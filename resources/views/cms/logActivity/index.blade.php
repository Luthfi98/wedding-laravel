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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_from">From</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_to">To</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="method">Method</label>
                                    <select class="form-control select2" id="method" name="method">
                                        <option value="">Select Method</option>
                                        <option value="GET">GET</option>
                                        <option value="POST">POST</option>
                                        <option value="PUT">PUT</option>
                                        <option value="DELETE">DELETE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <br>
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-primary btn-block" id="btn-filter-date">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped" id="logActivityTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>IP Address</th>
                                <th>Method</th>
                                <th>Table</th>
                                <th>Path</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        let table = $('#logActivityTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('log-activity.data') }}",
                data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.method = $('#method').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user_name', name: 'user_name'},
                {data: 'ip_address', name: 'ip_address'},
                {data: 'method', name: 'method'},
                {data: 'table', name: 'table'},
                {data: 'path', name: 'path'},
                {data: 'created_at_formatted', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[6, 'desc']]
        });

        // Handle filter button click
        $('#btn-filter-date').click(function() {
            table.ajax.reload();
        });

        // Initialize select2
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endpush 