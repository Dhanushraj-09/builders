<?php
/**
 * Admin — Delete Notification
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
verify_csrf_token($_GET['token'] ?? '');
$id = intval($_GET['id'] ?? 0);
if ($id) {
    $pdo->prepare("DELETE FROM notifications WHERE id = :id")->execute([':id' => $id]);
    setFlash('success', 'Notification deleted.');
}
redirect(SITE_URL . '/admin/notifications/');
?>
