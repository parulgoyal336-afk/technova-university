<?php
include 'admin_header.php';

// Handle Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = ?");
    if ($stmt->execute([$delete_id])) {
        header("Location: announcements.php?msg=Announcement Deleted Successfully");
        exit();
    }
}

// Handle Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_announcement'])) {
    $title = $_POST['title'];
    $message = $_POST['message'];
    $target_role = $_POST['target_role'];

    $stmt = $pdo->prepare("INSERT INTO announcements (title, message, target_role) VALUES (?, ?, ?)");
    if ($stmt->execute([$title, $message, $target_role])) {
        header("Location: announcements.php?msg=Announcement Posted Successfully");
        exit();
    }
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h3>Manage Announcements</h3>
    <button onclick="document.getElementById('addNoticeModal').style.display='block'" class="btn-primary" style="border: none; cursor: pointer;"><i class="fas fa-bullhorn"></i> Post New Announcement</button>
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
                <th style="padding: 12px;">Title</th>
                <th style="padding: 12px;">Message</th>
                <th style="padding: 12px;">Target</th>
                <th style="padding: 12px;">Date</th>
                <th style="padding: 12px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC");
            while ($row = $stmt->fetch()) {
                echo '<tr style="border-bottom: 1px solid #eee;">';
                echo '<td style="padding: 12px;">' . htmlspecialchars($row['title']) . '</td>';
                echo '<td style="padding: 12px; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . htmlspecialchars($row['message']) . '</td>';
                echo '<td style="padding: 12px;">' . $row['target_role'] . '</td>';
                echo '<td style="padding: 12px;">' . date('M j, Y', strtotime($row['created_at'])) . '</td>';
                echo '<td style="padding: 12px;">';
                echo '<a href="announcements.php?delete_id=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')" style="color: #e74c3c;"><i class="fas fa-trash"></i></a>';
                echo '</td>';
                echo '</tr>';
            }
            if ($stmt->rowCount() == 0) {
                echo '<tr><td colspan="5" style="text-align: center; padding: 20px;">No announcements found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Notice Modal -->
<div id="addNoticeModal" style="display:none; position:fixed; z-index:1001; left:0; top:0; width:100%; height:100%; overflow:auto; background-color: rgba(0,0,0,0.5);">
    <div class="glass-card" style="background: white; margin: 10% auto; padding: 2rem; width: 100%; max-width: 500px; border-radius: 10px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3>Post New Announcement</h3>
            <span onclick="document.getElementById('addNoticeModal').style.display='none'" style="cursor: pointer; font-size: 1.5rem;">&times;</span>
        </div>
        <form method="POST" action="announcements.php">
            <input type="hidden" name="add_announcement" value="1">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Title</label>
                <input type="text" name="title" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Message</label>
                <textarea name="message" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; resize: none;"></textarea>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem;">Target Audience</label>
                <select name="target_role" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <option value="All">All Users</option>
                    <option value="Student">Students Only</option>
                    <option value="Admin">Admins Only</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer; padding: 12px; font-weight: 600;">Post Announcement</button>
        </form>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
