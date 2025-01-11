<?php
include '../config/conn.php';
session_start();

$appliedProjectsSql = "SELECT `id`, `Project_Title`, `group_leader`, `members`, `language_used`, `status`, `creation_date` 
                       FROM projects 
                       WHERE user_id = '{$_SESSION['student_id']}' 
                       AND `status` = 'pending' 
                       ORDER BY `creation_date` DESC";
$appliedProjects = $conn->query($appliedProjectsSql);

// Fetch accepted projects
$acceptedProjectsSql = "SELECT p.Project_Title, p.status, s.full_name AS supervisor_name, ps.requirement 
                         FROM projects p 
                         JOIN project_supervisor_assign ps ON p.id = ps.project_Id 
                         JOIN supervisors s ON s.id = ps.supervisor_id   
                         WHERE `status` = 'approved' AND p.user_id = '{$_SESSION['student_id']}'";
$acceptedProjects = $conn->query($acceptedProjectsSql);

// Fetch rejected projects
$rejectedProjectsSql = "SELECT `Project_Title`, `status`, `rejection_reason` 
                         FROM `projects` 
                         WHERE `status` = 'rejected' AND user_id = '{$_SESSION['student_id']}'";
$rejectedProjects = $conn->query($rejectedProjectsSql);
?>


    <style>
       

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .section-title {
            font-weight: bold;
            color: #333333;
            margin-top: 40px;
            text-transform: uppercase;
        }

        .project-card {
            border: 1px solid #e0e0e0;
            margin-bottom: 15px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .project-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-sm {
            font-size: 0.9rem;
        }

        .accepted-project {
            border-left: 5px solid #28a745;
        }

        .rejected-project {
            border-left: 5px solid #dc3545;
        }

        .text-muted {
            font-size: 0.9rem;
        }

        .animate-fade {
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .update-btn, .delete-btn {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 20px;
            color: #fff;
        }
        .status-approved {
            background-color: #28a745;
        }
        .status-rejected {
            background-color: #dc3545;
        }

        .update-btn:hover {
            background-color: #218838;
            color: #ffffff;
        }

        .delete-btn:hover {
            background-color: #c82333;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="container">
    <?php if ($appliedProjects->num_rows > 0): ?>
        <h2 class="text-center section-title">Projects You Have Applied</h2>
        <?php while ($row = $appliedProjects->fetch_assoc()): 
            $creation_date = new DateTime($row['creation_date']);
            $current_date = new DateTime();
            $interval = $current_date->diff($creation_date);

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
            <div class="project-card animate-fade">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <h5 class="mb-0 text-dark"> <?= $row['Project_Title'] ?></h5>
                    </div>
                    <div class="col-md-3 text-secondary">
                        <p class="mb-0"> <?= $row['group_leader'] ?></p>
                    </div>
                    
                    <div class="col-md-2 text-secondary">
                        <p class="mb-0 "><?= $row['language_used'] ?></p>
                    </div>
                    <div class="col-md-2 text-muted">
                        <p class="mb-0">&#x23F3; <?= $time_ago ?></p>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-primary btn-sm me-2 update-btn" onclick="updateProject(<?= $row['id'] ?>)">Update</button>
                        <button class="btn btn-danger btn-sm delete-btn" onclick="deleteProject(<?= $row['id'] ?>)">Delete</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php if ($acceptedProjects->num_rows > 0): ?>
        <h2 class="text-center section-title">Accepted Projects</h2>
        <?php while ($row = $acceptedProjects->fetch_assoc()): ?>
            <div class="project-card accepted-project animate-fade">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="mb-0 text-dark"> <?= $row['Project_Title'] ?></h5>
                    </div>
                    <div class="col-md-3 text-secondary">
                        <span class="status-badge status-approved">Approved</span>
                    </div>
                    <div class="col-md-3 text-secondary">
                        <p class="mb-0">Supervisor: <?= $row['supervisor_name'] ?></p>
                    </div>
                    <div class="col-md-2 text-secondary">
                        <p class="mb-0">Requirement: <?= $row['requirement'] ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php if ($rejectedProjects->num_rows > 0): ?>
        <h2 class="text-center section-title">Rejected Projects</h2>
        <?php while ($row = $rejectedProjects->fetch_assoc()): ?>
            <div class="project-card rejected-project animate-fade">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="mb-0 text-dark"> <?= $row['Project_Title'] ?></h5>
                    </div>
                    <div class="col-md-3 text-secondary">
                        <span class="status-badge status-rejected">Rejected</span>
                    </div>
                    <div class="col-md-5 text-secondary">
                        <p class="mb-0">Reason: <?= $row['rejection_reason'] ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>


<script>
    function updateProject(projectId) {
        window.location.href = `update_project.php?id=${projectId}`;
    }

    function deleteProject(projectId) {
        if (confirm('Are you sure you want to delete this project?')) {
            window.location.href = `delete_project.php?id=${projectId}`;
        }
    }
</script>

