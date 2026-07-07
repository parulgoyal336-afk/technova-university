<?php include 'student_header.php'; ?>

<!-- Welcome Section -->
<div class="glass-card" style="background: var(--gold-gradient); color: var(--secondary-color); margin-bottom: 2rem; border: none; box-shadow: 0 10px 30px rgba(212,175,55,0.3);">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-weight: 700; letter-spacing: 1px;">Hello, <?php echo htmlspecialchars($student['first_name']); ?>!</h2>
            <p style="font-weight: 500;">Welcome back to your elite academic portal. Here's a quick overview of your performance.</p>
        </div>
        <div style="font-size: 3.5rem; opacity: 0.2;">
            <i class="fas fa-crown"></i>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
        <i class="fas fa-book" style="color: var(--primary-color);"></i>
        <?php
        $count_my_courses = $pdo->prepare("SELECT COUNT(*) FROM enrollments WHERE student_id = ?");
        $count_my_courses->execute([$student_id]);
        $courses_count = $count_my_courses->fetchColumn();
        ?>
        <h3 style="color: var(--primary-color);"><?php echo $courses_count; ?></h3>
        <p style="color: #999;">Enrolled Programs</p>
    </div>
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
        <i class="fas fa-calendar-check" style="color: var(--primary-color);"></i>
        <?php
        $att_stmt = $pdo->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) as present FROM attendance WHERE student_id = ?");
        $att_stmt->execute([$student_id]);
        $att_data = $att_stmt->fetch();
        $percentage = ($att_data['total'] > 0) ? round(($att_data['present'] / $att_data['total']) * 100) : 0;
        ?>
        <h3 style="color: var(--primary-color);"><?php echo $percentage; ?>%</h3>
        <p style="color: #999;">Avg. Attendance</p>
    </div>
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
        <i class="fas fa-star" style="color: var(--primary-color);"></i>
        <h3 style="color: var(--primary-color);">A+</h3>
        <p style="color: #999;">Current Grade</p>
    </div>
    <div class="stat-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
        <i class="fas fa-bell" style="color: var(--primary-color);"></i>
        <?php
        $count_notices = $pdo->query("SELECT COUNT(*) FROM announcements WHERE target_role IN ('All', 'Student')")->fetchColumn();
        ?>
        <h3 style="color: var(--primary-color);"><?php echo $count_notices; ?></h3>
        <p style="color: #999;">New Notices</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
    <!-- Recent Attendance Chart -->
    <div class="glass-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
        <h3 style="color: var(--primary-color);">My Attendance Trends</h3>
        <canvas id="studentAttendanceChart"></canvas>
    </div>
    
    <!-- Latest Notices -->
    <div class="glass-card" style="background: var(--light-color); border: 1px solid rgba(212,175,55,0.2);">
        <h3 style="color: var(--primary-color);">Announcements</h3>
        <div style="margin-top: 1rem;">
            <?php
            $stmt = $pdo->query("SELECT * FROM announcements WHERE target_role IN ('All', 'Student') ORDER BY created_at DESC LIMIT 3");
            while ($row = $stmt->fetch()) {
                echo '<div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(212,175,55,0.1);">';
                echo '<h4 style="color: var(--primary-color);">' . htmlspecialchars($row['title']) . '</h4>';
                echo '<p style="font-size: 0.9rem; color: #ccc; margin: 5px 0;">' . htmlspecialchars($row['message']) . '</p>';
                echo '<small style="color: #666;">' . date('M j, Y', strtotime($row['created_at'])) . '</small>';
                echo '</div>';
            }
            if ($stmt->rowCount() == 0) {
                echo '<p style="color: #999;">No new announcements.</p>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('studentAttendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Math', 'Science', 'Computer', 'English', 'History'],
            datasets: [{
                label: 'Attendance %',
                data: [85, 90, 95, 80, 75],
                backgroundColor: 'rgba(212, 175, 55, 0.7)',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, max: 100 }
            }
        }
    });
</script>

<?php include 'student_footer.php'; ?>
