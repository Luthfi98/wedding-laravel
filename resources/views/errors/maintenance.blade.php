@extends('layouts.cms')
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <img src="https://images.unsplash.com/photo-1581092921461-39b9d08a9b21?w=500&auto=format&fit=crop&q=60" 
                         alt="Under Maintenance" 
                         class="img-fluid mb-4" 
                         style="max-height: 200px; object-fit: cover;">
                    <h1 class="text-warning mb-3">Sedang Dalam Pemeliharaan</h1>
                    <p class="lead text-muted">Mohon maaf, situs sedang dalam pemeliharaan untuk meningkatkan layanan kami.</p>
                    <p class="text-muted">Kami akan kembali segera.</p>
                    <div class="mt-4">
                        <i class="bi bi-tools display-1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 