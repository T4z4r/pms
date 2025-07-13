@php
    use App\Models\BrandSetting;
    $brandSetting = BrandSetting::firstOrCreate();
@endphp


{{-- @can('view-leftbar') --}}
<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg  ">
    {{-- <div class="sidebar sidebar-light sidebar-main sidebar-expand-lg sidebar-main-resized"> --}}
    <div class="sidebar-content">
        <div class="sidebar-section">
            <ul class="nav nav-sidebar main-link" data-nav-type="accordion">

                <!-- Sidebar header -->
                <div class="sidebar-section ">
                    <div class="sidebar-section-body d-flex bg-main justify-content-center">
                        <h6 class="sidebar-resize-hide flex-grow-1 my-auto text-main">
                            {{-- ERP --}}
                            <img src="{{ $brandSetting &&
                            $brandSetting->company_logo &&
                            file_exists(public_path('storage/' . $brandSetting->company_logo))
                                ? asset('storage/' . $brandSetting->company_logo)
                                : asset('assets/images/flex-logo.png') }}"
                                height="40" alt="logo">

                        </h6>

                        <div>
                            <button type="button"
                                class="btn btn-flat-white bg-main btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="ph-arrows-left-right"></i>
                            </button>

                            <button type="button"
                                class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                                <i class="ph-x"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- /sidebar header -->
                <div class="mt-3"></div>

                <li class="nav-item ">
                    <a href="{{ route('dashboard') }}"
                        class="text-color nav-link  {{ request()->routeIs('dashboard') ? 'active' : null }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('activities.index') }}"
                        class="text-color nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                        <i class="ph-calendar"></i>
                        <span>Todo List</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('clients.index') }}"
                        class="nav-link {{ request()->is('clients*') ? 'active' : '' }}">
                        <i class="ph-users"></i>
                        <span>Client Management</span>
                    </a>
                </li>


                @php
                    $userManagementRoutes = ['users.*', 'roles.*', 'permissions.*'];
                    $userManagementActive = false;
                    foreach ($userManagementRoutes as $route) {
                        if (request()->routeIs($route)) {
                            $userManagementActive = true;
                            break;
                        }
                    }
                @endphp
                <li
                    class="nav-item nav-item-submenu {{ $userManagementActive || request()->is('users-roles*') ? 'nav-item-expand nav-item-open' : '' }}">
                    <a href="#"
                        class="text-color nav-link {{ $userManagementActive || request()->is('users-roles*') ? 'active' : '' }}">
                        <i class="ph-users-three"></i>
                        <span>User Management</span>
                    </a>
                    <ul
                        class="nav-group-sub collapse {{ $userManagementActive || request()->is('users-roles*') ? 'show' : '' }}">

                        <li class="nav-item">
                            <a class="nav-link{{ request()->is('users-roles*') ? ' active' : '' }}"
                                href="{{ route('users-roles.index') }}">
                                <i class="ph-user"></i>
                                <span>User </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('roles.*') ? ' active' : '' }}"
                                href="{{ route('roles.index') }}">
                                <i class="ph-identification-badge"></i>
                                <span>Roles</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}"
                                class="text-color nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                                <i class="ph-key"></i>
                                <span>Permissions</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('projects.index') }}"
                        class="text-color nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                        <i class="ph-briefcase"></i>
                        <span>Projects Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}"
                        class="text-color nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i class="ph-clipboard-text"></i>
                        <span>Task Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('issues.index') ? 'active' : '' }}"
                        href="{{ route('issues.index') }}">
                        <i class="ph-bug"></i> Reported Issues
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('systems.index') }}"
                        class="nav-link {{ request()->is('systems*') ? 'active' : '' }}">
                        <i class="ph-desktop"></i>
                        <span>Systems Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('system-manuals.index') }}"
                        class="nav-link {{ request()->is('system-manuals*') ? 'active' : '' }}">
                        <i class="ph-book-open"></i>
                        <span>System Manuals</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('system-designs.index') }}"
                        class="nav-link {{ request()->is('system-designs*') ? 'active' : '' }}">
                        <i class="ph ph-cpu"></i>
                        <span>System Designs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('drawio.editor') }}"
                        class="nav-link {{ request()->is('drawio-editor*') ? 'active' : '' }}">
                        <i class="ph-pencil"></i>
                        <span>Draw.io Editor</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="{{ route('documents.index') }}"
                        class="text-color nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                        <i class="ph-file-text"></i>
                        <span>Document Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tests.index') }}"
                        class="text-color nav-link {{ request()->routeIs('tests.*') ? 'active' : '' }}">
                        <i class="ph-check-square"></i>
                        <span>Test Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('security-gaps.index') }}"
                        class="text-color nav-link {{ request()->routeIs('security-gaps.*') ? 'active' : '' }}">
                        <i class="ph-shield-warning"></i>
                        <span>Security Gaps</span>
                    </a>

                    @php
                        $projectSettingsRoutes = [
                            'project_types.*',
                            'project_priorities.*',
                            'project_roles.*',
                            'project_tags.*',
                            'ratings.*',
                            'trace_metrics.*',
                        ];
                        $projectSettingsActive = false;
                        foreach ($projectSettingsRoutes as $route) {
                            if (request()->routeIs($route)) {
                                $projectSettingsActive = true;
                                break;
                            }
                        }
                    @endphp
                <li
                    class="nav-item nav-item-submenu {{ $projectSettingsActive ? 'nav-item-expand nav-item-open' : '' }}">
                    <a href="#" class="text-color nav-link {{ $projectSettingsActive ? 'active' : '' }}">
                        <i class="ph-gear"></i>
                        <span>Project Settings</span>
                    </a>
                    <ul class="nav-group-sub collapse {{ $projectSettingsActive ? 'show' : '' }}">
                        <li class="nav-item">
                            <a href="{{ route('project_types.index') }}"
                                class="text-color nav-link {{ request()->routeIs('project_types.*') ? 'active' : '' }}">
                                <i class="ph-list-bullets"></i>
                                <span>Project Types</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('project_priorities.index') }}"
                                class="text-color nav-link {{ request()->routeIs('project_priorities.*') ? 'active' : '' }}">
                                <i class="ph-arrow-up"></i>
                                <span>Priorities</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('project_roles.index') }}"
                                class="text-color nav-link {{ request()->routeIs('project_roles.*') ? 'active' : '' }}">
                                <i class="ph-users"></i>
                                <span>Project Roles</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('project_tags.index') }}"
                                class="text-color nav-link {{ request()->routeIs('project_tags.*') ? 'active' : '' }}">
                                <i class="ph-tag"></i>
                                <span>Tags</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ratings.index') }}"
                                class="text-color nav-link {{ request()->routeIs('ratings.*') ? 'active' : '' }}">
                                <i class="ph-star"></i>
                                <span>Ratings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('trace_metrics.index') }}"
                                class="text-color nav-link {{ request()->routeIs('trace_metrics.*') ? 'active' : '' }}">
                                <i class="ph-chart-line"></i>
                                <span>Metrics</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('security-gap-templates.index') }}"
                                class="text-color nav-link {{ request()->routeIs('security-gap-templates.*') ? 'active' : '' }}">
                                <i class="ph-shield-warning"></i>
                                <span>Security Gap Templates</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('standards.index') }}"
                        class="nav-link {{ request()->is('standards*') ? 'active' : '' }}">
                        <i class="ph-file-pdf"></i>
                        <span>Standards</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="text-color nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ph-sign-out"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
            {{-- </li> --}}
        </div>
    </div>
</div>
{{-- @endcan --}}
{{-- /main sidebar --}}
