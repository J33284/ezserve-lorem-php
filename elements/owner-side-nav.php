<?php
$userData = viewUser($_SESSION['userID']);
$profileImage = $userData->profileImage;

?>


<div class="side-nav card fixed-top rounded-4 bg-opacity-10 bg-white">
  <?php if (isset($_SESSION[AUTH_ID])) { ?>
    <?php if ($_SESSION[AUTH_TYPE] === 'business owner') { ?>
      <div class="d-flex mx-3 justify-content-start align-items-center">
    <?php if (!empty($profileImage)): ?>
        <img class="profileImg rounded-circle shadow p-1 bg-white" id="preview_profileImage" alt="Profile Image" 
            src="<?php echo $profileImage; ?>" style="width:5rem; height: 5rem">
    <?php else: ?>
        <i class="bi bi-person-circle" style="font-size: 2rem"></i>
    <?php endif; ?>
    <h3 class="mt-4 mx-2"><?php echo $_SESSION[AUTH_NAME]; ?></h3>
</div>

    <?php } ?>
    <hr class="mx-3">
    <div>
      <div class="nav-item <?php echo ($_GET['page'] === 'owner_profile') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=owner_profile" class="py-2"><i class="bi bi-person"></i><span>My Profile</span></a></div>
      <div class="nav-item <?php echo ($_GET['page'] === 'owner-order-list') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=owner-order-list" class="py-2"><i class="bi bi-list-check"></i><span>Client Orders</span></a></div>
      <div class="nav-item <?php echo ($_GET['page'] === 'owner_business') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=owner_business" class="py-2"><i class="bi bi-briefcase"></i><span>My Business</span></a></div>
      <div class="nav-item <?php echo ($_GET['page'] === 'owner_voucher') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=owner_voucher" class="py-2"><i class="bi bi-tags"></i><span>My Vouchers</span></a></div>
      <div class="nav-item <?php echo ($_GET['page'] === 'owner-settings') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=owner-settings" class="py-2"><i class="bi bi-gear"></i><span>Settings</span></a></div>
      
    </div>
  <?php } ?>
</div>


  <style>
    @media (max-width: 1300px) {
  .side-nav .nav-item span, h3{
    visibility: hidden;

  }
  .side-nav .nav-item span{
    visibility: hidden;

  }
  .side-nav i{
    font-size: 25px;
  }
  .side-nav{
    width: 15vw;
  }
 
  }
  

  </style>
