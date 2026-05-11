<?php
/**
 * Admin — Delete Project
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();

$id = intval($_GET['id'] ?? 0);
if (!$id) { redirect(SITE_URL . '/admin/projects/'); }

// Delete associated images from disk
$imgStmt = $pdo->prepare("SELECT image FROM project_images WHERE project_id = :pid");
$imgStmt->execute([':pid' => $id]);
$images = $imgStmt->fetchAll();
foreach ($images as $img) {
    $path = __DIR__ . '/../../assets/uploads/projects/' . $img['image'];
    if (file_exists($path)) { unlink($path); }
}

// Delete project (cascade deletes images from DB)
$stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
$stmt->execute([':id' => $id]);

setFlash('success', 'Project deleted successfully.');
redirect(SITE_URL . '/admin/projects/');
?>
