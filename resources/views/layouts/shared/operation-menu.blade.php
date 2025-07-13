{{-- This is the file for operation Management side bar --}}
@can('view-operation-management')
    {{-- Start of Truck Management --}}
    @can('view-trucks')
        <li
            class="nav-item nav-item-submenu {{ request()->routeIs('flex.single-truck') || request()->routeIs('flex.add-trailer') || request()->routeIs('flex.add-truck') || request()->routeIs('flex.all-trailers') || request()->routeIs('flex.all-trucks') ? 'nav-item-expand nav-item-open' : null }}">
            <a href="#" class="nav-link ">
                <i class="ph-truck"></i>
                <span>Trucks Management</span>
            </a>

            <ul
                class="nav-group-sub collapse {{ request()->routeIs('flex.single-truck') || request()->routeIs('flex.add-trailer') || request()->routeIs('flex.add-truck') || request()->routeIs('flex.all-trailers') || request()->routeIs('flex.all-trucks') ? 'show' : null }}">
                {{-- start of All Trucks link --}}
                <li class="nav-item ">
                    <a class="nav-link {{ request()->routeIs('flex.single-truck') || request()->routeIs('flex.add-truck') || request()->routeIs('flex.all-trucks') ? 'active' : null }}"
                        href="{{ route('flex.all-trucks') }}">
                        All Trucks
                    </a>
                </li>
                {{--  / --}}

                {{-- start of Trailers link --}}
                @can('view-trailer')
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->routeIs('flex.add-trailer') || request()->routeIs('flex.all-trailers') ? 'active' : null }}"
                            href="{{ route('flex.all-trailers') }}">
                            All Trailers
                        </a>
                    </li>
                @endcan

                {{--  / --}}


            </ul>
        </li>
    @endcan
    {{-- / --}}


    {{-- start of Licence Management --}}
    @can('view-licences')
        <li
            class="nav-item nav-item-submenu {{ request()->routeIs('licences.index') ||
            request()->routeIs('truck-licences.create') ||
            request()->routeIs('truck-licences.edit') ||
            request()->routeIs('truck-licences.show') ||
            request()->routeIs('truck-licences.index') ||
            request()->routeIs('request-licences.create') ||
            request()->routeIs('request-licences.edit') ||
            request()->routeIs('request-licences.show') ||
            request()->routeIs('request-licences.index')
                ? 'nav-item-expand nav-item-open'
                : null }}">
            <a href="#" class="nav-link">
                <i class="ph-credit-card"></i>
                <span>Licence Management</span>
            </a>

            <ul
                class="nav-group-sub collapse  {{ request()->routeIs('licences.index') ||
                request()->routeIs('truck-licences.create') ||
                request()->routeIs('truck-licences.edit') ||
                request()->routeIs('truck-licences.show') ||
                request()->routeIs('truck-licences.index') ||
                request()->routeIs('request-licences.create') ||
                request()->routeIs('request-licences.edit') ||
                request()->routeIs('request-licences.show') ||
                request()->routeIs('request-licences.index')
                    ? 'show'
                    : null }}">

                {{-- For All Licences --}}
                @can('view-licence')
                    <li class="nav-item visually-hidden">
                        <a class="nav-link {{ request()->routeIs('licences.index') ? 'active' : null }}"
                            href="{{ route('licences.index') }}">
                            Licences
                        </a>
                    </li>
                @endcan
                {{-- ./ --}}

                {{-- For Truck Licences --}}
                @can('view-truck-licences')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('truck-licences.create') ||
                        request()->routeIs('truck-licences.edit') ||
                        request()->routeIs('truck-licences.show') ||
                        request()->routeIs('truck-licences.index')
                            ? 'active'
                            : null }}"
                            href="{{ route('truck-licences.index') }}">
                            Truck Licences
                        </a>
                    </li>
                @endcan
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


            </ul>
        </li>
    @endcan
    {{-- ./ --}}



    {{-- Start of Route Management --}}
    @can('view-route-management')
        <li class="nav-item ">
            <a href="{{ route('flex.active-routes') }}"
                class="nav-link  {{ request()->routeIs('flex.view-route') || request()->routeIs('flex.edit-route') || request()->routeIs('flex.add-route') || request()->routeIs('flex.active-routes') ? 'active' : null }}">
                <i class="ph-path"></i>
                <span>Route Management </span>
            </a>
        </li>
    @endcan
    {{-- / --}}

    {{-- Start of Route Management --}}
    {{-- @can('view-route-management') --}}
        <li class="nav-item ">
            <a href="{{ route('flex.truck-change-requests') }}"
                class="nav-link  {{ request()->routeIs('flex.truck-change-requests') ? 'active' : null }}">
                <i class="ph-recycle"></i>
                <span>Truck Change </span>
            </a>
        </li>
    {{-- @endcan --}}
    {{-- / --}}



    {{-- Start of Route Management --}}
    @can('view-route-management')
        <li class="nav-item ">
            <a href="{{ route('flex.all-mobilizations') }}" class="nav-link">
                <i class="ph-path"></i>
                <span>Mobilization Management </span>
            </a>
        </li>
    @endcan
    {{-- / --}}

    {{-- <li class="nav-item ">
        <a href="{{ route('flex.operation-return-costs') }}" class="nav-link">
            <i class="ph-calculator"></i>
            <span>Return Costs </span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.all-return-requests') ? 'active' : null }}"
            href="{{ route('flex.all-return-requests') }}">
            <i class="ph-users"></i>
            Driver Returns
        </a>
    </li>
    {{-- Start of Store Requests --}}
    {{-- @can('view-store-request-management') --}}
    <li class="nav-item">
        <a class="nav-link
            {{ request()->routeIs('flex.request-trip') ||
            request()->routeIs('flex.truck-allocation') ||
            request()->routeIs('flex.view-allocation') ||
            request()->routeIs('flex.add-allocation') ||
            request()->routeIs('flex.trip-requests') ||
            request()->routeIs('flex.allocation-requests') ||
            request()->routeIs('flex.backload-requests') ||
            request()->routeIs('flex.going-trip') ||
            request()->routeIs('flex.backload-trip') ||
            request()->routeIs('flex.truck_cost')
                ? 'nav-item-expand nav-item-open'
                : null }}
            "
            href="{{ route('flex.allocation-lashing-gear-requests') }}">
            <i class="ph-house-simple "></i>
            Lashing Gear Request
        </a>
    </li>
    {{-- @endcan --}}
    {{-- ./ --}}
    @can('manage-trips')
        {{-- Start of Trip Management --}}
        <li
            class="nav-item nav-item-submenu
            {{ request()->routeIs('flex.request-trip') ||
            request()->routeIs('flex.truck-allocation') ||
            request()->routeIs('flex.view-allocation') ||
            request()->routeIs('flex.add-allocation') ||
            request()->routeIs('flex.trip-requests') ||
            request()->routeIs('flex.allocation-requests') ||
            request()->routeIs('flex.backload-requests') ||
            request()->routeIs('flex.going-trip') ||
            request()->routeIs('flex.backload-trip') ||
            request()->routeIs('flex.truck_cost')
                ? 'nav-item-expand nav-item-open'
                : null }}
        ">
            <a href="#" class="nav-link">
                <i class="ph-signpost"></i>
                <span>Trip Management</span>
            </a>

            <ul
                class="nav-group-sub collapse
    {{ request()->routeIs('flex.request-trip') ||
    request()->routeIs('flex.truck-allocation') ||
    request()->routeIs('flex.view-allocation') ||
    request()->routeIs('flex.add-allocation') ||
    request()->routeIs('flex.trip-requests') ||
    request()->routeIs('flex.allocation-requests') ||
    request()->routeIs('flex.backload-requests') ||
    request()->routeIs('flex.going-trip') ||
    request()->routeIs('flex.backload-trip') ||
    request()->routeIs('flex.request-trip') ||
    request()->routeIs('flex.truck_cost')
        ? 'show'
        : null }}">

                @can('manage-allocations')
                    {{-- start of Allocation Request Routes link --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.truck-allocation') || request()->routeIs('flex.request-trip') || request()->routeIs('flex.view-allocation') || request()->routeIs('flex.add-allocation') || request()->routeIs('flex.allocation-requests') || request()->routeIs('flex.truck_cost') ? 'active' : null }}"
                            href="{{ route('flex.allocation-requests') }}">
                            Trip Allocations
                        </a>
                    </li>
                    {{--  / --}}
                @endcan

                {{-- start of Going Load Trip Request link --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.going-trip') || request()->routeIs('flex.trip-requests') ? 'active' : null }}"
                        href="{{ route('flex.trip-requests') }}">
                        GoingLoad Trips
                    </a>
                </li>
                {{--  / --}}

                {{-- start of Back Load Trip Request link --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.request-backload') ||
                    request()->routeIs('flex.backload-requests') ||
                    request()->routeIs('flex.backload-trip')
                        ? 'active'
                        : null }}"
                        href="{{ route('flex.backload-requests') }}">
                        BackLoad Trips
                    </a>
                </li>
                {{--  / --}}

            </ul>
        </li>
        {{-- / --}}
    @endcan

    {{-- ./ --}}

    {{-- Start of Loading Trucks --}}
    <li class="nav-item ">
        <a href="{{ route('flex.loading-trucks') }}"
            class="nav-link  {{ request()->routeIs('flex.loading-trucks') ? 'active' : null }}">
            <i class="ph-database"></i>
            <span>Truck Loading </span>
        </a>
    </li>
    {{-- ./ --}}

    {{-- Start of Out of Budget Management --}}
    <li class="nav-item ">
        <a href="{{ route('flex.operation-offbudgets') }}"
            class="nav-link  {{ request()->routeIs('flex.operation-offbudgets') || request()->routeIs('flex.offbudgets.truck-offbudget') || request()->routeIs('flex.finance-details') || request()->routeIs('operation-offbudgets.tab_index') ? 'active' : null }}">
            <i class="ph-money"></i>
            <span>Out of budgets </span>
        </a>
    </li>
    {{-- ./ --}}



    {{-- @can('view-retirement-request') --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.all-driver-retirements') || request()->routeIs('flex.request-driver-retirement')
            || request()->routeIs('retirement-requests.show')
                ? 'active'
                : null }}"
                href="{{ route('flex.all-driver-retirements') }}">
                <i class="ph-user"></i>
                Deduction Requests
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
    {{-- @endcan --}}

    @can('view-settings-menu')
        <li class="nav-item ">
            <a href="{{ route('flex.offbudgets.trasnfer') }}"
                class="nav-link  {{ request()->routeIs('flex.offbudgets.trasnfer') ? 'active' : null }}">
                <i class="ph-recycle"></i>
                <span>Transfer Offbudgets </span>
            </a>
        </li>
    @endcan
    {{-- / --}}

    {{-- Start of Parking Fee Management --}}
    <li class="nav-item ">
        <a href="{{ route('upload-requests.index') }}"
            class="nav-link  {{ request()->routeIs('upload-requests.*') ? 'active' : null }}">
            <i class="ph-truck"></i>
            <span>Bulk Expense</span>
        </a>
    </li>
    {{-- / --}}

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.workshop.breakdown') ||
        request()->routeIs('flex.workshop.breakdown.create') ||
        request()->routeIs('flex.workshop.breakdown.show') ||
        request()->routeIs('flex.workshop.breakdown.show.single') ||
        request()->routeIs('flex.workshop.breakdown.edit')
            ? 'active'
            : null }}"
            href="{{ route('flex.operation.breakdown') }}">
            <i class="ph-circle-wavy-warning"></i>
            Breakdowns
        </a>
    </li>






    {{-- <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('advance_payment_requests.index','advance_payment_requests.show','advance_payment_requests.edit','advance_payment_requests.create') ? 'active': null }}"
            href="{{ route('advance_payment_requests.index') }}">
            <i class="ph-wallet"></i>
            Trip Advances
        </a>
    </li> --}}



    @can('view-truck-rescue')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.truck-rescue') ||
            request()->routeIs('flex.truck-rescue.create') ||
            request()->routeIs('flex.truck-rescue.show') ||
            request()->routeIs('flex.truck-rescue.edit')
                ? 'active'
                : null }}"
                href="{{ route('flex.truck-rescue') }}">
                <i class="ph-truck"></i>
                Truck Rescue
            </a>
        </li>
    @endcan

@endcan
