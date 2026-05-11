<?php
/**
 * Admin — Edit Service
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();

$id = intval($_GET['id'] ?? 0);
if (!$id) { redirect(SITE_URL . '/admin/services/'); }
$stmt = $pdo->prepare("SELECT * FROM services WHERE id = :id");
$stmt->execute([':id' => $id]);
$service = $stmt->fetch();
if (!$service) { redirect(SITE_URL . '/admin/services/'); }

$adminPageTitle = 'Edit Service';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $icon = sanitize($_POST['icon'] ?? 'fa-building');
    $sort_order = intval($_POST['sort_order'] ?? 0);
    $image = $service['image'];

    if (empty($title)) { $error = 'Title is required.'; }
    else {
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/uploads/services/';
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
            // Delete old image
            if ($image && file_exists($uploadDir . $image)) { unlink($uploadDir . $image); }
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','webp','gif'])) {
                $image = 'service_' . $id . '_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
            }
        }
        $stmt = $pdo->prepare("UPDATE services SET title=:t, description=:d, icon=:i, image=:img, sort_order=:s WHERE id=:id");
        $stmt->execute([':t'=>$title, ':d'=>$description, ':i'=>$icon, ':img'=>$image, ':s'=>$sort_order, ':id'=>$id]);
        setFlash('success', 'Service updated!');
        redirect(SITE_URL . '/admin/services/');
    }
}

include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>
<a href="<?= SITE_URL ?>/admin/services/" class="inline-flex items-center gap-2 text-dark-400 text-sm hover:text-white mb-6"><i class="fa-solid fa-arrow-left text-xs"></i> Back</a>

<?php if ($error): ?><div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-xl mb-6 text-sm"><?= $error ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="glass-card p-6 space-y-5 max-w-2xl">
        <div><label class="form-label">Title *</label><input type="text" name="title" class="form-input" value="<?= sanitize($service['title']) ?>" required></div>
        <div><label class="form-label">Description</label><textarea name="description" rows="4" class="form-input"><?= sanitize($service['description'] ?? '') ?></textarea></div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Icon</label><input type="text" name="icon" class="form-input" value="<?= sanitize($service['icon']) ?>"></div>
            <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="<?= $service['sort_order'] ?>"></div>
        </div>
        <?php if ($service['image']): ?>
        <div><label class="form-label">Current Image</label><img src="<?= UPLOAD_URL ?>services/<?= sanitize($service['image']) ?>" class="w-32 h-24 object-cover rounded-xl border border-white/10"></div>
        <?php endif; ?>
        <div><label class="form-label">New Image</label><input type="file" name="image" accept="image/*" class="form-input file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:bg-primary-500/10 file:text-primary-400 file:text-sm file:font-semibold"></div>
        <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3 rounded-xl font-heading font-bold text-sm"><i class="fa-solid fa-save mr-2"></i>Update</button>
    </div>
</form>
</main></div></body></html>
