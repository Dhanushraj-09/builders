<?php
/**
 * Admin — Add Notification
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
$adminPageTitle = 'Add Notification';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = sanitize($_POST['message'] ?? '');
    $status = sanitize($_POST['status'] ?? 'active');
    if (!empty($message)) {
        $pdo->prepare("INSERT INTO notifications (message, status) VALUES (:m, :s)")->execute([':m'=>$message, ':s'=>$status]);
        setFlash('success', 'Notification added!');
        redirect(SITE_URL . '/admin/notifications/');
    }
}

include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>
<a href="<?= SITE_URL ?>/admin/notifications/" class="inline-flex items-center gap-2 text-dark-400 text-sm hover:text-white mb-6"><i class="fa-solid fa-arrow-left text-xs"></i> Back</a>

<form method="POST">
    <div class="glass-card p-6 space-y-5 max-w-2xl">
        <div><label class="form-label">Message *</label><input type="text" name="message" class="form-input" placeholder="🏗️ New project launched!" required></div>
        <div><label class="form-label">Status</label>
            <select name="status" class="form-input"><option value="active">Active</option><option value="inactive">Inactive</option></select>
        </div>
        <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3 rounded-xl font-heading font-bold text-sm"><i class="fa-solid fa-plus mr-2"></i>Add</button>
    </div>
</form>
</main></div></body></html>
