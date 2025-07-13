{{-- This is the system's left sidebar menu blade @Tazar --}}
@php
 use Modules\FlexPerformance\app\Models\BrandSetting;

$brandSetting = BrandSetting::firstOrCreate();
@endphp


@can('view-leftbar')
    <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg bg-main-nav">

        <div class="sidebar-content">

            <div class="sidebar-section">

                <div class="sidebar-section-body d-flex justify-content-center">
                    <div class="">

                    @if ($brandSetting->company_logo)
                    <img src="{{ asset('storage/' . $brandSetting->company_logo) }}" class="image-fluid" width="200px"
                        alt="Flex ERP">
                @else
                <img src="{{ asset('storage/brand_settings/company_logo.png') }}" class="img-fluid  d-sm-none d-md-block" width="100%"
                            height="60px !important">
                @endif
                      
                    </div>
                    <h5 class="sidebar-resize-hide flex-grow-1 my-auto  text-muted"></h5>

                    <div class="">
                        {{--  --}}
                        <button type="button"
                            class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control bg- sidebar-main-resize d-none d-lg-inline-flex">
                            <i class=" ph-arrows-left-right"></i>
                        </button>

                        <button type="button"
                            class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                            <i class="ph-x"></i>
                        </button>
                    </div>
                </div>
            </div>


            <div class="sidebar-section">
                <ul class="nav nav-sidebar main-link" data-nav-type="accordion">
                    {{-- Start of Dashboard --}}
                    <li class="nav-item ">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link  {{ request()->routeIs('profile.index') || request()->routeIs('dashboard') ? 'active' : null }}">
                            <i class="ph-house"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    {{-- Start of My Services --}}
                    <li
                        class="nav-item nav-item-submenu {{ request()->routeIs('flex.my-grievances') || request()->routeIs('flex.biodata') || request()->routeIs('flex.my-pensions') || request()->routeIs('flex.my-overtimes') || request()->routeIs('flex.my-leaves') || request()->routeIs('flex.my-loans') ? 'nav-item-expand nav-item-open' : null }}">
                        <a href="#" class="nav-link">
                            <i class="ph-user"></i>
                            <span>My Services</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.my-grievances') || request()->routeIs('flex.biodata') || request()->routeIs('flex.my-pensions') || request()->routeIs('flex.my-overtimes') || request()->routeIs('flex.my-leaves') || request()->routeIs('flex.my-loans') ? 'show' : null }}">

                            {{-- start of Myservices Menu --}}
                            @include('layouts.shared.myservices-menu')
                            {{-- ./ end of Myservices Menu --}}
                        </ul>
                    </li>
                    {{-- ./ --}}


                    {{-- Start of Management Links --}}
                    @can('view-management')
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">
                                <i class="ph-chalkboard-teacher"></i>
                                <span>Management Menu</span>
                            </a>

                            <ul class="nav-group-sub collapse ">

                                {{-- Start of Management Menu --}}
                                @include('layouts.shared.management-menu')
                                {{-- End of Management Menu --}}


                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}

                    {{-- Start of HR Menu --}}
                    @can('view-human-capital')
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">
                                <i class="ph-users"></i>
                                <span>Human Capital Menu</span>
                            </a>
                            <ul class="nav-group-sub collapse ">


                                {{-- start of workforce management dropdown --}}
                                @can('view-workforce')
                                    @include('layouts.shared.workforce-menu')
                                @endcan
                                {{-- / --}}
                                {{-- start of Loan management --}}
                                @can('view-loan')
                                    <li
                                        class="nav-item nav-item-submenu {{ request()->routeIs('bank-loans') || request()->routeIs('flex.salary_advance') || request()->routeIs('flex.confirmed_loans') ? 'nav-item-expand nav-item-open' : null }}">
                                        <a href="#" class="nav-link">
                                            <i class="ph-bank"></i>
                                            <span>Loan Management</span>
                                        </a>
                                        <ul
                                            class="nav-group-sub collapse {{ request()->routeIs('bank-loans') || request()->routeIs('flex.salary_advance') || request()->routeIs('flex.confirmed_loans') ? 'show' : null }}">
                                            @can('view-bank-loan')
                                                <li class="nav-item"><a
                                                        class="nav-link {{ request()->routeIs('bank-loans') ? 'active' : null }}"
                                                        href="{{ route('bank-loans') }}">Bank Loans</a></li>
                                            @endcan
                                            @can('view-loan')
                                                <li class="nav-item"><a
                                                        class="nav-link {{ request()->routeIs('flex.salary_advance') ? 'active' : null }}"
                                                        href="{{ route('flex.salary_advance') }}">Other Loans(HESLB)</a></li>
                                            @endcan
                                            @can('approve-loan')
                                                <li class="nav-item"><a
                                                        class="nav-link {{ request()->routeIs('flex.confirmed_loans') ? 'active' : null }}"
                                                        href="{{ route('flex.confirmed_loans') }}">Approved Loans</a></li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan
                                {{-- ./ --}}

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}


                    {{-- start of Payroll Menu --}}
                    @can('view-payroll-menu')
                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.submitInputs') || request()->routeIs('pension_receipt.index') || request()->routeIs('flex.financial_group') || request()->routeIs('payroll.payroll') || request()->routeIs('payroll.employee_payslip') || request()->routeIs('payroll.comission_bonus') || request()->routeIs('flex.approved_financial_payments') ? 'nav-item-expand nav-item-open' : null }}">
                            <a href="#" class="nav-link">
                                <i class="ph-calculator"></i>
                                <span>Payroll Menu</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.submitInputs') || request()->routeIs('pension_receipt.index') || request()->routeIs('flex.financial_group') || request()->routeIs('payroll.employee_payslip') || request()->routeIs('payroll.payroll') || request()->routeIs('payroll.employee_payslip') || request()->routeIs('payroll.comission_bonus') || request()->routeIs('flex.approved_financial_payments') ? 'show' : null }}">

                                {{-- Start of Submit Input link --}}
                                @can('view-payslip')
                                    <li class="nav-item"><a
                                            class="nav-link {{ request()->routeIs('flex.submitInputs') ? 'active' : null }}"
                                            href="{{ route('flex.submitInputs') }}"> Submit Inputs </a></li>
                                @endcan
                                {{-- ./ --}}
                                {{-- start of payroll link --}}
                                @can('view-payroll')
                                    <li class="nav-item"><a
                                            class="nav-link {{ request()->routeIs('payroll.payroll') ? 'active' : null }}"
                                            href="{{ route('payroll.payroll') }}"> Payroll </a></li>
                                @endcan
                                {{-- / --}}
                                {{--  start of payroll Approvers link --}}
                                @can('view-pending-payments')
                                    <li class="nav-item"><a
                                            class="nav-link {{ request()->routeIs('flex.approved_financial_payments') ? 'active' : null }}"
                                            href="{{ route('flex.approved_financial_payments') }}">Payroll Approvers </a>
                                    </li>
                                @endcan
                                {{-- ./ --}}


                                {{-- Start of Payroll Inputs link --}}
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.financial_group') ? 'active' : null }}"
                                        href="{{ route('flex.financial_group') }}">Payroll inputs </a></li>

                                {{-- / --}}

                                {{-- start of payslip link  --}}
                                @can('view-payslip')
                                    <li class="nav-item"><a
                                            class="nav-link {{ request()->routeIs('payroll.employee_payslip') ? 'active' : null }}"
                                            href="{{ route('payroll.employee_payslip') }}"> Payslip </a></li>
                                @endcan
                                {{-- ./ --}}





                                @can('view-payslip')
                                    <li class="nav-item"><a
                                            class="nav-link {{ request()->routeIs('pension_receipt.index') ? 'active' : null }}"
                                            href="{{ route('pension_receipt.index') }}"> Upload Pension Receipt </a></li>
                                @endcan

                                @can('view-payslip')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('flex.organisation_reports') ? 'active' : null }}"
                                        href="{{ route('flex.organisation_reports') }}">Reports </a></li>
                                 @endcan
                                {{-- / --}}

                            </ul>
                        </li>
                    @endcan
                    {{-- / --}}


                    {{-- start of Leave Menu --}}
                    @can('view-leave-menu')
                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'nav-item-expand nav-item-open' : null }}">

                            <a href="#" class="nav-link">
                                <i class="ph-calendar-check"></i>
                                <span> Leave Menu</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'show' : null }}">
                                @if (session('mng_attend'))
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                        href="{{ route('attendance.leave') }}">Leave Applications</a>
                                </li>



                                {{--  start of unpaid leaves link --}}
                                @can('view-unpaid-leaves')
                                    <li class="nav-item ">
                                        <a class="nav-link {{ request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') ? 'active' : null }}"
                                            href="{{ route('flex.unpaid_leave') }}">Unpaid Leaves</a>
                                    </li>
                                @endcan
                                {{-- / --}}
                                @can('view-report')
                                    <li class="nav-item"><a
                                            class="nav-link {{ request()->routeIs('attendance.leavereport') ? 'active' : null }}"
                                            href="{{ route('attendance.leavereport') }}">Leave History</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    {{-- / --}}


                    {{--  start of Account Payables --}}

                    @can('finance-trips')
                        {{-- For Trip Payments --}}
                        {{-- <li class="nav-item ">
                            <a href="{{ route('flex.all_trip_expenses') }}"
                                class="nav-link {{ request()->routeIs('flex.all_trip_expenses') ? 'active' : null }}">
                                <i class="ph-wallet me-2"></i>
                                <span>Trip Payments</span>
                            </a>
                        </li> --}}


                        {{-- @can('view-settings-menu') --}}
                        <li class="nav-item ">
                            <a href="{{ route('flex.all_trip_expenses1') }}"
                                class="nav-link {{ request()->routeIs('flex.all_trip_expenses1') ? 'active' : null }}">
                                <i class="ph-wallet me-2"></i>
                                <span>Trip Payments </span>
                            </a>
                        </li>
                        {{-- @endcan --}}


                        {{-- For Payment History --}}
                        <li class="nav-item ">
                            <a href="{{ route('flex.payment_history') }}"
                                class="nav-link {{ request()->routeIs('flex.flex.payment_history') ? 'active' : null }}">
                                <i class="ph-list me-2"></i>
                                <span>Payment History</span>
                            </a>
                        </li>
                    @endcan
                    {{-- ./ --}}



                    {{-- Start of Account Receivables --}}
                    @can('account-receivables-menu')
                        @include('layouts.shared.account-receivables')
                    @endcan

                    {{-- Start of Finance Menu --}}
                    @can('view-finance-menu')

                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.tripTruck') ||
                            request()->routeIs('finance_trips.tab_index') ||
                            request()->routeIs('flex.end_unpaid_leave') ||
                            request()->routeIs('flex.save_unpaid_leave') ||
                            request()->routeIs('flex.add_unpaid_leave') ||
                            request()->routeIs('flex.unpaid_leave') ||
                            request()->routeIs('attendance.leavereport') ||
                            request()->routeIs('flex.finance-offbudget') ||
                            request()->routeIs('finance.view-invoice') ||
                            request()->routeIs('finance.create-invoice') ||
                            request()->routeIs('finance.edit-invoice') ||
                            request()->routeIs('finance.trip-detail') ||
                            request()->routeIs('finance.all-trips') ||
                            request()->routeIs('finance.single-trip-invoice') ||
                            request()->routeIs('finance.all-trip-invoices') ||
                            request()->routeIs('request-licences.create') ||
                            request()->routeIs('request-licences.edit') ||
                            request()->routeIs('request-licences.show') ||
                            request()->routeIs('finance.customer-invoice') ||
                            request()->routeIs('finance.create-customer-invoice') ||
                            request()->routeIs('request-licences.index')
                                ? 'nav-item-expand nav-item-open'
                                : null }}">

                            <a href="#" class="nav-link">
                                <i class="ph-truck"></i>
                                <span> Operation Menu</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.tripTruck') ||
                                request()->routeIs('finance_trips.tab_index') ||
                                request()->routeIs('flex.tripDetails') ||
                                request()->routeIs('flex.finance_trips') ||
                                request()->routeIs('flex.finance-offbudget') ||
                                request()->routeIs('finance.view-invoice') ||
                                request()->routeIs('finance.create-invoice') ||
                                request()->routeIs('finance.edit-invoice') ||
                                request()->routeIs('finance.trip-detail') ||
                                request()->routeIs('finance.all-trips') ||
                                request()->routeIs('finance.single-trip-invoice') ||
                                request()->routeIs('finance.all-trip-invoices') ||
                                request()->routeIs('request-licences.create') ||
                                request()->routeIs('request-licences.edit') ||
                                request()->routeIs('request-licences.show') ||
                                request()->routeIs('finance.customer-invoice') ||
                                request()->routeIs('finance.create-customer-invoice') ||
                                request()->routeIs('request-licences.index')
                                    ? 'show'
                                    : null }}">


                                @can('finance-trips')
                                    <li class="nav-item ">
                                        <a href="{{ route('flex.finance_trips') }}"
                                            class="nav-link  {{ request()->routeIs('flex.tripTruck') || request()->routeIs('finance_trips.tab_index') || request()->routeIs('flex.tripDetails') || request()->routeIs('flex.finance_trips') ? 'active' : null }}">
                                            {{-- <i class="ph-upload"></i> --}}
                                            <span>Trips Expenses </span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- Start of Finance Off Budgets --}}
                                @can('finance-offbudgets')
                                    <li class="nav-item ">
                                        <a href="{{ route('flex.finance-offbudget') }}"
                                            class="nav-link {{ request()->routeIs('flex.finance-offbudget') ? 'active' : null }} ">
                                            {{-- <i class="ph-money"></i> --}}
                                            <span>Out of budget Expenses</span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- / --}}


                                {{-- Start of Trips Payments --}}
                                @can('view-trip-payments')
                                    <li class="nav-item ">
                                        <a href="{{ route('finance.all-trips') }}"
                                            class="nav-link  {{ request()->routeIs('finance.view-invoice') || request()->routeIs('finance.create-invoice') || request()->routeIs('finance.edit-invoice') || request()->routeIs('finance.trip-detail') || request()->routeIs('finance.all-trips') ? 'active' : null }}">
                                            {{-- <i class="ph ph-files"></i> --}}
                                            <span>Trips Invoices </span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- / --}}

                                {{-- Start of Trips Payments --}}
                                @can('view-trip-payments')
                                    <li class="nav-item ">
                                        <a href="{{ route('finance.customer-invoice') }}"
                                            class="nav-link  {{ request()->routeIs('finance.customer-invoice') || request()->routeIs('finance.create-customer-invoice')
                                                ? 'active'
                                                : null }}">
                                            {{-- <i class="ph ph-files"></i> --}}
                                            <span>Customer Invoices </span>
                                        </a>
                                    </li>

                                    <li class="nav-item ">
                                        <a href="{{ route('finance.customer-receipts') }}"
                                            class="nav-link  {{ request()->routeIs('finance.customer-receipts') || request()->routeIs('finance.create-customer-receipts')
                                                ? 'active'
                                                : null }}">
                                            {{-- <i class="ph ph-files"></i> --}}
                                            <span>Customer Receipts </span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- / --}}
                                {{-- Start of Trips Payments --}}
                                @can('view-trip-payments')
                                    <li class="nav-item ">
                                        <a href="{{ route('finance.all-trip-invoices') }}"
                                            class="nav-link  {{ request()->routeIs('finance.single-trip-invoice') || request()->routeIs('finance.all-trip-invoices') ? 'active' : null }}">
                                            {{-- <i class="ph-receipt"></i> --}}
                                            <span>Invoice Receipts </span>
                                        </a>
                                    </li>
                                @endcan
                                {{-- / --}}

                                {{-- For Debit Note --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.all-debit-notes', 'flex.create-debit-note', 'flex.view-debit-note') ? 'active' : null }}"
                                        href="{{ route('flex.all-debit-notes') }}">
                                        {{-- <i class="ph-file-pdf"></i> --}}
                                        Debit Notes
                                    </a>
                                </li>
                                {{-- ./  --}}

                                {{-- For Credit Note --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('flex.all-credit-notes', 'flex.create-credit-note') ? 'active' : null }}"
                                        href="{{ route('flex.all-credit-notes') }}">
                                        {{-- <i class="ph-file-pdf"></i> --}}
                                        Credit Notes
                                    </a>
                                </li>
                                {{-- ./ --}}



                                {{-- For Request Licences --}}
                                @can('view-request-licence')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('request-licences.create') ||
                                        request()->routeIs('request-licences.edit') ||
                                        request()->routeIs('request-licences.show') ||
                                        request()->routeIs('request-licences.index')
                                            ? 'active'
                                            : null }}"
                                            href="{{ route('request-licences.index') }}">
                                            Request Licences
                                        </a>
                                    </li>
                                @endcan
                                {{-- ./ --}}
                                {{-- Start of Truck Rescue Requests --}}
                                @can('view-truck-rescue-request')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('flex.truck-rescue.request') || request()->routeIs('flex.truck-rescue.request.show')
                                            ? 'active'
                                            : null }}"
                                            href="{{ route('flex.truck-rescue.request') }}">
                                            {{-- <i class="ph-truck"></i> --}}
                                            Truck Rescue Requests
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        @can('view-trip-payments')
                            <li class="nav-item nav-item-submenu ">
                                <a href="#" class="nav-link  ">
                                    <i class="ph-receipt"></i>
                                    <span>Customer Notes</span>
                                </a>

                                <ul class="nav-group-sub collapse ">
                                    <li class="nav-item ">
                                        <a href="{{ route('customer-credit-notes.index') }}"
                                            class="nav-link  {{ request()->routeIs('customer-credit-notes.index') ? 'active' : null }}">
                                            <span>Credit Notes </span>
                                        </a>
                                    </li>


                                    <li class="nav-item ">
                                        <a href="{{ route('customer-debit-notes.index') }}"
                                            class="nav-link  {{ request()->routeIs('customer-debit-notes.index') ? 'active' : null }}">
                                            <span>Debit Notes </span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endcan





                        {{-- Start of Parking Fee Management --}}
                        <li class="nav-item ">
                            <a href="{{ route('upload-requests.index') }}"
                                class="nav-link  {{ request()->routeIs('upload-requests.*') ? 'active' : null }}">
                                <i class="ph-wallet"></i>
                                <span>Bulk Request </span>
                            </a>
                        </li>
                        {{-- / --}}

                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.workshop.breakdown.finance') || request()->routeIs('flex.workshop.breakdown.finance') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('attendance.leave') || request()->routeIs('flex.end_unpaid_leave') || request()->routeIs('flex.save_unpaid_leave') || request()->routeIs('flex.add_unpaid_leave') || request()->routeIs('flex.unpaid_leave') || request()->routeIs('attendance.leavereport') ? 'nav-item-expand nav-item-open' : null }}">

                            <a href="#" class="nav-link">
                                <i class="ph-gear"></i>
                                <span> Workshop Menu</span>
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
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">

                                <i class="ph-money"></i>
                                <span>Finance Menu</span>
                            </a>

                            <ul class="nav-group-sub collapse  {{  request()->routeIs('flex.all-customer-payments')
                                ? 'show'
                                : null }}">
                                @include('layouts.shared.finance-menu')

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}
                    @can('view-finance-menu')
                        {{-- For Payroll Inputs --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('finance_payroll_input_ledgers.index') ? 'active' : null }}"
                                href="{{ route('finance_payroll_input_ledgers.index') }}">
                                <i class="ph-printer"></i>
                                Payroll Expenses
                            </a>
                        </li>

                        {{-- ./ --}}
                    @endcan



                    {{-- Start of Vendor Menus --}}
                    @can('view-vendors-menu')
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">
                                <i class="ph-users-three"></i>
                                <span>Vendors Menu</span>
                            </a>

                            <ul class="nav-group-sub collapse ">
                                @include('layouts.shared.vendors-menu')

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}


                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('advance_payment_requests.index', 'advance_payment_requests.show', 'advance_payment_requests.edit', 'advance_payment_requests.create') ? 'active' : null }}"
                            href="{{ route('advance_payment_requests.index') }}">
                            <i class="ph-wallet"></i>
                            Trip Advances
                        </a>
                    </li> --}}

                    {{-- For Deduction Requests --}}
                    @can('view-finance-menu')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.finance-driver-retirements') ? 'active' : null }}"
                                href="{{ route('flex.finance-driver-retirements') }}">
                                <i class="ph-receipt"></i>
                                Deductions Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.finance-return-requests') ? 'active' : null }}"
                                href="{{ route('flex.finance-return-requests') }}">
                                <i class="ph-users"></i>
                                Driver Returns
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link
                            {{
                            request()->routeIs('flex.all-deductions-reviews')||
                            request()->routeIs('flex.all-deductions-reviews.show')||
                            request()->routeIs('flex.all-deductions-reviews.edit')
                            ? 'active' : null }}"
                                href="{{ route('flex.all-deductions-reviews') }}">
                                <i class="ph-folder"></i>
                                Deductions Review
                            </a>
                        </li>
                    @endcan
                    {{-- ./ --}}
                    {{-- Start of Retirement Management --}}
                    @can('view-retirements')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.driver-debts')|| request()->routeIs('flex.driver-opening-balance') ? 'active' : null }}"
                                href="{{ route('flex.driver-debts') }}">
                                <i class="ph-archive-box"></i>
                                <span>Driver Debts </span>
                            </a>
                        </li>
                    @endcan
                    {{-- ./ --}}
                    {{-- For Deduction LPO --}}
                    @can('view-procurement-menu')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.procurement-driver-retirements') ? 'active' : null }}"
                                href="{{ route('flex.procurement-driver-retirements') }}">
                                <i class="ph-receipt"></i>
                                Deduction LPO
                            </a>
                        </li>
                    @endcan
                    {{-- ./ --}}



                    {{-- Start of Account Menu --}}
                    @can('view-accounts-menu')
                        @include('layouts.shared.accounts-menu')
                    @endcan
                    {{-- ./ --}}


                    {{-- @can('view-settings-menu') --}}
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
                    {{-- @endcan --}}

                    {{-- Start of Fleet Menu --}}
                    @can('view-fleet-menu')
                        {{-- Start of Operation Management --}}
                        @include('layouts.shared.operation-menu')
                        {{-- / --}}
                    @endcan

                    {{-- ./ --}}

                    {{-- Start of Asset Menu --}}
                    @can('view-asset-menu')
                        <li class="nav-item nav-item-submenu ">
                            <a href="#" class="nav-link  ">
                                <i class="ph-armchair"></i>
                                <span>Asset Menu</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.edit-employee') || request()->routeIs('flex.view-employee') || request()->routeIs('flex.terminated-employees') || request()->routeIs('flex.suspended-employees') || request()->routeIs('flex.add-employee') || request()->routeIs('flex.active-employees') || request()->routeIs('flex.suspended-employees') ? 'show' : null }}">

                                @include('layouts.shared.asset-menu')

                            </ul>
                        </li>
                    @endcan
                    {{-- ./ --}}

                    {{-- For Assets Values --}}
                    @can('view-settings-menu')
                        <li class="nav-item ">
                            <a href="{{ route('flex.all-assets-data') }}"
                                class="nav-link {{ request()->routeIs('flex.flex.payment_history') ? 'active' : null }}">
                                <i class="ph-book me-2"></i>
                                <span>Asset Values</span>
                            </a>
                        </li>
                    @endcan
                    {{-- ./ --}}

                    {{-- start of Procurement Menu --}}
                    @can('view-procurement-menu')
                        {{-- Start of Store & Procurement Management --}}
                        @include('stores.store_menu.store-menu')
                        {{-- /End of Store & Procurement Management --}}
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
                            {{-- @can('view-licence') --}}
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('flex.pod-all-customers') }}">
                                    PODS
                                </a>
                            </li>
                            {{-- @endcan --}}
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

                    @can('view-settings-menu')

                <li
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
                        <a class="nav-link  {{ request()->routeIs('flex.finance-reports') ? 'active': null  }} " href="{{ route('flex.finance-reports') }}">
                            Finance  Reports
                        </a>
                    </li>

                    {{-- @can('view-licence') --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.operation-reports') ? 'active': null  }} " href="{{ route('flex.operation-reports') }}">
                            Operation Reports
                        </a>
                    </li>
                    {{-- @endcan --}}
                    {{-- ./ --}}

                    {{-- For Truck Licences --}}
                    {{-- @can('view-truck-licences') --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.procurement-reports') ? 'active': null  }} " href="{{ route('flex.procurement-reports') }}">
                            Procurement Reports
                        </a>
                    </li>
                    {{-- @endcan --}}

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.workshop-reports') ? 'active': null  }}" href="{{ route('flex.workshop-reports') }}">
                            Workshop Reports
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link " href="{{ route('flex.pod-all-customers') }}">
                            Other Reports
                        </a>
                    </li> --}}


                </ul>
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
                        <li
                            class="nav-item nav-item-submenu {{ request()->routeIs('flex.edit-employee') || request()->routeIs('flex.view-employee') || request()->routeIs('flex.add-employee') || request()->routeIs('flex.suspended-employees') || request()->routeIs('flex.active-employees') ? 'nav-item-expand nav-item-open' : null }}">
                            <a href="#" class="nav-link  ">
                                <i class="ph-gear"></i>
                                <span>Settings</span>
                            </a>

                            <ul
                                class="nav-group-sub collapse {{ request()->routeIs('flex.edit-employee') || request()->routeIs('flex.view-employee') || request()->routeIs('flex.terminated-employees') || request()->routeIs('flex.suspended-employees') || request()->routeIs('flex.add-employee') || request()->routeIs('flex.active-employees') || request()->routeIs('flex.suspended-employees') ? 'show' : null }}">
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{ request()->routeIs('flex.brand_settings') ? 'active' : null }}"
                                        href="{{ route('flex.brand_settings') }}"><i class="ph-paint-brush-household"></i>Brand Settings</a>
                                </li>
    
                                @can('manage-access')
                                    <li
                                        class="nav-item nav-item-submenu {{ request()->routeIs('users.index') || request()->routeIs('flex.add-role') || request()->routeIs('flex.edit-role') || request()->routeIs('roles.index') || request()->routeIs('permissions.index') || request()->routeIs('flex.add-customer') || request()->routeIs('flex.edit-customer') || request()->routeIs('flex.edit-customer') ? 'nav-item-expand nav-item-open' : null }}">
                                        <a href="#" class="nav-link">
                                            <i class="ph ph-shield-checkered"></i>
                                            <span>Access Control</span>
                                        </a>

                                        <ul
                                            class="nav-group-sub collapse  {{ request()->routeIs('users.index') || request()->routeIs('flex.add-role') || request()->routeIs('flex.edit-role') || request()->routeIs('roles.index') || request()->routeIs('permissions.index') || request()->routeIs('flex.add-customer') || request()->routeIs('flex.edit-customer') ? 'show' : null }}">
                                            <li class=" nav-item "><a
                                                    class="nav-link  {{ request()->routeIs('users.index') ? 'active' : null }}"
                                                    href="{{ url('users') }}">

                                                    {{ __('User') }}
                                                    Role </a>
                                            </li>
                                            <li class=" nav-item"><a
                                                    class="nav-link {{ request()->routeIs('roles.index') || request()->routeIs('flex.add-role') || request()->routeIs('flex.edit-role') ? 'active' : null }} "
                                                    href="{{ url('roles') }}">
                                                    Roles</a>
                                            </li>
                                            <li
                                                class=" nav-item {{ request()->routeIs('flex.all-modules') ? 'active' : null }} ">
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
                                                            {{-- <li class="nav-item">
                                                                <a class="nav-link  {{ request()->routeIs('flex.departments') || request()->routeIs('flex.edit-department') || request()->routeIs('flex.add-department') ? 'active' : null }}"
                                                                    href="{{ route('flex.departments') }}">
                                                                    Departments
                                                                </a>
                                                            </li> --}}
                                                        @endcan
                                                        {{--  / --}}

                                                        {{-- start of Positions Routes link --}}
                                                        @can('view-positions')
                                                            {{-- <li class="nav-item">
                                                                <a class="nav-link {{ request()->routeIs('flex.positions') || request()->routeIs('flex.edit-position') || request()->routeIs('flex.add-position') ? 'active' : null }}"
                                                                    href="{{ route('flex.positions') }}">
                                                                    Positions
                                                                </a>
                                                            </li> --}}
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
