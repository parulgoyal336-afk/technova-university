<?php
session_start();
require_once '../includes/db.php';
if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}
$student_id = $_SESSION['student_id'];
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : die("Course ID missing.");

// Fetch student info
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

// Fetch course info
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->execute([$course_id]);
$course = $stmt->fetch();

// Fetch marks for this course
$stmt = $pdo->prepare("SELECT * FROM marks WHERE student_id = ? AND course_id = ? ORDER BY exam_date");
$stmt->execute([$student_id, $course_id]);
$marks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card - <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #F5F5F5; background-color: #0B0B0B; margin: 40px; }
        .report-card { max-width: 800px; margin: 0 auto; padding: 40px; border: 2px solid #D4AF37; border-radius: 10px; background-color: #1A1A1A; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 1px solid rgba(212,175,55,0.3); padding-bottom: 20px; }
        .header h1 { color: #D4AF37; margin: 0; text-transform: uppercase; letter-spacing: 3px; }
        .header p { color: #999; margin: 5px 0; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
        .info-item p { margin: 8px 0; color: #ccc; }
        .info-item strong { color: #D4AF37; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { border: 1px solid rgba(212,175,55,0.2); padding: 12px; text-align: left; }
        th { background-color: rgba(212,175,55,0.1); color: #D4AF37; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; }
        td { color: #ccc; }
        .total-section { text-align: right; margin-top: 20px; font-weight: bold; padding-top: 20px; border-top: 1px solid rgba(212,175,55,0.3); }
        .total-section p { color: #ccc; }
        .footer { text-align: center; margin-top: 60px; font-size: 0.8rem; color: #666; }
        .print-btn { text-align: center; margin-top: 30px; }
        .print-btn button { padding: 12px 30px; background: linear-gradient(135deg, #D4AF37, #B8860B); color: #0B0B0B; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }
        @media print { 
            body { background-color: white; color: black; }
            .report-card { background-color: white; border-color: #ccc; box-shadow: none; }
            .header h1, .info-item strong, th { color: black; }
            th { background-color: #f4f4f4; }
            td, .info-item p, .total-section p { color: black; }
            .print-btn { display: none; } 
        }
    </style>
</head>
<body>
    <div class="report-card">
        <div class="header">
            <h1>TECHNOVA UNIVERSITY</h1>
            <p>Category-I Elite Global Institution</p>
            <p>Official Academic Transcript</p>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <p><strong>Student Name:</strong> <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></p>
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
            </div>
            <div class="info-item">
                <p><strong>Course:</strong> <?php echo htmlspecialchars($course['course_name']); ?></p>
                <p><strong>Course Code:</strong> <?php echo htmlspecialchars($course['course_code']); ?></p>
                <p><strong>Date:</strong> <?php echo date('F j, Y'); ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Exam Date</th>
                    <th>Max Marks</th>
                    <th>Marks Obtained</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_obtained = 0;
                $total_max = 0;
                foreach ($marks as $row): 
                    $total_obtained += $row['marks_obtained'];
                    $total_max += $row['max_marks'];
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                    <td><?php echo date('M j, Y', strtotime($row['exam_date'])); ?></td>
                    <td><?php echo $row['max_marks']; ?></td>
                    <td><?php echo $row['marks_obtained']; ?></td>
                    <td><strong><?php echo $row['grade']; ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-section">
            <?php if ($total_max > 0): 
                $final_percentage = ($total_obtained / $total_max) * 100;
                $final_grade = '';
                if ($final_percentage >= 90) $final_grade = 'A+';
                elseif ($final_percentage >= 80) $final_grade = 'A';
                elseif ($final_percentage >= 70) $final_grade = 'B';
                elseif ($final_percentage >= 60) $final_grade = 'C';
                elseif ($final_percentage >= 50) $final_grade = 'D';
                else $final_grade = 'F';
            ?>
                <p>Total Marks: <?php echo $total_obtained; ?> / <?php echo $total_max; ?></p>
                <p>Percentage: <?php echo round($final_percentage, 2); ?>%</p>
                <p>Final Grade: <span style="font-size: 1.2rem; color: #D4AF37;"><?php echo $final_grade; ?></span></p>
            <?php endif; ?>
        </div>

        <div class="footer">
            <p>This is a computer-generated report card and does not require a physical signature.</p>
            <p>&copy; <?php echo date('Y'); ?> Technova University Management System</p>
        </div>
    </div>

    <div class="print-btn">
        <button onclick="window.print()">Print / Save as PDF</button>
        <a href="marks.php" style="margin-left: 20px; color: #D4AF37; text-decoration: none; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px;">Back to Marks</a>
    </div>
</body>
</html>
