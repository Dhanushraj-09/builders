<?php
/**
 * Admin — Delete Contact
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
$id = intval($_GET['id'] ?? 0);
if ($id) {
    $pdo->prepare("DELETE FROM contacts WHERE id = :id")->execute([':id' => $id]);
    setFlash('success', 'Inquiry deleted.');
}
redirect(SITE_URL . '/admin/contacts/');
?>
