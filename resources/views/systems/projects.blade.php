@extends('layouts.vertical', ['title' => 'System Projects: ' . $system->name])

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-desktop text-secondary"></i> System Projects: {{ $system->name }}
                </h4>
                <a href="{{ route('systems.show', $system) }}" class="btn btn-brand btn-sm">
                    <i class="ph-arrow-left me-2"></i> Back to System Details
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="projectsTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Creator</th>
                        <th>Assignee</th>
                        <th>Created At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($system->projects as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{!! Str::limit(strip_tags($project->description ?? ''), 50) !!}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $project->type)) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $project->status)) }}</td>
                            <td>{{ $project->start_date?->format('Y-m-d H:i') ?? '--' }}</td>
                            <td>{{ $project->end_date?->format('Y-m-d H:i') ?? '-' }}</td>
                            <td>{{ $project->creator?->name ?? '--' }}</td>
                            <td>{{ $project->assignee ? $project->assignee->name : ($project->is_all_users ? 'All Users' : '-') }}
                            </td>
                            <td>{{ $project->created_at->format('Y-m-d') }}</td>
                            <td width="15%">
                                <a href="{{ url('projects.show', $project) }}" title="View Project"
                                    class="btn btn-sm btn-main">
                                    <i class="ph-info"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No projects linked.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('head-script')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush
