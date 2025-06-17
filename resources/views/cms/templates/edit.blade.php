@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <div class="d-flex gap-2 mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">{{ __('Templates') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>

    <div class="card">


        <div class="card-body">
            <form action="{{ route('templates.update', $template->id) }}" method="POST" enctype="multipart/form-data" id="templateForm">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $template->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="active" {{ old('status', $template->status) == 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="2">{{ old('description', $template->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <ul class="nav nav-tabs mb-3" id="codeTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="html-tab" data-bs-toggle="tab" data-bs-target="#html" type="button" role="tab">
                            <i class="bi bi-filetype-html"></i> HTML
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="css-tab" data-bs-toggle="tab" data-bs-target="#css" type="button" role="tab">
                            <i class="bi bi-filetype-css"></i> CSS
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="js-tab" data-bs-toggle="tab" data-bs-target="#js" type="button" role="tab">
                            <i class="bi bi-filetype-js"></i> JavaScript
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="php-tab" data-bs-toggle="tab" data-bs-target="#php" type="button" role="tab">
                            <i class="bi bi-filetype-php"></i> PHP
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="codeTabsContent">
                    <div class="tab-pane fade show active" id="html" role="tabpanel">
                        <div class="mb-3">
                            <label for="html_content" class="form-label">{{ __('HTML Content') }}</label>
                            <textarea class="form-control @error('html_content') is-invalid @enderror" id="htmlEditor" name="html_content">{{ $htmlContent }}</textarea>
                            @error('html_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="tab-pane fade" id="css" role="tabpanel">
                        <div class="mb-3">
                            <label for="css_content" class="form-label">{{ __('CSS Content') }}</label>
                            <textarea class="form-control @error('css_content') is-invalid @enderror" id="cssEditor" name="css_content">{{ $cssContent }}</textarea>
                            @error('css_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="tab-pane fade" id="js" role="tabpanel">
                        <div class="mb-3">
                            <label for="js_content" class="form-label">{{ __('JavaScript Content') }}</label>
                            <textarea class="form-control @error('js_content') is-invalid @enderror" id="jsEditor" name="js_content">{{ $jsContent }}</textarea>
                            @error('js_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                     <div class="tab-pane fade" id="php" role="tabpanel">
                        <div class="mb-3">
                            <label for="php_content" class="form-label">{{ __('PHP Content') }}</label>
                            <textarea class="form-control @error('php_content') is-invalid @enderror" id="phpEditor" name="php_content">{{ $phpContent??'' }}</textarea>
                            @error('php_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-sm btn-info" id="previewBtn">
                        <i class="bi bi-eye"></i> {{ __('Preview') }}
                    </button>
                    <a href="{{ route('templates.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">{{ __('Template Preview') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewFrame" style="width: 100%; height: calc(100vh - 200px); border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">
<style>
    .CodeMirror {
        height: calc(100vh - 400px);
        min-height: 400px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .nav-tabs .nav-link {
        padding: 0.5rem 1rem;
    }
    .nav-tabs .nav-link i {
        margin-right: 0.5rem;
    }
    .tab-content {
        background: #fff;
        padding: 1rem;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.25rem 0.25rem;
    }
    #previewModal .modal-content {
        height: calc(100vh - 100px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>

<script>
    $(document).ready(function() {
        // Function to update status label
        function updateStatusLabel() {
            const isChecked = $('#status').is(':checked');
            $('#statusLabel').text(isChecked ? '{{ __("Active") }}' : '{{ __("Inactive") }}');
            $('#status').val(isChecked ? 'active' : 'inactive');
        }

        // Initial call
        updateStatusLabel();

        // Update label when checkbox changes
        $('#status').change(updateStatusLabel);

        // Initialize CodeMirror editors
        var htmlEditor = CodeMirror.fromTextArea(document.getElementById('htmlEditor'), {
            mode: 'htmlmixed',
            theme: 'monokai',
            lineNumbers: true,
            autoCloseTags: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            indentUnit: 4,
            lineWrapping: true,
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            }
        });

        var cssEditor = CodeMirror.fromTextArea(document.getElementById('cssEditor'), {
            mode: 'css',
            theme: 'monokai',
            lineNumbers: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            indentUnit: 4,
            lineWrapping: true,
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            }
        });

        var jsEditor = CodeMirror.fromTextArea(document.getElementById('jsEditor'), {
            mode: 'javascript',
            theme: 'monokai',
            lineNumbers: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            indentUnit: 4,
            lineWrapping: true,
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            }
        });

        var phpEditor = CodeMirror.fromTextArea(document.getElementById('phpEditor'), {
            mode: 'htmlmixed',
            theme: 'monokai',
            lineNumbers: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            indentUnit: 4,
            lineWrapping: true,
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            }
        });


        // Function to save HTML content
        function saveHtml() {
            htmlEditor.save();
            const content = $('#htmlEditor').val();
            
            $.ajax({
                url: "{{ route('templates.update.html', $template->id) }}",
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    html_content: content
                },
                success: function(response) {
                    showToast(response.message);
                },
                error: function(xhr) {
                    showToast(xhr.responseJSON.message || 'Error updating HTML content', 'error');
                }
            });
        }

        // Function to save CSS content
        function saveCss() {
            cssEditor.save();
            const content = $('#cssEditor').val();
            
            $.ajax({
                url: "{{ route('templates.update.css', $template->id) }}",
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    css_content: content
                },
                success: function(response) {
                    showToast(response.message);
                },
                error: function(xhr) {
                    showToast(xhr.responseJSON.message || 'Error updating CSS content', 'error');
                }
            });
        }

        // Function to save JS content
        function saveJs() {
            jsEditor.save();
            const content = $('#jsEditor').val();
            
            $.ajax({
                url: "{{ route('templates.update.js', $template->id) }}",
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    js_content: content
                },
                success: function(response) {
                    showToast(response.message);
                },
                error: function(xhr) {
                    showToast(xhr.responseJSON.message || 'Error updating JavaScript content', 'error');
                }
            });
        }

        function saveJs() {
            jsEditor.save();
            const content = $('#jsEditor').val();
            
            $.ajax({
                url: "{{ route('templates.update.js', $template->id) }}",
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    js_content: content
                },
                success: function(response) {
                    showToast(response.message);
                },
                error: function(xhr) {
                    showToast(xhr.responseJSON.message || 'Error updating JavaScript content', 'error');
                }
            });
        }

        function savePhp() {
            phpEditor.save();
            const content = $('#phpEditor').val();
            
            $.ajax({
                url: "{{ route('templates.update.php', $template->id) }}",
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    php_content: content
                },
                success: function(response) {
                    showToast(response.message);
                },
                error: function(xhr) {
                    showToast(xhr.responseJSON.message || 'Error updating PHP content', 'error');
                }
            });
        }


        // Add save buttons to each editor
        $('.CodeMirror').each(function() {
            const editor = $(this);
            const saveButton = $('<button type="button" class="btn btn-sm btn-success position-absolute" style="top: 10px; right: 10px; z-index: 1000;"><i class="bi bi-save"></i> Save</button>');
            editor.parent().css('position', 'relative').append(saveButton);
        });

        // Handle save button clicks
        $('#html').find('.btn-success').click(function(e) {
            e.preventDefault();
            saveHtml();
        });
        
        $('#css').find('.btn-success').click(function(e) {
            e.preventDefault();
            saveCss();
        });
        
        $('#js').find('.btn-success').click(function(e) {
            e.preventDefault();
            saveJs();
        });

        $('#php').find('.btn-success').click(function(e) {
            e.preventDefault();
            savePhp();
        });

        // Handle tab switching
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            // Refresh the editor that was just shown
            if (e.target.id === 'html-tab') {
                htmlEditor.refresh();
            } else if (e.target.id === 'css-tab') {
                cssEditor.refresh();
            } else if (e.target.id === 'js-tab') {
                jsEditor.refresh();
            }
        });

        // Preview functionality
        $('#previewBtn').click(function() {
            // Save current editor content
            htmlEditor.save();
            cssEditor.save();
            jsEditor.save();

            // Get the content
            const htmlContent = $('#htmlEditor').val();
            const cssContent = $('#cssEditor').val();
            const jsContent = $('#jsEditor').val();

            // Create a complete HTML document
            const previewContent = `
                ${htmlContent}
            `;

            // Create a Blob and URL
            const blob = new Blob([previewContent], { type: 'text/html' });
            const url = URL.createObjectURL(blob);

            // Set the iframe source
            $('#previewFrame').attr('src', '{{ asset('assets/' . $template->id . '/template.html') }}');

            // Show the modal
            $('#previewModal').modal('show');

            // Clean up the URL when modal is closed
            $('#previewModal').on('hidden.bs.modal', function () {
                URL.revokeObjectURL(url);
            });
        });

        // Handle form submission for basic info
        $('#templateForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    showToast(response.message);
                },
                error: function(xhr) {
                    showToast(xhr.responseJSON.message || 'Error updating template', 'error');
                }
            });
        });
    });
</script>
@endpush 