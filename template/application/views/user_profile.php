<?php
session_start();
include '../config/conn.php';

// Fetch user details
$user_id = $_SESSION['user_id']; // Ensure user ID is stored in session after login
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>



<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                <?php
                            $imagePath = "application/uploads/" . ($_SESSION['image'] ?? 'default.png');
                                ?>
                    <img src="<?php  echo $imagePath ?>" class="img-thumbnail rounded-circle mb-3" alt="Profile Image" width="150">
                    <h5><?php echo htmlspecialchars($user['username']); ?></h5>
                    <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Profile</h5>
                    <form id="profileForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'application/api/update_profile.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                alert(data.message);
                if (data.success) {
                    location.reload();
                }
            },
            error: function() {
                alert('An error occurred while updating the profile.');
            }
        });
    });
});
</script>
</body>
</html>
