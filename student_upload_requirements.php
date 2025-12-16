<?php
session_start();

// if not logged in, redirect to login
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit;
}

// include connection
include 'connection.php';

// fetch student info
$student_id = $_SESSION['student_id'];
$stmt = $conn->prepare("SELECT full_name, profile_image FROM students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// profile image path
$profileImage = !empty($user['profile_image']) ? "uploads/" . $user['profile_image'] : "assets/imgs/default-avatar.png";
$fullName = $user['full_name'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form IX & Graduation Application Portal</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/styles.css">
        <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        .user-info {
      display: flex;
      align-items: center;
      gap: 10px; /* space between image and name */
    }

    .user img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .username {
      font-weight: 600;
      color: #0b2540; /* dark text */
      font-size: 14px;
      white-space: nowrap;
    }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                             <img src="assets/imgs/lc.png" alt="Student Account" class="img-fluid" style="width: 70px; height:70px; margin-top: 5px;">
                        </span>
                        <span class="title" style="margin-top: 10px;">Student Portal</span>
                    </a>
                </li>

                <li>
                    <a href="student_dashboard.php">
                        <span class="icon">
                            <i class="fa fa-dashboard" style="font-size: 1.75rem;"></i>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="student_new_application.php">
                        <span class="icon">
                            <i class="fa fa-pencil-square-o" style="font-size: 1.75rem;"></i>
                        </span>
                        <span class="title">New Application</span>
                    </a>
                </li>

                <li>
                    <a href="student_application_status.php">
                        <span class="icon">
                            <i class="fa fa-folder-open-o" style="font-size: 1.75rem;"></i>
                        </span>
                        <span class="title">Application Status</span>
                    </a>
                </li>

                <li>
                    <a href="student_upload_requirements.php">
                        <span class="icon">
                            <i class="fa fa-cloud-upload" style="font-size: 1.75rem;"></i>
                        </span>
                        <span class="title">Re-upload Requirements</span>
                    </a>
                </li>
                <li>
                    <a href="student_user_profile.php">
                        <span class="icon">
                            <i class="fa fa-user-o" style="font-size: 1.75rem;"></i>
                        </span>
                        <span class="title">Profile</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <span class="icon">
                        <i class="fa fa-sign-out" style="font-size: 1.75rem;"></i>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                  <h3 style="font-size: 18px; font-weight: 600;color: #0b2540; white-space: nowrap; overflow: hidden;text-overflow: ellipsis;max-width: 100%;">
                  Form IX & Graduation Application Portal
                </h3>


                <div class="user-info">
                  <div class="user">
                    <img src="<?php echo $profileImage; ?>" alt="Profile">
                  </div>
                  <span class="username">
                    <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                  </span>
                </div>

            </div>


          </div>
    </div>



                <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("uploadDocsForm").addEventListener("submit", function (e) {

    const appPdf = document.getElementById("appPdf").files.length;
    const validDocs = document.getElementById("validDocs").files.length;

    if (appPdf === 0) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "Application Form Missing",
            text: "Please upload your Application for Graduation Form (PDF).",
            confirmButtonColor: "#f59e0b"
        });
        return;
    }

    if (validDocs < 5) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "Incomplete Documents",
            text: "You must upload ALL required documents: F138, F137, Birth Certificate, Good Moral & SHS Diploma.",
            confirmButtonColor: "#f59e0b"
        });
        return;
    }
});
</script>

</body>

</html>