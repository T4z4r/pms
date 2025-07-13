@extends('layouts.vertical', ['title' => 'All Issues'])

@push('head-script')
    <!-- Styles -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
<div class="card border-top border-top-width-3 border-top-black rounded-0">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-bug text-secondary"></i> Reported Issues
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
        <!-- Horizontal Tabs -->
        <ul class="nav nav-tabs mb-3" id="issueTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab') == 'issues' || !request('tab') ? 'active' : '' }}" id="issues-tab" data-bs-toggle="tab" data-bs-target="#issues" type="button" role="tab" aria-controls="issues" aria-selected="{{ request('tab') == 'issues' || !request('tab') ? 'true' : 'false' }}">
                    <i class="ph-bug me-2"></i> Issues
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ request('tab') == 'statistics' ? 'active' : '' }}" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics" type="button" role="tab" aria-controls="statistics" aria-selected="{{ request('tab') == 'statistics' ? 'true' : 'false' }}">
                    <i class="ph-chart-bar me-2"></i> Statistics
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="issueTabsContent">
            <!-- Issues Tab -->
            <div class="tab-pane fade {{ request('tab') == 'issues' || !request('tab') ? 'show active' : '' }}" id="issues" role="tabpanel" aria-labelledby="issues-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-primary">Issues</h5>
                    <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal" data-bs-target="#addIssueModal">
                        <i class="ph-plus me-2"></i> Add Issue
                    </a>
                </div>

                <!-- Filters -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h6 class="card-title">Filter Issues</h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('issues.index') }}">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Project</label>
                                    <select name="project_id" class="form-select select2">
                                        <option value="">All Projects</option>
                                        @foreach ($projects as $id => $name)
                                            <option value="{{ $id }}" {{ request('project_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select select2">
                                        <option value="">All Statuses</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-select select2">
                                        <option value="">All Priorities</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority }}" {{ request('priority') == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Assigned To</label>
                                    <select name="assignee" class="form-select select2">
                                        <option value="">All Assignees</option>
                                        @foreach ($users as $id => $name)
                                            <option value="{{ $id }}" {{ request('assignee') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Created By</label>
                                    <select name="creator" class="form-select select2">
                                        <option value="">All Creators</option>
                                        @foreach ($users as $id => $name)
                                            <option value="{{ $id }}" {{ request('creator') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
                                    <a href="{{ route('issues.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Issues Table -->
                <table id="issuesTable" class="table table-striped table-bordered datatable-basic">
                    <thead>
                        <tr>
                            <th>SN.</th>
                            <th>Project</th>
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
                        @forelse($issues as $index => $issue)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $issue->project->name }}</td>
                                <td>{{ $issue->title }}</td>
                                <td>
                                    <span class="badge bg-{{ $issue->status == 'Open' ? 'info' : ($issue->status == 'In Progress' ? 'warning' : 'success') }}">
                                        {{ $issue->status }}
                                    </span>
                                </td>
                                <td>{{ $issue->priority }}</td>
                                <td>{{ $issue->users->pluck('name')->implode(', ') ?: '-' }}</td>
                                <td>{{ $issue->creator->name??'--' }}</td>
                                <td>{{ $issue->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editIssueModal{{ $issue->id }}">
                                        <i class="ph-note-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="deleteIssue({{ $issue->id }})">
                                        <i class="ph-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Issue Modal -->
                            <div class="modal fade" id="editIssueModal{{ $issue->id }}" tabindex="-1" aria-labelledby="editIssueModalLabel{{ $issue->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('issues.update', $issue) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editIssueModalLabel{{ $issue->id }}">Edit Issue: {{ $issue->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Project</label>
                                                        <select name="project_id" class="form-select select2" required>
                                                            @foreach ($projects as $id => $name)
                                                                <option value="{{ $id }}" {{ $issue->project_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" name="title" class="form-control" value="{{ $issue->title }}" required>

                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select select2" required>
                                                            @foreach ($statuses as $status)
                                                                <option value="{{ $status }}" {{ $issue->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Priority</label>
                                                        <select name="priority" class="form-select select2" required>
                                                            @foreach ($priorities as $priority)
                                                                <option value="{{ $priority }}" {{ $issue->priority == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Assigned To</label>
                                                        <select name="users[]" class="form-select select2" multiple>
                                                            @foreach ($users as $id => $name)
                                                                <option value="{{ $id }}" {{ $issue->users->contains($id) ? 'selected' : '' }}>{{ $name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Description</label>
                                                        <textarea name="description" class="form-control summernote">{!! $issue->description !!}</textarea>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Update Issue</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No issues found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Statistics Tab -->
            <div class="tab-pane fade {{ request('tab') == 'statistics' ? 'show active' : '' }}" id="statistics" role="tabpanel" aria-labelledby="statistics-tab">
                <h5 class="text-primary mb-3">Issue Statistics</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-primary text-white shadow-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="ph-bug display-6 me-3"></i>
                                <div>
                                    <p class="mb-0">Total Issues</p>
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
                                    <p class="mb-0">Open Issues</p>
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
                                    <p class="mb-0">In Progress Issues</p>
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
                                    <p class="mb-0">Closed Issues</p>
                                    <p class="card-text h2 mb-0">{{ $stats['closed_issues'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-success text-white shadow-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <i class="ph-arrow-down display-6 me-3"></i>
                                <div>
                                    <p class="mb-0">Low Priority Issues</p>
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
                                    <p class="mb-0">Medium Priority Issues</p>
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
                                    <p class="mb-0">High Priority Issues</p>
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

<!-- Add Issue Modal -->
<div class="modal fade" id="addIssueModal" tabindex="-1" aria-labelledby="addIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('issues.store', $projects->first() ?? null) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addIssueModalLabel">Add Issue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select select2" required>
                                @foreach ($projects as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select select2" required>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority }}" {{ $priority == 'Medium' ? 'selected' : '' }}>{{ $priority }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assigned To</label>
                            <select name="users[]" class="form-select select2" multiple>
                                @foreach ($users as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
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
            // Initialize Select2
            $('.select2').each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                    placeholder: 'Select an option',
                    allowClear: true,
                    width: '100%'
                });
            });

            // Initialize Summernote
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

            // Initialize DataTable
            // $('#issuesTable').DataTable({
            //     responsive: true,
            //     order: [[0, 'asc']],
            //     pageLength: 10,
            // });
        });

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
                        method: 'DELETE',
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
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    })
                    .fail(function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Issue deletion failed: ' + (xhr.responseJSON?.error || 'Unknown error'),
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush
