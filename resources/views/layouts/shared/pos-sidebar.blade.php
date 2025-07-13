@php
    use Modules\FlexPerformance\app\Models\BrandSetting;
    $brandSetting = BrandSetting::firstOrCreate();
@endphp


@can('view-leftbar')
    <div class="sidebar sidebar-light sidebar-main sidebar-expand-lg  ">
        <div class="sidebar-content">
            <div class="sidebar-section">
                <ul class="nav nav-sidebar main-link" data-nav-type="accordion">

                    <!-- Sidebar header -->
                    <div class="sidebar-section ">
                        <div class="sidebar-section-body d-flex bg-main justify-content-center">
                            <h6 class="sidebar-resize-hide flex-grow-1 my-auto text-main">
                                {{-- ERP --}}
                                <img src="{{ $brandSetting &&
                                $brandSetting->company_logo &&
                                file_exists(public_path('storage/' . $brandSetting->company_logo))
                                    ? asset('storage/' . $brandSetting->company_logo)
                                    : asset('assets/images/flex-logo.png') }}"
                                    height="40" alt="logo">

                            </h6>

                            <div>
                                <button type="button"
                                    class="btn btn-flat-white bg-main btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                    <i class="ph-arrows-left-right"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                                    <i class="ph-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- /sidebar header -->
                    <div class="mt-3"></div>

                    {{-- start of dashboard menu --}}
                    <li class="nav-item ">
                        <a href="{{ route('dashboard') }}"
                            class="text-color nav-link  {{ request()->routeIs('dashboard') ? 'active' : null }}">
                            <i class="ph-house "></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    {{-- end of dashboard menu --}}

                    {{-- start of user management --}}
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('ternat-employee.*') ? 'nav-item-expanded nav-item-open' : null }}">
                        <a href="#" class="nav-link ">
                            <i class="ph ph-users-three"></i>
                            <span>Users Management</span>
                        </a>

                        <ul class="nav-group-sub collapse {{ request()->routeIs('ternat-employee.*') ? 'show' : null }}">

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('ternat-employee.index', 'ternat-employees.create', 'ternat-employees.edit') ? 'active' : null }}"
                                    href="{{ route('ternat-employee.index') }}">
                                    Active Users
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('ternat-employee.suspended') ? 'active' : null }}"
                                    href="{{ route('ternat-employee.suspended') }}">
                                    Blocked Users
                                </a>
                            </li>

                        </ul>
                    </li>
                    {{-- ./ --}}

                    {{-- start of product management menu --}}
                    @php
                        $productRoutes = ['retails.*', 'retail-units.index', 'categories.index'];
                    @endphp

                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs(...$productRoutes) ? 'nav-item-expand nav-item-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="ph ph-clipboard-text"></i>
                            <span>Products Management</span>
                        </a>

                        <ul class="nav-group-sub collapse {{ request()->routeIs(...$productRoutes) ? 'show' : '' }}">
                            @include('layouts.shared.pos-sidebar.product-management')
                        </ul>
                    </li>

                    {{-- ./ --}}

                    {{-- Start of Supplier Management --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : null }}"
                            href="{{ route('suppliers.index') }}">
                            <i class="ph-user-list"></i>

                            Suppliers Management
                        </a>
                    </li>
                    {{-- ./ end of suppliers management --}}

                    {{-- Start of Customer Management --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.customer_details') || request()->routeIs('flex.add-customer') || request()->routeIs('flex.all-customers') || request()->routeIs('flex.edit-customer') || request()->routeIs('customer.tab_index') ? 'active' : null }}"
                            href="{{ route('flex.all-customers') }}">
                            <i class="ph-users"></i>
                            Customers Management
                        </a>
                    </li>
                    {{-- ./ end of customer Management --}}

                    {{-- start of purchases Management --}}
                    @can('view-purchase')
                        {{-- Procurements Management --}}
                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('purchases.*', 'service-purchases.*', 'out-of-stocks.*') ? 'nav-item-expanded nav-item-open' : null }}">
                            <a href="#" class="nav-link ">
                                <i class="ph-shopping-cart"></i>
                                <span>Purchases Management</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('purchases.*', 'service-purchases.*', 'out-of-stocks.*') ? 'show' : null }}">


                                @can('add-purchase')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('purchases.create') ? 'active' : null }}"
                                            href="{{ route('purchases.create') }}">
                                            New Purchase
                                        </a>
                                    </li>
                                @endcan

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('purchases.index') ? 'active' : null }}"
                                        href="{{ route('purchases.index') }}">
                                        List of Purchases
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}


                    {{-- start of Sales Management --}}
                    @can('view-purchase')
                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('sales.*', 'service-sales.*', 'out-of-stocks.*') ? 'nav-item-expanded nav-item-open' : null }}">
                            <a href="#" class="nav-link ">
                                <i class="ph-calculator"></i>
                                <span>Sales Management</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('sales.*', 'service-sales.*', 'out-of-stocks.*') ? 'show' : null }}">


                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('sales.create') ? 'active' : null }}"
                                        href="{{ route('sales.create') }}">
                                        New Sale
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('sales.index') ? 'active' : null }}"
                                        href="{{ route('sales.index') }}">
                                        List of Sales
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}


                    {{-- start of Stock Management --}}
                    @can('view-purchase')
                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('stocks.*', 'stock-alerts.*', 'out-of-stocks.*') ? 'nav-item-expanded nav-item-open' : null }}">
                            <a href="#" class="nav-link ">
                                <i class="ph ph-package"></i>
                                <span>Stock Management</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('stocks.*', 'stock-alerts.*', 'out-of-stocks.*') ? 'show' : null }}">

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : null }}"
                                        href="{{ url('stocks.index') }}">
                                        Stock List
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('stock-alerts.index') ? 'active' : null }}"
                                        href="{{ url('stock-alerts.index') }}">
                                        Stock Alerts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('out-of-stocks.index') ? 'active' : null }}"
                                        href="{{ url('out-of-stocks.index') }}">
                                        Out of Stock Items
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('stocks.report') ? 'active' : null }}"
                                        href="{{ url('stocks.report') }}">
                                        Stock Report
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endcan
                    {{-- ./end of Stock Management --}}

                    {{-- start of cashbook  --}}

                    {{-- @can('view-cashbook') --}}
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('cashbook.*') ? 'nav-item-expanded nav-item-open' : null }}">
                        <a href="#" class="nav-link ">
                            <i class="ph ph-book"></i>
                            <span>CashBook Management</span>
                        </a>

                        <ul class="nav-group-sub collapse {{ request()->routeIs('cashbook.*') ? 'show' : null }}">

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('cashbook.create') ? 'active' : null }}"
                                    href="{{ url('cashbook.create') }}">
                                    New Cash Book
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('cashbook.current') ? 'active' : null }}"
                                    href="{{ url('cashbook.current') }}">
                                    Current Cash Book
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('cashbook.old') ? 'active' : null }}"
                                    href="{{ url('cashbook.old') }}">
                                    Old Cash Books
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- @endcan --}}

                    {{-- Start of Customer Management --}}
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('flex.all-customers') }}">
                            <i class="ph-files"></i>
                            Reports
                        </a>
                    </li>
                    {{-- ./ end of customer Management --}}

                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('settings.*') ||
                        request()->routeIs('flex.company-details') ||
                        request()->routeIs('flex.edit-company-details') ||
                        request()->routeIs('taxes.*') ||
                        request()->routeIs('flex.add-company-details')
                            ? 'nav-item-expanded nav-item-open'
                            : '' }}">
                        <a href="#" class="nav-link ">
                            <i class="ph ph-gear"></i>
                            <span>System Settings</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('settings.*') ||
                            request()->routeIs('flex.company-details') ||
                            request()->routeIs('flex.edit-company-details') ||
                            request()->routeIs('taxes.*') ||
                            request()->routeIs('flex.add-company-details')
                                ? 'show'
                                : '' }}">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('flex.company-details') || request()->routeIs('flex.edit-company-details') || request()->routeIs('flex.add-company-details') ? 'active' : null }}"
                                    href="{{ route('flex.company-details') }}">
                                    Business Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('settings.financial-years.*') ? 'active' : '' }}"
                                    href="{{ route('settings.financial-years.index') }}">
                                    Financial Year
                                </a>
                            </li>
                            <li class="nav-item  ">
                                <a class="nav-link {{ request()->routeIs('taxes.*') ? 'active' : '' }}" href="{{ route('taxes.index') }}">
                                    System Taxes
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('settings.subscriptions') ? 'active' : '' }}"
                                    href="{{ url('settings.subscriptions') }}">
                                    Subscriptions
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('settings.staff-roles') ? 'active' : '' }}"
                                    href="{{ url('settings.staff-roles') }}">
                                    Staff Roles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('settings.language') ? 'active' : '' }}"
                                    href="{{ url('settings.language') }}">
                                    Language
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('settings.system-logs') ? 'active' : '' }}"
                                    href="{{ url('settings.system-logs') }}">
                                    System Logs
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('flex.all-customers') }}">
                            <i class="ph ph-headset"></i>
                            Support
                        </a>
                    </li>


                </ul>
                </li>
            </div>
        </div>
    </div>
@endcan
{{-- /main sidebar --}}
