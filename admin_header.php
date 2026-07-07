<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}
$base_url = "http://localhost/jpr/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SmartCollege</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo" style="color: var(--primary-color); margin-bottom: 2rem; border-bottom: 1px solid rgba(212,175,55,0.2); padding-bottom: 1rem;">
                <i class="fas fa-university"></i> TECHNOVA
            </div>
            <ul>
                <li><a href="dashboard.php" class="active"><i class="fas fa-chart-line"></i> Analytics</a></li>
                <li><a href="students.php"><i class="fas fa-user-graduate"></i> Students</a></li>
                <li><a href="courses.php"><i class="fas fa-book-open"></i> Programs</a></li>
                <li><a href="attendance.php"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="marks.php"><i class="fas fa-award"></i> Examination</a></li>
                <li><a href="announcements.php"><i class="fas fa-bullhorn"></i> News Desk</a></li>
                <li style="margin-top: 5rem; border-top: 1px solid rgba(212,175,55,0.1); padding-top: 1rem;"><a href="../logout.php" style="color: #e74c3c;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; background: var(--secondary-color); padding: 1.5rem 2rem; border-radius: 12px; border: 1px solid rgba(212,175,55,0.1); box-shadow: var(--shadow);">
                <h2 style="color: var(--primary-color); letter-spacing: 1px; text-transform: uppercase; font-size: 1.2rem;">Elite Control Center</h2>
                <div class="admin-profile" style="display: flex; align-items: center; gap: 15px;">
                    <div style="text-align: right;">
                        <p style="font-size: 0.9rem; color: var(--primary-color); font-weight: 600;"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                        <p style="font-size: 0.7rem; color: #666; text-transform: uppercase;">University Administrator</p>
                    </div>
                    <i class="fas fa-user-circle" style="font-size: 2.5rem; color: var(--primary-color); filter: drop-shadow(0 0 5px rgba(212,175,55,0.3));"></i>
                </div>
            </header>
