<?php
$userData = viewUser($_SESSION['userID']);

$fname = $userData->fname;
$lname = $userData->lname;
$birthday = $userData->birthday;
$email = $userData->email;
$number = $userData->number;
$username = $userData->username;
$password = $userData->password;

?>

<script src="assets/js/script.js"></script>
<div id="profile" class="profile">
  <div class="d-flex justify-content-between p-3">
    <h1>My Profile</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4" onclick="toggleEdit()">
      <i id="pencilIcon" class="bi bi-pencil-fill"></i>
    </a>
  </div>

  <form id="profileForm" method="POST">
  <?= csrf_token()?>
  <input type="hidden" name="action" value="usersAction">
  <div class="form">
    <div class="row g-3 p-4">
      <input type="text" class="form-control" name="fname" placeholder="First Name" required readonly value="<?php echo $fname; ?>">
      <input type="text" class="form-control" name="lname" placeholder="Last Name" required readonly value="<?php echo $lname; ?>">
      <input type="date" class="date form-control" name="birthday" placeholder="Birthday" required readonly value="<?php echo $birthday; ?>">
      <input type="email" class="form-control" name="email" placeholder="Email Address" required readonly value="<?php echo $email; ?>">
      <input type="text" class="form-control" name="number" placeholder="Mobile Number" required readonly value="<?php echo $number; ?>">
      <input type="text" class="form-control" name="username" placeholder="Username" required readonly value="<?php echo $username; ?>">
    <button type="submit" name="update" id="updateButton" class="btn-update btn btn-primary me-2" style="display: none">Update</button>
    <button type="button" name="cancel" id="cancelButton" class="btn-cancel btn btn-secondary" style="display: none" onclick="cancelEdit()">Cancel</button>
  </div>
</form>
</body>
</html>
