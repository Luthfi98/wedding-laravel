@extends('layouts.cms')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit {{ $title }}</h4>
        <div class="d-flex gap-2 mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">{{ $title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="menu_id" class="form-label">Menu <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('menu_id') is-invalid @enderror" id="menu_id" name="menu_id" required>
                                <option value="">Select Menu</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" {{ old('menu_id', $permission->menu_id) == $menu->id ? 'selected' : '' }}>{{ $menu->name }}</option>
                                @endforeach
                            </select>
                            @error('menu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="guard_name" class="form-label">Guard Name <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" required>
                                <option value="">Select Guard</option>
                                @foreach($guards as $guard)
                                    <option value="{{ $guard }}" {{ old('guard_name', $permission->guard_name) == $guard ? 'selected' : '' }}>{{ $guard }}</option>
                                @endforeach
                            </select>
                            @error('guard_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    });
</script>
@endpush 