@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <div class="d-flex gap-2 mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">{{ __('Clients') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug" class="form-label">{{ __('Slug') }}</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}">
                            <small class="text-muted">{{ __('Leave empty to auto-generate from name') }}</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- <div class="mb-3">
                    <label for="data" class="form-label">{{ __('Additional Data') }}</label>
                    <textarea class="form-control @error('data') is-invalid @enderror" id="data" name="data" rows="3">{{ old('data') }}</textarea>
                    <small class="text-muted">{{ __('Enter JSON format data') }}</small>
                    @error('data')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="mb-3">
                    <label class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                    </div>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('clients.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
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
            $('#status').val(isChecked ? '1' : '0');
        }

        // Initial call
        updateStatusLabel();

        // Update label when checkbox changes
        $('#status').change(updateStatusLabel);

        // Auto-generate slug from name
        $('#name').on('keyup', function() {
            if ($('#slug').val() === '') {
                let slug = $(this).val()
                    .toLowerCase()
                    .replace(/[^a-z0-9-]/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                $('#slug').val(slug);
            }
        });

        // Validate JSON in data field
        $('#data').on('change', function() {
            try {
                if ($(this).val()) {
                    JSON.parse($(this).val());
                    $(this).removeClass('is-invalid');
                }
            } catch (e) {
                $(this).addClass('is-invalid');
                $(this).next('.invalid-feedback').text('Invalid JSON format');
            }
        });
    });
</script>
@endpush 