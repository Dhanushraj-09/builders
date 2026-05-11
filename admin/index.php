<?php
/**
 * Admin Index — Redirect to login/dashboard
 */
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

if (isLoggedIn()) {
    redirect(SITE_URL . '/admin/dashboard.php');
} else {
    redirect(SITE_URL . '/admin/login.php');
}
?>
