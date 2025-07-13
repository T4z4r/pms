@extends('layouts.vertical', ['title' => 'Projects'])

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
    <!-- DataTable and Select2 initialization scripts -->
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <!-- Card Header -->
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-projector-screen text-secondary"></i> Projects
                </h4>
                <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#createProjectModal">
                    <i class="ph-plus me-2"></i> New Project
                </a>
            </div>
        </div>


        <!-- Projects Table -->
        <div class="card-body">
            <!-- Success Message -->
            @if (session('msg'))
                <div class="alert alert-success col-md-8 mx-auto" role="alert">
                    {{ session('msg') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger col-md-8 mx-auto" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Project Statistics Widgets -->
            <div class="row px-3">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card bg-primary text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-projector-screen display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Total Projects</p>
                                <p class="card-text h2 mb-0">{{ $totalProjects }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card bg-success text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-check-circle display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Active Projects</p>
                                <p class="card-text h2 mb-0">{{ $activeProjects }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card bg-danger text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-warning display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">High Priority Projects</p>
                                <p class="card-text h2 mb-0">{{ $highPriorityProjects }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table id="projectsTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Name</th>
                        <th>Client</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Tags</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->client ? $project->client->name : '-' }}</td>
                            <td>{{ $project->projectType->name }}</td>
                            <td>{{ $project->projectPriority->name }}</td>
                            <td>{{ $project->tags->pluck('name')->implode(', ') }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $project->status == 'active' ? 'success bg-opacity-10 text-success' : 'danger bg-opacity-10 text-danger' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td>{{ $project->created_at->format('Y-d-m') }}</td>
                            <td width="18%">
                                <a href="{{ route('projects.view', $project) }}" title="View Project"
                                    class="btn btn-main btn-sm">
                                    <i class="ph-info"></i>
                                </a>
                                <a href="#" title="Edit Project" class="btn btn-main btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editProjectModal{{ $project->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Project" class="btn btn-danger btn-sm"
                                    onclick="deleteProject({{ $project->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Project Modal -->
                        <div class="modal fade" id="editProjectModal{{ $project->id }}" tabindex="-1"
                            aria-labelledby="editProjectModalLabel{{ $project->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('projects.update', $project) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Project</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Name -->
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $project->name }}" required>

                                            </div>
                                            <!-- Client -->
                                            <div class="mb-3">
                                                <label class="form-label">Client</label>
                                                <select name="client_id" class="form-select select2">
                                                    <option value="">Select a client</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                                            {{ $client->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <!-- Description -->
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control summernote" placeholder="Enter description">{!! $project->description !!}</textarea>

                                            </div>
                                            <!-- Type -->
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
                                            <!-- Priority -->
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
                                            <!-- Tags -->
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
                                            <!-- Roles -->
                                            <div class="mb-3">
                                                <label class="form-label">Roles</label>
                                                <select name="roles[]" class="form-select select2" multiple>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $project->roles->contains($role->id) ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <!-- Users -->
                                            <div class="mb-3">
                                                <label class="form-label">Users</label>
                                                <select name="users[]" class="form-select select2" multiple>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $project->users->contains($user->id) ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <!-- Status -->
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select select2" required>
                                                    <option value="active"
                                                        {{ $project->status == 'active' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="inactive"
                                                        {{ $project->status == 'inactive' ? 'selected' : '' }}>Inactive
                                                    </option>
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
                            <td colspan="9" class="text-center">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Sample Project"
                            required>

                    </div>
                    <!-- Client -->
                    <div class="mb-3">
                        <label class="form-label">Client</label>
                        <select name="client_id" class="form-select select2">
                            <option value="">Select a client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Enter description"></textarea>

                    </div>
                    <!-- Type -->
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="project_type_id" class="form-select select2" required>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <!-- Priority -->
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="project_priority_id" class="form-select select2" required>
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <!-- Tags -->
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <select name="tags[]" class="form-select select2" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <!-- Roles -->
                    <div class="mb-3">
                        <label class="form-label">Roles</label>
                        <select name="roles[]" class="form-select select2" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <!-- Users -->
                    <div class="mb-3">
                        <label class="form-label">Users</label>
                        <select name="users[]" class="form-select select2" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select select2" required>
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
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

        // Delete project with SweetAlert confirmation
        function deleteProject(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this project?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "{{ url('projects') }}/" + id,
                            method: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(data) {
                            Swal.fire(
                                'Deleted!',
                                'Project has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function(xhr) {
                            Swal.fire(
                                'Failed!',
                                'Project deletion failed: ' + (xhr.responseJSON?.error || 'Unknown error'),
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endpush
