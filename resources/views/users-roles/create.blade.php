@extends('layouts.vertical', ['title' => 'Create User'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-users text-secondary"></i> Create User
                </h4>
                <a href="{{ route('users-roles.index') }}" class="btn btn-brand btn-sm">
                    <i class="ph-arrow-left me-2"></i> Back to Users
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success col-md-8 mx-auto" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('users-roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name') }}" placeholder="Full Name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ old('email') }}" placeholder="Email" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Password" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control" placeholder="Confirm Password" required>
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Roles</label>
                    @if ($roles->isNotEmpty())
                        <select name="roles[]" class="form-control select2" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                        {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <div class="alert alert-info" role="alert">
                            No roles available. Please create roles first.
                        </div>
                    @endif
                    @error('roles')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" style="background-color: #1d5fc9; border-color: #1d5fc9;">
                        <i class="ph-check me-2"></i> Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
