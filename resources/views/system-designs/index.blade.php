@extends('layouts.vertical', ['title' => 'System Designs'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-cpu text-secondary"></i> System Designs
            </h4>
            <div class="text-end">
                <a href="#" class="btn btn-main btn-sm" data-bs-toggle="modal" data-bs-target="#addDesignModal">
                    <i class="ph-plus me-2"></i> New Design
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
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body table-responsive">
            <table id="designsTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>System</th>
                        <th>Preview</th>
                        <th>Creator</th>
                        <th>Updated By</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($designs as $index => $design)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $design->title }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $design->type)) }}</td>
                            <td><a href="{{ route('systems.show', $design->system) }}">{{ $design->system->name }}</a>
                            </td>
                            <td>
                                @if ($design->thumbnail_path && Storage::disk('public')->exists($design->thumbnail_path))
                                    <img src="{{ Storage::url($design->thumbnail_path) }}" alt="Thumbnail"
                                        style="max-width: 50px;" class="img-thumbnail">
                                @else
                                    No Preview
                                @endif
                            </td>
                            <td>{{ $design->creator->name }}</td>
                            <td>{{ $design->updater ? $design->updater->name : '-' }}</td>
                            <td>{{ $design->created_at->format('Y-m-d H:i') }}</td>
                            <td width="18%">
                                <a href="#" title="View Design" class="btn btn-sm btn-main" data-bs-toggle="modal"
                                    data-bs-target="#viewDesignModal{{ $design->id }}">
                                    <i class="ph-info"></i>
                                </a>
                                <a href="#" title="Edit Design" class="btn btn-sm btn-main mx-1"
                                    data-bs-toggle="modal" data-bs-target="#editDesignModal{{ $design->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Design" class="btn btn-sm btn-danger"
                                    onclick="deleteDesign({{ $design->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                                <a href="{{ Storage::url($design->image_path) }}" title="Download Design"
                                    class="btn btn-sm btn-success" download>
                                    <i class="ph-download-simple"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No designs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Design Modal -->
    <div class="modal fade" id="addDesignModal" tabindex="-1" aria-labelledby="addDesignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('system-designs.store') }}" id="addDesignForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDesignModalLabel">Add Design</h5>
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
                                placeholder="Enter design title (e.g., System ERD)" required>

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
                            <label class="form-label">Type</label>
                            <select name="type" id="designType" class="form-select" required>
                                <option value="erd" {{ old('type') === 'erd' ? 'selected' : '' }}>ERD</option>
                                <option value="class_diagram" {{ old('type') === 'class_diagram' ? 'selected' : '' }}>Class
                                    Diagram</option>
                                <option value="flowchart" {{ old('type') === 'flowchart' ? 'selected' : '' }}>Flowchart
                                </option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Design Image (PNG)</label>
                            <div class="mb-2">
                                <a href="{{ route('drawio.editor') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="ph-pencil me-2"></i> Create Design in Draw.io Editor
                                </a>
                                <small class="text-muted d-block">Create your design in the Draw.io Editor, download as PNG,
                                    and upload here.</small>
                            </div>
                            <input type="file" name="image" class="form-control" accept="image/png" required>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload Design</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Design Modal -->
    @foreach ($designs as $index => $design)
        <div class="modal fade" id="editDesignModal{{ $design->id }}" tabindex="-1"
            aria-labelledby="editDesignModalLabel{{ $design->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('system-designs.update', $design) }}"
                        id="editDesignForm{{ $design->id }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDesignModalLabel{{ $design->id }}">Edit Design:
                                {{ $design->title }}</h5>
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
                                    value="{{ old('title', $design->title) }}"
                                    placeholder="Enter design title (e.g., System ERD)" required>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">System</label>
                                <select name="system_id" class="form-select select2" required>
                                    <option value="">Select a system</option>
                                    @foreach ($systems as $system)
                                        <option value="{{ $system->id }}"
                                            {{ old('system_id', $design->system_id) == $system->id ? 'selected' : '' }}>
                                            {{ $system->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select name="type" id="editDesignType{{ $design->id }}" class="form-select"
                                    required>
                                    <option value="erd" {{ old('type', $design->type) === 'erd' ? 'selected' : '' }}>
                                        ERD</option>
                                    <option value="class_diagram"
                                        {{ old('type', $design->type) === 'class_diagram' ? 'selected' : '' }}>Class
                                        Diagram</option>
                                    <option value="flowchart"
                                        {{ old('type', $design->type) === 'flowchart' ? 'selected' : '' }}>Flowchart
                                    </option>
                                </select>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Design Image (PNG)</label>
                                <div class="mb-2">
                                    <a href="{{ route('drawio.editor') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="ph-pencil me-2"></i> Update Design in Draw.io Editor
                                    </a>
                                    <small class="text-muted d-block">Update your design in the Draw.io Editor, download as
                                        PNG, and upload here.</small>
                                </div>
                                <input type="file" name="image" class="form-control" accept="image/png">
                                <small class="text-muted">Current image:
                                    @if ($design->image_path && Storage::disk('public')->exists($design->image_path))
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#viewDesignModal{{ $design->id }}">View</a>
                                    @else
                                        Not available
                                    @endif
                                </small>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update Design</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      <!-- View Design Modal -->
<div class="modal fade" id="viewDesignModal{{ $design->id }}" tabindex="-1" aria-labelledby="viewDesignModalLabel{{ $design->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDesignModalLabel{{ $design->id }}">View Design: {{ $design->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if($design->image_path && Storage::disk('public')->exists($design->image_path))
                    <img src="{{ Storage::url($design->image_path) }}" alt="{{ $design->title }}" class="img-fluid" style="max-width: 100%; max-height: 600px;">
                @else
                    <div class="alert alert-warning">Design image not found.</div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @if($design->image_path && Storage::disk('public')->exists($design->image_path))
                    <a href="{{ Storage::url($design->image_path) }}" class="btn btn-primary" download>Download</a>
                @endif
            </div>
        </div>
    </div>
</div>

    @endforeach

    <style>
        img {
            max-width: 100%;
        }

        .img-fluid {
            object-fit: contain;
        }

        .img-thumbnail {
            cursor: pointer;
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

                window.deleteDesign = function(id) {
                    Swal.fire({
                        title: 'Confirm Deletion',
                        text: 'Are you sure you want to delete this design? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                    url: "{{ route('system-designs.destroy', ':id') }}".replace(':id',
                                        id),
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                })
                                .done(function() {
                                    Swal.fire('Deleted!', 'Design has been deleted successfully.',
                                        'success');
                                    setTimeout(() => location.reload(), 500);
                                })
                                .fail(function(xhr) {
                                    Swal.fire('Failed!', 'Design deletion failed: ' + (xhr.responseJSON
                                        ?.error || 'Unknown error'), 'error');
                                });
                        }
                    });
                };
            });
        </script>
    @endpush
@endsection
