<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-success mb-2"><i class="ph-file-xls me-1"></i> Export to Excel</h6>
                <ul class="list-unstyled ms-3 mb-3">
                    <li><a class="dropdown-item" href="{{ route('systems.exportFeaturesExcel', $system) }}">Features</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('systems.exportRequirementsExcel', $system) }}">Requirements</a></li>
                </ul>
                <h6 class="text-danger mb-2"><i class="ph-file-pdf me-1"></i> Export to PDF</h6>
                <ul class="list-unstyled ms-3">
                    <li><a class="dropdown-item" href="{{ route('systems.exportFeaturesPdf', $system) }}">Features</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('systems.exportRequirementsPdf', $system) }}">Requirements</a></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
