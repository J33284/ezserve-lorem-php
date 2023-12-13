<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businesses = $DB->query("SELECT * FROM business WHERE status = 1");

$keyword = "";
$results = [];

if (isset($_POST['keyword'])) {
  $keyword = $_POST['keyword'];

  $sql = "SELECT * FROM business WHERE status = 1 AND (busName COLLATE utf8mb4_unicode_ci LIKE '%$keyword%' OR busType COLLATE utf8mb4_unicode_ci LIKE '%$keyword%')";

  $results = $DB->query($sql);
}
else {
  $results = $businesses;
}

?>

<?= element('header') ?>
<div class="h-100">
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
    <div class="mx-5 p-5">
      <?php foreach ($results as $business): ?>
        <div class="card flex-row shadow-sm p-3 mb-5 bg-white rounded" style="width: 85vw;">
          <?php
          $imagePath = !empty($business['busImage']) ? $business['busImage'] : 'assets/images/default.jpg';
          ?>
          <img class="card-img" src="<?= $imagePath ?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title"><?= $business['busName'] ?></h5>
            <p class="card-text"><?= $business['street'] . ', ' . $business['city_municipality'] ?></p>
            <form action="?page=client_business_details&businessCode=<?= $business['businessCode'] ?>" method="post">
              <input type="hidden" name="businessCode" value="<?= $business['businessCode'] ?>">
              <button type="submit" class="btn btn-primary view-business">View</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div style="height: 100vh">
      <p class="text-light p-5">No results found for your search term: "<?= $keyword ?>"</p>
    </div>
  <?php endif; ?>

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
