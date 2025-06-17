@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('menus.index') }}"><i class="bi bi-list"></i> Menu</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">{{ __('Parent Menu') }}</label>
                            <select class="form-select select2 @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                <option value="">{{ __('Select Parent Menu') }}</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id??'') == $parent->id ? 'selected' : '' }}>
                                        {{ ucfirst($parent->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $menu->name??'') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="module_name" class="form-label">{{ __('Module Name') }}</label>
                            <input type="text" class="form-control @error('module_name') is-invalid @enderror" id="module_name" name="module_name" value="{{ old('module_name', $menu->module_name??'') }}" required>
                            @error('module_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="icon" class="form-label">{{ __('Icon') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $menu->icon??'') }}" placeholder="e.g. bi-house-door">
                                <span class="input-group-text" id="iconPreview"><i class="bi bi-house-door"></i></span>
                            </div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="route" class="form-label">{{ __('Route') }}</label>
                            <input type="text" class="form-control @error('route') is-invalid @enderror" id="route" name="route" value="{{ old('route', $menu->route??'') }}" placeholder="e.g. dashboard">
                            @error('route')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="order" class="form-label">{{ __('Order') }}</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $menu->order??'', 0) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="list_permissions" class="form-label">{{ __('Permissions') }}</label>
                                <select class="form-select select2 @error('list_permissions') is-invalid @enderror" id="list_permissions" name="list_permissions[]" multiple>
                                    @php
                                        $permissions = ['create', 'view', 'update', 'delete'];
                                    @endphp
                                    @foreach($access as $permission)
                                        <option value="{{ $permission }}" {{ (collect(old('list_permissions', $menu->list_permissions??[]))->filter(function($item) use ($permission) {
                                            return stripos($item, $permission) !== false;
                                        })->isNotEmpty()) ? 'selected' : '' }}>
                                            {{ $permission }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('list_permissions')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="active" {{ old('status', $menu->status??'', 'active') === 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status" id="statusLabel">{{ __('Active') }}</label>
                            </div>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('menus.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
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
        // Status toggle handler
        $('#status').on('change', function() {
            $('#statusLabel').text($(this).is(':checked') ? '{{ __("Active") }}' : '{{ __("Inactive") }}');
            $(this).val($(this).is(':checked') ? 'active' : 'inactive');
        }).trigger('change');

        // Icon preview handler
        $('#icon').on('input', function() {
            const iconClass = $(this).val() || 'bi-house-door';
            $('#iconPreview').html(`<i class="bi ${iconClass}"></i>`);
        }).trigger('input');
    });
</script>
@endpush
