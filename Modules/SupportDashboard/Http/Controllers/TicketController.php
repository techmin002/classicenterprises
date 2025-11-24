<?php

namespace Modules\SupportDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\AMC\Entities\AMC;
use Modules\AMC\Entities\AmcCustomer;
use Modules\AMC\Entities\OutsiderCustomerAMC;
use Modules\AMC\Entities\RegisterCustomerAMC;
use Modules\Lead\Entities\Customer;
use Modules\SupportDashboard\Entities\CustomerTicket;
use Modules\SupportDashboard\Entities\RegisterCustomerTicket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role['name'] === 'Super Admin') {
            $branch_id = session('branch_id');
        } else {
            $branch_id = auth()->user()->branch_id;
        }
        $register = Customer::with(['lead', 'registerAmc'])
            ->where('branch_id', $branch_id)
            ->whereIn('ticket_status', ['on', 'report', 'complete'])
            ->orderBy('created_at', 'desc')
            ->get();


        $outsider = CustomerTicket::with('amc')
            ->where('branch_id', $branch_id)
            ->where('outsider_type', 'yes')
            ->where(function ($query) {
                $query->whereIn('status', ['complete', 'report', 'create'])
                    ->orWhereNull('status');
            })
            ->latest()->orderBy('created_at', 'desc')
            ->get();

        $amccustomer = AmcCustomer::with(['customer', 'amc'])
            ->where('branch_id', $branch_id)
            ->whereIn('status', ['on',])
            ->latest()->orderBy('created_at', 'desc')
            ->get();

        return view('supportdashboard::ticket.index', compact('register', 'outsider', 'amccustomer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supportdashboard::create');
    }


    public function edit($id)
    {
        return view('supportdashboard::edit');
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

    public function customerDetails($id)
    {
        // dd($id);
        $customer = CustomerTicket::with([
            'customer',
            'payments',
            'accessories.accessory'
        ])->where('id', $id)->firstOrFail();
        $customer->created_time = $this->formatTimeDifference($customer->created_at);

        return view('supportdashboard::ticket.details', compact('customer'));
    }


    private function formatTimeDifference($dateTime)
    {
        if (!$dateTime) {
            return 'N/A';
        }

        $time = \Carbon\Carbon::parse($dateTime);
        $now = \Carbon\Carbon::now();

        $diffInSeconds = $now->diffInSeconds($time);

        $years = floor($diffInSeconds / (365 * 24 * 60 * 60));
        $months = floor(($diffInSeconds % (365 * 24 * 60 * 60)) / (30 * 24 * 60 * 60));
        $days = floor(($diffInSeconds % (30 * 24 * 60 * 60)) / (24 * 60 * 60));
        $hours = floor(($diffInSeconds % (24 * 60 * 60)) / 3600);
        $minutes = floor(($diffInSeconds % 3600) / 60);

        $parts = [];

        if ($years > 0) {
            $parts[] = $years . ' year' . ($years > 1 ? 's' : '');
            if ($months > 0) $parts[] = $months . ' month' . ($months > 1 ? 's' : '');
            if ($days > 0) $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
        } elseif ($months > 0) {
            $parts[] = $months . ' month' . ($months > 1 ? 's' : '');
            if ($days > 0) $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
            if ($hours > 0) $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
        } elseif ($days > 0) {
            $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
            if ($hours > 0) $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
            if ($minutes > 0) $parts[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        } else {
            if ($hours > 0) $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
            if ($minutes > 0) $parts[] = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        }

        return $parts ? implode(' ', $parts) . ' ago' : 'Just now';
    }
}
