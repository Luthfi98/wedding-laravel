// Opening Animation
        document.addEventListener('DOMContentLoaded', function() {
            const openButton = document.querySelector('.open-button');
            const openingScreen = document.querySelector('.opening-screen');
            const mainContent = document.querySelector('.main-content');
            const dockMenu = document.querySelector('.dock-menu');

            openButton.addEventListener('click', function() {
                openingScreen.classList.add('hide');
                setTimeout(function() {
                    mainContent.style.display = 'block';
                    dockMenu.style.display = 'flex';
                }, 800);
            });

            // Initialize Swiper with autoplay
            const swiper = new Swiper('.swiper', {
                effect: 'coverflow',
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: 'auto',
                coverflowEffect: {
                    rotate: 50,
                    stretch: 0,
                    depth: 100,
                    modifier: 1,
                    slideShadows: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                loop: true,
            });

            // Countdown Timer
            function updateCountdown() {
                const weddingDate = new Date(document.getElementById('wedding-date')?.value).getTime();
                const now = new Date().getTime();
                const distance = weddingDate - now;

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('days').innerHTML = days.toString().padStart(2, '0');
                document.getElementById('hours').innerHTML = hours.toString().padStart(2, '0');
                document.getElementById('minutes').innerHTML = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').innerHTML = seconds.toString().padStart(2, '0');
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            // Active Menu Item
            function setActiveMenu() {
                const sections = document.querySelectorAll('section[id]');
                const scrollPosition = window.scrollY;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 100;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');
                    
                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        document.querySelector('.dock-menu a[href="#' + sectionId + '"]').classList.add('active');
                    } else {
                        document.querySelector('.dock-menu a[href="#' + sectionId + '"]').classList.remove('active');
                    }
                });
            }

            // Update active menu on scroll
            window.addEventListener('scroll', setActiveMenu);
            
            // Update active menu on click
            document.querySelectorAll('.dock-menu a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('href');
                    
                    // Remove active class from all menu items
                    document.querySelectorAll('.dock-menu a').forEach(item => {
                        item.classList.remove('active');
                    });
                    
                    // Add active class to clicked menu item
                    this.classList.add('active');
                    
                    document.querySelector(target).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Set initial active menu
            setActiveMenu();

            // Message Actions
            document.querySelectorAll('.message-action-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (this.querySelector('i').classList.contains('fa-heart')) {
                        this.classList.toggle('text-danger');
                    }
                });
            });

            // Music Player
            const musicPlayer = document.querySelector('.music-player');
            const bgMusic = document.getElementById('bgMusic');
            let isPlaying = false;

            musicPlayer.addEventListener('click', () => {
                if (isPlaying) {
                    bgMusic.pause();
                    musicPlayer.classList.remove('playing');
                } else {
                    bgMusic.play();
                    musicPlayer.classList.add('playing');
                }
                isPlaying = !isPlaying;
            });

            // Share Button
            const shareButton = document.querySelector('.share-button');
            shareButton.addEventListener('click', async () => {
                try {
                    await navigator.share({
                        title: 'Undangan Pernikahan',
                        text: 'Undangan Pernikahan Ahmad & Siti',
                        url: window.location.href
                    });
                } catch (err) {
                    console.log('Error sharing:', err);
                }
            });

            // Back to Top Button
            const backToTop = document.querySelector('.back-to-top');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });

            backToTop.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Messages Pagination
            const messagesContainers = document.querySelectorAll('.messages-container');
            const paginationBtns = document.querySelectorAll('.pagination-btn');
            const prevBtn = document.querySelector('.pagination-btn.prev');
            const nextBtn = document.querySelector('.pagination-btn.next');
            let currentPage = 1;
            const totalPages = messagesContainers.length;

            function updatePagination() {
                // Update active state of page buttons
                paginationBtns.forEach(btn => {
                    if (btn.classList.contains('active')) {
                        btn.classList.remove('active');
                    }
                });
                document.querySelector(`.pagination-btn:nth-child(${currentPage + 1})`).classList.add('active');

                // Update prev/next buttons
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages;

                // Show/hide messages
                messagesContainers.forEach(container => {
                    container.classList.remove('active');
                });
                document.querySelector(`.messages-container[data-page="${currentPage}"]`).classList.add('active');
            }

            paginationBtns.forEach((btn, index) => {
                if (index === 0) return; // Skip prev button
                if (index === paginationBtns.length - 1) return; // Skip next button
                
                btn.addEventListener('click', () => {
                    currentPage = index;
                    updatePagination();
                });
            });

            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                }
            });

            nextBtn.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                }
            });

            // Copy Bank Account Number
            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', function(event) {
                    const accountNumber = event.target.getAttribute('data-account');
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(accountNumber).then(() => {
                            const originalText = event.target.innerHTML;
                            event.target.innerHTML = '<i class="fas fa-check"></i> Tersalin';
                            setTimeout(() => {
                                event.target.innerHTML = originalText;
                            }, 2000);
                        }).catch(err => {
                            console.error('Error copying text: ', err);
                        });
                    }
                });
            });
        });