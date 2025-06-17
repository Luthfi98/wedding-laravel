<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title??'' }} - Undangan Pernikahan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('assets/'.$template->id.'/style.css?v1') }}">
    <style>
        
    </style>
</head>
<body>
    <!-- Opening Screen -->
    <div class="opening-screen" style="
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $other['background']? asset($other['background']):'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3' }}');
    ">
        <div class="opening-content">
            <h1 class="opening-title">Undangan Pernikahan</h1>
            <p class="opening-subtitle">Kepada Yth.<br>Bapak/Ibu/Saudara/i
            <br>
            {{ $to??"Fulan" }}
            </p>
            <button class="open-button">Buka Undangan</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" style="display: none;">
        <!-- Hero Section -->
        <section class="hero-section" style="
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $other['background']? asset($other['background']):'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3' }}');
    ">
            <div class="hero-content">
                <h1 class="couple-names">{{ $groom['nickname'] }} & {{ $bride['nickname'] }}</h1>
                <p class="wedding-date">{{ $closest['dateFormated'] }}</p>
                <p class="lead">Kami mengundang Anda untuk merayakan hari pernikahan kami</p>
            </div>
        </section>

        <!-- Couple Section -->
        <section class="section bg-light">
            <div class="container">
                <h2 class="section-title">Mempelai</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="couple-card" data-aos="fade-right">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3" alt="Groom" class="couple-image">
                            <h3 class="couple-name">{{ $groom['name'] }}</h3>
                            <p class="couple-parents">Putra dari Bapak {{ $groom['father'] }} & Ibu {{ $groom['mother'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="couple-card" data-aos="fade-left">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3" alt="Bride" class="couple-image">
                            <h3 class="couple-name">{{ $bride['name'] }}</h3>
                            <p class="couple-parents">Putri dari Bapak {{ $bride['father'] }} & Ibu {{ $bride['mother'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Event Section -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">Detail Acara</h2>
                <div class="row">
                    @foreach($locations as $location)
                    	<div class="col-md-6">
                            <div class="event-card" data-aos="fade-up">
                                <h3 class="event-title">{{ $location['name'] }}</h3>
                                <div class="event-info">
                                    <i class="fas fa-calendar"></i> {{ date('d M Y', strtotime($location['date'])) }}
                                </div>
                                <div class="event-info">
                                    <i class="fas fa-clock"></i> {{ date('H:i', strtotime($location['date'])) }}
                                </div>
                                <div class="event-info">
                                    <i class="fas fa-map-marker-alt"></i> {{ $location['location'] }}
                                </div>
                                <div class="event-info">
                                    <i class="fas fa-location-arrow"></i> {{ $location['address'] }}
                                </div>
                                <a href="{{ $location['maps'] }}" target="_blank" class="btn btn-outline-primary mt-3">
                                    <i class="fas fa-map-marked-alt"></i> Buka di Maps
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="section bg-light">
            <div class="container">
                <h2 class="section-title">Galeri Foto</h2>
                <div class="row">
                    @foreach($gallery as $gal)
                    <div class="col-md-4 col-sm-6">
                        <div class="gallery-item" data-aos="zoom-in">
                            <img src="{{ asset($gal) }}" alt="Gallery Image">
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </section>

        <!-- RSVP Section -->
        <section class="section">
            <div class="container">
                <h2 class="section-title">RSVP</h2>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="rsvp-form" data-aos="fade-up">
                            <form>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Nama Lengkap">
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <input type="tel" class="form-control" placeholder="Nomor Telepon">
                                </div>
                                <div class="mb-3">
                                    <select class="form-select">
                                        <option selected>Jumlah Tamu</option>
                                        <option>1 Orang</option>
                                        <option>2 Orang</option>
                                        <option>3 Orang</option>
                                        <option>4 Orang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" rows="3" placeholder="Ucapan & Doa"></textarea>
                                </div>
                                <button type="submit" class="submit-btn w-100">Kirim RSVP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-logo">webNest</div>
                <p>Membuat momen spesial Anda menjadi lebih berkesan</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
                <p class="mt-3">© 2024 webNest. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
   <script src="{{ asset('assets/'.$template->id.'/script.js?v1') }}"></script>
    
    <script>
       
    </script>
</body>
</html>