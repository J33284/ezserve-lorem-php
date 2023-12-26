<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!--main local css-->
    <link href="./assets/view.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/images/webworks-logo.png">
    
  </head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
 


    <header class="header container-fluid align-items-center justify-content-center fixed-top  ">
    <div class="container header-nav d-flex justify-content-between align-items-center">
        <div class="logo-area">
            <img class="logo" src="assets/images/new logo.png">
            
        </div>
        <nav class="d-flex justify-content-between align-items-center">
        <ul class="d-flex align-items-center justify-content-between">
            <li><a href="<?php echo SITE_URL ?>/?page=default">Home</a></li>
            <li><a href="<?php echo SITE_URL ?>/?page=services">Service</a></li>
            <li><a href="<?php echo SITE_URL ?>/?page=about">About</a></li>
            
            <?php if (isset($_SESSION[AUTH_ID])) { ?>
            <li class="dropdown">
                <a class="" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class=" profile-logo bi-person-fill"></i>
                </a>
                <ul class="dropdown-menu w-auto" aria-labelledby="navbarDropdown">
                    <?php if ($_SESSION[AUTH_TYPE] === 'client') { ?>
                        <div class="d-flex mx-3 justify-content-start align-items-center">
                        <i class="bi bi-person-circle" style="font-size: 45px"></i>
                        <h4 class="mt-4 mx-2"><?php echo $_SESSION[AUTH_NAME]; ?></h4>
                        </div>
                        <hr class="p-0 m-3">
                        <li><a class="dropdown-item" href="<?php echo SITE_URL ?>/?page=client_profile">Profile</a></li>
                    <?php } elseif ($_SESSION[AUTH_TYPE] === 'business owner') { ?>
                        <div class="d-flex mx-3 justify-content-start align-items-center">
                        <i class="bi bi-person-circle" style="font-size: 45px"></i>
                        <h4 class="mt-4 mx-2"><?php echo $_SESSION[AUTH_NAME]; ?></h4>
                        </div>
                        <hr class="p-0 m-3">
                        <li><a class="dropdown-item" href="<?php echo SITE_URL ?>/?page=owner_profile">Profile</a></li>
                    <?php } elseif ($_SESSION[AUTH_TYPE] === 'admin') { ?>
                        <div class="d-flex mx-3 justify-content-start align-items-center">
                        <i class="bi bi-person-circle" style="font-size: 45px"></i>
                        <h4 class="mt-4 mx-2"><?php echo $_SESSION[AUTH_NAME]; ?></h4>
                        </div>
                        <hr class="p-0 m-3">
                        <li><a class="dropdown-item" href="<?php echo SITE_URL ?>/?page=admin_profile">Profile</a></li>
                    <?php } ?>

                    <li><a class="dropdown-item" href="<?php echo SITE_URL ?>/?action=logout">Logout</a></li>
                </ul>
            </li>

    
        <?php } else { ?>
            <a class="" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="profile-logo bi-person-fill"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="<?php echo SITE_URL ?>/?page=login">Login</a></li><br>
                <li><a class="dropdown-item" href="<?php echo SITE_URL ?>/?page=register">Sign Up</a></li>
                </ul>
        <?php } ?>
    </ul>
</nav>

    </div>
    <div class="message row m-0">      
      <div class="col left-content">
     <?= show_message(); ?>
     </div>
</div>
</header>


