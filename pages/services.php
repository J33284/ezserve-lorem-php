<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); 

$businesses = $DB->query("SELECT * FROM business WHERE status ='1'");

?>

<?= element( 'header' ) ?>

<div class=" search container-fluid align-items-center justify-content-between"> 

      <div class="search-header py-5">
          <div id="searchbar" class="d-flex justify-content-center">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <span class="search-btn input-group-text border-0">
              <i class="bi bi-search"></i>
            </span>
          </div>
          
        </div>
    </div>
     
    <div class="mx-5 p-5">
    <?php foreach ($businesses as $business) : ?>
      <!-- main code -->
      <div class="card flex-row shadow-sm p-3 mb-5 bg-white rounded" style="width: 85vw;">
        <img class="card-img" src="assets/images/jh.jpg" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title"><?= $business['busName'] ?></h5>
            <p class="card-text"><?= $business['street'] . ', ' . $business['city_municipality'] ?></p>
            <form action="?page=client_business_details" method="post">
            <input type="hidden" name="businessCode" value="<?= $business['businessCode'] ?>">
            <button type="submit" class="btn btn-primary view-business" data-business-code="<?= $business['businessCode'] ?>">View</button>
          </form></div>
    </div>

     <?php endforeach; ?>
     
  </div>
     
  <script >
    
        

    
    
  </script> 
  
<?= element( 'footer' ) ?>