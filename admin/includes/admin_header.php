<?php
/**
 * Admin Header — Layout top section
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($adminPageTitle) ? $adminPageTitle . ' | Admin' : 'Admin Panel' ?> — <?= SITE_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: { primary: { 50:'#fffbeb',100:'#fef3c7',200:'#fde68a',300:'#fcd34d',400:'#fbbf24',500:'#f59e0b',600:'#d97706',700:'#b45309',800:'#92400e',900:'#78350f' }, dark: { 50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#020617' } },
                fontFamily: { heading: ['Outfit','sans-serif'], body: ['Inter','sans-serif'] }
            }}
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
    <style>
        .admin-sidebar { width: 260px; transition: transform 0.3s ease; }
        .admin-content { margin-left: 260px; transition: margin-left 0.3s ease; }
        @media (max-width: 1024px) {
            .admin-sidebar { transform: translateX(-100%); position: fixed; z-index: 50; }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-content { margin-left: 0; }
        }
        .admin-nav-link { display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.75rem; font-size:0.8125rem; font-weight:500; color:#94a3b8; transition:all 0.2s ease; }
        .admin-nav-link:hover { background:rgba(255,255,255,0.05); color:#fff; }
        .admin-nav-link.active { background:rgba(245,158,11,0.1); color:#fbbf24; border:1px solid rgba(245,158,11,0.15); }
        .admin-stat-card { background:rgba(30,41,59,0.5); backdrop-filter:blur(20px); border:1px solid rgba(255,255,255,0.05); border-radius:1rem; padding:1.5rem; transition:all 0.3s ease; }
        .admin-stat-card:hover { border-color:rgba(245,158,11,0.2); transform:translateY(-2px); }
        .admin-table { width:100%; border-collapse:separate; border-spacing:0; }
        .admin-table th { padding:0.75rem 1rem; text-align:left; font-size:0.75rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; border-bottom:1px solid rgba(255,255,255,0.05); }
        .admin-table td { padding:0.75rem 1rem; font-size:0.8125rem; color:#cbd5e1; border-bottom:1px solid rgba(255,255,255,0.03); }
        .admin-table tr:hover td { background:rgba(255,255,255,0.02); }
    </style>
</head>
<body class="bg-dark-950 text-white font-body antialiased">
    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>
