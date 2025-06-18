<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
     <link rel="icon" type="image/x-icon" href="{{ asset($favicon) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Undangan Digital Modern - Buat undangan digital yang elegan dan mudah dibagikan. Tersedia berbagai template menarik dengan harga terjangkau.">
    <meta name="keywords" content="undangan digital, undangan online, template undangan, undangan pernikahan digital, undangan ulang tahun digital">
    <title>Undangan Digital KUY - Solusi Modern untuk Acara Anda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <img src="{{ asset($logo) }}" style="height: 50px; vertical-align: middle;"/>
                <span style="vertical-align: middle; display: inline-block;">{{ $name }}</span>
                {{-- <img src="{{ asset($logo) }}" 
     style="height: 50px; vertical-align: middle; 
            clip-path: path('M24.5,4.5c-5.2,-7.3 -17.2,-3.8 -17.2,5.2c0,9.6 17.2,19.8 17.2,19.8s17.2,-10.2 17.2,-19.8c0,-9 -12,-12.5 -17.2,-5.2z');
            -webkit-clip-path: path('M24.5,4.5c-5.2,-7.3 -17.2,-3.8 -17.2,5.2c0,9.6 17.2,19.8 17.2,19.8s17.2,-10.2 17.2,-19.8c0,-9 -12,-12.5 -17.2,-5.2z');"/> --}}

            </div>
            <div class="desktop-nav">
                <a href="#features">Fitur</a>
                <a href="#templates">Template</a>
                <a href="#pricing">Harga</a>
                <a href="#contact">Kontak</a>
            </div>
            <div class="hamburger">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Buat Undangan Digital yang Memukau</h1>
            <p>Tim profesional kami siap membantu Anda membuat undangan digital yang sempurna untuk acara spesial Anda</p>
            <a href="#templates" class="cta-button">Lihat Template</a>
        </div>
    </section>

    <section id="features" class="features">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-users feature-icon"></i>
                    <h3>Tim Profesional</h3>
                    <p>Tim kami akan membantu menginput dan mengatur semua data undangan Anda</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-paint-brush feature-icon"></i>
                    <h3>Template Menarik</h3>
                    <p>Berbagai pilihan desain modern yang bisa Anda pilih</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-share-alt feature-icon"></i>
                    <h3>Mudah Dibagikan</h3>
                    <p>Bagikan melalui WhatsApp, email, atau media sosial</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-headset feature-icon"></i>
                    <h3>Dukungan Penuh</h3>
                    <p>Tim kami siap membantu Anda 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <section id="templates" class="templates">
        <div class="container">
            <h2 class="section-title">Template Undangan</h2>
            <div class="template-grid">
                <div class="template-card">
                    <img src="https://via.placeholder.com/300x200" alt="Template Undangan Pernikahan" class="template-image">
                    <div class="template-info">
                        <h3>Elegant Wedding</h3>
                        <p>Template pernikahan dengan desain elegan dan romantis</p>
                    </div>
                </div>
                <div class="template-card">
                    <img src="https://via.placeholder.com/300x200" alt="Template Undangan Ulang Tahun" class="template-image">
                    <div class="template-info">
                        <h3>Birthday Party</h3>
                        <p>Template ulang tahun yang ceria dan penuh warna</p>
                    </div>
                </div>
                <div class="template-card">
                    <img src="https://via.placeholder.com/300x200" alt="Template Undangan Seminar" class="template-image">
                    <div class="template-info">
                        <h3>Business Event</h3>
                        <p>Template profesional untuk acara bisnis</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing">
        <div class="container">
            <h2 class="section-title">Paket Harga</h2>
            <div class="pricing-grid">
                <div class="price-card">
                    <div class="discount-badge">Diskon 20%</div>
                    <h3>Basic</h3>
                    <div class="price">
                        <span class="original-price">Rp 129.000</span>
                        Rp 99.000
                    </div>
                    <ul>
                        <li>1 Template Pilihan</li>
                        <li>Input Data oleh Tim</li>
                        <li>Masa Aktif 1 Bulan</li>
                        <li>Dukungan Email</li>
                        <li>Revisi 2x</li>
                    </ul>
                    <a href="#" class="cta-button">Pilih Paket</a>
                </div>
                <div class="price-card popular">
                    <div class="discount-badge">Diskon 30%</div>
                    <h3>Premium</h3>
                    <div class="price">
                        <span class="original-price">Rp 299.000</span>
                        Rp 199.000
                    </div>
                    <ul>
                        <li>Semua Template</li>
                        <li>Input Data oleh Tim</li>
                        <li>Masa Aktif 3 Bulan</li>
                        <li>Dukungan 24/7</li>
                        <li>Musik & Animasi</li>
                        <li>Revisi 5x</li>
                    </ul>
                    <a href="#" class="cta-button">Pilih Paket</a>
                </div>
                <div class="price-card">
                    <div class="discount-badge">Diskon 40%</div>
                    <h3>Business</h3>
                    <div class="price">
                        <span class="original-price">Rp 799.000</span>
                        Rp 499.000
                    </div>
                    <ul>
                        <li>Semua Fitur Premium</li>
                        <li>Input Data oleh Tim</li>
                        <li>Masa Aktif 1 Tahun</li>
                        <li>Domain Kustom</li>
                        <li>Analytics</li>
                        <li>Revisi Unlimited</li>
                    </ul>
                    <a href="#" class="cta-button">Pilih Paket</a>
                </div>
            </div>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Undangan Dibuat</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Template</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Kepuasan Pelanggan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Dukungan</div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">Apa Kata Mereka?</h2>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Tim yang sangat profesional dan responsif. Mereka membantu mengatur semua data dengan rapi dan hasilnya sangat memuaskan!"</p>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/50" alt="User Avatar" class="author-avatar">
                        <div class="author-info">
                            <h4>Sarah Wijaya</h4>
                            <p>Pernikahan</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"Prosesnya sangat mudah, tinggal pilih template dan kirim data. Tim mereka yang mengerjakan semuanya dengan hasil yang memuaskan."</p>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/50" alt="User Avatar" class="author-avatar">
                        <div class="author-info">
                            <h4>Budi Santoso</h4>
                            <p>Event Perusahaan</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"Dukungan tim yang luar biasa, mereka membantu dari awal sampai akhir. Sangat merekomendasikan untuk acara spesial Anda!"</p>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/50" alt="User Avatar" class="author-avatar">
                        <div class="author-info">
                            <h4>Diana Putri</h4>
                            <p>Ulang Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">Cara Kerjanya</h2>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Pilih Template</h3>
                    <p>Pilih template yang sesuai dengan acara Anda dari koleksi kami</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Kirim Data</h3>
                    <p>Kirimkan data undangan Anda kepada tim kami</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Review & Bagikan</h3>
                    <p>Review hasil akhir dan bagikan undangan digital Anda</p>
                </div>
            </div>
        </div>
    </section>

    <section class="faq">
        <div class="container">
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <div class="faq-grid">
                <div class="faq-item">
                    <div class="faq-question">
                        Berapa lama proses pembuatan undangan?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Tim kami akan menyelesaikan undangan Anda dalam waktu 1-2 hari kerja setelah data diterima lengkap.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        Bagaimana cara mengirim data undangan?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Anda dapat mengirimkan data melalui WhatsApp, email, atau form yang kami sediakan. Tim kami akan membantu memastikan semua data lengkap.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        Apakah ada batasan revisi?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Setiap paket memiliki jumlah revisi yang berbeda. Basic (2x), Premium (5x), dan Business (Unlimited). Tim kami akan membantu memastikan Anda puas dengan hasilnya.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        Bagaimana jika ada perubahan data setelah undangan dibuat?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Tim kami siap membantu mengubah data kapan saja selama masa aktif paket Anda. Perubahan akan diproses dalam waktu 24 jam.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <h3>Hubungi Kami</h3>
            <div class="social-links">
                <a href="#"><i class="fab fa-whatsapp"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
            <p>&copy; 2024 Undangan Digital. All rights reserved.</p>
        </div>
    </footer>

    <button class="theme-toggle" id="themeToggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="overlay"></div>
    <div class="stars"></div>
    <div class="sun-moon-container">
        <div class="sun-moon">
            <div class="sun"></div>
            <div class="moon"></div>
        </div>
    </div>

    <div class="menu-overlay"></div>
    <div class="mobile-menu">
        <div class="mobile-menu-close"></div>
        <div class="mobile-nav">
            <a href="#features">Fitur</a>
            <a href="#templates">Template</a>
            <a href="#pricing">Harga</a>
            <a href="#contact">Kontak</a>
        </div>
    </div>

    <script src="{{ asset('assets/js/landing.js') }}"></script>
</body>
</html>