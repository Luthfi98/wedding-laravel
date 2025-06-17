<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title??'' }} - Undangan Digital</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500&family=Great+Vibes&display=swap" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
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
            <p class="opening-subtitle">Kepada Yth.<br>Bapak/Ibu/Saudara/i <br> {{ $to??'' }}</p>
            <button class="open-button">
                Buka Undangan <i class="fas fa-chevron-right ms-2"></i>
                <div class="seal">
                    <i class="fas fa-heart"></i>
                </div>
            </button>
        </div>
    </div>

    <!-- Music Player -->
    <div class="music-player">
        <i class="fas fa-music"></i>
        <audio id="bgMusic" loop>
            <source src="{{ asset($other['file_song']) }}" type="audio/mp3">
        </audio>
    </div>

    <!-- Share Button -->
    <div class="share-button">
        <i class="fas fa-share-alt"></i>
    </div>

    <!-- Back to Top Button -->
    <div class="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </div>

    <!-- Main Content -->
    <div class="main-content" style="display: none;">
        <!-- Hero Section -->
        <section id="home" class="hero-section">
            <div class="container">
                <h1 class="couple-names">{{ $groom['nickname'] }} & {{$bride['nickname']}}</h1>
                <p class="date-venue">{{ $closest['dateFormated'] }}</p>
                <p class="lead">Kami mengundang Anda untuk merayakan hari pernikahan kami</p>
            </div>
        </section>

        <!-- Couple Section -->
        <section id="couple" class="section bg-light">
            <div class="container">
                <h2 class="section-title">Mempelai</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="couple-card">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3" alt="Groom">
                            <h3>{{ $groom['name'] }}</h3>
                            <p>Putra dari Bapak {{ $groom['father'] }} & Ibu {{ $groom['mother'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="couple-card">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3" alt="Bride">
                            <h3>Siti</h3>
                            <p>Putri dari Bapak {{ $bride['father'] }} & Ibu {{ $bride['mother'] }}</p>
                        </div>
                    </div>
                </div>

                @if ($story)
                    <!-- Love Story Timeline -->
                    <div class="love-story">
                        <h3 class="section-title">Perjalanan Cinta Kami</h3>
                        <div class="timeline">
                            @foreach ($story as $item)
                                <div class="timeline-item">
                                    <div class="timeline-content">
                                        <div class="timeline-date">{{ date('m Y', strtotime($item['date'])) }}</div>
                                        <h4 class="timeline-title">{{  $item['title']}}</h4>
                                        <p class="timeline-description">
                                            {{ $item['description']}} 
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                @endif

            </div>
        </section>

        <!-- Event Section with Location Buttons -->
        <section id="event" class="section">
            <div class="container">
                <h2 class="section-title">Detail Acara</h2>
                <div class="row d-flex justify-content-center">
                    @foreach($client['data']['locations'] as $location)
                    <div class="col-md-6">
                        <div class="event-details batik-pattern">
                            <h3>{{ $location['name'] }}</h3>
                            <p><i class="fas fa-calendar"></i> {{ date('d M Y', strtotime($location['date'])) }}</p>
                            <p><i class="fas fa-clock"></i> {{ date('H:i', strtotime($location['date'])) }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $location['location'] }}</p>
                            <p>{{ $location['address'] }}</p>
                            <a href="{{ $location['maps'] }}" target="_blank" class="btn btn-outline-primary mt-3">
                                <i class="fas fa-map-marked-alt"></i> Buka di Maps
                            </a>
                        </div>
                    </div>
                    @endforeach
                   
                </div>
            </div>
        </section>

        <!-- Countdown Section -->
        <section class="section bg-light">
            <div class="container">
                <h2 class="section-title">Menuju Hari Bahagia</h2>
                <input type="hidden" id="wedding-date" name="wedding-date" value="{{ date('Y-m-d H:i', strtotime($closest['date'])) }}"/>
                <div class="row justify-content-center">
                    <div class="col-md-2 col-6">
                        <div class="countdown-item">
                            <div class="countdown-number" id="days">00</div>
                            <div>Hari</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="countdown-item">
                            <div class="countdown-number" id="hours">00</div>
                            <div>Jam</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="countdown-item">
                            <div class="countdown-number" id="minutes">00</div>
                            <div>Menit</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="countdown-item">
                            <div class="countdown-number" id="seconds">00</div>
                            <div>Detik</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="section">
            <div class="container">
                <h2 class="section-title">Galeri Foto</h2>
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach($client['data']['gallery'] as $gallery)
                        <div class="swiper-slide">
                            <img src="{{ asset($gallery) }}" alt="Gallery Image">
                        </div>
                        @endforeach
                      
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <!-- Messages Section -->
        <section class="messages-section">
            <div class="container">
                <h2 class="section-title">Ucapan & Doa</h2>
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <!-- Messages Container -->
                        <div class="messages-container active" data-page="1">
                            <!-- Message Cards for Page 1 -->
                            <div class="message-card">
                                <div class="message-header">
                                    <div class="message-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="message-info">
                                        <h5 class="message-name">Ahmad Rizki</h5>
                                        <p class="message-date">1 Januari 2024, 10:30</p>
                                    </div>
                                </div>
                                <p class="message-content">
                                    Selamat menempuh hidup baru, semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Aamiin.
                                </p>
                                <div class="message-actions">
                                    <button class="message-action-btn">
                                        <i class="fas fa-heart"></i> 15
                                    </button>
                                    <button class="message-action-btn">
                                        <i class="fas fa-reply"></i> Balas
                                    </button>
                                </div>
                            </div>

                            <div class="message-card">
                                <div class="message-header">
                                    <div class="message-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="message-info">
                                        <h5 class="message-name">Siti Nurul</h5>
                                        <p class="message-date">1 Januari 2024, 09:15</p>
                                    </div>
                                </div>
                                <p class="message-content">
                                    MasyaAllah, selamat ya! Semoga menjadi keluarga yang diberkahi Allah SWT. Aamiin.
                                </p>
                                <div class="message-actions">
                                    <button class="message-action-btn">
                                        <i class="fas fa-heart"></i> 12
                                    </button>
                                    <button class="message-action-btn">
                                        <i class="fas fa-reply"></i> Balas
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="messages-container" data-page="2">
                            <!-- Message Cards for Page 2 -->
                            <div class="message-card">
                                <div class="message-header">
                                    <div class="message-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="message-info">
                                        <h5 class="message-name">Budi Santoso</h5>
                                        <p class="message-date">31 Desember 2023, 20:45</p>
                                    </div>
                                </div>
                                <p class="message-content">
                                    Selamat menempuh hidup baru, semoga menjadi keluarga yang harmonis dan penuh berkah.
                                </p>
                                <div class="message-actions">
                                    <button class="message-action-btn">
                                        <i class="fas fa-heart"></i> 8
                                    </button>
                                    <button class="message-action-btn">
                                        <i class="fas fa-reply"></i> Balas
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container">
                            <button class="pagination-btn prev" disabled>
                                <i class="fas fa-chevron-left"></i> Sebelumnya
                            </button>
                            <button class="pagination-btn active">1</button>
                            <button class="pagination-btn">2</button>
                            <button class="pagination-btn next">
                                Selanjutnya <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- RSVP Section -->
        <section id="rsvp" class="section bg-light">
            <div class="container">
                <h2 class="section-title">RSVP</h2>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="rsvp-form">
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
                                <button type="submit" class="btn btn-primary w-100">Kirim RSVP</button>
                            </form>
                        </div>

                        <!-- Bank Accounts -->
                        <div class="bank-accounts">
                            <h3 class="section-title">Amplop Digital</h3>
                            <p class="text-center mb-4">Untuk yang ingin memberikan hadiah secara online, dapat transfer ke rekening berikut:</p>
                            @foreach ($bank as $item)
                                <div class="bank-account-item">
                                    
                                    <div class="bank-logo">
                                        <img src="{{ $item['bank_logo'] }}" alt="{{ $item['bank_name'] }}">
                                    </div>
                                    <div class="bank-info">
                                        <div class="bank-name">{{ $item['bank_fullname'] }}</div>
                                        <div class="account-number">{{ $item['account_number'] }}</div>
                                        <div class="account-name">{{ $item['account_holder'] }}</div>
                                    </div>
                                    <button class="copy-btn" data-account="{{ $item['account_number'] }}">
                                        <i class="fas fa-copy"></i> Salin
                                    </button>
                                </div>
                                
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Dock Menu -->
    <div class="dock-menu" style="display: none;">
        <a href="#home" class="active"><i class="fas fa-home"></i><span>Beranda</span></a>
        <a href="#couple"><i class="fas fa-heart"></i><span>Mempelai</span></a>
        <a href="#event"><i class="fas fa-calendar"></i><span>Acara</span></a>
        <a href="#gallery"><i class="fas fa-images"></i><span>Galeri</span></a>
        <a href="#rsvp"><i class="fas fa-envelope"></i><span>RSVP</span></a>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">webNest</div>
                <p class="footer-text">Membuat momen spesial Anda menjadi lebih berkesan</p>
                <div class="footer-social">
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                </div>
                <p class="footer-copyright">© 2024 webNest. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/'.$template->id.'/script.js?v1') }}"></script>
</body>
</html>