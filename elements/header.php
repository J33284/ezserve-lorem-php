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
    
  </head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
 


    <header class="header container-fluid align-items-center justify-content-center fixed-top">
    <div class="container header-nav d-flex justify-content-between align-items-center">
        <div>
            <img class="logo" src="assets/images/webworks-logo(white).png">
            <span><b>WEBWORKS</b></span>
        </div>
        <nav class="d-flex justify-content-between align-items-center">
            <ul class="d-flex align-items-center justify-content-between">
                <li><a href="<?php echo SITE_URL ?>/?page=default">Home</a></li>
                <li><a href="<?php echo SITE_URL ?>/?page=service">Service</a></li>
                <li><a href="<?php echo SITE_URL ?>/?page=owner-profile">About</a></li>
                <li><a href="<?php echo SITE_URL ?>/?page=login"><i class="bi-person-fill"></i></a></li>
              
        </nav>
    </div>
</header>
      
