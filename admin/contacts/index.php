<?php
/**
 * Admin — Contacts / Inquiries List
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
$adminPageTitle = 'Contact Inquiries';
$flash = getFlash();

// Mark as read if requested
if (isset($_GET['read'])) {
    $readId = intval($_GET['read']);
    $pdo->prepare("UPDATE contacts SET is_read = 1 WHERE id = :id")->execute([':id' => $readId]);
    redirect(SITE_URL . '/admin/contacts/');
}

$contacts = $pdo->query("SELECT * FROM contacts ORDER BY is_read ASC, created_at DESC")->fetchAll();
include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>

<?php if ($flash): ?>
<div class="bg-green-500/10 border border-green-500/20 text-green-400 p-3 rounded-xl mb-6 text-sm"><i class="fa-solid fa-circle-check mr-2"></i><?= $flash['message'] ?></div>
<?php endif; ?>

<p class="text-dark-400 text-sm mb-6"><?= count($contacts) ?> total inquiries</p>

<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Type</th><th>Budget</th><th>Location</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach($contacts as $c): ?>
                <tr class="<?= !$c['is_read'] ? 'bg-primary-500/[0.02]' : '' ?>">
                    <td class="font-medium <?= !$c['is_read'] ? 'text-white' : 'text-dark-400' ?>">
                        <?php if (!$c['is_read']): ?><span class="inline-block w-2 h-2 rounded-full bg-primary-400 mr-2"></span><?php endif; ?>
                        <?= sanitize($c['name']) ?>
                    </td>
                    <td><a href="tel:<?= sanitize($c['phone']) ?>" class="text-primary-400 hover:underline"><?= sanitize($c['phone']) ?></a></td>
                    <td class="text-dark-400"><?= sanitize($c['email'] ?? '—') ?></td>
                    <td class="text-dark-400"><?= sanitize($c['construction_type'] ?? '—') ?></td>
                    <td class="text-dark-400"><?= sanitize($c['budget_range'] ?? '—') ?></td>
                    <td class="text-dark-400"><?= sanitize($c['location'] ?? '—') ?></td>
                    <td class="text-dark-500 text-xs whitespace-nowrap"><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                    <td>
                        <div class="flex items-center gap-2">
                            <?php if (!$c['is_read']): ?>
                            <a href="?read=<?= $c['id'] ?>" class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-400 hover:bg-green-500/20" title="Mark as read"><i class="fa-solid fa-check text-xs"></i></a>
                            <?php endif; ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $c['phone']) ?>" target="_blank" class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-400 hover:bg-green-500/20" title="WhatsApp"><i class="fa-brands fa-whatsapp text-xs"></i></a>
                            <a href="<?= SITE_URL ?>/admin/contacts/delete.php?id=<?= $c[&token=<?= generate_csrf_token() ?>'id'] ?>&token=<?= generate_csrf_token() ?>" onclick="return confirm('Delete this inquiry?')" class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400 hover:bg-red-500/20" title="Delete"><i class="fa-solid fa-trash text-xs"></i></a>
                        </div>
                    </td>
                </tr>
                <?php if ($c['message']): ?>
                <tr>
                    <td colspan="8" class="text-dark-500 text-xs italic pl-8 py-2 border-b border-white/3">"<?= sanitize(substr($c['message'], 0, 200)) ?>"</td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php if (empty($contacts)): ?><tr><td colspan="8" class="text-center text-dark-500 py-8">No inquiries yet</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</main></div></body></html>
