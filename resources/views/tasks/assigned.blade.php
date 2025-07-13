```blade
@extends('layouts.backend')

@section('title', 'My Assigned Tasks')

@section('content')
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">My Assigned Tasks</h2>
                <p class="text-muted">View all tasks assigned to you.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Creator</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $index => $task)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->project->name ?? 'N/A' }}</td>
                                <td>{{ $task->creator->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $task->status == 'approved' ? 'success' : ($task->status == 'pending' ? 'secondary' : 'warning') }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>{{ $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $task->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('tasks.view', $task) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No assigned tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
```

#### Updated Task View (`resources/views/tasks/view.blade.php`)
This updates the provided view to:
- Disable operations (edit, delete, mark as completed, add subtasks, comments, attachments, remarks, updates) when the task or subtask is `under_review` or `approved` using `@if` statements.
- Add a new "Updates" section with a form to add updates and a table to display them, restricted by status and user assignment.

<xaiArtifact artifact_id="53c9454b-8c87-40d9-9fd4-cc9ae8aca075" artifact_version_id="2187ef2e-1986-42e3-ad6b-1b493852f553" title="Task View Blade" contentType="text/html">
```blade
@extends('layouts.backend')

@section('title', 'Task Details')

@section('content')
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">{{ $task->title }}</h2>
                <p class="text-muted">Detailed information about the task.</p>
            </div>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Tasks
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Task Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Title:</strong> {{ $task->title }}</p>
                        <p><strong>Description:</strong> {{ $task->description ?: 'N/A' }}</p>
                        <p><strong>Project:</strong> {{ $task->project->name ?? 'None' }}</p>
                        <p><strong>Creator:</strong> {{ $task->creator->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            <span class="badge bg-{{ $task->status == 'approved' ? 'success' : ($task->status == 'pending' ? 'secondary' : 'warning') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </p>
                        <p><strong>Due Date:</strong> {{ $task->due_date ? \Illuminate\Support\Carbon::parse($task->due_date)->format('Y-m-d') : 'N/A' }}</p>
                        <p><strong>Assigned Users:</strong> {{ $task->users->pluck('name')->implode(', ') ?: 'None' }}</p>
                        <p><strong>Created At:</strong> {{ $task->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
                @if ($task->status != 'under_review' && $task->status != 'approved' && $task->users->contains(auth()->user()))
                    <form action="{{ route('tasks.mark_completed', $task) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-primary">Mark as Completed</button>
                    </form>
                @endif
                @if ($task->status == 'under_review' && $task->creator_id == auth()->id())
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewTaskModal">
                        Review Task
                    </button>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Subtasks</h5>
                @if ($task->status != 'under_review' && $task->status != 'approved')
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createSubtaskModal">
                        <i class="fa fa-plus"></i> Add Subtask
                    </button>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($task->subtasks as $index => $subtask)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $subtask->title }}</td>
                                    <td>
                                        <span class="badge bg-{{ $subtask->status == 'approved' ? 'success' : ($subtask->status == 'pending' ? 'secondary' : 'warning') }}">
                                            {{ ucfirst($subtask->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $subtask->due_date ? \Illuminate\Support\Carbon::parse($subtask->due_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td>{{ $subtask->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        @if ($subtask->status != 'under_review' && $subtask->status != 'approved')
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editSubtaskModal{{ $subtask->id }}">Edit</button>
                                            <form action="{{ route('subtasks.destroy', $subtask) }}" method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                            <form action="{{ route('subtasks.mark_completed', $subtask) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-sm btn-primary">Mark as Completed</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Edit Subtask Modal -->
                                @if ($subtask->status != 'under_review' && $subtask->status != 'approved')
                                    <div class="modal fade" id="editSubtaskModal{{ $subtask->id }}" tabindex="-1"
                                         aria-labelledby="editSubtaskModalLabel{{ $subtask->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form class="modal-content" method="POST"
                                                  action="{{ route('subtasks.update', $subtask) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSubtaskModalLabel{{ $subtask->id }}">Edit Subtask</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" name="title" class="form-control"
                                                               value="{{ $subtask->title }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Description</label>
                                                        <textarea name="description" class="form-control">{{ $subtask->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Due Date</label>
                                                        <input type="date" name="due_date" class="form-control"
                                                               value="{{ $subtask->due_date ? \Illuminate\Support\Carbon::parse($subtask->due_date)->format('Y-m-d') : '' }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                                <!-- Subtask Updates -->
                                <tr>
                                    <td colspan="6">
                                        <div class="ms-4">
                                            <h6>Subtask Updates</h6>
                                            @if ($subtask->status != 'under_review' && $subtask->status != 'approved' && $task->users->contains(auth()->user()))
                                                <form method="POST" action="{{ route('task_updates.store') }}" class="mb-3">
                                                    @csrf
                                                    <input type="hidden" name="updatable_id" value="{{ $subtask->id }}">
                                                    <input type="hidden" name="updatable_type" value="App\Models\Subtask">
                                                    <div class="mb-3">
                                                        <label class="form-label">Add Update</label>
                                                        <textarea name="content" class="form-control" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Post Update</button>
                                                </form>
                                            @endif
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Update</th>
                                                            <th>Created At</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($subtask->updates as $updateIndex => $update)
                                                            <tr>
                                                                <td>{{ $updateIndex + 1 }}</td>
                                                                <td>{{ $update->user->name }}</td>
                                                                <td>{{ $update->content }}</td>
                                                                <td>{{ $update->created_at->format('Y-m-d H:i') }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center">No updates found.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Task Updates</h5>
                @if ($task->status != 'under_review' && $task->status != 'approved' && $task->users->contains(auth()->user()))
                    <form method="POST" action="{{ route('task_updates.store') }}" class="mb-3">
                        @csrf
                        <input type="hidden" name="updatable_id" value="{{ $task->id }}">
                        <input type="hidden" name="updatable_type" value="App\Models\Task">
                        <div class="mb-3">
                            <label class="form-label">Add Update</label>
                            <textarea name="content" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Update</button>
                    </form>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Update</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($task->updates as $index => $update)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $update->user->name }}</td>
                                    <td>{{ $update->content }}</td>
                                    <td>{{ $update->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No updates found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Comments</h5>
                @if ($task->status != 'under_review' && $task->status != 'approved')
                    <form method="POST" action="{{ route('comments.store') }}" class="mb-3">
                        @csrf
                        <input type="hidden" name="commentable_id" value="{{ $task->id }}">
                        <input type="hidden" name="commentable_type" value="App\Models\Task">
                        <div class="mb-3">
                            <label class="form-label">Add Comment</label>
                            <textarea name="content" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                    </form>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($task->comments as $index => $comment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ $comment->content }}</td>
                                    <td>{{ $comment->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        @if ($comment->user_id == auth()->id())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
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
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Attachments</h5>
                @if ($task->status != 'under_review' && $task->status != 'approved')
                    <form method="POST" action="{{ route('attachments.store') }}" enctype="multipart/form-data" class="mb-3">
                        @csrf
                        <input type="hidden" name="attachable_id" value="{{ $task->id }}">
                        <input type="hidden" name="attachable_type" value="App\Models\Task">
                        <div class="mb-3">
                            <label class="form-label">Upload File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Uploaded By</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($task->attachments as $index => $attachment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="{{ Storage::url($attachment->file_path) }}" target="_blank">{{ $attachment->file_name }}</a></td>
                                    <td>{{ $attachment->user->name }}</td>
                                    <td>{{ $attachment->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        @if ($attachment->user_id == auth()->id())
                                            <form action="{{ route('attachments.destroy', $attachment) }}" method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
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
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Remarks</h5>
                @if ($task->status != 'under_review' && $task->status != 'approved')
                    <form method="POST" action="{{ route('remarks.store') }}" class="mb-3">
                        @csrf
                        <input type="hidden" name="remarkable_id" value="{{ $task->id }}">
                        <input type="hidden" name="remarkable_type" value="App\Models\Task">
                        <div class="mb-3">
                            <label class="form-label">Add Remark</label>
                            <textarea name="content" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Remark</button>
                    </form>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Remark</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($task->remarks as $index => $remark)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $remark->user->name }}</td>
                                    <td>{{ $remark->content }}</td>
                                    <td>{{ $remark->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        @if ($remark->user_id == auth()->id())
                                            <form action="{{ route('remarks.destroy', $remark) }}" method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No remarks found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($task->review)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Task Review</h5>
                    <p><strong>Rating:</strong> {{ $task->review->rating }} / 5</p>
                    <p><strong>Comments:</strong> {{ $task->review->review_comments ?: 'N/A' }}</p>
                    <p><strong>Approved At:</strong> {{ $task->review->approved_at ? \Illuminate\Support\Carbon::parse($task->review->approved_at)->format('Y-m-d') : 'Not approved' }}</p>
                    <p><strong>Reviewed By:</strong> {{ $task->review->reviewer->name }}</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Create Subtask Modal -->
    @if ($task->status != 'under_review' && $task->status != 'approved')
        <div class="modal fade" id="createSubtaskModal" tabindex="-1" aria-labelledby="createSubtaskModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('subtasks.store', $task) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSubtaskModalLabel">New Subtask</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g., Subtask A" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" placeholder="Enter details"></textarea>
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
    @endif

    <!-- Review Task Modal -->
    @if ($task->status == 'under_review' && $task->creator_id == auth()->id())
        <div class="modal fade" id="reviewTaskModal" tabindex="-1" aria-labelledby="reviewTaskModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('task_reviews.store', $task) }}">
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
                            <textarea name="review_comments" class="form-control" placeholder="Enter feedback"></textarea>
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
    @endif
@endsection
```

---

### Explanation of Changes
#### Assigned Tasks View (`tasks/assigned.blade.php`)
- **Purpose**: Displays tasks where the authenticated user is an assignee, fetched via `TaskController@assigned`.
- **Features**:
  - Table with columns for task title, project, creator, status, due date, and creation date.
  - View button linking to the task details page.
  - Empty state message if no tasks are assigned.
- **Style**: Matches the reference (Bootstrap 5, modals, responsive table, badges), consistent with `tasks/index.blade.php`.
- **Data**: Expects `$tasks` from the controller, loaded with `project`, `creator`, and `users` relationships.

#### Task View Updates (`tasks/view.blade.php`)
- **Status-Based Restrictions**:
  - **Task Operations**:
    - "Mark as Completed" remains restricted to `pending`/`in_progress` tasks for assigned users with `@if ($task->status != 'under_review' && $task->status != 'approved' && $task->users->contains(auth()->user()))`.
    - Added `@if ($task->status != 'under_review' && $task->status != 'approved')` around comment, attachment, remark, and update forms.
  - **Subtask Operations**:
    - Wrapped "Add Subtask" button and modal in `@if ($task->status != 'under_review' && $task->status != 'approved')`.
    - Wrapped subtask actions (edit, delete, mark as completed) and edit modal in `@if ($subtask->status != 'under_review' && $subtask->status != 'approved')`.
    - Added subtask updates form under each subtask, restricted with `@if ($subtask->status != 'under_review' && $subtask->status != 'approved' && $task->users->contains(auth()->user()))`.
  - **Comment/Attachment/Remark Deletion**:
    - Replaced `@can('delete', ...)` with `@if ($comment->user_id == auth()->id())`, etc., to use direct user ID checks.
- **Task Updates**:
  - Added a "Task Updates" section with a form to post updates (textarea, submit button) and a table showing updates (user, content, timestamp).
  - Added a "Subtask Updates" section under each subtask, with a similar form and table.
  - Updates are restricted to assigned users and non-locked tasks/subtasks.
- **Review Logic**:
  - Kept the review modal/button condition (`@if ($task->status == 'under_review' && $task->creator_id == auth()->id())`) unchanged.
- **Date Formatting**:
  - Used `Carbon::parse()` for `due_date` and `approved_at`, consistent with the original.
  - Used `->format('Y-m-d H:i')` for update timestamps to show time.
- **Style**:
  - Maintained Bootstrap 5, Font Awesome, and reference style (cards, tables, badges, modals).
  - Nested subtask updates table with margin (`ms-4`) for visual hierarchy.

---

### Testing Instructions
1. **Run the Server**:
   ```bash
   php artisan serve
   ```
2. **Log In**: Use a seeded user (e.g., `admin@example.com`, `password`).
3. **Assigned Tasks** (`/tasks/assigned`):
   - Verify only tasks where you’re an assignee appear.
   - Check table columns (title, project, creator, status, due date, created at).
   - Click "View" to navigate to the task details page.
   - Test with no assigned tasks (should show "No assigned tasks found").
4. **Task View** (`/tasks/{id}/view`):
   - For a `pending` task:
     - Verify "Mark as Completed" (if assigned), "Add Subtask" button, comment/attachment/remark/update forms, and subtask actions (edit, delete, mark as completed, add updates) are visible.
     - Add a subtask, edit/delete it, mark it as completed, post task/subtask updates.
     - Delete your own comments/attachments/remarks.
   - Mark the task as completed (`under_review`):
     - Confirm "Mark as Completed", "Add Subtask" button, comment/attachment/remark/update forms, and subtask actions are hidden.
     - Verify the creator can see the "Review Task" button/modal.
     - Ensure comment/attachment/remark deletion buttons are visible for your own entries.
   - Approve the task (`approved`):
     - Confirm all operations (except view, review display, and user-owned deletions) remain hidden.
   - For a subtask in `under_review` or `approved`:
     - Verify its actions (edit, delete, mark as completed, add updates) are hidden, even if the task is `pending`.
   - Test Updates:
     - Post task and subtask updates, verify they appear in the respective tables.
     - Ensure updates are blocked for non-assigned users or locked tasks/subtasks (controller error message).
5. **Permissions**:
   - Confirm non-assigned users can’t post updates or mark tasks/subtasks as completed (controller logic).
   - Verify only the creator can delete their comments/attachments/remarks.
6. **Edge Cases**:
   - Test with a task/subtask already in `approved` status (e.g., via seeder).
   - Confirm UI updates (no buttons/forms) when status changes.

---

### Additional Notes
- **Assigned Tasks View**: Simple table-based view, extensible for filters (e.g., status, project) if needed.
- **Task Updates**:
  - Updates are text-based, stored in `task_updates`, and visible to all task participants.
  - Restricted to assigned users via controller and Blade checks.
  - No deletion for updates (to maintain a history), but can be added if required.
- **Status Restrictions**: Used `@if` statements to disable operations, consistent with previous requirements. Backend checks in controllers prevent bypassing UI restrictions.
- **Style**: Matches Bootstrap 5, Font Awesome, and reference style (e.g., positions example).
- **Performance**: The view loads updates via eager loading (`updates.user`). For large datasets, consider pagination.
- **Dependencies**: Ensure migrations are run (`php artisan migrate`), storage is linked (`php artisan storage:link`), and `maatwebsite/excel` is installed.
- **Enhancements** (if needed):
  - Add filters to the assigned tasks view (e.g., by status, project).
  - Include update notifications (e.g., email to task participants).
  - Display a "Task locked" message when actions are disabled.

This implementation adds the assigned tasks view and task/subtask updates, updating `tasks/view.blade.php` to disable operations for `under_review` or `approved` tasks/subtasks using `@if` statements. Let me know if you need further refinements or additional features!
