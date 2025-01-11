<?php
include '../config/conn.php';
session_start();

// Check if admin is logged in
if ($_SESSION['Role'] !== 'admin') {
    die("Access denied");
}

// Fetch all users
$sql = "SELECT id, username, email, Role FROM users";
$result = $conn->query($sql);
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Users</h2>
    <table class="table table-bordered table-striped   ">
        <thead class="theme-bg2  text-white">
        <tr>
            <th>ID</th>
            
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['Role']) ?></td>
                <td>
                    <a href="application/views/admin_reset_password.php?user_id=<?= $row['id'] ?>" class="btn label theme-bg text-white f-12 btn-sm">Reset Password</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

