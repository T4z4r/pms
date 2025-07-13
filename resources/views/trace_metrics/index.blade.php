@extends('layouts.vertical', ['title' => 'Trace Metrics'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
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
                <i class="ph-chart-line text-secondary"></i> Trace Metrics
            </h4>
            <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#createTraceMetricModal">
                <i class="ph-plus me-2"></i> New Metric
            </a>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <table id="traceMetricsTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Project</th>
                    <th>Metric Name</th>
                    <th>Value</th>
                    <th>Recorded At</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($metrics as $index => $metric)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $metric->project->name }}</td>
                        <td>{{ $metric->metric_name }}</td>
                        <td>{{ $metric->value }}</td>
                        <td>{{ $metric->recorded_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $metric->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="#" title="Edit Metric" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editTraceMetricModal{{ $metric->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" title="Delete Metric" class="btn btn-sm btn-danger" onclick="deleteTraceMetric({{ $metric->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editTraceMetricModal{{ $metric->id }}" tabindex="-1" aria-labelledby="editTraceMetricModalLabel{{ $metric->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('trace_metrics.update', $metric) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editTraceMetricModalLabel{{ $metric->id }}">Edit Metric</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Project</label>
                                            <select name="project_id" class="form-select" required>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}" {{ $project->id == $metric->project_id ? 'selected' : '' }}>
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Metric Name</label>
                                            <input type="text" name="metric_name" class="form-control" value="{{ $metric->metric_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Value</label>
                                            <input type="number" name="value" class="form-control" value="{{ $metric->value }}" step="0.01" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Recorded At</label>
                                            <input type="datetime-local" name="recorded_at" class="form-control" value="{{ $metric->recorded_at->format('Y-m-d\TH:i') }}" required>
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
                        <td colspan="7" class="text-center">No metrics found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createTraceMetricModal" tabindex="-1" aria-labelledby="createTraceMetricModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('trace_metrics.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTraceMetricModalLabel">New Metric</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select" required>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metric Name</label>
                        <input type="text" name="metric_name" class="form-control" placeholder="e.g. Tasks Completed" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <input type="number" name="value" class="form-control" placeholder="e.g. 10" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Recorded At</label>
                        <input type="datetime-local" name="recorded_at" class="form-control" required>
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
        function deleteTraceMetric(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this trace metric?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('trace_metrics.destroy', ':id') }}".replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Trace metric has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Trace metric deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush