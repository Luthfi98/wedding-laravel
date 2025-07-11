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
            <div class="d-flex justify-content-end align-items-center mb-3">
                <div>
                    @can('create template')
                    <a href="{{ route('templates.create') }}" class="btn btn-primary btn-sm mb-2">
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
                        <th scope="col">{{ __('Description')}}</th>
                        <th scope="col">{{ __('Created By')}}</th>
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
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('templates.data') }}",
                    type: "GET"
                },
                columns: [
                    { data: "DT_RowIndex", searchable: false},
                    { data: "name" },
                    { data: "description" },
                    { data: "created_by.name", name: 'createdBy.name', defaultContent : ''},
                    { data: "status" },
                    { data: "action", orderable: false, searchable: false }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        className: "text-center"
                    }
                ]
            });

            
        });

    </script>
</div>
@endsection