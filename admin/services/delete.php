<?php
/**
 * Admin — Delete Service
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
verify_csrf_token($_GET['token'] ?? '');

$id = intval($_GET['id'] ?? 0);
if ($id) {
    $stmt = $pdo->prepare("SELECT image FROM services WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $s = $stmt->fetch();
    if ($s && $s['image']) {
        $path = __DIR__ . '/../../assets/uploads/services/' . $s['image'];
        if (file_exists($path)) { unlink($path); }
    }
    $pdo->prepare("DELETE FROM services WHERE id = :id")->execute([':id' => $id]);
    setFlash('success', 'Service deleted.');
}
redirect(SITE_URL . '/admin/services/');
?>
