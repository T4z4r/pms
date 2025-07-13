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
                                {{-- {{Auth::user()->fname.' '.Auth::user()->lname}} --}}
                                {{-- ERP --}}
                                <img src="{{ asset('storage/' . $brandSetting->company_logo) }}" height="40" alt="logo">
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

                    <li class="nav-item ">
                        <a href="{{ route('dashboard') }}"
                            class="text-color nav-link  {{ request()->routeIs('dashboard') ? 'active' : null }}">
                            <i class="ph-house "></i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                    {{-- Start of My Services --}}
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.my-grievances') ||
                        request()->routeIs('flex.my-biodata') ||
                        request()->routeIs('flex.my-pensions') ||
                        request()->routeIs('flex.my-overtimes') ||
                        request()->routeIs('flex.my-leaves') ||
                        request()->routeIs('flex.my-loans') ||
                        request()->routeIs('flex.department-store-request') ||
                        request()->routeIs('flex.department-store-request.create') ||
                        request()->routeIs('flex.department-store-request.show') ||
                        request()->routeIs('flex.department-store-request.show.single') ||
                        request()->routeIs('flex.department-store-request.edit') ||
                        request()->routeIs('admistration-expenses.create') ||
                        request()->routeIs('admistration-expenses.edit') ||
                        request()->routeIs('admistration-expenses.show') ||
                        request()->routeIs('flex.admistration-requests') ||
                        request()->routeIs('flex.manager-trucks') ||
                        request()->routeIs('my_advance_salary_requests.*') ||
                        request()->routeIs('flex.manager-single-truck')
                            ? 'nav-item-expand nav-item-open'
                            : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-user"></i>
                            <span>My Services</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse
                            {{ request()->routeIs('flex.my-grievances') ||
                            request()->routeIs('flex.my-biodata') ||
                            request()->routeIs('flex.my-pensions') ||
                            request()->routeIs('flex.my-overtimes') ||
                            request()->routeIs('flex.my-leaves') ||
                            request()->routeIs('flex.my-loans') ||
                            request()->routeIs('flex.department-store-request') ||
                            request()->routeIs('flex.department-store-request.create') ||
                            request()->routeIs('flex.department-store-request.show') ||
                            request()->routeIs('flex.department-store-request.show.single') ||
                            request()->routeIs('flex.department-store-request.edit') ||
                            request()->routeIs('admistration-expenses.create') ||
                            request()->routeIs('admistration-expenses.edit') ||
                            request()->routeIs('admistration-expenses.show') ||
                            request()->routeIs('flex.admistration-requests') ||
                            request()->routeIs('flex.manager-trucks') ||
                            request()->routeIs('my_advance_salary_requests.*') ||
                            request()->routeIs('flex.manager-single-truck')
                                ? 'show'
                                : null }}">
                            {{-- start of Myservices Menu --}}
                            @include('layouts.shared.myservices-menu')
                            {{-- ./ end of Myservices Menu --}}
                        </ul>
                    </li>
                    {{-- ./ --}}


                    @can('view-human-capital')
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide"> HR & Payroll</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>
                        @include('layouts.shared.hr_module_menu')
                    @endcan

                    {{-- start of task management --}}
                @include('layouts.shared.left-sidear.task-management-menu')
                {{-- ./ end of  task management  --}}


                    {{-- start of Salary Advance Request --}}
                    {{-- @can('view-human-capital')
                        <li class="nav-item ">
                            <a href="{{ route('advance_salary_requests.index') }}"
                                class="text-color nav-link  {{ request()->routeIs('advance_salary_requests.*') ? 'active' : null }} ">
                                <i class="ph-receipt text-color"></i>
                                <span>Salary Advances</span>
                            </a>
                        </li>
                        @endcan --}}

                    {{-- end of Salary Advance Request --}}




                    {{-- =============================================== Flex ERP MANAGEMENT (OPERATION BASED) Menus ============================================== --}}

                    @can('view-management-menu')
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Operations Management</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>

                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">
                                <i class="ph-chalkboard-teacher"></i>
                                <span>Management Menu</span>
                            </a>

                            <ul class="nav-group-sub collapse ">
                                @include('layouts.shared.management-menu')
                            </ul>
                        </li>
                    @endcan

                    @can('view-finance-management')

                        {{-- =============================================== Flex ERP FINANCE  Menus ============================================== --}}
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Financial Accounting</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>


                        {{-- For General Finance --}}
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">

                                <i class="ph-money"></i>
                                <span>Finance Management</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse  {{ request()->routeIs('flex.transfer-balance') ||
                                request()->routeIs('flex.all-debtor-payments') ||
                                request()->routeIs('flex.initiated-show') ||
                                request()->routeIs('flex.all-disbursed-balances') ||
                                request()->routeIs('flex.add-debtor-payments') ||
                                request()->routeIs('flex.all-creditor-payments') ||
                                request()->routeIs('flex.all-customer-payments') ||
                                request()->routeIs('flex.add-creditor-payments') ||
                                request()->routeIs('flex.store-request') ||
                                request()->routeIs('flex.store-request.create') ||
                                request()->routeIs('flex.store-request.show') ||
                                request()->routeIs('flex.store-request.show.single') ||
                                request()->routeIs('flex.store-request.edit') ||
                                request()->routeIs('flex.payment-index') ||
                                request()->routeIs('flex.payment-show') ||
                                request()->routeIs('request-licences.create') ||
                                request()->routeIs('request-licences.edit') ||
                                request()->routeIs('request-licences.show') ||
                                request()->routeIs('request-licences.index') ||
                                request()->routeIs('flex.initiated-index') ||
                                request()->routeIs('flex.initiated-show') ||
                                request()->routeIs('admistration-expenses.create') ||
                                request()->routeIs('admistration-expenses.edit') ||
                                request()->routeIs('flex.admistration-show') ||
                                request()->routeIs('admistration-expenses.index')||
                                request()->routeIs('flex.show-balance')||
                                  request()->routeIs('flex.edit-balance')||
                                request()->routeIs('flex.all-employee-disbursed-balances')
                                    ? 'show'
                                    : null }}">
                                @include('layouts.shared.finance-menu')

                            </ul>
                        </li>



                        {{-- Start of Accounts Menu --}}


                        {{-- Start of Account Menu --}}
                        @can('view-accounts-menu')
                            @include('layouts.shared.accounts-menu')
                        @endcan
                        {{-- ./ --}}


                        @can('view-settings-menu1')
                            <li class="nav-item nav-item-submenu ">
                                <a href="#" class="nav-link  ">
                                    <i class="ph-books"></i>
                                    <span>Financial Statements</span>
                                </a>

                                <ul class="nav-group-sub collapse ">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('flex.trial-balance') }}">
                                            <i class="ph-receipt"></i>
                                            Trial Balance
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="{{ route('new-reports.income_statement') }}"
                                            class="nav-link {{ request()->routeIs('new-reports.income_statement') ? 'active' : null }} ">
                                            <i class="ph-receipt"></i>
                                            <span>Income Statement </span>
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a href="{{ route('flex.balance-sheet') }}"
                                            class="nav-link {{ request()->routeIs('flex.balance-sheet') ? 'active' : null }} ">
                                            <i class="ph-receipt"></i>
                                            <span>Balance Sheet </span>
                                        </a>
                                    </li>


                                    {{-- <li class="nav-item ">
                                    <a href="{{ route('cash_flow_statement') }}"
                                        class="nav-link {{ request()->routeIs('cash_flow_statement') ? 'active' : null }} ">
                                        <i class="ph-receipt"></i>
                                        <span>Cash Flow Statement </span>
                                    </a>
                                </li> --}}

                                    {{-- <li class="nav-item ">
                                    <a href="{{ route('equity_change_statement') }}" class="nav-link ">
                                        <i class="ph-receipt"></i>
                                        <span>Change of Equity </span>
                                    </a>
                                </li> --}}


                                    {{-- <li class="nav-item ">
                                    <a href="{{ route('config.show') }}"
                                        class="nav-link {{ request()->routeIs('config.show') ? 'active' : null }} ">
                                        <i class="ph-receipt"></i>
                                        <span>Account Configuration </span>
                                    </a>
                                </li> --}}


                                </ul>
                            </li>
                        @endcan
                        {{-- For OPeration Related Finance --}}
                        @include('layouts.shared.finance_module_menu')
                        {{--./ --}}

                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">PROCUREMENT</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>
                        {{-- Start of Procurement Menus --}}
                        {{-- start of Procurement Menu --}}
                        @can('view-procurement-menu')
                            {{-- Start of Store & Procurement Management --}}
                            @include('stores.store_menu.store-menu')
                            {{-- /End of Store & Procurement Management --}}

                            {{-- For Trip Related LPOs --}}
                            @include('layouts.shared.procurement_lpos')

                            {{-- ./ --}}
                        @endcan
                        {{-- ./ --}}

                    @endcan



                        {{-- Start of Vendor Menus --}}
                        @can('view-vendors-menu')
                            {{-- =============================================== Flex ERP CRM  Menus ============================================== --}}
                            <li class="nav-item-header">
                                <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">CRM</div>
                                <i class="ph-dots-three sidebar-resize-show"></i>
                            </li>


                            <li
                                class="nav-item nav-item-submenu {{ request()->routeIs('flex.project-customers') ||
                                request()->routeIs('flex.project-customer-details') ||
                                request()->routeIs('customer.tab_index_project')
                                    ? 'nav-item-expand nav-item-open'
                                    : null }}">
                                <a href="#" class="nav-link  ">
                                    <i class="ph-users-three"></i>
                                    <span>CRM Menu</span>
                                </a>

                                <ul
                                    class="nav-group-sub collapse {{ request()->routeIs('flex.project-customers') ||
                                    request()->routeIs('flex.project-customer-details') ||
                                    request()->routeIs('customer.tab_index_project')
                                        ? 'show'
                                        : null }}">
                                    @include('layouts.shared.vendors-menu')
                                </ul>
                            </li>

                            {{-- TODO: @Feature #Creating a new customer menu --}}
                            {{-- <li class="nav-item nav-item-submenu


                            {{ request()->routeIs('flex.project-customers') || request()->routeIs('flex.project-customer-details') ||
                        request()->routeIs('customer.tab_index_project') ? 'nav-item-expand nav-item-open' : null }}"
                    >
                        <a href="#" class="nav-link  ">
                            <i class="ph-users-three"></i>
                            <span>Customer Projects</span>
                        </a>

                        <ul class="nav-group-sub collapse
                            {{ request()->routeIs('flex.project-customers') || request()->routeIs('flex.project-customer-details') ||
                            request()->routeIs('customer.tab_index_project') ? 'show' : null}}"
                        >
                            @include('layouts.shared.vendors-project-menu')
                        </ul>
                    </li> --}}
                        @endcan
                        {{-- ./ --}}




                        {{-- For Project Management Menu --}}


                        @can('view-project-management')
                            {{-- =============================================== Flex ERP PROJECTS  Menus ============================================== --}}
                            <li class="nav-item-header">
                                <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">PROJECTS</div>
                                <i class="ph-dots-three sidebar-resize-show"></i>
                            </li>

                            <li
                                class="nav-item nav-item-submenu
                                {{ request()->routeIs('flex.projects.*') ||
                                request()->routeIs('project_common_costs.index') ||
                                request()->routeIs('project_common_cost_requests.index')
                                    ? 'nav-item-expand nav-item-open'
                                    : null }}">
                                <a href="#" class="nav-link">
                                    <i class="ph-activity"></i>
                                    <span>Project Managements</span>
                                </a>
                                <ul
                                    class="nav-group-sub collapse
                                    {{ request()->routeIs('flex.projects.*') ||
                                    request()->routeIs('project_common_costs.index') ||
                                    request()->routeIs('project_common_cost_requests.index')
                                        ? 'show'
                                        : null }}">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('flex.projects.*') ? 'active' : null }}"
                                            href="{{ route('flex.projects.index') }}">
                                            <i class="ph-activity"></i>
                                            Project List
                                        </a>
                                    </li>
                                     {{-- Start of Project Expenses --}}
                                 @can('view-project-payments')
                                      <li class="nav-item">
                                          <a class="nav-link {{ request()->routeIs('project_common_cost_requests.index') ? 'active' : null }}"
                                              href="{{ route('project_common_cost_requests.index') }}">
                                              <i class="ph-files"></i>
                                              Project Cost Requests
                                          </a>
                                      </li>
                                  @endcan
                                  {{-- / --}}
                                  @can('view-finance-management')
                                    <li class="nav-item ">
                                        <a href="{{ route('project_common_costs.index') }}"
                                            class="nav-link  {{ request()->routeIs('project_common_costs.index') ? 'active' : null }}">
                                            <i class="ph ph-calculator"></i>
                                            <span>Project Expenses </span>
                                        </a>
                                    </li>
                                    @endcan

                                </ul>
                            </li>
                            <li
                                class="nav-item nav-item-submenu {{ request()->routeIs('flex.tripTruck') || request()->routeIs('flex.all-customer-payments')
                                    ? 'nav-item-expand nav-item-open'
                                    : null }}">
                                <a href="#" class="nav-link">
                                    <i class="ph-receipt"></i>
                                    <span> Project Payments</span>
                                </a>
                                <ul
                                    class="nav-group-sub collapse {{ request()->routeIs('flex.all-customer-payments') ? 'show' : null }}">
                                    @can('view-debtor-payments')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('flex.all-customer-payments') || request()->routeIs('flex.initiated-show') ? 'active' : null }}"
                                                href="{{ route('flex.all-customer-payments') }}">
                                                <i class="ph-user"></i>
                                                Debtor Payment
                                            </a>
                                        </li>
                                    @endcan

                                    {{-- Start of Project Invoice --}}
                                    @can('view-project-payments')
                                        <li class="nav-item ">
                                            <a href="{{ route('finance.all-projects') }}"
                                                class="nav-link  {{ request()->routeIs('finance.view-invoice') || request()->routeIs('finance.create-invoice') || request()->routeIs('finance.edit-invoice') || request()->routeIs('finance.trip-detail') || request()->routeIs('finance.all-projects') ? 'active' : null }}">
                                                <i class="ph ph-files"></i>
                                                <span>Project Invoices </span>
                                            </a>
                                        </li>
                                        {{-- / --}}
                                        {{-- Start of Project Receipts --}}
                                        <li class="nav-item ">
                                            <a href="{{ route('finance.all-project-invoices') }}"
                                                class="nav-link  {{ request()->routeIs('finance.single-project-invoice') || request()->routeIs('finance.all-trip-invoices') ? 'active' : null }}">
                                                <i class="ph-receipt"></i>
                                                <span>Project Receipts </span>
                                            </a>
                                        </li>
                                        {{-- For Debit Note --}}
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('flex.project-all-debit-notes', 'flex.project-create-debit-note', 'flex.project-view-debit-note') ? 'active' : null }}"
                                                href="{{ route('flex.project-all-debit-notes') }}">
                                                <i class="ph-file-pdf"></i>
                                                Project Debit Notes
                                            </a>
                                        </li>
                                        {{--  --}}
                                        {{-- For Credit Note --}}
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('flex.all-credit-notes', 'flex.create-credit-note') ? 'active' : null }}"
                                                href="{{ route('flex.project-all-credit-notes') }}">
                                                <i class="ph-file-pdf"></i>
                                                Project Credit Notes
                                            </a>
                                        </li>
                                        {{-- ./ --}}
                                    @endcan
                                    {{-- / --}}
                                </ul>
                            </li>
                        @endcan
                        {{-- ./ --}}

                    @can('view-products')


                        {{-- =============================================== Flex ERP PRODUCTS  Menus ============================================== --}}
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">PRODUCTS</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>

                        {{-- For Product Management Menu --}}
                        <li class="nav-item ">
                            <a href="{{ route('products.index') }}"
                                class="nav-link  {{ request()->routeIs('products.index') ||
                                request()->routeIs('products.create') ||
                                request()->routeIs('products.edit') ||
                                request()->routeIs('products.show')
                                    ? 'active'
                                    : null }}">
                                <i class="ph-folder"></i>

                                <span>Products Menu </span>
                            </a>
                        </li>
                        {{-- ./ --}}

                    @endcan


                        @can('view-subscriptions')

                        {{-- =============================================== Flex ERP SUBSCRIPTION  Menus ============================================== --}}
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">SUBSCRIPTION</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>


                        {{-- For Subscription Management Menu --}}
                        <li class="nav-item ">
                            <a href="{{ route('subscriptions.index') }}"
                                class="nav-link  {{ request()->routeIs('subscriptions.index') ||
                                request()->routeIs('subscriptions.create') ||
                                request()->routeIs('subscriptions.edit') ||
                                request()->routeIs('subscriptions.show')
                                    ? 'active'
                                    : null }}">
                                <i class="ph-wallet"></i>

                                <span>Subscription Menu </span>
                            </a>
                        </li>
                        {{-- ./ --}}

                        {{-- For Subscription Report --}}
                        <li class="nav-item ">
                            <a href="{{ route('product-subscriptions.payments') }}"
                                class="nav-link  {{ request()->routeIs('product-subscriptions.payments') ||
                                request()->routeIs('product-subscriptions.add-payment') ||
                                request()->routeIs('product-subscriptions.edit-payment')
                                    ? 'active'
                                    : null }}">
                                <i class="ph-receipt"></i>

                                <span>Subscription Payments </span>
                            </a>
                        </li>
                        {{-- ./ --}}

                        {{-- For Subscription Report --}}
                        <li class="nav-item ">
                            <a href="{{ route('product-subscriptions.report') }}"
                                class="nav-link  {{ request()->routeIs('product-subscriptions.report') ? 'active' : null }}">
                                <i class="ph-file-pdf"></i>

                                <span>Subscription Report </span>
                            </a>
                        </li>
                        {{-- ./ --}}

                        @endcan


                        {{-- End of Subscription Section --}}

                        {{-- For Driver Management --}}

                        @include('layouts.shared.driver_management_menu')

                        {{-- =============================================== Flex Performance Menus ============================================== --}}

                        {{-- Start of Finance Menu --}}
                        @can('finance-breakdowns')


                            <li
                                class="nav-item nav-item-submenu {{ request()->routeIs('flex.workshop.breakdown.finance') || request()->routeIs('flex.workshop.breakdown.finance') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'nav-item-expand nav-item-open' : null }}">

                                <a href="#" class="nav-link">
                                    <i class="ph-gear"></i>
                                    <span> Workshop Expenses</span>
                                </a>

                                <ul
                                    class="nav-group-sub collapse {{ request()->routeIs('flex.workshop.breakdown.finance') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'show' : null }}">
                                    @can('finance-breakdowns')
                                        <li class="nav-item ">
                                            <a href="{{ route('flex.workshop.breakdown.finance') }}"
                                                class="nav-link  {{ request()->routeIs('flex.workshop.breakdown.finance') ? 'active' : null }}">
                                                {{-- <i class="ph-gear"></i> --}}
                                                <span>Breakdowns Expenses </span>
                                            </a>
                                        </li>
                                    @endcan



                                    {{-- @can('finance-breakdowns') --}}
                                    <li class="nav-item ">
                                        <a href="{{ route('flex.finance_assignment') }}"
                                            class="nav-link  {{ request()->routeIs('flex.workshop.breakdown.finance_assignment') ? 'active' : null }}">
                                            {{-- <i class="ph-wrench"></i> --}}
                                            <span>Assignment Expenses</span>
                                        </a>
                                    </li>
                                    {{-- @endcan --}}
                                </ul>
                            </li>

                        @endcan

                        {{-- =============================================== Flex ERP CRM  Menus ============================================== --}}





                    {{-- start of Old Performance Menus --}}

                    {{-- <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.performance') || request()->routeIs('flex.performance-report') || request()->routeIs('flex.projects') || request()->routeIs('flex.tasks') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-folder"></i>
                            <span>Performance Management</span>
                        </a>
                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.performance') || request()->routeIs('flex.performance-report') || request()->routeIs('flex.tasks') || request()->routeIs('flex.projects') ? 'show' : null }}">
                            <li class="nav-item">
                                <a href="{{ route('flex.projects') }}"
                                    class="nav-link {{ request()->routeIs('flex.projects') ? 'active' : null }}">
                                    Projects
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.tasks') }}"
                                    class="nav-link {{ request()->routeIs('flex.tasks') ? 'active' : null }}">
                                    Adhoc Tasks
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.performance') }}"
                                    class="nav-link {{ request()->routeIs('flex.performance') ? 'active' : null }}">
                                    Performance Ratios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('flex.performance-report') }}"
                                    class="nav-link {{ request()->routeIs('flex.performance-report') ? 'active' : null }} ">
                                    Performance Matrix
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- ./ end of old performance Menus --}}


                    {{-- =============================================== Old ERP Menus============================================== --}}














                    {{-- Start of Fleet Menu --}}
                    @can('view-fleet-menu')
                        {{-- Start of Operation Management --}}
                        @include('layouts.shared.operation-menu')
                        {{-- / --}}
                    @endcan

                    {{-- ./ --}}







                    {{-- Start of Asset Menu --}}
                    @can('view-asset-menu')
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Asset Management</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">
                                <i class="ph-armchair"></i>
                                <span>Assets Management</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.edit-employee') || request()->routeIs('flex.view-employee') || request()->routeIs('flex.terminated-employees') || request()->routeIs('flex.suspended-employees') || request()->routeIs('flex.add-employee') || request()->routeIs('flex.active-employees') || request()->routeIs('flex.suspended-employees') ? 'show' : null }}">

                                @include('layouts.shared.asset-menu')

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}




                    {{-- Start of Workshop Menus --}}
                    @can('view-workshop-menu')
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link">
                                <i class="ph-house"></i>
                                <span>Workshop Menu</span>
                            </a>
                            <ul
                                class="nav-group-sub collapse  {{ request()->routeIs('flex.workshop.checklist') ||
                                request()->routeIs('flex.workshop.checklist.create') ||
                                request()->routeIs('flex.workshop.checklist.show') ||
                                request()->routeIs('flex.workshop.checklist.show.single') ||
                                request()->routeIs('flex.workshop.checklist.edit') ||
                                request()->routeIs('flex.workshop.jobcard') ||
                                request()->routeIs('flex.workshop.jobcard.view') ||
                                request()->routeIs('flex.workshop.jobcard.edit') ||
                                request()->routeIs('flex.workshop.maintanance') ||
                                request()->routeIs('flex.workshop.maintanance.view') ||
                                request()->routeIs('flex.workshop.maintanance.create') ||
                                request()->routeIs('flex.workshop.maintanance.edit') ||
                                request()->routeIs('flex.workshop.maintanance.show.single') ||
                                request()->routeIs('flex.workshop.maintanance.show')
                                    ? 'show'
                                    : null }}">
                                @include('layouts.shared.workshop-menu')

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}

                    {{-- start of Company Documents --}}
                    {{-- @can('view-licences') --}}
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('licences.index') ||
                        request()->routeIs('truck-licences.create') ||
                        request()->routeIs('truck-licences.edit') ||
                        request()->routeIs('truck-licences.show') ||
                        request()->routeIs('truck-licences.index')
                            ? 'nav-item-expand nav-item-open'
                            : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-folder"></i>
                            <span>Company Documents</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse  {{ request()->routeIs('licences.index') ||
                            request()->routeIs('truck-licences.create') ||
                            request()->routeIs('truck-licences.edit') ||
                            request()->routeIs('truck-licences.show') ||
                            request()->routeIs('truck-licences.index')
                                ? 'show'
                                : null }}">

                            {{-- For All Licences --}}
                            @can('view-pods')
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('flex.pod-all-customers') }}">
                                        PODS
                                    </a>
                                </li>
                            @endcan
                            {{-- ./ --}}

                            {{-- For Truck Licences --}}
                            {{-- @can('view-truck-licences') --}}
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('flex.contracts-all-customers') }}">
                                    Contracts
                                </a>
                            </li>
                            {{-- @endcan --}}

                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('flex.all-certificates') }}">
                                    Certificates
                                </a>
                            </li>


                        </ul>
                    </li>
                    {{-- @endcan --}}
                    {{-- ./ --}}

                     {{-- start of Store Categories link --}}
                     <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs(' flex.requirements') ? 'active' : null }}"
                            href="{{ route('flex.requirements') }}">
                            <i class="ph-folder"></i>

                            ERP Documentation
                        </a>
                    </li>
                    {{--  / --}}

                    @can('view-settings-menu')
                        {{-- <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.finance-reports') ||
                            request()->routeIs('flex.operation-reports') ||
                            request()->routeIs('flex.workshop-reports') ||
                            request()->routeIs('truck-licences.show') ||
                            request()->routeIs('truck-licences.index')
                                ? 'nav-item-expand nav-item-open'
                                : null }}">
                            <a href="#" class="nav-link">
                                <i class="ph-file-pdf"></i>
                                <span>Reports</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse  {{ request()->routeIs('flex.finance-reports') ||
                                request()->routeIs('flex.operation-reports') ||
                                request()->routeIs('flex.procurement-reports') ||
                                request()->routeIs('flex.workshop-reports') ||
                                request()->routeIs('truck-licences.index')
                                    ? 'show'
                                    : null }}">

                                <li class="nav-item">
                                    <a class="nav-link  {{ request()->routeIs('flex.finance-reports') ? 'active' : null }} "
                                        href="{{ route('flex.finance-reports') }}">
                                        Finance Reports
                                    </a>
                                </li> --}}

                        {{-- @can('view-licence') --}}
                        {{-- <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.operation-reports') ? 'active' : null }} "
                                        href="{{ route('flex.operation-reports') }}">
                                        Operation Reports
                                    </a>
                                </li> --}}
                        {{-- @endcan --}}
                        {{-- ./ --}}

                        {{-- For Truck Licences --}}
                        {{-- @can('view-truck-licences') --}}
                        {{-- <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.procurement-reports') ? 'active' : null }} "
                                        href="{{ route('flex.procurement-reports') }}">
                                        Procurement Reports
                                    </a>
                                </li> --}}
                        {{-- @endcan --}}

                        {{-- <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.workshop-reports') ? 'active' : null }}"
                                        href="{{ route('flex.workshop-reports') }}">
                                        Workshop Reports
                                    </a>
                                </li> --}}
                        {{-- <li class="nav-item">
                        <a class="nav-link " href="{{ route('flex.pod-all-customers') }}">
                            Other Reports
                        </a>
                    </li> --}}


                        {{-- </ul>
                        </li> --}}




                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Report</div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>
                    @endcan
                    {{-- @can('view-reports') --}}
                    <li class="nav-item ">
                        <a href="{{ route('flex.add-assets') }}"
                            class="nav-link {{ request()->routeIs('flex.add-assets') ? 'active' : null }} ">
                            <i class="ph-file-pdf"></i>
                            <span> Reports</span>
                        </a>
                    </li>
                    {{-- @endcan --}}


                    @can('view-reports-menu1')

                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.financial_reports') || request()->routeIs('flex.organisation_reports') ? 'nav-item-expand nav-item-open' : null }}">
                            <a href="#" class="nav-link">
                                <i class="ph-note"></i>
                                <span>Reports</span>
                            </a>
                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.performance-reports') || request()->routeIs('flex.financial_reports') || request()->routeIs('flex.organisation_reports') ? 'show' : null }}">

                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.financial_reports') ? 'active' : null }}"
                                        href="{{ route('flex.financial_reports') }}">Statutory Reports </a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.organisation_reports') ? 'active' : null }}"
                                        href="{{ route('flex.organisation_reports') }}">Organisation Reports </a>
                                </li>

                                @can('view-reports')
                                    <li class="nav-item ">
                                        <a href="{{ route('flex.add-assets') }}"
                                            class="nav-link {{ request()->routeIs('flex.add-assets') ? 'active' : null }} ">
                                            {{-- <i class="ph-file-pdf"></i> --}}
                                            <span>Enterprise Reports</span>
                                        </a>
                                    </li>
                                @endcan

                                <li class="nav-item">
                                    <a href="{{ route('reports::index') }}" class="nav-link {">
                                        {{-- <i class="ph-notepad"></i> --}}
                                        <span class="text-sm font-medium responsive-side-text">Assets Reports</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan




                    @can('view-settings-menu')
                        <li class="nav-item-header">
                            <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Settings </div>
                            <i class="ph-dots-three sidebar-resize-show"></i>
                        </li>

                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.edit-employee') ||
                            request()->routeIs('users.index') ||
                            request()->routeIs('flex.view-employee') ||
                            request()->routeIs('flex.add-employee') ||
                            request()->routeIs('flex.suspended-employees') ||
                            request()->routeIs('flex.active-employees')
                                ? 'nav-item-expand nav-item-open'
                                : null }}">
                            <a href="#" class="nav-link  ">
                                <i class="ph-gear"></i>
                                <span>Settings</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.edit-employee') ||
                                request()->routeIs('users.index') ||
                                request()->routeIs('flex.view-employee') ||
                                request()->routeIs('flex.terminated-employees') ||
                                request()->routeIs('flex.suspended-employees') ||
                                request()->routeIs('flex.add-employee') ||
                                request()->routeIs('flex.active-employees') ||
                                request()->routeIs('flex.suspended-employees')
                                    ? 'show'
                                    : null }}">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.brand_settings') ? 'active' : null }}"
                                        href="{{ route('flex.brand_settings') }}">
                                        <i class="ph-paint-brush-household"></i> Brand Settings
                                    </a>
                                </li>

                                @can('manage-access')
                                    <li
                                        class="nav-item nav-item-submenu {{ request()->routeIs('users.index') ||
                                        request()->routeIs('flex.add-role') ||
                                        request()->routeIs('flex.edit-role') ||
                                        request()->routeIs('roles.index') ||
                                        request()->routeIs('permissions.index') ||
                                        request()->routeIs('flex.add-customer') ||
                                        request()->routeIs('flex.edit-customer') ||
                                        request()->routeIs('flex.edit-customer')
                                            ? 'nav-item-expand nav-item-open'
                                            : null }}">
                                        <a href="#" class="nav-link">
                                            <i class="ph ph-shield-checkered"></i>
                                            <span>Access Control</span>
                                        </a>

                                        <ul
                                            class="nav-group-sub collapse {{ request()->routeIs('users.index') ||
                                            request()->routeIs('flex.add-role') ||
                                            request()->routeIs('flex.edit-role') ||
                                            request()->routeIs('roles.index') ||
                                            request()->routeIs('permissions.index') ||
                                            request()->routeIs('flex.add-customer') ||
                                            request()->routeIs('flex.edit-customer')
                                                ? 'show'
                                                : null }}">
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : null }}"
                                                    href="{{ url('users') }}">
                                                    {{ __('User') }} Role
                                                </a>
                                            </li>

                                            <li class=" nav-item"><a
                                                    class="nav-link {{ request()->routeIs('roles.index') || request()->routeIs('flex.add-role') || request()->routeIs('flex.edit-role') ? 'active' : null }} "
                                                    href="{{ url('roles') }}">
                                                    Roles</a>
                                            </li>
                                            <li class=" nav-item {{ request()->routeIs('flex.all-modules') ? 'active' : null }} ">
                                                <a class="nav-link " href="{{ url('modules/all_modules') }}">
                                                    Modules
                                                </a>
                                            </li>
                                            <li
                                                class=" nav-item {{ request()->routeIs('permissions.index') ? 'active' : null }} ">
                                                <a class="nav-link " href="{{ url('permissions') }}">
                                                    Permission
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan
                                @can('view-settings-menu')
                                    {{-- For Payroll Inputs --}}
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('payroll_input_ledgers.index') ? 'active' : null }}"
                                            href="{{ route('payroll_input_ledgers.index') }}">
                                            <i class="ph-printer"></i>
                                            Payroll Ledgers
                                        </a>
                                    </li>

                                    {{-- ./ --}}
                                @endcan
                                <li
                                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.edit-employee') || request()->routeIs('flex.view-employee') || request()->routeIs('flex.add-employee') || request()->routeIs('flex.suspended-employees') || request()->routeIs('flex.active-employees') ? 'nav-item-expand nav-item-open' : null }}">
                                    <a href="#" class="nav-link  ">
                                        <i class="ph-users"></i>
                                        <span>HR System</span>
                                    </a>

                                    <ul
                                        class="nav-group-sub collapse {{ request()->routeIs('flex.edit-employee') || request()->routeIs('flex.view-employee') || request()->routeIs('flex.terminated-employees') || request()->routeIs('flex.suspended-employees') || request()->routeIs('flex.add-employee') || request()->routeIs('flex.active-employees') || request()->routeIs('flex.suspended-employees') ? 'show' : null }}">




                                        @can('view-organization')
                                            <li
                                                class="nav-item nav-item-submenu {{ request()->routeIs('flex.department') || request()->routeIs('flex.costCenter') || request()->routeIs('flex.branch') || request()->routeIs('flex.position') || request()->routeIs('flex.contract') || request()->routeIs('flex.organization_level') || request()->routeIs('flex.organization_structure') || request()->routeIs('flex.accounting_coding') ? 'nav-item-expand nav-item-open' : null }}">
                                                <a href="#" class="nav-link">
                                                    {{-- <i class="ph-buildings"></i> --}}
                                                    <span>Organisation</span>
                                                </a>
                                                <ul
                                                    class="nav-group-sub collapse {{ request()->routeIs('flex.department') || request()->routeIs('flex.costCenter') || request()->routeIs('flex.branch') || request()->routeIs('flex.position') || request()->routeIs('flex.contract') || request()->routeIs('flex.organization_level') || request()->routeIs('flex.organization_structure') || request()->routeIs('flex.accounting_coding') ? 'show' : null }}">

                                                    <li class="nav-item"><a
                                                            class="nav-link {{ request()->routeIs('flex.department') ? 'active' : null }}"
                                                            href="{{ route('flex.department') }}">Departments </a></li>
                                                    <li class="nav-item"><a
                                                            class="nav-link {{ request()->routeIs('flex.costCenter') ? 'active' : null }}"
                                                            href="{{ route('flex.costCenter') }}">Cost Center </a></li>
                                                    <li class="nav-item"><a
                                                            class="nav-link {{ request()->routeIs('flex.branch') ? 'active' : null }}"
                                                            href="{{ route('flex.branch') }}">Company Branches </a></li>
                                                    <li class="nav-item"><a
                                                            class="nav-link {{ request()->routeIs('flex.position') ? 'active' : null }}"
                                                            href="{{ route('flex.position') }}">Positions</a></li>


                                                </ul>
                                            </li>
                                            @can('view-setting')
                                                <li
                                                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.companyInfo') || request()->routeIs('bot.botIndex') || request()->routeIs('flex.updatecompanyInfo') || request()->routeIs('flex.leave-approval') || request()->routeIs('flex.erp.approvals') || request()->routeIs('users.index') || request()->routeIs('permissions.index') || request()->routeIs('flex.roles.index') || request()->routeIs('flex.email-notifications') || request()->routeIs('flex.holidays') || request()->routeIs('flex.permissions') || request()->routeIs('role') || request()->routeIs('flex.bank') || request()->routeIs('flex.audit_logs') || request()->routeIs('payroll.mailConfiguration') ? 'nav-item-expand nav-item-open' : null }}">
                                                    <a href="#" class="nav-link">
                                                        {{-- <i class="ph-gear-six"></i> --}}
                                                        <span>Other</span>
                                                    </a>

                                                    <ul
                                                        class="nav-group-sub collapse {{ request()->routeIs('flex.companyInfo') || request()->routeIs('bot.botIndex') || request()->routeIs('flex.companyInfo') || request()->routeIs('flex.updatecompanyInfo') || request()->routeIs('flex.leave-approval') || request()->routeIs('flex.erp.approvals') || request()->routeIs('users.index') || request()->routeIs('permissions.index') || request()->routeIs('roles.index') || request()->routeIs('flex.email-notifications') || request()->routeIs('flex.holidays') || request()->routeIs('flex.financial_group') || request()->routeIs('flex.bank') || request()->routeIs('flex.audit_logs') || request()->routeIs('payroll.mailConfiguration') ? 'show' : null }}">
                                                        @if (session('mng_roles_grp'))
                                                            <li class="nav-item"><a
                                                                    class="nav-link {{ request()->routeIs('flex.companyInfo') ? 'active' : null }}"
                                                                    href="{{ route('flex.companyInfo') }}">Company Info</a></li>
                                                        @endif






                                                        <li class=" nav-item"><a
                                                                class="nav-link {{ request()->routeIs('roles.index') ? 'active' : null }} "
                                                                href="{{ url('roles') }}">
                                                                Roles</a>
                                                        </li>



                                                        <li
                                                            class=" nav-item {{ request()->routeIs('permissions.index') ? 'active' : null }} ">
                                                            <a class="nav-link " href="{{ url('permissions') }}">Permission</a>

                                                        </li>

                                                        <li class=" nav-item "><a
                                                                class="nav-link  {{ request()->routeIs('users.index') ? 'active' : null }}"
                                                                href="{{ url('users') }}">{{ __('User') }}
                                                                Management</a>
                                                        </li>
                                                        <li class="nav-item"><a
                                                                class="nav-link {{ request()->routeIs('flex.holidays') ? 'active' : null }}"
                                                                href="{{ route('flex.holidays') }}">Holidays</a>
                                                        </li>


                                                        <li class="nav-item"><a
                                                                class="nav-link {{ request()->routeIs('flex.email-notifications') ? 'active' : null }}"
                                                                href="{{ route('flex.email-notifications') }}">Email Notification</a>
                                                        </li>

                                                        <li class="nav-item"><a
                                                                class="nav-link {{ request()->routeIs('flex.erp.approvals') ? 'active' : null }}"
                                                                href="{{ route('flex.erp.approvals') }}">Approvals</a>
                                                        </li>

                                                        <li class="nav-item"><a
                                                                class="nav-link {{ request()->routeIs('flex.leave-approval') ? 'active' : null }}"
                                                                href="{{ route('flex.leave-approval') }}">Leave Approvals</a>
                                                        </li>

                                                        @if (session('mng_audit'))
                                                            <li class="nav-item"><a
                                                                    class="nav-link {{ request()->routeIs('flex.audit_logs') ? 'active' : null }}"
                                                                    href="{{ route('flex.audit_logs') }}">Audit Trail</a></li>
                                                        @endif

                                                        @if (session('mng_audit'))
                                                            <li class="nav-item"><a
                                                                    class="nav-link {{ request()->routeIs('flex.passwordAutogenerate') ? 'active' : null }}"
                                                                    href="{{ route('flex.passwordAutogenerate') }}">Password
                                                                    Reset</a></li>
                                                        @endif
                                                        @if (session('mng_audit'))
                                                            <li class="nav-item"><a
                                                                    class="nav-link {{ request()->routeIs('bot.botIndex') ? 'active' : null }}"
                                                                    href="{{ route('bot.botIndex') }}">Post data to BOT</a></li>
                                                        @endif

                                                    </ul>
                                                </li>
                                            @endcan


                                        </ul>
                                    </li>
                                @endcan
                                {{-- ./ --}}

                                {{-- Start of ERP setting --}}
                                @can('view-settings')
                                    <li
                                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.positions') ||
                                        request()->routeIs('flex.edit-position') ||
                                        request()->routeIs('flex.add-position') ||
                                        request()->routeIs('flex.company-details') ||
                                        request()->routeIs('flex.edit-company-details') ||
                                        request()->routeIs('flex.add-company-details') ||
                                        request()->routeIs('flex.departments') ||
                                        request()->routeIs('flex.edit-department') ||
                                        request()->routeIs('flex.add-department')
                                            ? 'nav-item-expand nav-item-open'
                                            : null }}">
                                        <a href="#" class="nav-link ">
                                            <i class="ph-gear"></i>
                                            <span>ERP Settings</span>
                                        </a>

                                        <ul
                                            class="nav-group-sub collapse {{ request()->routeIs('flex.positions') ||
                                            request()->routeIs('flex.edit-position') ||
                                            request()->routeIs('flex.add-position') ||
                                            request()->routeIs('flex.company-details') ||
                                            request()->routeIs('flex.edit-company-details') ||
                                            request()->routeIs('flex.add-company-details') ||
                                            request()->routeIs('flex.departments') ||
                                            request()->routeIs('flex.edit-department') ||
                                            request()->routeIs('flex.add-department') ||
                                            request()->routeIs('flex.workshop.setting.inspection.category') ||
                                            request()->routeIs('flex.workshop.setting.inspection.category.create') ||
                                            request()->routeIs('flex.workshop.setting.inspection.category.show') ||
                                            request()->routeIs('flex.workshop.setting.inspection.category.edit') ||
                                            request()->routeIs('flex.workshop.setting.inspection.criteria') ||
                                            request()->routeIs('flex.workshop.setting.inspection.category.create') ||
                                            request()->routeIs('flex.workshop.setting.inspection.category.show') ||
                                            request()->routeIs('flex.workshop.setting.inspection.category.edit') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.category') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.category.create') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.category.show') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.item') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.item.create') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.item.show') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.item.edit') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.item.edit') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.fund') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.fund.create') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.fund.show') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.fund.edit') ||
                                            request()->routeIs('flex.workshop.setting.breakdown.fund.edit')
                                                ? 'show'
                                                : null }} ">
                                            {{-- Start of Organisation settings --}}
                                            @can('view-organisation-setting')
                                                <li
                                                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.positions') || request()->routeIs('flex.edit-position') || request()->routeIs('flex.add-position') || request()->routeIs('flex.company-details') || request()->routeIs('flex.edit-company-details') || request()->routeIs('flex.add-company-details') || request()->routeIs('flex.departments') || request()->routeIs('flex.edit-department') || request()->routeIs('flex.add-department') ? 'nav-item-expand nav-item-open' : null }}">
                                                    <a href="#" class="nav-link ">
                                                        <i class="ph-buildings"></i>
                                                        <span>Organisation </span>
                                                    </a>

                                                    <ul
                                                        class="nav-group-sub collapse {{ request()->routeIs('flex.positions') || request()->routeIs('flex.edit-position') || request()->routeIs('flex.add-position') || request()->routeIs('flex.company-details') || request()->routeIs('flex.edit-company-details') || request()->routeIs('flex.add-company-details') || request()->routeIs('flex.departments') || request()->routeIs('flex.edit-department') || request()->routeIs('flex.add-department') ? 'show' : null }}">
                                                        {{-- start of Company Details Routes link --}}
                                                        @can('view-company-details')
                                                            <li class="nav-item">
                                                                <a class="nav-link {{ request()->routeIs('flex.company-details') || request()->routeIs('flex.edit-company-details') || request()->routeIs('flex.add-company-details') ? 'active' : null }}"
                                                                    href="{{ route('flex.company-details') }}">
                                                                    Company Details
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        {{--  / --}}

                                                        {{-- start of Departments Routes link --}}
                                                        @can('view-departments')
                                                            <li class="nav-item">
                                                                <a class="nav-link  {{ request()->routeIs('flex.departments') || request()->routeIs('flex.edit-department') || request()->routeIs('flex.add-department') ? 'active' : null }}"
                                                                    href="{{ route('flex.departments') }}">
                                                                    Departments
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        {{--  / --}}

                                                        {{-- start of Positions Routes link --}}
                                                        @can('view-positions')
                                                            <li class="nav-item">
                                                                <a class="nav-link {{ request()->routeIs('flex.positions') || request()->routeIs('flex.edit-position') || request()->routeIs('flex.add-position') ? 'active' : null }}"
                                                                    href="{{ route('flex.positions') }}">
                                                                    Positions
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        {{--  / --}}
                                                        {{-- start of Positions Routes link --}}
                                                        @can('view-approvals')
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="{{ route('flex.erp.approvals') }}">
                                                                    Approvals
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        {{--  / --}}

                                                        {{-- start of Allocation Request Routes link --}}
                                                        @can('view-currencies')
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="{{ route('currencies.index') }}">
                                                                    Currencies
                                                                </a>
                                                            </li>
                                                        @endcan

                                                        {{--  --}}
                                                        @can('view-taxes')
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="{{ route('taxes.index') }}">
                                                                    System Taxes
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        {{--  / --}}

                                                    </ul>
                                                </li>
                                            @endcan
                                            {{-- / --}}

                                            {{--  --}}

                                            {{-- Start of Operation Settings --}}
                                            {{-- <li
                                                class="nav-item nav-item-submenu {{ request()->routeIs('flex.trip-requests') || request()->routeIs('flex.allocation-requests') ? 'nav-item-expand nav-item-open' : null }}">
                                                <a href="#" class="nav-link">
                                                    <i class="ph-truck"></i>
                                                    <span>Operation Settings</span>
                                                </a>

                                                <ul
                                                    class="nav-group-sub collapse  {{ request()->routeIs('flex.trip-requests') || request()->routeIs('flex.allocation-requests') ? 'show' : null }}">


                                                    {{--
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ request()->routeIs('flex.common-costs') ? 'active' : null }}"
                                                            href="{{ route('flex.common-costs') }}">
                                                            Common Costs
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link {{ request()->routeIs('flex.offbudgets') ? 'active' : null }}"
                                                            href="{{ route('flex.offbudgets') }}">
                                                            Out of Budgets
                                                        </a>
                                                    </li>


                                                </ul>
                                            </li> --}}
                                            {{-- / --}}


                                            {{-- Start of Accounting Settings settings --}}
                                            @can('view-account-setting1')
                                                <li
                                                    class="nav-item nav-item-submenu {{ request()->routeIs('flex.add-trailer') || request()->routeIs('flex.add-truck') || request()->routeIs('flex.all-trailers') || request()->routeIs('flex.all-trucks') ? 'nav-item-expand nav-item-open' : null }}">
                                                    <a href="#" class="nav-link ">
                                                        <i class="ph-calculator"></i>
                                                        <span>Accounting Settings</span>
                                                    </a>

                                                    <ul
                                                        class="nav-group-sub collapse {{ request()->routeIs('flex.add-trailer') || request()->routeIs('flex.add-truck') || request()->routeIs('flex.all-trailers') || request()->routeIs('flex.all-trucks') ? 'show' : null }}">
                                                        {{-- start of Company Details Routes link --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ route('flex.company-details') }}">
                                                                Accounting Chart
                                                            </a>
                                                        </li>
                                                        {{--  / --}}

                                                        {{-- start of Departments Routes link --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ route('flex.accounting-groups') }}">
                                                                Accounting Groups
                                                            </a>
                                                        </li>
                                                        {{--  / --}}

                                                        {{-- start of Positions Routes link --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ url('/settings/accounting-codes') }}">
                                                                Accounting Codes
                                                            </a>
                                                        </li>
                                                        {{--  / --}}
                                                        {{-- start of Administration Costs link --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="{{ url('/settings/common-admin-costs') }}">
                                                                Administration Costs
                                                            </a>
                                                        </li>
                                                        {{--  / --}}

                                                    </ul>
                                                </li>
                                            @endcan

                                            @can('view-workshop-setting')
                                                <li class="nav-item nav-item-submenu">
                                                    <a href="#" class="nav-link ">
                                                        <i class="ph-wrench"></i>
                                                        <span>Workshop Settings</span>
                                                    </a>
                                                    <ul
                                                        class="nav-group-sub collapse {{ request()->routeIs('flex.workshop.setting.inspection.category') ||
                                                        request()->routeIs('flex.workshop.setting.inspection.category.create') ||
                                                        request()->routeIs('flex.workshop.setting.inspection.category.show') ||
                                                        request()->routeIs('flex.workshop.setting.inspection.category.edit') ||
                                                        request()->routeIs('flex.workshop.setting.inspection.criteria') ||
                                                        request()->routeIs('flex.workshop.setting.inspection.category.create') ||
                                                        request()->routeIs('flex.workshop.setting.inspection.category.show') ||
                                                        request()->routeIs('flex.workshop.setting.inspection.category.edit') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.category') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.category.create') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.category.show') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.item') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.item.create') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.item.show') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.item.edit') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.item.edit') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.fund') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.fund.create') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.fund.show') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.fund.edit') ||
                                                        request()->routeIs('flex.workshop.setting.breakdown.fund.edit')
                                                            ? 'show'
                                                            : null }}">
                                                        <li class="nav-item nav-item-submenu">
                                                            <a href="#" class="nav-link ">
                                                                <i class="ph-wrench"></i>
                                                                <span>Checklist</span>
                                                            </a>
                                                            <ul
                                                                class="nav-group-sub collapse {{ request()->routeIs('flex.workshop.setting.inspection.category') ||
                                                                request()->routeIs('flex.workshop.setting.inspection.category.create') ||
                                                                request()->routeIs('flex.workshop.setting.inspection.category.show') ||
                                                                request()->routeIs('flex.workshop.setting.inspection.category.edit') ||
                                                                request()->routeIs('flex.workshop.setting.inspection.criteria') ||
                                                                request()->routeIs('flex.workshop.setting.inspection.criteria.create') ||
                                                                request()->routeIs('flex.workshop.setting.inspection.criteria.show') ||
                                                                request()->routeIs('flex.workshop.setting.inspection.criteria.edit')
                                                                    ? 'show'
                                                                    : null }}  ">
                                                                {{-- start of Company Details Routes link --}}
                                                                <li class="nav-item">
                                                                    <a class="nav-link {{ request()->routeIs('flex.workshop.setting.inspection.category') ||
                                                                    request()->routeIs('flex.workshop.setting.inspection.category.create') ||
                                                                    request()->routeIs('flex.workshop.setting.inspection.category.show') ||
                                                                    request()->routeIs('flex.workshop.setting.inspection.category.edit')
                                                                        ? 'active'
                                                                        : null }}"
                                                                        href="{{ route('flex.workshop.setting.inspection.category') }}">
                                                                        Inspection Categories
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link  {{ request()->routeIs('flex.workshop.setting.inspection.criteria') ||
                                                                    request()->routeIs('flex.workshop.setting.inspection.criteria.create') ||
                                                                    request()->routeIs('flex.workshop.setting.inspection.criteria.show') ||
                                                                    request()->routeIs('flex.workshop.setting.inspection.criteria.edit')
                                                                        ? 'active'
                                                                        : null }}"
                                                                        href="{{ route('flex.workshop.setting.inspection.criteria') }}">
                                                                        Inspection Criteria
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="nav-item nav-item-submenu">
                                                            <a href="#" class="nav-link ">
                                                                <i class="ph-wrench"></i>
                                                                <span>Breakdown</span>
                                                            </a>
                                                            <ul
                                                                class="nav-group-sub collapse {{ request()->routeIs('flex.workshop.setting.breakdown.category') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.category.create') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.category.show') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.category.edit') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.item') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.item.create') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.item.show') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.item.edit') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.fund') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.fund.create') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.fund.show') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.fund.edit') ||
                                                                request()->routeIs('flex.workshop.setting.breakdown.fund.edit')
                                                                    ? 'show'
                                                                    : null }}">
                                                                <li class="nav-item">
                                                                    <a class="nav-link {{ request()->routeIs('flex.workshop.setting.breakdown.category') ||
                                                                    request()->routeIs('flex.workshop.setting.breakdown.category.create') ||
                                                                    request()->routeIs('flex.workshop.setting.breakdown.category.show') ||
                                                                    request()->routeIs('flex.workshop.setting.breakdown.category.edit')
                                                                        ? 'active'
                                                                        : null }}"
                                                                        href="{{ route('flex.workshop.setting.breakdown.category') }}">
                                                                        Breakdown Categories
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link
                                                                    {{ request()->routeIs('flex.workshop.setting.breakdown.item') ||
                                                                    request()->routeIs('flex.workshop.setting.breakdown.item.create') ||
                                                                    request()->routeIs('flex.workshop.setting.breakdown.item.show') ||
                                                                    request()->routeIs('flex.workshop.setting.breakdown.item.edit')
                                                                        ? 'active'
                                                                        : null }}"
                                                                        href="{{ route('flex.workshop.setting.breakdown.item') }}">
                                                                        Breakdown Item
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->routeIs('flex.logs') ? 'active' : null }}"
                                                        href="{{ route('flex.logs') }}">
                                                        <i class="ph-list"></i>
                                                        System Logs
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link {{ request()->routeIs('flex.all-audit-logs') ? 'active' : null }}"
                                                        href="{{ route('flex.all-audit-logs') }}">
                                                        <i class="ph-list"></i>
                                                        User Logs
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('flex.system-maintenances') }}">
                                                        <i class="ph-warning"></i>
                                                        Maintenance
                                                    </a>
                                                </li>
                                            @endcan











                                            {{-- / --}}

                                            @if (Auth::user()->dept_id == 6 || Auth::user()->dept_id == 7)
                                                {{-- Start of Store Inventory Management --}}
                                                <li
                                                    class="nav-item nav-item-submenu {{ request()->routeIs('retails.index') || request()->routeIs('categories.index') ? 'nav-item-expand nav-item-open' : null }}">
                                                    <a href="#" class="nav-link">
                                                        <i class="ph-house"></i>
                                                        <span>Inventory</span>
                                                    </a>

                                                    <ul
                                                        class="nav-group-sub collapse  {{ request()->routeIs('retails.index') || request()->routeIs('categories.index') ? 'show' : null }}">

                                                        {{-- start of Store Retail link --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ request()->routeIs('retails.index') ? 'active' : null }}"
                                                                href="{{ route('retails.index') }}">
                                                                Retail
                                                            </a>
                                                        </li>
                                                        {{--  / --}}

                                                        {{-- start of Store Categories link --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ request()->routeIs('retail-units.index') ? 'active' : null }}"
                                                                href="{{ route('retail-units.index') }}">
                                                                Retail Units
                                                            </a>
                                                        </li>
                                                        {{--  / --}}

                                                        {{-- start of Store Categories link --}}
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : null }}"
                                                                href="{{ route('categories.index') }}">
                                                                Retail Categories
                                                            </a>
                                                        </li>
                                                        {{--  / --}}

                                                    </ul>
                                                </li>
                                            @endif




                                        </ul>
                                    </li>
                                @endcan
                                {{-- ./ --}}
                            </ul>
                        </li>
                    @endcan
                </ul>
                </li>
            </div>
        </div>
    </div>
@endcan
{{-- /main sidebar --}}
