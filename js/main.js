document.addEventListener('DOMContentLoaded', () => {
    // Theme Switcher Logic
    const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    const currentTheme = localStorage.getItem('theme');

    if (currentTheme) {
        document.documentElement.setAttribute('data-theme', currentTheme);
        if (currentTheme === 'light') {
            toggleSwitch.checked = true;
        }
    }

    function switchTheme(e) {
        if (e.target.checked) {
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
        }
    }

    if (toggleSwitch) {
        toggleSwitch.addEventListener('change', switchTheme, false);
    }

    // Intersection Observer for Scroll Animations
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    // Apply reveal class to sections and cards for animation
    const animElements = document.querySelectorAll('.stat-card, .glass-card, .section-title, .hero h1, .hero p');
    animElements.forEach(el => {
        el.classList.add('reveal');
        observer.observe(el);
    });

    // Explore Dropdown Toggle Logic
    const leftDropdown = document.querySelector('.left-dropdown');
    const leftDropbtn = document.querySelector('.left-dropbtn');

    if (leftDropdown && leftDropbtn) {
        leftDropbtn.addEventListener('click', (e) => {
            e.stopPropagation();
            leftDropdown.classList.toggle('active');
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!leftDropdown.contains(e.target)) {
                leftDropdown.classList.remove('active');
            }
        });
    }

    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            navLinks.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
                navLinks.classList.remove('active');
                const icon = menuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }

    // Mobile Dropdown Logic
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const dropbtn = dropdown.querySelector('.dropbtn');
        if (dropbtn) {
            dropbtn.addEventListener('click', (e) => {
                if (window.innerWidth <= 1024) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                }
            });
        }
    });

    // Scroll Header Effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.padding = '0.8rem 2rem';
            navbar.style.backgroundColor = 'var(--secondary-color)';
            navbar.style.borderBottom = '1px solid var(--primary-color)';
        } else {
            navbar.style.padding = '1.2rem 2rem';
            navbar.style.backgroundColor = 'var(--secondary-color)';
            navbar.style.borderBottom = '1px solid var(--border-color)';
        }
    });

    // Form Validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const inputs = form.querySelectorAll('input[required], textarea[required]');
            let valid = true;
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = '#e74c3c';
                } else {
                    input.style.borderColor = 'var(--border-color)';
                }
            });
            if (!valid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
});
