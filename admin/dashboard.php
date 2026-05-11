<?php
/**
 * Admin Dashboard
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAuth();

$adminPageTitle = 'Dashboard';

// Stats
$totalProjects = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$totalServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$totalNotifs = $pdo->query("SELECT COUNT(*) FROM notifications")->fetchColumn();
$totalContacts = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$unreadContacts = $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
$completedProjects = $pdo->query("SELECT COUNT(*) FROM projects WHERE status = 'completed'")->fetchColumn();
$ongoingProjects = $pdo->query("SELECT COUNT(*) FROM projects WHERE status = 'ongoing'")->fetchColumn();

// Recent projects
$recentProjects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Recent contacts
$recentContacts = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5")->fetchAll();

include __DIR__ . '/includes/admin_header.php';
include __DIR__ . '/includes/admin_sidebar.php';
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="admin-stat-card">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center"><i class="fa-solid fa-building text-blue-400"></i></div>
            <span class="text-xs font-semibold text-green-400 bg-green-500/10 px-2 py-0.5 rounded-full"><?= $ongoingProjects ?> active</span>
        </div>
        <p class="text-2xl font-heading font-bold text-white"><?= $totalProjects ?></p>
        <p class="text-dark-500 text-xs mt-1">Total Projects</p>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center"><i class="fa-solid fa-gear text-primary-400"></i></div>
        </div>
        <p class="text-2xl font-heading font-bold text-white"><?= $totalServices ?></p>
        <p class="text-dark-500 text-xs mt-1">Total Services</p>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center"><i class="fa-solid fa-bell text-purple-400"></i></div>
        </div>
        <p class="text-2xl font-heading font-bold text-white"><?= $totalNotifs ?></p>
        <p class="text-dark-500 text-xs mt-1">Notifications</p>
    </div>
    <div class="admin-stat-card">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center"><i class="fa-solid fa-envelope text-green-400"></i></div>
            <?php if ($unreadContacts > 0): ?>
            <span class="text-xs font-semibold text-primary-400 bg-primary-500/10 px-2 py-0.5 rounded-full"><?= $unreadContacts ?> new</span>
            <?php endif; ?>
        </div>
        <p class="text-2xl font-heading font-bold text-white"><?= $totalContacts ?></p>
        <p class="text-dark-500 text-xs mt-1">Contact Inquiries</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="flex flex-wrap gap-3 mb-8">
    <a href="<?= SITE_URL ?>/admin/projects/add.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-4 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-primary-500/20 transition-all">
        <i class="fa-solid fa-plus"></i> Add Project
    </a>
    <a href="<?= SITE_URL ?>/admin/services/add.php" class="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-white/10 transition-all">
        <i class="fa-solid fa-plus"></i> Add Service
    </a>
    <a href="<?= SITE_URL ?>/admin/notifications/add.php" class="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-white/10 transition-all">
        <i class="fa-solid fa-plus"></i> Add Notification
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Projects -->
    <div class="glass-card overflow-hidden">
        <div class="p-6 border-b border-white/5 flex items-center justify-between">
            <h3 class="font-heading font-bold text-white">Recent Projects</h3>
            <a href="<?= SITE_URL ?>/admin/projects/" class="text-primary-400 text-xs font-semibold hover:text-primary-300">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Title</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach($recentProjects as $p): ?>
                    <tr>
                        <td class="font-medium text-white"><?= sanitize($p['title']) ?></td>
                        <td><span class="badge-<?= $p['status'] ?> text-[11px] font-semibold px-2 py-0.5 rounded-full"><?= ucfirst(str_replace('_',' ',$p['status'])) ?></span></td>
                        <td class="text-dark-500 text-xs"><?= date('M d, Y', strtotime($p['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentProjects)): ?><tr><td colspan="3" class="text-center text-dark-500 py-6">No projects yet</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="glass-card overflow-hidden">
        <div class="p-6 border-b border-white/5 flex items-center justify-between">
            <h3 class="font-heading font-bold text-white">Recent Inquiries</h3>
            <a href="<?= SITE_URL ?>/admin/contacts/" class="text-primary-400 text-xs font-semibold hover:text-primary-300">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead><tr><th>Name</th><th>Phone</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach($recentContacts as $c): ?>
                    <tr>
                        <td class="font-medium <?= $c['is_read'] ? 'text-dark-400' : 'text-white' ?>">
                            <?php if (!$c['is_read']): ?><span class="inline-block w-2 h-2 rounded-full bg-primary-400 mr-2"></span><?php endif; ?>
                            <?= sanitize($c['name']) ?>
                        </td>
                        <td><?= sanitize($c['phone']) ?></td>
                        <td class="text-dark-500 text-xs"><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentContacts)): ?><tr><td colspan="3" class="text-center text-dark-500 py-6">No inquiries yet</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</main></div>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body></html>
