<!-- Add Module Modal -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('systems.storeModule', $system) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModuleModalLabel">Add Module</h5>
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
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                            placeholder="Enter module name (e.g., Inventory)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Enter module details">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}"
                            placeholder="Enter order (e.g., 1)" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-brand">Add</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Module Modals -->
@foreach ($system->modules as $module)
    <div class="modal fade" id="editModuleModal{{ $module->id }}" tabindex="-1"
        aria-labelledby="editModuleModalLabel{{ $module->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('systems.updateModule', [$system, $module]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModuleModalLabel{{ $module->id }}">Edit Module:
                            {{ $module->name }}</h5>
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
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $module->name) }}"
                                placeholder="Enter module name (e.g., Inventory)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote" placeholder="Enter module details">{!! old('description', $module->description) !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Order</label>
                            <input type="number" name="order" class="form-control"
                                value="{{ old('order', $module->order ?? 0) }}" placeholder="Enter order (e.g., 1)"
                                min="0">
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
