<?php
session_start();
// Restore form data from session if available
$formData = isset($_SESSION['register_form_data']) ? $_SESSION['register_form_data'] : [];
unset($_SESSION['register_form_data']); // Clear after use
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    /* ===== Global Styles ===== */
    * { font-family: 'Montserrat', sans-serif; margin:0; padding:0; box-sizing:border-box; }

    body {
        background: #f9fafb;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-image: url(assets/imgs/lemerycolleges.jpg);
        background-attachment: fixed;
        background-size: cover;
    }

    .page-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
    }

    .system-header { text-align: center; margin-bottom: 25px; animation: fadeInDown 0.8s ease; }
    .system-logo { width:100px; height:100px; object-fit:contain; margin-bottom:12px; }
    .system-title { font-size:22px; font-weight:700; color:#ffffff; line-height:1.4; text-shadow:0 2px 4px rgba(0,0,0,0.2); }
    .system-title span { font-size:18px; font-weight:500; display:block; margin-top:4px; color:#e3f2ff; }

    @keyframes fadeInDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }

    .auth-card {
        background: #fff;
        padding: 40px 32px;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        width: 100%;
        max-width: 450px;
    }

    .auth-card h2 {
        font-size:24px;
        font-weight:700;
        margin-bottom:24px;
        color:#1e3a8a;
        text-align:center;
    }

    .form-group { margin-bottom:18px; }
    label { display:block; font-size:14px; font-weight:600; margin-bottom:6px; color:#1e3a8a; }
    input, select { width:100%; padding:12px 14px; border-radius:8px; border:1px solid #d1d5db; font-size:14px; transition:border-color 0.2s; }
    input:focus, select:focus { border-color:#1e3a8a; outline:none; }

    .btn {
        display:block;
        width:100%;
        padding:12px;
        border:none;
        border-radius:8px;
        background:#1e3a8a;
        color:#fff;
        font-weight:600;
        cursor:pointer;
        transition:background 0.2s;
        margin-top:10px;
    }

    .btn:hover { background:#1e40af; }

    .alt-action { text-align:center; margin-top:16px; font-size:14px; color:#1e3a8a; }
    .alt-action a { color:#1e3a8a; text-decoration:none; font-weight:600; }
    .alt-action a:hover { text-decoration:underline; }

    #previewImage { width:100px; height:100px; border-radius:50%; object-fit:cover; border:2px solid #ddd; cursor:pointer; }

    .file-upload-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-upload-label {
        display: block;
        padding: 12px 14px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f9fafb;
    }

    .file-upload-label:hover {
        border-color: #1e3a8a;
        background: #eff6ff;
    }

    .file-upload-label i {
        margin-right: 8px;
        color: #1e3a8a;
    }

    .file-upload-input {
        display: none;
    }

    .file-name-display {
        margin-top: 8px;
        font-size: 13px;
        color: #1e3a8a;
        font-weight: 500;
    }

    .password-wrapper {
        position: relative;
        width: 100%;
    }

    .password-wrapper input {
        padding-right: 45px;
    }

    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #6b7280;
        font-size: 16px;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .password-toggle:hover {
        color: #1e3a8a;
    }

    .password-toggle:focus {
        outline: none;
    }

    @media (max-width:600px) { .system-logo{width:70px;height:70px;} .system-title{font-size:18px;} .system-title span{font-size:14px;} }
      .profile-icon-upload {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        border-radius: 50%;
        border: 3px solid #1e3a8a;
        background: linear-gradient(135deg, #e0e7ff 0%, #a5b4fc 100%);
        box-shadow: 0 4px 16px rgba(30,58,138,0.10), 0 1.5px 6px rgba(30,58,138,0.08);
        transition: box-shadow 0.2s, border-color 0.2s, background 0.2s;
        position: relative;
        cursor: pointer;
      }
      .profile-icon-upload:hover {
        box-shadow: 0 8px 24px rgba(30,58,138,0.18), 0 3px 12px rgba(30,58,138,0.12);
        border-color: #6366f1;
        background: linear-gradient(135deg, #c7d2fe 0%, #6366f1 100%);
      }
      .profile-icon-upload i.fa-user {
        font-size: 72px;
        color: #374151;
        transition: color 0.2s;
      }
      .profile-icon-upload:hover i.fa-user {
        color: #fff;
      }
      @media (max-width:600px) { .system-logo{width:70px;height:70px;} .system-title{font-size:18px;} .system-title span{font-size:14px;} .profile-icon-upload{width:80px;height:80px;} .profile-icon-upload i.fa-user{font-size:48px;} }
    </style>
</head>

<body>
<div class="page-container">
  
  <!-- System Header -->
  <div class="system-header">
    <img src="assets/imgs/lc.png" alt="System Logo" class="system-logo">
    <h1 class="system-title">
      Web-based Graduation Management System <br>
      <span>with SMS Notifications For Lemery Colleges</span>
    </h1>
  </div>

  <!-- Registration Card -->
  <div class="auth-card">
    <h2>Create Account</h2>
    <form action="register_function.php" method="POST" enctype="multipart/form-data">

      <!-- Profile Image (Human Icon) -->
      <div style="text-align:center; margin-bottom:20px;">
        <label for="profileImage" style="display:inline-block; cursor:pointer;">
          <div class="profile-icon-upload">
            <i class="fa fa-user"></i>
            <input type="file" id="profileImage" name="profile_image" accept="image/*" style="display:none;">
          </div>
          <div style="margin-top:8px; font-size:15px; color:#1e3a8a; font-weight:600; letter-spacing:0.5px;">Add Profile</div>
        </label>
      </div>

      <!-- Full Name -->
      <div class="form-group">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="full_name" value="<?php echo isset($formData['full_name']) ? htmlspecialchars($formData['full_name']) : ''; ?>" placeholder="Enter your full name" required>
      </div>

      <!-- Course -->
      <div class="form-group">
        <label for="course">Course</label>
        <select id="course" name="course" required>
          <option value="" disabled <?php echo !isset($formData['course']) ? 'selected' : ''; ?>>Select your course</option>
          <option value="BSIT" <?php echo (isset($formData['course']) && $formData['course'] === 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
          <option value="BSCS" <?php echo (isset($formData['course']) && $formData['course'] === 'BSCS') ? 'selected' : ''; ?>>BSCS</option>
          
        </select>
      </div>

      <!-- Section -->
      <div class="form-group">
        <label for="section">Section</label>
        <select id="section" name="section" required>
          <option value="" disabled <?php echo !isset($formData['section']) ? 'selected' : ''; ?>>Select your section</option>
          <option value="A" <?php echo (isset($formData['section']) && $formData['section'] === 'A') ? 'selected' : ''; ?>>A</option>
          <option value="B" <?php echo (isset($formData['section']) && $formData['section'] === 'B') ? 'selected' : ''; ?>>B</option>
          <option value="C" <?php echo (isset($formData['section']) && $formData['section'] === 'C') ? 'selected' : ''; ?>>C</option>
          <option value="D" <?php echo (isset($formData['section']) && $formData['section'] === 'D') ? 'selected' : ''; ?>>D</option>
          <option value="N/A" <?php echo (isset($formData['section']) && $formData['section'] === 'N/A') ? 'selected' : ''; ?>>N/A</option>
        </select>
      </div>

      <div class="form-group">
        <label for="year">Year</label>
        <input type="text" id="year" name="year" value="4th Year" readonly style="background-color: #f3f4f6; cursor: not-allowed;">
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="regEmail">Email Address</label>
        <input type="email" id="regEmail" name="email" value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>" placeholder="Enter your email" required>
      </div>

      <!-- Student ID -->
      <div class="form-group">
        <label for="studentId">Student ID</label>
        <input type="text" id="studentId" name="student_id" value="<?php echo isset($formData['student_id']) ? htmlspecialchars($formData['student_id']) : ''; ?>" placeholder="Enter Student ID" required>
      </div>

      <!-- Phone -->
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" value="<?php echo isset($formData['phone']) ? htmlspecialchars($formData['phone']) : ''; ?>" placeholder="Enter your phone number (11 digits)" maxlength="11" pattern="[0-9]{11}" inputmode="numeric" required>
      </div>

      <!-- COR (Certificate of Registration) -->
      <div class="form-group">
        <label for="corFile">Certificate of Registration (COR)</label>
        <div class="file-upload-wrapper">
          <label for="corFile" class="file-upload-label">
            <i class="fa fa-file-pdf-o"></i>
            <span id="corFileLabel">Click to upload COR file (PDF/Image)</span>
          </label>
          <input type="file" id="corFile" name="cor_file" class="file-upload-input" accept=".pdf,.jpg,.jpeg,.png,.gif" required>
          <div id="corFileName" class="file-name-display" style="display:none;"></div>
        </div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="regPassword">Password</label>
        <div class="password-wrapper">
          <input type="password" id="regPassword" name="password" placeholder="Create a password" required>
          <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
            <i class="fa fa-eye" id="togglePasswordIcon"></i>
          </button>
        </div>
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <div class="password-wrapper">
          <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-enter your password" required>
          <button type="button" class="password-toggle" id="toggleConfirmPassword" aria-label="Toggle password visibility">
            <i class="fa fa-eye" id="toggleConfirmPasswordIcon"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn" id="submitBtn">Register</button>
    </form>

    <div class="alt-action">
      Already have an account? <a href="student_login.php">Login</a>
    </div>
  </div>
</div>

<script>
document.getElementById("profileImage").addEventListener("change", function(event){
  const file = event.target.files[0];
  if(file){
    const reader = new FileReader();
    reader.onload = function(e){ document.getElementById("previewImage").src = e.target.result; };
    reader.readAsDataURL(file);
  }
});

// COR File Upload Handler
document.getElementById("corFile").addEventListener("change", function(event){
  const file = event.target.files[0];
  const fileNameDisplay = document.getElementById("corFileName");
  const fileLabel = document.getElementById("corFileLabel");
  
  if(file){
    fileNameDisplay.textContent = "Selected: " + file.name;
    fileNameDisplay.style.display = "block";
    fileLabel.textContent = "File selected - Click to change";
  } else {
    fileNameDisplay.style.display = "none";
    fileLabel.textContent = "Click to upload COR file (PDF/Image)";
  }
});

// Password Toggle Functionality
document.getElementById("togglePassword").addEventListener("click", function(){
  const passwordInput = document.getElementById("regPassword");
  const toggleIcon = document.getElementById("togglePasswordIcon");
  
  if(passwordInput.type === "password"){
    passwordInput.type = "text";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  }
});

document.getElementById("toggleConfirmPassword").addEventListener("click", function(){
  const confirmPasswordInput = document.getElementById("confirmPassword");
  const toggleIcon = document.getElementById("toggleConfirmPasswordIcon");
  
  if(confirmPasswordInput.type === "password"){
    confirmPasswordInput.type = "text";
    toggleIcon.classList.remove("fa-eye");
    toggleIcon.classList.add("fa-eye-slash");
  } else {
    confirmPasswordInput.type = "password";
    toggleIcon.classList.remove("fa-eye-slash");
    toggleIcon.classList.add("fa-eye");
  }
});

// Phone Number - Only allow numbers and limit to 11 digits
document.getElementById("phone").addEventListener("input", function(e){
  // Remove any non-numeric characters
  this.value = this.value.replace(/[^0-9]/g, '');
  
  // Limit to 11 digits
  if(this.value.length > 11){
    this.value = this.value.slice(0, 11);
  }
});

// Prevent paste of non-numeric characters
document.getElementById("phone").addEventListener("paste", function(e){
  e.preventDefault();
  const paste = (e.clipboardData || window.clipboardData).getData("text");
  const numbersOnly = paste.replace(/[^0-9]/g, '').slice(0, 11);
  this.value = numbersOnly;
});

// Form Validation - Prevent submission if passwords don't match
document.querySelector("form").addEventListener("submit", function(e){
  const password = document.getElementById("regPassword").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  
  if(password !== confirmPassword){
    e.preventDefault();
    Swal.fire({
      icon: 'error',
      title: 'Password Mismatch',
      text: 'Passwords do not match! Please check and try again.',
      confirmButtonColor: '#1e3a8a'
    });
    return false;
  }
});

// SweetAlert notifications
<?php if(isset($_GET['status'])): ?>
  <?php if($_GET['status'] === 'success'): ?>
    Swal.fire({icon:'success', title:'Registration Successful', text:'Your account is pending approval. You will be able to log in once it is approved.'})
      .then(()=>{ window.location='student_login.php'; });
  <?php elseif($_GET['status'] === 'password_mismatch'): ?>
    Swal.fire({icon:'error', title:'Password Mismatch', text:'Passwords do not match!'});
  <?php elseif($_GET['status'] === 'exists'): ?>
    Swal.fire({icon:'warning', title:'Account Exists', text:'Student ID or Email already registered.'});
  <?php elseif($_GET['status'] === 'sql_error'): ?>
    Swal.fire({icon:'error', title:'Database Error', text:'Check your database or query.'});
  <?php else: ?>
    Swal.fire({icon:'error', title:'Error', text:'Something went wrong. Please try again.'});
  <?php endif; ?>
<?php endif; ?>
</script>

</body>
</html>
