<?php
$userData = viewUser($_SESSION['userID']);

$fname = $userData->fname;
$lname = $userData->lname;
$birthday = $userData->birthday;
$email = $userData->email;
$number = $userData->number;
$username = $userData->username;
$password = $userData->password;
$ownerAddress = $userData->ownerAddress;

?>

<script src="assets/js/script.js"></script>
<div id="profile" class="profile">
  <div class="d-flex justify-content-between p-3">
    <h1 >My Profile</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4 " onclick="toggleEdit()">
      <i id="pencilIcon" class="bi bi-pencil-fill"></i>
    </a>
  </div>

  <form id="profileForm" method="POST">
        <?= csrf_token() ?>
        <input type="hidden" name="action" value="usersAction">
        <div class="form">
            <div class="row g-3">
                <div class="mb-2">
                    <label class="mb-2 " for="fname">First Name</label>
                    <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" required readonly
                        value="<?php echo $fname; ?>">
                </div>
                <div class="mb-2">
                    <label class="mb-2 " for="lname">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" required readonly
                        value="<?php echo $lname; ?>">
                </div>
                <div class="mb-2">
                    <label class="mb-2 " for="birthday">Birthday</label>
                    <input type="date" class="date form-control" name="birthday" id="birthday" placeholder="Birthday" required readonly
                        value="<?php echo $birthday; ?>">
                </div>
                <div class="mb-2">
                    <label class="mb-2 " for="email">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required readonly
                        value="<?php echo $email; ?>">
                </div>
                <div class="mb-2">
                    <label class="mb-2 " for="number">Mobile Number</label>
                    <input type="text" class="form-control" name="number" id="number" placeholder="Mobile Number" required readonly
                        value="<?php echo $number; ?>">
                </div>
                <div class="mb-2">
                    <label class="mb-2 " for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required readonly
                        value="<?php echo $username; ?>">
                </div>
                <div class="mb-2">
                    <label class="mb-2 " for="ownerAddress">Address</label>
                    <input type="text" class="form-control" name="ownerAddress" id="ownerAddress" placeholder="Address"  readonly
                        value="<?php echo $ownerAddress; ?>">
                </div>
                <div class="d-flex justify-content-end p-3" id="buttons">
                    <button type="submit" name="updateProfile" id="updateButton" class="btn-update btn btn-primary me-2"
                        style="display: none">Update</button>
                    <button type="button" name="cancel" id="cancelButton" class="btn-cancel btn btn-secondary"
                        style="display: none" onclick="cancelEdit()">Cancel</button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
