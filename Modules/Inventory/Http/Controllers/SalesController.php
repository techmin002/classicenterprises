<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Inventory\Entities\Sale;
use Modules\Inventory\Entities\Customer;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Machineries;
use Modules\Inventory\Entities\SaleAccessory;
use Modules\Inventory\Entities\SaleMachinery;
use App\Models\Accessory;
use App\Models\Machinery;

class SalesController extends Controller
{
    public function index()
    {
        $accessories = Accessories::active()->get();
        $machineries = Machineries::where('status', 'on')->get();
        $customers = Customer::where('status', 'on')->get();
        
        $paymentMethods = [
            'cash' => 'Cash',
            'cheque' => 'Cheque',
            'card' => 'Credit/Debit Card',
            'bank_transfer' => 'Bank Transfer',
            'online' => 'Online Payment'
        ];

        $sales = Sale::all();
        return view('inventory::Sales.index', compact(
            'accessories',
            'machineries',
            'customers',
            'paymentMethods',
            'sales'
        ));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Generate invoice number
            $invoiceNumber = 'INV-' . strtoupper(Str::random(6)) . '-' . date('Ymd');

            // Create the sale record
            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'customer_name' => $request->customer_name,
                'contact' => $request->contact,
                'landline' => $request->landline,
                'email' => $request->email,
                'customer_type' => $request->customer_type,
                'address' => $request->address,
                'total_amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount,
                'balance_due' => $request->balance_due,
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'created_by' => auth()->id(),
            ]);

            // Store accessories
            if ($request->has('accessories')) {
                foreach ($request->accessories as $accessory) {
                    SaleAccessory::create([
                        'sale_id' => $sale->id,
                        'accessory_id' => $accessory['id'],
                        'name' => Accessories::find($accessory['id'])->name,
                        'quantity' => $accessory['quantity'],
                        'price' => $accessory['price'],
                        'total' => $accessory['total'],
                        'warranty' => $accessory['warranty'],
                    ]);
                }
            }

            // Store machineries
            if ($request->has('machineries')) {
                foreach ($request->machineries as $machinery) {
                    SaleMachinery::create([
                        'sale_id' => $sale->id,
                        'machinery_id' => $machinery['id'],
                        'name' => Machineries::find($machinery['id'])->name,
                        'quantity' => $machinery['quantity'],
                        'price' => $machinery['price'],
                        'total' => $machinery['total'],
                        'warranty' => $machinery['warranty'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Sale created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create sale: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $accessories = Accessories::active()->get();
        $machineries = Machineries::where('status', 'on')->get();
        $customers = Customer::where('status', 'on')->get();

        $saleAccessories = SaleAccessory::where('sale_id', $id)->get();
        $saleMachineries = SaleMachinery::where('sale_id', $id)->get();

        // Attach the collections to the $sale object for blade compatibility
        $sale->saleAccessories = $saleAccessories;
        $sale->saleMachineries = $saleMachineries;

        $paymentMethods = [
            'cash' => 'Cash',
            'cheque' => 'Cheque',
            'card' => 'Credit/Debit Card',
            'bank_transfer' => 'Bank Transfer',
            'online' => 'Online Payment'
        ];

        return view('inventory::Sales.edit', compact(
            'sale',
            'accessories',
            'machineries',
            'customers',
            'saleAccessories',
            'saleMachineries',
            'paymentMethods'
        ));
    }


     public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $sale = Sale::findOrFail($id);

            // Update the sale record
            $sale->update([
                'customer_name' => $request->customer_name,
                'contact' => $request->contact,
                'email' => $request->email,
                'customer_type' => $request->customer_type,
                'address' => $request->address,
                'total_amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount,
                'balance_due' => $request->balance_due,
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'status' => $request->status,
                'remarks' => $request->remarks,
                'updated_by' => auth()->id(),
            ]);

            // Handle existing accessories
            if ($request->has('accessories')) {
                $existingAccessoryIds = [];
                
                foreach ($request->accessories as $accessoryId => $accessoryData) {
                    $existingAccessoryIds[] = $accessoryId;
                    
                    SaleAccessory::where('id', $accessoryId)->update([
                        'accessory_id' => $accessoryData['id'],
                        'quantity' => $accessoryData['quantity'],
                        'price' => $accessoryData['price'],
                        'total' => $accessoryData['total'],
                        'warranty' => $accessoryData['warranty'],
                    ]);
                }
                
                // Delete accessories that were removed
                SaleAccessory::where('sale_id', $sale->id)
                    ->whereNotIn('id', $existingAccessoryIds)
                    ->delete();
            } else {
                // If no accessories were submitted, delete all
                SaleAccessory::where('sale_id', $sale->id)->delete();
            }

            // Handle new accessories
            if ($request->has('new_accessories')) {
                foreach ($request->new_accessories as $newAccessory) {
                    SaleAccessory::create([
                        'sale_id' => $sale->id,
                        'accessory_id' => $newAccessory['id'],
                        'name' => Accessories::find($newAccessory['id'])->name,
                        'quantity' => $newAccessory['quantity'],
                        'price' => $newAccessory['price'],
                        'total' => $newAccessory['total'],
                        'warranty' => $newAccessory['warranty'],
                    ]);
                }
            }

            // Handle existing machineries
            if ($request->has('machineries')) {
                $existingMachineryIds = [];
                
                foreach ($request->machineries as $machineryId => $machineryData) {
                    $existingMachineryIds[] = $machineryId;
                    
                    SaleMachinery::where('id', $machineryId)->update([
                        'machinery_id' => $machineryData['id'],
                        'quantity' => $machineryData['quantity'],
                        'price' => $machineryData['price'],
                        'total' => $machineryData['total'],
                        'warranty' => $machineryData['warranty'],
                    ]);
                }
                
                // Delete machineries that were removed
                SaleMachinery::where('sale_id', $sale->id)
                    ->whereNotIn('id', $existingMachineryIds)
                    ->delete();
            } else {
                // If no machineries were submitted, delete all
                SaleMachinery::where('sale_id', $sale->id)->delete();
            }

            // Handle new machineries
            if ($request->has('new_machineries')) {
                foreach ($request->new_machineries as $newMachinery) {
                    SaleMachinery::create([
                        'sale_id' => $sale->id,
                        'machinery_id' => $newMachinery['id'],
                        'name' => Machineries::find($newMachinery['id'])->name,
                        'quantity' => $newMachinery['quantity'],
                        'price' => $newMachinery['price'],
                        'total' => $newMachinery['total'],
                        'warranty' => $newMachinery['warranty'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Sale #' . $sale->invoice_number . ' updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update sale: ' . $e->getMessage());
        }
    }

    public function destroy($id)
{
    DB::beginTransaction();

    try {
        $sale = Sale::findOrFail($id);

        // Delete related records first
        SaleAccessory::where('sale_id', $sale->id)->delete();
        SaleMachinery::where('sale_id', $sale->id)->delete();

        // Delete the sale record
        $sale->delete();

        DB::commit();

        return redirect()->route('sales.index')
            ->with('success', 'Sale #' . $sale->invoice_number . ' has been deleted successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('sales.index')
            ->with('error', 'Failed to delete sale: ' . $e->getMessage());
    }
}

public function showDetails($id)
{
    $sale = Sale::with(['saleAccessories.accessory', 'saleMachineries.machinery'])
                ->findOrFail($id);

    return view('inventory::Sales.details', compact('sale'));
}

    
}