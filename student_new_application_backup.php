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
    <!-- Add these libraries before your script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

 <style>
    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
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
/* === Graduation Application Form Styles (scoped) === */
.grad-form {
  --ink: #222;
  --muted: #4b5563;
  --border: #c7c7c7;
  font: 14px/1.3 "Times New Roman", Times, serif;
  color: var(--ink);
}

.grad-form * {
  box-sizing: border-box;
}

.grad-form .page {
  width: 794px;
  min-height: 1123px;
  margin: 20px auto;
  background: #fff;
  border: 1px solid #e5e7eb;
  padding: 28px 32px 40px;
}

.grad-form header {
  display: grid;
  grid-template-columns: 90px 1fr 160px;
  align-items: center;
  column-gap: 16px;
  margin-bottom: 8px;
}

.grad-form .logo {
  height: 72px;
  width: 72px;
  border: 1px solid var(--border);
  display: grid;
  place-items: center;
  font-size: 10px;
  color: var(--muted);
}

.grad-form .school h1 {
  margin: 0 0 4px 0;
  font-size: 18px;
  letter-spacing: .3px;
  text-transform: uppercase;
}

.grad-form .school .sub { 
  color: var(--muted); 
  font-size: 12px; 
}

.grad-form .title { 
  text-align: center; 
  margin: 10px 0 18px; 
}

.grad-form .title h2 { 
  margin: 0; 
  font-size: 16px; 
}

.grad-form .line {
  border: none;
  border-bottom: 1px solid var(--ink);
  padding: 2px 4px;
  background: transparent;
  font: inherit;
}

.grad-form .line.sm { min-width: 120px; }
.grad-form .line.lg { min-width: 360px; }

.grad-form .signature-line {
  display: flex;
  justify-content: flex-end;
  margin: 24px 0 12px;
}

.grad-form .sig {
  width: 360px;
  border-top: 1px solid var(--ink);
  text-align: center;
  padding-top: 4px;
  font-style: italic;
}

.grad-form .comments { 
  border: 1px solid var(--border); 
  padding: 10px; 
  margin-top: 8px; 
}

.grad-form .comments .row { 
  margin-bottom: 6px; 
}

.grad-form textarea.lines {
  width: 100%;
  height: 80px;
  border: 1px solid var(--border);
  background-image: linear-gradient(to bottom, transparent 24px, var(--border) 25px);
  background-size: 100% 25px;
  line-height: 25px;
  padding: 6px 8px;
  font: inherit;
  resize: vertical;
}
  #downloadDocBtn {
    position: fixed; /* stays visible when scrolling */
    top: 60px;       /* distance from top */
    right: 20px;     /* distance from right */
    background-color: #4CAF50; /* green background */
    color: white;    /* white text */
    border: none;
    padding: 10px 18px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    transition: background-color 0.3s ease;
    z-index: 1000;   /* appear above other elements */
  }

  #downloadDocBtn:hover {
    background-color: #45a049;
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
                            <i class="fa fa-sticky-note-o" style="font-size: 1.75rem;"></i>
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
        <button id="downloadDocBtn"><i class="fa fa-cloud-download"></i> Download as PDF</button>
            <!-- === Graduation Application Form === -->
            <div class="grad-form-container" style="overflow-x:auto;">
            <div class="grad-form" >
              <div class="page" id="gradFormPage">
                <header>
                  <div class="logo">
                    <img src="assets/imgs/lc.png" alt="School Logo" style="max-width: 100%; max-height: 100%;">
                  </div>
                  <div class="school">
                    <h1>Lemery Colleges</h1>
                    <div class="sub">Lemery, Batangas</div>
                    <div class="sub">Office of the Registrar</div>
                  </div>
                  <div class="right">
                    Date: <input class="line sm" type="text">
                  </div>
                </header>

                <div class="title"><h2>APPLICATION FOR GRADUATION</h2></div>

                <p>
                  Madam: <br>
                  I have the honor to apply for graduation this 
                  <input class="line sm" type="text"> Semester of School Year 
                  <input class="line sm" type="text"> for the Degree/Title of 
                  <input class="line lg" type="text">.<br>
                  Major/Area of Specialization: <input class="line lg" type="text"> <br>
                  Attached herewith is a checklist of all subjects I have already finished with the corresponding grades and units earned for final evaluation.
                </p>

                <!-- ✅ Signature Section -->
                <div class="signature-section" style="text-align:center; margin-top:30px; margin-left: 365px;">

                  <!-- Upload Signature -->
                  <label for="signatureUpload" style="cursor:pointer; display:inline-block;">
                    <img id="signaturePreview" src="assets/imgs/sign-placeholder.png" 
                         alt="Click to upload signature" 
                         style="max-width:250px; max-height:100px;">
                  </label>
                  <input type="file" id="signatureUpload" accept="image/*" style="display:none;" 
                         onchange="previewSignature(event)">

                  <!-- Name and Line -->
                  <div style="margin-top:10px;">
                          <p style="font-weight:600; margin:0;">
                        <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                      </p>
                    <div style="border-top:1px solid #000; width:360px; margin:0 auto; padding-top:4px;">
                    </div>
                    <div style="margin-top:4px; font-style:italic; font-size:14px;">
                      (Signature of Applicant over Printed Name)
                    </div>
                  </div>
                </div>


                <div class="comments">
                  <div class="row">Lack Units in: <input class="line lg" type="text"></div>
                  <div class="row">Lacking Requirements: <input class="line lg" type="text"></div>
                  <div class="row">Incomplete Grades in: <input class="line lg" type="text"></div>
                  <div class="row">Conditional Grades in: <input class="line lg" type="text"></div>
                  <div class="row">Recommendations: <input class="line lg" type="text"></div>
                </div>
            <!-- ✅ Signature Section -->
            <div class="signature-section" style="text-align:center; margin-top:30px; margin-left:365px;">

              <!-- New Inputs Section -->
              <div style="text-align:left; margin-top:20px; width:360px; margin-left:auto; margin-right:auto;">
                
                <div class="row" style="margin-bottom:10px;">
                  Evaluator Signature:  
                  <!-- Upload Signature -->
                  <label for="evaluatorUpload" style="cursor:pointer; display:inline-block;">
                    <img id="evaluatorPreview" src="assets/imgs/sign-placeholder.png" 
                         alt="Click to upload signature" 
                         style="max-width:250px; max-height:100px;">
                  </label>
                  <input type="file" id="evaluatorUpload" accept="image/*" style="display:none;" 
                         onchange="previewEvaluatorSignature(event)">
                </div>

                <div class="row">
                  Date: <input class="line sm" type="text">
                </div>

              </div>

            </div>


        <div style="text-align:left; margin-top:20px;">
          <div class="row">NOTED:<input class="line lg" type="text"><br><div class="row">Course Coordinator:<input class="line lg" type="text">
        </div>

        <h4 style="margin-top:20px; margin-bottom: 10px;">Please accomplish this portion</h4>
        <p>
          Family Name: <input class="line sm" type="text"> 
          First Name: <input class="line sm" type="text"> 
          Middle Name: <input class="line sm" type="text">
        </p>
        <p>
          Student Number: <input class="line sm" type="text"> 
          Birthdate: <input class="line sm" type="text"> 
          Cell Phone: <input class="line sm" type="text">
        </p>
        <p>
          Email Address: <input class="line lg" type="text"> 
          Home Address: <input class="line lg" type="text">
        </p>
        <p>
          Elementary School: <input class="line sm" type="text"> 
          Year: <input class="line sm" type="text">
        </p>
        <p>
          High School: <input class="line sm" type="text"> 
          Year: <input class="line sm" type="text">
        </p>
        <p>Course/Degree: <input class="line lg" type="text"></p>
        <p>Major: <input class="line lg" type="text"></p>
        <p>
          Thesis Title: <br>
          <textarea class="lines"></textarea>
        </p>

        <!-- ✅ Signature Section -->
        <div class="signature-section" style="text-align:center; margin-top:30px; margin-left:365px;">

          <!-- Upload Signature -->
          <label for="graduateSignatureUpload" style="cursor:pointer; display:inline-block;">
            <img id="graduateSignature" src="assets/imgs/sign-placeholder.png" 
                 alt="Click to upload signature" 
                 style="max-width:250px; max-height:100px;">
          </label>
          <input type="file" id="graduateSignatureUpload" accept="image/*" style="display:none;" 
                 onchange="previewGraduateSignature(event)">

          <!-- Name and Line -->
          <div style="margin-top:10px;">
            <p style="font-weight:600; margin:0;">
              <?php echo htmlspecialchars($_SESSION['full_name']); ?>
            </p>
            <div style="border-top:1px solid #000; width:360px; margin:0 auto; padding-top:4px;"></div>
            <div style="margin-top:4px; font-style:italic; font-size:14px;">
              (Signature of Applicant over Printed Name)
            </div>
          </div>
        </div>

    <p>
      Name of siblings who already graduated: <br>
      <textarea class="lines"></textarea>
    </p>

    <div style="text-align:right; margin-top:20px;">
      MER JANE P. LANDICHO, LPT <br>Registrar <br><div class="row">Date: <input class="line sm" type="text"></div>
    </div>
  </div>
</div>

          </div>
    </div>

<script>
function previewSignature(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('signaturePreview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>


<!-- ✅ Preview Script -->
<script>
function previewEvaluatorSignature(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('evaluatorPreview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>

<script>
function previewGraduateSignature(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('graduateSignature').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>

<script>
  const downloadBtn = document.getElementById('downloadDocBtn');

    // Get the PHP session name into JS
  const studentName = "<?= htmlspecialchars($_SESSION['full_name']); ?>";

  downloadBtn.addEventListener('click', async () => {
    const gradFormPage = document.getElementById('gradFormPage');

    // Take a screenshot of the form
    const canvas = await html2canvas(gradFormPage, {
      scale: 2,
      useCORS: true
    });

    const imgData = canvas.toDataURL('image/png');

    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'pt', 'a4');

    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = pdf.internal.pageSize.getHeight();

    const imgWidth = canvas.width;
    const imgHeight = canvas.height;
    const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);

    const imgPDFWidth = imgWidth * ratio;
    const imgPDFHeight = imgHeight * ratio;

    // Center the image
    const xOffset = (pdfWidth - imgPDFWidth) / 2;
    const yOffset = (pdfHeight - imgPDFHeight) / 2;

    pdf.addImage(
      imgData,
      'PNG',
      xOffset,
      yOffset,
      imgPDFWidth,
      imgPDFHeight
    );

    pdf.save(`${studentName}_Graduation_Application.pdf`);
  });
</script>

                <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>