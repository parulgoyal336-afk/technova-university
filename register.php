<?php
include 'includes/header.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $student_id = "STU" . rand(1000, 9999);

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $error = "Email already exists! Please login.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (student_id, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$student_id, $first_name, $last_name, $email, $password])) {
            $success = "Registration successful! You can now login with your email.";
        } else {
            $error = "Something went wrong! Please try again.";
        }
    }
}
?>

<section class="section" style="padding-top: 150px; display: flex; justify-content: center; align-items: center; min-height: 80vh;">
    <div class="glass-card" style="width: 100%; max-width: 500px; padding: 2.5rem; border: 1px solid rgba(212,175,55,0.2);">
        <h2 style="text-align: center; margin-bottom: 2rem; color: var(--primary-color); text-transform: uppercase; letter-spacing: 2px;">Elite Registration</h2>
        <?php if ($error): ?>
            <div style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 10px; border-radius: 5px; margin-bottom: 1rem; border: 1px solid rgba(231, 76, 60, 0.3);">
                <?php echo $error; ?>
            </div>
        <?php elseif ($success): ?>
            <div style="background: rgba(39, 174, 96, 0.1); color: #27ae60; padding: 10px; border-radius: 5px; margin-bottom: 1rem; border: 1px solid rgba(39, 174, 96, 0.3);">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.8rem; text-transform: uppercase;">First Name</label>
                    <input type="text" name="first_name" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.8rem; text-transform: uppercase;">Last Name</label>
                    <input type="text" name="last_name" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
                </div>
            </div>
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.8rem; text-transform: uppercase;">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.8rem; text-transform: uppercase;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; letter-spacing: 2px;">CREATE ELITE ACCOUNT</button>
            <div style="text-align: center; margin-top: 1.5rem;">
                <p style="color: #999;">Already have an account? <a href="login.php" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Login here</a></p>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
