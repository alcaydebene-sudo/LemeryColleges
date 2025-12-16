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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    /* === Student Profile Form Styles (scoped) === */
    .grad-form {
      --ink: #222;
      --muted: #4b5563;
      --border: #c7c7c7;
      font: 14px/1.4 "Times New Roman", Times, serif;
      color: var(--ink);
    }

    .grad-form * { box-sizing: border-box; }

    .grad-form .page {
      width: 1000px; /* wider to fit both sections */
      margin: 20px auto;
      background: #fff;
      border: 1px solid #e5e7eb;
      padding: 28px 32px 40px;
      display: flex;       /* flexbox for side by side */
      gap: 20px;
    }

    .grad-form .profile {
      flex: 1; /* main content expands */
    }

    .grad-form .title { 
      text-align: center; 
      margin: 0 0 18px; 
    }

    .grad-form .title h2 { 
      margin: 0; 
      font-size: 16px; 
      text-transform: uppercase;
    }

    .grad-form .row {
      margin-bottom: 6px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
    }

    .grad-form label {
      min-width: 140px;
      margin-right: 6px;
    }

    .grad-form .line {
      border: none;
      border-bottom: 1px solid var(--ink);
      background: transparent;
      font: inherit;
      padding: 2px 4px;
      flex: 1;
      min-width: 120px;
    }

    .grad-form .line.sm { max-width: 120px; }
    .grad-form .line.md { max-width: 250px; }
    .grad-form .line.lg { max-width: 360px; }

    .grad-form .section {
      margin: 12px 0;
    }

    /* === Assessment box === */
    .grad-form .assessment {

      width: 300px;
      flex-shrink: 0; /* fixed width */
      align-self: flex-start; /* align with top */
    }

    .grad-form .assessment h3 {
      margin: 0 0 10px;
      font-size: 15px;
      text-align: center;
      text-transform: uppercase;
    }

    .grad-form .assessment .row {
      justify-content: space-between;
    }

    .grad-form .total {
      margin-top: 10px;
      font-weight: bold;
    }

    .grad-form .checkboxes span {
      margin-right: 12px;
    }

    .grad-form .signature-line {
      margin-top: 30px;
    }

    .grad-form .sig {
      width: 260px;
      border-top: 1px solid var(--ink);
      text-align: center;
      padding-top: 4px;
      font-style: italic;
      margin: 0 auto;
    }
    .grad-form .row span {
    margin-right: 5px; /* adjust spacing */
    }
/* === Shared style for button === */
#proceedBtn {
  background-color: #4CAF50; /* default green */
  color: white;
  border: none;
  padding: 10px 18px;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  box-shadow: 0 4px 6px rgba(0,0,0,0.2);
  transition: background-color 0.3s ease;
}

#proceedBtn:hover {
  background-color: #45a049; /* darker green */
}


  .upload-form {
    display: flex;
    gap: 20px;
    align-items: flex-start;
    justify-content: center;
    flex-wrap: wrap;
    width: 1000px;
    margin: 20px auto;
    background: #fff;
    border: 1px solid #e5e7eb;
    padding: 28px 32px 40px;
  }

  .upload-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 15px 20px;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  }

  .upload-card h3 {
    margin-top: 0;
    font-size: 18px;
    color: #2563eb;
  }

  .upload-card .desc {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 12px;
  }

  .upload-card input[type="file"] {
    display: block;
    margin-top: 8px;
    padding: 6px;
    font-size: 14px;
    width: 100%;
  }

  .upload-actions {
    width: 100%;
    text-align: center;
    margin-top: 20px;
  }

  .upload-actions button {
    background: #2563eb;
    color: #fff;
    border: none;
    padding: 10px 18px;
    font-size: 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s ease-in-out;
    margin-bottom: 30px;
  }

  .upload-actions button:hover {
    background: #1e40af;
  }

  /* === Graduation Application Form Styles (scoped) === */
.graduation-app {
  --grad-ink: #222;
  --grad-muted: #4b5563;
  --grad-border: #c7c7c7;
  font: 14px/1.3 "Times New Roman", Times, serif;
  color: var(--grad-ink);
}

.graduation-app * {
  box-sizing: border-box;
}


.graduation-app header {
  display: grid;
  grid-template-columns: 90px 1fr 160px;
  align-items: center;
  column-gap: 16px;
  margin-bottom: 8px;
}

.graduation-logo {
  height: 72px;
  width: 72px;
  border: 1px solid var(--grad-border);
  display: grid;
  place-items: center;
  font-size: 10px;
  color: var(--grad-muted);
}

.graduation-school h1 {
  margin: 0 0 4px 0;
  font-size: 18px;
  letter-spacing: .3px;
  text-transform: uppercase;
}

.graduation-school .graduation-sub { 
  color: var(--grad-muted); 
  font-size: 12px; 
}

.graduation-title { 
  text-align: center; 
  margin: 10px 0 18px; 
}

.graduation-title h2 { 
  margin: 0; 
  font-size: 16px; 
}

.graduation-input {
  border: none;
  border-bottom: 1px solid var(--grad-ink);
  padding: 2px 4px;
  background: transparent;
  font: inherit;
}

.graduation-input.sm { min-width: 120px; }
.graduation-input.lg { min-width: 360px; }

.graduation-signature {
  margin: 25px 0 12px;
}

.graduation-sig-line {
  width: 360px;
  border-top: 1px solid var(--grad-ink);
  text-align: center;
  padding-top: 4px;
  font-style: italic;
}

.graduation-comments { 
  border: 1px solid var(--grad-border); 
  padding: 10px; 
  margin-top: 8px; 
}

.graduation-comments .graduation-row { 
  margin-bottom: 6px; 
}

.graduation-textarea {
  width: 100%;
  height: 80px;
  border: 1px solid var(--grad-border);
  background-image: linear-gradient(to bottom, transparent 24px, var(--grad-border) 25px);
  background-size: 100% 25px;
  line-height: 25px;
  padding: 6px 8px;
  font: inherit;
  resize: vertical;
}
.modal {
  display: none; /* hidden by default */
  position: fixed;
  inset: 0; /* shorthand for top, right, bottom, left = 0 */
  z-index: 1000;
  background: rgba(0, 0, 0, 0.5); /* dim background */
}

.modal-content {
  background: #fff;
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 40px 60px;
  border-radius: 0; /* remove rounded corners for full fit */
  box-shadow: none; /* no shadow for clean fullscreen look */
  overflow-y: auto; /* only vertical scroll inside modal if content is long */
  overflow-x: hidden;
  text-align: left;
  position: relative;
}

.modal-buttons {
  margin-top: 30px;
  text-align: right;
}

.modal-buttons button {
  padding: 10px 22px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  margin-left: 10px;
  font-size: 15px;
}

.modal-buttons .cancel {
  background: #ccc;
}

.modal-buttons .confirm {
  background: #2563eb;
  color: white;
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
                  <!-- =========================Form IX & Graduation Application Portal==================== -->
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



<div class="grad-form-container" style="overflow-x:auto;">
<div class="grad-form">
  <div class="page" id="gradFormPage">

    <!-- === Graduation Application Form === -->
<div class="graduation-app-container" style="overflow-x:auto;">
  <div class="graduation-app">
    <div class="graduation-page" id="graduationFormPage">

      <header>
        <div class="graduation-logo">
          <img src="assets/imgs/lc.png" alt="School Logo" style="max-width: 100%; max-height: 100%;">
        </div>
        <div class="graduation-school">
          <h1>Lemery Colleges</h1>
          <div class="graduation-sub">Lemery, Batangas</div>
          <div class="graduation-sub">Office of the Registrar</div>
        </div>
       <div class="graduation-right">
  Date: <span style="display:inline-block; border-bottom:1px solid #000; width:150px;"></span>
</div>

      </header>

      <div class="graduation-title"><h2>APPLICATION FOR GRADUATION FORM</h2></div>

      <p>
    Madam: <br>
    I have the honor to apply for graduation this 
    <span style="display:inline-block; border-bottom:1px solid #000; width:150px;"></span> 
    Semester of School Year 
    <span style="display:inline-block; border-bottom:1px solid #000; width:150px;"></span> 
    for the Degree/Title of 
    <span style="display:inline-block; border-bottom:1px solid #000; width:350px;"></span>.
    <br>

    Major/Area of Specialization: 
    <span style="display:inline-block; border-bottom:1px solid #000; width:350px;"></span>
    <br>

    Attached herewith is a checklist of all subjects I have already finished 
    with the corresponding grades and units earned for final evaluation.
</p>

<!-- Comments Section — Line Only -->
<div class="graduation-comments">
  <div class="graduation-row">
    Lack Units in: <span style="display:inline-block; border-bottom:1px solid #000; width:350px;"></span>
  </div>

  <div class="graduation-row">
    Lacking Requirements: <span style="display:inline-block; border-bottom:1px solid #000; width:350px;"></span>
  </div>

  <div class="graduation-row">
    Incomplete Grades in: <span style="display:inline-block; border-bottom:1px solid #000; width:350px;"></span>
  </div>

  <div class="graduation-row">
    Conditional Grades in: <span style="display:inline-block; border-bottom:1px solid #000; width:350px;"></span>
  </div>

  <div class="graduation-row">
    Recommendations: <span style="display:inline-block; border-bottom:1px solid #000; width:350px;"></span>
  </div>
</div>

      <!-- ✅ Evaluator Section -->
      <div class="graduation-signature" style="text-align:center; margin-top:30px; margin-left:592px;">
        <div style="text-align:left; margin-top:20px; width:360px; margin-left:auto; margin-right:auto;">
          <div class="graduation-row" style="margin-bottom:10px;">
            Evaluator Signature:
            <label for="evaluatorUpload" style="cursor:pointer; display:inline-block;">
              <!--<img id="evaluatorPreview" src="assets/imgs/sign-placeholder.png" 
                   alt="Click to upload signature" 
                   style="max-width:250px; max-height:100px;">
            </label>
               <input type="file" id="evaluatorUpload" accept="image/*" style="display:none;" 
                   onchange="previewEvaluatorSignature(event)"> -->
          </div>
          <div class="graduation-row">
            Date: <input class="graduation-input sm" type="date" required>
          </div>
        </div>
      </div>

      <!-- ✅ Noted Section -->
      <div style="text-align:left; margin-top:20px;">
        <div class="graduation-row">NOTED: <input class="graduation-input lg" type="text"></div>
        <div class="graduation-row">Course Coordinator: <input class="graduation-input lg" type="text" required></div>
      </div>
<br>
    <!-- LEFT SIDE (Student Profile) -->
    <div class="profile">
      <div class="title">
        <h2></h2>
      </div>

      <div class="row">
        <label>Name:</label>
        <input class="line md" placeholder="Last Name" required>
        <input class="line md" placeholder="First Name" required>
        <input class="line md" placeholder="Middle Name" required>
      </div>

      <div class="row">
        <label>Sex:</label>
        <input class="line md" placeholder="Male/Female" required>
        <label style="margin-left:30px;">Civil Status:</label>
       <input class="line md" placeholder="Single/Married" required>
      </div>

      <div class="row"><label>Permanent Address:</label><input class="line lg" required></div>
      <div class="row"><label>Temporary Address:</label><input class="line lg" required></div>
      
     <div class="row">
    <label>Telephone No.:</label>
    <input type="tel" class="line md" maxlength="11" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">

    <label style="margin-left:20px;">Birthday:</label>
    <input type="date" class="line md" required>
</div>

<div class="row">
    <label>Birthplace:</label>
    <input type="text" class="line lg" required>
</div>


      <div class="row"><label>Father:</label><input class="line md"><label>Occupation:</label><input class="line md" required></div>
      <div class="row"><label>Mother:</label><input class="line md"><label>Occupation:</label><input class="line md"  required></div>

      <div class="row"><label>Guardian:</label><input class="line md"><label>Relationship:</label><input class="line md" required></div>
      <div class="row"><label>Address of Guardian:</label><input class="line lg" required></div>
      <div class="row"><label>Telephone No.:</label><input type="tel" class="line md" maxlength="11" pattern="[0-9]*" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required></div>
      <div class="row"><label>If employed, Employer:</label><input class="line lg" required></div>

      <div class="row"><label>Elementary School:</label><input class="line lg" required><label>Year Graduated:</label><input class="line sm" required></div>
      <div class="row"><label>Secondary School:</label><input class="line lg" required><label>Year Completed:</label><input class="line sm" required></div>

      <div class="row"><label>Collegiate last Attended:</label><input class="line lg" required></div>
      <div class="row"><label>Last Sem/Year Attended:</label><input class="line md" required></div>

      <div class="section">
        <label>Credentials Need to Submitted: F138 HS, F137, Birth Certificate, Good Moral, JHS Diploma, 2x2 pic</label>
        
      </div>
    </div>

  </div>
</div>


          </div>
    </div>
  </div>
  </div>

  <!-- Submit Application Form Button -->
  <div style="text-align: center; margin: 30px 0;">
    <button id="proceedBtn" type="button">
      <i class="fa fa-paper-plane"></i> Submit Application Form
    </button>
  </div>

<script>
  // Download button removed
</script>


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

<script type="text/javascript">
    // Generate and submit only the application form PDF
    document.getElementById("proceedBtn").addEventListener("click", async function(e) {
  e.preventDefault();

  // Show loading
  Swal.fire({
    title: 'Generating PDF...',
    text: 'Please wait while we generate your application form.',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  try {
    // Generate PDF from the form
    const gradFormPage = document.getElementById('gradFormPage');
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

    // Convert PDF to blob
    const pdfBlob = pdf.output('blob');
    const pdfFile = new File([pdfBlob], `<?= htmlspecialchars($fullName) ?>_Graduation_Application.pdf`, { type: 'application/pdf' });

    // Create FormData and append only the generated PDF
    let formData = new FormData();
    formData.append('appPdf', pdfFile);

    // Update loading message
    Swal.update({
      title: 'Uploading...',
      text: 'Please wait while we submit your application form.'
    });

    // Submit only the application form
    const response = await fetch('upload_application_form_only.php', {
      method: "POST",
      body: formData
    });

    const data = await response.json();
    Swal.close();

    if (data.status === "success") {
      Swal.fire({
        icon: "success",
        title: "Submitted!",
        text: data.message,
        confirmButtonColor: "#2563eb"
      }).then(() => {
        window.location.href = "student_dashboard.php";
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Upload Failed",
        text: data.message,
        confirmButtonColor: "#dc2626"
      });
    }
  } catch (error) {
    Swal.close();
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Something went wrong while generating or uploading the form.",
      confirmButtonColor: "#dc2626"
    });
    console.error('Error:', error);
  }
});

</script>


                <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- jQuery -->
    <script src="assets/js/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/plugins/bootstrap/js/js.bootstrap.bundle.min.js" defer></script>
</body>

</html>