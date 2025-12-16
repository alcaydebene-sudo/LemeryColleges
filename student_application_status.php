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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
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

.docs-container {
  max-width: 1100px;
  margin: 30px auto;
  padding: 20px;
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  font-family: Arial, sans-serif;
}

.docs-container h2 {
  margin-bottom: 15px;
  font-size: 22px;
  color: #111827;
  text-align: center;
}

.docs-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
  margin-top: 10px;
  overflow: hidden;
  border-radius: 8px;
}

.docs-table th, .docs-table td {
  padding: 10px 12px;
  border: 1px solid #ddd;
  text-align: left;
  vertical-align: top;
}

.docs-table th {
  background: #f3f4f6;
  text-transform: uppercase;
  font-size: 13px;
  letter-spacing: 0.5px;
}

.docs-table tbody tr:nth-child(even) {
  background: #fafafa;
}

.status {
  font-weight: bold;
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 12px;
}
.status.review { color: #b45309; background: #fff7ed; }
.status.approved { color: #065f46; background: #ecfdf5; }
.status.rejected { color: #991b1b; background: #fef2f2; }

.action-btn {
  padding: 6px 12px;
  font-size: 13px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin: 2px 0;
  display: inline-block;
}

.delete-btn {
  background: #dc2626;
  color: white;
}

.delete-btn:hover {
  background: #b91c1c;
}

.docs-table {
  width: 100%;
  border-collapse: collapse;
}

.docs-table th,
.docs-table td {
  padding: 8px;
  text-align: center;
}

/* ✅ Responsive table */
@media screen and (max-width: 768px) {
  .docs-table {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    white-space: nowrap;
  }
}

.search-container {
  margin-bottom: 16px;
  text-align: right;
}

.search-box {
  display: inline-flex;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 4px 8px;
  background: #fff;
}

.search-box i {
  color: #555;
  margin-right: 6px;
}

.search-box input {
  border: none;
  outline: none;
  font-size: 14px;
  width: 220px;
}

/* ✅ Responsive search */
@media screen and (max-width: 600px) {
  .search-container {
    text-align: center;
  }

  .search-box input {
    width: 140px;
    font-size: 13px;
  }
}

.update-btn, .delete-btn {
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  font-size: 12px;
  margin: 2px 0;
}

.update-btn {
  background-color: #4CAF50;
}

.update-btn:hover {
  background-color: #45a049;
}

.delete-btn {
  background-color: #e74c3c;
}

.delete-btn:hover {
  background-color: #c0392b;
}

/* ===== UPDATE MODAL STYLES (matching upload design) ===== */
.upload-card {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 20px 25px;
  margin-bottom: 20px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
  transition: 0.3s;
}

.upload-card:hover {
  box-shadow: 0 6px 12px rgba(0,0,0,0.08);
}

.upload-card h3 {
  margin-top: 0;
  font-size: 18px;
  color: #2563eb;
  display: flex;
  align-items: center;
  gap: 8px;
}

.upload-card .desc {
  font-size: 13px;
  color: #6b7280;
  margin-bottom: 12px;
}

.upload-card input[type="file"] {
  display: block;
  width: 100%;
  padding: 8px;
  font-size: 14px;
  border: 1px dashed #d1d5db;
  border-radius: 8px;
  background-color: #f9fafb;
  cursor: pointer;
  transition: border-color 0.2s ease;
}

.upload-card input[type="file"]:hover {
  border-color: #2563eb;
}

.upload-actions {
  text-align: center;
  margin-top: 25px;
}

.upload-actions button {
  background: #2563eb;
  color: #fff;
  border: none;
  padding: 12px 22px;
  font-size: 15px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  transition: background 0.2s ease-in-out, transform 0.1s ease-in-out;
}

.upload-actions button:hover {
  background: #1e40af;
  transform: translateY(-1px);
}

/* ✅ MODAL OVERLAY (dark transparent background + centered modal) */
.modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6); /* Dark transparent background */
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: #fff;
  border-radius: 12px;
  padding: 30px 40px;
  box-shadow: 0 8px 16px rgba(0,0,0,0.3);
  max-width: 650px;
  width: 90%;
  max-height: 90%;
  overflow-y: auto;
  animation: fadeIn 0.2s ease-in-out;
  position: relative;
}

.close {
  position: absolute;
  right: 20px;
  top: 15px;
  font-size: 22px;
  cursor: pointer;
  color: #555;
}

.close:hover {
  color: #000;
}

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* Responsive modal */
@media (max-width: 600px) {
  #updateModal .modal-content {
    padding: 20px;
  }
  #updateModal h2 {
    font-size: 20px;
  }
}
.modal-buttons {
  margin-top: 30px;
  text-align: right;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.modal-buttons button {
  padding: 10px 22px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 15px;
  font-weight: 500;
  transition: background 0.2s ease-in-out, transform 0.1s ease-in-out;
}

.modal-buttons .cancel {
  background: #e5e7eb; /* light gray */
  color: #111827;
}

.modal-buttons .cancel:hover {
  background: #d1d5db;
  transform: translateY(-1px);
}

.modal-buttons .confirm {
  background: #2563eb;
  color: white;
}

.modal-buttons .confirm:hover {
  background: #1e40af;
  transform: translateY(-1px);
}

.modal-buttons .confirm i {
  margin-right: 6px;
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

<?php
include "connection.php";

$student_id = $_SESSION['student_id'] ?? null;
if (!$student_id) {
    die("Student not logged in.");
}

// Check if admin_checklist_status column exists
$checkColumn = $conn->query("SHOW COLUMNS FROM student_documents LIKE 'admin_checklist_status'");
if ($checkColumn->num_rows == 0) {
    $conn->query("ALTER TABLE student_documents ADD COLUMN admin_checklist_status TEXT NULL AFTER status");
}

// Fetch only this student's documents with their info, including admin checklist status
$sql = "SELECT sd.id, s.student_id, s.full_name, sd.application_form, 
               sd.valid_documents, sd.status, sd.uploaded_at,
               COALESCE(sd.admin_checklist_status, '{}') as admin_checklist_status
        FROM student_documents sd
        JOIN students s ON sd.student_id = s.student_id
        WHERE sd.student_id = ?
        ORDER BY sd.uploaded_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Get missing documents for the latest application
$missingDocuments = [];
$hasApplication = false;
$latestApplicationId = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hasApplication = true;
    $latestApplicationId = $row['id'];
    
    // Get admin checklist status
    $adminChecklistJson = isset($row['admin_checklist_status']) ? $row['admin_checklist_status'] : '{}';
    $adminChecklist = [];
    if (!empty($adminChecklistJson) && $adminChecklistJson !== '{}') {
        $adminChecklistArray = json_decode($adminChecklistJson, true);
        if (is_array($adminChecklistArray)) {
            $adminChecklist = $adminChecklistArray;
        }
    }
    
    // Standard documents
    $standardDocs = ['F138 HS', 'F137', 'Birth Certificate', 'Good Moral', 'SHS Diploma', '2x2 Picture'];
    
    // Check which documents are missing (unchecked by admin)
    foreach ($standardDocs as $docType) {
        if (!isset($adminChecklist[$docType]) || $adminChecklist[$docType] !== true) {
            $missingDocuments[] = $docType;
        }
    }
    
    // Reset result pointer for later use
    $result->data_seek(0);
}
?>

<div class="docs-container">
  <h2><i class="fa fa-folder-open-o" style="font-size: 1.75rem;"></i> My Status</h2>
  
  <!-- Information Text -->
  <div style="background: #f0f9ff; border-left: 4px solid #2563eb; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
    <p style="margin: 0; color: #1e40af; font-size: 14px; line-height: 1.6;">
      <i class="fa fa-info-circle" style="margin-right: 8px;"></i>
      <strong>Application Status Overview:</strong> This section displays your application status and document checklist. 
      You can view your uploaded documents, check your application status, and upload any missing documents as requested by the administrator. 
      Please ensure all required documents are uploaded and verified.
    </p>
  </div>

  <?php if ($hasApplication && !empty($missingDocuments)): ?>
    <!-- Notification Banner -->
    <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
      <h3 style="margin: 0 0 10px 0; color: #856404; font-size: 16px;">
        <i class="fa fa-exclamation-triangle"></i> Missing Documents Notification
      </h3>
      <p style="margin: 0; color: #856404; font-size: 14px;">
        You have been notified about missing documents. Please upload the following documents:
        <strong><?= implode(', ', $missingDocuments) ?></strong>
      </p>
    </div>

    <!-- Upload Missing Documents Form -->
    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 25px; margin-bottom: 20px;">
      <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 18px; color: #2563eb;">
        <i class="fa fa-upload"></i> Upload Missing Documents
      </h3>
      <p class="desc" style="margin-bottom: 20px; font-size: 13px; color: #6b7280;">
        Please upload the missing documents (PDF or images, max 5 MB each):
      </p>
      
      <form id="uploadMissingDocsForm" enctype="multipart/form-data" method="POST" action="upload_missing_documents.php">
        <input type="hidden" name="id" value="<?= $latestApplicationId ?>">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
          <?php 
          $docFieldMap = [
            'F138 HS' => 'doc_f138hs',
            'F137' => 'doc_f137',
            'Birth Certificate' => 'doc_birthcert',
            'Good Moral' => 'doc_goodmoral',
            'SHS Diploma' => 'doc_shsdiploma',
            '2x2 Picture' => 'doc_2x2picture'
          ];
          
          foreach ($missingDocuments as $docType): 
            $fieldName = $docFieldMap[$docType] ?? 'doc_' . strtolower(str_replace(' ', '_', $docType));
            $icon = (($docType === 'F138 HS' || $docType === 'F137') ? 'fa-file-pdf-o' : 
                    (($docType === 'Birth Certificate') ? 'fa-file-image-o' : 
                    (($docType === 'Good Moral') ? 'fa-file-text-o' : 
                    (($docType === '2x2 Picture') ? 'fa-camera' : 'fa-graduation-cap'))));
            $iconColor = (($docType === 'F138 HS' || $docType === 'F137') ? '#dc2626' : 
                         (($docType === 'Birth Certificate') ? '#059669' : 
                         (($docType === 'Good Moral') ? '#2563eb' : 
                         (($docType === '2x2 Picture') ? '#ec4899' : '#7c3aed'))));
          ?>
            <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb;">
              <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                <i class="fa <?= $icon ?>" style="color: <?= $iconColor ?>;"></i> <?= htmlspecialchars($docType) ?>
              </label>
              <input type="file" name="<?= $fieldName ?>" accept="application/pdf,image/*" required 
                     style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px;">
            </div>
          <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 25px;">
          <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 12px 22px; 
                  font-size: 15px; border-radius: 8px; cursor: pointer; font-weight: 500;">
            <i class="fa fa-upload"></i> Upload Missing Documents
          </button>
        </div>
      </form>
    </div>
  <?php endif; ?>

</div>
<!-- ================== UPDATE MODAL (Fullscreen Style) ================== -->
<div id="updateModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span id="closeUpdateModal" class="close" style="position:absolute; top:20px; right:25px; font-size:26px; cursor:pointer;">&times;</span>

    <h2 style="text-align:center; margin-top:20px; color:#2563eb;">Update Uploaded Documents</h2>
    <br>

    <form id="updateDocsForm" enctype="multipart/form-data" method="POST" action="update_upload_certificate_function.php" class="upload-form">
      <input type="hidden" name="id" id="id">

      <div class="upload-card" style="width: 100%;">
        <h3><i class="fa fa-folder-open-o"></i> Update Valid Documents</h3>
        <p class="desc" style="margin-bottom: 20px;">Upload updated documents (PDF or images, max 5 MB each). Leave blank to keep existing documents:</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
          <!-- F138 HS -->
          <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
              <i class="fa fa-file-pdf-o" style="color: #dc2626;"></i> F138 HS (Form 138 High School)
            </label>
            <input type="file" name="doc_f138hs" accept="application/pdf,image/*" style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px;">
          </div>

          <!-- F137 -->
          <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
              <i class="fa fa-file-pdf-o" style="color: #dc2626;"></i> F137 (Form 137)
            </label>
            <input type="file" name="doc_f137" accept="application/pdf,image/*" style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px;">
          </div>

          <!-- Birth Certificate -->
          <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
              <i class="fa fa-file-image-o" style="color: #059669;"></i> Birth Certificate
            </label>
            <input type="file" name="doc_birthcert" accept="application/pdf,image/*" style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px;">
          </div>

          <!-- Good Moral -->
          <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
              <i class="fa fa-file-text-o" style="color: #2563eb;"></i> Good Moral Certificate
            </label>
            <input type="file" name="doc_goodmoral" accept="application/pdf,image/*" style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px;">
          </div>

          <!-- SHS Diploma -->
          <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
              <i class="fa fa-graduation-cap" style="color: #7c3aed;"></i> SHS Diploma
            </label>
            <input type="file" name="doc_shsdiploma" accept="application/pdf,image/*" style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px;">
          </div>

          <!-- 2x2 Picture -->
          <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px; background: #f9fafb;">
            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
              <i class="fa fa-camera" style="color: #ec4899;"></i> 2x2 Picture
            </label>
            <input type="file" name="doc_2x2picture" accept="image/*" style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; font-size: 13px;">
          </div>
        </div>
      </div>

      <div class="modal-buttons">
        <button type="button" class="cancel" id="closeUpdateModalBtn">Cancel</button>
        <button type="submit" class="confirm"><i class="fa fa-save"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- ============ FILE PREVIEW MODAL ============ -->
<div id="fileModal"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.95); align-items:center; justify-content:center; z-index:10001;">
  
  <!-- Close Button -->
  <span onclick="closeFileModal()" 
        style="position:absolute; top:20px; right:40px; color:white;
        font-size:45px; font-weight:bold; cursor:pointer; transition: color 0.3s;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"
        onmouseover="this.style.color='#ff6b6b'"
        onmouseout="this.style.color='white'">&times;</span>
  
  <!-- Loading Spinner -->
  <div id="fileLoader" style="display:none; text-align:center;">
    <div style="border: 4px solid rgba(255, 255, 255, 0.3);
                border-top: 4px solid white;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;"></div>
    <p style="color:white; font-size:18px;">Loading...</p>
  </div>
  
  <!-- File Content Container -->
  <div id="fileContent" style="max-width:90%; max-height:90%; display:flex; 
       align-items:center; justify-content:center;"></div>
  
  <!-- Error Message -->
  <div id="fileError" style="display:none; color:white; text-align:center; 
       background:rgba(220, 38, 38, 0.9); padding:30px; border-radius:10px;">
    <p style="font-size:20px; margin:0;">⚠️ Unable to load file</p>
  </div>
</div>

<style>
@keyframes zoomIn {
  from { transform: scale(0.8); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

#fileContent img {
  max-width: 90%;
  max-height: 90vh;
  border-radius: 10px;
  box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
  animation: zoomIn 0.3s;
  object-fit: contain;
}

#fileContent iframe {
  width: 85%;
  height: 90vh;
  border: none;
  border-radius: 10px;
  background: white;
  box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
}
</style>

<script>
function openFileModal(fileUrl) {
  console.log("🔍 Opening file URL:", fileUrl);
  const modal = document.getElementById("fileModal");
  const content = document.getElementById("fileContent");
  content.innerHTML = "";

  if (!fileUrl) {
    content.innerHTML = "<p style='color:white;'>⚠️ No file found.</p>";
    modal.style.display = "flex";
    return;
  }

  // Clean and extract the file extension
  let ext = fileUrl.split('.').pop().toLowerCase().trim();
  ext = ext.replace(/[^a-z0-9]/gi, ''); // remove weird chars like " ] [ "
  console.log("📂 Cleaned extension:", ext);

  // Supported formats
  const imageExts = ['jpg','jpeg','png','gif','webp','jfif'];
  const pdfExts = ['pdf'];

  if (imageExts.includes(ext)) {
    // ✅ Image
    const img = document.createElement('img');
    img.src = fileUrl + "?t=" + new Date().getTime();
    img.style.maxWidth = "90%";
    img.style.maxHeight = "90%";
    img.style.borderRadius = "10px";
    img.style.objectFit = "contain";
    content.appendChild(img);
  } else if (pdfExts.includes(ext)) {
    // ✅ PDF
    const frame = document.createElement('iframe');
    frame.src = fileUrl + "?t=" + new Date().getTime();
    frame.style.width = "80%";
    frame.style.height = "90%";
    frame.style.border = "none";
    frame.style.borderRadius = "10px";
    frame.style.background = "white";
    content.appendChild(frame);
  } else {
    // ❌ Unsupported
    content.innerHTML = `
      <p style='color:white; font-size:18px; text-align:center;'>
        ❌ Unsupported file format<br>
        Extension: <b>${ext}</b><br>
        Supported: JPG, PNG, GIF, WEBP, PDF
      </p>`;
  }

  modal.style.display = "flex";
}

function closeFileModal() {
  const modal = document.getElementById("fileModal");
  const content = document.getElementById("fileContent");
  content.innerHTML = "";
  modal.style.display = "none";
}

document.getElementById("fileModal").addEventListener("click", function (e) {
  if (e.target === this) closeFileModal();
});
</script>

          </div>

    </div>


<script>
document.addEventListener("DOMContentLoaded", () => {
  // Open modal
  document.querySelectorAll(".update-btn").forEach(btn => {
    btn.addEventListener("click", function() {
      const recordId = this.getAttribute("data-id");
      document.getElementById("id").value = recordId; // set hidden input

      const modal = document.getElementById("updateModal");
      modal.style.display = "flex";
      modal.style.justifyContent = "center";
      modal.style.alignItems = "center";
      document.body.style.overflow = "hidden";
    });
  });

  // Close modal
  const closeBtn = document.getElementById("closeUpdateModal");
  const cancelBtn = document.getElementById("closeUpdateModalBtn");

  [closeBtn, cancelBtn].forEach(el => {
    el.addEventListener("click", () => {
      const modal = document.getElementById("updateModal");
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    });
  });

  // Click outside to close
  window.addEventListener("click", e => {
    const modal = document.getElementById("updateModal");
    if (e.target === modal) {
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    }
  });

  // ✅ AJAX form submission while keeping the form action attribute
  const updateForm = document.getElementById("updateDocsForm");
  updateForm.addEventListener("submit", function(e) {
    e.preventDefault(); // prevent default form submission

    // Validate file types and sizes for individual document fields
    const docFields = ['doc_f138hs', 'doc_f137', 'doc_birthcert', 'doc_goodmoral', 'doc_shsdiploma', 'doc_2x2picture'];
    const docNames = {
      'doc_f138hs': 'F138 HS',
      'doc_f137': 'F137',
      'doc_birthcert': 'Birth Certificate',
      'doc_goodmoral': 'Good Moral',
      'doc_shsdiploma': 'SHS Diploma',
      'doc_2x2picture': '2x2 Picture'
    };
    
    let hasFiles = false;
    for (let field of docFields) {
      const fileInput = document.querySelector(`input[name="${field}"]`);
      if (fileInput && fileInput.files.length > 0) {
        hasFiles = true;
        const file = fileInput.files[0];
        
        // Validate file type (2x2 Picture only accepts images)
        if (field === 'doc_2x2picture') {
          if (!file.type.startsWith("image/")) {
            Swal.fire({
              icon: 'error',
              title: 'Invalid File Type',
              text: `❌ ${docNames[field]} must be an Image file.`
            });
            return;
          }
        } else {
          if (!(file.type === "application/pdf" || file.type.startsWith("image/"))) {
            Swal.fire({
              icon: 'error',
              title: 'Invalid File Type',
              text: `❌ ${docNames[field]} must be a PDF or Image file.`
            });
            return;
          }
        }
        
        // Check file size (5MB limit)
        if (file.size > 5 * 1024 * 1024) {
          Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: `❌ ${docNames[field]} exceeds 5MB limit. Please upload a smaller file.`
          });
          return;
        }
      }
    }
    
    if (!hasFiles) {
      Swal.fire({
        icon: 'warning',
        title: 'No Files Selected',
        text: 'Please select at least one document to update.'
      });
      return;
    }

    const formData = new FormData(updateForm);

    fetch(updateForm.action, { // use the form's action
      method: "POST",
      body: formData
    })
    .then(response => response.json()) // PHP should return JSON
    .then(data => {
      if (data.status === "success") {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: data.message
        }).then(() => {
          // Reload page after clicking OK
          window.location.reload();
        });

        // Close modal
        document.getElementById("updateModal").style.display = "none";
        document.body.style.overflow = "auto";
      } else if (data.status === "warning") {
        Swal.fire({
          icon: 'warning',
          title: 'Warning',
          text: data.message
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.message
        });
      }
    })
    .catch(error => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Failed to update documents.'
      });
      console.error(error);
    });
  });
});
</script>







<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".delete-btn").forEach(button => {
    button.addEventListener("click", function () {
      const id = this.getAttribute("data-id"); // Get record ID

      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this application?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // ✅ Send delete request via fetch
          fetch('delete_document.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + encodeURIComponent(id)
          })
          .then(res => res.json())
          .then(data => {
            Swal.fire({
              icon: data.status === 'success' ? 'success' : 'error',
              title: data.status === 'success' ? 'Deleted!' : 'Error',
              text: data.message,
              confirmButtonColor: '#2563eb'
            }).then(() => {
              if (data.status === 'success') {
                location.reload(); // ✅ Refresh table
              }
            });
          })
          .catch(err => {
            Swal.fire('Error', 'Something went wrong while deleting.', 'error');
            console.error(err);
          });
        }
      });
    });
  });
});
</script>


<?php if (isset($_SESSION['delete_success'])): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Deleted!',
  text: '<?= $_SESSION['delete_success'] ?>',
  timer: 2000,
  showConfirmButton: false
});
</script>
<?php unset($_SESSION['delete_success']); endif; ?>

<?php if (isset($_SESSION['delete_error'])): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'Error!',
  text: '<?= $_SESSION['delete_error'] ?>'
});
</script>
<?php unset($_SESSION['delete_error']); endif; ?>

<!-- Upload Missing Documents Form Handler -->
<?php if ($hasApplication && !empty($missingDocuments)): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const uploadForm = document.getElementById("uploadMissingDocsForm");
  
  if (uploadForm) {
    uploadForm.addEventListener("submit", function(e) {
      e.preventDefault();
      
      // Validate files
      const docFields = <?php 
        $docFieldMap = [
          'F138 HS' => 'doc_f138hs',
          'F137' => 'doc_f137',
          'Birth Certificate' => 'doc_birthcert',
          'Good Moral' => 'doc_goodmoral',
          'SHS Diploma' => 'doc_shsdiploma',
          '2x2 Picture' => 'doc_2x2picture'
        ];
        echo json_encode(array_values(array_map(function($doc) use ($docFieldMap) {
          return $docFieldMap[$doc] ?? 'doc_' . strtolower(str_replace(' ', '_', $doc));
        }, $missingDocuments)));
      ?>;
      
      let hasFiles = false;
      for (let field of docFields) {
        const fileInput = uploadForm.querySelector(`input[name="${field}"]`);
        if (fileInput && fileInput.files.length > 0) {
          hasFiles = true;
          const file = fileInput.files[0];
          
          // Validate file type (2x2 Picture only accepts images)
          if (field === 'doc_2x2picture') {
            if (!file.type.startsWith("image/")) {
              Swal.fire({
                icon: 'error',
                title: 'Invalid File Type',
                text: '2x2 Picture must be an Image file.'
              });
              return;
            }
          } else {
            if (!(file.type === "application/pdf" || file.type.startsWith("image/"))) {
              Swal.fire({
                icon: 'error',
                title: 'Invalid File Type',
                text: 'All files must be PDF or Image files.'
              });
              return;
            }
          }
          
          // Check file size (5MB limit)
          if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
              icon: 'error',
              title: 'File Too Large',
              text: 'File size must not exceed 5MB.'
            });
            return;
          }
        }
      }
      
      if (!hasFiles) {
        Swal.fire({
          icon: 'warning',
          title: 'No Files Selected',
          text: 'Please select at least one document to upload.'
        });
        return;
      }
      
      const formData = new FormData(uploadForm);
      
      // Show loading
      Swal.fire({
        title: 'Uploading...',
        text: 'Please wait while we upload your documents.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });
      
      fetch(uploadForm.action, {
        method: "POST",
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        Swal.close();
        
        if (data.status === "success") {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: data.message,
            confirmButtonColor: '#2563eb'
          }).then(() => {
            window.location.reload();
          });
        } else if (data.status === "warning") {
          Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: data.message,
            confirmButtonColor: '#2563eb'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message,
            confirmButtonColor: '#dc2626'
          });
        }
      })
      .catch(error => {
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to upload documents.',
          confirmButtonColor: '#dc2626'
        });
        console.error(error);
      });
    });
  }
});
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