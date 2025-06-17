 document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const overlay = document.querySelector('.sidebar-overlay');
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                });
            });
            
            // Desktop sidebar toggle
            const toggleBtn = document.getElementById('desktopSidebarToggle');
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                
                // Change icon based on sidebar state
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('bi-list');
                    icon.classList.add('bi-list-nested');
                } else {
                    icon.classList.remove('bi-list-nested');
                    icon.classList.add('bi-list');
                }
            });

            // Handle submenu click in collapsed state
            const submenuLinks = document.querySelectorAll('.sidebar .nav-link[data-bs-toggle="collapse"]');
            submenuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (sidebar.classList.contains('collapsed')) {
                        e.preventDefault();
                        const submenu = this.nextElementSibling.querySelector('.submenu');
                        if (submenu) {
                            // Position the submenu
                            const rect = this.getBoundingClientRect();
                            submenu.style.top = rect.top + 'px';
                            submenu.classList.toggle('show');
                        }
                    }
                });
            });

            // Close submenu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.sidebar')) {
                    document.querySelectorAll('.sidebar .submenu.show').forEach(submenu => {
                        submenu.classList.remove('show');
                    });
                }
            });

            // Mobile sidebar toggle
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                
                // Change icon based on sidebar state
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('show')) {
                    icon.classList.remove('bi-list');
                    icon.classList.add('bi-x-lg');
                } else {
                    icon.classList.remove('bi-x-lg');
                    icon.classList.add('bi-list');
                }
            });

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });

              // Theme Toggle Functionality
            const lightModeBtn = document.getElementById('lightModeBtn');
            const darkModeBtn = document.getElementById('darkModeBtn');
            
            // Check for saved theme preference
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                darkModeBtn.classList.add('active');
                lightModeBtn.classList.remove('active');
            } else {
                lightModeBtn.classList.add('active');
                darkModeBtn.classList.remove('active');
            }

            // Light Mode Button Click
            lightModeBtn.addEventListener('click', function() {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
                lightModeBtn.classList.add('active');
                darkModeBtn.classList.remove('active');
            });

            // Dark Mode Button Click
            darkModeBtn.addEventListener('click', function() {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                darkModeBtn.classList.add('active');
                lightModeBtn.classList.remove('active');
            });
        });
