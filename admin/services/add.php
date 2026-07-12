<?php
/**
 * Admin — Add Service
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();
$adminPageTitle = 'Add Service';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token();
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $icon = sanitize($_POST['icon'] ?? 'fa-building');
    $sort_order = intval($_POST['sort_order'] ?? 0);
    $image = null;

    if (empty($title)) { $error = 'Service title is required.'; }
    else {
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/uploads/services/';
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','webp','gif'])) {
                $image = 'service_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
            }
        }
        $stmt = $pdo->prepare("INSERT INTO services (title, description, icon, image, sort_order) VALUES (:t, :d, :i, :img, :s)");
        $stmt->execute([':t'=>$title, ':d'=>$description, ':i'=>$icon, ':img'=>$image, ':s'=>$sort_order]);
        setFlash('success', 'Service added!');
        redirect(SITE_URL . '/admin/services/');
    }
}

include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>
<a href="<?= SITE_URL ?>/admin/services/" class="inline-flex items-center gap-2 text-dark-400 text-sm hover:text-white mb-6"><i class="fa-solid fa-arrow-left text-xs"></i> Back</a>

<?php if ($error): ?><div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-xl mb-6 text-sm"><i class="fa-solid fa-circle-exclamation mr-2"></i><?= $error ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    <div class="glass-card p-6 space-y-5 max-w-2xl">
        <div><label class="form-label">Title *</label><input type="text" name="title" class="form-input" required></div>
        <div><label class="form-label">Description</label><textarea name="description" rows="4" class="form-input"></textarea></div>
        <div class="grid grid-cols-2 gap-5">
            <div><label class="form-label">Font Awesome Icon</label><input type="text" name="icon" class="form-input" value="fa-building" placeholder="fa-building"></div>
            <div><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-input" value="0"></div>
        </div>
        <div><label class="form-label">Image</label><input type="file" name="image" accept="image/*" class="form-input file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:bg-primary-500/10 file:text-primary-400 file:text-sm file:font-semibold"></div>
        <button type="submit" class="bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3 rounded-xl font-heading font-bold text-sm"><i class="fa-solid fa-plus mr-2"></i>Add Service</button>
    </div>
</form>
</main></div></body></html>
