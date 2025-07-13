<li class="nav-item ">
    <a href="{{ route('list.activities') }}"
        class="text-color nav-link  {{ request()->routeIs('list.activities') ? 'active' : null }}">
        <i class="ph-house "></i>
        <span>All Activities</span>
    </a>
</li>

<li class="nav-item ">
    <a href="{{ route('farms.index') }}"
        class="text-color nav-link  {{ request()->routeIs('farms.index') ? 'active' : null }}">
        <i class="ph-house "></i>
        <span>Farms</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('farms.report') }}"
        class="text-color nav-link {{ request()->routeIs('farms.report') ? 'active' : null }}">
        <i class="ph-note"></i>
        <span class="text-sm font-medium responsive-side-text"> Report</span>
    </a>
</li>
