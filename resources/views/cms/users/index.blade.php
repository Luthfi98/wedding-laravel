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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <select class="form-select select2 form-select select2-sm" id="statusFilter" style="width: 200px;">
                        <option value="">{{ __('All') }}</option>
                        <option value="active">{{  __('Active') }}</option>
                        <option value="inactive">{{  __('Inactive') }}</option>
                    </select>
                </div>
                <div>
                    @can('create user')
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mb-2">
                            <i class="bi bi-plus"></i> {{ __('Add '. $title) }}
                        </a>
                    @endcan
                </div>
            </div>
            <table class="table table-striped" width="100%" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Name')}}</th>
                        {{-- <th scope="col">{{ __('Username')}}</th> --}}
                        <th scope="col">{{ __('Email')}}</th>
                        <th scope="col">{{ __('Role')}}</th>
                        <th scope="col">{{ __('Status')}}</th>
                        <th scope="col" width="10%">{{ __('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": {
                    "url": "{{ route('users.data') }}",
                    "type": "GET",
                    "data": function(d) {
                        d.status = $('#statusFilter').val();
                    }
                },
                "columns": [
                    { "data": "DT_RowIndex", searchable: false},
                    { "data": "name" },
                    // { "data": "username" },
                    { "data": "email" },
                    { "data": "role" },
                    { "data": "status" },
                    { "data": "action", orderable: false, searchable: false }
                ],
                "columnDefs": [
                    {
                        "targets": -1,
                        "className": "text-center"
                    }
                ]
            });

            // Reload table when filter changes
            $('#statusFilter').change(function() {
                table.ajax.reload();
            });
        });

    </script>
</div>
@endsection