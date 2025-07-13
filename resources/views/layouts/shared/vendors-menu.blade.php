{{-- Start of Customer Management --}}
@can('view-customer-management')
            {{-- Start of Customer Project Menu --}}
            @include('layouts.shared.vendors-project-menu')
            {{-- end of Customer Project Menu --}}

            {{-- start of All Customers Routes link --}}
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.customer_details') || request()->routeIs('flex.add-customer') || request()->routeIs('flex.all-customers') || request()->routeIs('flex.edit-customer') || request()->routeIs('customer.tab_index') ? 'active' : null }}"
                    href="{{ route('flex.all-customers') }}">
                    <i class="ph-user-list"></i>
                    Customers
                </a>
            </li> --}}
            {{--  / --}}
            @can('view-settings')
             {{-- start of All Customers Opening Balances link --}}
             <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.all-customer-opening-balances')  ? 'active' : null }}"
                    href="{{ route('flex.all-customer-opening-balances') }}">
                    <i class="ph-calculator"></i>
                     Opening Balances
                </a>
            </li>
            {{--  / --}}
            @endcan
@endcan
{{-- / --}}


@can('view-supplier')
    {{-- Start of Suppliers Management --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : null }}"
            href="{{ route('suppliers.index') }}">
            <i class="ph-user-list"></i>

            Suppliers
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('providers.create') ||
        request()->routeIs('providers.edit') ||
        request()->routeIs('providers.show') ||
        request()->routeIs('providers.index')
            ? 'active'
            : null }}"
            href="{{ route('providers.index') }}">
            <i class="ph-user-list"></i>

            Service Providers
        </a>
    </li>

    {{-- FOR INVENTORY MANAGEMENT --}}

    <li class="nav-item">
        <a class="nav-link
        {{ request()->routeIs('wholesalers.index')
            ? 'active'
            : null }}"
            href="{{ route('wholesalers.index') }}">
            <i class="ph-user-list"></i>

            Wholesalers
        </a>
    </li>
    {{-- <li
        class="nav-item nav-item-submenu {{ request()->routeIs('suppliers.create') ||
        request()->routeIs('suppliers.edit') ||
        request()->routeIs('suppliers.show') ||
        request()->routeIs('suppliers.index') ||
        request()->routeIs('providers.create') ||
        request()->routeIs('providers.edit') ||
        request()->routeIs('providers.show') ||
        request()->routeIs('providers.index')
            ? 'nav-item-expanded nav-item-open'
            : null }}">
        <a href="#" class="nav-link ">
            <span>Suppliers Management</span>
        </a>

        <ul
            class="nav-group-sub collapse {{ request()->routeIs('suppliers.create') ||
            request()->routeIs('suppliers.edit') ||
            request()->routeIs('suppliers.show') ||
            request()->routeIs('suppliers.index') ||
            request()->routeIs('providers.create') ||
            request()->routeIs('providers.edit') ||
            request()->routeIs('providers.show') ||
            request()->routeIs('providers.index')
                ? 'show'
                : null }}">

        </ul>
    </li> --}}
    {{-- / --}}
@endcan
