<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Modules\Inventory\Entities\Sale;
use Modules\Inventory\Entities\SaleReturn;
use Modules\Inventory\Entities\SaleReturnItem;
use Modules\Inventory\Entities\Inventory;


class SaleReturnController extends Controller
{

    public function index()
    {
        $returns = SaleReturn::with('sale')->latest()->get();
        $sales = Sale::latest()->get();

        return view('inventory::sale_returns.index', compact('returns', 'sales'));
    }


public function getSaleItems($id)
{
    $sale = Sale::with('accessories','machineries')->findOrFail($id);

    // Accessories
    foreach ($sale->accessories as $item) {

        $returned = SaleReturnItem::where('accessory_id', $item->accessory_id)
            ->whereHas('saleReturn', function($q) use ($id){
                $q->where('sale_id', $id);
            })
            ->sum('quantity');

        $item->returned_qty = $returned;
        $item->available_qty = $item->quantity - $returned;
    }

    // Machineries
    foreach ($sale->machineries as $item) {

        $returned = SaleReturnItem::where('machinery_id', $item->machinery_id)
            ->whereHas('saleReturn', function($q) use ($id){
                $q->where('sale_id', $id);
            })
            ->sum('quantity');

        $item->returned_qty = $returned;
        $item->available_qty = $item->quantity - $returned;
    }

    return view('inventory::sale_returns.items', compact('sale'));
}

    public function create($sale_id)
    {
        $sale = Sale::with('accessories', 'machineries')->findOrFail($sale_id);

        return view('inventory::sale_returns.create', compact('sale'));
    }

 

public function store(Request $request)
{
    DB::beginTransaction();

    try {

        $sale = Sale::with('accessories','machineries')->findOrFail($request->sale_id);

        $total_return_amount = 0;

        foreach ($request->items as $item) {

            if (empty($item['quantity']) || $item['quantity'] <= 0) {
                continue;
            }

            $soldQty = 0;
            $returnedQty = 0;

            /*
            |--------------------------------------
            | ACCESSORY RETURN CHECK
            |--------------------------------------
            */
            if (!empty($item['accessory_id'])) {

                $saleItem = $sale->accessories
                    ->where('accessory_id', $item['accessory_id'])
                    ->first();

                $soldQty = $saleItem->quantity ?? 0;

                $returnedQty = SaleReturnItem::where('accessory_id', $item['accessory_id'])
                    ->whereHas('saleReturn', function ($q) use ($sale) {
                        $q->where('sale_id', $sale->id);
                    })
                    ->sum('quantity');
            }

            /*
            |--------------------------------------
            | MACHINERY RETURN CHECK
            |--------------------------------------
            */
            if (!empty($item['machinery_id'])) {

                $saleItem = $sale->machineries
                    ->where('machinery_id', $item['machinery_id'])
                    ->first();

                $soldQty = $saleItem->quantity ?? 0;

                $returnedQty = SaleReturnItem::where('machinery_id', $item['machinery_id'])
                    ->whereHas('saleReturn', function ($q) use ($sale) {
                        $q->where('sale_id', $sale->id);
                    })
                    ->sum('quantity');
            }

            $availableQty = $soldQty - $returnedQty;

            // ❌ Stop if trying to return more than available
            if ($item['quantity'] > $availableQty) {
                throw new \Exception("Return quantity exceeds available quantity for ".$item['name']);
            }

            $total_return_amount += $item['quantity'] * $item['price'];
        }

        /*
        |--------------------------------------
        | CREATE SALE RETURN
        |--------------------------------------
        */

        $return = SaleReturn::create([
            'sale_id' => $request->sale_id,
            'return_invoice' => 'RET-' . Str::upper(Str::random(6)),
            'total_return_amount' => $total_return_amount,
            'remarks' => $request->remarks,
            'created_by' => auth()->id()
        ]);

        /*
        |--------------------------------------
        | SAVE RETURN ITEMS
        |--------------------------------------
        */

        foreach ($request->items as $item) {

            if (empty($item['quantity']) || $item['quantity'] <= 0) {
                continue;
            }

            $total = $item['quantity'] * $item['price'];

            SaleReturnItem::create([
                'sale_return_id' => $return->id,
                'accessory_id' => $item['accessory_id'] ?? null,
                'machinery_id' => $item['machinery_id'] ?? null,
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $total
            ]);

            /*
            |--------------------------------------
            | UPDATE INVENTORY
            |--------------------------------------
            */

            $inventory = Inventory::when(!empty($item['accessory_id']), function ($q) use ($item) {
                    $q->where('accessory_id', $item['accessory_id']);
                })
                ->when(!empty($item['machinery_id']), function ($q) use ($item) {
                    $q->where('machinery_id', $item['machinery_id']);
                })
                ->first();

            if ($inventory) {
                $inventory->quantity += $item['quantity'];
                $inventory->save();
            }
        }

        DB::commit();

        return redirect()->route('sale-returns.index')
            ->with('success', 'Sale Return Created Successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}

  public function show($id)
{
    $return = SaleReturn::with('sale', 'items', 'creator')->findOrFail($id);

    return view('inventory::sale_returns.show', compact('return'));
}

    public function edit($id)
    {
        $return = SaleReturn::with('items', 'sale')->findOrFail($id);

        return view('inventory::sale_returns.edit', compact('return'));
    }

    public function update(Request $request, $id)
{
    DB::beginTransaction();

    try {

        $return = SaleReturn::with('items')->findOrFail($id);

        /*
        |--------------------------------------
        | RESTORE INVENTORY FROM OLD RETURN
        |--------------------------------------
        */

        foreach ($return->items as $oldItem) {

            $inventory = Inventory::when($oldItem->accessory_id, function ($q) use ($oldItem) {
                    $q->where('accessory_id', $oldItem->accessory_id);
                })
                ->when($oldItem->machinery_id, function ($q) use ($oldItem) {
                    $q->where('machinery_id', $oldItem->machinery_id);
                })
                ->first();

            if ($inventory) {
                $inventory->quantity -= $oldItem->quantity;
                $inventory->save();
            }
        }

        /*
        |--------------------------------------
        | DELETE OLD RETURN ITEMS
        |--------------------------------------
        */

        $return->items()->delete();

        $total_return_amount = 0;

        /*
        |--------------------------------------
        | SAVE NEW ITEMS
        |--------------------------------------
        */

        foreach ($request->items as $item) {

            if (empty($item['quantity']) || $item['quantity'] <= 0) {
                continue;
            }

            $total = $item['quantity'] * $item['price'];

            SaleReturnItem::create([
                'sale_return_id' => $return->id,
                'accessory_id' => $item['accessory_id'] ?? null,
                'machinery_id' => $item['machinery_id'] ?? null,
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $total
            ]);

            $total_return_amount += $total;

            /*
            |--------------------------------------
            | UPDATE INVENTORY AGAIN
            |--------------------------------------
            */

            $inventory = Inventory::when(!empty($item['accessory_id']), function ($q) use ($item) {
                    $q->where('accessory_id', $item['accessory_id']);
                })
                ->when(!empty($item['machinery_id']), function ($q) use ($item) {
                    $q->where('machinery_id', $item['machinery_id']);
                })
                ->first();

            if ($inventory) {
                $inventory->quantity += $item['quantity'];
                $inventory->save();
            }
        }

        /*
        |--------------------------------------
        | UPDATE RETURN
        |--------------------------------------
        */

        $return->update([
            'remarks' => $request->remarks,
            'total_return_amount' => $total_return_amount
        ]);

        DB::commit();

        return redirect()->route('sale-returns.index')
            ->with('success', 'Return Updated Successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $return = SaleReturn::with('items')->findOrFail($id);

            foreach ($return->items as $item) {

                $inventory = Inventory::when($item->accessory_id, function ($q) use ($item) {
                    $q->where('accessory_id', $item->accessory_id);
                })
                    ->when($item->machinery_id, function ($q) use ($item) {
                        $q->where('machinery_id', $item->machinery_id);
                    })
                    ->first();

                if ($inventory) {
                    $inventory->quantity -= $item->quantity;
                    $inventory->save();
                }
            }

            $return->delete();

            DB::commit();

            return redirect()->route('sale-returns.index')
                ->with('success', 'Return Deleted');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
