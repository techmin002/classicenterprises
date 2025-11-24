@php
    $profile = \Modules\Setting\Entities\CompanyProfile::first();
@endphp
<style>
    /* Elegant Sidebar Styling */
    .main-sidebar {
        background: linear-gradient(180deg, #0d1b2a 0%, #1b263b 100%);
        color: #e0e0e0;
        transition: all 0.3s ease;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.3);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    .brand-link {
        background: linear-gradient(90deg, #007bff, #5f27cd);
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    .brand-link:hover {
        background: linear-gradient(90deg, #5f27cd, #007bff);
        text-decoration: none;
        color: #fff;
    }

    /* Sidebar user image */
    .user-panel img {
        border-radius: 10px;
        border: 2px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    }

    /* Sidebar Search */
    .form-control-sidebar {
        background-color: #14213d;
        border: none;
        color: #443d3d;
        border-radius: 8px;
    }

    .btn-sidebar {
        background: #5f27cd;
        color: rgb(47, 39, 39);
    }

    /* Menu items */
    .nav-sidebar .nav-item>.nav-link {
        color: #cfd8dc;
        border-radius: 8px;
        margin: 3px 10px;
        transition: all 0.3s ease;
    }

    .nav-sidebar .nav-item>.nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        transform: translateX(3px);
    }

    /* Active link */
    .nav-sidebar .nav-item>.nav-link.active {
        background: linear-gradient(90deg, #007bff, #5f27cd);
        color: #fff !important;
        box-shadow: 0 3px 10px rgba(0, 123, 255, 0.3);
    }

    /* Treeview submenu */
    .nav-treeview {
        margin-left: 10px;
        border-left: 1px solid rgba(255, 255, 255, 0.1);
    }

    .nav-treeview .nav-link {
        font-size: 0.9rem;
        color: #b0bec5;
        margin-left: 8px;
    }

    .nav-treeview .nav-link.active {
        background: rgba(95, 39, 205, 0.2);
        color: #fff;
    }

    /* Scrollbar */
    .main-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .main-sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }
</style>
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link text-center text-white" style="background-color: #007bff"
        style="text-decoration: none;">
        {{-- <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        {{-- <i class="fa fa-paw"></i> --}}
        @php($branch = Session::get('branch'))
        <span class="brand-text font-weight-bold ">{{ $branch->name ?? $profile->company_name }} </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex bg-dark">
            <div class="image">

                <img src="{{ asset('upload/images/settings/' . $profile->logo) }}" class="w-100 img-fluid"
                    alt="User Image">
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 mb-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item {{ request()->routeIs('home') ? 'menu-open' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @can('access_user_management')
                    <li
                        class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}"
                                    class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                    class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}"
                                    class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                    <p>Create Users</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- @can('access_user_management') --}}
                <li
                    class="nav-item {{ request()->routeIs('hot-leads') || request()->routeIs('warm-leads') || request()->routeIs('cold-leads') || request()->routeIs('followups') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('hot-leads') || request()->routeIs('warm-leads') || request()->routeIs('cold-leads') || request()->routeIs('followups') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Leads
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('hot-leads') }}"
                                class="nav-link {{ request()->routeIs('hot-leads') ? 'active' : '' }}">
                                <p>Hot Leads</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('warm-leads') }}"
                                class="nav-link {{ request()->routeIs('warm-leads') ? 'active' : '' }}">
                                <p>Warm Leads</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('cold-leads') }}"
                                class="nav-link {{ request()->routeIs('cold-leads') ? 'active' : '' }}">
                                <p>Cold Leads</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('followups') }}"
                                class="nav-link {{ request()->routeIs('followups') ? 'active' : '' }}">
                                <p>Followups</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- @endcan --}}

                <li class="nav-item {{ request()->routeIs('salecategories.*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('salecategories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Sales Category
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('salecategories.retailler') }}"
                                class="nav-link {{ request()->routeIs('salecategories.retailler') ? 'active' : '' }}">
                                <p>Retailler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('salecategories.wholeseller') }}"
                                class="nav-link {{ request()->routeIs('salecategories.wholeseller') ? 'active' : '' }}">
                                <p>Wholeseller</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <div class="my-3 border-top border-success pt-1">

                    @can('access_sliders')
                        {{-- ===================== Sales Dashboard ===================== --}}
                        <li class="nav-header text-primary"><b>Sales Dashboard</b></li>

                        {{-- Counter Sales --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs([
                                    'installation-queue.*',
                                    'installation.complete',
                                    'installation-assign.*',
                                    'installation.reports',
                                ]) && request()->route('sale_type') === 'counter_sales') active @endif">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Counter Sales
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-queue.index', 'counter_sales') }}"
                                        class="nav-link @if (request()->routeIs('installation-queue.index') && request()->route('sale_type') === 'counter_sales') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-assign.index', 'counter_sales') }}"
                                        class="nav-link @if (request()->routeIs('installation-assign.index') && request()->route('sale_type') === 'counter_sales') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('installation.complete', 'counter_sales') }}"
                                        class="nav-link @if (request()->routeIs('installation.complete') && request()->route('sale_type') === 'counter_sales') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation.reports', 'counter_sales') }}"
                                        class="nav-link @if (request()->routeIs('installation.reports') && request()->route('sale_type') === 'counter_sales') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Retailler --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs([
                                    'installation-queue.*',
                                    'installation.complete',
                                    'installation-assign.*',
                                    'installation.reports',
                                ]) && request()->route('sale_type') === 'retailler') active @endif">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Retailler
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-queue.index', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation-queue.index') && request()->route('sale_type') === 'retailler') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-assign.index', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation-assign.index') && request()->route('sale_type') === 'retailler') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation.complete', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation.complete') && request()->route('sale_type') === 'retailler') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation.reports', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation.reports') && request()->route('sale_type') === 'retailler') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        {{-- Wholeseller --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs([
                                    'installation-queue.*',
                                    'installation.complete',
                                    'installation-assign.*',
                                    'installation.reports',
                                ]) && request()->route('sale_type') === 'wholeseller') active @endif">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Wholeseller
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-queue.index', 'wholeseller') }}"
                                        class="nav-link @if (request()->routeIs('installation-queue.index') && request()->route('sale_type') === 'wholeseller') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-assign.index', 'wholeseller') }}"
                                        class="nav-link @if (request()->routeIs('installation-assign.index') && request()->route('sale_type') === 'wholeseller') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation.complete', 'wholeseller') }}"
                                        class="nav-link @if (request()->routeIs('installation.complete') && request()->route('sale_type') === 'wholeseller') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation.reports', 'wholeseller') }}"
                                        class="nav-link @if (request()->routeIs('installation.reports') && request()->route('sale_type') === 'wholeseller') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- ===================== Installation Dashboard ===================== --}}
                        <li class="nav-header text-primary"><b>Installation Dashboard</b></li>

                        {{-- Retail --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs([
                                    'installation-category-queue.*',
                                    'installation-category-assign.*',
                                    'installation-category.reports',
                                    'installation-category.complete',
                                ]) && request()->route('installation_category') === 'retailler') active @endif">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Retail
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-queue.index', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation-category-queue.index') &&
                                                request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-assign.index', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation-category-assign.index') &&
                                                request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.complete', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation-category.complete') && request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.reports', 'retailler') }}"
                                        class="nav-link @if (request()->routeIs('installation-category.reports') && request()->route('installation_category') === 'retailler') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Commercial --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs([
                                    'installation-category-queue.*',
                                    'installation-category-assign.*',
                                    'installation-category.reports',
                                    'installation-category.complete',
                                ]) && request()->route('installation_category') === 'commercial') active @endif">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Commercial
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-queue.index', 'commercial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category-queue.index') &&
                                                request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-assign.index', 'commercial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category-assign.index') &&
                                                request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.complete', 'commercial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category.complete') && request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.reports', 'commercial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category.reports') && request()->route('installation_category') === 'commercial') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Industrial --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link @if (request()->routeIs([
                                    'installation-category-queue.*',
                                    'installation-category-assign.*',
                                    'installation-category.reports',
                                    'installation-category.complete',
                                ]) && request()->route('installation_category') === 'industrial') active @endif">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Industrial
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-queue.index', 'industrial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category-queue.index') &&
                                                request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Queue</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category-assign.index', 'industrial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category-assign.index') &&
                                                request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Assign</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.complete', 'industrial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category.complete') && request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Complete</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('installation-category.reports', 'industrial') }}"
                                        class="nav-link @if (request()->routeIs('installation-category.reports') && request()->route('installation_category') === 'industrial') active @endif">
                                        <p>Installation Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                </div>

                <li class="nav-header text-primary border-top border-success pt-1 mt-2">
                    <strong>Support Dashboard</strong>
                </li>

                <li class="nav-item {{ request()->routeIs('ticket.index') ? 'menu-open' : '' }}">
                    <a href="{{ route('ticket.index') }}"
                        class="nav-link {{ request()->routeIs('ticket.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>Ticketing</p>
                    </a>
                </li>
                {{-- Register Customer --}}
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->routeIs(['supportdashboard.*', 'registercustomer-ticket.*']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Register
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('registercustomer-ticket.dashboard') }}"
                                class="nav-link {{ request()->routeIs('registercustomer-ticket.dashboard') ? 'active' : '' }}">
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('registercustomer-ticket.queue') }}"
                                class="nav-link {{ request()->routeIs('registercustomer-ticket.queue') ? 'active' : '' }}">
                                <p>Ticket Queue</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('registercustomer-ticket.assign') }}"
                                class="nav-link {{ request()->routeIs('registercustomer-ticket.assign') ? 'active' : '' }}">
                                <p>Ticket Assign</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('registercustomer-ticket.complete') }}"
                                class="nav-link {{ request()->routeIs('registercustomer-ticket.complete') ? 'active' : '' }}">
                                <p>Ticket Complete</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('registercustomer-ticket.report') }}"
                                class="nav-link {{ request()->routeIs('registercustomer-ticket.report') ? 'active' : '' }}">
                                <p>Ticket Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Outsider Customer --}}
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->routeIs(['supportdashboard.*', 'outsidercustomer-ticket.*']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Outsider
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('outsidercustomer-ticket.dashboard') }}"
                                class="nav-link {{ request()->routeIs('outsidercustomer-ticket.dashboard') ? 'active' : '' }}">
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('outsidercustomer-ticket.queue') }}"
                                class="nav-link {{ request()->routeIs('outsidercustomer-ticket.queue') ? 'active' : '' }}">
                                <p>Ticket Queue</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('outsidercustomer-ticket.assign') }}"
                                class="nav-link {{ request()->routeIs('outsidercustomer-ticket.assign') ? 'active' : '' }}">
                                <p>Ticket Assign</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('outsidercustomer-ticket.complete') }}"
                                class="nav-link {{ request()->routeIs('outsidercustomer-ticket.complete') ? 'active' : '' }}">
                                <p>Ticket Complete</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('outsidercustomer-ticket.report') }}"
                                class="nav-link {{ request()->routeIs('outsidercustomer-ticket.report') ? 'active' : '' }}">
                                <p>Ticket Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <div class="my-3 border-top border-success pt-1">
                    <li class="nav-header text-primary"><b>AMC Dashboard</b></li>

                    <li class="nav-item {{ request()->routeIs() ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs(['amc.*', 'amcassign.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                AMC
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        {{-- Submenu: AMC List --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('amc.index') }}"
                                    class="nav-link {{ request()->routeIs('amc.index') ? 'active' : '' }}">
                                    <p>List</p>
                                </a>
                            </li>

                            {{-- Submenu: AMC Assign --}}
                            <li class="nav-item">
                                <a href="{{ route('amcassign.index') }}"
                                    class="nav-link {{ request()->routeIs('amcassign.index') ? 'active' : '' }}">
                                    <p>Assign</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </div>

                <div class="border-top border-success"></div>

                @if (auth()->user()->access_type === 'Admin')
                @else
                    @can('access_branch')
                        <li class="nav-item {{ request()->routeIs('branches.*') ? 'menu-is-opening menu-open' : '' }}">
                            <a href="#" class="nav-link" {{ request()->routeIs('branches.*') ? 'active' : '' }}>
                                <i class="nav-icon fas fa-store"></i>
                                <p>
                                    Branch
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('branches.index') }}"
                                        class="nav-link {{ request()->routeIs('branches.index') ? 'active' : '' }}">
                                        {{-- <i class="far fa-circle nav-icon"></i> --}}
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
                            <i class="nav-icon fas fa-calendar"></i>
                            <p>
                                Attendance
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if (auth()->user()->role['name'] === 'Super Admin')
                                <li class="nav-item">
                                    <a href="{{ route('attendance.all') }}"
                                        class="nav-link @if (request()->routeIs('attendance.all')) active @endif">
                                        {{-- <i class="far fa-circle nav-icon"></i> --}}
                                        <p>Attendance</p>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('attendance.index') }}"
                                        class="nav-link @if (request()->routeIs('attendance.index')) active @endif">
                                        {{-- <i class="far fa-circle nav-icon"></i> --}}
                                        <p>My Attendance</p>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('attendance.checkin') }}"
                                    class="nav-link @if (request()->routeIs('attendance.checkin')) active @endif">

                                    <p>Check-In Request</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('attendance.checkout') }}"
                                    class="nav-link @if (request()->routeIs('attendance.checkout')) active @endif">

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
                            <p>
                                Payroll
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('setsalary.index') }}"
                                    class="nav-link @if (request()->routeIs('setsalary.index')) active @endif">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Set Salary</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('setsalary.payslip.index') }}"
                                    class="nav-link @if (request()->routeIs('setsalary.payslip.index')) active @endif">

                                    <p>Payslip</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Sliders --}}
                @can('access_sliders')
                    <li class="nav-item {{ request()->routeIs('sliders.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('sliders.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                Sliders
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('sliders.index') }}"
                                    class="nav-link {{ request()->routeIs('sliders.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Sliders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sliders.create') }}"
                                    class="nav-link {{ request()->routeIs('sliders.create') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Create Sliders</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Product Mgnt --}}
                @can('access_product')
                    <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                Product Mgnt
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('products-categories.index') }}"
                                    class="nav-link @if (request()->routeIs('products-categories.index')) active @endif">
                                    <p>Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products-brands.index') }}"
                                    class="nav-link @if (request()->routeIs('products-brands.index')) active @endif">
                                    <p>Brands</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products-machineries.index') }}"
                                    class="nav-link @if (request()->routeIs('products-machineries.index')) active @endif">
                                    <p>Machineries</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products-accessories.index') }}"
                                    class="nav-link @if (request()->routeIs('products-accessories.index')) active @endif">
                                    <p>Accessories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('technicaltools.index') }}"
                                    class="nav-link {{ request()->routeIs('technicaltools.index') ? 'active' : '' }}">
                                    <p>Technical Tools</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Inventory --}}
                <li
                    class="nav-item {{ request()->routeIs('inventory.*', 'suppliers.*', 'purchases.*', 'sales.*', 'stock-transfers.*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('inventory.*', 'suppliers.*', 'purchases.*', 'sales.*', 'stock-transfers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Inventory
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}"
                                class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('device-purchases.index') }}"
                                class="nav-link {{ request()->routeIs('device-purchases.index') ? 'active' : '' }}">
                                <p>Device Purchases</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inventries') }}"
                                class="nav-link {{ request()->routeIs('inventries') ? 'active' : '' }}">
                                <p>Inventries</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}"
                                class="nav-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                                <p>Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock-transfers.index') }}"
                                class="nav-link {{ request()->routeIs('stock-transfers.index') ? 'active' : '' }}">
                                <p>Stock Transfer</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('stock-issue.index') }}"
                                class="nav-link {{ request()->routeIs('stock-issue.index') ? 'active' : '' }}">
                                <p>stock issue</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Services --}}
                @can('access_sliders')
                    <li class="nav-item @if (request()->routeIs('services.*')) menu-is-opening menu-open @endif">
                        <a href="#" class="nav-link @if (request()->routeIs('services.*')) active @endif">
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                Services
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('services_category.index') }}"
                                    class="nav-link @if (request()->routeIs('services_category.index')) active @endif">
                                    <p>Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('services.index') }}"
                                    class="nav-link @if (request()->routeIs('services.index')) active @endif">
                                    <p>Services</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Blogs --}}
                @can('access_blogs')
                    <li class="nav-item {{ request()->routeIs('blogs.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('blogs.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                Blogs
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('blogs.index') }}"
                                    class="nav-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Blog</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('blogs.create') }}"
                                    class="nav-link {{ request()->routeIs('blogs.create') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Create Blogs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- <li
                      class="nav-item {{ request()->routeIs(['expenses.*', 'expenses-categories.*']) ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#"
                          class="nav-link {{ request()->routeIs(['expenses.*', 'expenses-categories.*']) ? 'active' : '' }}">
                          <i class="nav-icon fas fa-newspaper"></i>
                          <p>
                              Expenses
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('expenses-categories.index') }}"
                                  class="nav-link {{ request()->routeIs('expenses-categories.index') ? 'active' : '' }}">

                                  <p>Category</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('expenses.index') }}"
                                  class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">

                                  <p>Expenses</p>
                              </a>
                          </li>

                      </ul>
                  </li> --}}

                @can('access_pettycash')
                    <li
                        class="nav-item {{ request()->routeIs([
                            'pettycash-addcash.*',
                            'pettycash-request.*',
                            'pettycash-transfer.*',
                            'pettycash-transaction.*',
                            'expenses-categories.*',
                            'petty.expenses.*',
                        ])
                            ? 'menu-is-opening menu-open'
                            : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs([
                                'pettycash-addcash.*',
                                'pettycash-request.*',
                                'pettycash-transfer.*',
                                'pettycash-transaction.*',
                                'expenses-categories.*',
                                'petty.expenses.*',
                            ])
                                ? 'active'
                                : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                Petty Cash
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('expenses-categories.index') }}"
                                    class="nav-link {{ request()->routeIs('expenses-categories.index') ? 'active' : '' }}">
                                    <p>Add Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-addcash.index') }}"
                                    class="nav-link {{ request()->routeIs('pettycash-addcash.index') ? 'active' : '' }}">
                                    <p>Add Cash</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-request.index') }}"
                                    class="nav-link {{ request()->routeIs('pettycash-request.index') ? 'active' : '' }}">
                                    <p>Cash Request</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-transfer.index') }}"
                                    class="nav-link {{ request()->routeIs('pettycash-transfer.index') ? 'active' : '' }}">
                                    <p>Cash Verification</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('petty.expenses.index') }}"
                                    class="nav-link {{ request()->routeIs('petty.expenses.index') ? 'active' : '' }}">
                                    <p>Petty Cash Expenses</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pettycash-transaction.index') }}"
                                    class="nav-link {{ request()->routeIs('pettycash-transaction.index') ? 'active' : '' }}">
                                    <p>Petty Cash Transaction</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                {{-- Vehicle MGNT --}}
                @can('access_vehicle')
                    <li class="nav-item {{ request()->routeIs('PetrolMGNT.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs(['bike.*', 'petrol.*', 'service.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                Vehicle Mgnt
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('bike.index') }}"
                                    class="nav-link {{ request()->routeIs('bike.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Bike</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('petrol.index') }}"
                                    class="nav-link {{ request()->routeIs('petrol.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Petrol </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('service.index') }}"
                                    class="nav-link {{ request()->routeIs('service.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Service</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Finance --}}
                @can('access_finance')
                    <li class="nav-item {{ request()->routeIs('finance.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs(['firstbill.*', 'payment-verification.*', 'finance.*', 'daily.*']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                Finance
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('firstbill.index') }}"
                                    class="nav-link {{ request()->routeIs('firstbill.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>First Bill</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('payment-verification.index') }}"
                                    class="nav-link {{ request()->routeIs('payment-verification.index') ? 'active' : '' }}
                                   ">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Field Payment Verification</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('finance.index') }}"
                                    class="nav-link {{ request()->routeIs('finance.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Payment Entry</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('daily.index') }}"
                                    class="nav-link {{ request()->routeIs('daily.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Daily Collection</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <div class="border-top border-success"></div>
                {{-- Advertisements --}}
                @can('access_advertisements')
                    <li class="nav-item {{ request()->routeIs() ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('advertisements.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-image"></i>
                            <p>
                                Advertisements
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('advertisements.index') }}"
                                    class="nav-link {{ request()->routeIs('advertisements.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Advertisements</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('advertisements.create') }}"
                                    class="nav-link {{ request()->routeIs('advertisements.create') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Create Advertisements</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Teams --}}
                @can('access_teams')
                    <li class="nav-item {{ request()->routeIs('teams.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('teams.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Teams
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('teams.index') }}"
                                    class="nav-link {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Teams</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('teams.create') }}"
                                    class="nav-link {{ request()->routeIs('teams.create') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Create Teams</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- FAQs --}}
                @can('access_faqs')
                    <li class="nav-item {{ request()->routeIs('faqs.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('faqs.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>
                                FAQs
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('faqs.index') }}"
                                    class="nav-link {{ request()->routeIs('faqs.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>FAQs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('faqs.create') }}"
                                    class="nav-link {{ request()->routeIs('faqs.create') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Create FAQs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Testimonial --}}
                @can('access_testimonials')
                    <li class="nav-item {{ request()->routeIs('testimonials.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('testimonials.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-comment"></i>
                            <p>
                                Testimonial
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('testimonials.index') }}"
                                    class="nav-link {{ request()->routeIs('testimonials.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Testimonials</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('testimonials.create') }}"
                                    class="nav-link {{ request()->routeIs('testimonials.create') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Create Testimonials</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Vacancies --}}
                @can('access_vacancies')
                    <li class="nav-item {{ request()->routeIs('vacancies.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('vacancies.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                Vacancies
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('vacancies.index') }}"
                                    class="nav-link {{ request()->routeIs('vacancies.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Vacancies</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('vacancies.create') }}"
                                    class="nav-link {{ request()->routeIs('vacancies.create') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Create Vacancy</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- Gallery --}}
                @can('access_gallery')
                    <li class="nav-item">
                        <a href="{{ route('galleries.index') }}"
                            class="nav-link {{ request()->routeIs('galleries.index') ? 'active' : '' }}">
                            <i class="far fa-image nav-icon"></i>
                            <p>Gallery</p>
                        </a>
                    </li>
                @endcan
                {{-- Leaves --}}
                @can('access_leave')
                    <li class="nav-item {{ request()->routeIs('leave.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('leave.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                Leaves
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('leave-types.index') }}"
                                    class="nav-link {{ request()->routeIs('leave-types.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('leaves.index') }}"
                                    class="nav-link {{ request()->routeIs('leaves.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Leaves</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan
                {{-- Inquiries --}}
                @can('access_inquiries')
                    <li class="nav-item">
                        <a href="{{ route('inquires.index') }}"
                            class="nav-link {{ request()->routeIs('inquires.index') ? 'active' : '' }}">
                            <i class="far fa-address-book nav-icon"></i>
                            <p>Inquiries</p>
                        </a>
                    </li>
                @endcan
                {{-- Setting --}}
                @can('access_settings')
                    <li class="nav-item {{ request()->routeIs('company.*') ? 'menu-is-opening menu-open' : '' }}">
                        <a href="#" class="nav-link" {{ request()->routeIs('company.*') ? 'active' : '' }}>
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Setting
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('company.index') }}"
                                    class="nav-link {{ request()->routeIs('company.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Company Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('whyus.index') }}"
                                    class="nav-link {{ request()->routeIs('whyus.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Why Choose Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logs.index') }}"
                                    class="nav-link {{ request()->routeIs('logs.index') ? 'active' : '' }}">
                                    {{-- <i class="far fa-circle nav-icon"></i> --}}
                                    <p>Logs</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                @endcan

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
