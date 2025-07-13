@extends('layouts.vertical', ['title' => 'Security Gaps'])

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
                    <i class="ph-shield-warning text-secondary"></i> Security Gaps
                </h4>
                <div>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#createSecurityGapModal">
                        <i class="ph-plus me-2"></i> New Security Gap
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#assignUserSecurityGapModal">
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

        <div class="card-body">
            <table id="securityGapsTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Template</th>
                        <th>Project</th>
                        <th>Status</th>
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
                    @forelse($securityGaps as $index => $securityGap)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $securityGap->title }}</td>
                            <td>{!! Str::limit(strip_tags($securityGap->description ?? ''), 50) !!}</td>
                            <td>{{ $securityGap->template?->title ?? '-' }}</td>
                            <td>{{ $securityGap->project->name }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $securityGap->status)) }}</td>
                            <td>{{ $securityGap->start_date->format('Y-m-d H:i') }}</td>
                            <td>{{ $securityGap->end_date?->format('Y-m-d H:i') ?? '-' }}</td>
                            <td><span class="badge"
                                    style="background-color: {{ $securityGap->color }}">{{ $securityGap->color }}</span>
                            </td>
                            <td>{{ $securityGap->creator->name }}</td>
                            <td>{{ $securityGap->assignee?->name ?? '-' }}</td>
                            <td>{{ $securityGap->created_at->format('Y-m-d') }}</td>
                            <td width="18%">
                                <a href="#" title="Edit Security Gap" class="btn btn-sm btn-main"
                                    data-bs-toggle="modal" data-bs-target="#editSecurityGapModal{{ $securityGap->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Security Gap" class="btn btn-sm btn-danger"
                                    onclick="deleteSecurityGap({{ $securityGap->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editSecurityGapModal{{ $securityGap->id }}" tabindex="-1"
                            aria-labelledby="editSecurityGapModalLabel{{ $securityGap->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('security-gaps.update', $securityGap) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editSecurityGapModalLabel{{ $securityGap->id }}">
                                                Edit Security Gap</h5>
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
                                                <label class="form-label">Template</label>
                                                <select name="security_gap_template_id" class="form-select">
                                                    <option value="">No Template</option>
                                                    @foreach ($templates as $template)
                                                        <option value="{{ $template->id }}"
                                                            {{ old('security_gap_template_id', $securityGap->security_gap_template_id) == $template->id ? 'selected' : '' }}>
                                                            {{ $template->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control"
                                                    value="{{ old('title', $securityGap->title) }}"
                                                    placeholder="Enter security gap title (e.g., A01:2021-Broken Access Control)"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control summernote"
                                                    placeholder="Enter security gap details (e.g., mitigation steps)">{!! old('description', $securityGap->description) !!}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Project</label>
                                                <select name="project_id" class="form-select" required>
                                                    <option value="">Select a project</option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->id }}"
                                                            {{ old('project_id', $securityGap->project_id) == $project->id ? 'selected' : '' }}>
                                                            {{ $project->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="open"
                                                        {{ old('status', $securityGap->status) === 'open' ? 'selected' : '' }}>
                                                        Open</option>
                                                    <option value="in_progress"
                                                        {{ old('status', $securityGap->status) === 'in_progress' ? 'selected' : '' }}>
                                                        In Progress</option>
                                                    <option value="mitigated"
                                                        {{ old('status', $securityGap->status) === 'mitigated' ? 'selected' : '' }}>
                                                        Mitigated</option>
                                                    <option value="verified"
                                                        {{ old('status', $securityGap->status) === 'verified' ? 'selected' : '' }}>
                                                        Verified</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Start Date</label>
                                                <input type="datetime-local" name="start_date" class="form-control"
                                                    value="{{ old('start_date', $securityGap->start_date->format('Y-m-d\TH:i')) }}"
                                                    placeholder="Select start date and time" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">End Date</label>
                                                <input type="datetime-local" name="end_date" class="form-control"
                                                    value="{{ old('end_date', $securityGap->end_date?->format('Y-m-d\TH:i')) }}"
                                                    placeholder="Select end date and time (optional)">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Color</label>
                                                <input type="color" name="color" class="form-control h-10"
                                                    value="{{ old('color', $securityGap->color) }}"
                                                    placeholder="Select color for display" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center">No security gaps found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Security Gap Modal -->
    <div class="modal fade" id="createSecurityGapModal" tabindex="-1" aria-labelledby="createSecurityGapModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('security-gaps.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSecurityGapModalLabel">New Security Gap</h5>
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
                            <label class="form-label">Template</label>
                            <select name="security_gap_template_id" class="form-select select2">
                                <option value="">No Template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}"
                                        {{ old('security_gap_template_id') == $template->id ? 'selected' : '' }}>
                                        {{ $template->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Enter security gap title (e.g., A01:2021-Broken Access Control)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote"
                                placeholder="Enter security gap details (e.g., mitigation steps)">{!! old('description') !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select select2" required>
                                <option value="">Select a project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2" required>
                                <option value="open" {{ old('status') === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="mitigated" {{ old('status') === 'mitigated' ? 'selected' : '' }}>Mitigated
                                </option>
                                <option value="verified" {{ old('status') === 'verified' ? 'selected' : '' }}>Verified
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date" class="form-control"
                                value="{{ old('start_date') }}" placeholder="Select start date and time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date" class="form-control"
                                value="{{ old('end_date') }}" placeholder="Select end date and time (optional)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <input type="color" name="color" class="form-control h-10"
                                value="{{ old('color', '#3788d8') }}" placeholder="Select color for display" required>
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
    <div class="modal fade" id="assignUserSecurityGapModal" tabindex="-1"
        aria-labelledby="assignUserSecurityGapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('security-gaps.storeForUser') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignUserSecurityGapModalLabel">Assign Security Gap to User</h5>
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
                                    <option value="{{ $user->id }}"
                                        {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Template</label>
                            <select name="security_gap_template_id" class="form-select select2">
                                <option value="">No Template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}"
                                        {{ old('security_gap_template_id') == $template->id ? 'selected' : '' }}>
                                        {{ $template->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Enter security gap title (e.g., A01:2021-Broken Access Control)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote"
                                placeholder="Enter security gap details (e.g., mitigation steps)">{!! old('description') !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select" required>
                                <option value="">Select a project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="open" {{ old('status') === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="mitigated" {{ old('status') === 'mitigated' ? 'selected' : '' }}>Mitigated
                                </option>
                                <option value="verified" {{ old('status') === 'verified' ? 'selected' : '' }}>Verified
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date" class="form-control"
                                value="{{ old('start_date') }}" placeholder="Select start date and time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date" class="form-control"
                                value="{{ old('end_date') }}" placeholder="Select end date and time (optional)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <input type="color" name="color" class="form-control h-10"
                                value="{{ old('color', '#3788d8') }}" placeholder="Select color for display" required>
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
                placeholder: 'Enter security gap details (e.g., mitigation steps)',
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

            window.deleteSecurityGap = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this security gap?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                url: "{{ route('security-gaps.destroy', ':id') }}".replace(':id',
                                    id),
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            })
                            .done(function() {
                                Swal.fire(
                                    'Deleted!',
                                    'Security Gap has been deleted successfully.',
                                    'success'
                                );
                                setTimeout(function() {
                                    location.reload();
                                }, 500);
                            })
                            .fail(function() {
                                Swal.fire(
                                    'Failed!',
                                    'Security Gap deletion failed.',
                                    'error'
                                );
                            });
                    }
                });
            };
        });
    </script>
@endpush
