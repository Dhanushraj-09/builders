<?php
/**
 * Project Detail Page — StructuraPro Builders
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';
if (empty($slug)) { redirect(SITE_URL . '/projects.php'); }

$stmt = $pdo->prepare("SELECT * FROM projects WHERE slug = :slug LIMIT 1");
$stmt->execute([':slug' => $slug]);
$project = $stmt->fetch();

if (!$project) { redirect(SITE_URL . '/projects.php'); }

// Fetch images
$imgStmt = $pdo->prepare("SELECT * FROM project_images WHERE project_id = :pid ORDER BY sort_order ASC");
$imgStmt->execute([':pid' => $project['id']]);
$images = $imgStmt->fetchAll();

// Related projects
$relStmt = $pdo->prepare("SELECT p.*, (SELECT image FROM project_images WHERE project_id = p.id ORDER BY sort_order ASC LIMIT 1) as thumbnail FROM projects p WHERE p.id != :pid AND p.status = :status ORDER BY RAND() LIMIT 3");
$relStmt->execute([':pid' => $project['id'], ':status' => $project['status']]);
$related = $relStmt->fetchAll();

$pageTitle = $project['title'];
$pageDescription = substr(strip_tags($project['description']), 0, 160);

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- Page Header -->
<section class="pt-32 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 text-sm text-dark-400 mb-6" data-aos="fade-up">
            <a href="<?= SITE_URL ?>/projects.php" class="hover:text-primary-400 transition-colors">Projects</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-dark-300"><?= sanitize($project['title']) ?></span>
        </div>
    </div>
</section>

<!-- Project Content -->
<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Image Gallery -->
                <?php if (!empty($images)): ?>
                <div class="swiper gallery-swiper rounded-2xl overflow-hidden mb-8" data-aos="fade-up">
                    <div class="swiper-wrapper">
                        <?php foreach($images as $img): ?>
                        <div class="swiper-slide">
                            <div class="aspect-[16/10]">
                                <img src="<?= UPLOAD_URL ?>projects/<?= sanitize($img['image']) ?>" alt="<?= sanitize($project['title']) ?>" class="w-full h-full object-cover cursor-pointer" data-lightbox="<?= UPLOAD_URL ?>projects/<?= sanitize($img['image']) ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-pagination"></div>
                </div>
                <?php else: ?>
                <div class="aspect-[16/10] rounded-2xl bg-dark-800 flex items-center justify-center mb-8" data-aos="fade-up">
                    <i class="fa-solid fa-building text-6xl text-dark-600"></i>
                </div>
                <?php endif; ?>

                <!-- Thumbnail Strip -->
                <?php if (count($images) > 1): ?>
                <div class="flex gap-2 mb-8 overflow-x-auto pb-2" data-aos="fade-up">
                    <?php foreach($images as $img): ?>
                    <div class="w-20 h-16 flex-shrink-0 rounded-lg overflow-hidden cursor-pointer opacity-70 hover:opacity-100 transition-opacity border border-white/5 hover:border-primary-500/30" data-lightbox="<?= UPLOAD_URL ?>projects/<?= sanitize($img['image']) ?>">
                        <img src="<?= UPLOAD_URL ?>projects/<?= sanitize($img['image']) ?>" alt="" class="w-full h-full object-cover">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Description -->
                <div class="glass-card p-8 mb-8" data-aos="fade-up">
                    <h2 class="font-heading font-bold text-white text-2xl mb-4">About This Project</h2>
                    <p class="text-dark-300 leading-relaxed"><?= nl2br(sanitize($project['description'])) ?></p>
                </div>

                <!-- Video -->
                <?php if ($project['video']): ?>
                <div class="glass-card p-8 mb-8" data-aos="fade-up">
                    <h3 class="font-heading font-bold text-white text-xl mb-4"><i class="fa-solid fa-video text-primary-400 mr-2"></i>Project Video</h3>
                    <div class="aspect-video rounded-xl overflow-hidden">
                        <iframe src="<?= sanitize($project['video']) ?>" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Testimonial -->
                <?php if ($project['testimonial']): ?>
                <div class="glass-card testimonial-card p-8" data-aos="fade-up">
                    <h3 class="font-heading font-bold text-white text-xl mb-4"><i class="fa-solid fa-quote-left text-primary-400 mr-2"></i>Client Testimonial</h3>
                    <div class="star-rating mb-4">
                        <?php for($s = 1; $s <= 5; $s++): ?>
                            <i class="fa-solid fa-star <?= $s > $project['rating'] ? 'empty' : '' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-dark-300 text-sm leading-relaxed italic mb-4">"<?= sanitize($project['testimonial']) ?>"</p>
                    <p class="text-primary-400 font-semibold text-sm">— <?= sanitize($project['client_name']) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="glass-card p-8 sticky top-28" data-aos="fade-up">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-heading font-bold text-white text-xl"><?= sanitize($project['title']) ?></h2>
                        <span class="badge-<?= $project['status'] ?> text-xs font-semibold px-3 py-1 rounded-full"><?= ucfirst(str_replace('_', ' ', $project['status'])) ?></span>
                    </div>

                    <div class="space-y-4 mb-8">
                        <?php if ($project['client_name']): ?>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center"><i class="fa-solid fa-user text-primary-400 text-xs"></i></div>
                            <div><p class="text-dark-500 text-xs">Client</p><p class="text-white text-sm font-medium"><?= sanitize($project['client_name']) ?></p></div>
                        </div>
                        <?php endif; ?>
                        <?php if ($project['location']): ?>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center"><i class="fa-solid fa-location-dot text-primary-400 text-xs"></i></div>
                            <div><p class="text-dark-500 text-xs">Location</p><p class="text-white text-sm font-medium"><?= sanitize($project['location']) ?></p></div>
                        </div>
                        <?php endif; ?>
                        <?php if ($project['budget']): ?>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center"><i class="fa-solid fa-indian-rupee-sign text-primary-400 text-xs"></i></div>
                            <div><p class="text-dark-500 text-xs">Budget</p><p class="text-white text-sm font-medium"><?= sanitize($project['budget']) ?></p></div>
                        </div>
                        <?php endif; ?>
                        <?php if ($project['start_date']): ?>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center"><i class="fa-solid fa-calendar text-primary-400 text-xs"></i></div>
                            <div><p class="text-dark-500 text-xs">Start Date</p><p class="text-white text-sm font-medium"><?= date('M d, Y', strtotime($project['start_date'])) ?></p></div>
                        </div>
                        <?php endif; ?>
                        <?php if ($project['end_date']): ?>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center"><i class="fa-solid fa-calendar-check text-primary-400 text-xs"></i></div>
                            <div><p class="text-dark-500 text-xs">Completion</p><p class="text-white text-sm font-medium"><?= date('M d, Y', strtotime($project['end_date'])) ?></p></div>
                        </div>
                        <?php endif; ?>
                        <?php if ($project['rating'] > 0): ?>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center"><i class="fa-solid fa-star text-primary-400 text-xs"></i></div>
                            <div><p class="text-dark-500 text-xs">Rating</p>
                                <div class="star-rating">
                                    <?php for($s=1;$s<=5;$s++): ?><i class="fa-solid fa-star <?= $s > $project['rating'] ? 'empty' : '' ?> text-xs"></i><?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-3">
                        <a href="<?= SITE_URL ?>/contact.php" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3 rounded-xl font-heading font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all">
                            <i class="fa-solid fa-paper-plane"></i> Inquire About This Project
                        </a>
                        <a href="https://wa.me/<?= SITE_WHATSAPP ?>?text=Hi%2C%20I%20am%20interested%20in%20the%20project%3A%20<?= urlencode($project['title']) ?>" target="_blank" class="w-full inline-flex items-center justify-center gap-2 bg-green-500/10 border border-green-500/20 text-green-400 px-6 py-3 rounded-xl font-heading font-semibold text-sm hover:bg-green-500/20 transition-all">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Projects -->
        <?php if (!empty($related)): ?>
        <div class="mt-20">
            <h2 class="section-title text-2xl sm:text-3xl text-white mb-8" data-aos="fade-up">Related <span class="gradient-text">Projects</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach($related as $rp): ?>
                <a href="<?= SITE_URL ?>/project-detail.php?slug=<?= urlencode($rp['slug']) ?>" class="project-card group" data-aos="fade-up">
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl relative">
                        <?php if ($rp['thumbnail']): ?>
                            <img src="<?= UPLOAD_URL ?>projects/<?= sanitize($rp['thumbnail']) ?>" alt="<?= sanitize($rp['title']) ?>" class="w-full h-full object-cover project-image">
                        <?php else: ?>
                            <div class="w-full h-full bg-dark-800 flex items-center justify-center project-image"><i class="fa-solid fa-building text-4xl text-dark-600"></i></div>
                        <?php endif; ?>
                        <div class="project-overlay"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <h3 class="font-heading font-bold text-white group-hover:text-primary-400 transition-colors"><?= sanitize($rp['title']) ?></h3>
                            <p class="text-dark-400 text-sm"><?= sanitize($rp['location']) ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox-overlay">
    <button id="lightbox-close" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-white/20 transition-colors z-10"><i class="fa-solid fa-xmark"></i></button>
    <img id="lightbox-img" src="" alt="Project Image">
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
