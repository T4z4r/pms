<!-- Add Submodule Modal -->
<div class="modal fade" id="addSubmoduleModal" tabindex="-1" aria-labelledby="addSubmoduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('systems.storeSubmodule', $system) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubmoduleModalLabel">Add Submodule</h5>
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
                        <label class="form-label">Module</label>
                        <select name="module_id" id="addSubmoduleModule" class="form-select select2" required>
                            <option value="" disabled selected>Select a module</option>
                            @foreach ($system->modules as $module)
                                <option value="{{ $module->id }}"
                                    {{ old('module_id') == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                            placeholder="Enter submodule name (e.g., Stock Management)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Enter submodule details">{!! old('description') !!}</textarea>
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

<!-- Edit Submodule Modals -->
@foreach ($submodules as $submodule)
    <div class="modal fade" id="editSubmoduleModal{{ $submodule->id }}" tabindex="-1"
        aria-labelledby="editSubmoduleModalLabel{{ $submodule->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('systems.updateSubmodule', [$system, $submodule]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubmoduleModalLabel{{ $submodule->id }}">Edit Submodule:
                            {{ $submodule->name }}</h5>
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
                            <label class="form-label">Module</label>
                            <select name="module_id" id="editSubmoduleModule{{ $submodule->id }}"
                                class="form-select select2" required>
                                <option value="" disabled>Select a module</option>
                                @foreach ($system->modules as $module)
                                    <option value="{{ $module->id }}"
                                        {{ old('module_id', $submodule->module_id) == $module->id ? 'selected' : '' }}>
                                        {{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $submodule->name) }}"
                                placeholder="Enter submodule name (e.g., Stock Management)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote" placeholder="Enter submodule details">{!! old('description', $submodule->description) !!}</textarea>
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
