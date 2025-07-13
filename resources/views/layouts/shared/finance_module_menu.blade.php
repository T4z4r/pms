{{-- These are the menus for the Finance Module of ERP --}}

{{-- Start of Finance Menu --}}
@can('finance-trips')

    {{-- Start of Payables --}}

    {{-- For Operation Payables --}}

    @can('finance-trips')
        <li
            class="nav-item nav-item-submenu {{ request()->routeIs('flex.employee-list') ||
            request()->routeIs('flex.performance-pillars') ||
            request()->routeIs('flex.projects') ||
            request()->routeIs('flex.tasks') ||
            request()->routeIs('flex.projects') ||
            request()->routeIs('flex.tripTruck') ||
            request()->routeIs('finance_trips.tab_index') ||
            request()->routeIs('flex.tripDetails') ||
            request()->routeIs('flex.finance_trips') ||
            request()->routeIs('flex.all_trip_expenses1') ||
            request()->routeIs('upload-requests.*') ||
            request()->routeIs('request-licences.create') ||
            request()->routeIs('request-licences.edit') ||
            request()->routeIs('request-licences.show') ||
            request()->routeIs('request-licences.index') ||
            request()->routeIs('flex.finance-offbudget') ||
            request()->routeIs('flex.payment_history') ||
            request()->routeIs('flex.truck-rescue.request') ||
            request()->routeIs('flex.truck-rescue.request.show')
                ? 'nav-item-expand nav-item-open'
                : null }}">
            <a href="#" class="nav-link">
                <i class="ph-truck"></i>
                <span>Operation Expenses</span>
            </a>
            <ul
                class="nav-group-sub collapse
                {{ request()->routeIs('flex.employee-list') ||
                request()->routeIs('flex.performance-pillars') ||
                request()->routeIs('flex.tasks') ||
                request()->routeIs('flex.projects') ||
                request()->routeIs('flex.tripTruck') ||
                request()->routeIs('finance_trips.tab_index') ||
                request()->routeIs('flex.tripDetails') ||
                request()->routeIs('flex.finance_trips') ||
                request()->routeIs('flex.all_trip_expenses1') ||
                request()->routeIs('upload-requests.*') ||
                request()->routeIs('request-licences.create') ||
                request()->routeIs('request-licences.edit') ||
                request()->routeIs('request-licences.show') ||
                request()->routeIs('request-licences.index') ||
                request()->routeIs('flex.finance-offbudget') ||
                request()->routeIs('flex.payment_history') ||
                request()->routeIs('flex.truck-rescue.request') ||
                request()->routeIs('flex.truck-rescue.request.show')
                    ? 'show'
                    : null }}">


                @can('finance-trips')
                    <li class="nav-item ">
                        <a href="{{ route('flex.finance_trips') }}"
                            class="nav-link  {{ request()->routeIs('flex.tripTruck') || request()->routeIs('finance_trips.tab_index') || request()->routeIs('flex.tripDetails') || request()->routeIs('flex.finance_trips') ? 'active' : null }}">
                            <i class="ph-path"></i>
                            <span>Trips </span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item ">
                    <a href="{{ route('flex.all_trip_expenses1') }}"
                        class="nav-link {{ request()->routeIs('flex.all_trip_expenses1') ? 'active' : null }}">
                        <i class="ph-calculator me-2"></i>
                        <span>Trip Expenses </span>
                    </a>
                </li>


                {{-- Start of Parking Fee Management --}}
                <li class="nav-item ">
                    <a href="{{ route('upload-requests.index') }}"
                        class="nav-link  {{ request()->routeIs('upload-requests.*') ? 'active' : null }}">
                        <i class="ph-wallet"></i>
                        <span>Bulk Request </span>
                    </a>
                </li>
                {{-- / --}}

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
                            <i class="ph-receipt"></i>

                            Licences Request
                        </a>
                    </li>
                @endcan
                {{-- ./ --}}

                {{-- Start of Finance Off Budgets --}}
                @can('finance-offbudgets')
                    <li class="nav-item ">
                        <a href="{{ route('flex.finance-offbudget') }}"
                            class="nav-link {{ request()->routeIs('flex.finance-offbudget') ? 'active' : null }} ">
                            <i class="ph-money"></i>
                            <span>Out of budgets</span>
                        </a>
                    </li>
                @endcan
                {{-- / --}}
                {{-- For Payment History --}}
                <li class="nav-item ">
                    <a href="{{ route('flex.payment_history') }}"
                        class="nav-link {{ request()->routeIs('flex.payment_history') ? 'active' : null }}">
                        <i class="ph-list me-2"></i>
                        <span>Payment History</span>
                    </a>
                </li>

                {{-- ./ --}}

                {{-- Start of Truck Rescue Requests --}}
                @can('view-truck-rescue-request')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.truck-rescue.request') || request()->routeIs('flex.truck-rescue.request.show')
                            ? 'active'
                            : null }}"
                            href="{{ route('flex.truck-rescue.request') }}">
                            <i class="ph-truck"></i>
                            Truck Rescues
                        </a>
                    </li>
                @endcan

            </ul>
        </li>
    @endcan
    {{-- ./ --}}
    {{-- ./ --}}

    <li
        class="nav-item nav-item-submenu
        {{ request()->routeIs('flex.all-customer-payments') ||
        request()->routeIs('flex.initiated-show') ||
        request()->routeIs('finance.view-invoice') ||
        request()->routeIs('finance.create-invoice') ||
        request()->routeIs('finance.edit-invoice') ||
        request()->routeIs('finance.trip-detail') ||
        request()->routeIs('finance.all-trips') ||
        request()->routeIs('finance.single-trip-invoice') ||
        request()->routeIs('finance.all-trip-invoices') ||
        request()->routeIs('flex.all-debit-notes', 'flex.create-debit-note', 'flex.view-debit-note') ||
        request()->routeIs('flex.all-credit-notes', 'flex.create-credit-note') ||
        request()->routeIs('flex.debit-note-payments') ||
        request()->routeIs('finance.customer-invoice') ||
        request()->routeIs('finance.create-customer-invoice') ||
        request()->routeIs('finance.customer-receipts') ||
        request()->routeIs('finance.create-customer-receipts') ||
        request()->routeIs('customer-credit-notes.index') ||
        request()->routeIs('flex.show-customer-payments') 

            ? 'nav-item-expand nav-item-open'
            : null }}">

        <a href="#" class="nav-link">
            <i class="ph-receipt"></i>
            <span> Trip Debtor Payments</span>
        </a>

        <ul
            class="nav-group-sub collapse
        {{ request()->routeIs('flex.all-customer-payments') ||
        request()->routeIs('flex.initiated-show') ||
        request()->routeIs('finance.view-invoice') ||
        request()->routeIs('finance.create-invoice') ||
        request()->routeIs('finance.edit-invoice') ||
        request()->routeIs('finance.trip-detail') ||
        request()->routeIs('finance.all-trips') ||
        request()->routeIs('finance.single-trip-invoice') ||
        request()->routeIs('finance.all-trip-invoices') ||
        request()->routeIs('flex.all-debit-notes', 'flex.create-debit-note', 'flex.view-debit-note') ||
        request()->routeIs('flex.all-credit-notes', 'flex.create-credit-note') ||
        request()->routeIs('flex.debit-note-payments') ||
        request()->routeIs('finance.customer-invoice') ||
        request()->routeIs('finance.create-customer-invoice') ||
        request()->routeIs('finance.customer-receipts') ||
        request()->routeIs('finance.create-customer-receipts') ||
        request()->routeIs('customer-credit-notes.*') ||
        request()->routeIs('customer-debit-notes.*') ||
        request()->routeIs('flex.show-customer-payments') 
            ? 'show'
            : null }}">



            @can('view-debtor-payments')
                <li class="nav-item">
                    <a class="nav-link {{ 
                    request()->routeIs('flex.all-customer-payments') ||
                     request()->routeIs('flex.show-customer-payments') ||
                       request()->routeIs('flex.initiated-show') 
                        ? 'active'
                        : null }}"
                        href="{{ route('flex.all-customer-payments') }}">
                        <i class="ph-user"></i>
                        Debtor Payment

                    </a>

                </li>
            @endcan



            {{-- Start of Trips Payments --}}
            @can('view-trip-payments')
                <li class="nav-item ">
                    <a href="{{ route('finance.all-trips') }}"
                        class="nav-link
                        {{ request()->routeIs('finance.view-invoice') ||
                        request()->routeIs('finance.create-invoice') ||
                        request()->routeIs('finance.edit-invoice') ||
                        request()->routeIs('finance.trip-detail') ||
                        request()->routeIs('finance.all-trips')
                            ? 'active'
                            : null }}">
                        <i class="ph ph-files"></i>
                        <span>Trips Invoices </span>
                    </a>
                </li>
            @endcan
            {{-- / --}}
            {{-- Start of Trips Payments --}}
            @can('view-trip-payments')
                <li class="nav-item ">
                    <a href="{{ route('finance.all-trip-invoices') }}"
                        class="nav-link  {{ request()->routeIs('finance.single-trip-invoice') || request()->routeIs('finance.all-trip-invoices')
                            ? 'active'
                            : null }}">
                        <i class="ph-receipt"></i>
                        <span>Trips Receipts </span>
                    </a>
                </li>
            @endcan
            {{-- / --}}

            {{-- For Debit Note --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.all-debit-notes', 'flex.create-debit-note', 'flex.view-debit-note') ? 'active' : null }}"
                    href="{{ route('flex.all-debit-notes') }}">
                    <i class="ph-file-pdf"></i>
                    Trip Debit Notes
                </a>
            </li>
            {{-- ./  --}}

            {{-- For Credit Note --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.all-credit-notes', 'flex.create-credit-note') ? 'active' : null }}"
                    href="{{ route('flex.all-credit-notes') }}">
                    <i class="ph-file-pdf"></i>
                    Trip Credit Notes
                </a>
            </li>
            {{-- ./ --}}
            {{-- For  Note --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.debit-note-payments') ? 'active' : null }}"
                    href="{{ route('flex.debit-note-payments') }}">
                    <i class="ph-receipt"></i>
                    Debit Notes Payments
                </a>
            </li>
            {{-- ./ --}}

            {{-- Start of Trips Payments --}}
            @can('view-trip-payments')
                <li class="nav-item ">
                    <a href="{{ route('finance.customer-invoice') }}"
                        class="nav-link  {{ request()->routeIs('finance.customer-invoice') || request()->routeIs('finance.create-customer-invoice')
                            ? 'active'
                            : null }}">
                        <i class="ph ph-files"></i>
                        <span>Customer Invoices </span>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{ route('finance.customer-receipts') }}"
                        class="nav-link  {{ request()->routeIs('finance.customer-receipts') || request()->routeIs('finance.create-customer-receipts')
                            ? 'active'
                            : null }}">
                        <i class="ph ph-receipt"></i>
                        <span>Customer Receipts </span>
                    </a>
                </li>
            @endcan
            {{-- / --}}
            <li class="nav-item ">
                <a href="{{ route('customer-credit-notes.index') }}"
                    class="nav-link  {{ request()->routeIs('customer-credit-notes.index') ? 'active' : null }}">
                    <i class="ph-file-pdf"></i>

                    <span>Customer Credit Notes </span>
                </a>
            </li>


            <li class="nav-item ">
                <a href="{{ route('customer-debit-notes.index') }}"
                    class="nav-link  {{ request()->routeIs('customer-debit-notes.*') ? 'active' : null }}">
                    <i class="ph-file-pdf"></i>

                    <span> Customer Debit Notes </span>
                </a>
            </li>



        </ul>
    </li>

    {{-- ./ --}}



    {{-- Start of Receivabes --}}

    {{-- ./ --}}


@endcan
