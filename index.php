<?php
/**
 * Home Page — CELTA Builders
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$pageTitle = 'Home';
$pageDescription = 'CELTA Builders — Premium construction company in Srivilliputhur, Tamil Nadu. Expert builders for residential, commercial, interior works & renovation with modern 3D designs.';

// Fetch featured projects
$featuredStmt = $pdo->query("SELECT p.*, (SELECT image FROM project_images WHERE project_id = p.id ORDER BY sort_order ASC LIMIT 1) as thumbnail FROM projects p WHERE p.featured = 1 ORDER BY p.created_at DESC LIMIT 6");
$featuredProjects = $featuredStmt->fetchAll();

// Fetch services
$servicesStmt = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC LIMIT 6");
$services = $servicesStmt->fetchAll();

// Fetch completed projects with testimonials
$testimonialStmt = $pdo->query("SELECT * FROM projects WHERE testimonial IS NOT NULL AND testimonial != '' ORDER BY created_at DESC LIMIT 6");
$testimonials = $testimonialStmt->fetchAll();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- ═══════════════ HERO SECTION ═══════════════ -->
<section id="hero" class="relative min-h-screen flex items-center overflow-hidden">
    <!-- Background Video -->
    <video autoplay loop muted playsinline class="hero-video absolute inset-0 w-full h-full object-cover object-[75%_75%] md:object-center z-0">
        <source src="<?= SITE_URL ?>/assets/videos/v1.mp4" type="video/mp4">
    </video>

    <!-- Gradient Overlays -->
    <div class="hero-gradient-1 absolute inset-0 z-[1] bg-gradient-to-r from-dark-950/60 via-dark-950/30 to-transparent"></div>
    <div class="hero-gradient-2 absolute inset-0 z-[1] bg-gradient-to-t from-dark-950/70 via-transparent to-transparent"></div>

    <!-- Hero Content -->
    <div class="hero-content relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
        <div class="max-w-3xl">
            <div class="hero-title">

                <h1 class="section-title text-4xl sm:text-5xl md:text-6xl lg:text-7xl text-white mb-6">
                    Building <span class="gradient-text">Dreams</span><br>
                    Into Reality
                </h1>
            </div>
            <p class="hero-subtitle text-dark-300 text-lg sm:text-xl max-w-xl mb-10 leading-relaxed">
                Premium residential & commercial construction with modern designs, 
                quality materials, and trusted craftsmanship across Tamil Nadu.
            </p>
            <div class="hero-cta flex flex-wrap gap-4 mb-12">
                <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-8 py-4 rounded-xl font-heading font-bold text-base hover:shadow-2xl hover:shadow-primary-500/30 hover:-translate-y-1 transition-all">
                    <i class="fa-solid fa-paper-plane"></i>
                    Get Free Quote
                </a>
                <a href="<?= SITE_URL ?>/projects.php" class="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-white px-8 py-4 rounded-xl font-heading font-semibold text-base hover:bg-white/10 hover:border-white/20 transition-all">
                    <i class="fa-solid fa-images"></i>
                    View Projects
                </a>
            </div>
            <div class="hero-stats flex flex-wrap gap-8">
                <div>
                    <div class="stat-number text-3xl" data-counter="150" data-suffix="+">0</div>
                    <p class="text-dark-400 text-sm mt-1">Projects Completed</p>
                </div>
                <div>
                    <div class="stat-number text-3xl" data-counter="120" data-suffix="+">0</div>
                    <p class="text-dark-400 text-sm mt-1">Happy Clients</p>
                </div>
                <div>
                    <div class="stat-number text-3xl" data-counter="12" data-suffix="+">0</div>
                    <p class="text-dark-400 text-sm mt-1">Years Experience</p>
                </div>
                <div>
                    <div class="stat-number text-3xl" data-counter="35" data-suffix="+">0</div>
                    <p class="text-dark-400 text-sm mt-1">Expert Team</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
        <div class="w-6 h-10 border-2 border-white/20 rounded-full flex justify-center pt-2">
            <div class="w-1 h-2 bg-primary-400 rounded-full animate-pulse"></div>
        </div>
    </div>
</section>

<!-- ═══════════════ SERVICES OVERVIEW ═══════════════ -->
<section class="py-24 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">

            <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4 mb-4">
                Our Premium <span class="gradient-text">Services</span>
            </h2>
            <p class="text-dark-400 max-w-2xl mx-auto">Complete construction solutions from planning to finishing — delivering excellence in every project.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($services as $i => $service): ?>
            <div class="glass-card service-card p-8" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="service-icon mb-6">
                    <i class="fa-solid <?= sanitize($service['icon']) ?>"></i>
                </div>
                <h3 class="font-heading font-bold text-white text-xl mb-3"><?= sanitize($service['title']) ?></h3>
                <p class="text-dark-400 text-sm leading-relaxed mb-4"><?= sanitize(substr($service['description'], 0, 120)) ?>...</p>
                <a href="<?= SITE_URL ?>/services.php" class="text-primary-400 text-sm font-semibold hover:text-primary-300 transition-colors inline-flex items-center gap-1">
                    Learn More <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════ FEATURED PROJECTS ═══════════════ -->
<?php if (!empty($featuredProjects)): ?>
<section class="py-24 bg-dark-900/30 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-16">
            <div data-aos="fade-up">

                <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4 mb-4">
                    Featured <span class="gradient-text">Projects</span>
                </h2>
                <p class="text-dark-400 max-w-lg">Showcasing our finest construction work across residential and commercial sectors.</p>
            </div>
            <a href="<?= SITE_URL ?>/projects.php" class="mt-6 md:mt-0 inline-flex items-center gap-2 text-primary-400 font-semibold hover:text-primary-300 transition-colors" data-aos="fade-up" data-aos-delay="200">
                View All Projects <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="swiper projects-swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                <?php foreach($featuredProjects as $project): ?>
                <div class="swiper-slide">
                    <a href="<?= SITE_URL ?>/project-detail.php?slug=<?= urlencode($project['slug']) ?>" class="block project-card group">
                        <div class="aspect-[4/3] overflow-hidden rounded-2xl relative">
                            <?php if ($project['thumbnail']): 
                                $ext = strtolower(pathinfo($project['thumbnail'], PATHINFO_EXTENSION));
                                $isVideo = in_array($ext, ['mp4', 'webm', 'mov']);
                            ?>
                                <?php if($isVideo): ?>
                                    <video src="<?= UPLOAD_URL ?>projects/<?= sanitize($project['thumbnail']) ?>" class="w-full h-full object-cover project-image" muted autoplay loop playsinline></video>
                                <?php else: ?>
                                    <img src="<?= UPLOAD_URL ?>projects/<?= sanitize($project['thumbnail']) ?>" alt="<?= sanitize($project['title']) ?>" class="w-full h-full object-cover project-image">
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="w-full h-full bg-dark-800 flex items-center justify-center project-image">
                                    <i class="fa-solid fa-building text-4xl text-dark-600"></i>
                                </div>
                            <?php endif; ?>
                            <div class="project-overlay"></div>
                            <div class="absolute top-4 left-4 right-4 flex items-start justify-between pointer-events-none z-10">
                                <span class="badge-<?= $project['status'] ?> text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                    <?= ucfirst(str_replace('_', ' ', $project['status'])) ?>
                                </span>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <h3 class="font-heading font-bold text-white text-lg mb-1 group-hover:text-primary-400 transition-colors"><?= sanitize($project['title']) ?></h3>
                                <p class="text-dark-400 text-sm flex items-center gap-1"><i class="fa-solid fa-location-dot text-primary-500 text-xs"></i> <?= sanitize($project['location']) ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination mt-8"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════ CONSTRUCTION PROCESS ═══════════════ -->
<section class="py-24 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">

            <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4 mb-4">
                How We <span class="gradient-text">Build</span>
            </h2>
            <p class="text-dark-400 max-w-2xl mx-auto">A transparent, step-by-step construction process designed for quality and client satisfaction.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
            <?php
            $steps = [
                ['icon' => 'fa-comments', 'title' => 'Consultation', 'desc' => 'Free initial meeting to understand your vision, requirements, budget, and timeline for the project.'],
                ['icon' => 'fa-compass-drafting', 'title' => 'Design & Planning', 'desc' => 'Architectural planning, 2D/3D elevation design, structural engineering, and building plan approval.'],
                ['icon' => 'fa-file-contract', 'title' => 'Agreement & Budgeting', 'desc' => 'Transparent cost estimation, material selection, and formal construction agreement with clear terms.'],
                ['icon' => 'fa-helmet-safety', 'title' => 'Construction', 'desc' => 'Quality construction with regular progress updates, site inspections, and strict timeline adherence.'],
                ['icon' => 'fa-paintbrush', 'title' => 'Interior & Finishing', 'desc' => 'Premium interior works including flooring, painting, electrical fittings, modular kitchen, and false ceiling.'],
                ['icon' => 'fa-key', 'title' => 'Handover', 'desc' => 'Final quality inspection, documentation, warranty provision, and key handover with complete satisfaction.']
            ];
            foreach($steps as $i => $step):
            ?>
            <div class="timeline-item" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="timeline-dot"><i class="fa-solid <?= $step['icon'] ?>"></i></div>
                <div class="glass-card p-6">
                    <span class="text-primary-500 text-xs font-bold font-heading">STEP <?= $i + 1 ?></span>
                    <h3 class="font-heading font-bold text-white text-lg mt-1 mb-2"><?= $step['title'] ?></h3>
                    <p class="text-dark-400 text-sm leading-relaxed"><?= $step['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════ TESTIMONIALS ═══════════════ -->
<?php if (!empty($testimonials)): ?>
<section class="py-24 bg-dark-900/30 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">

            <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4 mb-4">
                Client <span class="gradient-text">Reviews</span>
            </h2>
            <p class="text-dark-400 max-w-2xl mx-auto">Hear from our satisfied clients about their construction experience.</p>
        </div>

        <div class="swiper testimonials-swiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                <?php foreach($testimonials as $t): ?>
                <div class="swiper-slide">
                    <div class="glass-card testimonial-card p-8 h-full flex flex-col">
                        <div class="star-rating mb-4">
                            <?php for($s = 1; $s <= 5; $s++): ?>
                                <i class="fa-solid fa-star <?= $s > $t['rating'] ? 'empty' : '' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-dark-300 text-sm leading-relaxed flex-1 mb-6">"<?= sanitize($t['testimonial']) ?>"</p>
                        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-dark-950 font-bold text-sm">
                                <?= strtoupper(substr($t['client_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="text-white font-semibold text-sm"><?= sanitize($t['client_name']) ?></p>
                                <p class="text-dark-500 text-xs"><?= sanitize($t['location']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination mt-8"></div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════ CTA SECTION ═══════════════ -->
<section class="py-24 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="cta-section rounded-3xl p-12 md:p-16 text-center relative" data-aos="fade-up">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-primary-500/20 text-primary-400 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                    <i class="fa-solid fa-phone-volume"></i>
                    Free Construction Consultation
                </div>
                <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mb-6">
                    Ready to <span class="gradient-text">Build</span> Your Dream?
                </h2>
                <p class="text-dark-300 max-w-2xl mx-auto mb-10 text-lg">Get a free quotation for your construction project. Our experts will guide you through every step from planning to completion.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-8 py-4 rounded-xl font-heading font-bold text-base hover:shadow-2xl hover:shadow-primary-500/30 hover:-translate-y-1 transition-all">
                        <i class="fa-solid fa-paper-plane"></i>
                        Get Free Quote
                    </a>
                    <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" class="inline-flex items-center gap-2 bg-green-500/10 border border-green-500/20 text-green-400 px-8 py-4 rounded-xl font-heading font-bold text-base hover:bg-green-500/20 transition-all">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        WhatsApp Us
                    </a>
                    <a href="tel:<?= SITE_PHONE ?>" class="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-white px-8 py-4 rounded-xl font-heading font-semibold text-base hover:bg-white/10 transition-all">
                        <i class="fa-solid fa-phone"></i>
                        <?= SITE_PHONE ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
