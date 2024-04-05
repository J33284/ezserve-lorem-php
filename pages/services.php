
<head><title>Services</title></head>
<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businesses = $DB->query("SELECT DISTINCT business.*
    FROM business
    WHERE business.status = '1'");


$keyword = "";
$results = [];

if (isset($_POST['keyword'])) {
  $keyword = $_POST['keyword'];

  $sql = "SELECT * FROM business WHERE status = 1 
  AND (busName COLLATE utf8mb4_unicode_ci LIKE '%$keyword%' OR busType COLLATE utf8mb4_unicode_ci LIKE '%$keyword%')";

  $results = $DB->query($sql);
}
else {
  $results = $businesses;
}

?>

<?= element('header') ?>
<div >
  <div class="search container-fluid align-items-center justify-content-between">

    <div class="search-header py-5">
      <form id="searchbar" class="d-flex justify-content-center" method="post">
        <input type="text" class="form-control rounded" placeholder="Search" name="keyword" value="<?= $keyword ?>" />
        <button type="button" class="btn btn-primary" id="search-button" data-mdb-ripple-init>
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>

    <?php if (!empty($results)): ?>
      <div class="service-wrap mx-5 p-5">
        <div class="sub-service row">
        <?php $cardCount = 0; ?>
          <?php foreach ($results as $business): ?>
            <?php $cardCount++; ?>
            <div class="col-md-3 mb-4">
              <div class="card shadow-sm p-3 mb-5 bg-white bg-opacity-75 justify-content-between" style="width: 100%; height: auto">
              <div >
                <?php
                $imagePath = !empty($business['busImage']) ? $business['busImage'] : 'assets/images/default.jpg';
                ?>
                <img class="card-img-top rounded-3 img-fluid"  src="<?= $imagePath ?>" alt="Card image cap" style="height:190px">
                <div class="card-body" style="height:100px;">
                  <h5 class="card-title"><?= $business['busName'] ?></h5>
                  <p class="card-text"><?= $business['city_municipality'] . ' ' . $business['province'] ?></p>
                  
                </div>
          </div>
                <form action="?page=client_business_details&businessCode=<?= $business['businessCode'] ?>" method="post">
                    <input type="hidden" name="businessCode" value="<?= $business['businessCode'] ?>">
                    <button type="submit" class="btn btn-primary view-business m-0 d-flex align-items-end">View</button>
                  </form>
              </div>
            </div>
            <?php if ($cardCount % 4 === 0): ?>
              </div><div class="row">
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php else: ?>
      <div style="height: 100vh">
        <p class="text-light p-5">No results found for your search term: "<?= $keyword ?>"</p>
      </div>
    <?php endif; ?>

  </div>
</div>
    </div>
<?= element('footer') ?>
<script>
const searchButton = document.getElementById('search-button');

searchButton.addEventListener('click', function() {
  document.getElementById('searchbar').submit();
});

const searchInput = document.querySelector('#searchbar input');

searchInput.addEventListener('keypress', function(event) {
  if (event.key === 'Enter') {
    event.preventDefault();
    document.getElementById('search-button').click();
  }
});
</script>

<style>
  
  @media (max-width: 700px) {
    .service-wrap{
      margin-left: 0!important;
      padding: 0!important;
      width: 100vw;
      
    }
  
    
  }
</style>