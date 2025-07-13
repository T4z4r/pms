@extends('layouts.vertical', ['title' => 'View Test Plan: ' . $testPlan->title])

@push('head-script')
    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <!-- Summernote CSS - CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Summernote JS - CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="lead text-primary">
                    <i class="ph-clipboard-text text-secondary"></i> Test Plan: {{ $testPlan->title }}
                </h4>
                <div>
                    <a href="{{ route('tests.index') }}" class="btn btn-brand btn-sm me-2">
                        <i class="ph-arrow-left me-2"></i> Back to Test Plans
                    </a>
                    <a href="#" class="btn btn-brand btn-sm me-2" data-bs-toggle="modal"
                        data-bs-target="#createTestCaseModal">
                        <i class="ph-plus-circle me-2"></i> Add Test Case
                    </a>
                    <a href="{{ route('tests.exportExcel', $testPlan) }}" class="btn btn-success btn-sm me-2">
                        <i class="ph-file-xls me-2"></i> Export to Excel
                    </a>
                    <a href="{{ route('tests.exportPdf', $testPlan) }}" class="btn btn-danger btn-sm">
                        <i class="ph-file-pdf me-2"></i> Export to PDF
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
            <div class="mb-4">
                <h5>Test Plan Details</h5>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 20%;">Title</th>
                            <td>{{ $testPlan->title }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!! $testPlan->description ?? '-' !!}</td>
                        </tr>
                        <tr>
                            <th>Project</th>
                            <td>{{ $testPlan->project->name }}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{ $testPlan->start_date->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $testPlan->end_date?->format('Y-m-d H:i') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td>
                                <span class="badge" style="background-color: {{ $testPlan->color }}">
                                    {{ $testPlan->color }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Creator</th>
                            <td>{{ $testPlan->creator->name }}</td>
                        </tr>
                        <tr>
                            <th>Assignee</th>
                            <td>{{ $testPlan->assignee?->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $testPlan->created_at->format('Y-m-d') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h5>Test Cases</h5>
            <table id="testCasesTable" class="table table-striped table-bordered datatable-basic">
                <thead>
                    <tr>
                        <th>SN.</th>
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
                    @forelse($testPlan->testCases as $index => $testCase)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $testCase->title }}</td>
                            <td>{!! Str::limit(strip_tags($testCase->description ?? ''), 50) !!}</td>
                            <td>{!! Str::limit(strip_tags($testCase->expected_outcome ?? ''), 50) !!}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $testCase->status)) }}</td>
                            <td>{{ $testCase->creator->name }}</td>
                            <td>{{ $testCase->created_at->format('Y-m-d') }}</td>
                            <td width="15%">
                                <a href="#" title="Edit Test Case" class="btn btn-sm btn-main" data-bs-toggle="modal"
                                    data-bs-target="#editTestCaseModal{{ $testCase->id }}">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete Test Case" class="btn btn-sm btn-danger"
                                    onclick="deleteTestCase({{ $testCase->id }})">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No test cases found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Test Case Modal -->
    <div class="modal fade" id="createTestCaseModal" tabindex="-1" aria-labelledby="createTestCaseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('tests.storeTestCase', $testPlan) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTestCaseModalLabel">New Test Case for {{ $testPlan->title }}</h5>
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
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                                placeholder="Enter test case title (e.g., API Authentication Test)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote"
                                placeholder="Enter test case details (e.g., steps to execute)">{!! old('description') !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expected Outcome</label>
                            <textarea name="expected_outcome" class="form-control summernote"
                                placeholder="Enter expected result (e.g., User authenticated successfully)">{!! old('expected_outcome') !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending
                                </option>
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
    @foreach ($testPlan->testCases as $testCase)
        <div class="modal fade" id="editTestCaseModal{{ $testCase->id }}" tabindex="-1"
            aria-labelledby="editTestCaseModalLabel{{ $testCase->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('tests.updateTestCase', $testCase) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTestCaseModalLabel{{ $testCase->id }}">Edit Test Case:
                                {{ $testCase->title }}</h5>
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
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $testCase->title) }}"
                                    placeholder="Enter test case title (e.g., API Authentication Test)" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control summernote"
                                    placeholder="Enter test case details (e.g., steps to execute)">{!! old('description', $testCase->description) !!}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Expected Outcome</label>
                                <textarea name="expected_outcome" class="form-control summernote"
                                    placeholder="Enter expected result (e.g., User authenticated successfully)">{!! old('expected_outcome', $testCase->expected_outcome) !!}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="pending"
                                        {{ old('status', $testCase->status) === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="passed"
                                        {{ old('status', $testCase->status) === 'passed' ? 'selected' : '' }}>Passed
                                    </option>
                                    <option value="failed"
                                        {{ old('status', $testCase->status) === 'failed' ? 'selected' : '' }}>Failed
                                    </option>
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
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
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
                                url: "{{ route('tests.destroyTestCase', ':id') }}".replace(':id',
                                    id),
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
