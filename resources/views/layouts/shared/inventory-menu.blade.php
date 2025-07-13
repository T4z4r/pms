<li class="nav-item-header">
    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">INVENTORY MANAGEMENT</div>
    <i class="ph-dots-three sidebar-resize-show"></i>
</li>

<li
    class="nav-item nav-item-submenu {{ request()->routeIs('purchases.*', 'service-purchases.*', 'order-requests.*', 'workshop-requests.*', 'retails.*', 'out-of-stocks.*', 'stocks-taking.*') ? 'nav-item-expanded nav-item-open' : null }}">
    <a href="#" class="nav-link">
        <i class="ph-database"></i>
        <span>Inventory Menu</span>
    </a>
    <ul
        class="nav-group-sub collapse {{ request()->routeIs('purchases.*', 'service-purchases.*', 'order-requests.*', 'workshop-requests.*', 'retails.*', 'out-of-stocks.*', 'stocks-taking.*') ? 'show' : null }}">


        @can('view-purchase')
            {{-- Order Request Management --}}
            <li
                class="nav-item nav-item-submenu {{ request()->routeIs('order-requests.*') ? 'nav-item-expanded nav-item-open' : null }}">
                <a href="#" class="nav-link ">
                    <i class="ph-files"></i>
                    <span>Order Request</span>
                </a>

                <ul
                    class="nav-group-sub collapse {{ request()->routeIs('order-requests.*') ? 'show' : null }}">
                    @can('add-purchase')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('order-requests.create') ? 'active' : null }}"
                                href="{{ route('order-requests.create') }}">
                                New Order
                            </a>
                        </li>
                    @endcan

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('order-requests.index') ? 'active' : null }}"
                            href="{{ route('order-requests.index') }}">
                            List of Orders
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
    </ul>
</li>
