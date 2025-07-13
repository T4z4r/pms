@extends('layouts.vertical', ['title' => 'Edit Permission'])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-shield-check text-secondary"></i> Edit Permission
                </h4>
                <a href="{{ route('permissions.index') }}" class="btn btn-brand btn-sm">
                    <i class="ph-arrow-left me-2"></i> Back to Permissions
                </a>
            </div>
        </div>

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
            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Permission Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}"
                        required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Permission</button>
                </div>
            </form>
        </div>
    </div>
@endsection
