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

<!-- Add Submodule Modal -->
<div class="modal fade" id="addSubmoduleModal" tabindex="-1" aria-labelledby="addSubmoduleModalLabel"
    aria-hidden="true">
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

<!-- Add Feature Modal -->
<div class="modal fade" id="addFeatureModal" tabindex="-1" aria-labelledby="addFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('systems.storeFeature', $system) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFeatureModalLabel">Add Feature</h5>
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
                            placeholder="Enter feature title (e.g., User Authentication)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" placeholder="Enter feature details">{!! old('description') !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Module</label>
                        <select name="module_id" id="addFeatureModule" class="form-select select2">
                            <option value="">None</option>
                            @foreach ($system->modules as $module)
                                <option value="{{ $module->id }}"
                                    {{ old('module_id') == $module->id ? 'selected' : '' }}>{{ $module->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Submodule</label>
                        <select name="submodule_id" id="addFeatureSubmodule" class="form-select select2">
                            <option value="">None</option>
                            @if (old('module_id'))
                                @foreach (\App\Models\Submodule::where('module_id', old('module_id'))->get() as $submodule)
                                    <option value="{{ $submodule->id }}"
                                        {{ old('submodule_id') == $submodule->id ? 'selected' : '' }}>
                                        {{ $submodule->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="planned" {{ old('status') === 'planned' ? 'selected' : '' }}>Planned
                            </option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>On Hold
                            </option>
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
                            <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium
                            </option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending
                            </option>
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
