@extends('layouts.cms')
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <img src="https://images.unsplash.com/photo-1594322436404-5a0526db4d13?w=500&auto=format&fit=crop&q=60" 
                         alt="Access Denied" 
                         class="img-fluid mb-4" 
                         style="max-height: 200px; object-fit: cover;">
                    <h1 class="text-danger mb-3">Akses Ditolak</h1>
                    <p class="lead text-muted">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                    <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection