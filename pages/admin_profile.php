<?= element('admin_header') ?>
<?= element('admin-side-nav') ?>

<script src="assets/js/script.js"></script>
<div id="profile" class="profile" style="margin: 120px 0 0 22%; width: 70vw">
  <div class="d-flex justify-content-between p-3">
    <h1>My Profile</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4" onclick="toggleEdit()">
      <i id="pencilIcon" class="bi bi-pencil-fill"></i>
    </a>
  </div>
<?php
$userData = viewAdmin($_SESSION['userID']);

$email = $userData->email;
$username = $userData->username;
?>

  <form id="profileForm" method="POST">
    <input type="hidden" name="action" value="adminFunction">
    <div class="form">
      <div class="row g-3 p-4">
        <div class="mb-3">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required readonly value="<?php echo $email; ?>">
        </div>
        <div class="mb-3">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="Username" required readonly value="<?php echo $username; ?>">
        </div>
        <div class="d-flex justify-content-end p-3" id="buttons">
          <button type="submit" name="update" id="updateButton" class="btn-update btn btn-primary me-2" style="display: none">Update</button>
          <button type="button" name="cancel" id="cancelButton" class="btn-cancel btn btn-secondary" style="display: none" onclick="cancelEdit()">Cancel</button>
        </div>
      </div>
    </div>
  </form>

