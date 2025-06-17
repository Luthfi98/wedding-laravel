// Existing script...

// Theme Toggle with Animations
const themeToggle = document.getElementById('themeToggle');
const icon = themeToggle.querySelector('i');
const sunMoonContainer = document.querySelector('.sun-moon-container');
const sun = document.querySelector('.sun');
const moon = document.querySelector('.moon');
const stars = document.querySelector('.stars');
const overlay = document.querySelector('.overlay');

// Create stars
for (let i = 0; i < 50; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    star.style.width = Math.random() * 3 + 'px';
    star.style.height = star.style.width;
    star.style.left = Math.random() * 100 + '%';
    star.style.top = Math.random() * 100 + '%';
    star.style.animationDelay = Math.random() * 1.5 + 's';
    stars.appendChild(star);
}

function updateIcon(theme) {
    icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}

function animateThemeChange(newTheme) {
    themeToggle.classList.add('animating');
    overlay.classList.add('active');
    sunMoonContainer.classList.add('active');
    
    if (newTheme === 'dark') {
        moon.style.display = 'block';
        sun.style.display = 'none';
        stars.classList.add('active');
    } else {
        sun.style.display = 'block';
        moon.style.display = 'none';
        stars.classList.remove('active');
    }

    setTimeout(() => {
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon(newTheme);
        
        setTimeout(() => {
            themeToggle.classList.remove('animating');
            overlay.classList.remove('active');
            sunMoonContainer.classList.remove('active');
        }, 800);
    }, 300);
}

themeToggle.addEventListener('click', () => {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    animateThemeChange(newTheme);
});

// Check for saved theme preference
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateIcon(savedTheme);
}

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// FAQ Toggle
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement;
        faqItem.classList.toggle('active');
    });
});

// Mobile Menu Toggle
const hamburger = document.querySelector('.hamburger');
const mobileMenu = document.querySelector('.mobile-menu');
const menuOverlay = document.querySelector('.menu-overlay');
const mobileLinks = document.querySelectorAll('.mobile-menu .mobile-nav a');
const closeButton = document.querySelector('.mobile-menu-close');

function toggleMenu() {
    hamburger.classList.toggle('active');
    mobileMenu.classList.toggle('active');
    menuOverlay.classList.toggle('active');
    document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
}

hamburger.addEventListener('click', toggleMenu);
menuOverlay.addEventListener('click', toggleMenu);
closeButton.addEventListener('click', toggleMenu);

// Close mobile menu when clicking on links
mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
        toggleMenu();
        // Smooth scroll to section
        const targetId = link.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        if (targetSection) {
            targetSection.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Close mobile menu on window resize
window.addEventListener('resize', () => {
    if (window.innerWidth > 768 && mobileMenu.classList.contains('active')) {
        toggleMenu();
    }
});

// Update active menu item on scroll
const sections = document.querySelectorAll('section[id]');
window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop - 60) {
            current = section.getAttribute('id');
        }
    });

    // Update desktop nav
    document.querySelectorAll('.desktop-nav a').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.classList.add('active');
        }
    });

    // Update mobile nav
    document.querySelectorAll('.mobile-nav a').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === current) {
            link.classList.add('active');
        }
    });
});