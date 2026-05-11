<?php
/**
 * Admin — Edit Notification
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();

$id = intval($_GET['id'] ?? 0);
if (!$id) { redirect(SITE_URL . '/admin/notifications/'); }
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE id = :id");
$stmt->execute([':id' => $id]);
$notif = $stmt->fetch();
if (!$notif) { redirect(SITE_URL . '/admin/notifications/'); }

$adminPageTitle = 'Edit Notification';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = sanitize($_POST['message'] ?? '');
    $status = sanitize($_POST['status'] ?? 'active');
    if (!empty($message)) {
        $pdo->prepare("UPDATE notifications SET message=:m, status=:s WHERE id=:id")->execute([':m'=>$message, ':s'=>$status, ':id'=>$id]);
        setFlash('success', 'Notification updated!');
        redirect(SITE_URL . '/admin/notifications/');
    }
}

include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>
<a href="<?= SITE_URL ?>/admin/notifications/" class="inline-flex items-center gap-2 text-dark-400 text-sm hover:text-white mb-6"><i class="fa-solid fa-arrow-left text-xs"></i> Back</a>

<form method="POST">
    <div class="glass-card p-6 space-y-5 max-w-2xl">
        <div><label class="form-label">Message *</label><input type="text" name="message" class="form-input" value="<?= sanitize($notif['message']) ?>" required></div>
        <div><label class="form-label">Status</label>
            <select name="status" class="form-input">
                <option value="active" <?= $notif['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $notif['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3 rounded-xl font-heading font-bold text-sm"><i class="fa-solid fa-save mr-2"></i>Update</button>
    </div>
</form>
</main></div></body></html>
