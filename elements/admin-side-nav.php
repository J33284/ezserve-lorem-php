<div class="side-nav card fixed-top  rounded-4 bg-opacity-10 bg-white">
<?php if (isset($_SESSION[AUTH_ID])) { ?>
    <?php if ($_SESSION[AUTH_TYPE] === 'admin') { ?>
      <div class="d-flex mx-3 justify-content-start align-items-center">
        <i class="bi bi-person-circle" style="font-size: 45px"></i>
        <h3 class="mt-4 mx-2"><?php echo $_SESSION[AUTH_NAME]; ?></h3>
      </div>
    <?php } ?>
        <hr class="mx-3">
        <div class="">
          <div class="nav-item <?php echo ($_GET['page'] === 'admin_business_reg') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=admin_business_reg" class="py-2"><i class="bi bi-list-check"></i><span>Registrations</span></i></a></div>
          <div class="nav-item <?php echo ($_GET['page'] === 'admin-bus-list') ? 'active' : ''; ?>"><a style="width:100rem" href="<?php echo SITE_URL ?>/?page=admin-bus-list" class="py-2"><i class="bi bi-briefcase"></i><span>Businesses</span></a></div>
          <div class="nav-item <?php echo ($_GET['page'] === 'admin-users') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=admin-users" class="py-2"><i class="bi bi-people"></i><span>User Accounts</span></a></div>
          <div class="nav-item <?php echo ($_GET['page'] === 'admin_profile') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=admin_profile" class="py-2"><i class="bi bi-person"></i><span>Profile</span></a></div>
          <div class="nav-item <?php echo ($_GET['page'] === 'admin_settings') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=admin_settings" class="py-2"><i class="bi bi-gear"></i><span> Settings</span></a></div>
      
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