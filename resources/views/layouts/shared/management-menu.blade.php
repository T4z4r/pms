{{-- This is the management menu view --}}
@can('view-management-menu')

    {{-- Start of Allocation Requests --}}
    @can('view-requested-allocations')
        <li class="nav-item ">
            <a href="{{ route('flex.allocation-requests') }}"
                class="nav-link  {{ request()->routeIs('flex.allocation-requests') || request()->routeIs('flex.truck-allocation') ? 'active' : null }}">
                <i class="ph-path"></i>
                <span>Allocation Requests</span>
            </a>
        </li>
   

    {{-- Start of Trips --}}
    <li class="nav-item ">
        <a href="{{ route('flex.trips') }}"
            class="nav-link  {{ request()->routeIs('flex.request-trip') || request()->routeIs('flex.trips') ? 'active' : null }}">
            <i class="ph-signpost"></i>
            <span> All Trips </span>
        </a>
    </li>
    {{-- @endif --}}


    {{-- Start of Truck Rescue Requests --}}
    @can('view-truck-rescue-request1')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.truck-rescue.request') || request()->routeIs('flex.truck-rescue.request.show')
                ? 'active'
                : null }}"
                href="{{ route('flex.truck-rescue.request') }}">
                <i class="ph-truck"></i>
                Truck Rescue Requests
            </a>
        </li>
    @endcan

    {{-- ./ --}}


    {{-- @if (Auth::user()->dept_id == 1) --}}
    {{-- Start of Management --}}
    <li class="nav-item ">
        <a href="{{ route('flex.offbudget-requests') }}"
            class="nav-link {{ request()->routeIs('flex.offbudget-requests') ? 'active' : null }} ">
            <i class="ph-money"></i>
            <span>Out of budget Requests</span>
        </a>
    </li>
    {{-- / --}}
    {{-- @endif --}}

    <li class="nav-item ">
        <a href="{{ route('flex.workshop.breakdown.finance') }}"
            class="nav-link  {{ request()->routeIs('flex.workshop.breakdown.finance') ? 'active' : null }}">
            <i class="ph-gear"></i>
            <span>Breakdowns Expenses </span>
        </a>
    </li>


    {{-- @can('finance-breakdowns') --}}
    <li class="nav-item ">
        <a href="{{ route('flex.finance_assignment') }}"
            class="nav-link  {{ request()->routeIs('flex.workshop.breakdown.finance_assignment') ? 'active' : null }}">
            <i class="ph-wrench"></i>
            <span>Assignment Expenses</span>
        </a>
    </li>
    {{-- @endcan --}}

     @endcan


    {{-- Start of Administration Expense Requests --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admistration-expenses.create') ||
        request()->routeIs('admistration-expenses.edit') ||
        request()->routeIs('admistration-expenses.show') ||
        request()->routeIs('admistration-expenses.index')
            ? 'active'
            : null }}"
            href="{{ route('admistration-expenses.index') }}">
            <i class="ph-credit-card"></i>
            <span>Administration Expenses</span>
        </a>
    </li>
    {{-- ./ --}}


    {{-- For Request Licences --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('request-licences.create') ||
        request()->routeIs('request-licences.edit') ||
        request()->routeIs('request-licences.show') ||
        request()->routeIs('request-licences.index')
            ? 'active'
            : null }}"
            href="{{ route('request-licences.index') }}">
            <i class="ph-file me-2"></i>
            Licence Requests
        </a>
    </li>


    {{-- Start of Procurements Approvals --}}

    @can('view-procurement-approvals')
        <li
            class="nav-item nav-item-submenu {{ request()->routeIs('purchases.index') ||
            request()->routeIs('purchases.create') ||
            request()->routeIs('purchases.edit') ||
            request()->routeIs('purchases.show') ||
            request()->routeIs('out-of-stocks.index') ||
            request()->routeIs('service-purchases.edit') ||
            request()->routeIs('service-purchases.show') ||
            request()->routeIs('service-purchases.tab_index') ||
            request()->routeIs('service-purchases.index') ||
            request()->routeIs('flex.initiated-index') ||
            request()->routeIs('flex.initiated-service-index')
                ? 'nav-item-expanded nav-item-open'
                : null }}">
            <a href="#" class="nav-link ">
                <i class="ph-files"></i>
                <span>Vendors Approval</span>
            </a>

            <ul
                class="nav-group-sub collapse {{ request()->routeIs('purchases.index') ||
                request()->routeIs('purchases.create') ||
                request()->routeIs('purchases.edit') ||
                request()->routeIs('purchases.show') ||
                request()->routeIs('out-of-stocks.index') ||
                request()->routeIs('service-purchases.edit') ||
                request()->routeIs('service-purchases.show') ||
                request()->routeIs('service-purchases.tab_index') ||
                request()->routeIs('service-purchases.index') ||
                request()->routeIs('flex.initiated-show') ||
                request()->routeIs('flex.initiated-service-show') ||
                request()->routeIs('flex.initiated-index') ||
                request()->routeIs('flex.initiated-service-index')
                    ? 'show'
                    : null }}">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.initiated-index') || request()->routeIs('flex.initiated-show') ? 'active' : null }}"
                        href="{{ route('flex.initiated-index') }}">
                        Invoices Initiated
                    </a>
                </li>

                <li class="nav-item" hidden>
                    <a class="nav-link {{ request()->routeIs('flex.initiated-service-index') || request()->routeIs('flex.initiated-service-show') ? 'active' : null }}"
                        href="{{ route('flex.initiated-service-index') }}">
                        Initiated Service Invoices
                    </a>
                </li>
            </ul>
        </li>
    @endcan
    {{-- / --}}



@endcan
