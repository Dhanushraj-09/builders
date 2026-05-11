<?php
/**
 * Admin — Notifications List
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
$adminPageTitle = 'Notifications';
$flash = getFlash();
$notifications = $pdo->query("SELECT * FROM notifications ORDER BY created_at DESC")->fetchAll();
include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>

<?php if ($flash): ?>
<div class="bg-green-500/10 border border-green-500/20 text-green-400 p-3 rounded-xl mb-6 text-sm"><i class="fa-solid fa-circle-check mr-2"></i><?= $flash['message'] ?></div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6">
    <p class="text-dark-400 text-sm"><?= count($notifications) ?> notifications</p>
    <a href="<?= SITE_URL ?>/admin/notifications/add.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-4 py-2.5 rounded-xl text-sm font-semibold"><i class="fa-solid fa-plus"></i> Add Notification</a>
</div>

<div class="glass-card overflow-hidden">
    <table class="admin-table">
        <thead><tr><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach($notifications as $n): ?>
            <tr>
                <td class="text-white max-w-md truncate"><?= sanitize($n['message']) ?></td>
                <td>
                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full <?= $n['status'] === 'active' ? 'bg-green-500/15 text-green-400 border border-green-500/20' : 'bg-dark-700 text-dark-400 border border-white/5' ?>">
                        <?= ucfirst($n['status']) ?>
                    </span>
                </td>
                <td class="text-dark-500 text-xs"><?= date('M d, Y', strtotime($n['created_at'])) ?></td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="<?= SITE_URL ?>/admin/notifications/edit.php?id=<?= $n['id'] ?>" class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 hover:bg-blue-500/20"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                        <a href="<?= SITE_URL ?>/admin/notifications/delete.php?id=<?= $n['id'] ?>" onclick="return confirm('Delete?')" class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400 hover:bg-red-500/20"><i class="fa-solid fa-trash text-xs"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($notifications)): ?><tr><td colspan="4" class="text-center text-dark-500 py-8">No notifications</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
</main></div></body></html>
