// Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Opening Animation
        $('.open-button').click(function() {
            $('.opening-screen').addClass('hide');
            setTimeout(function() {
                $('.main-content').fadeIn();
            }, 800);
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });