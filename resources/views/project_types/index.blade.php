@extends('layouts.vertical', ['title' => 'Project Types'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
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
                <i class="ph-folder text-secondary"></i> Project Types
            </h4>
            <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#createProjectTypeModal">
                <i class="ph-plus me-2"></i> New Project Type
            </a>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <table id="projectTypesTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($types as $index => $type)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->description }}</td>
                        <td>
                            <span class="badge bg-{{ $type->status == 'active' ? 'success bg-opacity-10 text-success' : 'danger bg-opacity-10 text-danger' }}">
                                {{ ucfirst($type->status) }}
                            </span>
                        </td>
                        <td>{{ $type->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="#" title="Edit Project Type" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editProjectTypeModal{{ $type->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" title="Delete Project Type" class="btn btn-sm btn-danger" onclick="deleteProjectType({{ $type->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editProjectTypeModal{{ $type->id }}" tabindex="-1" aria-labelledby="editProjectTypeModalLabel{{ $type->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" method="POST" action="{{ route('project_types.update', $type) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProjectTypeModalLabel{{ $type->id }}">Edit Project Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $type->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control">{{ $type->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="active" {{ $type->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $type->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <td colspan="6" class="text-center">No project types found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createProjectTypeModal" tabindex="-1" aria-labelledby="createProjectTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('project_types.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectTypeModalLabel">New Project Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Web Development" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
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
        function deleteProjectType(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this project type?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('project_types') }}/" + id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Project type has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Project type deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush