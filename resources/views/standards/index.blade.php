@extends('layouts.vertical', ['title' => 'Standards Management'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <!-- Summernote CSS - CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Summernote JS - CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="lead text-primary"><i class="ph-seal-check me-2"></i> Standards Management</h4>
                <div>
                    <a href="#" class="btn btn-main btn-sm" data-bs-toggle="modal" data-bs-target="#addStandardModal">
                        <i class="ph-plus me-2"></i> New Standard
                    </a>
                </div>
            </div>
        </div>



        {{-- <div class="card shadow-sm"> --}}
        {{-- <div class="card-header bg-light">
                <h5 class="card-title mb-0">Standards</h5>
            </div> --}}
        <div class="card-body">
            <!-- Statistics Widgets -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 ">
                    <div class="card bg-primary text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-list display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Total Standards</p>
                                <p class="card-text h2 mb-0">{{ $totalStandards }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="card bg-success text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-check-circle display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Compliant Standards</p>
                                <p class="card-text h2 mb-0">{{ $complianceCounts['compliant'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="card bg-warning text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-warning-circle display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Partially Compliant</p>
                                <p class="card-text h2 mb-0">{{ $complianceCounts['partially_compliant'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="card bg-danger text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-x-circle display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Non-Compliant Standards</p>
                                <p class="card-text h2 mb-0">{{ $complianceCounts['non_compliant'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Standards Table -->
            @if (session('msg'))
                <div class="alert alert-success col-md-8 mx-auto" role="alert">
                    {{ session('msg') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger col-md-8 mx-auto" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table id="standardsTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Name</th>
                        {{-- <th>System</th> --}}
                        <th>Compliance Status</th>
                        <th>Creator</th>
                        <th>Updated By</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($standards as $index => $standard)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $standard->name }}</td>
                            {{-- <td><a href="{{ route('systems.show', $standard->system) }}">{{ $standard->system->name }}</a> --}}
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $standard->compliance_status === 'compliant' ? 'success' : ($standard->compliance_status === 'non_compliant' ? 'danger' : ($standard->compliance_status === 'partially_compliant' ? 'warning' : 'secondary')) }}">
                                    {{ ucwords(str_replace('_', ' ', $standard->compliance_status)) }}
                                </span>
                            </td>
                            <td>{{ $standard->creator->name }}</td>
                            <td>{{ $standard->updater ? $standard->updater->name : '-' }}</td>
                            <td>{{ $standard->created_at->format('Y-m-d H:i') }}</td>
                            <td width="18%">
                                <a href="#" title="View Standard" class="btn btn-sm btn-brand "
                                    data-bs-toggle="modal" data-bs-target="#viewStandardModal{{ $standard->id }}">
                                    <i class="ph-info"></i>
                                </a>
                                <a href="#" title="Edit Standard" class="btn btn-sm btn-main mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editStandardModal{{ $standard->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Standard" class="btn btn-sm btn-danger "
                                    onclick="deleteStandard({{ $standard->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No standards found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Add Standard Modal -->
    <div class="modal fade" id="addStandardModal" tabindex="-1" aria-labelledby="addStandardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <form method="POST" action="{{ route('standards.store') }}" id="addStandardForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStandardModalLabel">Add Standard</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Enter standard name (e.g., OWASP Top 10)" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label">System</label>
                            <select name="system_id" class="form-select select2" required>
                                <option value="">Select a system</option>
                                @foreach ($systems as $system)
                                    <option value="{{ $system->id }}"
                                        {{ old('system_id') == $system->id ? 'selected' : '' }}>{{ $system->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">Compliance Status</label>
                            <select name="compliance_status" class="form-select" required>
                                <option value="compliant"
                                    {{ old('compliance_status') === 'compliant' ? 'selected' : '' }}>
                                    Compliant</option>
                                <option value="non_compliant"
                                    {{ old('compliance_status') === 'non_compliant' ? 'selected' : '' }}>Non-Compliant
                                </option>
                                <option value="partially_compliant"
                                    {{ old('compliance_status') === 'partially_compliant' ? 'selected' : '' }}>Partially
                                    Compliant</option>
                                <option value="not_applicable"
                                    {{ old('compliance_status') === 'not_applicable' ? 'selected' : '' }}>Not Applicable
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote" placeholder="Enter standard description">{!! old('description') !!}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Standard</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add View Standard Modal after the Edit Standard Modal loop -->
    @foreach ($standards as $standard)
        <!-- View Standard Modal -->
        <div class="modal fade" id="viewStandardModal{{ $standard->id }}" tabindex="-1"
            aria-labelledby="viewStandardModalLabel{{ $standard->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewStandardModalLabel{{ $standard->id }}">
                            Standard: {{ $standard->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <p>{{ $standard->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Compliance Status</label>
                            <p>
                                <span
                                    class="badge bg-{{ $standard->compliance_status === 'compliant' ? 'success' : ($standard->compliance_status === 'non_compliant' ? 'danger' : ($standard->compliance_status === 'partially_compliant' ? 'warning' : 'secondary')) }}">
                                    {{ ucwords(str_replace('_', ' ', $standard->compliance_status)) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Creator</label>
                            <p>{{ $standard->creator->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Updated By</label>
                            <p>{{ $standard->updater ? $standard->updater->name : '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created At</label>
                            <p>{{ $standard->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <div class="border p-3 rounded">{!! $standard->description !!}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('standards.download', $standard->id) }}" class="btn btn-success">
                            <i class="ph-download-simple me-2"></i>Download
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Edit Standard Modal -->
    @foreach ($standards as $standard)
        <div class="modal fade" id="editStandardModal{{ $standard->id }}" tabindex="-1"
            aria-labelledby="editStandardModalLabel{{ $standard->id }}" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <form method="POST" action="{{ route('standards.update', $standard) }}"
                        id="editStandardForm{{ $standard->id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editStandardModalLabel{{ $standard->id }}">Edit Standard:
                                {{ $standard->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $standard->name) }}"
                                    placeholder="Enter standard name (e.g., OWASP Top 10)" required>
                            </div>
                            {{-- <div class="mb-3">
                                <label class="form-label">System</label>
                                <select name="system_id" class="form-select select2" required>
                                    <option value="">Select a system</option>
                                    @foreach ($systems as $system)
                                        <option value="{{ $system->id }}"
                                            {{ old('system_id', $standard->system_id) == $system->id ? 'selected' : '' }}>
                                            {{ $system->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Compliance Status</label>
                                <select name="compliance_status" class="form-select" required>
                                    <option value="compliant"
                                        {{ old('compliance_status', $standard->compliance_status) === 'compliant' ? 'selected' : '' }}>
                                        Compliant</option>
                                    <option value="non_compliant"
                                        {{ old('compliance_status', $standard->compliance_status) === 'non_compliant' ? 'selected' : '' }}>
                                        Non-Compliant</option>
                                    <option value="partially_compliant"
                                        {{ old('compliance_status', $standard->compliance_status) === 'partially_compliant' ? 'selected' : '' }}>
                                        Partially Compliant</option>
                                    <option value="not_applicable"
                                        {{ old('compliance_status', $standard->compliance_status) === 'not_applicable' ? 'selected' : '' }}>
                                        Not Applicable</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control summernote" placeholder="Enter standard description">{!! old('description', $standard->description) !!}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update Standard</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .card {
            border: none;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-bottom: 1px solid #e9ecef;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>

    @push('footer-script')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: 'Select a system',
                    allowClear: true,
                    width: '100%'
                });

                $('.summernote').summernote({
                    height: 200,
                    placeholder: 'Enter standard description',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'hr']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });

                window.deleteStandard = function(id) {
                    Swal.fire({
                        title: 'Confirm Deletion',
                        text: 'Are you sure you want to delete this standard? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                    url: "{{ route('standards.destroy', ':id') }}".replace(':id', id),
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                })
                                .done(function() {
                                    Swal.fire('Deleted!', 'Standard has been deleted successfully.',
                                        'success');
                                    setTimeout(() => location.reload(), 500);
                                })
                                .fail(function(xhr) {
                                    Swal.fire('Failed!', 'Standard deletion failed: ' + (xhr
                                        .responseJSON?.error || 'Unknown error'), 'error');
                                });
                        }
                    });
                };
            });
        </script>
    @endpush
@endsection
