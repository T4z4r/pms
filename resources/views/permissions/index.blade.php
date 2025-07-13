@extends('layouts.vertical', ['title' => 'Permissions Management'])

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
                <i class="ph-shield-check text-secondary"></i> Permissions Management
            </h4>
            <a href="{{ route('permissions.create') }}" class="btn btn-brand btn-sm">
                <i class="ph-plus me-2"></i> Create Permission
            </a>
        </div>
    </div>

    @if (session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} col-md-8 mx-auto" role="alert">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <div class="card-body">
        @if ($permissions->isNotEmpty())
            <table id="permissionsTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                            <td width="18%">
                                <a href="{{ route('permissions.edit', $permission->id) }}" title="Edit Permission" class="btn btn-sm btn-main">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Permission" class="btn btn-sm btn-danger" onclick="deletePermission({{ $permission->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $permissions->links() }}
            </div>
        @else
            <div class="alert alert-info" role="alert">
                No permissions found. Create a new permission to get started.
            </div>
        @endif
    </div>
</div>
@endsection

@push('footer-script')
    <script>
        function deletePermission(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this permission?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('permissions') }}/" + id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Permission has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Permission deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush