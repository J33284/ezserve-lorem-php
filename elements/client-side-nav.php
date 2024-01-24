<div class="side-nav card fixed-top  rounded-4 bg-opacity-10 bg-white">
<?php if (isset($_SESSION[AUTH_ID])) { ?>
    <?php if ($_SESSION[AUTH_TYPE] === 'client') { ?>
      <div class="d-flex mx-3 justify-content-start align-items-center">
        <i class="bi bi-person-circle" style="font-size: 2rem"></i>
        <h3 class="mt-4 mx-2"><?php echo $_SESSION[AUTH_NAME]; ?></h3>
      </div>
    <?php } ?>
        <hr class="mx-3">
        <div class="">
          <div class="nav-item <?php echo ($_GET['page'] === 'client_profile') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=client_profile" class="py-2"><i class="bi bi-person"></i><span>My Profile</span></i></a></div>
          <div class="nav-item <?php echo ($_GET['page'] === 'client-order-history') ? 'active' : ''; ?>"><a href="<?php echo SITE_URL ?>/?page=client-order-history"><i class="bi bi-bag"></i><span>Order History</span></i></a></div>
           </div>
           <?php } ?>
      </div>

      
<style>
  


    @media (max-width: 1100px) {
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