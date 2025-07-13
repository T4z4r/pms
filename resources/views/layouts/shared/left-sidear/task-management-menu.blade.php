{{-- This is a Task Management Menu --}}
@can('manage-tasks')
<li
    class="nav-item nav-item-submenu
     {{ request()->routeIs('tasks-line-manager.*')
        || request()->routeIs('flex-projects.*')
        ||  request()->routeIs('flex-projects-tasks.*')
        ? 'nav-item-expand nav-item-open'
        : null }}">
    <a href="#" class="nav-link">
        <i class="ph-presentation-chart"></i>
        <span>Tasks Management</span>
    </a>


    <ul
        class="nav-group-sub collapse {{
        request()->routeIs('tasks-line-manager.*') ||
        request()->routeIs('flex-projects.*') ||
        request()->routeIs('flex-projects-tasks.*')
        ? 'show' : null }}">
        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.linemanager.taskmanagement') ? 'active' : null }}"
                href="{{ route('flex.linemanager.taskmanagement') }}">
                <i class="ph ph-projector-screen-chart"></i>
                Tasks Dashboard
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex-projects.*') ? 'active' : null }}"
                href="{{ route('flex.projects.index') }}">
                <i class="ph-folder"></i>
                Projects
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex-projects-tasks.*') ? 'active' : null }}"
                href="{{ route('flex-projects-tasks.index') }}">
                <i class="ph-clipboard"></i>Review Tasks
            </a>
        </li>

        {{-- <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                    href="{{ route('attendance.leave') }}"><i class="ph ph-users"></i>Teams</a>
            </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.linemanager.employees') ? 'active' : null }}"
                href="{{ route('flex.linemanager.employees') }}">
                <i class="ph ph-file-pdf"></i>
                Task Reports</a>
        </li> --}}

        {{-- start of Line Manager Settings --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('tasks-line-manager.config') ? 'active' : null }}"
                href="{{ route('tasks-line-manager.config') }}">
                <i class="ph ph-gear"></i>
                Settings</a>
        </li>
        {{-- end of Line Manager Settings --}}


    </ul>
</li>
@endcan
