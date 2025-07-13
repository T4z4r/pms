@extends('layouts.vertical', ['title' => 'View System: ' . $system->name])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-desktop text-secondary"></i> System: {{ $system->name }}
                </h4>
                <div>
                    <a href="{{ route('systems.index') }}" class="btn btn-brand btn-sm me-2">
                        <i class="ph-arrow-left me-2"></i> Back to Systems
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addModuleModal">
                        <i class="ph-cube me-2"></i> Add Module
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addSubmoduleModal">
                        <i class="ph-cubes me-2"></i> Add Submodule
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addFeatureModal">
                        <i class="ph-gear me-2"></i> Add Feature
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addRequirementModal">
                        <i class="ph-check-circle me-2"></i> Add Requirement
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#exportModal">
                        <i class="ph-download-simple me-2"></i> Export Options
                    </button>
                </div>
            </div>
        </div>

        <!-- Export Options Modal -->
        @include('systems.partials.export-modal')

        @if (session('msg'))
            <div class="alert alert-success col-md-8 mx-auto" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger col-md-8 mx-auto" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <div class="mb-4">
                <h5>System Details</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <tbody>
                            <tr>
                                <th class="w-25">Name</th>
                                <td>{{ $system->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{!! $system->description ?? '-' !!}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucwords(str_replace('_', ' ', $system->status)) }}</td>
                            </tr>
                            <tr>
                                <th>Creator</th>
                                <td>{{ $system->creator?->name ?? '--' }}</td>
                            </tr>
                            <tr>
                                <th>Assignee</th>
                                <td>{{ $system->assignee?->name ?? ($system->is_all_users ? 'All Users' : '-') }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $system->created_at->format('Y-m-d') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Navigation Links -->
            <ul class="nav nav-pills mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('systems.show', $system) }}">Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('systems.projects', $system) }}">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('systems.modules', $system) }}">Modules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('systems.submodules', $system) }}">Submodules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('systems.features', $system) }}">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('systems.requirements', $system) }}">Requirements</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Include Modals -->
    @include('systems.partials.modals')
@endsection

@push('head-script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush
