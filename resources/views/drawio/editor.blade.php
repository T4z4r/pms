@extends('layouts.vertical', ['title' => 'Draw.io Editor'])

@push('head-script')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="https://embed.diagrams.net/static/js/app.min.js"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="card border-top border-top-width-3 border-top-black rounded-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="lead text-primary">
                <i class="ph-pencil me-2"></i> Draw.io Editor
            </h4>
            <div>
                <a href="{{ route('system-designs.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="ph-blueprint me-2"></i> Go to System Designs
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Diagram Type</label>
                <select id="designType" class="form-select select2">
                    <option value="erd">Entity-Relationship Diagram (ERD)</option>
                    <option value="class_diagram">Class Diagram</option>
                    <option value="flowchart">Flowchart</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Diagram Editor</label>
                <div id="loading" class="text-center" style="display: none;">Loading editor...</div>
                <iframe id="drawioEditor" style="width: 100%; height: 600px; border: 1px solid #ccc;"></iframe>
                <div id="drawioError" class="text-danger mt-2 d-none"></div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button id="downloadPng" class="btn btn-primary">
                    <i class="ph-download-simple me-2"></i> Download as PNG
                </button>
                <button id="downloadSvg" class="btn btn-outline-primary">
                    <i class="ph-download-simple me-2"></i> Download as SVG
                </button>
            </div>
            <div class="mt-3">
                <div class="alert alert-info">
                    <strong>Instructions:</strong>
                    <ol>
                        <li>Select a diagram type above.</li>
                        <li>Create or edit your diagram in the editor.</li>
                        <li>Click "Download as PNG" or "Download as SVG" to save your diagram.</li>
                        <li>Go to the <a href="{{ route('system-designs.index') }}">System Designs</a> page to upload the
                            PNG and associate it with a system.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <style>
        iframe {
            overflow: auto;
        }

        .text-danger.d-none {
            display: none;
        }
    </style>

    @push('footer-script')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: 'Select a diagram type',
                    allowClear: true,
                    width: '100%'
                });

                let editorLoaded = false;
                const iframe = document.getElementById('drawioEditor');
                const errorDiv = $('#drawioError');
                const loadingDiv = $('#loading');

                // Show loading indicator
                loadingDiv.show();

                // Set iframe source
                iframe.src = 'https://embed.diagrams.net/?embed=1&ui=atlas&spin=1&proto=json&configure=1';

                // Handle iframe load
                iframe.onload = function() {
                    loadingDiv.hide();
                    const receive = function(evt) {
                        if (evt.origin !== 'https://embed.diagrams.net') return;
                        const msg = JSON.parse(evt.data);
                        if (msg.event === 'configure') {
                            iframe.contentWindow.postMessage(JSON.stringify({
                                action: 'configure',
                                config: {
                                    autoSave: false,
                                    enableLocalStorage: false,
                                    defaultFonts: ['Arial', 'Helvetica', 'Verdana']
                                }
                            }), '*');
                        } else if (msg.event === 'init') {
                            loadDefaultDiagram();
                            editorLoaded = true;
                        } else if (msg.event === 'export') {
                            if (msg.data) {
                                const format = msg.format || 'png';
                                const mimeType = format === 'png' ? 'image/png' : 'image/svg+xml';
                                const blob = new Blob([atob(msg.data.replace(`data:${mimeType};base64,`, ''))], {
                                    type: mimeType
                                });
                                const url = window.URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.href = url;
                                a.download = `diagram-${new Date().toISOString()}.${format}`;
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                                window.URL.revokeObjectURL(url);
                                errorDiv.addClass('d-none');
                            } else {
                                errorDiv.text(`Failed to export diagram as ${msg.format.toUpperCase()}.`).removeClass('d-none');
                            }
                        } else if (msg.event === 'error') {
                            errorDiv.text('Editor error: ' + msg.message).removeClass('d-none');
                            Swal.fire('Error', 'Editor error: ' + msg.message, 'error');
                        }
                    };
                    window.addEventListener('message', receive);

                    // Debounced diagram type change
                    let debounceTimeout;
                    $('#designType').on('change', function() {
                        clearTimeout(debounceTimeout);
                        debounceTimeout = setTimeout(loadDefaultDiagram, 300);
                    });

                    $('#downloadPng').on('click', function(e) {
                        e.preventDefault();
                        errorDiv.addClass('d-none');
                        iframe.contentWindow.postMessage(JSON.stringify({
                            action: 'export',
                            format: 'png'
                        }), '*');
                    });

                    $('#downloadSvg').on('click', function(e) {
                        e.preventDefault();
                        errorDiv.addClass('d-none');
                        iframe.contentWindow.postMessage(JSON.stringify({
                            action: 'export',
                            format: 'svg'
                        }), '*');
                    });
                };

                // Handle iframe load error
                iframe.onerror = function() {
                    loadingDiv.hide();
                    errorDiv.text('Failed to load Draw.io editor. Please check your internet connection.').removeClass('d-none');
                };

                function loadDefaultDiagram() {
                    const type = $('#designType').val();
                    let xml = '<mxGraphModel><root><mxCell id="0"/><mxCell id="1" parent="0"/>';
                    if (type === 'erd') {
                        xml += '<mxCell id="2" value="Entity" style="rounded=1;whiteSpace=wrap;html=1;" vertex="1" parent="1"><mxGeometry x="100" y="100" width="120" height="60" as="geometry"/></mxCell>';
                    } else if (type === 'class_diagram') {
                        xml += '<mxCell id="2" value="Class" style="shape=umlClass;whiteSpace=wrap;html=1;" vertex="1" parent="1"><mxGeometry x="100" y="100" width="120" height="60" as="geometry"/></mxCell>';
                    } else if (type === 'flowchart') {
                        xml += '<mxCell id="2" value="Start" style="rounded=1;whiteSpace=wrap;html=1;" vertex="1" parent="1"><mxGeometry x="100" y="100" width="80" height="40" as="geometry"/></mxCell>';
                    }
                    xml += '</root></mxGraphModel>';
                    if (editorLoaded) {
                        iframe.contentWindow.postMessage(JSON.stringify({
                            action: 'load',
                            xml: xml
                        }), '*');
                    }
                }
            });
        </script>
    @endpush
@endsection