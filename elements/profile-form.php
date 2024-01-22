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
$profileImage = $userData->profileImage;



?>

<script src="assets/js/script.js"></script>
<div class="pb-5" style="height: auto ">
<div id="profile" class="profile" >
  <div class="d-flex justify-content-between p-3">
    <h1 >My Profile</h1>
    <a href="#" class="btn-edit btn-lg float-end mt-4 " onclick="toggleEdit()">
      <i id="pencilIcon" class="bi bi-pencil-fill"></i>
    </a>
  </div>

  <form id="profileForm" method="POST" class="pb-5 ">
        <?= csrf_token() ?>
        <input type="hidden" name="action" value="usersAction">
        <div class="form">
            <div class="card p-4 mb-3">
            <div class="row g-3">
                <div class="d-flex justify-content-center align-items-center mb-2">
                        <div class="rounded-5">
                        <img class="profileImg rounded-circle shadow p-1 mb-5 bg-white"  id="profileImage<?$userData?>" alt="Profile Image" src="assets/images/profile-placeholder.jpg" >
                        <input type="file" class="form-control w-50" id="addProfileImage" name="addProfileImage" accept="image/*" onchange="previewPic(this)" style="display:none">
                        
</div>
                </div>
                <div class="fields mb-3 ">
                    <label class="mb-2 col-lg-3 col-sm-5 " for="fname">First Name</label>
                    <input type="text" class="col form-control" name="fname" id="fname" placeholder="First Name" required readonly
                        value="<?php echo $fname; ?>">
                </div>
                <div class=" fields mb-3">
                    <label class="mb-2 col-lg-3 col-sm-5" for="lname">Last Name</label>
                    <input type="text" class=" col form-control" name="lname" id="lname" placeholder="Last Name" required readonly
                        value="<?php echo $lname; ?>">
                </div>
                <div class="fields  mb-3 ">
                    <label class="mb-2 col-lg-3 col-sm-5" for="birthday">Birthday</label>
                    <input type="date" class="date col form-control" name="birthday" id="birthday" placeholder="Birthday" required readonly
                        value="<?php echo $birthday; ?>">
                </div>
               
                <div class="fields  mb-3 ">
                    <label class="mb-2 col-lg-3 col-sm-5 " for="number">Mobile Number</label>
                    <input type="text" class=" col form-control" name="number" id="number" placeholder="Mobile Number" required readonly
                        value="<?php echo $number; ?>">
                </div>
                <div class="fields mb-3 ">
                    <label class="mb-2 col-lg-3 col-sm-5" for="ownerAddress">Address</label>
                    <input type="text" class=" col form-control" name="ownerAddress" id="ownerAddress" placeholder="Address"  readonly
                        value="<?php echo $ownerAddress; ?>">
                </div>
</div>
                </div>
                <div class="card p-4">
                    <div class="fields mb-3 ">
                        <label class="mb-2 col-lg-3 col-sm-5 " for="email">Email Address</label>
                        <input type="email" class=" col form-control" name="email" id="email" placeholder="Email Address" required readonly
                            value="<?php echo $email; ?>">
                    </div>
                    <div class="fields ">
                        <label class="mb-2 col-lg-3 col-sm-5 " for="username">Username</label>
                        <input type="text" class=" col form-control" name="username" id="username" placeholder="Username" required readonly
                            value="<?php echo $username; ?>">
                    </div>
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
</div>

<style>
    @media (max-width: 1700px) {
        .fields{
            display: flex;
            flex-direction: row
        }
        .profileImg{
            width: 10rem;
        }
    }

    @media (max-width:700px) {
        .fields{
            display: flex;
            flex-direction: column;
        }
        .profileImg{
            width: 8rem;
        }
    }
</style>
<script>

function previewPic(input, userID) {
    console.log('previewPic function called');
    var previewBr = input.closest('.profileForm').querySelector('.imageBranchPreview_' + branchCode);

    console.log('File:', input.files);

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onloadend = function () {
            console.log('Read successful');
            previewBr.src = reader.result;
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        console.log('No file selected or no files support');
        previewBr.src = "https://mdbootstrap.com/img/Photos/Others/placeholder.jpg";
    }
}

</script>