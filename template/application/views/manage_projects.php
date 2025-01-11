<?php
include '../config/conn.php';

// Fetch all projects

$sql = "SELECT `id`,`Project_Title`, `group_leader`, `group_name`, `members`, `language_used`, `status`, `creation_date` 
        FROM projects 
        WHERE `status` = 'Pending' 
        ORDER BY `creation_date` DESC";

$result = $conn->query($sql);
?>


<div class="container mt-4">
<h2 class="text-center mb-4">Projects Applied</h2>
</div>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): 
        // Calculate time difference
        $creation_date = new DateTime($row['creation_date']);
        $current_date = new DateTime();
        $interval = $current_date->diff($creation_date);

        // Format time difference
        if ($interval->y > 0) {
            $time_ago = $interval->y . 'y ago';
        } elseif ($interval->m > 0) {
            $time_ago = $interval->m . 'm ago';
        } elseif ($interval->d > 0) {
            $time_ago = $interval->d . 'd ago';
        } elseif ($interval->h > 0) {
            $time_ago = $interval->h . 'hr ago';
        } elseif ($interval->i > 0) {
            $time_ago = $interval->i . 'min ago';
        } else {
            $time_ago = 'Just now';
        }
    ?>
        <div class="container mt-4">
   
    <div class="row mb-3 p-3 bg-light rounded shadow-sm align-items-center">
        <div class="col-md-3">
            <h5 class="mb-0 text-dark"><?= $row['Project_Title'] ?></h5>
        </div>
        <div class="col-md-3 text-secondary">
            <p class="mb-0"><?= $row['group_leader'] ?></p>
        </div>
        <div class="col-md-2 text-secondary">
            <p class="mb-0"><?= $row['language_used'] ?></p>
        </div>
        <div class="col-md-2 text-muted">
            <p class="mb-0"><?= $time_ago ?></p>
        </div>
        <div class="col-md-2 text-end">
        <button class="btn btn-primary btn-sm me-2 accept-btn" data-id="<?= $row['id'] ?>">Accept</button>
        <button class="btn btn-info btn-sm reject-btn" data-id="<?= $row['id'] ?>">Reject</button>
        </div>
    </div>

</div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="text-center">No projects found.</div>
<?php endif; ?>

    


      <style>
      body {
    background-color: #f8f9fa; /* Light gray background */
}

h2 {
    font-weight: bold;
    color: #333333;
}

.row {
    border: 1px solid #e0e0e0;
    margin-bottom: 15px;
}

p, h5 {
    margin: 0;
}

button {
    font-size: 0.9rem;
}


      </style>



<?php
// Fetch supervisors for the dropdown
$supervisorQuery = "SELECT id, full_name FROM supervisors";
$supervisors = $conn->query($supervisorQuery);

if (!$supervisors) {
    // Log the error and display a user-friendly message
    die("Error fetching supervisors: " . $conn->error);
}
?>




<div class="modal" tabindex="-1" id="apply_model">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Project Approving </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" id="student_form">
                                                                            <div class="row">
                                                                                        <div class="col-12">
                                                                                                <div class="alert alert-success d-none" role="alert">
                                                                                                A simple success alert—check it out!
                                                                                                </div>
                                                                                                <div class="alert alert-danger d-none" role="alert">
                                                                                                A simple danger alert—check it out!
                                                                                                </div>
                                                                                        </div>
                                                                                <div class="col-12">
                                                                                                <div class="form-group">
                                                                                                        <label for="supervisor">Supervisor Name</label>
                                                                                                        <select name="supervisor_id" id="supervisor" class="form-control">
                                                                                                            <?php while ($result = $supervisors->fetch_assoc()): ?>
                                                                                                                <option value="<?= $result['id'] ?>">
                                                                                                                    <?= $result['full_name'] ?>
                                                                                                                </option>
                                                                                                            <?php endwhile; ?>
                                                                                                        </select>
                                                                                                </div>


                                                                               
                                                                                
                                                                                                <div class="form-group">
                                                                                                    <label for="">Requirement Details</label>
                                                                                                    <input type="text" name="Requirement" id="Requirement" class="form-control">
                                                                                                </div>

                                                                                                 <input type="hidden" name="project_id" id="accept_project_id">


                                                                                    

                                                                                    
                                                                                </div>
                                                                            </div>
                                                                                <div class="modal-footer">
                                                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                            </div>
                                                    </form>
                                                </div>
                                                
                                                </div>
                                            </div>
                                            </div>
                                            </div>
</div>


<div class="modal" tabindex="-1" id="reject_model">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Rejection Details </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" id="student_form">
                                                    <div class="row">
                                                        <div class="col-12">
                                                        <div class="alert alert-success d-none" role="alert">
                                                        A simple success alert—check it out!
                                                        </div>
                                                        <div class="alert alert-danger d-none" role="alert">
                                                        A simple danger alert—check it out!
                                                        </div>
                                                        </div>
                                                        <div class="col-12">
                                                            
                                                        
                                                            <div class="form-group">
                                                                <label for="">Reason for Rejection</label>
                                                                <textarea class="form-control" id="rejection_reason" name="rejection_reason"  rows="3"></textarea>
                                                            </div>

                                                            <input type="hidden" name="project_id" id="reject_project_id">




                                                          

                                         


                                                            

                                                            
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                                    </form>
                                                </div>
                                                
                                                </div>
                                            </div>
                                            </div>
                                            </div>
</div>



<script>

    
    $(".accept-btn").on("click", function () {

                const projectId = $(this).data("id");
                $("#accept_project_id").val(projectId); // Set project ID in hidden input
                $("#apply_model").modal("show");
                

    })


    $(".reject-btn").on("click", function () {
    const projectId = $(this).data("id");
    $("#reject_project_id").val(projectId); // Set project ID in hidden input
    $("#reject_model").modal("show");
});



           
    

    $("#student_form").on("submit", function (e) {
     e.preventDefault(); // Prevent the default form submission
    

       const formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "application/api/appreoved.php", // Update this to the correct path
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    alert(response.message);
                    $("#apply_model").modal("hide");
                    location.reload(); // Reload the page to refresh the project list
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert("An error occurred. Please try again.");
            }
        });
});



$("#reject_model form").on("submit", function (e) {
    e.preventDefault(); // Prevent the default form submission

    const formData = $(this).serialize(); // Serialize form data

    $.ajax({
        url: "application/api/project_rejection.php", // Update this to the correct path
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (response) {
            if (response.status === "success") {
                alert(response.message);
                $("#reject_model").modal("hide");
                location.reload(); // Reload the page to refresh the project list
            } else {
                alert(response.message);
            }
        },
        error: function () {
            alert("An error occurred. Please try again.");
        }
    });
});

</script>




    

  

  
