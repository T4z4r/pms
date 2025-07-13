@extends('layouts.vertical', ['title' => 'Create Permission'])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-shield-check text-secondary"></i> Create Permission
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
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Permission Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., view dashboard"
                        value="{{ old('name') }}" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Permission</button>
                </div>
            </form>
        </div>
    </div>
@endsection
