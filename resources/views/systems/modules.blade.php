@extends('layouts.vertical', ['title' => 'System Modules: ' . $system->name])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-desktop text-secondary"></i> System Modules: {{ $system->name }}
                </h4>
                <div>
                    <a href="{{ route('systems.show', $system) }}" class="btn btn-brand btn-sm me-2">
                        <i class="ph-arrow-left me-2"></i> Back to System Details
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addModuleModal">
                        <i class="ph-cube me-2"></i> Add Module
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="modulesTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Order</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($system->modules->sortBy('order') as $index => $module)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $module->name }}</td>
                            <td>{!! Str::limit(strip_tags($module->description ?? ''), 50) !!}</td>
                            <td>{{ $module->order ?? '0' }}</td>
                            <td>{{ $module->created_at->format('Y-m-d H:i') }}</td>
                            <td width="15%">
                                <a href="#" title="Edit Module" class="btn btn-sm btn-main me-1"
                                    data-bs-toggle="modal" data-bs-target="#editModuleModal{{ $module->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Module" class="btn btn-sm btn-danger"
                                    onclick="deleteModule({{ $module->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No modules found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Module Modals -->
    @include('systems.partials.module-modals')
@endsection


@push('head-script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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

            window.deleteModule = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this module?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: "{{ route('systems.destroyModule', [$system, ':id']) }}"
                                    .replace(':id', id),
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            })
                            .done(function() {
                                Swal.fire('Deleted!', 'Module has been deleted successfully.',
                                    'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            })
                            .fail(function(xhr) {
                                Swal.fire('Failed!', xhr.responseJSON.message ||
                                    'Module deletion failed.', 'error');
                            });
                    }
                });
            };
        });
    </script>
@endpush
