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
    /* =========== Google Fonts ============ */
    @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap");

    /* =============== Globals ============== */
    * {
      font-family: "Montserrat", sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
  background: url(assets/imgs/lemerycolleges.jpg) no-repeat center center fixed;
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
    }
    .auth-card {
      background: #fff;
      padding: 40px 32px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      width: 100%;
      max-width: 400px;
    }
    .auth-card h2 {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 24px;
      color: #0b2540;
      text-align: center;
    }
    .form-group { margin-bottom: 18px; }
    label {
      display: block;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 6px;
      color: #34405a;
    }
    input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 8px;
      border: 1px solid #d1d5db;
      font-size: 14px;
      transition: border-color 0.2s;
    }
    input:focus { border-color: #0366d6; outline: none; }
    .btn {
      display: block;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: #0366d6;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
      margin-top: 10px;
    }
    .btn:hover { background: #0254b8; }
    .alt-action {
      text-align: center;
      margin-top: 16px;
      font-size: 14px;
      color: #465a74;
    }
    .alt-action a { color: #0366d6; text-decoration: none; font-weight: 600; }
    .alt-action a:hover { text-decoration: underline; }
/* ===== System Header (Default Desktop) ===== */
.system-header {
  text-align: center;
  margin-bottom: 30px;
  padding: 0 15px;
  animation: fadeInDown 0.8s ease;
}

/* Logo */
.system-logo {
  width: 150px;
  height: 150px;
  object-fit: contain;
  margin-bottom: 12px;
  filter: drop-shadow(0 4px 6px rgba(0,0,0,0.15));
}

/* Title */
.system-title {
  font-size: 30px;
  font-weight: 700;
  color: #ffffff;
  line-height: 1.4;
  text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
.system-title span {
  font-size: 18px;
  font-weight: 500;
  display: block;
  margin-top: 4px;
  color: #e3f2ff;
}

  /* ===== Subtle Animation ===== */
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

/* ===== On Phones (Header fixed on top) ===== */
@media (max-width: 600px) {
  body {
    flex-direction: column; /* stack header on top, card below */
    align-items: center;
    padding: 20px 10px;
  }
  .system-header {
    margin-bottom: 20px;
    position: relative; /* stays above auth-card */
    top: 0;
  }
  .system-logo {
    width: 70px;
    height: 70px;
  }
  .system-title {
    font-size: 18px;
  }
  .system-title span {
    font-size: 14px;
  }
}

  </style>
</head>
<body>
<div class="system-header">
  <img src="assets/imgs/lc.png" alt="System Logo" class="system-logo">
  <h1 class="system-title">
    Web-based Graduation Management System <br>
    <span>with SMS Notifications For Lemery Colleges</span>
  </h1>
</div>
  <div class="auth-card">
    <h2>Student Login</h2>
    <form action="login_function.php" method="POST">
      <div class="form-group">
        <label for="loginId">Student ID or Email</label>
        <input type="text" id="loginId" name="loginId" placeholder="Enter Student ID or Email" required>
      </div>
      <div class="form-group">
        <label for="loginPassword">Password</label>
        <div style="position:relative;">
          <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required style="padding-right:40px;">
          <span id="togglePassword" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">
            <!-- Eye SVG icon (smaller size) -->
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 9s3-6 8-6 8 6 8 6-3 6-8 6-8-6-8-6z"/><circle cx="9" cy="9" r="2.5"/></svg>
          </span>
        </div>
      </div>
      <button type="submit" class="btn">Login</button>
    </form>
    <div class="alt-action">
      Don’t have an account? <a href="student_register.php">Register</a>
    </div>
  </div>
<script>
  // Toggle password visibility
  const passwordInput = document.getElementById('loginPassword');
  const togglePassword = document.getElementById('togglePassword');
  const eyeIcon = document.getElementById('eyeIcon');
  let passwordVisible = false;
  togglePassword.addEventListener('click', function() {
    passwordVisible = !passwordVisible;
    passwordInput.type = passwordVisible ? 'text' : 'password';
    eyeIcon.innerHTML = passwordVisible
      ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M13.46 13.46A3 3 0 0 1 9 15a3 3 0 0 1-2.46-5.46"/><path d="M1 9s3-6 8-6 8 6 8 6-3 6-8 6-8-6-8-6z"/><line x1="1" y1="1" x2="17" y2="17"/></svg>'
      : '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 9s3-6 8-6 8 6 8 6-3 6-8 6-8-6-8-6z"/><circle cx="9" cy="9" r="2.5"/></svg>';
  });
<?php if (isset($_GET['status'])): ?>
  <?php if ($_GET['status'] === 'invalid'): ?>
    Swal.fire({icon: 'error', title: 'Invalid Login', text: 'Student ID/Email or password is incorrect.'});
  <?php elseif ($_GET['status'] === 'no_account'): ?>
    Swal.fire({icon: 'warning', title: 'No Account Found', text: 'No account with that Student ID or Email.'});
  <?php elseif ($_GET['status'] === 'for_approval'): ?>
    Swal.fire({icon: 'info', title: 'Account Not Yet Approved', text: 'Your account is not yet approved. Please contact the administrator.'});
  <?php endif; ?>
<?php endif; ?>
</script>

<!-- jQuery -->
<script src="assets/js/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/plugins/bootstrap/js/js.bootstrap.bundle.min.js" defer></script>
</body>
</html>
