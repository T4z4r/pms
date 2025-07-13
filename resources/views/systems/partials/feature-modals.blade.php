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
                                    {{ old('module_id') == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
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
                            <option value="planned" {{ old('status') === 'planned' ? 'selected' : '' }}>Planned</option>
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

<!-- Edit Feature Modals -->
@foreach ($system->features as $feature)
    <div class="modal fade" id="editFeatureModal{{ $feature->id }}" tabindex="-1"
        aria-labelledby="editFeatureModalLabel{{ $feature->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('systems.updateFeature', [$system, $feature]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFeatureModalLabel{{ $feature->id }}">Edit Feature:
                            {{ $feature->title }}</h5>
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
                                value="{{ old('title', $feature->title) }}"
                                placeholder="Enter feature title (e.g., User Authentication)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control summernote" placeholder="Enter feature details">{!! old('description', $feature->description) !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Module</label>
                            <select name="module_id" id="editFeatureModule{{ $feature->id }}"
                                class="form-select select2">
                                <option value="">None</option>
                                @foreach ($system->modules as $module)
                                    <option value="{{ $module->id }}"
                                        {{ old('module_id', $feature->module_id) == $module->id ? 'selected' : '' }}>
                                        {{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Submodule</label>
                            <select name="submodule_id" id="editFeatureSubmodule{{ $feature->id }}"
                                class="form-select select2">
                                <option value="">None</option>
                                @if (old('module_id', $feature->module_id))
                                    @foreach (\App\Models\Submodule::where('module_id', old('module_id', $feature->module_id))->get() as $submodule)
                                        <option value="{{ $submodule->id }}"
                                            {{ old('submodule_id', $feature->submodule_id) == $submodule->id ? 'selected' : '' }}>
                                            {{ $submodule->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="planned"
                                    {{ old('status', $feature->status) === 'planned' ? 'selected' : '' }}>Planned
                                </option>
                                <option value="in_progress"
                                    {{ old('status', $feature->status) === 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="completed"
                                    {{ old('status', $feature->status) === 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="on_hold"
                                    {{ old('status', $feature->status) === 'on_hold' ? 'selected' : '' }}>On Hold
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
