{{-- These are assets Menu Links --}}
<li class="nav-item">
    <a href="{{ route('procurement::index') }}" class="nav-link ">
        <i class="ph-shopping-cart"></i>
        <span class="text-sm font-medium responsive-side-text"> Procurement</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('assets::index') }}" class="nav-link ">
        <i class="ph-armchair"></i>
        <span class="text-sm font-medium responsive-side-text">Assets</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('reports::index') }}" class="nav-link {">
        <i class="ph-notepad"></i>
        <span class="text-sm font-medium responsive-side-text">Reports</span>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('metadata::index') }}" class="nav-link ">
        <i class="ph-archive"></i>
        <span class="text-sm font-medium responsive-side-text">Meta data</span>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('settings::index') }}" class="nav-link ">
        <i class="ph-gear"></i>
        <span class="text-sm font-medium responsive-side-text">Settings</span>
    </a>
</li>
