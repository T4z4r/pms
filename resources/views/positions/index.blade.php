@extends('layouts.backend')

@section('content')
<!-- Hero Section -->
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Positions</h2>
            <p class="text-muted">Manage all user positions here.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPositionModal">
            <i class="fa fa-plus"></i> New Position
        </button>
    </div>

    <!-- Table -->
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
                    @forelse($positions as $index => $position)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $position->name }}</td>
                            <td>
                                <span class="badge bg-{{ $position->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($position->status) }}
                                </span>
                            </td>
                            <td>{{ $position->created_at->format('Y-m-d') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editPositionModal{{ $position->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('positions.destroy', $position->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editPositionModal{{ $position->id }}" tabindex="-1"
                             aria-labelledby="editPositionModalLabel{{ $position->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form class="modal-content" method="POST"
                                      action="{{ route('positions.update', $position->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Position</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                   value="{{ $position->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active" {{ $position->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $position->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                            <td colspan="5" class="text-center">No positions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createPositionModal" tabindex="-1" aria-labelledby="createPositionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('positions.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">New Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Position Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Manager, Developer" required>
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

