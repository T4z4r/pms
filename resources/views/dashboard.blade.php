@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fullcalendar/main.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('assets/fullcalendar/main.min.js') }}"></script>
    <style>
    .animate-icon {
        transition: transform 0.3s ease;
    }
    .animate-icon:hover {
        transform: scale(1.2) rotate(5deg);
    }
</style>
@endpush

@push('head-scriptTwo')

    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0 mt-1">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary"><i class="ph-gauge me-2"></i> Dashboard</h4>
                <div>
                    <button class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
                        <i class="ph-arrow-clockwise me-1"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Statistics Widgets -->


<div class="row g-3">
    <div class="col-lg-3 col-md-6">
        <div class="card bg-primary text-white shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <i class="ph-desktop display-6 me-3 animate-icon"></i>
                <div>
                    <p class="title mb-1">Total Systems</p>
                    <h2 class="card-text mb-0">{{ $totalSystems }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card bg-success text-white shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <i class="ph-briefcase display-6 me-3 animate-icon"></i>
                <div>
                    <p class="title mb-1">Total Projects</p>
                    <h2 class="card-text mb-0">{{ $totalProjects }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card bg-info text-white shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <i class="ph-gear display-6 me-3 animate-icon"></i>
                <div>
                    <p class="title mb-1">Total Features</p>
                    <h2 class="card-text mb-0">{{ $totalFeatures }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card bg-warning text-white shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <i class="ph-check-circle display-6 me-3 animate-icon"></i>
                <div>
                    <p class="title mb-1">Total Requirements</p>
                    <h2 class="card-text mb-0">{{ $totalRequirements }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
            <hr>
            <div class="card">
                <div class="card-body">
                    <!-- Main Tabbed Interface -->
                    <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                data-bs-target="#overview" type="button" role="tab" aria-controls="overview"
                                aria-selected="true">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent"
                                type="button" role="tab" aria-controls="recent" aria-selected="false">Recent
                                Activity</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="schedules-tab" data-bs-toggle="tab" data-bs-target="#schedules"
                                type="button" role="tab" aria-controls="schedules"
                                aria-selected="false">Schedules</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="dashboardTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel"
                            aria-labelledby="overview-tab">
                            <!-- Nested Tab Navigation for Overview -->
                            <ul class="nav nav-tabs mb-3" id="overviewTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="project-status-tab" data-bs-toggle="tab"
                                        data-bs-target="#project-status" type="button" role="tab"
                                        aria-controls="project-status" aria-selected="false">Project Status</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="system-status-tab" data-bs-toggle="tab"
                                        data-bs-target="#system-status" type="button" role="tab"
                                        aria-controls="system-status" aria-selected="true">System Status</button>
                                </li>

                            </ul>

                            <!-- Nested Tab Panes for Overview -->
                            <div class="tab-content" id="overviewTabsContent">
                                <div class="tab-pane fade " id="system-status" role="tabpanel"
                                    aria-labelledby="system-status-tab">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">System Status Distribution</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="systemStatusChart" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="project-status" role="tabpanel"
                                    aria-labelledby="project-status-tab">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Project Status Distribution</h5>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="projectStatusChart" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity Tab -->
                        <div class="tab-pane fade" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                            <!-- Nested Tab Navigation for Recent Activity -->
                            <ul class="nav nav-tabs mb-3" id="recentActivityTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="recent-systems-tab" data-bs-toggle="tab"
                                        data-bs-target="#recent-systems" type="button" role="tab"
                                        aria-controls="recent-systems" aria-selected="true">Recent Systems</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="recent-projects-tab" data-bs-toggle="tab"
                                        data-bs-target="#recent-projects" type="button" role="tab"
                                        aria-controls="recent-projects" aria-selected="false">Recent Projects</button>
                                </li>
                            </ul>

                            <!-- Nested Tab Panes for Recent Activity -->
                            <div class="tab-content" id="recentActivityTabsContent">
                                <div class="tab-pane fade show active" id="recent-systems" role="tabpanel"
                                    aria-labelledby="recent-systems-tab">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Recent Systems</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="recentSystemsTable"
                                                class="table table-striped table-bordered datatable-basic">
                                                <thead>
                                                    <tr>
                                                        <th>SN.</th>
                                                        <th>Name</th>
                                                        <th>Projects</th>
                                                        <th>Status</th>
                                                        <th>Creator</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($recentSystems as $index => $system)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td><a href="{{ route('systems.show', $system) }}"
                                                                    data-bs-toggle="tooltip"
                                                                    title="View System">{{ $system->name }}</a></td>
                                                            <td>{{ $system->projects->pluck('name')->implode(', ') ?: '-' }}
                                                            </td>
                                                            <td>{{ ucwords(str_replace('_', ' ', $system->status)) }}</td>
                                                            <td>{{ $system->creator->name }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No systems found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="recent-projects" role="tabpanel"
                                    aria-labelledby="recent-projects-tab">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Recent Projects</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="recentProjectsTable"
                                                class="table table-striped table-bordered datatable-basic">
                                                <thead>
                                                    <tr>
                                                        <th>SN.</th>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th>Creator</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($recentProjects as $index => $project)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td><a href="{{ route('projects.show', $project) }}"
                                                                    data-bs-toggle="tooltip"
                                                                    title="View Project">{{ $project->name }}</a></td>
                                                            <td>{{ ucwords(str_replace('_', ' ', $project->status)) }}</td>
                                                            <td>{{ $project->creator->name }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No projects found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedules Tab -->
                        <div class="tab-pane fade" id="schedules" role="tabpanel" aria-labelledby="schedules-tab">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Project Timeline</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="timeline">
                                                @forelse($timelineEvents as $event)
                                                    <div class="timeline-event">
                                                        <div class="timeline-marker"></div>
                                                        <div class="timeline-details">
                                                            <span
                                                                class="timeline-date badge bg-secondary">{{ $event['date'] }}</span>
                                                            <h6 class="mt-2 mb-1">{{ $event['title'] }}</h6>
                                                            <p class="text-muted small">{{ $event['description'] }}</p>
                                                            <span
                                                                class="badge bg-{{ $event['status'] === 'completed' ? 'success' : ($event['status'] === 'in_progress' ? 'info' : 'warning') }}">{{ ucwords(str_replace('_', ' ', $event['status'])) }}</span>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="text-center text-muted">No timeline events found.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h5 class="card-title mb-0">Test Plan Calendar</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="calendar"
                                                class="fc fc-media-screen fc-direction-ltr fc-theme-standard"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Card Styling */
        .card {
            border: none;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-bottom: 1px solid #e9ecef;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Timeline Styling */
        .timeline {
            position: relative;
            padding: 20px 0;
            margin-left: 20px;
        }

        .timeline-event {
            position: relative;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }

        .timeline-marker {
            width: 12px;
            height: 12px;
            background: #007bff;
            border-radius: 50%;
            position: absolute;
            top: 8px;
            left: -18px;
            z-index: 1;
        }

        .timeline-event::before {
            content: '';
            position: absolute;
            width: 2px;
            background: #007bff;
            top: 0;
            bottom: -20px;
            left: -12px;
        }

        .timeline-details {
            background: #ffffff;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
            flex-grow: 1;
        }

        .timeline-date {
            font-size: 0.85rem;
        }

        /* Calendar Styling */
        #calendar {
            min-height: 300px;
        }

        .fc-event {
            cursor: pointer;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .timeline-details {
                margin-left: 15px;
            }

            .timeline-marker {
                left: -15px;
            }

            .timeline-event::before {
                left: -10px;
            }
        }
    </style>

    @push('footer-script')
        <script>
            $(document).ready(function() {
                // Initialize Tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Initialize Charts
                const systemStatusChart = new Chart(document.getElementById('systemStatusChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Active', 'Inactive', 'Under Development', 'Deprecated'],
                        datasets: [{
                            data: [
                                {{ $systemStatusCounts['active'] ?? 0 }},
                                {{ $systemStatusCounts['inactive'] ?? 0 }},
                                {{ $systemStatusCounts['under_development'] ?? 0 }},
                                {{ $systemStatusCounts['deprecated'] ?? 0 }}
                            ],
                            backgroundColor: ['#28a745', '#dc3545', '#007bff', '#ffc107'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });

                const projectStatusChart = new Chart(document.getElementById('projectStatusChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Not Started', 'In Progress', 'Completed', 'On Hold', 'Cancelled'],
                        datasets: [{
                            label: 'Projects',
                            data: [
                                {{ $projectStatusCounts['not_started'] ?? 0 }},
                                {{ $projectStatusCounts['in_progress'] ?? 0 }},
                                {{ $projectStatusCounts['completed'] ?? 0 }},
                                {{ $projectStatusCounts['on_hold'] ?? 0 }},
                                {{ $projectStatusCounts['cancelled'] ?? 0 }}
                            ],
                            backgroundColor: '#007bff',
                            borderColor: '#0056b3',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Count'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });

                // Initialize FullCalendar
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    events: @json($calendarEvents),
                    eventClick: function(info) {
                        Swal.fire({
                            title: 'Test Plan: ' + info.event.title,
                            text: 'Start: ' + info.event.start.toLocaleString() + (info.event.end ?
                                '\nEnd: ' + info.event.end.toLocaleString() : ''),
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }
                });
                calendar.render();

                // Loading Placeholder
                $('.card-body').each(function() {
                    if ($(this).find('canvas, table, #calendar, .timeline').length === 0) {
                        $(this).html('<div class="text-center text-muted py-4">Loading...</div>');
                    }
                });
            });
        </script>
    @endpush
@endsection
