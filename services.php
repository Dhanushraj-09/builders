<?php
/**
 * Services Page — CELTA Builders
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$pageTitle = 'Our Services';
$pageDescription = 'Complete construction services including residential, commercial, interior works, renovation, electrical, and architecture design by CELTA Builders.';

$servicesStmt = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC");
$services = $servicesStmt->fetchAll();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- Services Section with Full Background -->
<section class="relative overflow-hidden bg-cover bg-center bg-fixed pt-64 pb-24" style="background-image: url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1920&q=80');">
    <!-- Background Overlays -->
    <div class="absolute inset-0 bg-dark-950/40 backdrop-blur-[2px]"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-dark-950 via-dark-950/80 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center mb-20" data-aos="fade-up">

            <h1 class="section-title text-4xl sm:text-5xl md:text-6xl text-white mt-4 mb-4">
                What We <span class="gradient-text">Offer</span>
            </h1>
            <p class="text-dark-300 max-w-2xl mx-auto text-lg">Complete construction solutions from foundation to finishing — delivering excellence at every step.</p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($services as $i => $service): ?>
            <div class="glass-card service-card overflow-hidden group" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <!-- Service Image -->
                <div class="aspect-[16/10] overflow-hidden relative">
                    <?php if ($service['image']): ?>
                        <img src="<?= UPLOAD_URL ?>services/<?= sanitize($service['image']) ?>" alt="<?= sanitize($service['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-dark-800 to-dark-900">
                        </div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-950 via-transparent to-transparent"></div>
                </div>

                <!-- Service Content -->
                <div class="p-8">
                    <div class="service-icon mb-5">
                        <i class="fa-solid <?= sanitize($service['icon']) ?>"></i>
                    </div>
                    <h3 class="font-heading font-bold text-white text-xl mb-3"><?= sanitize($service['title']) ?></h3>
                    <p class="text-dark-400 text-sm leading-relaxed mb-6"><?= sanitize($service['description']) ?></p>
                    <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center gap-2 text-primary-400 text-sm font-semibold hover:text-primary-300 transition-colors group/link">
                        Get Quote <i class="fa-solid fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- Service Areas -->
<section class="py-24 bg-dark-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">

            <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4 mb-4">
                Service <span class="gradient-text">Areas</span>
            </h2>
            <p class="text-dark-400 max-w-2xl mx-auto">We serve clients across Virudhunagar district and surrounding areas in Tamil Nadu.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php
            $areas = ['Srivilliputhur', 'Sivakasi', 'Virudhunagar', 'Madurai', 'Rajapalayam', 'Sattur', 'Aruppukottai', 'Kovilpatti', 'Tenkasi', 'Theni', 'Dindigul', 'Tirunelveli'];
            foreach($areas as $i => $area):
            ?>
            <div class="glass-card p-4 text-center group hover:border-primary-500/30" data-aos="fade-up" data-aos-delay="<?= $i * 50 ?>">
                <i class="fa-solid fa-location-dot text-primary-500 mb-2 group-hover:scale-125 transition-transform"></i>
                <p class="text-white text-sm font-medium"><?= $area ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="cta-section rounded-3xl p-12 md:p-16 text-center relative" data-aos="fade-up">
            <div class="relative z-10">
                <h2 class="section-title text-3xl sm:text-4xl text-white mb-6">
                    Need a <span class="gradient-text">Construction</span> Service?
                </h2>
                <p class="text-dark-300 max-w-xl mx-auto mb-8">Contact us today for a free consultation and quotation. Our experts are ready to help.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-8 py-4 rounded-xl font-heading font-bold hover:shadow-2xl hover:shadow-primary-500/30 hover:-translate-y-1 transition-all">
                        <i class="fa-solid fa-paper-plane"></i> Get Free Quote
                    </a>
                    <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" class="inline-flex items-center gap-2 bg-green-500/10 border border-green-500/20 text-green-400 px-8 py-4 rounded-xl font-heading font-bold hover:bg-green-500/20 transition-all">
                        <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
