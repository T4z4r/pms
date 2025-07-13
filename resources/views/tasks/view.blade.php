@extends('layouts.vertical', ['title' => 'Task Details'])

@push('head-script')
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
                <i class="ph-check-square text-secondary"></i> {{ $task->title }}
            </h4>
            <a href="{{ route('tasks.index') }}" class="btn btn-brand btn-sm">
                <i class="ph-arrow-left me-2"></i> Back to Tasks
            </a>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <div class="row">
            <!-- Vertical Tabs -->
            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="taskTabs" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="pill" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
                        <i class="ph-info me-2"></i> Task Information
                    </button>
                    <button class="nav-link" id="subtasks-tab" data-bs-toggle="pill" data-bs-target="#subtasks" type="button" role="tab" aria-controls="subtasks" aria-selected="false">
                        <i class="ph-list-bullets me-2"></i> Subtasks
                    </button>
                    <button class="nav-link" id="comments-tab" data-bs-toggle="pill" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">
                        <i class="ph-chat-text me-2"></i> Comments
                    </button>
                    <button class="nav-link" id="attachments-tab" data-bs-toggle="pill" data-bs-target="#attachments" type="button" role="tab" aria-controls="attachments" aria-selected="false">
                        <i class="ph-paperclip me-2"></i> Attachments
                    </button>
                    @if ($task->review)
                        <button class="nav-link" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">
                            <i class="ph-check-circle me-2"></i> Task Review
                        </button>
                    @endif
                </div>
            </div>

            <!-- Tab Content -->
            <div class="col-md-9">
                <div class="tab-content" id="taskTabsContent">
                    <!-- Task Information Tab -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary">Task Information</h5>
                            @if ($task->status != 'under_review' && $task->status != 'approved')
                                <a href="#" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editTaskModal">
                                    <i class="ph-note-pencil me-2"></i> Edit Task
                                </a>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Title:</strong> {{ $task->title }}</p>
                                <p><strong>Description:</strong> {!! $task->description ?: 'N/A' !!}</p>
                                <p><strong>Project:</strong> {{ $task->project->name ?? 'None' }}</p>
                                <p><strong>Creator:</strong> {{ $task->creator->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{ $task->status == 'approved' ? 'success bg-opacity-10 text-success' : ($task->status == 'pending' ? 'secondary bg-opacity-10 text-secondary' : 'warning bg-opacity-10 text-warning') }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </p>
                                <p><strong>Due Date:</strong> {{ $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}</p>
                                <p><strong>Assigned Users:</strong> {{ $task->users->pluck('name')->implode(', ') ?: 'None' }}</p>
                                <p><strong>Created At:</strong> {{ $task->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            @if (in_array($task->status, ['pending', 'in_progress']) && $task->users->contains(auth()->user()))
                                <form action="{{ route('tasks.mark_completed', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ph-check me-2"></i> Mark as Completed
                                    </button>
                                </form>
                            @endif
                            @if ($task->status == 'under_review' && $task->creator_id == auth()->id())
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewTaskModal">
                                    <i class="ph-check-circle me-2"></i> Review Task
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Subtasks Tab -->
                    <div class="tab-pane fade" id="subtasks" role="tabpanel" aria-labelledby="subtasks-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary">Subtasks</h5>
                            @if ($task->status != 'under_review' && $task->status != 'approved')
                                <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal" data-bs-target="#createSubtaskModal">
                                    <i class="ph-plus me-2"></i> Add Subtask
                                </a>
                            @endif
                        </div>
                        <table id="subtasksTable" class="table table-striped table-bordered datatable-basic">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Created At</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($task->subtasks as $index => $subtask)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $subtask->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $subtask->status == 'approved' ? 'success bg-opacity-10 text-success' : ($subtask->status == 'pending' ? 'secondary bg-opacity-10 text-secondary' : 'warning bg-opacity-10 text-warning') }}">
                                                {{ ucfirst($subtask->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $subtask->due_date ? \Illuminate\Support\Carbon::parse($subtask->due_date)->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $subtask->created_at->format('Y-m-d') }}</td>
                                        <td width="18%">
                                            @if ($subtask->status != 'under_review' && $subtask->status != 'approved')
                                                <a href="#" title="Edit Subtask" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editSubtaskModal{{ $subtask->id }}">
                                                    <i class="ph-note-pencil"></i>
                                                </a>
                                                <a href="javascript:void(0)" title="Delete Subtask" class="btn btn-sm btn-danger" onclick="deleteSubtask({{ $subtask->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                                <form action="{{ route('subtasks.mark_completed', $subtask) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="ph-check"></i> Mark as Completed
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Edit Subtask Modal -->
                                    @if ($subtask->status != 'under_review' && $subtask->status != 'approved')
                                        <div class="modal fade" id="editSubtaskModal{{ $subtask->id }}" tabindex="-1" aria-labelledby="editSubtaskModalLabel{{ $subtask->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" action="{{ route('subtasks.update', $subtask) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editSubtaskModalLabel{{ $subtask->id }}">Edit Subtask</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" name="title" class="form-control" value="{{ $subtask->title }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea name="description" class="form-control summernote" placeholder="Enter details">{!! $subtask->description !!}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Due Date</label>
                                                                <input type="date" name="due_date" class="form-control" value="{{ $subtask->due_date ? \Illuminate\Support\Carbon::parse($subtask->due_date)->format('Y-m-d') : '' }}">
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
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No subtasks found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Comments Tab -->
                    <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary">Comments</h5>
                            @if ($task->status != 'under_review' && $task->status != 'approved')
                                <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                                    <i class="ph-plus me-2"></i> Add Comment
                                </a>
                            @endif
                        </div>
                        <table id="commentsTable" class="table table-striped table-bordered datatable-basic">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>User</th>
                                    <th>Comment</th>
                                    <th>Created At</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($task->comments as $index => $comment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $comment->user->name }}</td>
                                        <td>{!! $comment->content !!}</td>
                                        <td>{{ $comment->created_at->format('Y-m-d') }}</td>
                                        <td width="18%">
                                            @if ($comment->user_id == auth()->id())
                                                <a href="javascript:void(0)" title="Delete Comment" class="btn btn-sm btn-danger" onclick="deleteComment({{ $comment->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No comments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Attachments Tab -->
                    <div class="tab-pane fade" id="attachments" role="tabpanel" aria-labelledby="articles-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-primary">Attachments</h5>
                            @if ($task->status != 'under_review' && $task->status != 'approved')
                                <a href="#" class="btn btn-sm btn-brand" data-bs-toggle="modal" data-bs-target="#addAttachmentModal">
                                    <i class="ph-plus me-2"></i> Upload Attachment
                                </a>
                            @endif
                        </div>
                        <table id="attachmentsTable" class="table table-striped table-bordered datatable-basic">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>File Name</th>
                                    <th>Uploaded By</th>
                                    <th>Created At</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($task->attachments as $index => $attachment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a></td>
                                        <td>{{ $attachment->user->name }}</td>
                                        <td>{{ $attachment->created_at->format('Y-m-d') }}</td>
                                        <td width="18%">
                                            @if ($attachment->user_id == auth()->id())
                                                <a href="javascript:void(0)" title="Delete Attachment" class="btn btn-sm btn-danger" onclick="deleteAttachment({{ $attachment->id }})">
                                                    <i class="ph-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No attachments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Task Review Tab -->
                    @if ($task->review)
                        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                            <h5 class="text-primary mb-3">Task Review</h5>
                            <p><strong>Rating:</strong> {{ $task->review->rating }} / 5</p>
                            <p><strong>Comments:</strong> {!! $task->review->review_comments ?: 'N/A' !!}</p>
                            <p><strong>Approved At:</strong> {{ $task->review->approved_at ? \Illuminate\Support\Carbon::parse($task->review->approved_at)->format('Y-m-d') : 'Not approved' }}</p>
                            <p><strong>Reviewed By:</strong> {{ $task->review->reviewer->name }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
@if ($task->status != 'under_review' && $task->status != 'approved')
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel">Edit Task: {{ $task->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote" placeholder="Enter details">{!! $task->description !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Project</label>
                            <select name="project_id" class="form-select">
                                <option value="">None</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control" value="{{ $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assigned Users</label>
                            <select name="users[]" class="form-select select2" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $task->users->contains($user->id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
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
@endif

<!-- Create Subtask Modal -->
@if ($task->status != 'under_review' && $task->status != 'approved')
    <div class="modal fade" id="createSubtaskModal" tabindex="-1" aria-labelledby="createSubtaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('subtasks.store', $task) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSubtaskModalLabel">New Subtask</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Subtask A" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote" placeholder="Enter details"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control">
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
@endif

<!-- Review Task Modal -->
@if ($task->status == 'under_review' && $task->creator_id == auth()->id())
    <div class="modal fade" id="reviewTaskModal" tabindex="-1" aria-labelledby="reviewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('task_reviews.store', $task) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewTaskModalLabel">Review Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rating (1-5)</label>
                            <input type="number" name="rating" class="form-control" min="1" max="5" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Review Comments</label>
                            <textarea name="review_comments" class="form-control summernote" placeholder="Enter feedback"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Approve Task</label>
                            <select name="approved" class="form-select" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Add Comment Modal -->
@if ($task->status != 'under_review' && $task->status != 'approved')
    <div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('comments.store') }}">
                    @csrf
                    <input type="hidden" name="commentable_id" value="{{ $task->id }}">
                    <input type="hidden" name="commentable_type" value="App\Models\Task">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCommentModalLabel">Add Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <textarea name="content" class="form-control summernote" placeholder="Enter comment" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<!-- Add Attachment Modal -->
@if ($task->status != 'under_review' && $task->status != 'approved')
    <div class="modal fade" id="addAttachmentModal" tabindex="-1" aria-labelledby="addAttachmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('attachments.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="attachable_id" value="{{ $task->id }}">
                    <input type="hidden" name="attachable_type" value="App\Models\Task">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAttachmentModalLabel">Upload Attachment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection

@push('footer-script')
    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                $(this).select2({ dropdownParent: $(this).parent() });
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
        });

        function deleteSubtask(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this subtask?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('subtasks.destroy', ':id') }}".replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Subtask has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Subtask deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }

        function deleteComment(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this comment?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('comments.destroy', ':id') }}".replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Comment has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Comment deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }

        function deleteAttachment(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this attachment?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('attachments.destroy', ':id') }}".replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Attachment has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Attachment deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush
