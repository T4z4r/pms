@extends('layouts.vertical', ['title' => 'Systems'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <!-- Summernote CSS - CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
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
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-desktop text-secondary"></i> Systems
            </h4>
            <div>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#createSystemModal">
                    <i class="ph-plus me-2"></i> New System
                </a>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#assignUserSystemModal">
                    <i class="ph-user-plus me-2"></i> Assign to User
                </a>
                <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#assignAllSystemModal">
                    <i class="ph-users me-2"></i> Assign to All
                </a>
            </div>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <table id="systemsTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Projects</th>
                    <th>Status</th>
                    <th>Creator</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($systems as $index => $system)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $system->name }}</td>
                        <td>{!! Str::limit(strip_tags($system->description ?? ''), 50) !!}</td>
                        <td>{{ $system->projects->pluck('name')->implode(', ') ?: '-' }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $system->status)) }}</td>
                        <td>{{ $system->creator->name }}</td>
                        <td>{{ $system->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="{{ route('systems.show', $system) }}" title="View System" class="btn btn-sm btn-main me-1">
                                <i class="ph-info"></i>
                            </a>
                            <a href="#" title="Edit System" class="btn btn-sm btn-main me-1" data-bs-toggle="modal" data-bs-target="#editSystemModal{{ $system->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" title="Delete System" class="btn btn-sm btn-danger" onclick="deleteSystem({{ $system->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editSystemModal{{ $system->id }}" tabindex="-1" aria-labelledby="editSystemModalLabel{{ $system->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('systems.update', $system) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSystemModalLabel{{ $system->id }}">Edit System</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $system->name) }}" placeholder="Enter system name (e.g., Web App)" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" id="description_{{ $system->id }}" class="form-control summernote" placeholder="Enter system details">{!! old('description', $system->description) !!}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Projects</label>
                                            <select name="project_ids[]" class="form-select select2" multiple required>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}" {{ in_array($project->id, old('project_ids', $system->projects->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ old('status', $system->status) === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $system->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="under_development" {{ old('status', $system->status) === 'under_development' ? 'selected' : '' }}>Under Development</option>
                                                <option value="deprecated" {{ old('status', $system->status) === 'deprecated' ? 'selected' : '' }}>Deprecated</option>
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
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No systems found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create System Modal -->
<div class="modal fade" id="createSystemModal" tabindex="-1" aria-labelledby="createSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('systems.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createSystemModalLabel">New System</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter system name (e.g., Web App)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description_create" class="form-control summernote" placeholder="Enter system details">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Projects</label>
                        <select name="project_ids[]" class="form-select select2" multiple required>
                            <option value="">Select projects</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ in_array($project->id, old('project_ids', [])) ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="under_development" {{ old('status') === 'under_development' ? 'selected' : '' }}>Under Development</option>
                            <option value="deprecated" {{ old('status') === 'deprecated' ? 'selected' : '' }}>Deprecated</option>
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
</div>

<!-- Assign to User Modal -->
<div class="modal fade" id="assignUserSystemModal" tabindex="-1" aria-labelledby="assignUserSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('systems.storeForUser') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignUserSystemModalLabel">Assign System to User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Assign to User</label>
                        <select name="assigned_to" class="form-select select2" required>
                            <option value="">Select a user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter system name (e.g., Web App)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description_assign" class="form-control summernote" placeholder="Enter system details">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Projects</label>
                        <select name="project_ids[]" class="form-select select2" multiple required>
                            <option value="">Select projects</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ in_array($project->id, old('project_ids', [])) ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="under_development" {{ old('status') === 'under_development' ? 'selected' : '' }}>Under Development</option>
                            <option value="deprecated" {{ old('status') === 'deprecated' ? 'selected' : '' }}>Deprecated</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign to All Modal -->
<div class="modal fade" id="assignAllSystemModal" tabindex="-1" aria-labelledby="assignAllSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('systems.storeForAll') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignAllSystemModalLabel">Assign System to All Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter system name (e.g., Web App)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description_all" class="form-control summernote" placeholder="Enter system details">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Projects</label>
                        <select name="project_ids[]" class="form-select select2" multiple required>
                            <option value="">Select projects</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ in_array($project->id, old('project_ids', [])) ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="under_development" {{ old('status') === 'under_development' ? 'selected' : '' }}>Under Development</option>
                            <option value="deprecated" {{ old('status') === 'deprecated' ? 'selected' : '' }}>Deprecated</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign</button>
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
            $('.select2').select2({
                placeholder: 'Select a user or project',
                allowClear: true,
                width: '100%'
            });

            $('.summernote').summernote({
                height: 200,
                placeholder: 'Enter system details',
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

            window.deleteSystem = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this system?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('systems.destroy', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function() {
                            Swal.fire(
                                'Deleted!',
                                'System has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'System deletion failed.',
                                'error'
                            );
                        });
                    }
                });
            };
        });
    </script>
@endpush
