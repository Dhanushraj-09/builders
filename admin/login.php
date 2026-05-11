<?php
/**
 * Admin Login Page
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if (isLoggedIn()) { redirect(SITE_URL . '/admin/dashboard.php'); }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (loginAdmin($pdo, $username, $password)) {
        redirect(SITE_URL . '/admin/dashboard.php');
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= SITE_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: { primary: { 400:'#fbbf24', 500:'#f59e0b', 600:'#d97706' }, dark: { 800:'#1e293b', 900:'#0f172a', 950:'#020617' } },
                fontFamily: { heading: ['Outfit','sans-serif'], body: ['Inter','sans-serif'] }
            }}
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body class="bg-dark-950 font-body antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto bg-gradient-to-br from-primary-400 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/25 mb-4">
                <i class="fa-solid fa-helmet-safety text-dark-950 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-heading font-bold text-white"><?= SITE_NAME ?></h1>
            <p class="text-dark-400 text-sm mt-1">Admin Panel</p>
        </div>

        <!-- Login Form -->
        <div class="glass-card p-8 md:p-10">
            <h2 class="font-heading font-bold text-white text-xl mb-2">Welcome Back</h2>
            <p class="text-dark-400 text-sm mb-8">Sign in to manage your website.</p>

            <?php if ($error): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-xl mb-6 flex items-center gap-2 text-sm">
                <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div>
                    <label class="form-label">Username</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-dark-500"><i class="fa-solid fa-user text-sm"></i></span>
                        <input type="text" name="username" class="form-input pl-10" placeholder="Enter username" required autofocus>
                    </div>
                </div>
                <div>
                    <label class="form-label">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-dark-500"><i class="fa-solid fa-lock text-sm"></i></span>
                        <input type="password" name="password" class="form-input pl-10" placeholder="Enter password" required>
                    </div>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-6 py-3.5 rounded-xl font-heading font-bold hover:shadow-lg hover:shadow-primary-500/30 transition-all">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-dark-600 text-xs mt-6">&copy; <?= date('Y') ?> <?= SITE_NAME ?></p>
    </div>
</body>
</html>
