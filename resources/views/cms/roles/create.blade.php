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
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="guard_name" class="form-label">{{ __('Guard') }}</label>
                    <input type="text" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" value="{{ old('guard_name') }}" required>
                    @error('guard_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}">
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
