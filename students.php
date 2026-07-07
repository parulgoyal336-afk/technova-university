<?php
include 'admin_header.php';

// Handle Student Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt->execute([$delete_id])) {
        header("Location: students.php?msg=Student Deleted Successfully");
        exit();
    }
}

// Handle Student Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $student_id = $_POST['student_id'];

    $stmt = $pdo->prepare("INSERT INTO students (student_id, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$student_id, $first_name, $last_name, $email, $password])) {
        header("Location: students.php?msg=Student Added Successfully");
        exit();
    }
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h3>Manage Students</h3>
    <button onclick="document.getElementById('addStudentModal').style.display='block'" class="btn-primary" style="border: none; cursor: pointer;"><i class="fas fa-user-plus"></i> Add New Student</button>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
        <?php echo htmlspecialchars($_GET['msg']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="background: white;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid #eee; text-align: left;">
                <th style="padding: 12px;">Student ID</th>
                <th style="padding: 12px;">Name</th>
                <th style="padding: 12px;">Email</th>
                <th style="padding: 12px;">Joined Date</th>
                <th style="padding: 12px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
            while ($student = $stmt->fetch()) {
                echo '<tr style="border-bottom: 1px solid #eee;">';
                echo '<td style="padding: 12px;">' . htmlspecialchars($student['student_id']) . '</td>';
                echo '<td style="padding: 12px;">' . htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) . '</td>';
                echo '<td style="padding: 12px;">' . htmlspecialchars($student['email']) . '</td>';
                echo '<td style="padding: 12px;">' . date('M j, Y', strtotime($student['created_at'])) . '</td>';
                echo '<td style="padding: 12px;">';
                echo '<a href="edit_student.php?id=' . $student['id'] . '" style="color: #3498db; margin-right: 15px;"><i class="fas fa-edit"></i></a>';
                echo '<a href="students.php?delete_id=' . $student['id'] . '" onclick="return confirm(\'Are you sure?\')" style="color: #e74c3c;"><i class="fas fa-trash"></i></a>';
                echo '</td>';
                echo '</tr>';
            }
            if ($stmt->rowCount() == 0) {
                echo '<tr><td colspan="5" style="text-align: center; padding: 20px;">No students found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Student Modal (Simple Implementation) -->
<div id="addStudentModal" style="display:none; position:fixed; z-index:1001; left:0; top:0; width:100%; height:100%; overflow:auto; background-color: rgba(0,0,0,0.5);">
    <div class="glass-card" style="background: white; margin: 10% auto; padding: 2rem; width: 100%; max-width: 500px; border-radius: 10px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Add New Student</h3>
            <span onclick="document.getElementById('addStudentModal').style.display='none'" style="cursor: pointer; font-size: 1.5rem;">&times;</span>
        </div>
        <form method="POST" action="students.php">
            <input type="hidden" name="add_student" value="1">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Student ID</label>
                <input type="text" name="student_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem;">First Name</label>
                    <input type="text" name="first_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem;">Last Name</label>
                    <input type="text" name="last_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer; padding: 12px; font-weight: 600;">Add Student</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
