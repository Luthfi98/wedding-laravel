@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }} <small class="text-muted">({{ __('Only fill if you want to change') }})</small></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ $user->password == old('password', $user->password) ? '' : 'required' }}>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ $user->password == old('password', $user->password) ? '' : 'required' }}>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="mb-3">
                            <label for="role_id" class="form-label">{{ __('Role') }}</label>
                            <select class="form-select select2 @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
                                <option value="">{{ __('Select Role') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->roles->first()->id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->guard_name) }} - {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">{{ __('Status') }}</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="active" {{ old('status', $user->status, 'active') === 'active' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
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