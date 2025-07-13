@extends('layouts.vertical', ['title' => 'Security Gap Templates'])

@push('head-script')
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
<div class="card border-top border-top-width-3 border-top-black rounded-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-shield text-secondary"></i> Security Gap Templates
            </h4>
            <div>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                    <i class="ph-plus me-2"></i> New Template
                </a>
            </div>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <table id="templatesTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Version</th>
                    <th>Creator</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $index => $template)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $template->title }}</td>
                        <td>{!! Str::limit(strip_tags($template->description ?? ''), 50) !!}</td>
                        <td>{{ $template->version_number }}</td>
                        <td>{{ $template->creator->name }}</td>
                        <td>{{ $template->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="#" title="Edit Template" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editTemplateModal{{ $template->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" title="Delete Template" class="btn btn-sm btn-danger" onclick="deleteTemplate({{ $template->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editTemplateModal{{ $template->id }}" tabindex="-1" aria-labelledby="editTemplateModalLabel{{ $template->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('security-gap-templates.update', $template) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editTemplateModalLabel{{ $template->id }}">Edit Template (Version {{ $template->version_number + 1 }})</h5>
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
                                            <input type="text" name="title" class="form-control" value="{{ old('title', $template->title) }}" placeholder="Enter template title (e.g., A01:2021-Broken Access Control)" required>

                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" placeholder="Enter template details (e.g., mitigation steps)">{!! old('description', $template->description) !!}</textarea>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No templates found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Template Modal -->
<div class="modal fade" id="createTemplateModal" tabindex="-1" aria-labelledby="createTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('security-gap-templates.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTemplateModalLabel">New Template</h5>
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
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter template title (e.g., A01:2021-Broken Access Control)" required>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter template details (e.g., mitigation steps)">{!! old('description') !!}</textarea>

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
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            window.deleteTemplate = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this template?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('security-gap-templates.destroy', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function() {
                            Swal.fire(
                                'Deleted!',
                                'Template has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Template deletion failed.',
                                'error'
                            );
                        });
                    }
                });
            };
        });
    </script>
@endpush
