{{-- This is my services Menu --}}

{{-- Farm activities menu --}}
@can('view-activities')
<li class="nav-item">
    <a href="{{ route('activities.individual') }}"
        class="nav-link {{ request()->routeIs('activities.individual') ? 'active' : null }}">
        <i class="ph-house"></i>
        <span>Activities</span>
    </a>
</li>
@endcan

@can('view-my-leaves')
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('flex.my-leaves') ? 'active' : null }}"
        href="{{ route('flex.my-leaves') }}"><i class="ph-user-rectangle me-2"></i>My Leaves</a>
</li>
@endcan
{{-- / End of farm activities menu --}}



{{-- / --}}

{{-- start of active employee link --}}
@can('view-my-overtime')
    <!-- <li class="nav-item">


                    <a class="nav-link {{ request()->routeIs('flex.my-overtimes') ? 'active' : null }}"
                        href="{{ route('flex.my-overtimes') }}"><i class="ph-clock me-2"></i>
                        My Overtimes
                    </a>
                </li> -->
@endcan


{{-- / --}}
{{-- start of overtime link --}}
{{-- @can('view-my-pensions') --}}
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('flex.my-pensions') ? 'active' : null }}"
        href="{{ route('flex.my-pensions') }}"> <i class="ph-bank me-2"></i>Pensions </a>
</li>
{{-- @endcan --}}

{{-- start of employee termination link --}}

{{-- @can('view-my-loans') --}}
<li class="nav-item ">
    <a class="nav-link {{ request()->routeIs('flex.my-loans') ? 'active' : null }}"
        href="{{ route('flex.my-loans') }}"><i class="ph-buildings me-2"></i>My Loans</a>
</li>
{{-- @endcan --}}

{{-- / --}}



@can('view-payslip1')
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('flex.download_payslip') ? 'active' : null }}"
        href="{{ route('flex.download_payslip') }}"> <i class="ph-bank me-2"></i>Payslip </a>
</li>
@endcan

{{-- / --}}

{{-- start of Grievances link --}}
{{-- @can('view-my-grivance') --}}
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('flex.my-grievances') ? 'active' : null }}"
        href="{{ route('flex.my-grievances') }}"><i class="ph-waves me-2"></i> Grievances </a>
</li>
{{-- @endcan --}}

{{-- / --}}

{{-- start of biodata link --}}
{{-- @can('view-my-biodata') --}}
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('flex.my-biodata') ? 'active' : null }}"
        href="{{ route('flex.my-biodata') }}"> <i class="ph-user-circle me-2"></i>Biodata </a>
</li>
{{-- @endcan --}}

{{-- / --}}


{{-- @can('view-department-store-request-management') --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.department-store-request') ||
        request()->routeIs('flex.department-store-request.create') ||
        request()->routeIs('flex.department-store-request.show') ||
        request()->routeIs('flex.department-store-request.show.single') ||
        request()->routeIs('flex.department-store-request.edit')
            ? 'active'
            : null }}"
            href="{{ route('flex.department-store-request') }}">
            <i class="ph-house "></i>
            Procurement Request
        </a>
    </li>
{{-- @endcan --}}

{{-- start of Salary Advances --}}
@can('view-my-salary-advance')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('my_advance_salary_requests.*') ? 'active' : null }}"
            href="{{ route('my_advance_salary_requests.index') }}">
            <i class="ph-receipt"></i>
            Salary Advance </a>
    </li>
@endcan
{{-- ./ end of salary advance --}}



{{-- @can('view-administration-expenses') --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admistration-expenses.create') ||
        request()->routeIs('admistration-expenses.edit') ||
        request()->routeIs('admistration-expenses.show') ||
        request()->routeIs('flex.admistration-requests')
            ? 'active'
            : null }}"
            href="{{ route('flex.admistration-requests') }}">
            <i class="ph ph-bank"></i>
            <span>Adminstration Expenses </span>
        </a>
    </li>
{{-- @endcan --}}


{{-- Start of Route Management --}}
@can('truck-manager')
    <!-- <li class="nav-item ">
                    <a href="{{ route('flex.manager-trucks') }}"
                        class="nav-link  {{ request()->routeIs('flex.manager-trucks') || request()->routeIs('flex.manager-single-truck') ? 'active' : null }}">
                        <i class="ph-truck"></i>
                        <span>Trucks </span>
                    </a>
                </li> -->
@endcan
{{-- / --}}

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('tasks.assigned') ||
    request()->routeIs('tasks.index') ||
    request()->routeIs('tasks.pending') ||
    request()->routeIs('tasks.reviewed') ||
    request()->routeIs('tasks.overdue') ||
    request()->routeIs('tasks.completed') ||
    request()->routeIs('tasks.show') ||
    request()->routeIs('tasks.create')
        ? 'active'
        : null }}"
        href="{{ route('tasks.index') }}"> <i class="ph-user-circle me-2"></i>Tasks </a>
</li>

@can('view-inventory-orders')
<li class="nav-item">
    <a class="nav-link" href="{{ route('inventory-orders.index') }}">
        <i class="ph ph-bank"></i>
        <span>Inventory Orders</span>
    </a>
</li>
@endcan
