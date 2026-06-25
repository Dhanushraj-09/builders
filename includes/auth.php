<?php
/**
 * Authentication Helper
 * CELTA Builders Website
 */

session_start();

/**
 * Check if admin is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Require admin authentication — redirect to login if not authenticated
 */
function requireAuth() {
    if (!isLoggedIn()) {
        redirect(SITE_URL . '/admin/login.php');
    }
}

/**
 * Login admin
 */
function loginAdmin($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT id, username, password FROM admins WHERE username = :username LIMIT 1");
    $stmt->execute([':username' => $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        return true;
    }
    return false;
}

/**
 * Logout admin
 */
function logoutAdmin() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

/**
 * Get current admin username
 */
function getAdminUsername() {
    return $_SESSION['admin_username'] ?? 'Admin';
}
?>
