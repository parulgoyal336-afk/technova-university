<?php
session_start();
require_once 'db.php';

// Dynamically determine the base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . "://" . $host . "/jpr/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart College Management System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path fill='%23D4AF37' d='M243.4 2.6l-224 96c-14 6-19.4 23.6-12.7 37.4 5.4 11 17.4 17.4 29.8 15.3l20.1-3.4c10.4-1.8 20.9 4.9 23.4 15.1l32 128c2.5 10.2 13 16.9 23.4 15.1l32-5.4c10.4-1.8 17.1-12.3 15.3-22.7l-32-128c-1.8-10.4-12.3-17.1-22.7-15.3l-20.1 3.4c-4.1.7-8.2-1.5-10-5.3-2.3-4.6-.4-10.4 4.2-12.4l224-96c14-6 19.4-23.6 12.7-37.4-5.4-11-17.4-17.4-29.8-15.3z'/><path fill='%23D4AF37' d='M448 416c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32s14.3-32 32-32h320c17.7 0 32 14.3 32 32zM256 128c-17.7 0-32 14.3-32 32v192c0 17.7 14.3 32 32 32s32-14.3 32-32V160c0-17.7-14.3-32-32-32zm-128 32c-17.7 0-32 14.3-32 32v160c0 17.7 14.3 32 32 32s32-14.3 32-32V192c0-17.7-14.3-32-32-32zm256 0c-17.7 0-32 14.3-32 32v160c0 17.7 14.3 32 32 32s32-14.3 32-32V192c0-17.7-14.3-32-32-32zM480 480c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32s14.3-32 32-32h384c17.7 0 32 14.3 32 32z'/></svg>">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
    <!-- Mobile App Manifest -->
    <link rel="manifest" href="<?php echo $base_url; ?>manifest.json">
    <meta name="theme-color" content="#D4AF37">
    <link rel="apple-touch-icon" href="<?php echo $base_url; ?>assets/images/logo-192.png">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo $base_url; ?>index.php" class="logo">
                <i class="fas fa-university"></i> TECHNOVA
            </a>
            <div class="left-dropdown">
                <button class="left-dropbtn">Explore <i class="fas fa-th-large"></i></button>
                <div class="left-dropdown-content">
                    <a href="<?php echo $base_url; ?>pages/admissions.php"><i class="fas fa-user-graduate"></i> Admissions</a>
                    <a href="<?php echo $base_url; ?>pages/scholarships.php"><i class="fas fa-hand-holding-usd"></i> Scholarships</a>
                    <a href="<?php echo $base_url; ?>pages/about.php#campus-life"><i class="fas fa-university"></i> Campus Life</a>
                    <a href="<?php echo $base_url; ?>pages/library.php"><i class="fas fa-book"></i> Library</a>
                    <a href="<?php echo $base_url; ?>pages/research.php"><i class="fas fa-flask"></i> Research</a>
                </div>
            </div>
            <ul class="nav-links">
                <div class="mobile-menu-header">
                    <span class="logo"><i class="fas fa-university"></i> TECHNOVA</span>
                </div>
                <li class="mobile-only-dropdown dropdown">
                    <a href="#" class="dropbtn">Explore <i class="fas fa-th-large" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                    <div class="dropdown-content">
                        <a href="<?php echo $base_url; ?>pages/admissions.php"><i class="fas fa-user-graduate"></i> Admissions</a>
                        <a href="<?php echo $base_url; ?>pages/scholarships.php"><i class="fas fa-hand-holding-usd"></i> Scholarships</a>
                        <a href="<?php echo $base_url; ?>pages/about.php#campus-life"><i class="fas fa-university"></i> Campus Life</a>
                        <a href="<?php echo $base_url; ?>pages/library.php"><i class="fas fa-book"></i> Library</a>
                        <a href="<?php echo $base_url; ?>pages/research.php"><i class="fas fa-flask"></i> Research</a>
                    </div>
                </li>
                <li><a href="<?php echo $base_url; ?>index.php">Home</a></li>
                <li><a href="<?php echo $base_url; ?>pages/about.php">About</a></li>
                <li class="dropdown">
                    <a href="<?php echo $base_url; ?>pages/courses.php" class="dropbtn">Courses <i class="fas fa-chevron-down" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                    <div class="dropdown-content">
                        <a href="<?php echo $base_url; ?>pages/courses.php?filter=ug#course-grid">Undergraduate</a>
                        <a href="<?php echo $base_url; ?>pages/courses.php?filter=pg#course-grid">Postgraduate</a>
                        <a href="<?php echo $base_url; ?>pages/courses.php?filter=phd#course-grid">Research/PhD</a>
                    </div>
                </li>
                <li><a href="<?php echo $base_url; ?>pages/placements.php">Placements</a></li>
                <li><a href="<?php echo $base_url; ?>pages/achievements.php">Achievements</a></li>
                <li><a href="<?php echo $base_url; ?>pages/contact.php">Contact</a></li>
                <?php if (isset($_SESSION['student_id'])): ?>
                    <li><a href="<?php echo $base_url; ?>student/dashboard.php" class="btn-primary">Student Dashboard</a></li>
                    <li><a href="<?php echo $base_url; ?>logout.php" class="btn-outline">Logout</a></li>
                <?php elseif (isset($_SESSION['admin_id'])): ?>
                    <li><a href="<?php echo $base_url; ?>admin/dashboard.php" class="btn-primary">Admin Dashboard</a></li>
                    <li><a href="<?php echo $base_url; ?>logout.php" class="btn-outline">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo $base_url; ?>login.php" class="btn-primary">Login</a></li>
                <?php endif; ?>
            </ul>
            <div class="nav-actions">
                <div class="theme-switch-wrapper">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" id="checkbox" />
                        <div class="slider round"></div>
                    </label>
                </div>
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </nav>
