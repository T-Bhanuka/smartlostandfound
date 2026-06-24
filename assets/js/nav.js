document.addEventListener('DOMContentLoaded', () => {
    // Sticky scroll shrink logic
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile Menu Toggle logic
    const hamburger = document.getElementById('hamburger-toggle');
    const navLinks = document.getElementById('nav-links');

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', (e) => {
            e.stopPropagation();
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('open');
        });

        // Close mobile menu if clicked outside
        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
                hamburger.classList.remove('active');
                navLinks.classList.remove('open');
            }
        });
    }

    // Sliding Underline Tab Indicator logic
    const links = document.querySelectorAll('.nav-links .nav-item-link');
    const indicator = document.getElementById('nav-indicator');

    function updateIndicator(element) {
        if (element && indicator) {
            if (window.innerWidth > 768) {
                indicator.style.width = `${element.offsetWidth}px`;
                indicator.style.left = `${element.offsetLeft}px`;
                indicator.style.opacity = '1';
            }
        } else if (indicator) {
            indicator.style.opacity = '0';
        }
    }

    // Get current page filename
    let currentPath = window.location.pathname.split('/').pop();
    if (currentPath === '') {
        currentPath = 'dashboard.php';
    }

    let activeLink = null;

    links.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (currentPath === linkHref || (currentPath === 'index.php' && linkHref === 'dashboard.php')) {
            link.classList.add('active');
            activeLink = link;
        }

        link.addEventListener('mouseenter', (e) => {
            updateIndicator(e.target);
        });

        link.addEventListener('mouseleave', () => {
            updateIndicator(activeLink);
        });
    });

    // Initialize indicator position
    setTimeout(() => {
        updateIndicator(activeLink);
    }, 100);

    // Recalculate on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768 && indicator) {
            indicator.style.opacity = '0';
        } else {
            updateIndicator(activeLink);
        }
    });
});
