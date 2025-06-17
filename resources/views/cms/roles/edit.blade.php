@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <div class="d-flex gap-2 mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="guard_name" class="form-label">{{ __('Guard') }}</label>
                            <input type="text" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" value="{{ old('guard_name', $role->guard_name) }}" required>
                            @error('guard_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Update') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="card">
                    <div class="card-body" style="height: 100%; overflow-y: auto;">
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="row">
                                @foreach ($permissions as $key => $permission)
                                    <div class="col-md-12 mb-2">
                                        <h6 class="text-primary">{{ $key }}</h6>
                                        <div class="row">
                                            @foreach ($permission as $p)
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $p->id }}" id="permission_{{ $p->id }}" {{ $role->permissions->contains($p->id) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $p->id }}">
                                                            {{ ucwords($p->name) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

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

        // Initial call to set correct label
        updateStatusLabel();

        // Update label when switch is toggled
        $('#status').on('change', function() {
            updateStatusLabel();
        });
    });
</script>
@endpush 