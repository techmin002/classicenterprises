<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Branch;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\Machineries;
use Modules\Inventory\Entities\StockIssue;
use Modules\Inventory\Entities\StockIssueAccessory;
use Modules\Inventory\Entities\StockIssueMachinery;
use Modules\Inventory\Entities\StockIssueTechnicalTool;
use Modules\Inventory\Entities\StockTransfer;
use Modules\Inventory\Entities\StockTransferAccessories;
use Modules\Inventory\Entities\StockTransferMachineries;
use Modules\Inventory\Entities\StockTransferTechnicalTool;
use Modules\Product\Entities\Accessory;
use Modules\Product\Entities\Machinery;
use Modules\Product\Entities\TechnicalTools;

class StockIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machineries = Machinery::select('id', 'name')->get();
        $branches = Branch::all();
        $accessories = Accessory::select('id', 'name')->get();
        $technicalTools = TechnicalTools::select('id', 'tool_name as name')->get();

        // $stockIssues = StockIssue::with('user')->latest()->get();
        $stockIssues = StockIssue::with([
            'user.branch',
            'stockTransfers.accessories',
            'stockTransfers.machineries',
            'stockTransfers.technicaltools',
            'stockTransfers.fromBranch',
            'stockTransfers.toBranch',
            'stockTransfers.user',
        ])->latest()->get();

        return view('inventory::stockissue.index', compact(
            'machineries',
            'accessories',
            'technicalTools',
            'stockIssues',
            'branches'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        // 1. Create Stock Issue
        $issue = StockIssue::create([
            'message' => $request->message,
            'requested_by' => auth()->id(),
            'status' => 'pending',
        ]);

        // 2. Store Machineries
        if ($request->has('machineries')) {
            foreach ($request->machineries as $machinery) {
                if (! empty($machinery['id']) && ! empty($machinery['qty'])) {
                    StockIssueMachinery::create([
                        'stock_issue_id' => $issue->id,
                        'machinery_id' => $machinery['id'],
                        'quantity' => $machinery['qty'],
                    ]);
                }
            }
        }
        // 3. Store Accessories
        if ($request->accessories) {
            foreach ($request->accessories as $accessory) {
                if (! empty($accessory['id']) && ! empty($accessory['qty'])) {
                    StockIssueAccessory::create([
                        'stock_issue_id' => $issue->id,
                        'accessory_id' => $accessory['id'],
                        'quantity' => $accessory['qty'],
                    ]);
                }
            }
        }

        // 4. Store Technical Tools
        if ($request->has('technical_tools')) {
            foreach ($request->technical_tools as $tool) {
                if (! empty($tool['id']) && ! empty($tool['qty'])) {
                    StockIssueTechnicalTool::create([
                        'stock_issue_id' => $issue->id,
                        'technical_tool_id' => $tool['id'],
                        'quantity' => $tool['qty'],
                    ]);
                }
            }
        }

        return back()->with('success', 'Stock Issue Request Created Successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('inventory::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('inventory::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function reject(Request $request, $id)
    {
        $stockIssue = StockIssue::findOrFail($id);
        $stockIssue->status = 'rejected';
        if ($request->has('message')) {
            $stockIssue->message = $request->message;
        }
        $stockIssue->save();

        return redirect()->back()->with('success', 'Request Rejected.');
    }

    // public function accept(Request $request, $id)
    // {
    //     $stockIssue = StockIssue::findOrFail($id);
    //     $stockIssue->status = 'accepted';
    //     if ($request->has('message')) {
    //         $stockIssue->message = $request->message;
    //     }
    //     $stockIssue->save();

    //     return redirect()->back()->with('success', 'Request Accepted.');
    // }

    public function accept(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'from_branch_id' => 'required|exists:branches,id',
                'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
                'transfer_date' => 'required|date',
                'status' => 'required|in:pending,in_transit,completed,cancelled',
                'remarks' => 'nullable|string',

                // Accessories
                'accessories' => 'sometimes|array',
                'accessories.*.accessory_id' => 'required|exists:accessories,id',
                'accessories.*.quantity' => 'required|integer',

                // Machineries
                'machineries' => 'sometimes|array',
                'machineries.*.machinery_id' => 'required|exists:machineries,id',
                'machineries.*.quantity' => 'required|integer',

                // Technical Tools
                'technical_tools' => 'sometimes|array',
                'technical_tools.*.technical_tool_id' => 'required|exists:technical_tools,id',
                'technical_tools.*.quantity' => 'required|integer',
            ]);

            DB::beginTransaction();

            // 🔴 Stock availability validation
            $this->validateStockAvailability($validated);

            // Create stock transfer
            $stockTransfer = StockTransfer::create([
                'stock_issue_id' => $request->stock_issue_id,
                'from_branch_id' => $validated['from_branch_id'],
                'to_branch_id' => $validated['to_branch_id'],
                'transfer_date' => $validated['transfer_date'],
                'status' => $validated['status'],
                'remarks' => $validated['remarks'] ?? null,
                'created_by' => Auth::id(),
            ]);

            // ================= ACCESSORIES =================
            foreach ($validated['accessories'] ?? [] as $acc) {

                $this->createTransferAccessory($stockTransfer, $acc);

                // From branch (-)
                $this->updateInventory(
                    null,                           // machinery_id
                    $acc['accessory_id'],           // accessory_id
                    null,                           // technical_tool_id
                    $validated['from_branch_id'],
                    -$acc['quantity']
                );

                // To branch (+)
                $this->updateInventory(
                    null,
                    $acc['accessory_id'],
                    null,
                    $validated['to_branch_id'],
                    +$acc['quantity']
                );
            }

            // ================= MACHINERIES =================
            foreach ($validated['machineries'] ?? [] as $mach) {

                $this->createTransferMachinery($stockTransfer, $mach);

                // From branch (-)
                $this->updateInventory(
                    $mach['machinery_id'],
                    null,
                    null,
                    $validated['from_branch_id'],
                    -$mach['quantity']
                );

                // To branch (+)
                $this->updateInventory(
                    $mach['machinery_id'],
                    null,
                    null,
                    $validated['to_branch_id'],
                    +$mach['quantity']
                );
            }

            // ================= TECHNICAL TOOLS =================
            foreach ($validated['technical_tools'] ?? [] as $tool) {

                $this->createTransferTechnicalTool($stockTransfer, $tool);

                // From branch (-)
                $this->updateInventory(
                    null,
                    null,
                    $tool['technical_tool_id'],
                    $validated['from_branch_id'],
                    -$tool['quantity']
                );

                // To branch (+)
                $this->updateInventory(
                    null,
                    null,
                    $tool['technical_tool_id'],
                    $validated['to_branch_id'],
                    +$tool['quantity']
                );
            }

            // Update stock issue
            $stockIssue = StockIssue::findOrFail($id);
            $stockIssue->status = 'accepted';
            $stockIssue->message = $validated['remarks'] ?? null;
            $stockIssue->save();

            DB::commit();

            return back()->with('success', 'Stock transferred successfully');

        } catch (ValidationException $e) {
            DB::rollBack();

            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Stock not available for one or more items.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    protected function validateStockAvailability($validatedData)
    {
        $errors = [];

        // Check accessories stock
        if (! empty($validatedData['accessories'])) {
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
        if (! empty($validatedData['machineries'])) {
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

        // Check technical tools stock
        if (! empty($validatedData['technical_tools'])) {
            foreach ($validatedData['technical_tools'] as $index => $tool) {
                $availableQuantity = $this->getAvailableTechnicalToolQuantity(
                    $tool['technical_tool_id'],
                    $validatedData['from_branch_id']
                );

                if ($tool['quantity'] > $availableQuantity) {
                    $toolName = TechnicalTools::find($tool['technical_tool_id'])->name;
                    $errors["technical_tools.$index.quantity"] =
                        "Insufficient stock for $toolName. Available: $availableQuantity";
                }
            }
        }

        if (! empty($errors)) {
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

    protected function getAvailableTechnicalToolQuantity($toolId, $branchId)
    {
        return Inventory::where('technical_tool_id', $toolId)
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
        ]);
    }

    protected function createTransferMachinery(StockTransfer $stockTransfer, array $machineryData)
    {
        return StockTransferMachineries::create([
            'stock_transfer_id' => $stockTransfer->id,
            'machinery_id' => $machineryData['machinery_id'],
            'quantity' => $machineryData['quantity'],
            'serial_numbers' => $machineryData['serial_numbers'] ?? null,
        ]);
    }

    protected function createTransferTechnicalTool(StockTransfer $stockTransfer, array $toolData)
    {
        return StockTransferTechnicalTool::create([
            'stock_transfer_id' => $stockTransfer->id,
            'technical_tool_id' => $toolData['technical_tool_id'],
            'quantity' => $toolData['quantity'],
            'serial_numbers' => $toolData['serial_numbers'] ?? null,
        ]);
    }

    protected function updateInventory(
        ?int $machineryId,
        ?int $accessoryId,
        ?int $technicalToolId,
        int $branchId,
        int $quantityChange
    ) {
        $inventory = Inventory::firstOrNew([
            'machinery_id' => $machineryId,
            'accessory_id' => $accessoryId,
            'technical_tool_id' => $technicalToolId,
            'branch_id' => $branchId,
        ]);

        if (! $inventory->exists) {
            $inventory->opening_quantity = 0;
            $inventory->quantity = 0;
        }

        $inventory->quantity += $quantityChange;

        if ($inventory->quantity < 0) {
            throw new \Exception('Insufficient stock for transfer');
        }

        $inventory->updated_by = Auth::id();
        $inventory->save();
    }
}
