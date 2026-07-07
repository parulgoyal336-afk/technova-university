<?php
include 'student_header.php';

$selected_course = isset($_GET['course_id']) ? $_GET['course_id'] : '';
?>

<div style="margin-bottom: 2rem;">
    <h3>My Marks & Performance</h3>
</div>

<div class="glass-card" style="background: white; margin-bottom: 2rem;">
    <form method="GET" action="marks.php" style="display: flex; gap: 1rem; align-items: flex-end;">
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 0.5rem;">Select Course</label>
            <select name="course_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                <option value="">-- All Courses --</option>
                <?php
                $stmt = $pdo->prepare("SELECT c.id, c.course_name FROM courses c 
                                     JOIN enrollments e ON c.id = e.course_id 
                                     WHERE e.student_id = ?");
                $stmt->execute([$student_id]);
                while ($course = $stmt->fetch()) {
                    $selected = ($selected_course == $course['id']) ? 'selected' : '';
                    echo '<option value="' . $course['id'] . '" ' . $selected . '>' . htmlspecialchars($course['course_name']) . '</option>';
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn-primary" style="border: none; cursor: pointer; padding: 10px 20px;">Filter Marks</button>
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <!-- Marks Table -->
    <div class="glass-card" style="background: white; flex: 2;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Marks Obtained</h3>
            <?php if ($selected_course): ?>
                <a href="report_card.php?course_id=<?php echo $selected_course; ?>" class="btn-outline" style="font-size: 0.8rem; padding: 5px 15px;"><i class="fas fa-file-pdf"></i> View Report Card</a>
            <?php endif; ?>
        </div>
        <div style="margin-top: 1.5rem;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; text-align: left;">
                        <th style="padding: 12px;">Subject</th>
                        <th style="padding: 12px;">Course</th>
                        <th style="padding: 12px;">Marks</th>
                        <th style="padding: 12px;">Grade</th>
                        <th style="padding: 12px;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT m.*, c.course_name FROM marks m 
                             JOIN courses c ON m.course_id = c.id 
                             WHERE m.student_id = ?";
                    $params = [$student_id];
                    if ($selected_course) {
                        $query .= " AND m.course_id = ?";
                        $params[] = $selected_course;
                    }
                    $query .= " ORDER BY m.exam_date DESC";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute($params);
                    while ($row = $stmt->fetch()) {
                        $color = ($row['grade'] == 'F') ? '#e74c3c' : '#27ae60';
                        echo '<tr style="border-bottom: 1px solid #eee;">';
                        echo '<td style="padding: 12px;">' . htmlspecialchars($row['subject_name']) . '</td>';
                        echo '<td style="padding: 12px;">' . htmlspecialchars($row['course_name']) . '</td>';
                        echo '<td style="padding: 12px;">' . $row['marks_obtained'] . ' / ' . $row['max_marks'] . '</td>';
                        echo '<td style="padding: 12px;"><span style="color: ' . $color . '; font-weight: 600;">' . $row['grade'] . '</span></td>';
                        echo '<td style="padding: 12px;">' . date('M j, Y', strtotime($row['exam_date'])) . '</td>';
                        echo '</tr>';
                    }
                    if ($stmt->rowCount() == 0) {
                        echo '<tr><td colspan="5" style="text-align: center; padding: 20px;">No marks recorded.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Performance Analytics -->
    <div class="glass-card" style="background: white; flex: 1; text-align: center;">
        <h3>Performance Analysis</h3>
        <div style="margin-top: 2rem;">
            <canvas id="studentPerformanceChart"></canvas>
            <div style="margin-top: 1.5rem; text-align: left;">
                <?php
                $stmt = $pdo->prepare("SELECT AVG(marks_obtained) as avg_marks, MAX(marks_obtained) as max_marks, MIN(marks_obtained) as min_marks FROM marks WHERE student_id = ?");
                $stmt->execute([$student_id]);
                $perf = $stmt->fetch();
                ?>
                <p><strong>Average Marks:</strong> <?php echo round($perf['avg_marks'], 2); ?>%</p>
                <p><strong>Highest Marks:</strong> <?php echo $perf['max_marks']; ?>%</p>
                <p><strong>Lowest Marks:</strong> <?php echo $perf['min_marks']; ?>%</p>
            </div>
        </div>
    </div>
</div>

<script>
    const ctxPerf = document.getElementById('studentPerformanceChart').getContext('2d');
    new Chart(ctxPerf, {
        type: 'radar',
        data: {
            labels: ['Attendance', 'Assignments', 'Exams', 'Projects', 'Participation'],
            datasets: [{
                label: 'Performance Score',
                data: [85, 90, 80, 95, 88],
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: '#3498db',
                pointBackgroundColor: '#3498db'
            }]
        },
        options: {
            responsive: true,
            scales: {
                r: { beginAtZero: true, max: 100 }
            }
        }
    });
</script>

<?php include 'student_footer.php'; ?>
