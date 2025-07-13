@extends('layouts.vertical', ['title' => 'System Requirements: ' . $system->name])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-desktop text-secondary"></i> System Requirements: {{ $system->name }}
                </h4>
                <div>
                    <a href="{{ route('systems.show', $system) }}" class="btn btn-brand btn-sm me-2">
                        <i class="ph-arrow-left me-2"></i> Back to System Details
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addRequirementModal">
                        <i class="ph-check-circle me-2"></i> Add Requirement
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="requirementsTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Creator</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($system->requirements as $index => $requirement)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $requirement->title }}</td>
                            <td>{!! Str::limit(strip_tags($requirement->description ?? ''), 50) !!}</td>
                            <td>{{ ucwords($requirement->priority) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $requirement->status)) }}</td>
                            <td>{{ $requirement->creator?->name ?? '--' }}</td>
                            <td>{{ $requirement->created_at->format('Y-m-d H:i') }}</td>
                            <td width="15%">
                                <a href="#" title="Edit Requirement" class="btn btn-sm btn-main me-1"
                                    data-bs-toggle="modal" data-bs-target="#editRequirementModal{{ $requirement->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Requirement" class="btn btn-sm btn-danger"
                                    onclick="deleteRequirement({{ $requirement->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No requirements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Requirement Modals -->
    @include('systems.partials.requirement-modals')
@endsection

@push('head-script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select an option',
                allowClear: true,
                width: '100%'
            });

            $('.summernote').summernote({
                height: 200,
                placeholder: 'Enter details',
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

            window.deleteRequirement = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this requirement?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: "{{ route('systems.destroyRequirement', [$system, ':id']) }}"
                                    .replace(':id', id),
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            })
                            .done(function() {
                                Swal.fire('Deleted!', 'Requirement has been deleted successfully.',
                                    'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            })
                            .fail(function(xhr) {
                                Swal.fire('Failed!', xhr.responseJSON.message ||
                                    'Requirement deletion failed.', 'error');
                            });
                    }
                });
            };
        });
    </script>
@endpush
