<?php
session_start();
include 'connection.php';

// if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// fallback avatar
$profileImage = !empty($user['profile_image']) ? "uploads/" . $user['profile_image'] : "assets/imgs/default-avatar.png";
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
    /* ================= PROFILE PAGE EXTRA STYLES ================= */

	/* Auth card styling */
	.auth-card {
	  background: #fff;
	  padding: 30px 25px;
	  border-radius: 16px;
	  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
	  max-width: 1000px;
	  margin: 30px auto;
	}

	.auth-card h2 {
	  font-size: 22px;
	  font-weight: 700;
	  margin-bottom: 20px;
	  color: #0b2540;
	  text-align: center;
	}

	/* Profile image preview */
	.profile-preview {
	  text-align: center;
	  margin-bottom: 20px;
	}
	.profile-preview img {
	  width: 120px;
	  height: 120px;
	  border-radius: 50%;
	  object-fit: cover;
	  border: 3px solid #d1d5db;
	  cursor: pointer;
	  transition: transform 0.3s;
	}
	.profile-preview img:hover {
	  transform: scale(1.05);
	}
	.profile-preview p {
	  font-size: 12px;
	  color: #666;
	  margin-top: 6px;
	}

	/* Form fields */
	.form-group {
	  margin-bottom: 18px;
	}
	.form-group label {
	  display: block;
	  font-size: 14px;
	  font-weight: 600;
	  margin-bottom: 6px;
	  color: #34405a;
	}
	.form-group input {
	  width: 100%;
	  padding: 12px 14px;
	  border-radius: 8px;
	  border: 1px solid #d1d5db;
	  font-size: 14px;
	  transition: border-color 0.2s, box-shadow 0.2s;
	}
	.form-group input:focus {
	  border-color: #0366d6;
	  box-shadow: 0 0 4px rgba(3, 102, 214, 0.3);
	  outline: none;
	}

	/* Password field with toggle */
	.password-wrapper {
	  position: relative;
	}
	.password-wrapper input {
	  padding-right: 45px;
	}
	.password-toggle {
	  position: absolute;
	  right: 12px;
	  top: 50%;
	  transform: translateY(-50%);
	  background: none;
	  border: none;
	  cursor: pointer;
	  color: #666;
	  font-size: 18px;
	  padding: 0;
	  width: 30px;
	  height: 30px;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  transition: color 0.2s;
	}
	.password-toggle:hover {
	  color: #0366d6;
	}
	.password-toggle:focus {
	  outline: none;
	}

	/* Submit button */
	.auth-card .btn {
	  display: block;
	  width: 100%;
	  padding: 12px;
	  border: none;
	  border-radius: 8px;
	  background: #0366d6;
	  color: #fff;
	  font-weight: 600;
	  cursor: pointer;
	  transition: background 0.2s, transform 0.2s;
	  margin-top: 10px;
	}
	.auth-card .btn:hover {
	  background: #0254b8;
	  transform: translateY(-1px);
	}

	/* Topbar title truncate */
	.topbar h3 {
	  font-size: 18px;
	  font-weight: 600;
	  color: #0b2540;
	  white-space: nowrap;
	  overflow: hidden;
	  text-overflow: ellipsis;
	  max-width: calc(100% - 150px); /* leave space for profile info */
	}

	/* Responsive adjustments */
	@media (max-width: 768px) {
	  .auth-card {
	    padding: 20px 15px;
	    margin: 20px;
	  }
	  .profile-preview img {
	    width: 100px;
	    height: 100px;
	  }
	  .topbar h3 {
	    font-size: 16px;
	    max-width: calc(100% - 120px);
	  }
	}

    </style>
</head>

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

			  <div class="auth-card">
			    <h2>My Profile</h2>
			    <form action="student_update_profile_function.php" method="POST" enctype="multipart/form-data">
			      <!-- Profile Image -->
			      <div class="profile-preview">
			        <label for="profileImage">
			          <img id="previewImage" src="<?php echo $profileImage; ?>" alt="Profile Preview">
			        </label>
			        <input type="file" id="profileImage" name="profile_image" accept="image/*" style="display:none;">
			        <p>Click image to change</p>
			      </div>

			      <div class="form-group">
			        <label for="studentId">Student ID</label>
			        <input type="text" id="studentId" name="student_id" value="<?php echo htmlspecialchars($user['student_id']); ?>" readonly>
			      </div>
			      <div class="form-group">
              <label for="fullName">Full Name</label>
			        <input type="text" id="fullName" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
			      </div>
			      <div class="form-group">
			        <label for="regEmail">Email Address</label>
			        <input type="email" id="regEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
			      </div>
			      <div class="form-group">
			        <label for="phone">Phone Number</label>
			        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
			      </div>
			      <div class="form-group">
			        <label for="regPassword">New Password (leave blank if unchanged)</label>
			        <div class="password-wrapper">
			          <input type="password" id="regPassword" name="password" placeholder="Enter new password">
			          <button type="button" class="password-toggle" onclick="togglePassword('regPassword', 'toggleRegPassword')">
			            <i class="fa fa-eye" id="toggleRegPassword"></i>
			          </button>
			        </div>
			      </div>
			      <div class="form-group">
			        <label for="confirmPassword">Confirm New Password</label>
			        <div class="password-wrapper">
			          <input type="password" id="confirmPassword" name="confirm_password" placeholder="Re-enter new password">
			          <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword', 'toggleConfirmPassword')">
			            <i class="fa fa-eye" id="toggleConfirmPassword"></i>
			          </button>
			        </div>
			      </div>
			      <button type="submit" class="btn"><i class="fa fa-check-square-o"></i> Update Profile</button>
			    </form>
			  </div>
          </div>
    </div>

  <script>
    document.getElementById("profileImage").addEventListener("change", function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById("previewImage").src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    // Toggle password visibility
    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>
  <?php if (isset($_GET['status'])): ?>
  <script>
    <?php if ($_GET['status'] === 'success'): ?>
      Swal.fire({
        icon: 'success',
        title: 'Profile Updated',
        text: 'Your profile has been updated successfully.'
      });
    <?php elseif ($_GET['status'] === 'password_mismatch'): ?>
      Swal.fire({
        icon: 'error',
        title: 'Password Mismatch',
        text: 'New password and confirm password do not match.'
      });
    <?php elseif ($_GET['status'] === 'error'): ?>
      Swal.fire({
        icon: 'error',
        title: 'Update Failed',
        text: 'Something went wrong. Please try again.'
      });
    <?php endif; ?>
  </script>
<?php endif; ?>

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