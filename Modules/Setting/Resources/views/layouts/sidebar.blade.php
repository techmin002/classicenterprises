  <!-- Main Sidebar Container -->
  @php
      $profile = \Modules\Setting\Entities\CompanyProfile::first();
  @endphp
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
              {{-- <div class="info">
          <a href="{{ route('home') }}" class="d-block" style="text-decoration: none;">{{ $profile->company_name }}</a>
        </div> --}}
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
                          <p>
                              Dashboard

                          </p>
                      </a>
                  </li>

                  @can('access_user_management')
                      <li
                          class="nav-item {{ request()->routeIs('users.*', 'roles.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('users.*', 'roles.*') ? 'active' : '' }}>
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
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Roles</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('users.index') }}"
                                      class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Users</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('users.create') }}"
                                      class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Create Users</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
                  @can('access_user_management')
                      <li
                          class="nav-item {{ request()->routeIs('users.*', 'roles.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link"
                              {{ request()->routeIs('users.*', 'roles.*') ? 'active' : '' }}>
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
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Hot Leads</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('warm-leads') }}"
                                      class="nav-link {{ request()->routeIs('warm-leads') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Warm Leads</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('cold-leads') }}"
                                      class="nav-link {{ request()->routeIs('cold-leads') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Cold Leads</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('followups') }}"
                                      class="nav-link {{ request()->routeIs('followups') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Followups</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
                  <li
                      class="nav-item {{ request()->routeIs('users.*', 'salecategories.*') ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#" class="nav-link"
                          {{ request()->routeIs('users.*', 'salecategories.*') ? 'active' : '' }}>
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
                                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                                  <p>Retailler</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('salecategories.wholeseller') }}"
                                  class="nav-link {{ request()->routeIs('salecategories.wholeseller') ? 'active' : '' }}">
                                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                                  <p>Wholeseller</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <div class="my-3 border-top border-success pt-1">
                    <li class="nav-header text-primary">
                        <strong>Sales Detail's</strong>
                    </li>
                  <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                          <i class="nav-icon fas fa-image"></i>
                          <p>
                              CC Installation
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('installation-queue.index', 'classic_customer') }}"
                                  class="nav-link @if (request()->routeIs('installation-queue.index', 'classic_customer')) active @endif">
                                  <p>Installation Queue</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('installation.reports', 'classic_customer') }}"
                                  class="nav-link @if (request()->routeIs('installation.reports', 'classic_customer')) active @endif">
                                  <p>Installation Reports</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('installation.complete', 'classic_customer') }}"
                                  class="nav-link @if (request()->routeIs('installation.complete', 'classic_customer')) active @endif">
                                  <p>Installation Complete</p>
                              </a>
                          </li>

                      </ul>
                  </li>

                  <li class="nav-header text-primary"><b>Sales Detail's</b></li>

                <li class="nav-item {{ request()->routeIs('inventory.*', 'suppliers.*', 'purchases.*', 'sales.*', 'stock-transfers.*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('inventory.*', 'suppliers.*', 'purchases.*', 'sales.*', 'stock-transfers.*') ? 'active' : '' }}">
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
                    </ul>
                </li>

                  <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                          <i class="nav-icon fas fa-image"></i>
                          <p>
                              CC Installation
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('installation-queue.index', 'classic_customer') }}"
                                  class="nav-link @if (request()->routeIs('installation-queue.index', 'classic_customer')) active @endif">
                                  <p>Installation Queue</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('installation.reports', 'classic_customer') }}"
                                  class="nav-link @if (request()->routeIs('installation.reports', 'classic_customer')) active @endif">
                                  <p>Installation Reports</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('installation.complete', 'classic_customer') }}"
                                  class="nav-link @if (request()->routeIs('installation.complete', 'classic_customer')) active @endif">
                                  <p>Installation Complete</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                  @can('access_sliders')
                      <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                          <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                              <i class="nav-icon fas fa-image"></i>
                              <p>
                                  Retails
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('installation-queue.index', 'retailler') }}"
                                      class="nav-link @if (request()->routeIs('installation-queue.index', 'retailler')) active @endif">
                                      <p>Installation Queue</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('installation.reports', 'retailler') }}"
                                      class="nav-link @if (request()->routeIs('installation.reports', 'retailler')) active @endif">
                                      <p>Installation Reports</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('installation.complete', 'retailler') }}"
                                      class="nav-link @if (request()->routeIs('installation.complete', 'retailler')) active @endif">
                                      <p>Installation Complete</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan
                  @can('access_sliders')
                      <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                          <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                              <i class="nav-icon fas fa-image"></i>
                              <p>
                                  Wholesale
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('installation-queue.index', 'wholeseller') }}"
                                      class="nav-link @if (request()->routeIs('installation-queue.index', 'wholeseller')) active @endif">
                                      <p>Installation Queue</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('installation.reports', 'wholeseller') }}"
                                      class="nav-link @if (request()->routeIs('installation.reports', 'wholeseller')) active @endif">
                                      <p>Installation Reports</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('installation.complete', 'wholeseller') }}"
                                      class="nav-link @if (request()->routeIs('installation.complete', 'wholeseller')) active @endif">
                                      <p>Installation Complete</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan
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
                  @can('access_sliders')
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
                          </ul>
                      </li>
                  @endcan
                  @can('access_sliders')
                      <li class="nav-item @if (request()->routeIs('products.*')) menu-is-opening menu-open @endif">
                          <a href="#" class="nav-link @if (request()->routeIs('products.*')) active @endif">
                              <i class="nav-icon fas fa-image"></i>
                              <p>
                                  Inventory Mgnt
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('inventories.index', 'machinery') }}"
                                      class="nav-link @if (request()->routeIs('inventories.index', 'machinery')) active @endif">
                                      <p>Machineries</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('inventories.index', 'machinery') }}"
                                      class="nav-link @if (request()->routeIs('inventories.index', 'accessory')) active @endif">
                                      <p>Accessories</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('inventories.create') }}"
                                      class="nav-link @if (request()->routeIs('inventories.create')) active @endif">
                                      <p>Purchase</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  @endcan
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
                  @can('access_blogs')
                      <li class="nav-item {{ request()->routeIs('expenses.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link" {{ request()->routeIs('expenses.*') ? 'active' : '' }}>
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
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Category</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('expenses.index') }}"
                                      class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Expenses</p>
                                  </a>
                              </li>

                          </ul>
                      </li>
                  @endcan
                  {{-- @can('access_blogs') --}}
                  <li class="nav-item {{ request()->routeIs('pettycash.*') ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#" class="nav-link" {{ request()->routeIs('pettycash.*') ? 'active' : '' }}>
                          <i class="nav-icon fas fa-newspaper"></i>
                          <p>
                              Petty Cash
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ route('pettycash-addcash.index') }}"
                                  class="nav-link {{ request()->routeIs('pettycash-addcash.index') ? 'active' : '' }}">
                                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                                  <p>Cash Add</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('pettycash-request.index') }}"
                                  class="nav-link {{ request()->routeIs('pettycash-request.index') ? 'active' : '' }}">
                                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                                  <p>Cash Request </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('pettycash-transfer.index') }}"
                                  class="nav-link {{ request()->routeIs('pettycash-transfer.index') ? 'active' : '' }}">
                                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                                  <p>Cash Transfer </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('pettycash-transaction.index') }}"
                                  class="nav-link {{ request()->routeIs('pettycash-transaction.index') ? 'active' : '' }}">
                                  {{-- <i class="far fa-circle nav-icon"></i> --}}
                                  <p>Petty Cash transaction </p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  {{-- @endcan --}}
                  {{-- @can('access_blogs') --}}
                  <li class="nav-item {{ request()->routeIs('PetrolMGNT.*') ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#" class="nav-link" {{ request()->routeIs('PetrolMGNT.*') ? 'active' : '' }}>
                          <i class="nav-icon fas fa-newspaper"></i>
                          <p>
                              Vehical MGNT
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
                  <li class="nav-item {{ request()->routeIs('finance.*') ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#" class="nav-link" {{ request()->routeIs('finance.*') ? 'active' : '' }}>
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
                  {{-- @endcan --}}
                  <!-- Support Dashboard Section -->
                  <div class="my-3 border-top border-success pt-1">
                      <li class="nav-header text-primary">
                          <strong>Support Dashboard</strong>
                      </li>

                      <li
                          class="nav-item {{ request()->routeIs('supportdashboard.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#"
                              class="nav-link {{ request()->routeIs('supportdashboard.*') ? 'active' : '' }}">
                              <i class="nav-icon fas fa-newspaper"></i>
                              <p>
                                  Tickets
                                  <i class="right fas fa-angle-left"></i>
                              </p>
                          </a>

                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('supportdashboard.create') }}"
                                      class="nav-link {{ request()->routeIs('supportdashboard.create') ? 'active' : '' }}">
                                      <p>Ticket Create</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('pettycash-request.index') }}"
                                      class="nav-link {{ request()->routeIs('pettycash-request.index') ? 'active' : '' }}">
                                      <p>Ticket Queue</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('pettycash-request.index') }}"
                                      class="nav-link {{ request()->routeIs('pettycash-request.index') ? 'active' : '' }}">
                                      <p>Ticket Assign</p>
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a href="{{ route('pettycash-request.index') }}"
                                      class="nav-link {{ request()->routeIs('pettycash-request.index') ? 'active' : '' }}">
                                      <p>Task Complete</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                  </div>
                  <div class="border-top border-success"></div>
                  @can('access_advertisements')
                      <li
                          class="nav-item {{ request()->routeIs('advertisements.*') ? 'menu-is-opening menu-open' : '' }}">
                          <a href="#" class="nav-link"
                              {{ request()->routeIs('advertisements.*') ? 'active' : '' }}>
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
                  <li class="nav-item">
                      <a href="{{ route('galleries.index') }}"
                          class="nav-link {{ request()->routeIs('galleries.index') ? 'active' : '' }}">
                          <i class="far fa-image nav-icon"></i>
                          <p>Gallery</p>
                      </a>
                  </li>
                  <li class="nav-item {{ request()->routeIs('expenses.*') ? 'menu-is-opening menu-open' : '' }}">
                      <a href="#" class="nav-link" {{ request()->routeIs('expenses.*') ? 'active' : '' }}>
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
                  <li class="nav-item">
                      <a href="{{ route('inquires.index') }}"
                          class="nav-link {{ request()->routeIs('inquires.index') ? 'active' : '' }}">
                          <i class="far fa-address-book nav-icon"></i>
                          <p>Inquiries</p>
                      </a>
                  </li>
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
                          </ul>
                          <ul class="nav nav-treeview">
                              <li class="nav-item">
                                  <a href="{{ route('whyus.index') }}"
                                      class="nav-link {{ request()->routeIs('whyus.index') ? 'active' : '' }}">
                                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                                      <p>Why Choose Us</p>
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
