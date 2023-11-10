<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); 

//$businesses = $DB->query("SELECT * FROM business LIMIT 1");
$businesses = $DB->query("SELECT b.*, br.* FROM business b
    JOIN branches br ON b.businessCode = br.businessCode
    LIMIT 1");
?>


    <?= element( 'header' ) ?>
    
    <div class="bus-details" >
        <?php foreach ($businesses as $business) : ?>
      <div class=" container shadow mb-5 bg-white rounded details sticky-top " style="padding: 30px 0px 0px 20px;">
        <div class="row">
          <h1 class=" d-flex justify-content-start align-items-center"> <?= $business['busName'] ?></h1>
          
          </div>    
        
        <div class="links border-top ">
          <ul class=" d-flex justify-content-start align-items-center">
            <li class="nav-item"><a class="nav-link" href="#About"> About Us </a></li>
            <li class="nav-item"><a class="nav-link" href="#Branches"> Branches </a></li>
            
          </ul>
        </div>
     
      </div>         
     
      <div class="info container d-flex justify-content-center align-items-center">
           
          <div >
              <div id="About" class="card p-3 shadow p-3 mb-5 bg-white rounded border-0" style=" width: 80vw; height: 30vh;">
                <h2>About Us</h2>
                <hr>
                <p> <?= $business['about'] ?></p>
              </div>

              <div id="Branches" class="card p-3 shadow p-3 mb-5 bg-white rounded border-0">
                <h2> Branches </h2>
                <hr>
                <img class="d-flex justify-content-center align-items-center"src="../icons/sampleMap.jpg" alt="Google Map">

                <!--sample link-->
                <a href="./ownpack.html"><?= $business['branchName'] ?></a>
              </div>
              
              
            </div>
          </div>
          <?php endforeach; ?>
        </div>

    <?= element( 'footer' ) ?>