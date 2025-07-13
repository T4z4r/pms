@extends('layouts.vertical', ['title' => 'Document Management'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
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
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-file-text text-secondary"></i> Document Management
            </h4>
            <div>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#createDocumentModal">
                    <i class="ph-plus me-2"></i> New Document
                </a>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#assignUserDocumentModal">
                    <i class="ph-user-plus me-2"></i> Assign to User
                </a>
            </div>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body table-responsive">
        <table id="documentsTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Project</th>
                    <th>Type</th>
                    <th>File</th>
                    <th>Version</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Color</th>
                    <th>Creator</th>
                    <th>Assignee</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $index => $document)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $document->title }}</td>
                        <td>{!! Str::limit(strip_tags($document->latestVersion ? $document->latestVersion->content : ''), 50) !!}</td>
                        <td>{{ $document->project?->name ?? '-' }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $document->type)) }}</td>
                        <td>
                            @if ($document->latestVersion && $document->latestVersion->file_path)
                                <a href="{{ Storage::url($document->latestVersion->file_path) }}" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $document->latestVersion ? $document->latestVersion->version_number : 1 }}</td>
                        <td>{{ $document->start_date->format('Y-m-d H:i') }}</td>
                        <td>{{ $document->end_date?->format('Y-m-d H:i') ?? '-' }}</td>
                        <td><span class="badge" style="background-color: {{ $document->color }}">{{ $document->color }}</span></td>
                        <td>{{ $document->creator->name }}</td>
                        <td>{{ $document->assignee?->name ?? '-' }}</td>
                        <td>{{ $document->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="#" title="Edit Document" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editDocumentModal{{ $document->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            <a href="{{ route('documents.versions', $document) }}" title="View Versions" class="btn btn-sm btn-info">
                                <i class="ph-list"></i>
                            </a>
                            <a href="javascript:void(0)" title="Delete Document" class="btn btn-sm btn-danger" onclick="deleteDocument({{ $document->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editDocumentModal{{ $document->id }}" tabindex="-1" aria-labelledby="editDocumentModalLabel{{ $document->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('documents.update', $document) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editDocumentModalLabel{{ $document->id }}">Edit Document (Version {{ $document->latestVersion ? $document->latestVersion->version_number + 1 : 1 }})</h5>
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
                                            <input type="text" name="title" class="form-control" value="{{ old('title', $document->title) }}" placeholder="Enter document title (e.g., Risk Assessment)" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Content</label>
                                            <textarea name="content" class="form-control summernote" placeholder="Enter document content (e.g., project details, notes)">{!! old('content', $document->latestVersion ? $document->latestVersion->content : '') !!}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Project</label>
                                            <select name="project_id" class="form-select">
                                                <option value="">No Project</option>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}" {{ old('project_id', $document->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select name="type" class="form-select" required>
                                                <option value="project_document" {{ old('type', $document->type) === 'project_document' ? 'selected' : '' }}>Project Document</option>
                                                <option value="template" {{ old('type', $document->type) === 'template' ? 'selected' : '' }}>Template</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">File (PDF, DOC, DOCX)</label>
                                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx">
                                            @if ($document->latestVersion && $document->latestVersion->file_path)
                                                <small>Current file: <a href="{{ Storage::url($document->latestVersion->file_path) }}" target="_blank">View</a></small>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', $document->start_date->format('Y-m-d\TH:i')) }}" placeholder="Select start date and time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $document->end_date?->format('Y-m-d\TH:i')) }}" placeholder="Select end date and time (optional)">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Color</label>
                                            <input type="color" name="color" class="form-control h-10" value="{{ old('color', $document->color) }}" placeholder="Select calendar color" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save New Version</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="14" class="text-center">No documents found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Document Modal -->
<div class="modal fade" id="createDocumentModal" tabindex="-1" aria-labelledby="createDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createDocumentModalLabel">New Document (Version 1)</h5>
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
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter document title (e.g., Risk Assessment)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control summernote" placeholder="Enter document content (e.g., project details, notes)">{!! old('content') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select">
                            <option value="">No Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="project_document" {{ old('type') === 'project_document' ? 'selected' : '' }}>Project Document</option>
                            <option value="template" {{ old('type') === 'template' ? 'selected' : '' }}>Template</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File (PDF, DOC, DOCX)</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" placeholder="Upload a file (optional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}" placeholder="Select start date and time" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}" placeholder="Select end date and time (optional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" class="form-control h-10" value="{{ old('color', '#3788d8') }}" placeholder="Select calendar color" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign to User Modal -->
<div class="modal fade" id="assignUserDocumentModal" tabindex="-1" aria-labelledby="assignUserDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('documents.storeForUser') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignUserDocumentModalLabel">Assign Document to User (Version 1)</h5>
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
                        <label class="form-label">Assign to User</label>
                        <select name="assigned_to" class="form-select select2" required>
                            <option value="">Select a user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter document title (e.g., Security Checklist)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control summernote" placeholder="Enter document content (e.g., project details, notes)">{!! old('content') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select">
                            <option value="">No Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="project_document" {{ old('type') === 'project_document' ? 'selected' : '' }}>Project Document</option>
                            <option value="template" {{ old('type') === 'template' ? 'selected' : '' }}>Template</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File (PDF, DOC, DOCX)</label>
                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" placeholder="Upload a file (optional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}" placeholder="Select start date and time" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}" placeholder="Select end date and time (optional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" class="form-control h-10" value="{{ old('color', '#3788d8') }}" placeholder="Select calendar color" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Assign</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select a user',
                allowClear: true,
                width: '100%'
            });

            $('.summernote').summernote({
                height: 200,
                placeholder: 'Enter document content (e.g., project details, notes)',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });

            window.deleteDocument = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this document?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('documents.destroy', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function() {
                            Swal.fire(
                                'Deleted!',
                                'Document has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Document deletion failed.',
                                'error'
                            );
                        });
                    }
                });
            };
        });
    </script>
@endpush
