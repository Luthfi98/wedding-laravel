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
            <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="html_file" class="form-label">{{ __('HTML File') }}</label>
                            <input type="file" class="form-control @error('html_file') is-invalid @enderror" id="html_file" name="html_file" accept=".html,.htm">
                            <small class="text-muted">{{ __('Max size: 2MB, Allowed: .html, .htm') }}</small>
                            @error('html_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="css_file" class="form-label">{{ __('CSS File') }}</label>
                            <input type="file" class="form-control @error('css_file') is-invalid @enderror" id="css_file" name="css_file" accept=".css">
                            <small class="text-muted">{{ __('Max size: 2MB, Allowed: .css') }}</small>
                            @error('css_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="js_file" class="form-label">{{ __('JavaScript File') }}</label>
                            <input type="file" class="form-control @error('js_file') is-invalid @enderror" id="js_file" name="js_file" accept=".js">
                            <small class="text-muted">{{ __('Max size: 2MB, Allowed: .js') }}</small>
                            @error('js_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="active" {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                    </div>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('templates.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
    });
</script>
@endpush
