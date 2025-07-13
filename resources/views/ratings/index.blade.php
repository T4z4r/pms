@extends('layouts.vertical', ['title' => 'Ratings'])

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
                <i class="ph-star text-secondary"></i> Ratings
            </h4>
            <a href="#" class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#createRatingModal">
                <i class="ph-plus me-2"></i> New Rating
            </a>
        </div>
    </div>

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto" role="alert">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card-body">
        <table id="ratingsTable" class="table table-striped table-bordered datatable-basic">
            <thead>
                <tr>
                    <th>SN.</th>
                    <th>Project</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Created At</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ratings as $index => $rating)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rating->project->name }}</td>
                        <td>{{ $rating->user->name }}</td>
                        <td>{{ $rating->rating }}</td>
                        <td>{{ $rating->comment }}</td>
                        <td>{{ $rating->created_at->format('Y-m-d') }}</td>
                        <td width="18%">
                            <a href="#" title="Edit Rating" class="btn btn-sm btn-main" data-bs-toggle="modal" data-bs-target="#editRatingModal{{ $rating->id }}">
                                <i class="ph-note-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" title="Delete Rating" class="btn btn-sm btn-danger" onclick="deleteRating({{ $rating->id }})">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editRatingModal{{ $rating->id }}" tabindex="-1" aria-labelledby="editRatingModalLabel{{ $rating->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('ratings.update', $rating) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editRatingModalLabel{{ $rating->id }}">Edit Rating</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Project</label>
                                            <select name="project_id" class="form-select" required>
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}" {{ $project->id == $rating->project_id ? 'selected' : '' }}>
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Rating (1-5)</label>
                                            <input type="number" name="rating" class="form-control" value="{{ $rating->rating }}" min="1" max="5" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Comment</label>
                                            <textarea name="comment" class="form-control">{{ $rating->comment }}</textarea>
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
                        <td colspan="7" class="text-center">No ratings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createRatingModal" tabindex="-1" aria-labelledby="createRatingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('ratings.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createRatingModalLabel">New Rating</h5>
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
                        <label class="form-label">Rating (1-5)</label>
                        <input type="number" name="rating" class="form-control" placeholder="e.g. 4" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" class="form-control" placeholder="Enter comment"></textarea>
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
        function deleteRating(id) {
            Swal.fire({
                text: 'Are you sure you want to delete this rating?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('ratings.destroy', ':id') }}".replace(':id', id),
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .done(function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Rating has been deleted successfully.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Rating deletion failed.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
@endpush