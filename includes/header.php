<?php
/**
 * Frontend Header
 * CELTA Builders Website
 */
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Meta Tags -->
    <title><?= isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME . ' - ' . SITE_TAGLINE ?></title>
    <meta name="description" content="<?= isset($pageDescription) ? $pageDescription : 'Premium construction company in Srivilliputhur, Tamil Nadu. Expert builders for residential, commercial, interior works & renovation. Quality construction with modern designs.' ?>">
    <meta name="keywords" content="builder, construction company, Srivilliputhur, Sivakasi, Virudhunagar, Madurai, house construction, commercial building, interior works, renovation, villa construction">
    <meta name="author" content="<?= SITE_NAME ?>">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?= isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME ?>">
    <meta property="og:description" content="<?= isset($pageDescription) ? $pageDescription : 'Premium construction company delivering dream homes and commercial buildings with modern designs and quality craftsmanship.' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= SITE_URL ?>">
    <meta property="og:image" content="<?= SITE_URL ?>/assets/images/og-image.jpg">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= SITE_URL ?>/assets/images/logo.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#fffbeb', 100:'#fef3c7', 200:'#fde68a', 300:'#fcd34d', 400:'#fbbf24', 500:'#f59e0b', 600:'#d97706', 700:'#b45309', 800:'#92400e', 900:'#78350f' },
                        dark: { 50:'#f8fafc', 100:'#f1f5f9', 200:'#e2e8f0', 300:'#cbd5e1', 400:'#94a3b8', 500:'#64748b', 600:'#475569', 700:'#334155', 800:'#1e293b', 900:'#0f172a', 950:'#020617' }
                    },
                    fontFamily: {
                        heading: ['Outfit', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css?v=<?= time() ?>">
</head>
<body class="bg-dark-950 text-white font-body antialiased">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-dark-950">
        <div class="preloader-content text-center flex flex-col items-center">
            <div class="house-builder-loader mb-6">
                <div class="roof"></div>
                <div class="walls">
                    <div class="window"></div>
                    <div class="door"></div>
                </div>
            </div>
            <p class="text-primary-400 font-heading text-lg tracking-wider animate-pulse"><?= SITE_NAME ?></p>
        </div>
    </div>
