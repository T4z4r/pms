@extends('layouts.vertical', ['title' => 'Activity Calendar'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js'></script>
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
                <i class="ph-calendar text-secondary"></i> Activity Calendar
            </h4>
            <div>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#createActivityModal">
                    <i class="ph-plus me-2"></i> New Activity
                </a>
                {{-- @if (Auth::user()->hasRole('admin')) --}}
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#assignUserActivityModal">
                        <i class="ph-user-plus me-2"></i> Assign to User
                    </a>
                    <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#assignAllActivityModal">
                        <i class="ph-users me-2"></i> Assign to All
                    </a>
                {{-- @endif --}}
            </div>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <ul class="nav nav-tabs mb-3" id="activityTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-pane" type="button" role="tab" aria-controls="calendar-pane" aria-selected="true">Calendar</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-pane" type="button" role="tab" aria-controls="table-pane" aria-selected="false">Table</button>
            </li>
        </ul>
        <div class="tab-content" id="activityTabContent">
            <div class="tab-pane fade show active" id="calendar-pane" role="tabpanel" aria-labelledby="calendar-tab">
                <div id="calendar" class="mb-4"></div>
            </div>
            <div class="tab-pane fade" id="table-pane" role="tabpanel" aria-labelledby="table-tab">
                <table id="activitiesTable" class="table table-striped table-bordered datatable-basic">
                    <thead>
                        <tr>
                            <th>SN.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Color</th>
                            <th>Creator</th>
                            <th>Assignee</th>
                            <th>Created At</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $activity->title }}</td>
                                <td>{{ $activity->description ?? '-' }}</td>
                                <td>{{ $activity->start_time->format('Y-m-d H:i') }}</td>
                                <td>{{ $activity->end_time?->format('Y-m-d H:i') ?? '-' }}</td>
                                <td><span class="badge" style="background-color: {{ $activity->color }}">{{ $activity->color }}</span></td>
                                <td>{{ $activity->creator->name }}</td>
                                <td>{{ $activity->assignee ? $activity->assignee->name : ($activity->is_all_users ? 'All Users' : '-') }}</td>
                                <td>{{ $activity->created_at->format('Y-m-d') }}</td>
                                <td width="18%">
                                    {{-- @if (Auth::user()->can('update', $activity)) --}}
                                        <a href="#" title="Edit Activity" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editActivityModal{{ $activity->id }}">
                                            <i class="ph-note-pencil"></i>
                                        </a>
                                    {{-- @endif --}}
                                    {{-- @if (Auth::user()->can('delete', $activity)) --}}
                                        <a href="javascript:void(0)" title="Delete Activity" class="btn btn-sm btn-danger" onclick="deleteActivity({{ $activity->id }})">
                                            <i class="ph-trash"></i>
                                        </a>
                                    {{-- @endif --}}
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            {{-- @if (Auth::user()->can('update', $activity)) --}}
                                <div class="modal fade" id="editActivityModal{{ $activity->id }}" tabindex="-1" aria-labelledby="editActivityModalLabel{{ $activity->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('activities.update', $activity) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editActivityModalLabel{{ $activity->id }}">Edit Activity</h5>
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
                                                        <input type="text" name="title" class="form-control" value="{{ old('title', $activity->title) }}" required>
                                                        @error('title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Description</label>
                                                        <textarea name="description" class="form-control">{{ old('description', $activity->description) }}</textarea>
                                                        @error('description')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Start Time</label>
                                                        <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time', $activity->start_time->format('Y-m-d\TH:i')) }}" required>
                                                        @error('start_time')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">End Time</label>
                                                        <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time', $activity->end_time?->format('Y-m-d\TH:i')) }}">
                                                        @error('end_time')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Color</label>
                                                        <input type="color" name="color" class="form-control h-10" value="{{ old('color', $activity->color) }}" required>
                                                        @error('color')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
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
                            {{-- @endif --}}
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No activities found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal (User's Own Activity) -->
<div class="modal fade" id="createActivityModal" tabindex="-1" aria-labelledby="createActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('activities.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createActivityModalLabel">New Activity</h5>
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
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Team Meeting" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="e.g. Discuss project milestones">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                        @error('start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time') }}">
                        @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" class="form-control h-10" value="{{ old('color', '#3788d8') }}" required>
                        @error('color')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

<!-- Assign to User Modal (Admin Only) -->
<div class="modal fade" id="assignUserActivityModal" tabindex="-1" aria-labelledby="assignUserActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('activities.storeForUser') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignUserActivityModalLabel">Assign Activity to User</h5>
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
                        @error('assigned_to')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Team Meeting" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="e.g. Discuss project milestones">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                        @error('start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time') }}">
                        @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" class="form-control h-10" value="{{ old('color', '#3788d8') }}" required>
                        @error('color')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

<!-- Assign to All Users Modal (Admin Only) -->
<div class="modal fade" id="assignAllActivityModal" tabindex="-1" aria-labelledby="assignAllActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('activities.storeForAll') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignAllActivityModalLabel">Assign Activity to All Users</h5>
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
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Company Meeting" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="e.g. Annual company-wide meeting">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                        @error('start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time') }}">
                        @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" class="form-control h-10" value="{{ old('color', '#3788d8') }}" required>
                        @error('color')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select a user',
                allowClear: true,
                width: '100%'
            });

            // Initialize FullCalendar
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                editable: true,
                selectable: true,
                events: '{{ route('activities.data') }}',
                select: function(info) {
                    $('#createActivityModal').modal('show');
                    document.querySelector('input[name="start_time"]').value = info.start.toISOString().slice(0, 16);
                    document.querySelector('input[name="end_time"]').value = info.end ? info.end.toISOString().slice(0, 16) : '';
                },
                eventClick: function(info) {
                    @if (Auth::user()->hasRole('admin'))
                        $(`#editActivityModal${info.event.id}`).modal('show');
                    @else
                        if (info.event.extendedProps.assignee === '{{ Auth::user()->name }}' || info.event.extendedProps.creator === '{{ Auth::user()->name }}' || info.event.extendedProps.assignee === 'All Users') {
                            $(`#editActivityModal${info.event.id}`).modal('show');
                        }
                    @endif
                },
                eventDrop: function(info) {
                    @if (Auth::user()->hasRole('admin'))
                        updateEvent(info.event);
                    @else
                        info.revert();
                        Swal.fire('Permission Denied', 'You cannot modify this activity.', 'error');
                    @endif
                },
                eventResize: function(info) {
                    @if (Auth::user()->hasRole('admin'))
                        updateEvent(info.event);
                    @else
                        info.revert();
                        Swal.fire('Permission Denied', 'You cannot modify this activity.', 'error');
                    @endif
                }
            });
            calendar.render();

            // Initialize DataTable when table tab is shown
            // let dataTableInitialized = false;
            // $('#table-tab').on('shown.bs.tab', function () {
            //     if (!dataTableInitialized) {
            //         $('#activitiesTable').DataTable({
            //             responsive: true,
            //             order: [[3, 'desc']],
            //             columnDefs: [
            //                 { orderable: false, targets: [9] }
            //             ]
            //         });
            //         dataTableInitialized = true;
            //     }
            // });

            function updateEvent(event) {
                $.ajax({
                    url: `/activities/${event.id}`,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        title: event.title,
                        description: event.extendedProps.description,
                        start_time: event.start.toISOString(),
                        end_time: event.end ? event.end.toISOString() : null,
                        color: event.backgroundColor,
                    },
                    success: function() {
                        calendar.refetchEvents();
                        Swal.fire('Updated', 'Activity updated successfully.', 'success');
                    },
                    error: function() {
                        Swal.fire('Failed', 'Failed to update activity.', 'error');
                    }
                });
            }

            window.deleteActivity = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this activity?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('activities.destroy', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function() {
                            Swal.fire(
                                'Deleted!',
                                'Activity has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Activity deletion failed.',
                                'error'
                            );
                        });
                    }
                });
            };
        });
    </script>
@endpush
