<?php
/**
 * Admin — Services List
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
$adminPageTitle = 'Services';
$flash = getFlash();
$services = $pdo->query("SELECT * FROM services ORDER BY sort_order ASC")->fetchAll();
include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>

<?php if ($flash): ?>
<div class="bg-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-500/10 border border-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-500/20 text-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-400 p-3 rounded-xl mb-6 flex items-center gap-2 text-sm">
    <i class="fa-solid fa-<?= $flash['type'] === 'success' ? 'circle-check' : 'circle-exclamation' ?>"></i> <?= $flash['message'] ?>
</div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6">
    <p class="text-dark-400 text-sm"><?= count($services) ?> services</p>
    <a href="<?= SITE_URL ?>/admin/services/add.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-4 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
        <i class="fa-solid fa-plus"></i> Add Service
    </a>
</div>

<div class="glass-card overflow-hidden">
    <table class="admin-table">
        <thead><tr><th>Icon</th><th>Title</th><th>Order</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach($services as $s): ?>
            <tr>
                <td><i class="fa-solid <?= sanitize($s['icon']) ?> text-primary-400"></i></td>
                <td class="font-medium text-white"><?= sanitize($s['title']) ?></td>
                <td class="text-dark-400"><?= $s['sort_order'] ?></td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="<?= SITE_URL ?>/admin/services/edit.php?id=<?= $s['id'] ?>" class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 hover:bg-blue-500/20"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                        <a href="<?= SITE_URL ?>/admin/services/delete.php?id=<?= $s['id'] ?>" onclick="return confirm('Delete this service?')" class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400 hover:bg-red-500/20"><i class="fa-solid fa-trash text-xs"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($services)): ?><tr><td colspan="4" class="text-center text-dark-500 py-8">No services</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

</main></div></body></html>
