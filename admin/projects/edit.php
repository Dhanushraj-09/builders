<?php
/**
 * Admin — Edit Project
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();

$id = intval($_GET['id'] ?? 0);
if (!$id) { redirect(SITE_URL . '/admin/projects/'); }

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id");
$stmt->execute([':id' => $id]);
$project = $stmt->fetch();
if (!$project) { redirect(SITE_URL . '/admin/projects/'); }

// Existing images
$imgStmt = $pdo->prepare("SELECT * FROM project_images WHERE project_id = :pid ORDER BY sort_order ASC");
$imgStmt->execute([':pid' => $id]);
$existingImages = $imgStmt->fetchAll();

$adminPageTitle = 'Edit Project';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token();
    $title = sanitize($_POST['title'] ?? '');
    $client_name = sanitize($_POST['client_name'] ?? '');
    $location = sanitize($_POST['location'] ?? '');
    $budget = sanitize($_POST['budget'] ?? '');
    $square_feet = sanitize($_POST['square_feet'] ?? '');
    $status = sanitize($_POST['status'] ?? 'upcoming');
    $description = sanitize($_POST['description'] ?? '');
    $testimonial = sanitize($_POST['testimonial'] ?? '');
    $rating = intval($_POST['rating'] ?? 5);
    $video = sanitize($_POST['video'] ?? '');
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $featured = isset($_POST['featured']) ? 1 : 0;

    if (empty($title)) {
        $error = 'Project title is required.';
    } else {
        $stmt = $pdo->prepare("UPDATE projects SET title=:title, client_name=:cn, location=:loc, budget=:budget, square_feet=:sf, status=:status, description=:desc, testimonial=:test, rating=:rating, video=:video, start_date=:sd, end_date=:ed, featured=:feat WHERE id=:id");
        $stmt->execute([
            ':title' => $title, ':cn' => $client_name, ':loc' => $location,
            ':budget' => $budget, ':sf' => $square_feet, ':status' => $status, ':desc' => $description,
            ':test' => $testimonial, ':rating' => $rating, ':video' => $video,
            ':sd' => $start_date ?: null, ':ed' => $end_date ?: null, ':feat' => $featured, ':id' => $id
        ]);

        // Delete selected images
        if (!empty($_POST['delete_images'])) {
            foreach ($_POST['delete_images'] as $delId) {
                $delStmt = $pdo->prepare("SELECT image FROM project_images WHERE id = :id AND project_id = :pid");
                $delStmt->execute([':id' => intval($delId), ':pid' => $id]);
                $delImg = $delStmt->fetch();
                if ($delImg) {
                    $filePath = __DIR__ . '/../../assets/uploads/projects/' . $delImg['image'];
                    if (file_exists($filePath)) { unlink($filePath); }
                    $pdo->prepare("DELETE FROM project_images WHERE id = :id")->execute([':id' => intval($delId)]);
                }
            }
        }

        // New image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = __DIR__ . '/../../assets/uploads/projects/';
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }
            $maxSort = $pdo->prepare("SELECT COALESCE(MAX(sort_order),0) FROM project_images WHERE project_id = :pid");
            $maxSort->execute([':pid' => $id]);
            $sortStart = $maxSort->fetchColumn() + 1;

            foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg','jpeg','png','webp','gif','mp4','webm','mov'])) {
                        $filename = 'project_' . $id . '_' . ($sortStart + $i) . '_' . time() . '.' . $ext;
                        if (move_uploaded_file($tmp, $uploadDir . $filename)) {
                            $imgStmt2 = $pdo->prepare("INSERT INTO project_images (project_id, image, sort_order) VALUES (:pid, :img, :sort)");
                            $imgStmt2->execute([':pid' => $id, ':img' => $filename, ':sort' => $sortStart + $i]);
                        }
                    }
                }
            }
        }

        setFlash('success', 'Project updated successfully!');
        redirect(SITE_URL . '/admin/projects/');
    }
}

include __DIR__ . '/../includes/admin_header.php';
include __DIR__ . '/../includes/admin_sidebar.php';
?>

<a href="<?= SITE_URL ?>/admin/projects/" class="inline-flex items-center gap-2 text-dark-400 text-sm hover:text-white transition-colors mb-6">
    <i class="fa-solid fa-arrow-left text-xs"></i> Back to Projects
</a>

<?php if ($error): ?>
<div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-xl mb-6 flex items-center gap-2 text-sm">
    <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="space-y-6">
    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Project Details</h3>
                <div><label class="form-label">Project Title *</label><input type="text" name="title" class="form-input" value="<?= sanitize($project['title']) ?>" required></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div><label class="form-label">Client Name</label><input type="text" name="client_name" class="form-input" value="<?= sanitize($project['client_name'] ?? '') ?>"></div>
                    <div><label class="form-label">Location</label><input type="text" name="location" class="form-input" value="<?= sanitize($project['location'] ?? '') ?>"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div><label class="form-label">Budget</label><input type="text" name="budget" class="form-input" value="<?= sanitize($project['budget'] ?? '') ?>"></div>
                    <div><label class="form-label">Square Feet</label><input type="text" name="square_feet" class="form-input" value="<?= sanitize($project['square_feet'] ?? '') ?>"></div>
                    <div><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-input" value="<?= $project['start_date'] ?? '' ?>"></div>
                    <div><label class="form-label">End Date</label><input type="date" name="end_date" class="form-input" value="<?= $project['end_date'] ?? '' ?>"></div>
                </div>
                <div><label class="form-label">Description</label><textarea name="description" rows="5" class="form-input"><?= sanitize($project['description'] ?? '') ?></textarea></div>
            </div>

            <!-- Existing Images -->
            <?php if (!empty($existingImages)): ?>
            <div class="glass-card p-6">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3 mb-4">Current Images</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <?php foreach($existingImages as $img): ?>
                    <div class="relative group">
                        <img src="<?= UPLOAD_URL ?>projects/<?= sanitize($img['image']) ?>" class="w-full aspect-square object-cover rounded-xl border border-white/5">
                        <label class="absolute inset-0 bg-red-500/0 group-hover:bg-red-500/30 has-[:checked]:bg-red-900/70 rounded-xl flex items-center justify-center cursor-pointer transition-colors">
                            <input type="checkbox" name="delete_images[]" value="<?= $img['id'] ?>" class="hidden peer">
                            <span class="opacity-0 group-hover:opacity-100 peer-checked:hidden text-white text-sm bg-red-500 px-3 py-1.5 rounded-lg shadow-lg transition-opacity">
                                <i class="fa-solid fa-trash mr-1"></i>Remove
                            </span>
                            <span class="hidden peer-checked:flex items-center text-white text-sm bg-red-600 px-3 py-1.5 rounded-lg shadow-lg border border-red-400">
                                <i class="fa-solid fa-check mr-1"></i>Marked
                            </span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-dark-600 text-xs mt-2">Check images to remove them on save.</p>
            </div>
            <?php endif; ?>

            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Add More Media (Photos & Videos)</h3>
                <div>
                    <input type="file" name="images[]" multiple accept="image/*,video/*" class="form-input file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:bg-primary-500/10 file:text-primary-400 file:text-sm file:font-semibold">
                    <p class="text-dark-600 text-xs mt-1">Accepted: JPG, PNG, WebP, GIF, MP4, WEBM. Max 50MB each. Hold Ctrl/Cmd to select multiple files.</p>
                    <div class="preview flex flex-wrap gap-3 mt-3"></div>
                </div>
                <div><label class="form-label">Video URL</label><input type="text" name="video" class="form-input" value="<?= sanitize($project['video'] ?? '') ?>"></div>
            </div>

            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Client Testimonial</h3>
                <div><textarea name="testimonial" rows="3" class="form-input"><?= sanitize($project['testimonial'] ?? '') ?></textarea></div>
                <div><label class="form-label">Rating</label>
                    <select name="rating" class="form-input">
                        <?php for($r=5;$r>=1;$r--): ?><option value="<?= $r ?>" <?= $project['rating'] == $r ? 'selected' : '' ?>><?= $r ?> Stars</option><?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Publish</h3>
                <div><label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <?php foreach(['upcoming','ongoing','completed','on_hold'] as $s): ?>
                        <option value="<?= $s ?>" <?= $project['status'] == $s ? 'selected' : '' ?>><?= ucfirst(str_replace('_',' ',$s)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="featured" class="w-4 h-4 rounded accent-primary-500" <?= $project['featured'] ? 'checked' : '' ?>>
                    <span class="text-sm text-dark-300">Featured Project</span>
                </label>
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3 rounded-xl font-heading font-bold text-sm hover:shadow-lg hover:shadow-primary-500/20 transition-all">
                    <i class="fa-solid fa-save mr-2"></i> Update Project
                </button>
            </div>
        </div>
    </div>
</form>

</main></div>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body></html>
