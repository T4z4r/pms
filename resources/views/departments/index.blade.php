@extends('layouts.backend')

@section('content')
<!-- Hero Section -->
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Departments</h2>
            <p class="text-muted">Manage all company departments here.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
            <i class="fa fa-plus"></i> New Department
        </button>
    </div>

    <!-- Departments Table -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $index => $department)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $department->name }}</td>
                            <td>
                                <span class="badge bg-{{ $department->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($department->status) }}
                                </span>
                            </td>
                            <td>{{ $department->created_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editDepartmentModal{{ $department->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Department Modal -->
                        <div class="modal fade" id="editDepartmentModal{{ $department->id }}" tabindex="-1"
                             aria-labelledby="editDepartmentModalLabel{{ $department->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form class="modal-content" method="POST"
                                      action="{{ route('departments.update', $department->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Department</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                   value="{{ $department->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ $department->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $department->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No departments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Department Modal -->
<div class="modal fade" id="createDepartmentModal" tabindex="-1" aria-labelledby="createDepartmentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('departments.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">New Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Department Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. IT, HR, Finance" required>
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
