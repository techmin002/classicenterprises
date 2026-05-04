<?php
namespace Modules\Inventory\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Inventory\Entities\PreSale;
use Modules\Inventory\Entities\PreSaleItem;
use Modules\Inventory\Entities\Sale;
use Modules\Inventory\Entities\SaleAccessory;
use Modules\Inventory\Entities\SaleMachinery;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Machineries;
use Illuminate\Support\Facades\Gate;

class PreSaleController extends Controller
{
    public function index()
{
    // abort_if(Gate::denies('access_presales'), 403);
    $preSales = PreSale::with('items')
        ->latest()
        ->get();

    $accessories = Accessories::active()->get();
    $machineries = Machineries::where('status', 'on')->get();

    return view('inventory::pre_sales.index', compact(
        'preSales',
        'accessories',
        'machineries'
    ));
}
// public function store(Request $request)
// {
//     DB::beginTransaction();

//     try {
//         $branchId = auth()->user()->role['name'] === 'Super Admin'
//             ? session('branch_id')
//             : auth()->user()->branch_id;

//         $bookingNumber = 'BOOK-' . strtoupper(Str::random(5)) . '-' . date('Ymd');

//        $advance = $request->paid_amount ?? 0;
// $total   = $request->total_amount ?? 0;

// $preSale = PreSale::create([
//     'booking_number' => $bookingNumber,
//     'customer_name'  => $request->customer_name,
//     'contact'        => $request->contact,
//     'email'          => $request->email,
//     'address'        => $request->address,
//     'total_amount'   => $total,
//     'advance_amount' => $advance,
//     'balance_due'    => $total - $advance,
//     'status'         => 'pending',
//     'branch_id'      => $branchId,
//     'created_by'     => auth()->id(),
// ]);
//         // Save items (NO inventory update)
//         foreach ($request->accessories ?? [] as $item) {
//             $product = Accessories::findOrFail($item['id']);

//             PreSaleItem::create([
//                 'pre_sale_id' => $preSale->id,
//                 'type'        => 'accessory',
//                 'product_id'  => $product->id,
//                 'name'        => $product->name,
//                 'quantity'    => $item['quantity'],
//                 'price'       => $item['price'],
//                 'total'       => $item['total'],
//             ]);
//         }

//         foreach ($request->machineries ?? [] as $item) {
//             $product = Machineries::findOrFail($item['id']);

//             PreSaleItem::create([
//                 'pre_sale_id' => $preSale->id,
//                 'type'        => 'machinery',
//                 'product_id'  => $product->id,
//                 'name'        => $product->name,
//                 'quantity'    => $item['quantity'],
//                 'price'       => $item['price'],
//                 'total'       => $item['total'],
//             ]);
//         }

//         DB::commit();

//         return back()->with('success', 'Pre-sale created successfully');

//     } catch (\Exception $e) {
//         DB::rollBack();
//         return back()->with('error', $e->getMessage());
//     }
// }
public function store(Request $request)
{
    DB::beginTransaction();

    try {
        $branchId = auth()->user()->role['name'] === 'Super Admin'
            ? session('branch_id')
            : auth()->user()->branch_id;

        $bookingNumber = 'BOOK-' . strtoupper(Str::random(5)) . '-' . date('Ymd');

        $totalAmount = 0;

        // First calculate total from items
        foreach ($request->accessories ?? [] as $item) {
            $qty   = $item['quantity'] ?? 0;
            $price = $item['price'] ?? 0;
            $totalAmount += ($qty * $price);
        }

        foreach ($request->machineries ?? [] as $item) {
            $qty   = $item['quantity'] ?? 0;
            $price = $item['price'] ?? 0;
            $totalAmount += ($qty * $price);
        }

        $advance = $request->paid_amount ?? 0;
        $balance = $totalAmount - $advance;

        // Create PreSale
        $preSale = PreSale::create([
            'booking_number' => $bookingNumber,
            'customer_name'  => $request->customer_name,
            'contact'        => $request->contact,
            'email'          => $request->email,
            'address'        => $request->address,
            'total_amount'   => $totalAmount,
            'advance_amount' => $advance,
            'balance_due'    => $balance,
            'status'         => 'pending',
            'branch_id'      => $branchId,
            'created_by'     => auth()->id(),
        ]);

        // Save Accessories
        foreach ($request->accessories ?? [] as $item) {

            if (empty($item['id'])) continue;

            $product = Accessories::findOrFail($item['id']);

            $qty   = $item['quantity'] ?? 1;
            $price = $item['price'] ?? $product->price;
            $total = $qty * $price;

            PreSaleItem::create([
                'pre_sale_id' => $preSale->id,
                'type'        => 'accessory',
                'product_id'  => $product->id,
                'name'        => $product->name,
                'quantity'    => $qty,
                'price'       => $price,
                'total'       => $total,
            ]);
        }

        // Save Machineries
        foreach ($request->machineries ?? [] as $item) {

            if (empty($item['id'])) continue;

            $product = Machineries::findOrFail($item['id']);

            $qty   = $item['quantity'] ?? 1;
            $price = $item['price'] ?? $product->price;
            $total = $qty * $price;

            PreSaleItem::create([
                'pre_sale_id' => $preSale->id,
                'type'        => 'machinery',
                'product_id'  => $product->id,
                'name'        => $product->name,
                'quantity'    => $qty,
                'price'       => $price,
                'total'       => $total,
            ]);
        }

        DB::commit();

        return back()->with('success', 'Pre-sale created successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}
public function confirm($id)
{
    abort_if(Gate::denies('edit_presales'), 403);

    DB::beginTransaction();

    try {
        $preSale = PreSale::with('items')->findOrFail($id);

        if ($preSale->status !== 'pending') {
            throw new \Exception("Already processed");
        }

        // Create Sale
      $sale = Sale::create([
    'invoice_number'    => 'INV-' . strtoupper(Str::random(6)) . '-' . date('Ymd'),
    'customer_name'     => $preSale->customer_name,
    'contact'           => $preSale->contact,
    'email'             => $preSale->email,
    'address'           => $preSale->address,
    'customer_type'     => 'customer', // default or store in pre_sale
    'total_amount'      => $preSale->total_amount,
    'paid_amount'       => $preSale->advance_amount,
    'balance_due'       => $preSale->balance_due,
    'payment_method'    => 'cash', // default
    'status'            => 'completed',
    'remarks'           => 'Converted from Pre-Sale',
    'created_by'        => auth()->id(),
    'branch_id'         => $preSale->branch_id,
]);

        foreach ($preSale->items as $item) {

            if ($item->type === 'accessory') {

                SaleAccessory::create([
                    'sale_id' => $sale->id,
                    'accessory_id' => $item->product_id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ]);

                $inventory = Inventory::where('accessory_id', $item->product_id)
                    ->where('branch_id', $preSale->branch_id)
                    ->lockForUpdate()
                    ->first();

            } else {

                SaleMachinery::create([
                    'sale_id' => $sale->id,
                    'machinery_id' => $item->product_id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ]);

                $inventory = Inventory::where('machinery_id', $item->product_id)
                    ->where('branch_id', $preSale->branch_id)
                    ->lockForUpdate()
                    ->first();
            }

            if (!$inventory || $inventory->quantity < $item->quantity) {
                throw new \Exception("Stock issue for {$item->name}");
            }

            $inventory->quantity -= $item->quantity;
            $inventory->save();
        }

        // Update PreSale status
        $preSale->update(['status' => 'confirmed']);

        DB::commit();

        return back()->with('success', 'Pre-sale converted to sale');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}
public function cancel($id)
{
    abort_if(Gate::denies('edit_presales'), 403);
    try {
        $preSale = PreSale::findOrFail($id);

        if ($preSale->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled');
        }

        $preSale->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Pre-sale cancelled successfully');

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}
}