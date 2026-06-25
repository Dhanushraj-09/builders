<?php
/**
 * Projects Page — CELTA Builders
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$pageTitle = 'Our Projects';
$pageDescription = 'Explore our portfolio of completed and ongoing construction projects — residential, commercial, and interior works across Tamil Nadu.';

$projectsStmt = $pdo->query("SELECT p.*, (SELECT image FROM project_images WHERE project_id = p.id ORDER BY sort_order ASC LIMIT 1) as thumbnail FROM projects p ORDER BY p.created_at DESC");
$projects = $projectsStmt->fetchAll();

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- Page Header -->
<section class="pt-32 pb-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary-500/5 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center" data-aos="fade-up">

            <h1 class="section-title text-4xl sm:text-5xl md:text-6xl text-white mt-4 mb-4">
                Our <span class="gradient-text">Projects</span>
            </h1>
            <p class="text-dark-400 max-w-2xl mx-auto text-lg">Showcasing our finest construction work — from luxury villas to commercial complexes.</p>
        </div>
    </div>
</section>

<!-- Filter + Projects Grid -->
<section class="py-12 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-3 mb-12" data-aos="fade-up">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <button class="filter-btn" data-filter="completed">Completed</button>
            <button class="filter-btn" data-filter="ongoing">Ongoing</button>
            <button class="filter-btn" data-filter="upcoming">Upcoming</button>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($projects as $i => $project): ?>
            <div class="project-filter-item" data-status="<?= $project['status'] ?>" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
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
                            <div class="w-full h-full bg-gradient-to-br from-dark-800 to-dark-900 flex items-center justify-center project-image">
                                <i class="fa-solid fa-building text-5xl text-dark-600"></i>
                            </div>
                        <?php endif; ?>
                        <div class="project-overlay"></div>

                        <!-- Badges Container -->
                        <div class="absolute top-4 left-4 right-4 flex items-start justify-between gap-2 pointer-events-none z-10">
                            <!-- Status Badge -->
                            <span class="badge-<?= $project['status'] ?> text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                <?= ucfirst(str_replace('_', ' ', $project['status'])) ?>
                            </span>

                            <!-- Rating -->
                            <?php if ($project['rating'] > 0): ?>
                            <span class="bg-dark-900/80 backdrop-blur text-primary-400 text-xs font-semibold px-2 py-1 rounded-lg flex items-center gap-1 shadow-lg">
                                <i class="fa-solid fa-star text-[10px]"></i> <?= $project['rating'] ?>.0
                            </span>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="font-heading font-bold text-white text-lg mb-2 group-hover:text-primary-400 transition-colors"><?= sanitize($project['title']) ?></h3>
                            <div class="flex items-center justify-between">
                                <p class="text-dark-400 text-sm flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot text-primary-500 text-xs"></i>
                                    <?= sanitize($project['location']) ?>
                                </p>
                                <?php if ($project['budget']): ?>
                                <span class="text-primary-400 text-xs font-semibold"><?= sanitize($project['budget']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($projects)): ?>
        <div class="text-center py-20">
            <i class="fa-solid fa-folder-open text-5xl text-dark-600 mb-4"></i>
            <p class="text-dark-400 text-lg">No projects found. Check back soon!</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
