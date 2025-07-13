@extends('layouts.vertical', ['title' => 'Tasks'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <!-- Summernote CSS - CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Summernote JS - CDN Link -->
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
                <i class="ph-check-square text-secondary"></i> Tasks
            </h4>
            <div>
                <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    <i class="ph-plus me-2"></i> New Task
                </a>
                <a href="{{ route('tasks.export_template') }}" class="btn btn-brand btn-sm">
                    <i class="ph-download me-2"></i> Download Template
                </a>
                <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#importTaskModal">
                    <i class="ph-upload me-2"></i> Import Tasks
                </a>
                <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#exportProjectTasksModal">
                    <i class="ph-download me-2"></i> Export Project Tasks
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form id="taskFilterForm" method="GET" action="{{ route('tasks.index') }}" class="mt-3">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Project</label>
                    <select name="project_id" class="form-select select2">
                        <option value="">All Projects</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select select2">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Assigned User</label>
                    <select name="user_id" class="form-select select2">
                        < value="">All Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <table id="tasksTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Creator</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Assigned Users</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $index => $task)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->project->name ?? 'N/A' }}</td>
                        <td>{{ $task->creator->name }}</td>
                        <td>
                            <span class="badge bg-{{ $task->status == 'approved' ? 'success bg-opacity-10 text-success' : ($task->status == 'pending' ? 'secondary bg-opacity-10 text-secondary' : 'warning bg-opacity-10 text-warning') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $task->users->pluck('name')->implode(', ') ?: 'None' }}</td>
                        <td>{{ $task->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="{{ route('tasks.view', $task) }}" title="View Task" class="btn btn-sm btn-main">
                                <i class="ph-info"></i>
                            </a>
                            @if ($task->status != 'under_review' && $task->status != 'approved')
                                <a href="#" title="Edit Task" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Task" class="btn btn-sm btn-danger" onclick="deleteTask({{ $task->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            @endif
                        </td>
                    </tr>

                    <!-- Edit Task Modal -->
                    <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form class="modal-content" method="POST" action="{{ route('tasks.update', $task) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editTaskModalLabel{{ $task->id }}">Edit Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control summernote" placeholder="Enter details">{!! $task->description !!}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Project</label>
                                        <select name="project_id" class="form-select">
                                            <option value="">None</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                                                    {{ $project->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Due Date</label>
                                        <input type="date" name="due_date" class="form-control" value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Assigned Users</label>
                                        <select name="users[]" class="form-select select2" multiple>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $task->users->contains($user->id) ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
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
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No tasks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST_completion_status="complete" action="{{ route('tasks.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createTaskModalLabel">New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Develop Feature X" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control summernote" placeholder="Enter details"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Project</label>
                    <select name="project_id" class="form-select">
                        <option value="">None</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Assigned Users</label>
                    <select name="users[]" class="form-select select2" multiple>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Create</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Import Tasks Modal -->
<div class="modal fade" id="importTaskModal" tabindex="-1" aria-labelledby="importTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('tasks.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importTaskModalLabel">Import Tasks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Excel File</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Import</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Export Project Tasks Modal -->
<div class="modal fade" id="exportProjectTasksModal" tabindex="-1" aria-labelledby="exportProjectTasksModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('tasks.export') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exportProjectTasksModalLabel">Export Project Tasks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Select Project <span class="text-danger">*</span></label>
                    <select name="export_project_id" class="form-select select2" required>
                        <option value="" disabled selected>Select a project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Export</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').each(function() {
                $(this).select2({ dropdownParent: $(this).parent() });
            });

            // Initialize Summernote
            $('.summernote').summernote({
                height: 200,
                placeholder: 'Enter details',
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


            // Handle filter form submission
            $('#taskFilterForm').on('submit', function(e) {
                e.preventDefault();
                this.submit();
            });
        });

        function deleteTask(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this task?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('tasks') }}/" + id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Task has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Task deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush
