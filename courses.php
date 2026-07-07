<?php
include 'student_header.php';

// Handle Enrollment
if (isset($_GET['enroll_id'])) {
    $enroll_id = $_GET['enroll_id'];
    // Check if already enrolled
    $check = $pdo->prepare("SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?");
    $check->execute([$student_id, $enroll_id]);
    if (!$check->fetch()) {
        $enroll = $pdo->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)");
        if ($enroll->execute([$student_id, $enroll_id])) {
            $msg = "Enrolled successfully!";
        }
    }
}
?>

<div style="margin-bottom: 2rem;">
    <h3>My Courses & Enrollments</h3>
</div>

<?php if (isset($msg)): ?>
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
        <?php echo $msg; ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <!-- Enrolled Courses -->
    <div class="glass-card" style="background: var(--light-color); flex: 2; border: 1px solid rgba(212,175,55,0.2);">
        <h3 style="color: var(--primary-color);">My Enrolled Programs</h3>
        <div style="margin-top: 1.5rem;">
            <?php
            $stmt = $pdo->prepare("SELECT c.* FROM courses c 
                                 JOIN enrollments e ON c.id = e.course_id 
                                 WHERE e.student_id = ?");
            $stmt->execute([$student_id]);
            while ($row = $stmt->fetch()) {
                echo '<div style="margin-bottom: 1rem; padding: 1.5rem; border: 1px solid rgba(212,175,55,0.1); border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">';
                echo '<div>';
                echo '<h4 style="color: var(--primary-color);">' . htmlspecialchars($row['course_name']) . '</h4>';
                echo '<p style="font-size: 0.9rem; color: #999;">' . htmlspecialchars($row['course_code']) . '</p>';
                echo '</div>';
                echo '<a href="marks.php" class="btn-outline" style="font-size: 0.8rem; padding: 5px 15px;">View Progress</a>';
                echo '</div>';
            }
            if ($stmt->rowCount() == 0) {
                echo '<p style="color: #666;">You haven\'t enrolled in any programs yet.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Available Courses -->
    <div class="glass-card" style="background: var(--light-color); flex: 1; border: 1px solid rgba(212,175,55,0.2);">
        <h3 style="color: var(--primary-color);">Browse Programs</h3>
        <div style="margin-top: 1.5rem;">
            <?php
            // Get courses NOT enrolled in
            $stmt = $pdo->prepare("SELECT * FROM courses WHERE id NOT IN (SELECT course_id FROM enrollments WHERE student_id = ?)");
            $stmt->execute([$student_id]);
            while ($row = $stmt->fetch()) {
                echo '<div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(212,175,55,0.1);">';
                echo '<h4 style="color: #fff;">' . htmlspecialchars($row['course_name']) . '</h4>';
                echo '<p style="font-size: 0.8rem; color: #999; margin: 5px 0;">' . htmlspecialchars($row['duration']) . ' | ₹' . number_format($row['fees'], 2) . '</p>';
                echo '<a href="courses.php?enroll_id=' . $row['id'] . '" class="btn-primary" style="font-size: 0.8rem; padding: 5px 15px; display: inline-block; text-decoration: none; margin-top: 5px;">Enroll Now</a>';
                echo '</div>';
            }
            if ($stmt->rowCount() == 0) {
                echo '<p style="color: #666;">All programs are already enrolled.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php include 'student_footer.php'; ?>
