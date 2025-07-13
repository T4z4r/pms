@extends('layouts.vertical', ['title' => 'Project Details'])

@push('head-script')
    <!-- Styles -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-projector-screen text-secondary"></i> {{ $project->name }}
                </h4>
                <a href="{{ route('projects.index') }}" class="btn btn-brand btn-sm">
                    <i class="ph-arrow-left me-2"></i> Back to Projects
                </a>
            </div>
        </div>

        @if (session('msg'))
            <div class="alert alert-success col-md-8 mx-auto" role="alert">
                {{ session('msg') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger col-md-8 mx-auto" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <div class="row">
                <!-- Vertical Tabs -->
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" id="projectTabs" role="tablist" aria-orientation="vertical">
                        <button class="nav-link {{ request('tab') == 'info' || !request('tab') ? 'active' : '' }}"
                            id="info-tab" data-bs-toggle="pill" data-bs-target="#info" type="button" role="tab"
                            aria-controls="info"
                            aria-selected="{{ request('tab') == 'info' || !request('tab') ? 'true' : 'false' }}">
                            <i class="ph-info me-2"></i> Project Information
                        </button>
                        <button class="nav-link {{ request('tab') == 'team' ? 'active' : '' }}" id="team-tab"
                            data-bs-toggle="pill" data-bs-target="#team" type="button" role="tab" aria-controls="team"
                            aria-selected="{{ request('tab') == 'team' ? 'true' : 'false' }}">
                            <i class="ph-users me-2"></i> Team Members
                        </button>
                        <button class="nav-link {{ request('tab') == 'ratings' ? 'active' : '' }}" id="ratings-tab"
                            data-bs-toggle="pill" data-bs-target="#ratings" type="button" role="tab"
                            aria-controls="ratings" aria-selected="{{ request('tab') == 'ratings' ? 'true' : 'false' }}">
                            <i class="ph-star me-2"></i> Ratings
                        </button>
                        <button class="nav-link {{ request('tab') == 'metrics' ? 'active' : '' }}" id="metrics-tab"
                            data-bs-toggle="pill" data-bs-target="#metrics" type="button" role="tab"
                            aria-controls="metrics" aria-selected="{{ request('tab') == 'metrics' ? 'true' : 'false' }}">
                            <i class="ph-chart-line me-2"></i> Trace Metrics
                        </button>
                        <button class="nav-link {{ request('tab') == 'issues' ? 'active' : '' }}" id="issues-tab"
                            data-bs-toggle="pill" data-bs-target="#issues" type="button" role="tab"
                            aria-controls="issues" aria-selected="{{ request('tab') == 'issues' ? 'true' : 'false' }}">
                            <i class="ph-bug me-2"></i> Issues
                        </button>
                        <button class="nav-link {{ request('tab') == 'statistics' ? 'active' : '' }}" id="statistics-tab"
                            data-bs-toggle="pill" data-bs-target="#statistics" type="button" role="tab"
                            aria-controls="statistics"
                            aria-selected="{{ request('tab') == 'statistics' ? 'true' : 'false' }}">
                            <i class="ph-chart-bar me-2"></i> Statistics
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="col-md-9">
                    <div class="tab-content" id="projectTabsContent">
                        <!-- Project Information Tab -->
                        <div class="tab-pane fade {{ request('tab') == 'info' || !request('tab') ? 'show active' : '' }}"
                            id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary">Project Information</h5>
                                <a href="#" class="btn btn-sm btn-main" data-bs-toggle="modal"
                                    data-bs-target="#editProjectModal">
                                    <i class="ph-note-pencil me-2"></i> Edit Project
                                </a>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Name:</strong> {{ $project->name }}</p>
                                    <p><strong>Description:</strong> {!! $project->description ?: 'N/A' !!}</p>
                                    <p><strong>Type:</strong> {{ $project->projectType->name }}</p>
                                    <p><strong>Priority:</strong> {{ $project->projectPriority->name }} (Level
                                        {{ $project->projectPriority->level }})</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong>
                                        <span
                                            class="badge bg-{{ $project->status == 'active' ? 'success bg-opacity-10 text-success' : 'danger bg-opacity-10 text-danger' }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </p>
                                    <p><strong>Tags:</strong> {{ $project->tags->pluck('name')->implode(', ') ?: 'None' }}
                                    </p>
                                    <p><strong>Created At:</strong> {{ $project->created_at->format('Y-m-d') }}</p>
                                    <p><strong>Updated At:</strong> {{ $project->updated_at->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Team Members Tab -->
                        <div class="tab-pane fade {{ request('tab') == 'team' ? 'show active' : '' }}" id="team"
                            role="tabpanel" aria-labelledby="team-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary">Team Members</h5>
                                <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal"
                                    data-bs-target="#addTeamMemberModal">
                                    <i class="ph-plus me-2"></i> Add Team Member
                                </a>
                            </div>
                            <table id="teamMembersTable" class="table table-striped table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>SN.</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($project->users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->pivot->projectRole->name }}</td>
                                            <td width="18%">
                                                <a href="#" title="Edit Team Member" class="btn btn-sm btn-main"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTeamMemberModal{{ $user->id }}">
                                                    <i class="ph-note-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Remove Team Member"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="removeTeamMember({{ $user->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Team Member Modal -->
                                        <div class="modal fade" id="editTeamMemberModal{{ $user->id }}"
                                            tabindex="-1" aria-labelledby="editTeamMemberModalLabel{{ $user->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST"
                                                        action="{{ route('projects.update_team_member', [$project, $user]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editTeamMemberModalLabel{{ $user->id }}">Edit Team
                                                                Member: {{ $user->name }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Role</label>
                                                                <select name="project_role_id" class="form-select select2"
                                                                    required>
                                                                    @foreach ($roles as $role)
                                                                        <option value="{{ $role->id }}"
                                                                            {{ $user->pivot->project_role_id == $role->id ? 'selected' : '' }}>
                                                                            {{ $role->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No team members assigned.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Ratings Tab -->
                        <div class="tab-pane fade {{ request('tab') == 'ratings' ? 'show active' : '' }}" id="ratings"
                            role="tabpanel" aria-labelledby="ratings-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary">Ratings</h5>
                                <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal"
                                    data-bs-target="#addRatingModal">
                                    <i class="ph-plus me-2"></i> Add Rating
                                </a>
                            </div>
                            <table id="ratingsTable" class="table table-striped table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>SN.</th>
                                        <th>User</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Created At</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($project->ratings as $index => $rating)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $rating->user->name }}</td>
                                            <td>{{ $rating->rating }} / 5</td>
                                            <td>{{ $rating->comment ?: 'N/A' }}</td>
                                            <td>{{ $rating->created_at->format('Y-m-d') }}</td>
                                            <td width="18%">
                                                <a href="#" title="Edit Rating" class="btn btn-sm btn-main"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editRatingModal{{ $rating->id }}">
                                                    <i class="ph-note-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Delete Rating"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="deleteRating({{ $rating->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Rating Modal -->
                                        <div class="modal fade" id="editRatingModal{{ $rating->id }}" tabindex="-1"
                                            aria-labelledby="editRatingModalLabel{{ $rating->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('ratings.update', $rating) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editRatingModalLabel{{ $rating->id }}">Edit Rating
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Rating (1-5)</label>
                                                                <input type="number" name="rating" class="form-control"
                                                                    value="{{ $rating->rating }}" min="1"
                                                                    max="5" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Comment</label>
                                                                <textarea name="comment" class="form-control">{{ $rating->comment }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No ratings available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Trace Metrics Tab -->
                        <div class="tab-pane fade {{ request('tab') == 'metrics' ? 'show active' : '' }}" id="metrics"
                            role="tabpanel" aria-labelledby="metrics-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary">Trace Metrics</h5>
                                <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal"
                                    data-bs-target="#addTraceMetricModal">
                                    <i class="ph-plus me-2"></i> Add Metric
                                </a>
                            </div>
                            <table id="traceMetricsTable" class="table table-striped table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>SN.</th>
                                        <th>Metric Name</th>
                                        <th>Value</th>
                                        <th>Recorded At</th>
                                        <th>Created At</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($project->traceMetrics as $index => $metric)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $metric->metric_name }}</td>
                                            <td>{{ $metric->value }}</td>
                                            <td>{{ $metric->recorded_at->format('Y-m-d H:i') }}</td>
                                            <td>{{ $metric->created_at->format('Y-m-d') }}</td>
                                            <td width="18%">
                                                <a href="#" title="Edit Metric" class="btn btn-sm btn-main"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTraceMetricModal{{ $metric->id }}">
                                                    <i class="ph-note-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Delete Metric"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="deleteTraceMetric({{ $metric->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Trace Metric Modal -->
                                        <div class="modal fade" id="editTraceMetricModal{{ $metric->id }}"
                                            tabindex="-1" aria-labelledby="editTraceMetricModalLabel{{ $metric->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST"
                                                        action="{{ route('trace_metrics.update', $metric) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editTraceMetricModalLabel{{ $metric->id }}">Edit
                                                                Metric</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Metric Name</label>
                                                                <input type="text" name="metric_name"
                                                                    class="form-control"
                                                                    value="{{ $metric->metric_name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Value</label>
                                                                <input type="number" name="value" class="form-control"
                                                                    value="{{ $metric->value }}" step="0.01" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Recorded At</label>
                                                                <input type="datetime-local" name="recorded_at"
                                                                    class="form-control"
                                                                    value="{{ $metric->recorded_at->format('Y-m-d\TH:i') }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No metrics recorded.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Issues Tab -->
                        <div class="tab-pane fade {{ request('tab') == 'issues' ? 'show active' : '' }}" id="issues"
                            role="tabpanel" aria-labelledby="issues-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="text-primary">Issues</h5>
                                <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal"
                                    data-bs-target="#addIssueModal">
                                    <i class="ph-plus me-2"></i> Add Issue
                                </a>
                            </div>
                            <div class="card shadow-sm mb-4">
                                <div class="card-header">
                                    <h6 class="card-title">Create New Issue</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('issues.store', $project) }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" required>

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select select2" required>
                                                    <option value="Open">Open</option>
                                                    <option value="In Progress">In Progress</option>
                                                    <option value="Closed">Closed</option>
                                                </select>

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Priority</label>
                                                <select name="priority" class="form-select select2" required>
                                                    <option value="Low">Low</option>
                                                    <option value="Medium" selected>Medium</option>
                                                    <option value="High">High</option>
                                                </select>

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Assigned To</label>
                                                <select name="users[]" class="form-select select2" multiple>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control summernote" placeholder="Issue details"></textarea>

                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create Issue</button>
                                    </form>
                                </div>
                            </div>
                            <table id="issuesTable" class="table table-striped table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>SN.</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Assigned To</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($project->issues as $index => $issue)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $issue->title }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $issue->status == 'Open' ? 'info' : ($issue->status == 'In Progress' ? 'warning' : 'success') }}">
                                                    {{ $issue->status }}
                                                </span>
                                            </td>
                                            <td>{{ $issue->priority }}</td>
                                            <td>{{ $issue->users->pluck('name')->implode(', ') ?: '-' }}</td>
                                            <td>{{ $issue->creator->name }}</td>
                                            <td>{{ $issue->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-main" data-bs-toggle="modal"
                                                    data-bs-target="#editIssueModal{{ $issue->id }}">
                                                    <i class="ph-note-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                                                    onclick="deleteIssue({{ $issue->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Issue Modal -->
                                        <div class="modal fade" id="editIssueModal{{ $issue->id }}" tabindex="-1"
                                            aria-labelledby="editIssueModalLabel{{ $issue->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <form class="modal-content" method="POST"
                                                    action="{{ route('issues.update', $issue) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Issue: {{ $issue->title }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" name="title" class="form-control"
                                                                    value="{{ $issue->title }}" required>

                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Status</label>
                                                                <select name="status" class="form-select select2"
                                                                    required>
                                                                    <option value="Open"
                                                                        {{ $issue->status == 'Open' ? 'selected' : '' }}>
                                                                        Open</option>
                                                                    <option value="In Progress"
                                                                        {{ $issue->status == 'In Progress' ? 'selected' : '' }}>
                                                                        In Progress</option>
                                                                    <option value="Closed"
                                                                        {{ $issue->status == 'Closed' ? 'selected' : '' }}>
                                                                        Closed</option>
                                                                </select>

                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Priority</label>
                                                                <select name="priority" class="form-select select2"
                                                                    required>
                                                                    <option value="Low"
                                                                        {{ $issue->priority == 'Low' ? 'selected' : '' }}>
                                                                        Low</option>
                                                                    <option value="Medium"
                                                                        {{ $issue->priority == 'Medium' ? 'selected' : '' }}>
                                                                        Medium</option>
                                                                    <option value="High"
                                                                        {{ $issue->priority == 'High' ? 'selected' : '' }}>
                                                                        High</option>
                                                                </select>

                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Assigned To</label>
                                                                <select name="users[]" class="form-select select2"
                                                                    multiple>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}"
                                                                            {{ $issue->users->contains($user->id) ? 'selected' : '' }}>
                                                                            {{ $user->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea name="description" class="form-control summernote">{{ $issue->description }}</textarea>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Update
                                                            Issue</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No issues found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Statistics Tab -->
                        <div class="tab-pane fade {{ request('tab') == 'statistics' ? 'show active' : '' }}"
                            id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
                            <h5 class="text-primary mb-3">Project Statistics</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-primary text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-bug display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">Total Issues</p>
                                                <p class="card-text h2 mb-0">{{ $stats['total_issues'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-info text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-info display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">Open Issues</p>
                                                <p class="card-text h2 mb-0">{{ $stats['open_issues'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-warning text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-clock display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">In Progress Issues</p>
                                                <p class="card-text h2 mb-0">{{ $stats['in_progress_issues'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-success text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-check-circle display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">Closed Issues</p>
                                                <p class="card-text h2 mb-0">{{ $stats['closed_issues'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-secondary text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-users display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">Team Size</p>
                                                <p class="card-text h2 mb-0">{{ $stats['team_size'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-info text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-star display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">Average Rating</p>
                                                <p class="card-text h2 mb-0">
                                                    {{ number_format($stats['average_rating'], 1) }} / 5</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="mt-4 mb-3">Issue Priorities</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-success text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-arrow-down display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">Low Priority Issues</p>
                                                <p class="card-text h2 mb-0">{{ $stats['low_priority_issues'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-warning text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-minus display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">Medium Priority Issues</p>
                                                <p class="card-text h2 mb-0">{{ $stats['medium_priority_issues'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-danger text-white shadow-sm h-100">
                                        <div class="card-body d-flex align-items-center">
                                            <i class="ph-arrow-up display-6 me-3"></i>
                                            <div>
                                                <p class="title mb-0">High Priority Issues</p>
                                                <p class="card-text h2 mb-0">{{ $stats['high_priority_issues'] }}</p>
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
    </div>

    <!-- Edit Project Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProjectModalLabel">Edit Project: {{ $project->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $project->name }}"
                                required>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote">{!! $project->description !!}</textarea>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="project_type_id" class="form-select select2" required>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $type->id == $project->project_type_id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="project_priority_id" class="form-select select2" required>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->id }}"
                                        {{ $priority->id == $project->project_priority_id ? 'selected' : '' }}>
                                        {{ $priority->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tags</label>
                            <select name="tags[]" class="form-select select2" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                        {{ $project->tags->contains($tag->id) ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2" required>
                                <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $project->status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Team Member Modal -->
    <div class="modal fade" id="addTeamMemberModal" tabindex="-1" aria-labelledby="addTeamMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ url('projects.add_team_member', $project) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeamMemberModalLabel">Add Team Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">User</label>
                            <select name="user_id" class="form-select select2" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="project_role_id" class="form-select select2" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Rating Modal -->
    <div class="modal fade" id="addRatingModal" tabindex="-1" aria-labelledby="addRatingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('ratings.store') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRatingModalLabel">Add Rating</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rating (1-5)</label>
                            <input type="number" name="rating" class="form-control" placeholder="e.g. 4"
                                min="1" max="5" required>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <textarea name="comment" class="form-control" placeholder="Enter comment"></textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Trace Metric Modal -->
    <div class="modal fade" id="addTraceMetricModal" tabindex="-1" aria-labelledby="addTraceMetricModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('trace_metrics.store') }}">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTraceMetricModalLabel">Add Metric</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Metric Name</label>
                            <input type="text" name="metric_name" class="form-control"
                                placeholder="e.g. Tasks Completed" required>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Value</label>
                            <input type="number" name="value" class="form-control" placeholder="e.g. 10"
                                step="0.01" required>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Recorded At</label>
                            <input type="datetime-local" name="recorded_at" class="form-control" required>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Issue Modal -->
    <div class="modal fade" id="addIssueModal" tabindex="-1" aria-labelledby="addIssueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('issues.store', $project) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addIssueModalLabel">Add Issue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select select2" required>
                                    <option value="Open">Open</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Closed">Closed</option>
                                </select>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select select2" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium" selected>Medium</option>
                                    <option value="High">High</option>
                                </select>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assigned To</label>
                                <select name="users[]" class="form-select select2" multiple>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control summernote" placeholder="Issue details"></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Create Issue</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for dropdowns
            $('.select2').each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                    placeholder: 'Select an option',
                    allowClear: true,
                    width: '100%'
                });
            });

            // Initialize Summernote for description fields
            $('.summernote').summernote({
                height: 200,
                placeholder: 'Enter description',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });


        });

        function removeTeamMember(userId) {
            Swal.fire({
                text: 'Are you sure you want to remove this team member?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ url('projects.remove_team_member', [$project, ':userId']) }}".replace(
                                ':userId', userId),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(data) {
                            Swal.fire(
                                'Removed!',
                                'Team member has been removed successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Team member removal failed.',
                                'error'
                            );
                        });
                }
            });
        }

        function deleteRating(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this rating?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ route('ratings.destroy', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(data) {
                            Swal.fire(
                                'Deleted!',
                                'Rating has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Rating deletion failed.',
                                'error'
                            );
                        });
                }
            });
        }

        function deleteTraceMetric(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this trace metric?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ route('trace_metrics.destroy', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(data) {
                            Swal.fire(
                                'Deleted!',
                                'Trace metric has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Trace metric deletion failed.',
                                'error'
                            );
                        });
                }
            });
        }

        function deleteIssue(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this issue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ url('issues') }}/" + id,
                            method: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(data) {
                            Swal.fire(
                                'Deleted!',
                                'Issue has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function(xhr) {
                            Swal.fire(
                                'Failed!',
                                'Issue deletion failed: ' + (xhr.responseJSON?.error || 'Unknown error'),
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endpush
