@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('banks.index') }}"> Bank</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('banks.update', $bank->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $bank->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="code" class="form-label">{{ __('Code') }}</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $bank->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            @if($bank->image)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset($bank->image) }}" alt="{{ $bank->name }}" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">{{ __('Status') }}</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="active" {{ old('status', $bank->status) === 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('banks.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#status').on('change', function() {
            $('#statusLabel').text($(this).is(':checked') ? '{{ __("Active") }}' : '{{ __("Inactive") }}');
            $(this).val($(this).is(':checked') ? 'active' : 'inactive');
        }).trigger('change');
    });
</script>
@endpush 