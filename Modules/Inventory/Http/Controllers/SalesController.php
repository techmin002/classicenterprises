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
use Modules\Inventory\Entities\Inventory;

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

            // Store accessories and update inventory
            if ($request->has('accessories')) {
                foreach ($request->accessories as $accessory) {
                    // Create sale accessory record
                    SaleAccessory::create([
                        'sale_id' => $sale->id,
                        'accessory_id' => $accessory['id'],
                        'name' => Accessories::find($accessory['id'])->name,
                        'quantity' => $accessory['quantity'],
                        'price' => $accessory['price'],
                        'total' => $accessory['total'],
                        'warranty' => $accessory['warranty'],
                    ]);

                    // Update inventory
                    $inventory = Inventory::where('accessory_id', $accessory['id'])
                        ->first();

                    if ($inventory) {
                        // Check if enough stock exists
                        if ($inventory->quantity < $accessory['quantity']) {
                            throw new \Exception("Not enough stock for accessory: " . Accessories::find($accessory['id'])->name);
                        }

                        // Decrease the quantity
                        $inventory->quantity -= $accessory['quantity'];
                        $inventory->save();
                    } else {
                        throw new \Exception("Inventory not found for accessory: " . Accessories::find($accessory['id'])->name);
                    }
                }
            }

            // Store machineries and update inventory
            if ($request->has('machineries')) {
                foreach ($request->machineries as $machinery) {
                    // Create sale machinery record
                    SaleMachinery::create([
                        'sale_id' => $sale->id,
                        'machinery_id' => $machinery['id'],
                        'name' => Machineries::find($machinery['id'])->name,
                        'quantity' => $machinery['quantity'],
                        'price' => $machinery['price'],
                        'total' => $machinery['total'],
                        'warranty' => $machinery['warranty'],
                    ]);

                    // Update inventory
                    $inventory = Inventory::where('machinery_id', $machinery['id'])
                        ->first();

                    if ($inventory) {
                        // Check if enough stock exists
                        if ($inventory->quantity < $machinery['quantity']) {
                            throw new \Exception("Not enough stock for machinery: " . Machineries::find($machinery['id'])->name);
                        }

                        // Decrease the quantity
                        $inventory->quantity -= $machinery['quantity'];
                        $inventory->save();
                    } else {
                        throw new \Exception("Inventory not found for machinery: " . Machineries::find($machinery['id'])->name);
                    }
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
                    
                    $saleAccessory = SaleAccessory::find($accessoryId);
                    $originalQuantity = $saleAccessory->quantity;
                    $newQuantity = $accessoryData['quantity'];
                    
                    // Update sale accessory record
                    $saleAccessory->update([
                        'accessory_id' => $accessoryData['id'],
                        'quantity' => $newQuantity,
                        'price' => $accessoryData['price'],
                        'total' => $accessoryData['total'],
                        'warranty' => $accessoryData['warranty'],
                    ]);

                    // Update inventory
                    $inventory = Inventory::where('accessory_id', $accessoryData['id'])
                        ->first();

                    if ($inventory) {
                        // Calculate difference and adjust inventory
                        $quantityDifference = $originalQuantity - $newQuantity;
                        $inventory->quantity += $quantityDifference;
                        
                        // Check if enough stock exists after adjustment
                        if ($inventory->quantity < 0) {
                            throw new \Exception("Not enough stock for accessory: " . $saleAccessory->name);
                        }
                        
                        $inventory->save();
                    }
                }
                
                // Delete accessories that were removed
                $removedAccessories = SaleAccessory::where('sale_id', $sale->id)
                    ->whereNotIn('id', $existingAccessoryIds)
                    ->get();

                foreach ($removedAccessories as $removed) {
                    // Return quantity to inventory
                    $inventory = Inventory::where('accessory_id', $removed->accessory_id)
                        ->first();

                    if ($inventory) {
                        $inventory->quantity += $removed->quantity;
                        $inventory->save();
                    }

                    // Delete the sale accessory record
                    $removed->delete();
                }
            } else {
                // If no accessories were submitted, delete all and return to inventory
                $removedAccessories = SaleAccessory::where('sale_id', $sale->id)->get();
                
                foreach ($removedAccessories as $removed) {
                    // Return quantity to inventory
                    $inventory = Inventory::where('accessory_id', $removed->accessory_id)
                        ->first();

                    if ($inventory) {
                        $inventory->quantity += $removed->quantity;
                        $inventory->save();
                    }
                }
                
                SaleAccessory::where('sale_id', $sale->id)->delete();
            }

            // Handle new accessories
            if ($request->has('new_accessories')) {
                foreach ($request->new_accessories as $newAccessory) {
                    // Create sale accessory record
                    SaleAccessory::create([
                        'sale_id' => $sale->id,
                        'accessory_id' => $newAccessory['id'],
                        'name' => Accessories::find($newAccessory['id'])->name,
                        'quantity' => $newAccessory['quantity'],
                        'price' => $newAccessory['price'],
                        'total' => $newAccessory['total'],
                        'warranty' => $newAccessory['warranty'],
                    ]);

                    // Update inventory
                    $inventory = Inventory::where('accessory_id', $newAccessory['id'])
                        ->first();

                    if ($inventory) {
                        // Check if enough stock exists
                        if ($inventory->quantity < $newAccessory['quantity']) {
                            throw new \Exception("Not enough stock for accessory: " . Accessories::find($newAccessory['id'])->name);
                        }

                        // Decrease the quantity
                        $inventory->quantity -= $newAccessory['quantity'];
                        $inventory->save();
                    } else {
                        throw new \Exception("Inventory not found for accessory: " . Accessories::find($newAccessory['id'])->name);
                    }
                }
            }

            // Handle existing machineries (similar to accessories)
            if ($request->has('machineries')) {
                $existingMachineryIds = [];
                
                foreach ($request->machineries as $machineryId => $machineryData) {
                    $existingMachineryIds[] = $machineryId;
                    
                    $saleMachinery = SaleMachinery::find($machineryId);
                    $originalQuantity = $saleMachinery->quantity;
                    $newQuantity = $machineryData['quantity'];
                    
                    // Update sale machinery record
                    $saleMachinery->update([
                        'machinery_id' => $machineryData['id'],
                        'quantity' => $newQuantity,
                        'price' => $machineryData['price'],
                        'total' => $machineryData['total'],
                        'warranty' => $machineryData['warranty'],
                    ]);

                    // Update inventory
                    $inventory = Inventory::where('machinery_id', $machineryData['id'])
                        ->first();

                    if ($inventory) {
                        // Calculate difference and adjust inventory
                        $quantityDifference = $originalQuantity - $newQuantity;
                        $inventory->quantity += $quantityDifference;
                        
                        // Check if enough stock exists after adjustment
                        if ($inventory->quantity < 0) {
                            throw new \Exception("Not enough stock for machinery: " . $saleMachinery->name);
                        }
                        
                        $inventory->save();
                    }
                }
                
                // Delete machineries that were removed
                $removedMachineries = SaleMachinery::where('sale_id', $sale->id)
                    ->whereNotIn('id', $existingMachineryIds)
                    ->get();

                foreach ($removedMachineries as $removed) {
                    // Return quantity to inventory
                    $inventory = Inventory::where('machinery_id', $removed->machinery_id)
                        ->first();

                    if ($inventory) {
                        $inventory->quantity += $removed->quantity;
                        $inventory->save();
                    }

                    // Delete the sale machinery record
                    $removed->delete();
                }
            } else {
                // If no machineries were submitted, delete all and return to inventory
                $removedMachineries = SaleMachinery::where('sale_id', $sale->id)->get();
                
                foreach ($removedMachineries as $removed) {
                    // Return quantity to inventory
                    $inventory = Inventory::where('machinery_id', $removed->machinery_id)
                        ->first();

                    if ($inventory) {
                        $inventory->quantity += $removed->quantity;
                        $inventory->save();
                    }
                }
                
                SaleMachinery::where('sale_id', $sale->id)->delete();
            }

            // Handle new machineries
            if ($request->has('new_machineries')) {
                foreach ($request->new_machineries as $newMachinery) {
                    // Create sale machinery record
                    SaleMachinery::create([
                        'sale_id' => $sale->id,
                        'machinery_id' => $newMachinery['id'],
                        'name' => Machineries::find($newMachinery['id'])->name,
                        'quantity' => $newMachinery['quantity'],
                        'price' => $newMachinery['price'],
                        'total' => $newMachinery['total'],
                        'warranty' => $newMachinery['warranty'],
                    ]);

                    // Update inventory
                    $inventory = Inventory::where('machinery_id', $newMachinery['id'])
                        ->first();

                    if ($inventory) {
                        // Check if enough stock exists
                        if ($inventory->quantity < $newMachinery['quantity']) {
                            throw new \Exception("Not enough stock for machinery: " . Machineries::find($newMachinery['id'])->name);
                        }

                        // Decrease the quantity
                        $inventory->quantity -= $newMachinery['quantity'];
                        $inventory->save();
                    } else {
                        throw new \Exception("Inventory not found for machinery: " . Machineries::find($newMachinery['id'])->name);
                    }
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

            // Get all accessories and machineries to return to inventory
            $saleAccessories = SaleAccessory::where('sale_id', $sale->id)->get();
            $saleMachineries = SaleMachinery::where('sale_id', $sale->id)->get();

            // Return accessory quantities to inventory
            foreach ($saleAccessories as $accessory) {
                $inventory = Inventory::where('accessory_id', $accessory->accessory_id)
                    ->first();

                if ($inventory) {
                    $inventory->quantity += $accessory->quantity;
                    $inventory->save();
                }
            }

            // Return machinery quantities to inventory
            foreach ($saleMachineries as $machinery) {
                $inventory = Inventory::where('machinery_id', $machinery->machinery_id)
                    ->first();

                if ($inventory) {
                    $inventory->quantity += $machinery->quantity;
                    $inventory->save();
                }
            }

            // Delete related records
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