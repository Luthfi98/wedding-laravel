@extends('layouts.cms')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">{{ $title }}</h4>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('log-activity.index') }}"><i class="bi bi-clock-history"></i> Log Activity</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150" style="background-color: var(--bg-color)">User</th>
                                <td style="background-color: var(--bg-color)">{{ $log->user ? $log->user->name : 'Guest' }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: var(--bg-color)">IP Address</th>
                                <td style="background-color: var(--bg-color)">{{ $log->ip_address }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: var(--bg-color)">Method</th>
                                <td style="background-color: var(--bg-color)">
                                    <span class="badge bg-{{ $log->method === 'GET' ? 'info' : ($log->method === 'POST' ? 'success' : ($log->method === 'PUT' ? 'warning' : ($log->method === 'DELETE' ? 'danger' : 'secondary'))) }}">
                                        {{ $log->method }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th style="background-color: var(--bg-color)">Table</th>
                                <td style="background-color: var(--bg-color)">{{ $log->table }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: var(--bg-color)">Path</th>
                                <td style="background-color: var(--bg-color)">{{ $log->path }}</td>
                            </tr>
                            <tr>
                                <th style="background-color: var(--bg-color)">Created At</th>
                                <td style="background-color: var(--bg-color)">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Data Changes</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="background-color: var(--bg-color)">Field</th>
                                        <th style="background-color: var(--bg-color)">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($log->data as $key => $value)
                                        <tr>
                                            <td style="background-color: var(--bg-color)">{{ $key }}</td>
                                            <td style="background-color: var(--bg-color)">
                                                @if(is_array($value))
                                                    <pre class="mb-0">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection