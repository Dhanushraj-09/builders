<?php
/**
 * Admin — Projects List
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();

$adminPageTitle = 'Projects';
$flash = getFlash();

$projects = $pdo->query("SELECT p.*, (SELECT COUNT(*) FROM project_images WHERE project_id = p.id) as image_count FROM projects p ORDER BY p.created_at DESC")->fetchAll();

include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>

<?php if ($flash): ?>
<div class="bg-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-500/10 border border-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-500/20 text-<?= $flash['type'] === 'success' ? 'green' : 'red' ?>-400 p-3 rounded-xl mb-6 flex items-center gap-2 text-sm">
    <i class="fa-solid fa-<?= $flash['type'] === 'success' ? 'circle-check' : 'circle-exclamation' ?>"></i> <?= $flash['message'] ?>
</div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6">
    <p class="text-dark-400 text-sm"><?= count($projects) ?> projects total</p>
    <a href="<?= SITE_URL ?>/admin/projects/add.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-4 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-primary-500/20 transition-all">
        <i class="fa-solid fa-plus"></i> Add Project
    </a>
</div>

<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr><th>Title</th><th>Client</th><th>Location</th><th>Status</th><th>Images</th><th>Featured</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach($projects as $p): ?>
                <tr>
                    <td class="font-medium text-white"><?= sanitize($p['title']) ?></td>
                    <td><?= sanitize($p['client_name'] ?? '—') ?></td>
                    <td class="text-dark-400"><?= sanitize($p['location'] ?? '—') ?></td>
                    <td><span class="badge-<?= $p['status'] ?> text-[11px] font-semibold px-2 py-0.5 rounded-full"><?= ucfirst(str_replace('_',' ',$p['status'])) ?></span></td>
                    <td class="text-dark-400"><?= $p['image_count'] ?></td>
                    <td><?= $p['featured'] ? '<i class="fa-solid fa-star text-primary-400 text-xs"></i>' : '<i class="fa-solid fa-star text-dark-700 text-xs"></i>' ?></td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="<?= SITE_URL ?>/admin/projects/edit.php?id=<?= $p['id'] ?>" class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 hover:bg-blue-500/20 transition-colors" title="Edit"><i class="fa-solid fa-pen-to-square text-xs"></i></a>
                            <a href="<?= SITE_URL ?>/admin/projects/delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this project?')" class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400 hover:bg-red-500/20 transition-colors" title="Delete"><i class="fa-solid fa-trash text-xs"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($projects)): ?><tr><td colspan="7" class="text-center text-dark-500 py-8">No projects found. <a href="<?= SITE_URL ?>/admin/projects/add.php" class="text-primary-400">Add your first project</a></td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</main></div>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body></html>
