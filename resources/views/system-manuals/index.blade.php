@extends('layouts.vertical', ['title' => 'System Manuals'])

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
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-book-open me-2"></i> System Manuals
                </h4>
                <a href="#" class="btn btn-main btn-sm" data-bs-toggle="modal" data-bs-target="#addManualModal">
                    <i class="ph-plus me-2"></i> New Manual
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Statistics Widgets -->
            <div class="row mb-1">
                <div class="col-lg-6 col-md-6 mb-3">
                    <div class="card bg-primary text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-book-open display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Total Manuals</->
                                <p class="card-text h2 mb-0">{{ $totalManuals }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mb-3">
                    <div class="card bg-success text-white shadow-sm h-60">
                        <div class="card-body d-flex align-items-center">
                            <i class="ph-desktop display-6 me-3"></i>
                            <div>
                                <p class="title mb-0">Systems with Manuals</->
                                <p class="card-text h2 mb-0">{{ count($manualsBySystem) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Manuals Table -->
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
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Manuals</h5>
                </div>
                <div class="card-body">
                    <table id="manualsTable" class="table table-striped table-bordered datatable-basic">
                        <thead>
                            <tr>
                                <th>SN.</th>
                                <th>Title</th>
                                <th>System</th>
                                <th>Creator</th>
                                <th>Updated By</th>
                                <th>Created At</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($manuals as $index => $manual)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $manual->title }}</td>
                                    <td><a
                                            href="{{ route('systems.show', $manual->system) }}">{{ $manual->system->name }}</a>
                                    </td>
                                    <td>{{ $manual->creator->name }}</td>
                                    <td>{{ $manual->updater ? $manual->updater->name : '-' }}</td>
                                    <td>{{ $manual->created_at->format('Y-m-d H:i') }}</td>
                                    <td width="18%">
                                        <a href="#" title="View Manual" class="btn btn-sm btn-main me-1"
                                            data-bs-toggle="modal" data-bs-target="#viewManualModal{{ $manual->id }}">
                                            <i class="ph-info"></i>
                                        </a>
                                        <a href="#" title="Edit Manual" class="btn btn-sm btn-main me-1"
                                            data-bs-toggle="modal" data-bs-target="#editManualModal{{ $manual->id }}">
                                            <i class="ph-note-pencil"></i>
                                        </a>
                                        <a href="javascript:void(0)" title="Delete Manual"
                                            class="btn btn-sm btn-danger me-1" onclick="deleteManual({{ $manual->id }})">
                                            <i class="ph-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No manuals found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- Add Manual Modal -->
    <div class="modal fade" id="addManualModal" tabindex="-1" aria-labelledby="addManualModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('system-manuals.store') }}" id="addManualForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addManualModalLabel">Add Manual</h5>
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
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Enter manual title (e.g., User Guide)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">System</label>
                            <select name="system_id" class="form-select select2" required>
                                <option value="">Select a system</option>
                                @foreach ($systems as $system)
                                    <option value="{{ $system->id }}"
                                        {{ old('system_id') == $system->id ? 'selected' : '' }}>{{ $system->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter a brief description">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" class="form-control summernote" placeholder="Enter manual content" required>{!! old('content') !!}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Manual</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Manual Modal -->
    @foreach ($manuals as $manual)
        <div class="modal fade" id="editManualModal{{ $manual->id }}" tabindex="-1"
            aria-labelledby="editManualModalLabel{{ $manual->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form method="POST" action="{{ route('system-manuals.update', $manual) }}"
                        id="editManualForm{{ $manual->id }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editManualModalLabel{{ $manual->id }}">Edit Manual:
                                {{ $manual->title }}</h5>
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
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $manual->title) }}"
                                    placeholder="Enter manual title (e.g., User Guide)" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">System</label>
                                <select name="system_id" class="form-select select2" required>
                                    <option value="">Select a system</option>
                                    @foreach ($systems as $system)
                                        <option value="{{ $system->id }}"
                                            {{ old('system_id', $manual->system_id) == $system->id ? 'selected' : '' }}>
                                            {{ $system->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter a brief description">{{ old('description', $manual->description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea name="content" class="form-control summernote" placeholder="Enter manual content" required>{!! old('content', $manual->content) !!}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update Manual</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- View Manual Modal -->
    @foreach ($manuals as $manual)
        <div class="modal fade" id="viewManualModal{{ $manual->id }}" tabindex="-1"
            aria-labelledby="viewManualModalLabel{{ $manual->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewManualModalLabel{{ $manual->id }}">View Manual:
                            {{ $manual->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Description:</h6>
                        <p>{{ $manual->description ?: 'No description provided.' }}</p>
                        <h6>Content:</h6>
                        <div class="border p-3" style="min-height: 300px;">
                            {!! $manual->content !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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
                    height: 400,
                    placeholder: 'Enter manual content',
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

                window.deleteManual = function(id) {
                    Swal.fire({
                        title: 'Confirm Deletion',
                        text: 'Are you sure you want to delete this manual? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                    url: "{{ route('system-manuals.destroy', ':id') }}".replace(':id',
                                        id),
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                })
                                .done(function() {
                                    Swal.fire('Deleted!', 'Manual has been deleted successfully.',
                                        'success');
                                    setTimeout(() => location.reload(), 500);
                                })
                                .fail(function(xhr) {
                                    Swal.fire('Failed!', 'Manual deletion failed: ' + (xhr.responseJSON
                                        ?.error || 'Unknown error'), 'error');
                                });
                        }
                    });
                };
            });
        </script>
    @endpush
@endsection
