<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); 

$current_page = isset($_GET['page']) ? $_GET['page'] : 'default'; // Get the current page or default to 'default'

?>


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
    <link rel="icon" type="image/x-icon" href="assets/images/new logo.png">
    
  </head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
 


    <header class="header align-items-center justify-content-center fixed-top  " style="height: auto">
    <div class=" header-nav d-flex justify-content-between align-items-center" style="height: auto">
        <div class="title">
            <img class="logo col-sm-7" src="assets/images/has shadow.png">
            <a class="col-sm-3 burger-menu-icon" href="#" role="button" onclick="toggleMenu()">
        <i class="bi bi-list text-white"></i>
            </a>
        </div>
        <nav class="d-flex  align-items-center ">
        <ul class="burger-menu " id="burgerDropdown" >
                
        <li><a class="burger-item <?php echo ($current_page === 'default') ? 'active' : ''; ?>" href="<?= SITE_URL ?>/?page=default">Home</a></li>
    <li><a class="burger-item <?php echo ($current_page === 'services') ? 'active' : ''; ?>" href="<?= SITE_URL ?>/?page=services">Service</a></li>
    <li><a class="burger-item <?php echo ($current_page === 'about') ? 'active' : ''; ?>" href="<?= SITE_URL ?>/?page=about">About Us</a></li>

          
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
                        <li><a class="dropdown-item text-dark" href="<?php echo SITE_URL ?>/?page=admin_profile">Profile</a></li>
                    <?php } ?>

                    <li><a class="dropdown-item text-dark" href="<?php echo SITE_URL ?>/?action=logout">Logout</a></li>
                </ul>
            </li>

    
        <?php } else { ?>
            <a class="" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="profile-logo bi-person-fill"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item text-dark" href="<?php echo SITE_URL ?>/?page=login">Login</a></li><br>
                <li><a class="dropdown-item text-dark" href="<?php echo SITE_URL ?>/?page=register">Sign Up</a></li>
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


<style>
    .dropdown-menu li:hover>.dropdown-item {
        
  border-radius: 10px;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ;
  background:linear-gradient(to left, #ccffff 0%, #99ccff 58%);
  
}
.burger-menu li:hover>.burger-item {
        padding: 5px;
        border-radius: 5px;
  box-shadow:  #3385a6 0px 3px 8px; ;
        
      }
      .burger-menu .burger-item.active {
        padding: 5px;
        border-radius: 5px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px; ;
        background:linear-gradient(to bottom, #0f3a4b 0%, #3385a6 100%);
}


    .dropdown-item{
        color: #000000!important;
    }
    .burger-menu-icon {
            display: block;
        }
   @media (max-width: 1700px) {
        .logo{
            width: 10rem;
            height: 5rem;
            margin-left: 20px;
        }
        nav{
            margin: 0 50px;
        }
        nav ul{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .title{
            display:flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
        .burger-menu li a{
                display: block!important;
                color: #f1f1f1;
                text-decoration: none;
                font-size: 20px;
}
.burger-menu-icon {
                display: none;
            }

    }
     @media (max-width:700px) {
     
    .logo{
      width: 10rem;
      height: 4rem;
     margin: 0;
    }
    .header-nav{
        display: flex;
  flex-direction: column;
        
    }
    nav ul{
        display: flex;
  flex-direction: column;
  
    }
    nav ul li a{
        display:flex;
        justify-content: end;
    }
    .burger-menu {
                display: none;
                overflow: hidden;
                max-height: 0;
                transition: max-height 0.3s ease-in-out;
            }

            .burger-menu.show {
                display: block;
                max-height: 1000px; /* Adjust as needed */
                transition: max-height 0.3s ease-in-out;
            }

            .burger-menu li {
                display: block;
                color: #f1f1f1;
                text-decoration: none;
                font-size: 20px;
                transition: 0.3s;
                margin-top: 5px; /* Add some margin between menu items */
            }
            .burger-menu-icon {
                display: block;
            }
        } 

nav{
        display: flex;
  justify-content: start;
    }
    nav ul{
        padding:0;
    }
  
</style>
<script>
    function toggleMenu() {
        if (window.innerWidth <= 700) {
            var menu = document.getElementById('burgerDropdown');
            menu.classList.toggle('show');
        }
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 700) {
            // Hide the menu if the screen is wider than 700px
            var menu = document.getElementById('burgerDropdown');
            menu.classList.remove('show');
        }
    });
</script>