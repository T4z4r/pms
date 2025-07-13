@extends('layouts.vertical', ['title' => 'System Features: ' . $system->name])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-desktop text-secondary"></i> System Features: {{ $system->name }}
                </h4>
                <div>
                    <a href="{{ route('systems.show', $system) }}" class="btn btn-brand btn-sm me-2">
                        <i class="ph-arrow-left me-2"></i> Back to System Details
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#addFeatureModal">
                        <i class="ph-gear me-2"></i> Add Feature
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="featuresTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Module</th>
                        <th>Submodule</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Creator</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupedFeatures = $system->features
                            ->sortBy('module.order')
                            ->groupBy(fn($f) => $f->module->name ?? 'Uncategorized');
                        $rowIndex = 1;
                    @endphp

                    @forelse($groupedFeatures as $moduleName => $features)
                        <tr class="table-primary">
                            <td colspan="9" class="fw-bold">{{ $moduleName }}</td>
                        </tr>
                        @foreach ($features as $feature)
                            <tr>
                                <td>{{ $rowIndex++ }}</td>
                                <td>{{ $feature->module->name ?? 'N/A' }}</td>
                                <td>{{ $feature->submodule->name ?? 'N/A' }}</td>
                                <td>{{ $feature->title }}</td>
                                <td>{!! Str::limit(strip_tags($feature->description ?? ''), 50) !!}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $feature->status)) }}</td>
                                <td>{{ $feature->creator?->name ?? '--' }}</td>
                                <td>{{ $feature->created_at->format('Y-m-d H:i') }}</td>
                                <td width="15%">
                                    <a href="#" title="Edit Feature" class="btn btn-sm btn-main me-1"
                                        data-bs-toggle="modal" data-bs-target="#editFeatureModal{{ $feature->id }}">
                                        <i class="ph-note-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0)" title="Delete Feature" class="btn btn-sm btn-danger"
                                        onclick="deleteFeature({{ $feature->id }})">
                                        <i class="ph-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No features found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include Feature Modals -->
    @include('systems.partials.feature-modals')
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

            // Initialize Summernote for description fields
            $('.summernote').summernote({
                height: 200,
                placeholder: 'Enter description',
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

            $('#addFeatureModule').on('change', function() {
                var moduleId = $(this).val();
                $('#addFeatureSubmodule').empty().append('<option value="">None</option>');
                if (moduleId) {
                    $.get('{{ route('submodules.byModule') }}', {
                        module_id: moduleId
                    }, function(data) {
                        $.each(data, function(index, submodule) {
                            $('#addFeatureSubmodule').append('<option value="' + submodule
                                .id + '">' + submodule.name + '</option>');
                        });
                    });
                }
            });

            @foreach ($system->features as $feature)
                $('#editFeatureModule{{ $feature->id }}').on('change', function() {
                    var moduleId = $(this).val();
                    $('#editFeatureSubmodule{{ $feature->id }}').empty().append(
                        '<option value="">None</option>');
                    if (moduleId) {
                        $.get('{{ route('submodules.byModule') }}', {
                            module_id: moduleId
                        }, function(data) {
                            $.each(data, function(index, submodule) {
                                $('#editFeatureSubmodule{{ $feature->id }}').append(
                                    '<option value="' + submodule.id + '">' + submodule
                                    .name + '</option>');
                            });
                            @if ($feature->submodule_id)
                                $('#editFeatureSubmodule{{ $feature->id }}').val(
                                    {{ $feature->submodule_id }});
                            @endif
                        });
                    }
                });
                @if ($feature->module_id)
                    $('#editFeatureModule{{ $feature->id }}').trigger('change');
                @endif
            @endforeach

            window.deleteFeature = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this feature?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: "{{ route('systems.destroyFeature', [$system, ':id']) }}"
                                    .replace(':id', id),
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            })
                            .done(function() {
                                Swal.fire('Deleted!', 'Feature has been deleted successfully.',
                                    'success');
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            })
                            .fail(function(xhr) {
                                Swal.fire('Failed!', xhr.responseJSON.message ||
                                    'Feature deletion failed.', 'error');
                            });
                    }
                });
            };
        });
    </script>
@endpush
