@extends('layouts.vertical', ['title' => 'Project Priorities'])

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
                <i class="ph-sort-ascending text-secondary"></i> Project Priorities
            </h4>
            <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#createProjectPriorityModal">
                <i class="ph-plus me-2"></i> New Priority
            </a>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <table id="projectPrioritiesTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($priorities as $index => $priority)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $priority->name }}</td>
                        <td>{{ $priority->level }}</td>
                        <td>
                            <span class="badge bg-{{ $priority->status == 'active' ? 'success bg-opacity-10 text-success' : 'danger bg-opacity-10 text-danger' }}">
                                {{ ucfirst($priority->status) }}
                            </span>
                        </td>
                        <td>{{ $priority->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="#" title="Edit Priority" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editProjectPriorityModal{{ $priority->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" title="Delete Priority" class="btn btn-sm btn-danger" onclick="deleteProjectPriority({{ $priority->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editProjectPriorityModal{{ $priority->id }}" tabindex="-1" aria-labelledby="editProjectPriorityModalLabel{{ $priority->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" method="POST" action="{{ route('project_priorities.update', $priority) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProjectPriorityModalLabel{{ $priority->id }}">Edit Priority</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $priority->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Level</label>
                                        <input type="number" name="level" class="form-control" value="{{ $priority->level }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="active" {{ $priority->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $priority->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                        <td colspan="6" class="text-center">No priorities found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createProjectPriorityModal" tabindex="-1" aria-labelledby="createProjectPriorityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('project_priorities.store') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectPriorityModalLabel">New Priority</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. High" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Level</label>
                    <input type="number" name="level" class="form-control" placeholder="e.g. 3" required>
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
        function deleteProjectPriority(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this project priority?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('project_priorities') }}/" + id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Project priority has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Project priority deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush