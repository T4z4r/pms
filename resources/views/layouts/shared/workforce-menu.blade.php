{{-- This is Workforce Links blade --}}
<li
class="nav-item nav-item-submenu {{ request()->routeIs('flex.addDisciplinary') || request()->routeIs('flex.addPromotion') || request()->routeIs('flex.addIncrement') || request()->routeIs('flex.addTermination') || request()->routeIs('flex.addEmployee') || request()->routeIs('flex.employee') || request()->routeIs('flex.grievancesCompain') || request()->routeIs('flex.promotion') || request()->routeIs('flex.termination') || request()->routeIs('flex.inactive_employee') || request()->routeIs('flex.overtime') || request()->routeIs('flex.termination') || request()->routeIs('imprest.imprest') || request()->routeIs('flex.transfers') ? 'nav-item-expand nav-item-open' : null }}">
<a href="#" class="nav-link">
    <i class="ph-users-three"></i>
    <span>Employee Management</span>
</a>

<ul
    class="nav-group-sub collapse {{ request()->routeIs('flex.addDisciplinary') || request()->routeIs('flex.addPromotion') || request()->routeIs('flex.addIncrement') || request()->routeIs('flex.addTermination') || request()->routeIs('flex.addEmployee') || request()->routeIs('flex.employee') || request()->routeIs('flex.grievancesCompain') || request()->routeIs('flex.promotion') || request()->routeIs('flex.termination') || request()->routeIs('flex.inactive_employee') || request()->routeIs('flex.overtime') || request()->routeIs('imprest.imprest') || request()->routeIs('flex.transfers') ? 'show' : null }}">
    {{-- start of active employee link --}}
    @can('view-employee')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.addEmployee') || request()->routeIs('flex.employee') ? 'active' : null }}"
                href="{{ route('flex.employee') }}">
                Active Employees</a>
        </li>
    @endcan
    {{--  / --}}
    {{-- start of  Employee Approval link --}}
    @can('transfer-employee')

        <li class="nav-item "><a
                class="nav-link {{ request()->routeIs('flex.transfers') ? 'active' : null }}"
                href="{{ route('flex.transfers') }}">Employee Approval</a></li>
    @endcan
    {{-- / --}}

    {{--  start of suspend employee link --}}
    @can('suspend-employee')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.inactive_employee') ? 'active' : null }}"
                href="{{ route('flex.inactive_employee') }}">Suspended Employees</a>
        </li>
    @endcan
    {{-- / --}}

    {{--  start of employee termination link --}}
    @can('view-termination')
        <li class="nav-item ">
            <a class="nav-link {{ request()->routeIs('flex.addTermination') || request()->routeIs('flex.termination') ? 'active' : null }}"
                href="{{ route('flex.termination') }}">Employee Termination</a>
        </li>
    @endcan
    {{-- / --}}

    {{-- start of promotion/increment link --}}
    @can('view-promotions')
        <li class="nav-item ">
            <a class="nav-link {{ request()->routeIs('flex.addPromotion') || request()->routeIs('flex.addIncrement') || request()->routeIs('flex.promotion') ? 'active' : null }}"
                href="{{ route('flex.promotion') }}">Promotions/Increments</a>
        </li>
    @endcan
    {{-- / --}}


    {{--  start of overtime link --}}

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.overtime') ? 'active' : null }}"
            href="{{ route('flex.overtime') }}">Overtime </a>
    </li>

    {{-- / --}}





    {{-- start of displinary  actions link --}}
    @can('view-grivance')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.addDisciplinary') || request()->routeIs('flex.grievancesCompain') ? 'active' : null }}"
                href="{{ route('flex.grievancesCompain') }}">Disciplinary Actions</a>
        </li>
    @endcan
    {{-- / --}}

    {{-- start of  Grievances link --}}
    @can('view-grivance')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.grievances') ? 'active' : null }}"
                href="{{ route('flex.grievances') }}"> Employees Grievances</a>
        </li>
    @endcan
    {{-- / --}}

</ul>
</li>
{{-- / --}}
