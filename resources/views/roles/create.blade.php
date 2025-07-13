@extends('layouts.vertical', ['title' => 'Create Role'])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-key text-secondary"></i> Create Role
                </h4>
                <a href="{{ route('roles.index') }}" class="btn btn-brand btn-sm">
                    <i class="ph-arrow-left me-2"></i> Back to Roles
                </a>
            </div>
        </div>

        @if (session('msg'))
            <div class="alert alert-success col-md-8 mx-auto" role="alert">
                {{ session('msg') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger col-md-8 mx-auto" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="Enter role name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <h5 class="text-primary mb-3">Permissions</h5>
                    @if ($permissions->isNotEmpty())
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            @foreach ($permissions as $permission)
                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            id="permission-{{ $permission->id }}" name="permissions[]"
                                            value="{{ $permission->name }}"
                                            {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            No permissions available. Please create permissions first.
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ph-check me-2"></i> Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
