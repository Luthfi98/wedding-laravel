@extends(Auth::user() ? 'layouts.cms' : 'layouts.guest')
@if (Auth::user())
    
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <img src="https://images.unsplash.com/photo-1594322436404-5a0526db4d13?w=500&auto=format&fit=crop&q=60" 
                        alt="Page Not Found" 
                        class="img-fluid mb-4" 
                        style="max-height: 200px; object-fit: cover;">
                    <h1 class="text-danger mb-3">Halaman Tidak Ditemukan</h1>
                    <p class="lead text-muted">Maaf, halaman yang Anda cari tidak dapat ditemukan.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-house-door me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@else
    @section('content')
    <div class="container">
    <h1>404</h1>
    <h2>Halaman Tidak Ditemukan</h2>
    <p>Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
    <a href="/">Kembali ke Beranda</a>
  </div>
    @endsection
@endif


