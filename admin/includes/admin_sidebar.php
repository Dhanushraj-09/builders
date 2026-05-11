<?php
/**
 * Admin Sidebar Navigation
 */
$adminPage = basename($_SERVER['PHP_SELF'], '.php');
$adminDir = basename(dirname($_SERVER['PHP_SELF']));
?>

<!-- Sidebar -->
<aside id="admin-sidebar" class="admin-sidebar fixed top-0 left-0 h-full bg-dark-900/95 backdrop-blur-xl border-r border-white/5 flex flex-col z-50">
    <!-- Logo -->
    <div class="p-6 border-b border-white/5">
        <a href="<?= SITE_URL ?>/admin/dashboard.php" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                <i class="fa-solid fa-helmet-safety text-dark-950 text-lg"></i>
            </div>
            <div>
                <span class="text-base font-heading font-bold text-white">Admin Panel</span>
                <span class="block text-[10px] text-primary-400 tracking-wider">MANAGEMENT</span>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <p class="text-dark-600 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2 mt-2">Main</p>
        <a href="<?= SITE_URL ?>/admin/dashboard.php" class="admin-nav-link <?= $adminPage == 'dashboard' ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
        </a>

        <p class="text-dark-600 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2 mt-6">Content</p>
        <a href="<?= SITE_URL ?>/admin/projects/" class="admin-nav-link <?= $adminDir == 'projects' ? 'active' : '' ?>">
            <i class="fa-solid fa-images w-5 text-center"></i> Projects
        </a>
        <a href="<?= SITE_URL ?>/admin/services/" class="admin-nav-link <?= $adminDir == 'services' ? 'active' : '' ?>">
            <i class="fa-solid fa-gear w-5 text-center"></i> Services
        </a>
        <a href="<?= SITE_URL ?>/admin/notifications/" class="admin-nav-link <?= $adminDir == 'notifications' ? 'active' : '' ?>">
            <i class="fa-solid fa-bell w-5 text-center"></i> Notifications
        </a>

        <p class="text-dark-600 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2 mt-6">Inquiries</p>
        <a href="<?= SITE_URL ?>/admin/contacts/" class="admin-nav-link <?= $adminDir == 'contacts' ? 'active' : '' ?>">
            <i class="fa-solid fa-envelope w-5 text-center"></i> Contacts
        </a>
    </nav>

    <!-- Bottom -->
    <div class="p-4 border-t border-white/5">
        <a href="<?= SITE_URL ?>" target="_blank" class="admin-nav-link text-dark-500 hover:text-primary-400">
            <i class="fa-solid fa-globe w-5 text-center"></i> View Website
        </a>
        <a href="<?= SITE_URL ?>/admin/logout.php" class="admin-nav-link text-red-400/60 hover:text-red-400 hover:bg-red-500/5">
            <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Logout
        </a>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="admin-content min-h-screen">
    <!-- Top Bar -->
    <header class="sticky top-0 z-30 bg-dark-950/80 backdrop-blur-xl border-b border-white/5 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="lg:hidden w-9 h-9 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="font-heading font-bold text-white text-lg"><?= $adminPageTitle ?? 'Dashboard' ?></h1>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-dark-400 text-sm hidden sm:block">Welcome, <strong class="text-white"><?= getAdminUsername() ?></strong></span>
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-dark-950 font-bold text-sm">
                <?= strtoupper(substr(getAdminUsername(), 0, 1)) ?>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="p-6">

<script>
function toggleSidebar() {
    document.getElementById('admin-sidebar').classList.toggle('open');
    document.getElementById('sidebar-overlay').classList.toggle('hidden');
}
</script>
