@extends('layouts.vertical', ['title' => 'Test Plans'])

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
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-clipboard-text text-secondary"></i> Test Plans
            </h4>
            <div>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#createTestPlanModal">
                    <i class="ph-plus me-2"></i> New Test Plan
                </a>
                <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal" data-bs-target="#assignUserTestPlanModal">
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
        <table id="testPlansTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    {{-- <th></th> --}}
                    <th>SN.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Project</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    {{-- <th>Color</th> --}}
                    {{-- <th>Creator</th> --}}
                    <th>Assignee</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testPlans as $index => $testPlan)
                    <tr>
                        {{-- <td>
                            <a href="javascript:void(0)" class="toggle-test-cases" data-test-plan-id="{{ $testPlan->id }}">
                                <i class="ph-caret-down"></i>
                            </a>
                        </td> --}}
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $testPlan->title }}</td>
                        <td>{!! Str::limit(strip_tags($testPlan->description ?? ''), 50) !!}</td>
                        <td>{{ $testPlan->project->name }}</td>
                        <td>{{ $testPlan->start_date->format('Y-m-d H:i') }}</td>
                        <td>{{ $testPlan->end_date?->format('Y-m-d H:i') ?? '-' }}</td>
                        {{-- <td><span class="badge" style="background-color: {{ $testPlan->color }}">{{ $testPlan->color }}</span></td> --}}
                        {{-- <td>{{ $testPlan->creator->name }}</td> --}}
                        <td>{{ $testPlan->assignee?->name ?? '-' }}</td>
                        <td>{{ $testPlan->created_at->format('Y-m-d') }}</td>
                        <td width="20%">
                            <a href="{{ route('tests.show', $testPlan) }}" title="View Test Plan" class="btn btn-sm btn-main">
                                <i class="ph-info"></i>
                            </a>
                            <a href="#" title="Edit Test Plan" class="btn btn-sm btn-main mx-1" data-bs-toggle="modal" data-bs-target="#editTestPlanModal{{ $testPlan->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            {{-- <a href="#" title="Add Test Case" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createTestCaseModal{{ $testPlan->id }}">
                                <i class="ph-plus-circle"></i>
                            </a> --}}
                            <a href="javascript:void(0)" title="Delete Test Plan" class="btn btn-sm btn-danger" onclick="deleteTestPlan({{ $testPlan->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <tr class="test-cases-row" id="test-cases-{{ $testPlan->id }}" style="display: none;">
                        <td colspan="12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Expected Outcome</th>
                                        <th>Status</th>
                                        <th>Creator</th>
                                        <th>Created At</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($testPlan->testCases as $testCase)
                                        <tr>
                                            <td>{{ $testCase->title }}</td>
                                            <td>{!! Str::limit(strip_tags($testCase->description ?? ''), 50) !!}</td>
                                            <td>{!! Str::limit(strip_tags($testCase->expected_outcome ?? ''), 50) !!}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $testCase->status)) }}</td>
                                            <td>{{ $testCase->creator->name }}</td>
                                            <td>{{ $testCase->created_at->format('Y-m-d') }}</td>
                                            <td width="18%">
                                                <a href="#" title="Edit Test Case" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editTestCaseModal{{ $testCase->id }}">
                                                    <i class="ph-note-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Delete Test Case" class="btn btn-sm btn-danger" onclick="deleteTestCase({{ $testCase->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No test cases found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Edit Test Plan Modal -->
                    <div class="modal fade" id="editTestPlanModal{{ $testPlan->id }}" tabindex="-1" aria-labelledby="editTestPlanModalLabel{{ $testPlan->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('tests.update', $testPlan) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editTestPlanModalLabel{{ $testPlan->id }}">Edit Test Plan</h5>
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
                                            <input type="text" name="title" class="form-control" value="{{ old('title', $testPlan->title) }}" placeholder="Enter test plan title (e.g., Security Test Suite)" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control summernote" placeholder="Enter test plan details (e.g., scope, objectives)">{!! old('description', $testPlan->description) !!}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Project</label>
                                            <select name="project_id" class="form-select" required>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}" {{ old('project_id', $testPlan->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', $testPlan->start_date->format('Y-m-d\TH:i')) }}" placeholder="Select start date and time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $testPlan->end_date?->format('Y-m-d\TH:i')) }}" placeholder="Select end date and time (optional)">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Color</label>
                                            <input type="color" name="color" class="form-control h-10" value="{{ old('color', $testPlan->color) }}" placeholder="Select calendar color" required>
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

                    <!-- Create Test Case Modal -->
                    <div class="modal fade" id="createTestCaseModal{{ $testPlan->id }}" tabindex="-1" aria-labelledby="createTestCaseModalLabel{{ $testPlan->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('tests.storeTestCase', $testPlan) }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createTestCaseModalLabel{{ $testPlan->id }}">New Test Case for {{ $testPlan->title }}</h5>
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
                                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter test case title (e.g., API Authentication Test)" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control summernote" placeholder="Enter test case details (e.g., steps to execute)">{!! old('description') !!}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Expected Outcome</label>
                                            <textarea name="expected_outcome" class="form-control summernote" placeholder="Enter expected result (e.g., User authenticated successfully)">{!! old('expected_outcome') !!}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="passed" {{ old('status') === 'passed' ? 'selected' : '' }}>Passed</option>
                                                <option value="failed" {{ old('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                            </select>
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

                    <!-- Edit Test Case Modal -->
                    @foreach($testPlan->testCases as $testCase)
                        <div class="modal fade" id="editTestCaseModal{{ $testCase->id }}" tabindex="-1" aria-labelledby="editTestCaseModalLabel{{ $testCase->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('tests.updateTestCase', $testCase) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTestCaseModalLabel{{ $testCase->id }}">Edit Test Case: {{ $testCase->title }}</h5>
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
                                                <input type="text" name="title" class="form-control" value="{{ old('title', $testCase->title) }}" placeholder="Enter test case title (e.g., API Authentication Test)" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="description" class="form-control summernote" placeholder="Enter test case details (e.g., steps to execute)">{!! old('description', $testCase->description) !!}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Expected Outcome</label>
                                                <textarea name="expected_outcome" class="form-control summernote" placeholder="Enter expected result (e.g., User authenticated successfully)">{!! old('expected_outcome', $testCase->expected_outcome) !!}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="pending" {{ old('status', $testCase->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="passed" {{ old('status', $testCase->status) === 'passed' ? 'selected' : '' }}>Passed</option>
                                                    <option value="failed" {{ old('status', $testCase->status) === 'failed' ? 'selected' : '' }}>Failed</option>
                                                </select>
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
                    @endforeach
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No test plans found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Test Plan Modal -->
<div class="modal fade" id="createTestPlanModal" tabindex="-1" aria-labelledby="createTestPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('tests.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTestPlanModalLabel">New Test Plan</h5>
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
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter test plan title (e.g., Security Test Suite)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Enter test plan details (e.g., scope, objectives)">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select" required>
                            <option value="">Select a project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
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
<div class="modal fade" id="assignUserTestPlanModal" tabindex="-1" aria-labelledby="assignUserTestPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('tests.storeForUser') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignUserTestPlanModalLabel">Assign Test Plan to User</h5>
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
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter test plan title (e.g., Penetration Test Plan)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Enter test plan details (e.g., scope, objectives)">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select" required>
                            <option value="">Select a project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
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
                placeholder: 'Enter details',
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

            $('.toggle-test-cases').click(function() {
                const testPlanId = $(this).data('test-plan-id');
                const row = $('#test-cases-' + testPlanId);
                row.toggle();
                const icon = $(this).find('i');
                icon.toggleClass('ph-caret-down ph-caret-up');
            });

            window.deleteTestPlan = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this test plan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('tests.destroy', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function() {
                            Swal.fire(
                                'Deleted!',
                                'Test Plan has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Test Plan deletion failed.',
                                'error'
                            );
                        });
                    }
                });
            };

            window.deleteTestCase = function(id) {
                Swal.fire({
                    text: 'Are you sure you want to delete this test case?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('tests.destroyTestCase', ':id') }}".replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function() {
                            Swal.fire(
                                'Deleted!',
                                'Test Case has been deleted successfully.',
                                'success'
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Test Case deletion failed.',
                                'error'
                            );
                        });
                    }
                });
            };
        });
    </script>
@endpush
