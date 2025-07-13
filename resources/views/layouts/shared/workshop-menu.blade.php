
{{-- This is Workshop Menu File --}}

<li class="nav-item ">
    <a class="nav-link {{ request()->routeIs('flex.single-truck') || request()->routeIs('flex.add-truck') || request()->routeIs('flex.all-trucks') ? 'active' : null }}"
        href="{{ route('flex.all-trucks') }}">
        <i class="ph-truck"></i>
         Trucks
    </a>
</li>
@can('view-checklist')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.workshop.checklist') ||
        request()->routeIs('flex.workshop.checklist.create') ||
        request()->routeIs('flex.workshop.checklist.show') ||
        request()->routeIs('flex.workshop.checklist.show.single') ||
        request()->routeIs('flex.workshop.checklist.edit')
            ? 'active'
            : null }}"
            href="{{ route('flex.workshop.checklist') }}">
            <i class="ph-list-checks"></i>Checklist
        </a>
    </li>
@endcan
@can('view-jobcard')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.workshop.jobcard') ||
        request()->routeIs('flex.workshop.jobcard.view') ||
        request()->routeIs('flex.workshop.jobcard.edit')
            ? 'active'
            : null }}"
            href="{{ url('/workshop/jobcard') }}">
            <i class="ph-article"></i>Job Cards
        </a>
    </li>
@endcan
@can('view-maintanance')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.workshop.maintanance') ||
        request()->routeIs('flex.workshop.maintanance.view') ||
        request()->routeIs('flex.workshop.maintanance.create') ||
        request()->routeIs('flex.workshop.maintanance.edit') ||
        request()->routeIs('flex.workshop.maintanance.show') ||
        request()->routeIs('flex.workshop.maintanance.show.single')
            ? 'active'
            : null }}"
            href="{{ url('/workshop/maintanance') }}">
            <i class="ph-wrench"></i>Maintanance
        </a>
    </li>
@endcan


{{-- Start of Technician Management --}}
@can('view-technician-management')
    <li class="nav-item nav-item-submenu">
        <a href="#" class="nav-link ">
            <i class="ph-users-three"></i>
            <span>Technicians</span>
        </a>
        <ul
            class="nav-group-sub collapse {{ request()->routeIs('flex.technician.tech') ||
            request()->routeIs('flex.technician.tech.create') ||
            request()->routeIs('flex.technician.tech.show') ||
            request()->routeIs('flex.technician.tech.edit') ||
            request()->routeIs('flex.technician.type') ||
            request()->routeIs('flex.technician.type.create') ||
            request()->routeIs('flex.technician.type.show') ||
            request()->routeIs('flex.technician.type.edit') ||
            request()->routeIs('flex.technician.department') ||
            request()->routeIs('flex.technician.department.create') ||
            request()->routeIs('flex.technician.department.show') ||
            request()->routeIs('flex.technician.department.edit')
                ? 'show'
                : null }}">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.technician.tech') ||
                request()->routeIs('flex.technician.tech.create') ||
                request()->routeIs('flex.technician.tech.show') ||
                request()->routeIs('flex.technician.tech.edit')
                    ? 'active'
                    : null }}"
                    href="{{ route('flex.technician.tech') }}">
                    Technicians
                </a>
            </li>
            {{--  / --}}

            {{-- start of Departments Routes link --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.technician.department') ||
                request()->routeIs('flex.technician.department.create') ||
                request()->routeIs('flex.technician.department.show') ||
                request()->routeIs('flex.technician.department.edit')
                    ? 'active'
                    : null }}"
                    href="{{ route('flex.technician.department') }}">
                    Specializations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('flex.technician.type') ||
                request()->routeIs('flex.technician.type.create') ||
                request()->routeIs('flex.technician.type.show') ||
                request()->routeIs('flex.technician.type.edit')
                    ? 'active'
                    : null }}"
                    href="{{ route('flex.technician.type') }}">
                    Technician Types
                </a>
            </li>
        </ul>
    </li>
@endcan
{{-- ./ --}}


{{-- Start of Working Hours --}}
@can('view-working-hours-management')
    <li class="nav-item ">
        <a href="{{ route('flex.working-hours') }}"
            class="nav-link  {{ request()->routeIs('flex.working-hours') ||
            request()->routeIs('flex.working-hours.create') ||
            request()->routeIs('flex.working-hours.show') ||
            request()->routeIs('flex.working-hours.edit')
                ? 'active'
                : null }}">
            <i class="ph ph-clock"></i>
            <span>Working Hours </span>
        </a>
    </li>
@endcan
{{-- ./ --}}

{{-- Start of Assigned Tasks --}}
@can('view-dashboard-assignments')
    <li class="nav-item ">
        <a href="{{ route('flex.task') }}"
            class="nav-link  {{ request()->routeIs('flex.task') ||
            request()->routeIs('flex.task.show') ||
            request()->routeIs('flex.task.edt')
                ? 'active'
                : null }}">
            <i class="ph ph-files"></i>
            <span>Assigned Tasks</span>
        </a>
    </li>
@endcan
{{-- ./ --}}

{{-- @can('view-breakdown') --}}
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('flex.workshop.breakdown') ||
    request()->routeIs('flex.workshop.breakdown.create') ||
    request()->routeIs('flex.workshop.breakdown.show') ||
    request()->routeIs('flex.workshop.breakdown.show.single') ||
    request()->routeIs('flex.workshop.breakdown.edit')
        ? 'active'
        : null }}"
        href="{{ url('/workshop/breakdown') }}">
        <i class="ph-circle-wavy-warning"></i>
        Breakdowns
    </a>
</li>
{{-- @endcan --}}


         {{-- start of Store Retail link --}}
         <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('retails.index') ? 'active' : null }}"
                href="{{ route('retails.index') }}">
                <i class="ph-shopping-cart"></i>
                Retail
            </a>
        </li>
        {{--  / --}}


    {{-- Start of Store Requests --}}
    @can('view-store-request-management')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.store-request') ||
            request()->routeIs('flex.store-request.create') ||
            request()->routeIs('flex.store-request.show') ||
            request()->routeIs('flex.store-request.show.single') ||
            request()->routeIs('flex.store-request.edit')
                ? 'active'
                : null }}"
                href="{{ route('flex.store-request') }}">
                <i class="ph-house-simple "></i>
                Store Request
            </a>
        </li>
    @endcan
    {{-- ./ --}}
@can('view-lashing-gear')
    {{-- Start of Lashing Gears & Tyres Managements --}}
    <li
        class="nav-item nav-item-submenu {{ request()->routeIs('truck-lashing-gears.create') ||
        request()->routeIs('truck-lashing-gears.edit') ||
        request()->routeIs('truck-lashing-gears.show') ||
        request()->routeIs('truck-lashing-gears.index') ||
        request()->routeIs('truck-tyres.create') ||
        request()->routeIs('truck-tyres.edit') ||
        request()->routeIs('truck-tyres.show') ||
        request()->routeIs('truck-tyres.index')
            ? 'nav-item-expanded nav-item-open'
            : null }}">
        <a href="#" class="nav-link ">
            <i class="ph-poker-chip"></i>
            <span>Tires & Lashing Gears</span>
        </a>

        <ul
            class="nav-group-sub collapse {{ request()->routeIs('truck-lashing-gears.create') ||
            request()->routeIs('truck-lashing-gears.edit') ||
            request()->routeIs('truck-lashing-gears.show') ||
            request()->routeIs('truck-lashing-gears.index') ||
            request()->routeIs('truck-tyres.create') ||
            request()->routeIs('truck-tyres.edit') ||
            request()->routeIs('truck-tyres.show') ||
            request()->routeIs('truck-tyres.index')
                ? 'show'
                : null }}">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('truck-tyres.create') ||
                request()->routeIs('truck-tyres.edit') ||
                request()->routeIs('truck-tyres.show') ||
                request()->routeIs('truck-tyres.index')
                    ? 'active'
                    : null }}"
                    href="{{ route('truck-tyres.index') }}">
                    Tyres
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('truck-lashing-gears.create') ||
                request()->routeIs('truck-lashing-gears.edit') ||
                request()->routeIs('truck-lashing-gears.show') ||
                request()->routeIs('truck-lashing-gears.index')
                    ? 'active'
                    : null }}"
                    href="{{ route('truck-lashing-gears.index') }}">
                    Lashing Gears
                </a>
            </li>
        </ul>
    </li>
    {{-- / --}}
@endcan

<li class="nav-item nav-item-submenu">
    <a href="#" class="nav-link ">
        <i class="ph-wrench"></i>
        <span>Checklist Setting</span>
    </a>
    <ul
        class="nav-group-sub collapse {{ request()->routeIs('flex.workshop.setting.inspection.category') ||
        request()->routeIs('flex.workshop.setting.inspection.category.create') ||
        request()->routeIs('flex.workshop.setting.inspection.category.show') ||
        request()->routeIs('flex.workshop.setting.inspection.category.edit') ||
        request()->routeIs('flex.workshop.setting.inspection.criteria') ||
        request()->routeIs('flex.workshop.setting.inspection.criteria.create') ||
        request()->routeIs('flex.workshop.setting.inspection.criteria.show') ||
        request()->routeIs('flex.workshop.setting.inspection.criteria.edit')
            ? 'show'
            : null }}  ">
        {{-- start of Company Details Routes link --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.workshop.setting.inspection.category') ||
            request()->routeIs('flex.workshop.setting.inspection.category.create') ||
            request()->routeIs('flex.workshop.setting.inspection.category.show') ||
            request()->routeIs('flex.workshop.setting.inspection.category.edit')
                ? 'active'
                : null }}"
                href="{{ route('flex.workshop.setting.inspection.category') }}">
                Inspection Categories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ request()->routeIs('flex.workshop.setting.inspection.criteria') ||
            request()->routeIs('flex.workshop.setting.inspection.criteria.create') ||
            request()->routeIs('flex.workshop.setting.inspection.criteria.show') ||
            request()->routeIs('flex.workshop.setting.inspection.criteria.edit')
                ? 'active'
                : null }}"
                href="{{ route('flex.workshop.setting.inspection.criteria') }}">
                Inspection Criteria
            </a>
        </li>
    </ul>
</li>
<li class="nav-item nav-item-submenu">
    <a href="#" class="nav-link ">
        <i class="ph-wrench"></i>
        <span>Breakdown Settings</span>
    </a>
    <ul
        class="nav-group-sub collapse {{ request()->routeIs('flex.workshop.setting.breakdown.category') ||
        request()->routeIs('flex.workshop.setting.breakdown.category.create') ||
        request()->routeIs('flex.workshop.setting.breakdown.category.show') ||
        request()->routeIs('flex.workshop.setting.breakdown.category.edit') ||
        request()->routeIs('flex.workshop.setting.breakdown.item') ||
        request()->routeIs('flex.workshop.setting.breakdown.item.create') ||
        request()->routeIs('flex.workshop.setting.breakdown.item.show') ||
        request()->routeIs('flex.workshop.setting.breakdown.item.edit') ||
        request()->routeIs('flex.workshop.setting.breakdown.fund') ||
        request()->routeIs('flex.workshop.setting.breakdown.fund.create') ||
        request()->routeIs('flex.workshop.setting.breakdown.fund.show') ||
        request()->routeIs('flex.workshop.setting.breakdown.fund.edit') ||
        request()->routeIs('flex.workshop.setting.breakdown.fund.edit')
            ? 'show'
            : null }}">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.workshop.setting.breakdown.category') ||
            request()->routeIs('flex.workshop.setting.breakdown.category.create') ||
            request()->routeIs('flex.workshop.setting.breakdown.category.show') ||
            request()->routeIs('flex.workshop.setting.breakdown.category.edit')
                ? 'active'
                : null }}"
                href="{{ route('flex.workshop.setting.breakdown.category') }}">
                Breakdown Categories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link
            {{ request()->routeIs('flex.workshop.setting.breakdown.item') ||
            request()->routeIs('flex.workshop.setting.breakdown.item.create') ||
            request()->routeIs('flex.workshop.setting.breakdown.item.show') ||
            request()->routeIs('flex.workshop.setting.breakdown.item.edit')
                ? 'active'
                : null }}"
                href="{{ route('flex.workshop.setting.breakdown.item') }}">
                Breakdown Item
            </a>
        </li>

    </ul>
</li>
