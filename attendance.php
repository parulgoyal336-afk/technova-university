<?php
include 'student_header.php';

$student_id = $_SESSION['student_id'];
$selected_course = isset($_GET['course_id']) ? $_GET['course_id'] : '';

// Get overall attendance statistics for the selected course (or all courses)
$att_query = "SELECT COUNT(*) as total, 
                    SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) as present,
                    SUM(CASE WHEN status='Absent' THEN 1 ELSE 0 END) as absent,
                    SUM(CASE WHEN status='Late' THEN 1 ELSE 0 END) as late
             FROM attendance WHERE student_id = ?";
$att_params = [$student_id];
if ($selected_course) {
    $att_query .= " AND course_id = ?";
    $att_params[] = $selected_course;
}
$att_stmt = $pdo->prepare($att_query);
$att_stmt->execute($att_params);
$att_data = $att_stmt->fetch();

$total = $att_data['total'];
$present = $att_data['present'];
$absent = $att_data['absent'];
$late = $att_data['late'];
$percentage = ($total > 0) ? round(($present / $total) * 100, 1) : 0;
?>

<div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h2 style="color: var(--primary-color); text-transform: uppercase; letter-spacing: 2px;">Attendance Dashboard</h2>
        <p style="color: #666; font-size: 0.9rem;">Monitor your presence and academic eligibility</p>
    </div>
    <div style="width: 300px;">
        <form method="GET" action="attendance.php">
            <label style="color: var(--primary-color); font-size: 0.75rem; text-transform: uppercase; margin-bottom: 5px; display: block;">Filter by Program</label>
            <select name="course_id" onchange="this.form.submit()" style="width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid rgba(212,175,55,0.2); color: white; border-radius: 6px; outline: none; cursor: pointer;">
                <option value="">-- All Enrolled Programs --</option>
                <?php
                $courses_stmt = $pdo->prepare("SELECT c.id, c.course_name FROM courses c 
                                             JOIN enrollments e ON c.id = e.course_id 
                                             WHERE e.student_id = ?");
                $courses_stmt->execute([$student_id]);
                while ($course = $courses_stmt->fetch()) {
                    $selected = ($selected_course == $course['id']) ? 'selected' : '';
                    echo '<option value="' . $course['id'] . '" ' . $selected . '>' . htmlspecialchars($course['course_name']) . '</option>';
                }
                ?>
            </select>
        </form>
    </div>
</div>

<!-- Attendance Overview Cards -->
<div class="stats-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2); text-align: center; padding: 2rem;">
        <div style="position: relative; display: inline-block;">
            <svg width="100" height="100" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(212,175,55,0.1)" stroke-width="8" />
                <circle cx="50" cy="50" r="45" fill="none" stroke="var(--primary-color)" stroke-width="8" 
                        stroke-dasharray="<?php echo (2 * pi() * 45 * $percentage / 100) . ' ' . (2 * pi() * 45); ?>" 
                        transform="rotate(-90 50 50)" stroke-linecap="round" style="transition: stroke-dasharray 1s ease;" />
                <text x="50" y="55" text-anchor="middle" font-size="18" font-weight="700" fill="var(--primary-color)"><?php echo round($percentage); ?>%</text>
            </svg>
        </div>
        <p style="color: #999; margin-top: 1rem; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px;">Overall Presence</p>
    </div>
    
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2); border-left: 4px solid #27ae60;">
        <h3 style="color: #27ae60;"><?php echo $present; ?></h3>
        <p style="color: #999;">Days Present</p>
    </div>
    
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2); border-left: 4px solid #e74c3c;">
        <h3 style="color: #e74c3c;"><?php echo $absent; ?></h3>
        <p style="color: #999;">Days Absent</p>
    </div>
    
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2); border-left: 4px solid #f1c40f;">
        <h3 style="color: #f1c40f;"><?php echo $late; ?></h3>
        <p style="color: #999;">Days Late</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Detailed Attendance Log -->
    <div class="glass-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.1); padding: 0;">
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid rgba(212,175,55,0.1);">
            <h4 style="color: var(--primary-color); text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px;">Recent Attendance Log</h4>
        </div>
        <div style="padding: 1rem 2rem;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid rgba(212,175,55,0.1);">
                        <th style="padding: 15px; color: var(--primary-color); font-size: 0.8rem; text-transform: uppercase;">Date</th>
                        <th style="padding: 15px; color: var(--primary-color); font-size: 0.8rem; text-transform: uppercase;">Course Program</th>
                        <th style="padding: 15px; color: var(--primary-color); font-size: 0.8rem; text-transform: uppercase;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $log_query = "SELECT a.*, c.course_name 
                                 FROM attendance a 
                                 JOIN courses c ON a.course_id = c.id 
                                 WHERE a.student_id = ?";
                    $log_params = [$student_id];
                    if ($selected_course) {
                        $log_query .= " AND a.course_id = ?";
                        $log_params[] = $selected_course;
                    }
                    $log_query .= " ORDER BY a.attendance_date DESC LIMIT 10";
                    
                    $stmt = $pdo->prepare($log_query);
                    $stmt->execute($log_params);
                    
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) {
                            $status_color = '#27ae60';
                            if ($row['status'] == 'Absent') $status_color = '#e74c3c';
                            if ($row['status'] == 'Late') $status_color = '#f1c40f';
                            
                            echo '<tr style="border-bottom: 1px solid rgba(212,175,55,0.05);">';
                            echo '<td style="padding: 15px; color: #ccc;">' . date('M j, Y', strtotime($row['attendance_date'])) . '</td>';
                            echo '<td style="padding: 15px; color: #999;">' . htmlspecialchars($row['course_name']) . '</td>';
                            echo '<td style="padding: 15px;">';
                            echo '<span style="background: rgba(0,0,0,0.2); color: ' . $status_color . '; padding: 4px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; border: 1px solid ' . $status_color . '22;">' . $row['status'] . '</span>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3" style="text-align: center; padding: 40px; color: #666;">No attendance records found yet.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Eligibility Alert -->
    <div class="glass-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.1);">
        <h4 style="color: var(--primary-color); text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; margin-bottom: 1.5rem;">Academic Eligibility</h4>
        <?php if ($percentage < 75 && $total > 0): ?>
            <div style="background: rgba(231, 76, 60, 0.1); border: 1px solid rgba(231, 76, 60, 0.2); padding: 1.5rem; border-radius: 8px; text-align: center;">
                <i class="fas fa-exclamation-triangle" style="font-size: 2.5rem; color: #e74c3c; margin-bottom: 1rem;"></i>
                <h3 style="color: #e74c3c; margin-bottom: 0.5rem;">Critical Warning</h3>
                <p style="color: #ccc; font-size: 0.85rem;">Your attendance is below the mandatory 75% required for examination eligibility. Please contact the academic cell immediately.</p>
            </div>
        <?php else: ?>
            <div style="background: rgba(39, 174, 96, 0.1); border: 1px solid rgba(39, 174, 96, 0.2); padding: 1.5rem; border-radius: 8px; text-align: center;">
                <i class="fas fa-check-circle" style="font-size: 2.5rem; color: #27ae60; margin-bottom: 1rem;"></i>
                <h3 style="color: #27ae60; margin-bottom: 0.5rem;">Status: Eligible</h3>
                <p style="color: #ccc; font-size: 0.85rem;">Excellent! Your attendance meets the elite standards of Technova University. You are eligible for all upcoming examinations.</p>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 2rem;">
            <p style="color: #666; font-size: 0.75rem; line-height: 1.6;">
                <i class="fas fa-info-circle"></i> <strong>Note:</strong> Attendance is updated every 24 hours. For any discrepancies, please submit an application to your respective department head.
            </p>
        </div>
    </div>
</div>

<?php include 'student_footer.php'; ?>
