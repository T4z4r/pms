@extends('layouts.vertical', ['title' => 'Users Management'])

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
                    <i class="ph-users text-secondary"></i> Users Management
                </h4>
                <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="ph-plus me-2"></i> Add User
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success col-md-8 mx-auto" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="card-body">
            <table id="usersTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                            <td width="18%">
                                <a href="#" title="Edit User" class="btn btn-sm btn-main" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $user->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    class="d-inline delete-user-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-user-btn"
                                        data-id="{{ $user->id }}">
                                        <i class="ph-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('users-roles.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                <label for="name{{ $user->id }}" class="form-label">Name</label>
                                                <input type="text" name="name" id="name{{ $user->id }}"
                                                    class="form-control" value="{{ old('name', $user->name) }}" required
                                                    aria-describedby="nameError{{ $user->id }}">
                                                @error('name')
                                                    <span id="nameError{{ $user->id }}"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="email{{ $user->id }}" class="form-label">Email</label>
                                                <input type="email" name="email" id="email{{ $user->id }}"
                                                    class="form-control" value="{{ old('email', $user->email) }}" required
                                                    aria-describedby="emailError{{ $user->id }}">
                                                @error('email')
                                                    <span id="emailError{{ $user->id }}"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="password{{ $user->id }}" class="form-label">New Password
                                                    (leave blank to keep current)</label>
                                                <input type="password" name="password" id="password{{ $user->id }}"
                                                    class="form-control" placeholder="New Password"
                                                    aria-describedby="passwordError{{ $user->id }}">
                                                @error('password')
                                                    <span id="passwordError{{ $user->id }}"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_confirmation{{ $user->id }}"
                                                    class="form-label">Confirm Password</label>
                                                <input type="password" name="password_confirmation"
                                                    id="password_confirmation{{ $user->id }}" class="form-control"
                                                    placeholder="Confirm Password"
                                                    aria-describedby="passwordConfirmationError{{ $user->id }}">
                                                @error('password_confirmation')
                                                    <span id="passwordConfirmationError{{ $user->id }}"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="roles{{ $user->id }}" class="form-label">Roles</label>
                                                <select name="roles[]" id="roles{{ $user->id }}"
                                                    class="form-control select2" multiple>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                            {{ $user->roles->contains($role->name) ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('roles')
                                                    <span id="rolesError{{ $user->id }}"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"
                                                style="background-color: #1d5fc9; border-color: #1d5fc9;">Save
                                                Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{-- {{ $users->links() }} --}}
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('users-roles.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Roles</label>
                        <select name="roles[]" class="form-control select2" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('footer-script')
<script>
    $(document).on('click', '.delete-user-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var form = btn.closest('form');
        var userId = btn.data('id');

        Swal.fire({
            text: 'Are you sure you want to delete this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    method: "POST",
                    data: form.serialize(),
                })
                .done(function(data) {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted successfully.',
                        'success'
                    );
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                })
                .fail(function() {
                    Swal.fire(
                        'Failed!',
                        'User deletion failed.',
                        'error'
                    );
                });
            }
        });
    });
</script>
@endpush
