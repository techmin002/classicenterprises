@php
    $profile = \Modules\Setting\Entities\CompanyProfile::first();
@endphp

<style>
    /* ===== SIDEBAR BASE ===== */
    .main-sidebar {
        background: #0f172a;
        color: #cbd5e1;
        transition: width 0.3s ease;
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.4);
        border-right: 1px solid rgba(255, 255, 255, 0.04);
    }

    /* ===== BRAND ===== */
    .brand-link {
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding: 14px 20px !important;
        background: #1e293b !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        text-decoration: none !important;
        transition: background 0.2s ease;
    }

    .brand-link:hover {
        background: #273448 !important;
        text-decoration: none !important;
    }

    .brand-text {
        font-size: 1rem !important;
        font-weight: 600 !important;
        letter-spacing: 0.3px;
        color: #f1f5f9 !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

   /* ===== USER PANEL ===== */
.user-panel {
    padding: 14px 16px !important;
    margin: 0 !important;
    background: #1e293b !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
}

.user-panel .image {
    width: 190px;              /* increase size */
    height: 80px;             /* optional */
    border-radius: 0 !important;   /* remove rounded shape */
    overflow: hidden;
    border: none;             /* remove border if you want clean logo */
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-panel img {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;   /* ✅ IMPORTANT: show full image */
}
    /* ===== SEARCH ===== */
    .form-inline {
        padding: 12px 14px;
        background: #0f172a;
    }

    .input-group[data-widget="sidebar-search"] {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: #1e293b;
    }

    .form-control-sidebar {
        background: transparent !important;
        border: none !important;
        color: #cbd5e1 !important;
        font-size: 13px !important;
        padding: 8px 12px !important;
        height: 36px !important;
    }

    .form-control-sidebar::placeholder {
        color: #64748b !important;
    }

    .form-control-sidebar:focus {
        outline: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    .btn-sidebar {
        background: transparent !important;
        border: none !important;
        color: #64748b !important;
        padding: 0 12px !important;
        height: 36px !important;
        transition: color 0.2s;
    }

    .btn-sidebar:hover {
        color: #94a3b8 !important;
    }

    /* ===== SCROLLBAR ===== */
    .sidebar {
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(100, 116, 139, 0.3) transparent;
    }

    .sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(100, 116, 139, 0.3);
        border-radius: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    /* ===== NAV SECTION HEADER ===== */
    .nav-header {
        font-size: 10px !important;
        font-weight: 700 !important;
        letter-spacing: 1.2px !important;
        text-transform: uppercase !important;
        color: #475569 !important;
        padding: 16px 18px 6px !important;
        margin: 0 !important;
        border-top: none !important;
    }

    .nav-header.border-top {
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        margin-top: 4px !important;
        padding-top: 14px !important;
    }

    /* ===== DIVIDER ===== */
    .border-top.border-success {
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        margin: 6px 0 !important;
    }

    /* ===== NAV ITEMS ===== */
    .nav-sidebar {
        padding: 4px 0 20px !important;
    }

    .nav-sidebar > .nav-item {
        margin: 1px 8px !important;
    }

    .nav-sidebar .nav-item > .nav-link {
        color: #94a3b8 !important;
        border-radius: 8px !important;
        padding: 9px 12px !important;
        font-size: 13.5px !important;
        font-weight: 400 !important;
        display: flex !important;
        align-items: center !important;
        gap: 0 !important;
        transition: background 0.15s ease, color 0.15s ease !important;
        white-space: nowrap;
        overflow: hidden;
    }

    .nav-sidebar .nav-item > .nav-link:hover {
        background: rgba(255, 255, 255, 0.06) !important;
        color: #e2e8f0 !important;
        text-decoration: none !important;
    }

    /* Active parent nav link */
    .nav-sidebar .nav-item > .nav-link.active {
        background: rgba(59, 130, 246, 0.15) !important;
        color: #93c5fd !important;
    }

    /* ===== NAV ICON ===== */
    .nav-icon {
        width: 30px !important;
        min-width: 30px !important;
        font-size: 14px !important;
        text-align: center !important;
        color: #64748b !important;
        transition: color 0.15s !important;
    }

    .nav-link:hover .nav-icon,
    .nav-link.active .nav-icon {
        color: #60a5fa !important;
    }

    /* Arrow icon */
    .nav-link .right {
        margin-left: auto !important;
        font-size: 11px !important;
        color: #475569 !important;
        transition: transform 0.2s ease, color 0.15s !important;
    }

    .nav-link.active .right,
    .menu-open > .nav-link .right {
        transform: rotate(-90deg);
        color: #64748b !important;
    }

    /* ===== TREEVIEW SUBMENU ===== */
    .nav-treeview {
        margin: 2px 0 2px 14px !important;
        padding: 0 !important;
        border-left: 1px solid rgba(255, 255, 255, 0.07) !important;
    }

    .nav-treeview > .nav-item {
        margin: 1px 6px !important;
    }

    .nav-treeview .nav-link {
        color: #64748b !important;
        font-size: 13px !important;
        padding: 7px 10px 7px 14px !important;
        border-radius: 6px !important;
        transition: background 0.15s ease, color 0.15s ease !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nav-treeview .nav-link:hover {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #cbd5e1 !important;
        text-decoration: none !important;
    }

    .nav-treeview .nav-link.active {
        background: rgba(59, 130, 246, 0.12) !important;
        color: #93c5fd !important;
    }

    .nav-treeview .nav-link p {
        margin: 0 !important;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== p TAG IN NAV ===== */
    .nav-sidebar .nav-link p {
        margin: 0 !important;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== DASHBOARD ITEM SPECIAL ===== */
    .nav-sidebar > .nav-item:first-child > .nav-link.active {
        background: rgba(59, 130, 246, 0.15) !important;
        color: #93c5fd !important;
    }
</style>

<aside class="main-sidebar elevation-4">

    {{-- Brand Logo --}}
    <a href="{{ route('home') }}" class="brand-link" style="text-decoration: none;">
        @php($branch = Session::get('branch'))
        <span class="brand-text">{{ $branch->name ?? $profile->company_name }}</span>
    </a>

    <div class="sidebar">

        {{-- User / Logo Panel --}}
        <div class="user-panel d-flex">
            <div class="image">
                <img src="{{ asset('upload/images/settings/' . $profile->logo) }}" alt="Logo">
            </div>
        </div>

        {{-- Search --}}
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search…" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Sidebar Menu --}}
        <nav class="mt-2 mb-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item {{ request()->routeIs('home') ? 'menu-open' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Users Management --}}
                @can('access_user_management')
                    <li class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users Management <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                    <p>Create Users</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Leads --}}
                @can('access_leads')
                    <li class="nav-item {{ request()->routeIs('hot-leads') || request()->routeIs('warm-leads') || request()->routeIs('cold-leads') || request()->routeIs('followups') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('hot-leads') || request()->routeIs('warm-leads') || request()->routeIs('cold-leads') || request()->routeIs('followups') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-fire"></i>
                            <p>Leads <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('hot-leads') }}" class="nav-link {{ request()->routeIs('hot-leads') ? 'active' : '' }}">
                                    <p>Hot Leads</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('warm-leads') }}" class="nav-link {{ request()->routeIs('warm-leads') ? 'active' : '' }}">
                                    <p>Warm Leads</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('cold-leads') }}" class="nav-link {{ request()->routeIs('cold-leads') ? 'active' : '' }}">
                                    <p>Cold Leads</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('followups') }}" class="nav-link {{ request()->routeIs('followups') ? 'active' : '' }}">
                                    <p>Followups</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Sales Category --}}
                @can('access_salescategory')
                    <li class="nav-item {{ request()->routeIs('salecategories.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('salecategories.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Sales Category <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('salecategories.retailler') }}" class="nav-link {{ request()->routeIs('salecategories.retailler') ? 'active' : '' }}">
                                    <p>Retailler</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('salecategories.wholeseller') }}" class="nav-link {{ request()->routeIs('salecategories.wholeseller') ? 'active' : '' }}">
                                    <p>Wholeseller</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Installation Dashboard --}}
                @can('access_sliders')
                    @can('access_installments')
                        <li class="nav-header border-top"><strong>Installation</strong></li>

                        {{-- Retail --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs(['installation-category-queue.*','installation-category-assign.*','installation-category.reports','installation-category.complete']) && request()->route('installation_category') === 'retailler') active @endif">
                                <i class="nav-icon fas fa-store"></i>
                                <p>Retail <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-queue.index', 'retailler') }}" class="nav-link @if (request()->routeIs('installation-category-queue.index') && request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-assign.index', 'retailler') }}" class="nav-link @if (request()->routeIs('installation-category-assign.index') && request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.complete', 'retailler') }}" class="nav-link @if (request()->routeIs('installation-category.complete') && request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.reports', 'retailler') }}" class="nav-link @if (request()->routeIs('installation-category.reports') && request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Commercial --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs(['installation-category-queue.*','installation-category-assign.*','installation-category.reports','installation-category.complete']) && request()->route('installation_category') === 'commercial') active @endif">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Commercial <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-queue.index', 'commercial') }}" class="nav-link @if (request()->routeIs('installation-category-queue.index') && request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-assign.index', 'commercial') }}" class="nav-link @if (request()->routeIs('installation-category-assign.index') && request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.complete', 'commercial') }}" class="nav-link @if (request()->routeIs('installation-category.complete') && request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.reports', 'commercial') }}" class="nav-link @if (request()->routeIs('installation-category.reports') && request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Industrial --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs(['installation-category-queue.*','installation-category-assign.*','installation-category.reports','installation-category.complete']) && request()->route('installation_category') === 'industrial') active @endif">
                                <i class="nav-icon fas fa-industry"></i>
                                <p>Industrial <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-queue.index', 'industrial') }}" class="nav-link @if (request()->routeIs('installation-category-queue.index') && request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-assign.index', 'industrial') }}" class="nav-link @if (request()->routeIs('installation-category-assign.index') && request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.complete', 'industrial') }}" class="nav-link @if (request()->routeIs('installation-category.complete') && request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.reports', 'industrial') }}" class="nav-link @if (request()->routeIs('installation-category.reports') && request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                @endcan

                {{-- Support Dashboard --}}
                @can('access_tickets')
                    <li class="nav-header border-top"><strong>Support</strong></li>
                    <li class="nav-item {{ request()->routeIs('ticket.index') ? 'menu-open' : '' }}">
                        <a href="{{ route('ticket.index') }}" class="nav-link {{ request()->routeIs('ticket.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>Ticketing</p>
                        </a>
                    </li>
                @endcan

                @can('access_customers')
                    {{-- Register Customer --}}
                    <li class="nav-item {{ request()->routeIs(['supportdashboard.*', 'registercustomer-ticket.*']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['supportdashboard.*', 'registercustomer-ticket.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-check"></i>
                            <p>Register Customer <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('registercustomer-ticket.dashboard') }}" class="nav-link {{ request()->routeIs('registercustomer-ticket.dashboard') ? 'active' : '' }}">
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('registercustomer-ticket.regular') }}" class="nav-link {{ request()->routeIs('registercustomer-ticket.regular') ? 'active' : '' }}">
                                    <p>Warrenty In Service</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('registercustomer-ticket.warrenty') }}" class="nav-link {{ request()->routeIs('registercustomer-ticket.warrenty') ? 'active' : '' }}">
                                    <p>Warrenty Out Service</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('registercustomer-ticket.queue') }}" class="nav-link {{ request()->routeIs('registercustomer-ticket.queue') ? 'active' : '' }}">
                                    <p>Queue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('registercustomer-ticket.assign') }}" class="nav-link {{ request()->routeIs('registercustomer-ticket.assign') ? 'active' : '' }}">
                                    <p>Assign</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('registercustomer-ticket.complete') }}" class="nav-link {{ request()->routeIs('registercustomer-ticket.complete') ? 'active' : '' }}">
                                    <p>Complete</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('registercustomer-ticket.report') }}" class="nav-link {{ request()->routeIs('registercustomer-ticket.report') ? 'active' : '' }}">
                                    <p>Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- AMC Customer --}}
                    <li class="nav-item {{ request()->routeIs(['supportdashboard.*', 'amccustomer-ticket.*', 'amcassign.*', 'amc.*']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['supportdashboard.*', 'amccustomer-ticket.*', 'amcassign.*', 'amc.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-contract"></i>
                            <p>AMC Customer <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('amccustomer-ticket.dashboard') }}" class="nav-link {{ request()->routeIs('amccustomer-ticket.dashboard') ? 'active' : '' }}">
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amc.index') }}" class="nav-link {{ request()->routeIs('amc.index') ? 'active' : '' }}">
                                    <p>Amc Policy</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amcassign.index') }}" class="nav-link {{ request()->routeIs('amcassign.index') ? 'active' : '' }}">
                                    <p>Customer Add</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amccustomer-ticket.inservice') }}" class="nav-link {{ request()->routeIs('amccustomer-ticket.inservice') ? 'active' : '' }}">
                                    <p>AMC In Service</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amccustomer-ticket.outservice') }}" class="nav-link {{ request()->routeIs('amccustomer-ticket.outservice') ? 'active' : '' }}">
                                    <p>AMC Out Service</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amccustomer-ticket.queue') }}" class="nav-link {{ request()->routeIs('amccustomer-ticket.queue') ? 'active' : '' }}">
                                    <p>Queue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amccustomer-ticket.assign') }}" class="nav-link {{ request()->routeIs('amccustomer-ticket.assign') ? 'active' : '' }}">
                                    <p>Assign</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amccustomer-ticket.complete') }}" class="nav-link {{ request()->routeIs('amccustomer-ticket.complete') ? 'active' : '' }}">
                                    <p>Complete</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('amccustomer-ticket.report') }}" class="nav-link {{ request()->routeIs('amccustomer-ticket.report') ? 'active' : '' }}">
                                    <p>Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Outsider Customer --}}
                    <li class="nav-item {{ request()->routeIs(['supportdashboard.*', 'outsidercustomer-ticket.*']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['supportdashboard.*', 'outsidercustomer-ticket.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-alt"></i>
                            <p>Outsider Customer <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('outsidercustomer-ticket.dashboard') }}" class="nav-link {{ request()->routeIs('outsidercustomer-ticket.dashboard') ? 'active' : '' }}">
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('outsidercustomer-ticket.regular-service') }}" class="nav-link {{ request()->routeIs('outsidercustomer-ticket.regular-service') ? 'active' : '' }}">
                                    <p>Regular Service</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('outsidercustomer-ticket.queue') }}" class="nav-link {{ request()->routeIs('outsidercustomer-ticket.queue') ? 'active' : '' }}">
                                    <p>Queue</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('outsidercustomer-ticket.assign') }}" class="nav-link {{ request()->routeIs('outsidercustomer-ticket.assign') ? 'active' : '' }}">
                                    <p>Assign</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('outsidercustomer-ticket.complete') }}" class="nav-link {{ request()->routeIs('outsidercustomer-ticket.complete') ? 'active' : '' }}">
                                    <p>Complete</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('outsidercustomer-ticket.report') }}" class="nav-link {{ request()->routeIs('outsidercustomer-ticket.report') ? 'active' : '' }}">
                                    <p>Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- IMS --}}
                @can('access_ime')
                    <li class="nav-header border-top"><strong>IMS</strong></li>
                    <li class="nav-item {{ request()->routeIs('inventries', 'inventory.*', 'suppliers.*', 'suppliers_edit', 'device-purchases.*', 'device_purchase_machineries_accessories', 'device_purchase_edit', 'sales.*', 'stock-transfers.*', 'stock-issue.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('inventries', 'inventory.*', 'suppliers.*', 'suppliers_edit', 'device-purchases.*', 'device_purchase_machineries_accessories', 'device_purchase_edit', 'sales.*', 'stock-transfers.*', 'stock-issue.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>IMS <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('access_suppliers')
                                <li class="nav-item">
                                    <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.index', 'suppliers_edit') ? 'active' : '' }}">
                                        <p>Suppliers</p>
                                    </a>
                                </li>
                            @endcan
                            @can('access_purchases')
                                <li class="nav-item">
                                    <a href="{{ route('device-purchases.index') }}" class="nav-link {{ request()->routeIs('device-purchases.index', 'device_purchase_edit', 'device_purchase_machineries_accessories') ? 'active' : '' }}">
                                        <p>Stock Purchases</p>
                                    </a>
                                </li>
                            @endcan
                            @can('access_inventory')
                                <li class="nav-item">
                                    <a href="{{ route('inventries') }}" class="nav-link {{ request()->routeIs('inventries', 'inventory.*') ? 'active' : '' }}">
                                        <p>Inventries</p>
                                    </a>
                                </li>
                            @endcan
                            @can('access_stocktransfers')
                                <li class="nav-item">
                                    <a href="{{ route('stock-transfers.index') }}" class="nav-link {{ request()->routeIs('stock-transfers.index') ? 'active' : '' }}">
                                        <p>Stock Transfer</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                {{-- Sales Management --}}
                @can('access_allsales')
                    <li class="nav-header border-top"><strong>Sales Management</strong></li>
                    <li class="nav-item {{ request()->routeIs('sales.*', 'sale-returns.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('sales.*', 'sale-returns.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>Sales <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('access_presales')
                                <li class="nav-item">
                                    <a href="{{ route('pre-sales.index') }}" class="nav-link {{ request()->routeIs('pre-sales.index') ? 'active' : '' }}">
                                        <p>Pre Sales</p>
                                    </a>
                                </li>
                            @endcan
                            @can('access_sales')
                                <li class="nav-item">
                                    <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                                        <p>Sales List</p>
                                    </a>
                                </li>
                            @endcan
                            @can('access_salesreturn')
                                <li class="nav-item">
                                    <a href="{{ route('sale-returns.index') }}" class="nav-link {{ request()->routeIs('sale-returns.index') ? 'active' : '' }}">
                                        <p>Sales Returns</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <div class="border-top border-success mt-2"></div>

                {{-- Branch --}}
                @if (auth()->user()->access_type === 'Admin')
                @else
                    @can('access_branch')
                        <li class="nav-item {{ request()->routeIs('branches.*') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-store"></i>
                                <p>Branch <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('branches.index') }}" class="nav-link {{ request()->routeIs('branches.index') ? 'active' : '' }}">
                                        <p>Branch</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                @endif

                {{-- Attendance --}}
                @can('access_attendance')
                    <li class="nav-item @if (request()->routeIs('attendance.*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (request()->routeIs('attendance.*')) active @endif">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Attendance <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (auth()->user()->role['name'] === 'Super Admin')
                                <li class="nav-item">
                                    <a href="{{ route('attendance.all') }}" class="nav-link @if (request()->routeIs('attendance.all')) active @endif">
                                        <p>Attendance</p>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('attendance.index') }}" class="nav-link @if (request()->routeIs('attendance.index')) active @endif">
                                        <p>My Attendance</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('attendance.checkin') }}" class="nav-link @if (request()->routeIs('attendance.checkin')) active @endif">
                                    <p>Check-In Request</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('attendance.checkout') }}" class="nav-link @if (request()->routeIs('attendance.checkout')) active @endif">
                                    <p>Check-Out Request</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Payroll --}}
                @can('access_payroll')
                    <li class="nav-item @if (request()->routeIs('setsalary.*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (request()->routeIs('setsalary.*')) active @endif">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Payroll <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('setsalary.index') }}" class="nav-link @if (request()->routeIs('setsalary.index')) active @endif">
                                    <p>Set Salary</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('setsalary.payslip.index') }}" class="nav-link @if (request()->routeIs('setsalary.payslip.index')) active @endif">
                                    <p>Payslip</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Sliders --}}
                @can('access_sliders')
                    <li class="nav-item {{ request()->routeIs('sliders.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('sliders.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>Sliders <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('sliders.index') }}" class="nav-link {{ request()->routeIs('sliders.index') ? 'active' : '' }}">
                                    <p>Sliders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sliders.create') }}" class="nav-link {{ request()->routeIs('sliders.create') ? 'active' : '' }}">
                                    <p>Create Sliders</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Product Management --}}
                @can('access_product')
                    <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                            <i class="nav-icon fas fa-box-open"></i>
                            <p>Product Mgnt <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('products-categories.index') }}" class="nav-link @if (request()->routeIs('products-categories.index')) active @endif">
                                    <p>Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products-brands.index') }}" class="nav-link @if (request()->routeIs('products-brands.index')) active @endif">
                                    <p>Brands</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products-machineries.index') }}" class="nav-link @if (request()->routeIs('products-machineries.index')) active @endif">
                                    <p>Machineries</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products-accessories.index') }}" class="nav-link @if (request()->routeIs('products-accessories.index')) active @endif">
                                    <p>Accessories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('technicaltools.index') }}" class="nav-link {{ request()->routeIs('technicaltools.index') ? 'active' : '' }}">
                                    <p>Technical Tools</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Services --}}
                @can('access_sliders')
                    <li class="nav-item @if (request()->routeIs('services.*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (request()->routeIs('services.*')) active @endif">
                            <i class="nav-icon fas fa-concierge-bell"></i>
                            <p>Services <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('services_category.index') }}" class="nav-link @if (request()->routeIs('services_category.index')) active @endif">
                                    <p>Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('services.index') }}" class="nav-link @if (request()->routeIs('services.index')) active @endif">
                                    <p>Services</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Blogs --}}
                @can('access_blogs')
                    <li class="nav-item {{ request()->routeIs('blogs.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-blog"></i>
                            <p>Blogs <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('blogs.index') }}" class="nav-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                                    <p>Blog</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('blogs.create') }}" class="nav-link {{ request()->routeIs('blogs.create') ? 'active' : '' }}">
                                    <p>Create Blogs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Petty Cash --}}
                @can('access_pettycash')
                    <li class="nav-item {{ request()->routeIs(['pettycash-addcash.*','pettycash-request.*','pettycash-transfer.*','pettycash-transaction.*','expenses-categories.*','petty.expenses.*']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['pettycash-addcash.*','pettycash-request.*','pettycash-transfer.*','pettycash-transaction.*','expenses-categories.*','petty.expenses.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-coins"></i>
                            <p>Petty Cash <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('expenses-categories.index') }}" class="nav-link {{ request()->routeIs('expenses-categories.index') ? 'active' : '' }}">
                                    <p>Add Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-addcash.index') }}" class="nav-link {{ request()->routeIs('pettycash-addcash.index') ? 'active' : '' }}">
                                    <p>Add Cash</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-request.index') }}" class="nav-link {{ request()->routeIs('pettycash-request.index') ? 'active' : '' }}">
                                    <p>Cash Request</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-transfer.index') }}" class="nav-link {{ request()->routeIs('pettycash-transfer.index') ? 'active' : '' }}">
                                    <p>Cash Verification</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('petty.expenses.index') }}" class="nav-link {{ request()->routeIs('petty.expenses.index') ? 'active' : '' }}">
                                    <p>Petty Cash Expenses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-transaction.index') }}" class="nav-link {{ request()->routeIs('pettycash-transaction.index') ? 'active' : '' }}">
                                    <p>Petty Cash Transaction</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Vehicle Management --}}
                @can('access_vehicle')
                    <li class="nav-item {{ request()->routeIs(['bike.*', 'petrol.*', 'service.*']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['bike.*', 'petrol.*', 'service.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-motorcycle"></i>
                            <p>Vehicle Mgnt <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('bike.index') }}" class="nav-link {{ request()->routeIs('bike.index') ? 'active' : '' }}">
                                    <p>Bike</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('petrol.index') }}" class="nav-link {{ request()->routeIs('petrol.index') ? 'active' : '' }}">
                                    <p>Petrol</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('service.index') }}" class="nav-link {{ request()->routeIs('service.index') ? 'active' : '' }}">
                                    <p>Service</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Finance --}}
                @can('access_finance')
                    <li class="nav-item {{ request()->routeIs(['firstbill.*', 'payment-verification.*', 'finance.*', 'daily.*']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['firstbill.*', 'payment-verification.*', 'finance.*', 'daily.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Finance <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('firstbill.index') }}" class="nav-link {{ request()->routeIs('firstbill.index') ? 'active' : '' }}">
                                    <p>First Bill</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('payment-verification.index') }}" class="nav-link {{ request()->routeIs('payment-verification.index') ? 'active' : '' }}">
                                    <p>Field Payment Verification</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('finance.index') }}" class="nav-link {{ request()->routeIs('finance.index') ? 'active' : '' }}">
                                    <p>Payment Entry</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('daily.index') }}" class="nav-link {{ request()->routeIs('daily.index') ? 'active' : '' }}">
                                    <p>Daily Collection</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <div class="border-top border-success"></div>

                {{-- Advertisements --}}
                @can('access_advertisements')
                    <li class="nav-item {{ request()->routeIs('advertisements.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('advertisements.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-ad"></i>
                            <p>Advertisements <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('advertisements.index') }}" class="nav-link {{ request()->routeIs('advertisements.index') ? 'active' : '' }}">
                                    <p>Advertisements</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('advertisements.create') }}" class="nav-link {{ request()->routeIs('advertisements.create') ? 'active' : '' }}">
                                    <p>Create Advertisements</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Teams --}}
                @can('access_teams')
                    <li class="nav-item {{ request()->routeIs('teams.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('teams.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-people-carry"></i>
                            <p>Teams <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('teams.index') }}" class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                                    <p>Teams</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('teams.create') }}" class="nav-link {{ request()->routeIs('teams.create') ? 'active' : '' }}">
                                    <p>Create Teams</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- FAQs --}}
                @can('access_faqs')
                    <li class="nav-item {{ request()->routeIs('faqs.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>FAQs <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('faqs.index') }}" class="nav-link {{ request()->routeIs('faqs.index') ? 'active' : '' }}">
                                    <p>FAQs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('faqs.create') }}" class="nav-link {{ request()->routeIs('faqs.create') ? 'active' : '' }}">
                                    <p>Create FAQs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Testimonials --}}
                @can('access_testimonials')
                    <li class="nav-item {{ request()->routeIs('testimonials.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('testimonials.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comment-dots"></i>
                            <p>Testimonial <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('testimonials.index') }}" class="nav-link {{ request()->routeIs('testimonials.index') ? 'active' : '' }}">
                                    <p>Testimonials</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('testimonials.create') }}" class="nav-link {{ request()->routeIs('testimonials.create') ? 'active' : '' }}">
                                    <p>Create Testimonials</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Vacancies --}}
                @can('access_vacancies')
                    <li class="nav-item {{ request()->routeIs('vacancies.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('vacancies.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Vacancies <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('vacancies.index') }}" class="nav-link {{ request()->routeIs('vacancies.index') ? 'active' : '' }}">
                                    <p>Vacancies</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vacancies.create') }}" class="nav-link {{ request()->routeIs('vacancies.create') ? 'active' : '' }}">
                                    <p>Create Vacancy</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Gallery --}}
                @can('access_gallery')
                    <li class="nav-item">
                        <a href="{{ route('galleries.index') }}" class="nav-link {{ request()->routeIs('galleries.index') ? 'active' : '' }}">
                            <i class="nav-icon far fa-images"></i>
                            <p>Gallery</p>
                        </a>
                    </li>
                @endcan

                {{-- Leaves --}}
                @can('access_leave')
                    <li class="nav-item {{ request()->routeIs('leave.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('leave.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-minus"></i>
                            <p>Leaves <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('leave-types.index') }}" class="nav-link {{ request()->routeIs('leave-types.index') ? 'active' : '' }}">
                                    <p>Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('leaves.index') }}" class="nav-link {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
                                    <p>Leaves</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('holidays.index') }}" class="nav-link {{ request()->routeIs('holidays.index') ? 'active' : '' }}">
                                    <p>Holidays</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Inquiries --}}
                @can('access_inquiries')
                    <li class="nav-item">
                        <a href="{{ route('inquires.index') }}" class="nav-link {{ request()->routeIs('inquires.index') ? 'active' : '' }}">
                            <i class="nav-icon far fa-address-book"></i>
                            <p>Inquiries</p>
                        </a>
                    </li>
                @endcan

                {{-- Settings --}}
                @can('access_settings')
                    <li class="nav-item {{ request()->routeIs('company.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('company.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Setting <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('company.index') }}" class="nav-link {{ request()->routeIs('company.index') ? 'active' : '' }}">
                                    <p>Company Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('whyus.index') }}" class="nav-link {{ request()->routeIs('whyus.index') ? 'active' : '' }}">
                                    <p>Why Choose Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logs.index') }}" class="nav-link {{ request()->routeIs('logs.index') ? 'active' : '' }}">
                                    <p>Logs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

            </ul>
        </nav>
    </div>
</aside>