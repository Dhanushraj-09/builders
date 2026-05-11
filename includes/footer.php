<?php
/**
 * Footer
 * Builder Company Website
 */
?>

<!-- Footer -->
<footer class="relative bg-dark-950 pt-20 pb-8 border-t border-white/5">
    <div class="absolute inset-0 bg-gradient-to-t from-primary-500/5 to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <a href="<?= SITE_URL ?>" class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25">
                        <i class="fa-solid fa-helmet-safety text-dark-950 text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xl font-heading font-bold text-white"><?= SITE_NAME ?></span>
                        <span class="block text-xs text-primary-400 tracking-wider">Premium Builders</span>
                    </div>
                </a>
                <p class="text-dark-400 text-sm leading-relaxed mb-6">Building dreams into reality with premium construction quality, modern designs, and trusted craftsmanship across Tamil Nadu.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-dark-400 hover:text-primary-400 hover:border-primary-400/30 hover:bg-primary-400/5 transition-all"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-dark-400 hover:text-primary-400 hover:border-primary-400/30 hover:bg-primary-400/5 transition-all"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-dark-400 hover:text-primary-400 hover:border-primary-400/30 hover:bg-primary-400/5 transition-all"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-dark-400 hover:text-primary-400 hover:border-primary-400/30 hover:bg-primary-400/5 transition-all"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-heading font-bold text-white mb-6 text-lg">Quick Links</h4>
                <ul class="space-y-3">
                    <li><a href="<?= SITE_URL ?>/index.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Home</a></li>
                    <li><a href="<?= SITE_URL ?>/about.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>About Us</a></li>
                    <li><a href="<?= SITE_URL ?>/services.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Our Services</a></li>
                    <li><a href="<?= SITE_URL ?>/projects.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Projects</a></li>
                    <li><a href="<?= SITE_URL ?>/contact.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Contact Us</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="font-heading font-bold text-white mb-6 text-lg">Our Services</h4>
                <ul class="space-y-3">
                    <li><a href="<?= SITE_URL ?>/services.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>House Construction</a></li>
                    <li><a href="<?= SITE_URL ?>/services.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Commercial Buildings</a></li>
                    <li><a href="<?= SITE_URL ?>/services.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Interior Works</a></li>
                    <li><a href="<?= SITE_URL ?>/services.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Renovation</a></li>
                    <li><a href="<?= SITE_URL ?>/services.php" class="text-dark-400 hover:text-primary-400 transition-colors text-sm flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-primary-500/50"></i>Architecture Design</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="font-heading font-bold text-white mb-6 text-lg">Contact Us</h4>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0 mt-0.5"><i class="fa-solid fa-location-dot text-primary-400 text-xs"></i></div>
                        <span class="text-dark-400 text-sm"><?= SITE_ADDRESS ?></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-phone text-primary-400 text-xs"></i></div>
                        <a href="tel:<?= SITE_PHONE ?>" class="text-dark-400 hover:text-primary-400 transition-colors text-sm"><?= SITE_PHONE ?></a>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-envelope text-primary-400 text-xs"></i></div>
                        <a href="mailto:<?= SITE_EMAIL ?>" class="text-dark-400 hover:text-primary-400 transition-colors text-sm"><?= SITE_EMAIL ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-dark-500 text-sm">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</p>

            <!-- Light / Dark Mode Toggle -->
            <button id="theme-toggle" class="theme-toggle-btn" aria-label="Toggle light/dark mode" title="Switch theme">
                <span class="theme-toggle-track">
                    <i class="fa-solid fa-moon theme-icon-dark"></i>
                    <i class="fa-solid fa-sun theme-icon-light"></i>
                    <span class="theme-toggle-thumb"></span>
                </span>
                <span class="theme-toggle-label" id="theme-label">Dark Mode</span>
            </button>

            <p class="text-dark-600 text-xs">Designed with <i class="fa-solid fa-heart text-primary-500"></i> for Premium Construction</p>
        </div>
    </div>
</footer>

<!-- Floating Social Buttons (Jumping) -->
<style>
    .floating-socials-wrap {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }
    .float-btn {
        position: relative;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.6rem;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .float-btn-wa {
        background: linear-gradient(135deg, #25d366, #128c7e);
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.45);
        animation: jumpBounce 2s ease-in-out infinite;
    }
    .float-btn-ig {
        background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        box-shadow: 0 4px 20px rgba(225, 48, 108, 0.45);
        animation: jumpBounce 2s ease-in-out infinite 1s;
    }
    @keyframes jumpBounce {
        0%, 100% { transform: translateY(0); }
        15% { transform: translateY(-16px); }
        30% { transform: translateY(0); }
        45% { transform: translateY(-9px); }
        60% { transform: translateY(0); }
    }
    .float-btn:hover {
        animation-play-state: paused;
        transform: scale(1.18) !important;
    }
    .float-btn-wa:hover { box-shadow: 0 8px 35px rgba(37, 211, 102, 0.65); }
    .float-btn-ig:hover { box-shadow: 0 8px 35px rgba(225, 48, 108, 0.65); }

    /* Pulsing ring */
    .float-btn-ring {
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        opacity: 0;
        pointer-events: none;
        animation: ringPulse 3s ease-out infinite;
    }
    .float-btn-wa .float-btn-ring { border: 2px solid #25d366; }
    .float-btn-ig .float-btn-ring { border: 2px solid #e6683c; animation-delay: 1.5s; }
    @keyframes ringPulse {
        0% { transform: scale(1); opacity: 0.6; }
        100% { transform: scale(1.9); opacity: 0; }
    }

    /* Tooltip */
    .float-btn-tip {
        position: absolute;
        right: calc(100% + 14px);
        top: 50%;
        transform: translateY(-50%);
        background: rgba(15, 23, 42, 0.95);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        padding: 6px 14px;
        border-radius: 8px;
        white-space: nowrap;
        border: 1px solid rgba(255, 255, 255, 0.1);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease, visibility 0.25s ease;
        pointer-events: none;
    }
    .float-btn-tip::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
        border: 5px solid transparent;
        border-left-color: rgba(15, 23, 42, 0.95);
    }
    .float-btn:hover .float-btn-tip {
        opacity: 1;
        visibility: visible;
    }
    @media (max-width: 480px) {
        .float-btn { width: 48px; height: 48px; font-size: 1.3rem; }
        .floating-socials-wrap { bottom: 1rem; right: 1rem; gap: 0.75rem; }
    }
</style>

<div class="floating-socials-wrap">
    <!-- Instagram -->
    <a href="https://www.instagram.com/" target="_blank" class="float-btn float-btn-ig" aria-label="Follow on Instagram">
        <i class="fa-brands fa-instagram"></i>
        <span class="float-btn-tip">Follow Us</span>
        <span class="float-btn-ring"></span>
    </a>
    <!-- WhatsApp -->
    <a href="https://wa.me/<?= SITE_WHATSAPP ?>?text=Hello%2C%20I%20am%20interested%20in%20your%20construction%20services." target="_blank" class="float-btn float-btn-wa" aria-label="Chat on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
        <span class="float-btn-tip">Chat with us</span>
        <span class="float-btn-ring"></span>
    </a>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/three-scene.js?v=<?= time() ?>"></script>
<script src="<?= SITE_URL ?>/assets/js/main.js?v=<?= time() ?>"></script>
</body>
</html>
