<li
    class="nav-item nav-item-submenu
            {{ request()->routeIs('flex.all_fuel_lpos') ||
            request()->routeIs(
                'flex.trip_fuel_stations',
                'procurement_trips.tab_index',
                'flex.tripDetails',
                'flex.procurement_trips',
                'flex.transfer_trip_fuel_station',
                'flex.pay_trip_fuel_station'
            ) ||
            request()->routeIs('flex.projects') ||
            request()->routeIs('flex.tasks')
                ? 'nav-item-expand nav-item-open'
                : null }}">
    <a href="#" class="nav-link">
        <i class="ph-receipt"></i>
        <span>Procurement LPOs</span>
    </a>
    <ul
        class="nav-group-sub collapse
                {{ request()->routeIs('flex.all_fuel_lpos') ||
                request()->routeIs(
                    'flex.trip_fuel_stations',
                    'procurement_trips.tab_index',
                    'flex.tripDetails',
                    'flex.procurement_trips',
                    'flex.transfer_trip_fuel_station',
                    'flex.pay_trip_fuel_station'
                ) ||
                request()->routeIs('flex.tasks') ||
                request()->routeIs('flex.projects')
                    ? 'show'
                    : null }}">
        @can('procurement-admin-expense')
            {{-- For Fuel LPOs --}}
            <li class="nav-item ">
                <a href="{{ route('flex.all_fuel_lpos') }}"
                    class="nav-link {{ request()->routeIs('flex.all_fuel_lpos') ? 'active' : null }}">
                    <i class="ph-receipt me-2"></i>
                    <span>Fuel LPOs</span>
                </a>
            </li>

            {{-- @can('view-settings-menu') --}}

            {{-- For Trip Fuel LPOs --}}
            <li class="nav-item ">
                <a href="{{ route('flex.trip_fuel_stations') }}"
                    class="nav-link
                      {{
                      request()->routeIs('flex.trip_fuel_stations', 'procurement_trips.tab_index', 'flex.tripDetails', 'flex.procurement_trips','flex.transfer_trip_fuel_station','flex.pay_trip_fuel_station') ? 'active' : null }}">
                    <i class="ph-gas-pump me-2"></i>
                    <span>Trip Trucks Fuel</span>
                </a>
            </li>
            {{-- @endcan --}}



            {{-- For Administration LPO --}}
            <li class="nav-item ">
                <a href="{{ route('flex.procurementAdministration') }}"
                    class="nav-link {{ request()->routeIs('flex.procurementAdministration') ? 'active' : null }}">
                    <i class="ph-user me-2"></i>
                    <span>Administration LPOs</span>
                </a>
            </li>
            {{-- For OOB LPO --}}

            <li class="nav-item ">
                <a href="{{ route('flex.procurementOffbudgets') }}"
                    class="nav-link {{ request()->routeIs('flex.procurementOffbudgets') ? 'active' : null }}">
                    <i class="ph-truck me-2"></i>
                    <span>Out of Budget LPOs</span>
                </a>
            </li>

            {{-- For Requested Items LPO --}}
            <li class="nav-item ">
                <a href="{{ route('workshop-requests.show_bulk_items') }}"
                    class="nav-link {{ request()->routeIs('workshop-requests.show_bulk_items') ? 'active' : null }}">
                    <i class="ph-shopping-cart me-2"></i>
                    <span>Requested Items LPO</span>
                </a>
            </li>

            {{-- For Fuel LPOs --}}
            <li class="nav-item ">
                <a href="{{ route('flex.payables-daily-reports') }}"
                    class="nav-link {{ request()->routeIs('flex.payables-daily-reports') ? 'active' : null }}">
                    <i class="ph-file-pdf me-2"></i>
                    <span>Daily Reports</span>
                </a>
            </li>
        @endcan

    </ul>
</li>
