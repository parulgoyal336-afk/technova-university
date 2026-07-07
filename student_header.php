<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}
$base_url = "http://localhost/jpr/";
$student_id = $_SESSION['student_id'];

// Fetch student details
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - SmartCollege</title>
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
                <li><a href="dashboard.php" class="active"><i class="fas fa-columns"></i> Dashboard</a></li>
                <li><a href="profile.php"><i class="fas fa-id-card"></i> Elite Profile</a></li>
                <li><a href="courses.php"><i class="fas fa-graduation-cap"></i> My Programs</a></li>
                <li><a href="attendance.php"><i class="fas fa-calendar-alt"></i> Attendance</a></li>
                <li><a href="marks.php"><i class="fas fa-medal"></i> Achievements</a></li>
                <li style="margin-top: 5rem; border-top: 1px solid rgba(212,175,55,0.1); padding-top: 1rem;"><a href="../logout.php" style="color: #e74c3c;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; background: var(--secondary-color); padding: 1.5rem 2rem; border-radius: 12px; border: 1px solid rgba(212,175,55,0.1); box-shadow: var(--shadow);">
                <h2 style="color: var(--primary-color); letter-spacing: 1px; text-transform: uppercase; font-size: 1.2rem;">Elite Student Portal</h2>
                <div class="student-profile" style="display: flex; align-items: center; gap: 15px;">
                    <div style="text-align: right;">
                        <p style="font-size: 0.9rem; color: var(--primary-color); font-weight: 600;"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
                        <p style="font-size: 0.7rem; color: #666; text-transform: uppercase;">Elite Member</p>
                    </div>
                    <img src="<?php echo $base_url . 'assets/images/' . $student['profile_pic']; ?>" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary-color); filter: drop-shadow(0 0 5px rgba(212,175,55,0.3));">
                </div>
            </header>
