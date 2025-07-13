@extends('layouts.vertical', ['title' => 'Roles Management'])

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

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
                <i class="ph-key text-secondary"></i> Roles Management
            </h4>
            <a href="{{ route('roles.create') }}" class="btn btn-brand btn-sm">
                <i class="ph-plus me-2"></i> Create Role
            </a>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        @if ($roles->isNotEmpty())
            <table id="rolesTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = $roles->firstItem(); @endphp
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @php
                                    $permissions = $role->permissions->pluck('name');
                                    $displayCount = 3;
                                @endphp
                                {{ $permissions->take($displayCount)->implode(', ') }}
                                @if ($permissions->count() > $displayCount)
                                    ...
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>
                            <td width="18%">
                                <a href="{{ route('roles.edit', $role->id) }}" title="Edit Role" class="btn btn-sm btn-main">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Role" class="btn btn-sm btn-danger" onclick="deleteRole({{ $role->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $roles->links() }}
            </div>
        @else
            <div class="alert alert-info" role="alert">
                No roles found. Create a new role to get started.
            </div>
        @endif
    </div>
</div>
@endsection

@push('footer-script')
    <script>
        function deleteRole(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this role?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('roles') }}/" + id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Role has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Role deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush
