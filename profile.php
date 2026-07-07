<?php
include 'student_header.php';

$success = "";
$error = "";

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    $stmt = $pdo->prepare("UPDATE students SET first_name = ?, last_name = ?, phone = ?, dob = ?, address = ? WHERE id = ?");
    if ($stmt->execute([$first_name, $last_name, $phone, $dob, $address, $student_id])) {
        $success = "Profile updated successfully!";
        // Refresh student details
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$student_id]);
        $student = $stmt->fetch();
    } else {
        $error = "Failed to update profile.";
    }
}
?>

<div style="margin-bottom: 2rem;">
    <h3>My Profile</h3>
</div>

<?php if ($success): ?>
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
        <?php echo $success; ?>
    </div>
<?php elseif ($error): ?>
    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <!-- Profile Info Card -->
    <div class="glass-card" style="background: white; text-align: center;">
        <img src="<?php echo $base_url . 'assets/images/' . $student['profile_pic']; ?>" alt="Profile" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 5px solid var(--primary-color); margin-bottom: 1rem;">
        <h3><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></h3>
        <p style="color: #666; font-weight: 600;">Student ID: <?php echo htmlspecialchars($student['student_id']); ?></p>
        <p style="color: #999; margin-top: 5px;"><?php echo htmlspecialchars($student['email']); ?></p>
        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee; text-align: left;">
            <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($student['created_at'])); ?></p>
        </div>
    </div>

    <!-- Edit Profile Card -->
    <div class="glass-card" style="background: white;">
        <h3>Edit Personal Information</h3>
        <form method="POST" action="profile.php" style="margin-top: 1.5rem;">
            <input type="hidden" name="update_profile" value="1">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem;">First Name</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem;">Last Name</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Phone Number</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Date of Birth</label>
                <input type="date" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Address</label>
                <textarea name="address" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; resize: none;"><?php echo htmlspecialchars($student['address']); ?></textarea>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer; padding: 12px; font-weight: 600;">Update Profile</button>
        </form>
    </div>
</div>

<?php include 'student_footer.php'; ?>
