@can('view-customer-management')
    <li class="nav-item">
        <a class="nav-link
            {{ request()->routeIs('flex.project-customers') || request()->routeIs('flex.project-customer-details') ||
            request()->routeIs('customer.tab_index_project') ? 'active' : null }}"
            href="{{ route('flex.project-customers') }}"
        >
            <i class="ph-user-list"></i>
            Customers
        </a>
    </li>
@endcan
