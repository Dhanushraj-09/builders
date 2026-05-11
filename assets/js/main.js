/**
 * Main JavaScript
 * StructuraPro Builders Website
 */

document.addEventListener('DOMContentLoaded', () => {

    // ── Preloader ──
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('preloader')?.classList.add('loaded');
        }, 800);
    });

    // ── AOS Init ──
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80,
            delay: 50
        });
    }

    // ── Navbar Scroll Effect ──
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (navbar) {
            if (currentScroll > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });

    // ── Mobile Menu Toggle ──
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            if (mobileMenu.classList.contains('hidden')) {
                menuIcon.className = 'fa-solid fa-bars text-lg';
            } else {
                menuIcon.className = 'fa-solid fa-xmark text-lg';
            }
        });
    }

    // ── Counter Animation ──
    const counters = document.querySelectorAll('[data-counter]');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-counter'));
                const suffix = el.getAttribute('data-suffix') || '';
                const duration = 2000;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
                    const current = Math.floor(eased * target);
                    el.textContent = current + suffix;
                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        el.textContent = target + suffix;
                    }
                }
                requestAnimationFrame(updateCounter);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(c => counterObserver.observe(c));

    // ── GSAP Animations ──
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Hero text animation
        gsap.from('.hero-title', {
            y: 60,
            opacity: 0,
            duration: 1,
            delay: 1,
            ease: 'power3.out'
        });
        gsap.from('.hero-subtitle', {
            y: 40,
            opacity: 0,
            duration: 1,
            delay: 1.3,
            ease: 'power3.out'
        });
        gsap.from('.hero-cta', {
            y: 30,
            opacity: 0,
            duration: 1,
            delay: 1.6,
            ease: 'power3.out'
        });
        gsap.from('.hero-stats', {
            y: 30,
            opacity: 0,
            duration: 1,
            delay: 1.8,
            ease: 'power3.out'
        });

        // Scroll-triggered section reveals
        gsap.utils.toArray('.gsap-reveal').forEach(el => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                y: 40,
                opacity: 0,
                duration: 0.8,
                ease: 'power2.out'
            });
        });
    }

    // ── Project Filter ──
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-filter-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.getAttribute('data-filter');

            projectCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-status') === filter) {
                    card.style.display = '';
                    card.style.animation = 'fadeInUp 0.5s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // ── Lightbox ──
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxClose = document.getElementById('lightbox-close');

    document.querySelectorAll('[data-lightbox]').forEach(img => {
        img.addEventListener('click', () => {
            if (lightbox && lightboxImg) {
                lightboxImg.src = img.getAttribute('data-lightbox');
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', () => {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    if (lightbox) {
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // ── Contact Form Validation ──
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let valid = true;
            const name = this.querySelector('[name="name"]');
            const phone = this.querySelector('[name="phone"]');

            if (name && name.value.trim().length < 2) {
                valid = false;
                name.style.borderColor = 'rgba(239, 68, 68, 0.5)';
            } else if (name) {
                name.style.borderColor = '';
            }

            if (phone && phone.value.trim().length < 10) {
                valid = false;
                phone.style.borderColor = 'rgba(239, 68, 68, 0.5)';
            } else if (phone) {
                phone.style.borderColor = '';
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    }

    // ── Swiper Initialization ──
    if (typeof Swiper !== 'undefined') {
        // Testimonials slider
        if (document.querySelector('.testimonials-swiper')) {
            new Swiper('.testimonials-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        }

        // Featured projects slider
        if (document.querySelector('.projects-swiper')) {
            new Swiper('.projects-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                pagination: { el: '.swiper-pagination', clickable: true },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        }

        // Project detail gallery
        if (document.querySelector('.gallery-swiper')) {
            new Swiper('.gallery-swiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                pagination: { el: '.swiper-pagination', clickable: true }
            });
        }
    }

    // ── Smooth Scroll ──
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ── Theme Toggle (Light / Dark Mode) ──
    const themeToggle = document.getElementById('theme-toggle');
    const themeLabel = document.getElementById('theme-label');
    const savedTheme = localStorage.getItem('theme');

    // Apply saved theme on load
    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        if (themeLabel) themeLabel.textContent = 'Light Mode';
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('light-mode');
            const isLight = document.body.classList.contains('light-mode');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            if (themeLabel) {
                themeLabel.textContent = isLight ? 'Light Mode' : 'Dark Mode';
            }
        });
    }
});
