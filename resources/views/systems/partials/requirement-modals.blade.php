<!-- Add Requirement Modal -->
<div class="modal fade" id="addRequirementModal" tabindex="-1" aria-labelledby="addRequirementModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('systems.storeRequirement', $system) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addRequirementModalLabel">Add Requirement</h5>
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
                            placeholder="Enter requirement title (e.g., OAuth 2.0 Support)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Enter requirement details">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select" required>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status') === 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                            <option value="implemented" {{ old('status') === 'implemented' ? 'selected' : '' }}>
                                Implemented</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Requirement Modals -->
@foreach ($system->requirements as $requirement)
    <div class="modal fade" id="editRequirementModal{{ $requirement->id }}" tabindex="-1"
        aria-labelledby="editRequirementModalLabel{{ $requirement->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('systems.updateRequirement', [$system, $requirement]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRequirementModalLabel{{ $requirement->id }}">Edit Requirement:
                            {{ $requirement->title }}</h5>
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
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $requirement->title) }}"
                                placeholder="Enter requirement title (e.g., OAuth 2.0 Support)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote" placeholder="Enter requirement details">{!! old('description', $requirement->description) !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select" required>
                                <option value="low"
                                    {{ old('priority', $requirement->priority) === 'low' ? 'selected' : '' }}>Low
                                </option>
                                <option value="medium"
                                    {{ old('priority', $requirement->priority) === 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="high"
                                    {{ old('priority', $requirement->priority) === 'high' ? 'selected' : '' }}>High
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending"
                                    {{ old('status', $requirement->status) === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved"
                                    {{ old('status', $requirement->status) === 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected"
                                    {{ old('status', $requirement->status) === 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                                <option value="implemented"
                                    {{ old('status', $requirement->status) === 'implemented' ? 'selected' : '' }}>
                                    Implemented</option>
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
