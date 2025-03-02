document.addEventListener('DOMContentLoaded', function () {
    // Menú móvil toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', function () {
        if (mobileMenu.classList.contains('transform-none')) {
            mobileMenu.classList.remove('transform-none');
            mobileMenu.classList.add('-translate-y-full');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        } else {
            mobileMenu.classList.remove('-translate-y-full');
            mobileMenu.classList.add('transform-none');
            menuToggle.innerHTML = '<i class="fas fa-times"></i>';
        }
    });

    // Enlaces del menú móvil
    const mobileLinks = document.querySelectorAll('.mobile-link');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Close mobile menu when a link is clicked
            mobileMenu.classList.remove('transform-none');
            mobileMenu.classList.add('-translate-y-full');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';

            // Scroll to section if it's an anchor link
            const href = this.getAttribute('href');
            if (href.startsWith('#') && href.length > 1) {
                event.preventDefault();
                const targetSection = document.querySelector(href);
                if (targetSection) {
                    targetSection.scrollIntoView({behavior: 'smooth'});
                }
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (event) {
        if (!mobileMenu.contains(event.target) &&
            !menuToggle.contains(event.target) &&
            mobileMenu.classList.contains('transform-none')) {
            mobileMenu.classList.remove('transform-none');
            mobileMenu.classList.add('-translate-y-full');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        }
    });

    // Add resize handler to reset menu on desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) { // Adjust breakpoint as needed
            mobileMenu.classList.remove('transform-none');
            mobileMenu.classList.add('-translate-y-full');
            menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        }
    });
});
