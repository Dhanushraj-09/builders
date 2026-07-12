<?php
/**
 * Admin — Add Project
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';
requireAuth();

$adminPageTitle = 'Add Project';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token();
    $title = sanitize($_POST['title'] ?? '');
    $slug = generateSlug($title);
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
        // Check unique slug
        $check = $pdo->prepare("SELECT id FROM projects WHERE slug = :slug");
        $check->execute([':slug' => $slug]);
        if ($check->fetch()) { $slug .= '-' . time(); }

        $stmt = $pdo->prepare("INSERT INTO projects (title, slug, client_name, location, budget, square_feet, status, description, testimonial, rating, video, start_date, end_date, featured) VALUES (:title, :slug, :cn, :loc, :budget, :sf, :status, :desc, :test, :rating, :video, :sd, :ed, :feat)");
        $stmt->execute([
            ':title' => $title, ':slug' => $slug, ':cn' => $client_name, ':loc' => $location,
            ':budget' => $budget, ':sf' => $square_feet, ':status' => $status, ':desc' => $description,
            ':test' => $testimonial, ':rating' => $rating, ':video' => $video,
            ':sd' => $start_date ?: null, ':ed' => $end_date ?: null, ':feat' => $featured
        ]);
        $projectId = $pdo->lastInsertId();

        // Handle media uploads
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = __DIR__ . '/../../assets/uploads/projects/';
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }

            foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg','jpeg','png','webp','gif','mp4','webm','mov'])) {
                        $filename = 'project_' . $projectId . '_' . ($i+1) . '_' . time() . '.' . $ext;
                        if (move_uploaded_file($tmp, $uploadDir . $filename)) {
                            $imgStmt = $pdo->prepare("INSERT INTO project_images (project_id, image, sort_order) VALUES (:pid, :img, :sort)");
                            $imgStmt->execute([':pid' => $projectId, ':img' => $filename, ':sort' => $i]);
                        }
                    }
                }
            }
        }

        setFlash('success', 'Project added successfully!');
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
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Project Details</h3>
                <div>
                    <label class="form-label">Project Title *</label>
                    <input type="text" name="title" class="form-input" placeholder="e.g. Modern Luxury Villa" required>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div><label class="form-label">Client Name</label><input type="text" name="client_name" class="form-input" placeholder="Client name"></div>
                    <div><label class="form-label">Location</label><input type="text" name="location" class="form-input" placeholder="City, State"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div><label class="form-label">Budget</label><input type="text" name="budget" class="form-input" placeholder="e.g. ₹50 Lakhs"></div>
                    <div><label class="form-label">Square Feet</label><input type="text" name="square_feet" class="form-input" placeholder="e.g. 2500"></div>
                    <div><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-input"></div>
                    <div><label class="form-label">End Date</label><input type="date" name="end_date" class="form-input"></div>
                </div>
                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="5" class="form-input" placeholder="Project description..."></textarea>
                </div>
            </div>

            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Media</h3>
                <div>
                    <label class="form-label">Project Media (Photos & Videos)</label>
                    <input type="file" name="images[]" multiple accept="image/*,video/*" class="form-input file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:bg-primary-500/10 file:text-primary-400 file:text-sm file:font-semibold">
                    <p class="text-dark-600 text-xs mt-1">Accepted: JPG, PNG, WebP, GIF, MP4, WEBM. Max 50MB each. Hold Ctrl/Cmd to select multiple files.</p>
                    <div class="preview flex flex-wrap gap-3 mt-3"></div>
                </div>
                <div>
                    <label class="form-label">Video URL (YouTube embed)</label>
                    <input type="text" name="video" class="form-input" placeholder="https://www.youtube.com/embed/...">
                </div>
            </div>

            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Client Testimonial</h3>
                <div>
                    <label class="form-label">Testimonial</label>
                    <textarea name="testimonial" rows="3" class="form-input" placeholder="Client feedback..."></textarea>
                </div>
                <div>
                    <label class="form-label">Rating (1-5)</label>
                    <select name="rating" class="form-input">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="glass-card p-6 space-y-5">
                <h3 class="font-heading font-bold text-white text-lg border-b border-white/5 pb-3">Publish</h3>
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="upcoming">Upcoming</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                        <option value="on_hold">On Hold</option>
                    </select>
                </div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="featured" class="w-4 h-4 rounded accent-primary-500">
                    <span class="text-sm text-dark-300">Featured Project</span>
                </label>
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3 rounded-xl font-heading font-bold text-sm hover:shadow-lg hover:shadow-primary-500/20 transition-all">
                    <i class="fa-solid fa-plus mr-2"></i> Add Project
                </button>
            </div>
        </div>
    </div>
</form>

</main></div>
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>
</body></html>
