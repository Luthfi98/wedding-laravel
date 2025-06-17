@extends('layouts.cms')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Data {{ $title }}</h4>
        <div class="d-flex gap-2 mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select class="form-select select2" id="filter_menu">
                        <option value="">All Menus</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select select2" id="filter_guard">
                        <option value="">All Guards</option>
                        @foreach($guards as $guard)
                            <option value="{{ $guard }}">{{ $guard }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Add {{ $title }}
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" id="permissions-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Menu</th>
                            <th>Guard</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#permissions-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('permissions.data') }}",
                data: function(d) {
                    d.menu = $('#filter_menu').val();
                    d.guard = $('#filter_guard').val();
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'menu.name', name: 'menu.name'},
                {data: 'guard_name', name: 'guard_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
            ],
            order: [[1, 'asc', 0,'asc']]
        });

        $('#filter_menu, #filter_guard').on('change', function() {
            table.ajax.reload();
        });
    });
</script>
@endpush