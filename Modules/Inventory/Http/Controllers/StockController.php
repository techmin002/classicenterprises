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

        try {
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
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error creating stock transfer: ' . $e->getMessage());
        }
    }

    /**
     * Validate stock availability before transfer
     */
    protected function validateStockAvailability(array $data)
    {
        $errors = [];

        // Validate accessories stock
        if (!empty($data['accessories'])) {
            foreach ($data['accessories'] as $index => $accessory) {
                $inventory = Inventory::where([
                    'accessory_id' => $accessory['accessory_id'],
                    'branch_id' => $data['from_branch_id']
                ])->first();

                if (!$inventory || $inventory->quantity < $accessory['quantity']) {
                    $errors["accessories.$index.quantity"] = 'Insufficient stock for selected accessory';
                }
            }
        }

        // Validate machineries stock
        if (!empty($data['machineries'])) {
            foreach ($data['machineries'] as $index => $machinery) {
                $inventory = Inventory::where([
                    'machinery_id' => $machinery['machinery_id'],
                    'branch_id' => $data['from_branch_id']
                ])->first();

                if (!$inventory || $inventory->quantity < $machinery['quantity']) {
                    $errors["machineries.$index.quantity"] = 'Insufficient stock for selected machinery';
                }
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    /**
     * Create stock transfer accessory record
     */
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

    /**
     * Create stock transfer machinery record
     */
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

    /**
     * Update inventory quantity
     */
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

    /**
     * Update transfer status
     */
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

    /**
     * Process inventory changes for status updates
     */
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

    // app/Http/Controllers/Inventory/StockTransferController.php

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
            'transfer_date' => 'required|date',
            'status' => 'required|in:pending,in_transit,completed,cancelled',
            'remarks' => 'nullable|string|max:500',
            'accessories' => 'sometimes|array',
            'accessories.*.accessory_id' => 'required_with:accessories|exists:accessories,id',
            'accessories.*.quantity' => 'required_with:accessories|integer|min:1',
            'accessories.*.condition' => 'required_with:accessories|in:new,used,refurbished,damaged',
            'accessories.*.serial_numbers' => 'nullable|string',
            'machineries' => 'sometimes|array',
            'machineries.*.machinery_id' => 'required_with:machineries|exists:machineries,id',
            'machineries.*.quantity' => 'required_with:machineries|integer|min:1',
            'machineries.*.condition' => 'required_with:machineries|in:new,used,refurbished,damaged',
            'machineries.*.serial_numbers' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            // Find the transfer
            $transfer = StockTransfer::findOrFail($id);

            // Only allow updates for pending or in_transit statuses
            if (!in_array($transfer->status, ['pending', 'in_transit'])) {
                throw new \Exception('Only pending or in-transit transfers can be modified');
            }

            // Update basic transfer info
            $transfer->update([
                'from_branch_id' => $validated['from_branch_id'],
                'to_branch_id' => $validated['to_branch_id'],
                'transfer_date' => $validated['transfer_date'],
                'status' => $validated['status'],
                'remarks' => $validated['remarks'],
                'updated_by' => auth()->id()
            ]);

            // Sync accessories
            if (isset($validated['accessories'])) {
                $accessoriesData = [];
                foreach ($validated['accessories'] as $accessory) {
                    $accessoriesData[$accessory['accessory_id']] = [
                        'quantity' => $accessory['quantity'],
                        'condition' => $accessory['condition'],
                        'serial_numbers' => $accessory['serial_numbers'] ?? null
                    ];
                }
                $transfer->accessories()->sync($accessoriesData);
            }

            // Sync machineries
            if (isset($validated['machineries'])) {
                $machineriesData = [];
                foreach ($validated['machineries'] as $machinery) {
                    $machineriesData[$machinery['machinery_id']] = [
                        'quantity' => $machinery['quantity'],
                        'condition' => $machinery['condition'],
                        'serial_numbers' => $machinery['serial_numbers'] ?? null
                    ];
                }
                $transfer->machineries()->sync($machineriesData);
            }

            DB::commit();

            return redirect()->route('stock-transfers.index')
                ->with('success', 'Stock transfer updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error updating transfer: ' . $e->getMessage());
        }
    }

    // app/Http/Controllers/Inventory/StockTransferController.php

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $transfer = StockTransfer::findOrFail($id);

            // Only allow deletion for pending transfers
            if ($transfer->status !== 'pending') {
                throw new \Exception('Only pending transfers can be deleted');
            }

            // Detach all relationships
            $transfer->accessories()->detach();
            $transfer->machineries()->detach();

            // Delete the transfer
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
