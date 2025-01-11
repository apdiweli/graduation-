<div class="pcoded-main-container">
        <div class="pcoded-wrapper f">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->

                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper form-place">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!--[ daily sales section ] start-->
                               
                                <?php
// Database connection
include 'application/config/conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count all projects
$sqlTotal = "SELECT COUNT(Project_Title) AS TotalProjects FROM projects";
$resultTotal = $conn->query($sqlTotal);
$totalProjects = $resultTotal->fetch_assoc()['TotalProjects'] ?? 0;

// Query to count accepted projects
$sqlAccepted = "SELECT COUNT(Project_Title) AS AcceptedProjects FROM projects WHERE status='Approved'";
$resultAccepted = $conn->query($sqlAccepted);
$acceptedProjects = $resultAccepted->fetch_assoc()['AcceptedProjects'] ?? 0;

// Query to count rejected projects
$sqlRejected = "SELECT COUNT(Project_Title) AS RejectedProjects FROM projects WHERE status='Rejected'";
$resultRejected = $conn->query($sqlRejected);
$rejectedProjects = $resultRejected->fetch_assoc()['RejectedProjects'] ?? 0;

$sqlPending = "SELECT COUNT(Project_Title) AS PendingProjects FROM projects WHERE status='pending'";
$resultPending = $conn->query($sqlPending);
$pendingProjects = $resultPending->fetch_assoc()['PendingProjects'] ?? 0;


$sqlSupervisors = "SELECT COUNT(full_name) AS supervisor FROM supervisors";
$resultSupervisors = $conn->query($sqlSupervisors);
$totalSupervisors = $resultSupervisors->fetch_assoc()['supervisor'] ?? 0;


$sqlUsers = "SELECT COUNT(username) AS username FROM users";
$resultUsers = $conn->query($sqlUsers);
$totalUsers = $resultUsers->fetch_assoc()['username'] ?? 0;
?>




                                        <div class="col-md-6 col-xl-4">
                                            <div class="card daily-sales">
                                                <div class="card-block">
                                                    <h6 class="mb-4">Projects Taken</h6>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-9">
                                                            <h4 class="f-w-300 d-flex align-items-center m-b-0">
                                                                <i class="feather icon-pocket text-c-green f-30 m-r-10"></i>
                                                                <?php echo $totalProjects; ?> project<?php echo $totalProjects > 1 ? 's' : ''; ?>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="progress m-t-30" style="height: 7px;">
                                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4">
                                            <div class="card daily-sales">
                                                <div class="card-block">
                                                    <h6 class="mb-4">Accepted Projects</h6>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-9">
                                                            <h4 class="f-w-300 d-flex align-items-center m-b-0">
                                                                <i class="feather icon-check-circle text-c-green f-30 m-r-10"></i>
                                                                <?php echo $acceptedProjects; ?> accepted
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="progress m-t-30" style="height: 7px;">
                                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-4">
                                            <div class="card daily-sales">
                                                <div class="card-block">
                                                    <h6 class="mb-4">Rejected Projects</h6>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-9">
                                                            <h4 class="f-w-300 d-flex align-items-center m-b-0">
                                                                <i class="feather icon-x-circle text-c-red f-30 m-r-10"></i>
                                                                <?php echo $rejectedProjects; ?> rejected
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="progress m-t-30" style="height: 7px;">
                                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-xl-4">
                                            <div class="card daily-sales">
                                                <div class="card-block">
                                                    <h6 class="mb-4">Pending Projects</h6>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-9">
                                                            <h4 class="f-w-300 d-flex align-items-center m-b-0">
                                                                <i class="feather icon-clock text-c-yellow f-30 m-r-10"></i>
                                                                <?php echo $pendingProjects; ?> pending
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="progress m-t-30" style="height: 7px;">
                                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                             </div>
                                        </div>

                                        <div class="col-md-6 col-xl-4">
                                            <div class="card daily-sales">
                                                <div class="card-block">
                                                    <h6 class="mb-4">Supervisors</h6>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-9">
                                                            <h4 class="f-w-300 d-flex align-items-center m-b-0">
                                                                <i class="feather icon-users text-c-blue f-30 m-r-10"></i>
                                                                <?php echo $totalSupervisors; ?> supervisor<?php echo $totalSupervisors > 1 ? 's' : ''; ?>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="progress m-t-30" style="height: 7px;">
                                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>



                                    <div class="col-md-6 col-xl-4">
                                            <div class="card daily-sales">
                                                <div class="card-block">
                                                    <h6 class="mb-4">Users</h6>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-9">
                                                            <h4 class="f-w-300 d-flex align-items-center m-b-0">
                                                                <i class="feather icon-user text-c-purple f-30 m-r-10"></i>
                                                                <?php echo $totalUsers; ?> user<?php echo $totalUsers > 1 ? 's' : ''; ?>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <div class="progress m-t-30" style="height: 7px;">
                                                        <div class="progress-bar progress-c-theme" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <?php
                                        // Calculate percentages
                                        $totalProjects = max($totalProjects, 1); // Prevent division by zero
                                        $acceptedPercentage = round(($acceptedProjects / $totalProjects) * 100, 2);
                                        $rejectedPercentage = round(($rejectedProjects / $totalProjects) * 100, 2);
                                        $pendingPercentage = round(($pendingProjects / $totalProjects) * 100, 2);
                                    ?>



                                    <div class="col-md-12 col-xl-6">
                                        <div class="card">
                                            <div class="card-block">
                                                <h6 class="mb-4">Project Status Distribution</h6>
                                                <canvas id="projectPieChart" width="400" height="400"></canvas>
                                            </div>
                                        </div>
                                    </div>


                                
                         
                         
                                <!--[ year  sales section ] end-->
                                <!--[ Recent Users ] start-->
                            <div class="row">
                            <div class="col-xl-1 col-md-2 "> </div>
                                <div class="col-xl-10 col-md-6 ">
                                    <div class="card Recent-Users">
                                        <div class="card-header">
                                            <h5>Recent projects applied</h5>
                                        </div>
                                        <div class="card-block px-0 py-3">
                                            <div class="table-responsive">
                                    <table class="table table-hover" id="displayDashboard">
                                           <?php
                                           include("application/config/conn.php");
                                           
                                                                                // Check connection
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }

                                            // SQL query
                                            $sql = "select p.id, u.image ,p.Project_Title,u.username,p.creation_date from  projects p join users u on p.user_id=u.student_id  where p.status='Pending' ORDER BY p.creation_date DESC";
                                            $result = $conn->query($sql);
                                            ?>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $imagePath = !empty($row['image']) 
                                                    ? "application/uploads/" . $row['image'] 
                                                    : "application/uploads/default.png";
                                                    $projectTitle = htmlspecialchars($row['Project_Title']);
                                                    $username = htmlspecialchars($row['username']);
                                                    $creationDate = date("Y-m-d", strtotime($row['creation_date']));
                                                    echo "
                                                    <tr class='unread'>
                                                        <td><img class='rounded-circle' style='width:40px;' src='$imagePath' alt='activity-user'></td>
                                                        <td>
                                                            <h6 class='mb-1'>$projectTitle</h6>
                                                            <p class='m-0'>$username</p>
                                                        </td>
                                                        <td>
                                                            <h6 class='text-muted'><i class='fas fa-circle text-c-green f-10 m-r-15'></i>$creationDate</h6>
                                                        </td>
                                                        <td>
                                                            <a href='reject.php?id={$row['id']}' class='label theme-bg2 text-white f-12'>Reject</a>
                                                            <a href='approve.php?id={$row['id']}' class='label theme-bg text-white f-12'>Approve</a>
                                                        </td>
                                                    </tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='4' class='text-center'>No projects found.</td></tr>";
                                            }
                                            ?>
                                               </tbody>
                                    </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                             

                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data from PHP
    const acceptedPercentage = <?php echo $acceptedPercentage; ?>;
    const rejectedPercentage = <?php echo $rejectedPercentage; ?>;
    const pendingPercentage = <?php echo $pendingPercentage; ?>;

    // Create the pie chart
    const ctx = document.getElementById('projectPieChart').getContext('2d');
    const projectPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Accepted', 'Rejected', 'Pending'],
            datasets: [{
                data: [acceptedPercentage, rejectedPercentage, pendingPercentage],
                backgroundColor: ['#4CAF50', '#F44336', '#FFC107'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ${value}%`;
                        }
                    }
                }
            }
        }
    });
</script>
