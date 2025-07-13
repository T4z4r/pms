@can('view-retirements')

    <li
        class="nav-item nav-item-submenu {{ request()->routeIs('flex.finance-driver-retirements') ||
        request()->routeIs('flex.finance-return-requests') ||
        request()->routeIs('flex.all-deductions-reviews') ||
        request()->routeIs('flex.all-deductions-reviews.show') ||
        request()->routeIs('flex.all-deductions-reviews.edit') ||
        request()->routeIs('flex.driver-debts') ||
        request()->routeIs('flex.driver-opening-balance')
            ? 'nav-item-expand nav-item-open'
            : '' }}">
        <a href="#" class="nav-link">
            <i class="ph-users"></i>
            <span>Driver Management</span>
        </a>
        <ul
            class="nav-group-sub collapse {{ request()->routeIs('flex.finance-driver-retirements') ||
            request()->routeIs('flex.finance-return-requests') ||
            request()->routeIs('flex.all-deductions-reviews') ||
            request()->routeIs('flex.all-deductions-reviews.show') ||
            request()->routeIs('flex.all-deductions-reviews.edit') ||
            request()->routeIs('flex.driver-debts') ||
            request()->routeIs('flex.driver-opening-balance')
                ? 'show'
                : '' }}">
            {{-- For Deduction Requests --}}
            @can('view-finance-menu')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.finance-driver-retirements') ? 'active' : '' }}"
                        href="{{ route('flex.finance-driver-retirements') }}">
                        <i class="ph-receipt"></i>
                        Deductions Requests
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.finance-return-requests') ? 'active' : '' }}"
                        href="{{ route('flex.finance-return-requests') }}">
                        <i class="ph-users"></i>
                        Driver Returns
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.all-deductions-reviews') ||
                    request()->routeIs('flex.all-deductions-reviews.show') ||
                    request()->routeIs('flex.all-deductions-reviews.edit')
                        ? 'active'
                        : '' }}"
                        href="{{ route('flex.all-deductions-reviews') }}">
                        <i class="ph-folder"></i>
                        Deductions Review
                    </a>
                </li>
            @endcan
            {{-- Start of Retirement Management --}}
            @can('view-retirements')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.driver-debts') || request()->routeIs('flex.driver-opening-balance') ? 'active' : '' }}"
                        href="{{ route('flex.driver-debts') }}">
                        <i class="ph-archive-box"></i>
                        <span>Driver Debts</span>
                    </a>
                </li>
            @endcan
            {{-- For Deduction LPO --}}
            @can('view-procurement-menu')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('flex.procurement-driver-retirements') ? 'active' : '' }}"
                        href="{{ route('flex.procurement-driver-retirements') }}">
                        <i class="ph-receipt"></i>
                        Deduction LPO
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
