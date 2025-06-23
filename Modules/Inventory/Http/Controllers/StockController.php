<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\StockTransfer;
use Modules\Inventory\Entities\Branch;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Machineries;
use Modules\Inventory\Entities\StockTransferAccessories;
use Modules\Inventory\Entities\StockTransferMachineries;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\User;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    public function index()
    {
        $accessories = Accessories::all();
        $machineries = Machineries::all();
        $branches = Branch::all();
        $user = User::all();
        $stockTransfers = StockTransfer::with(['accessories', 'machineries', 'fromBranch', 'toBranch'])->get();
        $stockaccessories = StockTransferAccessories::with('accessory')->get();
        $stockmachineries = StockTransferMachineries::with('machinery')->get();
        return view('inventory::stocktransfer.index', compact(
            'stockTransfers',
            'accessories',
            'machineries',
            'branches',
            'stockaccessories',
            'stockmachineries',
            'user'
        ));
    }

    public function store(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'from_branch_id' => 'required|exists:branches,id',
                'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
                'transfer_date' => 'required|date',
                'status' => 'required|in:pending,in_transit,completed,cancelled',
                'remarks' => 'nullable|string',
                'accessories' => 'sometimes|array',
                'accessories.*.accessory_id' => 'required_with:accessories|exists:accessories,id',
                'accessories.*.quantity' => 'required_with:accessories|integer|min:1',
                'accessories.*.serial_numbers' => 'nullable|string',
                'accessories.*.condition' => 'required_with:accessories|in:new,used,refurbished,damaged',
                'machineries' => 'sometimes|array',
                'machineries.*.machinery_id' => 'required_with:machineries|exists:machineries,id',
                'machineries.*.quantity' => 'required_with:machineries|integer|min:1',
                'machineries.*.serial_numbers' => 'nullable|string',
                'machineries.*.condition' => 'required_with:machineries|in:new,used,refurbished,damaged',
            ]);

            // Validate stock availability
            $this->validateStockAvailability($validated);

            DB::beginTransaction();

            // Create the stock transfer
            $stockTransfer = StockTransfer::create([
                'from_branch_id' => $validated['from_branch_id'],
                'to_branch_id' => $validated['to_branch_id'],
                'transfer_date' => $validated['transfer_date'],
                'status' => $validated['status'],
                'remarks' => $validated['remarks'] ?? null,
                'created_by' => Auth::id(),
            ]);

            // Process accessories
            if (!empty($validated['accessories'])) {
                foreach ($validated['accessories'] as $accessory) {
                    $this->createTransferAccessory($stockTransfer, $accessory);
                    $this->updateInventory(
                        null,
                        $accessory['accessory_id'],
                        $validated['from_branch_id'],
                        -$accessory['quantity']
                    );
                }
            }

            // Process machineries
            if (!empty($validated['machineries'])) {
                foreach ($validated['machineries'] as $machinery) {
                    $this->createTransferMachinery($stockTransfer, $machinery);
                    $this->updateInventory(
                        $machinery['machinery_id'],
                        null,
                        $validated['from_branch_id'],
                        -$machinery['quantity']
                    );
                }
            }

            DB::commit();

            return redirect()->route('stock-transfers.index')
                ->with('success', 'Stock transfer created successfully!');
        } catch (ValidationException $e) {
            return redirect()->route('stock-transfers.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('stock-transfers.index')
                ->with('error', 'Error creating stock transfer: ' . $e->getMessage())
                ->withInput();
        }
    }

    protected function validateStockAvailability($validatedData)
    {
        $errors = [];

        // Check accessories stock
        if (!empty($validatedData['accessories'])) {
            foreach ($validatedData['accessories'] as $index => $accessory) {
                $availableQuantity = $this->getAvailableAccessoryQuantity(
                    $accessory['accessory_id'],
                    $validatedData['from_branch_id']
                );

                if ($accessory['quantity'] > $availableQuantity) {
                    $accessoryName = Accessories::find($accessory['accessory_id'])->name;
                    $errors["accessories.$index.quantity"] = "Insufficient stock for $accessoryName. Available: $availableQuantity";
                }
            }
        }

        // Check machinery stock
        if (!empty($validatedData['machineries'])) {
            foreach ($validatedData['machineries'] as $index => $machinery) {
                $availableQuantity = $this->getAvailableMachineryQuantity(
                    $machinery['machinery_id'],
                    $validatedData['from_branch_id']
                );

                if ($machinery['quantity'] > $availableQuantity) {
                    $machineryName = Machineries::find($machinery['machinery_id'])->name;
                    $errors["machineries.$index.quantity"] = "Insufficient stock for $machineryName. Available: $availableQuantity";
                }
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    protected function getAvailableAccessoryQuantity($accessoryId, $branchId)
    {
        return Inventory::where('accessory_id', $accessoryId)
            ->where('branch_id', $branchId)
            ->value('quantity') ?? 0;
    }

    protected function getAvailableMachineryQuantity($machineryId, $branchId)
    {
        return Inventory::where('machinery_id', $machineryId)
            ->where('branch_id', $branchId)
            ->value('quantity') ?? 0;
    }

    protected function createTransferAccessory(StockTransfer $stockTransfer, array $accessoryData)
    {
        return StockTransferAccessories::create([
            'stock_transfer_id' => $stockTransfer->id,
            'accessory_id' => $accessoryData['accessory_id'],
            'quantity' => $accessoryData['quantity'],
            'serial_numbers' => $accessoryData['serial_numbers'] ?? null,
            'condition' => $accessoryData['condition'],
        ]);
    }

    protected function createTransferMachinery(StockTransfer $stockTransfer, array $machineryData)
    {
        return StockTransferMachineries::create([
            'stock_transfer_id' => $stockTransfer->id,
            'machinery_id' => $machineryData['machinery_id'],
            'quantity' => $machineryData['quantity'],
            'serial_numbers' => $machineryData['serial_numbers'] ?? null,
            'condition' => $machineryData['condition'],
        ]);
    }

    protected function updateInventory(?int $machineryId, ?int $accessoryId, int $branchId, int $quantityChange)
    {
        $inventory = Inventory::firstOrNew([
            'machinery_id' => $machineryId,
            'accessory_id' => $accessoryId,
            'branch_id' => $branchId,
        ]);

        if (!$inventory->exists) {
            $inventory->opening_quantity = 0;
            $inventory->quantity = 0;
        }

        $inventory->quantity += $quantityChange;

        if ($inventory->quantity < 0) {
            throw new \Exception("Insufficient stock for transfer");
        }

        $inventory->updated_by = Auth::id();
        $inventory->save();
    }

    public function updateStatus(Request $request, StockTransfer $stockTransfer)
    {
        $request->validate([
            'status' => 'required|in:pending,in_transit,completed,cancelled'
        ]);

        DB::beginTransaction();

        try {
            $oldStatus = $stockTransfer->status;
            $newStatus = $request->status;

            $stockTransfer->update([
                'status' => $newStatus,
                'updated_by' => Auth::id()
            ]);

            // Handle inventory changes based on status
            if ($oldStatus !== $newStatus) {
                if ($newStatus === 'completed') {
                    // Add to destination branch
                    $this->processStatusChange($stockTransfer, $stockTransfer->to_branch_id, 1);
                } elseif ($newStatus === 'cancelled' && $oldStatus !== 'completed') {
                    // Return to source branch
                    $this->processStatusChange($stockTransfer, $stockTransfer->from_branch_id, 1);
                } elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {
                    // Reverse from destination branch
                    $this->processStatusChange($stockTransfer, $stockTransfer->to_branch_id, -1);
                }
            }

            DB::commit();

            return back()->with('success', 'Status updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }

    protected function processStatusChange(StockTransfer $stockTransfer, int $branchId, int $multiplier)
    {
        // Process accessories
        foreach ($stockTransfer->accessories as $accessory) {
            $this->updateInventory(
                null,
                $accessory->accessory_id,
                $branchId,
                $accessory->quantity * $multiplier
            );
        }

        // Process machineries
        foreach ($stockTransfer->machineries as $machinery) {
            $this->updateInventory(
                $machinery->machinery_id,
                null,
                $branchId,
                $machinery->quantity * $multiplier
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
            'transfer_date' => 'required|date',
            'status' => 'required|in:pending,in_transit,completed,cancelled',
            'remarks' => 'nullable|string|max:500',
            'accessories' => 'sometimes|array',
            'accessories.*.id' => 'required_with:accessories|exists:accessories,id',
            'accessories.*.quantity' => 'required_with:accessories|integer|min:1',
            'accessories.*.condition' => 'required_with:accessories|in:new,used,refurbished,damaged',
            'accessories.*.serial_numbers' => 'nullable|string',
            'new_accessories' => 'sometimes|array',
            'new_accessories.*.id' => 'required_with:new_accessories|exists:accessories,id',
            'new_accessories.*.quantity' => 'required_with:new_accessories|integer|min:1',
            'new_accessories.*.condition' => 'required_with:new_accessories|in:new,used,refurbished,damaged',
            'new_accessories.*.serial_numbers' => 'nullable|string',
            'machineries' => 'sometimes|array',
            'machineries.*.id' => 'required_with:machineries|exists:machineries,id',
            'machineries.*.quantity' => 'required_with:machineries|integer|min:1',
            'machineries.*.condition' => 'required_with:machineries|in:new,used,refurbished,damaged',
            'machineries.*.serial_numbers' => 'nullable|string',
            'new_machineries' => 'sometimes|array',
            'new_machineries.*.id' => 'required_with:new_machineries|exists:machineries,id',
            'new_machineries.*.quantity' => 'required_with:new_machineries|integer|min:1',
            'new_machineries.*.condition' => 'required_with:new_machineries|in:new,used,refurbished,damaged',
            'new_machineries.*.serial_numbers' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $transfer = StockTransfer::with(['accessories', 'machineries'])->findOrFail($id);

            if (!in_array($transfer->status, ['pending', 'in_transit'])) {
                throw new \Exception('Only pending or in-transit transfers can be modified');
            }

            $this->validateStockUpdate($transfer, $validated);

            $originalAccessories = $transfer->accessories->keyBy('id');
            $originalMachineries = $transfer->machineries->keyBy('id');

            $transfer->update([
                'from_branch_id' => $validated['from_branch_id'],
                'to_branch_id' => $validated['to_branch_id'],
                'transfer_date' => $validated['transfer_date'],
                'status' => $validated['status'],
                'remarks' => $validated['remarks'],
                'updated_by' => auth()->id()
            ]);

            if (isset($validated['accessories'])) {
                $accessoriesData = [];
                foreach ($validated['accessories'] as $accessory) {
                    $accessoryId = $accessory['id'];
                    $quantityChange = $accessory['quantity'] - ($originalAccessories[$accessoryId]->pivot->quantity ?? 0);

                    $accessoriesData[$accessoryId] = [
                        'quantity' => $accessory['quantity'],
                        'condition' => $accessory['condition'],
                        'serial_numbers' => $accessory['serial_numbers'] ?? null
                    ];

                    if ($quantityChange != 0) {
                        $this->updateInventory(
                            null,
                            $accessoryId,
                            $transfer->from_branch_id,
                            -$quantityChange
                        );
                    }
                }
                $transfer->accessories()->sync($accessoriesData);
            }

            if (isset($validated['new_accessories'])) {
                foreach ($validated['new_accessories'] as $accessory) {
                    $this->createTransferAccessory($transfer, [
                        'accessory_id' => $accessory['id'],
                        'quantity' => $accessory['quantity'],
                        'condition' => $accessory['condition'],
                        'serial_numbers' => $accessory['serial_numbers'] ?? null
                    ]);

                    $this->updateInventory(
                        null,
                        $accessory['id'],
                        $transfer->from_branch_id,
                        -$accessory['quantity']
                    );
                }
            }

            if (isset($validated['machineries'])) {
                $machineriesData = [];
                foreach ($validated['machineries'] as $machinery) {
                    $machineryId = $machinery['id'];
                    $quantityChange = $machinery['quantity'] - ($originalMachineries[$machineryId]->pivot->quantity ?? 0);

                    $machineriesData[$machineryId] = [
                        'quantity' => $machinery['quantity'],
                        'condition' => $machinery['condition'],
                        'serial_numbers' => $machinery['serial_numbers'] ?? null
                    ];

                    if ($quantityChange != 0) {
                        $this->updateInventory(
                            $machineryId,
                            null,
                            $transfer->from_branch_id,
                            -$quantityChange
                        );
                    }
                }
                $transfer->machineries()->sync($machineriesData);
            }

            if (isset($validated['new_machineries'])) {
                foreach ($validated['new_machineries'] as $machinery) {
                    $this->createTransferMachinery($transfer, [
                        'machinery_id' => $machinery['id'],
                        'quantity' => $machinery['quantity'],
                        'condition' => $machinery['condition'],
                        'serial_numbers' => $machinery['serial_numbers'] ?? null
                    ]);

                    $this->updateInventory(
                        $machinery['id'],
                        null,
                        $transfer->from_branch_id,
                        -$machinery['quantity']
                    );
                }
            }

            $this->processRemovedItems($transfer, $validated, $originalAccessories, $originalMachineries);

            DB::commit();

            return redirect()->route('stock-transfers.index')
                ->with('success', 'Stock transfer updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error updating transfer: ' . $e->getMessage());
        }
    }

    protected function validateStockUpdate(StockTransfer $transfer, array $data)
    {
        $errors = [];
        $fromBranchId = $data['from_branch_id'];

        if (isset($data['accessories'])) {
            foreach ($data['accessories'] as $index => $accessory) {
                $originalQuantity = $transfer->accessories->where('id', $accessory['id'])->first()->pivot->quantity ?? 0;
                $quantityChange = $accessory['quantity'] - $originalQuantity;

                if ($quantityChange > 0) {
                    $inventory = Inventory::where([
                        'accessory_id' => $accessory['id'],
                        'branch_id' => $fromBranchId
                    ])->first();

                    if (!$inventory || $inventory->quantity < $quantityChange) {
                        $errors["accessories.$index.quantity"] = 'Insufficient stock for selected accessory';
                    }
                }
            }
        }

        if (isset($data['new_accessories'])) {
            foreach ($data['new_accessories'] as $index => $accessory) {
                $inventory = Inventory::where([
                    'accessory_id' => $accessory['id'],
                    'branch_id' => $fromBranchId
                ])->first();

                if (!$inventory || $inventory->quantity < $accessory['quantity']) {
                    $errors["new_accessories.$index.quantity"] = 'Insufficient stock for selected accessory';
                }
            }
        }

        if (isset($data['machineries'])) {
            foreach ($data['machineries'] as $index => $machinery) {
                $originalQuantity = $transfer->machineries->where('id', $machinery['id'])->first()->pivot->quantity ?? 0;
                $quantityChange = $machinery['quantity'] - $originalQuantity;

                if ($quantityChange > 0) {
                    $inventory = Inventory::where([
                        'machinery_id' => $machinery['id'],
                        'branch_id' => $fromBranchId
                    ])->first();

                    if (!$inventory || $inventory->quantity < $quantityChange) {
                        $errors["machineries.$index.quantity"] = 'Insufficient stock for selected machinery';
                    }
                }
            }
        }

        if (isset($data['new_machineries'])) {
            foreach ($data['new_machineries'] as $index => $machinery) {
                $inventory = Inventory::where([
                    'machinery_id' => $machinery['id'],
                    'branch_id' => $fromBranchId
                ])->first();

                if (!$inventory || $inventory->quantity < $machinery['quantity']) {
                    $errors["new_machineries.$index.quantity"] = 'Insufficient stock for selected machinery';
                }
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    protected function processRemovedItems(StockTransfer $transfer, array $data, $originalAccessories, $originalMachineries)
    {
        $currentAccessoryIds = collect($data['accessories'] ?? [])->pluck('id')->merge(
            collect($data['new_accessories'] ?? [])->pluck('id')
        )->toArray();

        foreach ($originalAccessories as $accessory) {
            if (!in_array($accessory->id, $currentAccessoryIds)) {
                $this->updateInventory(
                    null,
                    $accessory->id,
                    $transfer->from_branch_id,
                    $accessory->pivot->quantity
                );
            }
        }

        $currentMachineryIds = collect($data['machineries'] ?? [])->pluck('id')->merge(
            collect($data['new_machineries'] ?? [])->pluck('id')
        )->toArray();

        foreach ($originalMachineries as $machinery) {
            if (!in_array($machinery->id, $currentMachineryIds)) {
                $this->updateInventory(
                    $machinery->id,
                    null,
                    $transfer->from_branch_id,
                    $machinery->pivot->quantity
                );
            }
        }
    }

    public function edit($id)
    {
        $branches = Branch::all();
        $accessories = Accessories::all();
        $machineries = Machineries::all();
        $transfer = StockTransfer::find($id);
        return view('inventory::StockTransfer.edit', compact('transfer', 'branches', 'accessories', 'machineries'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $transfer = StockTransfer::findOrFail($id);

            if ($transfer->status !== 'pending') {
                throw new \Exception('Only pending transfers can be deleted');
            }

            $transfer->accessories()->detach();
            $transfer->machineries()->detach();
            $transfer->delete();

            DB::commit();

            return redirect()->route('stock-transfers.index')
                ->with('success', 'Stock transfer deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error deleting transfer: ' . $e->getMessage());
        }
    }
}