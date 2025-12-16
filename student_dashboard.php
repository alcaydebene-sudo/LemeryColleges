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

<?php
include "connection.php";

// 🔎 Count students
$countSql = "SELECT COUNT(*) AS total FROM students";
$result = $conn->query($countSql);
$totalStudents = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalStudents = $row['total'];
}
?>

<?php
include "connection.php";

$student_id = $_SESSION['student_id'] ?? null;
if (!$student_id) {
    die("Student not logged in.");
}

// 🔎 Count this student's records in `student_documents`
$countSql = "SELECT COUNT(*) AS total FROM student_documents WHERE student_id = ?";
$stmt = $conn->prepare($countSql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$totalStudent_Documents = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalStudent_Documents = $row['total'];
}
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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .username {
            font-weight: 600;
            color: #0b2540;
            font-size: 14px;
            white-space: nowrap;
        }

        /* ✅ Responsive Lemery Colleges Info Box Layout */
        .info-container {
            margin: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .info-box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }

        .info-box h2 {
            color: #0b2540;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .info-box p, .info-box ul {
            color: #333;
            line-height: 1.6;
            margin: 0;
        }

        .info-box ul {
            list-style: disc;
            padding-left: 20px;
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

                <li><a href="student_dashboard.php"><span class="icon"><i class="fa fa-dashboard" style="font-size: 1.75rem;"></i></span><span class="title">Dashboard</span></a></li>
                <li><a href="student_new_application.php"><span class="icon"><i class="fa fa-pencil-square-o" style="font-size: 1.75rem;"></i></span><span class="title">New Application</span></a></li>
                <li><a href="student_application_status.php"><span class="icon"><i class="fa fa-folder-open-o" style="font-size: 1.75rem;"></i></span><span class="title">Application Status</span></a></li>
                <li><a href="student_user_profile.php"><span class="icon"><i class="fa fa-user-o" style="font-size: 1.75rem;"></i></span><span class="title">Profile</span></a></li>
                <li><a href="logout.php"><span class="icon"><i class="fa fa-sign-out" style="font-size: 1.75rem;"></i></span><span class="title">Sign Out</span></a></li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">

<!-- ======= TOPBAR ======= -->
<div class="topbar" style="display: flex; justify-content: flex-end; align-items: center; gap: 20px; padding: 10px 20px; background: #ffffffff; border-bottom: 1px solid #ddd;">


  
  <!-- 👤 User Info -->
  <div class="user-info" style="display:flex; align-items:center; gap:10px;">
    <div class="user">
      <img src="<?php echo $profileImage; ?>" alt="Profile">
    </div>
    <span class="username"><?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
  </div>
</div>
<!-- ======= END TOPBAR ======= -->

<!-- ✅ Lemery Colleges Info Section -->
<style>
  .info-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 24px;
    padding: 40px;
    background: #f9fafb;
    border-radius: 16px;
  }

  .info-box {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    padding: 24px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .info-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
  }

  .info-box h2 {
    color: #1e3a8a;
    font-size: 1.5rem;
    margin-bottom: 12px;
    border-bottom: 3px solid #2563eb;
    display: inline-block;
    padding-bottom: 4px;
  }

  .info-box p {
    font-size: 1rem;
    color: #374151;
    line-height: 1.6;
    text-align: justify;
  }

  .info-box ul {
    list-style-type: none;
    padding-left: 0;
  }

  .info-box ul li {
    background: #eef2ff;
    margin: 6px 0;
    padding: 10px 14px;
    border-radius: 8px;
    color: #1e3a8a;
    font-weight: 500;
  }

  @media (max-width: 768px) {
    .info-container {
      padding: 20px;
      gap: 16px;
    }
  }
</style>

<div class="info-container">
  <div class="info-box">
    <h2>Vision</h2>
    <p>"Expanding the Right Choice for Real Life Education in Southern Luzon."</p>
  </div>

  <div class="info-box">
    <h2>Mission</h2>
    <p>
      Cognizant to the vital role of real-life education, LC is committed to:
    </p>
    <ul>
      <li>Provide holistic higher education and technical-vocational programs which are valued by the stakeholders. <strong>(Academics)</strong></li>
      <li>Transform the youth into world-class professionals who creatively respond to the ever-changing world of work. <strong>(Graduates)</strong></li>
      <li>Advance research production to improve human life and address societal needs. <strong>(Research)</strong></li>
      <li>Engage in various projects that aim to build strong community relations and involvement. <strong>(Community)</strong></li>
      <li>Promote compliance with quality assurance in both service delivery and program development. <strong>(Quality Assurance)</strong></li>
    </ul>
  </div>

  <div class="info-box">
    <h2>Core Values</h2>
    <ul>
      <li>L – Love of God and Country</li>
      <li>C’s – Competent, Committed, and Compassionate in Service</li>
      <li>I – Innovative Minds</li>
      <li>A – Aspiring People</li>
      <li>N – Noble Dreams</li>
    </ul>
  </div>

  <div class="info-box">
    <h2>Quality Policy</h2>
    <p>
      Lemery Colleges is committed to uphold the highest standards of quality in education, service delivery, and program development, ensuring that every student is equipped with the knowledge, skills, and values necessary to become champions in life.
    </p>
  </div>
</div>
<!-- ✅ End of Lemery Colleges Info Section -->

<!-- =========== Scripts =========  -->
<script src="assets/js/main.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
  document.getElementById("notifBell").addEventListener("click", function() {
    const notif = document.getElementById("notifDropdown");
    const act = document.getElementById("activityDropdown");
    notif.style.display = notif.style.display === "block" ? "none" : "block";
    act.style.display = "none";
  });

  document.getElementById("activityBell").addEventListener("click", function() {
    const act = document.getElementById("activityDropdown");
    const notif = document.getElementById("notifDropdown");
    act.style.display = act.style.display === "block" ? "none" : "block";
    notif.style.display = "none";
  });

  window.addEventListener("click", function(e) {
    if (!e.target.closest("#notifBell") && !e.target.closest("#notifDropdown") &&
        !e.target.closest("#activityBell") && !e.target.closest("#activityDropdown")) {
      document.getElementById("notifDropdown").style.display = "none";
      document.getElementById("activityDropdown").style.display = "none";
    }
  });
</script>

</body>
</html>
