<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title??'' }} - Wedding Nest</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/templates/'.$template->id.'/style-min.css?v1') }}">
</head>
<body>
    <!-- Cover Page -->
    <div class="cover-page" id="coverPage" style="
    background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $other['background']? asset($other['background']):'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3' }}');
    ">
        <div class="cover-content">
            <div>
                <p class="cover-subtitle">The Wedding Of</p>
                <h1 class="cover-title">{{ $groom['nickname'] }} & {{ $bride['nickname'] }}</h1>
            </div>
            <div>
                <p class="invited-to">Kepada Bpk/Ibu/Saudara/i</p>
                <p class="invited-to-name">{{ $to }}</p>
                <button class="open-btn" onclick="openInvitation()">
                    <i class="fas fa-envelope-open"></i> Buka Undangan
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Music Player -->
        <div class="music-player">
            <button class="music-btn" id="musicBtn" onclick="toggleMusic()">
                <i class="fas fa-music" id="musicIcon"></i>
            </button>
            <audio id="bgMusic" loop>
                <source src="{{ asset($other['file_song']) }}" type="audio/mpeg">
            </audio>
        </div>

        <button class="scroll-btn" id="scrollBtn" onclick="toggleAutoScroll()">
            <i class="fas fa-arrow-down"></i>
        </button>

        <!-- Hero Section -->
        <section class="hero section" id="hero">
            <div class="hero-content">
                <h1 class="hero-title">{{$groom['nickname']}} & {{ $bride['nickname'] }}</h1>
                <p class="hero-subtitle">Akan melangsungkan pernikahan</p>
                <p class="hero-quote">"Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan-pasangan dari jenismu sendiri"</p>
                <div class="quran-verse">
                    <p>QS. Ar-Rum: 21</p>
                </div>
            </div>
        </section>

        <!-- Couple Section -->
        <section class="couple-section section" id="couple">
            <!-- Floating Particles -->
            <div class="floating-particles">
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
            </div>
            
            <h2 class="couple-title">Our Wedding</h2>
            <p class="section-subtitle">Dengan penuh rasa syukur, kami akan melangsungkan pernikahan.</p>
            <div class="couple-info">
                <div class="couple-number couple-number-groom">The Groom</div>
                <div class="couple-card">
                    <div class="couple-img-wrapper" style="position:relative;">
                        <img class="couple-img" src="https://undangkami.com/wp-content/uploads/2025/05/04-foto-the-groom--1024x682.jpeg" alt="Groom" />
                        <div class="couple-overlay">
                            <h3 class="couple-name">{{ $groom['name'] }}</h3>
                            <p class="couple-parents">Putra dari<br>Bapak {{ $groom['father'] }} & Ibu {{ $groom['mother'] }}</p>
                            <a class="instagram-link" href="https://instagram.com/ahmad" target="_blank" title="Instagram Ahmad"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="vertical-pattern">
                    <div class="vertical-line"></div>
                    <div class="vertical-deco deco1"></div>
                    <div class="vertical-deco deco2"></div>
                </div>
                <div class="couple-card">
                    <div class="couple-img-wrapper" style="position:relative;">
                        <img class="couple-img" src="https://undangkami.com/wp-content/uploads/2025/05/03-foto-the-bride--681x1024.jpeg" alt="Bride" />
                        <div class="couple-overlay">
                            <h3 class="couple-name">{{ $bride['name'] }}</h3>
                            <p class="couple-parents">Putri dari<br>Bapak {{ $bride['father'] }} & Ibu {{ $bride['mother'] }}</p>
                            <a class="instagram-link" href="https://instagram.com/siti" target="_blank" title="Instagram Siti"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="couple-number couple-number-bride">The Bride</div>
            </div>
        </section>
	
        
        <!-- Love Story Section -->
        @if ($story)
        <section class="love-story section" id="story">
            <div class="story-shapes">
                <div class="story-heart h1"></div>
                <div class="story-heart h2"></div>
                <div class="story-heart h3"></div>
                <div class="story-petal p1"></div>
                <div class="story-petal p2"></div>
                <div class="story-petal p3"></div>
                <div class="story-petal p4"></div>
            </div>
            <h2 class="section-title">Perjalanan Cinta Kami</h2>
            <p class="section-subtitle">Momen-momen yang membawa kami hingga ke jenjang pernikahan.</p>
            <div class="timeline">
                @foreach($story as $item)
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-date">{{ date('m Y', strtotime($item['date'])) }}</div>
                        <h3 class="timeline-title">{{  $item['title']}}</h3>
                        <p class="timeline-desc">
                        	{{  $item['description']}}
                        </p>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
        

        <!-- Venue Section -->
        <section class="venue-section section" id="venue">
            <h2 class="section-title">Lokasi Acara</h2>
            <p class="section-subtitle">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
            
            <div class="venue-container">
                <div class="venue-card">
                    <div class="venue-image" style="background-image: url('https://undangkami.com/wp-content/uploads/elementor/thumbs/05-foto-akad--r60mosmkgcc372mv1mh820de472aeii5di58r6xndk.jpeg');">
                        <span>Akad Nikah</span>
                    </div>
                    <div class="venue-content">
                        <h3 class="venue-type">Akad Nikah</h3>
                        <div class="venue-details">
                            <div class="venue-detail">
                                <i class="fas fa-calendar"></i>
                                <span>Sabtu, 7 Mei 2027</span>
                            </div>
                            <div class="venue-detail">
                                <i class="fas fa-clock"></i>
                                <span>08:00 WIB</span>
                            </div>
                            <div class="venue-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Masjid Al-Hikmah</span>
                            </div>
                            <div class="venue-detail">
                                <i class="fas fa-location-arrow"></i>
                                <span>Jl. Sudirman No. 123, Jakarta</span>
                            </div>
                        </div>
                        <button class="venue-btn" onclick="openMaps('Masjid Al-Hikmah, Jakarta')">
                            <i class="fas fa-directions"></i> Petunjuk Arah
                        </button>
                    </div>
                </div>
                <div class="venue-card">
                    <div class="venue-image" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');">
                        <span>Resepsi</span>
                    </div>
                    <div class="venue-content">
                        <h3 class="venue-type">Resepsi</h3>
                        <div class="venue-details">
                            <div class="venue-detail">
                                <i class="fas fa-calendar"></i>
                                <span>Sabtu, 7 Mei 2027</span>
                            </div>
                            <div class="venue-detail">
                                <i class="fas fa-clock"></i>
                                <span>11:00 - 14:00 WIB</span>
                            </div>
                            <div class="venue-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Hotel Grand Palace</span>
                            </div>
                            <div class="venue-detail">
                                <i class="fas fa-location-arrow"></i>
                                <span>Jl. Thamrin No. 456, Jakarta</span>
                            </div>
                        </div>
                        <button class="venue-btn" onclick="openMaps('Hotel Grand Palace, Jakarta')">
                            <i class="fas fa-directions"></i> Petunjuk Arah
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Countdown Section -->
        <section class="countdown-section section" id="countdown">
            <!-- Decorative Shapes -->
            <div class="countdown-shapes">
                <div class="countdown-flower f1"></div>
                <div class="countdown-flower f2"></div>
                <div class="countdown-flower f3"></div>
                <div class="countdown-flower f4"></div>
                <div class="countdown-flower f5"></div>
                <div class="countdown-flower f6"></div>
                <div class="countdown-flower f7"></div>
                <div class="countdown-flower f8"></div>
                <div class="countdown-love l1"></div>
                <div class="countdown-love l2"></div>
                <div class="countdown-love l3"></div>
                <div class="countdown-love l4"></div>
                <div class="countdown-shape shape1"></div>
                <div class="countdown-shape shape2"></div>
                <div class="countdown-shape shape3"></div>
                <div class="countdown-shape shape4"></div>
            </div>
            <div class="countdown-container">
                <h3 class="countdown-title">Menghitung Hari</h3>
                <div class="countdown-timer">
                    <div class="countdown-item">
                        <span class="countdown-number" id="days">00</span>
                        <span class="countdown-label">Hari</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="hours">00</span>
                        <span class="countdown-label">Jam</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="minutes">00</span>
                        <span class="countdown-label">Menit</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="seconds">00</span>
                        <span class="countdown-label">Detik</span>
                    </div>
                </div>
                <div class="calendar-buttons">
                    <button class="save-calendar-btn" onclick="saveToCalendar('akad')">
                        <i class="fas fa-calendar-plus"></i> Simpan Akad Nikah
                    </button>
                    <button class="save-calendar-btn" onclick="saveToCalendar('resepsi')">
                        <i class="fas fa-calendar-plus"></i> Simpan Resepsi
                    </button>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section class="gallery-section section" id="gallery">
            <h2 class="section-title">Galeri Foto</h2>
            <p class="section-subtitle">Kenangan indah yang tak akan terlupakan.</p>
            <div class="gallery-grid">
                <div class="gallery-item" onclick="openGalleryModal('https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80')">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto 1">
                </div>
                <div class="gallery-item" onclick="openGalleryModal('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80')">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto 2">
                </div>
                <div class="gallery-item" onclick="openGalleryModal('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80')">
                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto 3">
                </div>
                <div class="gallery-item" onclick="openGalleryModal('https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80')">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto 4">
                </div>
                <div class="gallery-item" onclick="openGalleryModal('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80')">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto 5">
                </div>
                <div class="gallery-item" onclick="openGalleryModal('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80')">
                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto 6">
                </div>
            </div>
        </section>

        <!-- Gallery Modal -->
        <div class="gallery-modal" id="galleryModal">
            <div class="modal-content">
                <button class="modal-close" onclick="closeGalleryModal()">
                    <i class="fas fa-times"></i>
                </button>
                <img class="modal-image" id="modalImage" src="" alt="Gallery Image">
            </div>
        </div>

        <!-- Gift Section -->
        <section class="gift-section section" id="gift">
            <h2 class="section-title">Amplop Digital</h2>
            <p class="section-subtitle">Kehadiran dan doa restu adalah hadiah terbaik. Namun jika ingin memberikan tanda kasih, kami sediakan fitur di bawah ini.</p>
            <div class="gift-container">
                <div class="gift-grid">
                    <div class="gift-card">
                        <div class="gift-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <h3 class="gift-title">Bank Central Asia (BCA)</h3>
                        <p class="gift-info">Atas nama: Ahmad Fadillah</p>
                        <div class="gift-number" id="bcaNumber">1234567890</div>
                        <button class="copy-btn" onclick="copyToClipboard('bcaNumber', event)">
                            <i class="fas fa-copy"></i> Salin Nomor
                        </button>
                    </div>
                    <div class="gift-card">
                        <div class="gift-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <h3 class="gift-title">Bank Mandiri</h3>
                        <p class="gift-info">Atas nama: Siti Nurhaliza</p>
                        <div class="gift-number" id="mandiriNumber">0987654321</div>
                        <button class="copy-btn" onclick="copyToClipboard('mandiriNumber', event)">
                            <i class="fas fa-copy"></i> Salin Nomor
                        </button>
                    </div>
                    <div class="gift-card">
                        <div class="gift-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <h3 class="gift-title">Alamat Hadiah</h3>
                        <p class="gift-info">Jl. Sudirman No. 123, Jakarta Selatan</p>
                        <p class="gift-info">Atas nama: Ahmad Fadillah</p>
                        <button class="copy-btn" onclick="copyToClipboard('address', event)">
                            <i class="fas fa-map-marker-alt"></i> Salin Alamat
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Guest Book Section -->
        <section class="guest-book section" id="guestbook">
            <h2 class="section-title">RSPV</h2>
            <p class="section-subtitle">Tinggalkan jejak dan doa restu Anda di sini.</p>
            <div class="guest-form">
                <div class="form-group">
                    <label for="guestName">Nama</label>
                    <input type="text" id="guestName" placeholder="Masukkan nama Anda">
                </div>
                <div class="form-group">
                    <label for="guestMessage">Ucapan & Doa</label>
                    <textarea id="guestMessage" placeholder="Tulis ucapan dan doa untuk kedua mempelai"></textarea>
                </div>
                <div class="form-group">
                    <label for="attendanceSelect">Konfirmasi Kehadiran</label>
                    <select id="attendanceSelect">
                        <option value="">Pilih</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Tidak Hadir">Tidak Hadir</option>
                        <option value="Masih Ragu">Masih Ragu</option>
                    </select>
                </div>
                <button class="submit-btn" onclick="submitGuestBook()">
                    <i class="fas fa-paper-plane"></i> Kirim Ucapan
                </button>
            </div>
            
            <!-- Guest Messages Display -->
            <div class="guest-messages">
                <div class="message-count" id="messageCount">Belum ada ucapan</div>
                <div class="messages-container" id="messagesContainer">
                    <div class="no-messages">Belum ada ucapan dari tamu. Jadilah yang pertama mengirim ucapan!</div>
                </div>
            </div>
        </section>

        <!-- Thank You Section -->
        <section class="thank-you-section section" id="thankyou">
            <div class="thank-you-content">
                <h2 class="thank-you-title">Terima Kasih</h2>
                <p class="thank-you-message">
                    Atas kehadiran dan doa restu dari Bapak/Ibu/Saudara/i,<br>
                    kami mengucapkan terima kasih yang sebesar-besarnya.<br>
                    Semoga doa dan restu yang diberikan menjadi keberkahan<br>
                    dalam membina rumah tangga kami.
                </p>
                <p class="couple-signature">
                    Ahmad & Siti
                </p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-logo">WeddingNest</div>
                <p class="footer-tagline">Membuat momen pernikahan Anda tak terlupakan</p>
                <div class="footer-links">
                    <a href="https://instagram.com/ahmad" class="footer-link" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://weddingnest.com" class="footer-link" target="_blank" title="Website"><i class="fas fa-globe"></i></a>
                </div>
                <div class="footer-copyright">
                    © 2024 WeddingNest. All rights reserved.
                </div>
            </div>
        </footer>

        <!-- Fixed Menu -->
        <div class="fixed-menu">
            <div class="menu-items">
                <div title="Beranda" class="menu-item active" onclick="scrollToSection('hero')">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span>
                </div>
                <div title="Mempelai" class="menu-item" onclick="scrollToSection('couple')">
                    <i class="fas fa-heart"></i>
                    <span>Mempelai</span>
                </div>
                <div title="Lokasi" class="menu-item" onclick="scrollToSection('venue')">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Lokasi</span>
                </div>
                <div title="Galeri" class="menu-item" onclick="scrollToSection('gallery')">
                    <i class="fas fa-images"></i>
                    <span>Galeri</span>
                </div>
                <div title="Ucapan" class="menu-item" onclick="scrollToSection('guestbook')">
                    <i class="fas fa-comments"></i>
                    <span>Ucapan</span>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/templates/'.$template->id.'/script-min.js?v1') }}"></script>
</body>
</html>