<?php
/**
 * Navigation Bar
 * CELTA Builders Website
 */

$notifStmt = $pdo->query("SELECT message FROM notifications WHERE status = 'active' ORDER BY created_at DESC");
$activeNotifs = $notifStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<?php if (!empty($activeNotifs)): ?>
<!-- ═══════════════ NOTIFICATION TOPBAR ═══════════════ -->
<div class="fixed top-0 left-0 right-0 z-[999] h-10 topbar-inner flex items-center overflow-hidden">
    <div class="flex whitespace-nowrap notification-track w-max text-sm font-medium text-primary-400">
        <?php 
        // Create a single string of notifications separated by a dot or space
        $notifString = implode(' &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp; ', $activeNotifs);
        ?>
        <div class="px-8"><?= $notifString ?></div>
        <div class="px-8"><?= $notifString ?></div>
    </div>
</div>
<?php endif; ?>

<!-- ═══════════════ MAIN NAVIGATION ═══════════════ -->
<nav id="navbar" class="fixed left-0 right-0 z-[998] transition-all duration-300" style="top: <?= !empty($activeNotifs) ? '40px' : '0' ?>;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 <?= !empty($activeNotifs) ? 'pt-2' : 'pt-4' ?>">
        <div class="navbar-glass bg-dark-950/60 backdrop-blur-2xl border border-white/5 rounded-2xl px-6 py-3 flex items-center justify-between transition-all duration-300">
            
            <!-- Logo -->
            <a href="<?= SITE_URL ?>" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25 group-hover:shadow-primary-500/40 transition-shadow">
                    <i class="fa-solid fa-helmet-safety text-dark-950 text-lg"></i>
                </div>
                <div>
                    <span class="text-lg font-heading font-bold text-white"><?= SITE_NAME ?></span>
                    <span class="hidden sm:block text-[10px] text-primary-400 tracking-widest uppercase">We Understand Your Dream</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <div class="hidden lg:flex items-center gap-1">
                <a href="<?= SITE_URL ?>/index.php" class="nav-link <?= $currentPage === 'index' ? 'nav-active' : '' ?>">Home</a>
                <a href="<?= SITE_URL ?>/about.php" class="nav-link <?= $currentPage === 'about' ? 'nav-active' : '' ?>">About</a>
                <a href="<?= SITE_URL ?>/services.php" class="nav-link <?= $currentPage === 'services' ? 'nav-active' : '' ?>">Services</a>
                <a href="<?= SITE_URL ?>/projects.php" class="nav-link <?= $currentPage === 'projects' || $currentPage === 'project-detail' ? 'nav-active' : '' ?>">Projects</a>
                <a href="<?= SITE_URL ?>/contact.php" class="nav-link <?= $currentPage === 'contact' ? 'nav-active' : '' ?>">Contact</a>
            </div>

            <!-- Mobile Toggle -->
            <button id="mobile-toggle" class="lg:hidden w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition-all" aria-label="Toggle menu">
                <i id="menu-icon" class="fa-solid fa-bars text-lg"></i>
            </button>

        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden mt-2 bg-dark-950/95 backdrop-blur-2xl border border-white/5 rounded-2xl p-4 transition-all">
            <a href="<?= SITE_URL ?>/index.php" class="mobile-nav-link <?= $currentPage === 'index' ? 'mobile-nav-active' : '' ?>">
                <i class="fa-solid fa-house text-primary-500/60 w-5 text-center"></i> Home
            </a>
            <a href="<?= SITE_URL ?>/about.php" class="mobile-nav-link <?= $currentPage === 'about' ? 'mobile-nav-active' : '' ?>">
                <i class="fa-solid fa-building-columns text-primary-500/60 w-5 text-center"></i> About Us
            </a>
            <a href="<?= SITE_URL ?>/services.php" class="mobile-nav-link <?= $currentPage === 'services' ? 'mobile-nav-active' : '' ?>">
                <i class="fa-solid fa-gear text-primary-500/60 w-5 text-center"></i> Services
            </a>
            <a href="<?= SITE_URL ?>/projects.php" class="mobile-nav-link <?= $currentPage === 'projects' || $currentPage === 'project-detail' ? 'mobile-nav-active' : '' ?>">
                <i class="fa-solid fa-images text-primary-500/60 w-5 text-center"></i> Projects
            </a>
            <a href="<?= SITE_URL ?>/contact.php" class="mobile-nav-link <?= $currentPage === 'contact' ? 'mobile-nav-active' : '' ?>">
                <i class="fa-solid fa-paper-plane text-primary-500/60 w-5 text-center"></i> Contact Us
            </a>
        </div>
    </div>
</nav>
