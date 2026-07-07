<?php
include 'includes/header.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'admin') {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: admin/dashboard.php");
            exit();
        } else {
            $error = "Invalid Admin Email or Password";
        }
    } else {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['student_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            header("Location: student/dashboard.php");
            exit();
        } else {
            $error = "Invalid Student Email or Password";
        }
    }
}
?>

<section class="section" style="padding-top: 150px; display: flex; justify-content: center; align-items: center; min-height: 80vh;">
    <div class="glass-card" style="width: 100%; max-width: 400px; padding: 2.5rem; border: 1px solid rgba(212,175,55,0.2);">
        <h2 style="text-align: center; margin-bottom: 2rem; color: var(--primary-color); text-transform: uppercase; letter-spacing: 2px;">Elite Portal Login</h2>
        <?php if ($error): ?>
            <div style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 10px; border-radius: 5px; margin-bottom: 1rem; border: 1px solid rgba(231, 76, 60, 0.3);">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.8rem; text-transform: uppercase;">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
            </div>
            <div style="margin-bottom: 1.2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.8rem; text-transform: uppercase;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #999; font-size: 0.8rem; text-transform: uppercase;">Login As</label>
                <select name="role" required style="width: 100%; padding: 12px; border: 1px solid rgba(212,175,55,0.3); border-radius: 4px; background: rgba(0,0,0,0.5); color: white;">
                    <option value="student">Elite Student</option>
                    <option value="admin">University Administrator</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; letter-spacing: 2px;">SECURE LOGIN</button>
            <div style="text-align: center; margin-top: 1.5rem;">
                <p style="color: #999;">New Student? <a href="register.php" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Register here</a></p>
                <a href="#" style="font-size: 0.8rem; color: #666; text-decoration: none; margin-top: 10px; display: inline-block;">Forgot Password?</a>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
