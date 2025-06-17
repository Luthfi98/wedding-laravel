@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('settings.index') }}"> Setting</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Type') }}</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>{{ __('Text') }}</option>
                                <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>{{ __('Number') }}</option>
                                <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>{{ __('File') }}</option>
                                <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>{{ __('Select') }}</option>
                                <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>{{ __('Textarea') }}</option>
                                <option value="code" {{ old('type') == 'code' ? 'selected' : '' }}>{{ __('Code') }}</option>
                                <option value="radio" {{ old('type') == 'radio' ? 'selected' : '' }}>{{ __('Radio') }}</option>
                                <option value="checkbox" {{ old('type') == 'checkbox' ? 'selected' : '' }}>{{ __('Checkbox') }}</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="value" class="form-label">{{ __('Value') }}</label>
                            <div id="value-container">
                                <!-- Dynamic input will be inserted here -->
                            </div>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">{{ __('Status') }}</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="active" {{ old('status', 'active') === 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('settings.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js"></script>
<script>
    $(document).ready(function() {
        // Status switch handler
        $('#status').on('change', function() {
            $('#statusLabel').text($(this).is(':checked') ? '{{ __("Active") }}' : '{{ __("Inactive") }}');
            $(this).val($(this).is(':checked') ? 'active' : 'inactive');
        }).trigger('change');

        let codeEditor = null;

        // Type change handler
        $('#type').on('change', function() {
            const type = $(this).val();
            const container = $('#value-container');
            container.empty();

            switch(type) {
                case 'text':
                    container.html('<input type="text" class="form-control" name="value" value="{{ old("value") }}">');
                    break;
                case 'number':
                    container.html('<input type="number" class="form-control" name="value" value="{{ old("value") }}">');
                    break;
                case 'file':
                    container.html('<input type="file" class="form-control" name="value">');
                    break;
                case 'select':
                    container.html(`
                        <div class="select-options">
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-primary add-option">Add Option</button>
                            </div>
                            <div class="options-container">
                                <div class="option-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="value[options][]" placeholder="Option value">
                                        <input type="text" class="form-control" name="value[labels][]" placeholder="Option label">
                                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    break;
                case 'textarea':
                    container.html('<textarea class="form-control" name="value" rows="3">{{ old("value") }}</textarea>');
                    break;
                case 'code':
                    container.html('<textarea class="form-control" name="value" id="valueEditor">{{ old("value") }}</textarea>');
                    // Initialize CodeMirror after the textarea is added to the DOM
                    setTimeout(() => {
                        if (codeEditor) {
                            codeEditor.toTextArea();
                        }
                        codeEditor = CodeMirror.fromTextArea(document.getElementById('valueEditor'), {
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
                    }, 0);
                    break;
                case 'radio':
                    container.html(`
                        <div class="radio-options">
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-primary add-radio">Add Radio Option</button>
                            </div>
                            <div class="radio-container">
                                <div class="radio-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="value[options][]" placeholder="Option value">
                                        <input type="text" class="form-control" name="value[labels][]" placeholder="Option label">
                                        <button type="button" class="btn btn-danger remove-radio">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    break;
                case 'checkbox':
                    container.html(`
                        <div class="checkbox-options">
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-primary add-checkbox">Add Checkbox Option</button>
                            </div>
                            <div class="checkbox-container">
                                <div class="checkbox-item mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="value[options][]" placeholder="Option value">
                                        <input type="text" class="form-control" name="value[labels][]" placeholder="Option label">
                                        <button type="button" class="btn btn-danger remove-checkbox">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    break;
            }

            // Initialize event handlers for dynamic elements
            initializeDynamicHandlers();
        }).trigger('change');

        function initializeDynamicHandlers() {
            // Select options
            $('.add-option').on('click', function() {
                const optionHtml = `
                    <div class="option-item mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" name="value[options][]" placeholder="Option value">
                            <input type="text" class="form-control" name="value[labels][]" placeholder="Option label">
                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                        </div>
                    </div>
                `;
                $('.options-container').append(optionHtml);
            });

            // Radio options
            $('.add-radio').on('click', function() {
                const radioHtml = `
                    <div class="radio-item mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" name="value[options][]" placeholder="Option value">
                            <input type="text" class="form-control" name="value[labels][]" placeholder="Option label">
                            <button type="button" class="btn btn-danger remove-radio">Remove</button>
                        </div>
                    </div>
                `;
                $('.radio-container').append(radioHtml);
            });

            // Checkbox options
            $('.add-checkbox').on('click', function() {
                const checkboxHtml = `
                    <div class="checkbox-item mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" name="value[options][]" placeholder="Option value">
                            <input type="text" class="form-control" name="value[labels][]" placeholder="Option label">
                            <button type="button" class="btn btn-danger remove-checkbox">Remove</button>
                        </div>
                    </div>
                `;
                $('.checkbox-container').append(checkboxHtml);
            });

            // Remove handlers
            $(document).on('click', '.remove-option', function() {
                $(this).closest('.option-item').remove();
            });

            $(document).on('click', '.remove-radio', function() {
                $(this).closest('.radio-item').remove();
            });

            $(document).on('click', '.remove-checkbox', function() {
                $(this).closest('.checkbox-item').remove();
            });
        }
    });
</script>
@endpush