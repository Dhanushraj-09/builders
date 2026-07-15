<?php
/**
 * Database Connection
 * CELTA Builders Website
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'builder_company_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Site Configuration
define('SITE_NAME', 'CELTA Builders');
define('SITE_TAGLINE', 'Building Dreams Into Reality');
define('SITE_PHONE', '+91 95145 44444');
define('SITE_WHATSAPP', '919514544444');
define('SITE_EMAIL', 'celtabuilders@gmail.com');
define('SITE_ADDRESS', 'Convent complex ,Bypass road, Srivilliputhur ..<br> Manicka vinayagar colony Retta palam bus stop (Opp) Sivakasi , Virudhunagar District, Tamil Nadu - 626125');
define('SITE_INSTAGRAM', 'https://www.instagram.com/celta_builders?igsh=MWR1cTV1ZmlqeDNrdA==');
define('SITE_URL', 'http://localhost/builders');

// Upload paths
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/uploads/');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/**
 * Helper: Sanitize input
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Helper: Generate slug from string
 */
function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * Helper: Redirect
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Helper: Flash message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
?>
