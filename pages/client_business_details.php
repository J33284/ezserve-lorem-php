<style>
html{
  scroll-padding-top: 250px;
}
    </style>


<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');

$businessCode = $_GET['businessCode'];

// Retrieve all branches for the given business
$businesses = $DB->query("SELECT b.*, br.* FROM business b
        JOIN branches br ON b.businessCode = br.businessCode
        WHERE b.businessCode = '$businessCode'");

$business = $businesses->fetch_assoc();
?>

<?= element('header') ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="bus-details">
    
    <div class="container shadow mb-5 bg-white rounded details sticky-top" style="height: auto; padding: 30px 0px 0px 20px;">
        <div class="row">
            <h1 class="d-flex justify-content-start align-items-center"><?= $business['busName'] ?></h1>
        </div>

        <div class="links border-top">
            <ul class="d-flex justify-content-start align-items-center">
                <li class="nav-item"><a class="nav-link" href="#About"> About Us </a></li>
                <li class="nav-item"><a class="nav-link" href="#Branches"> Branches </a></li>
            </ul>
        </div>
    </div>

    <div class="info container d-flex justify-content-center align-items-center">
        <div>
            <div id="About" class="card p-3 shadow p-3 mb-5 bg-white rounded border-0" style="width: 80vw; height: auto;">
                <h2>About Us</h2>
                <hr>
                <p><?= $business['about'] ?></p>
            </div>
           
            <div id="Branches" class="card p-3 shadow p-3 mb-5 bg-white rounded border-0 d-flex" style="width:80vw; height: auto;">
                <h2> Branches </h2>
                <hr>
                <div class="map-group d-flex">
                <div id="map" class=" col shadow  mb-5 bg-white rounded border-0 " style="width: 50vw; height: 50vh;"></div>
                <div class="flex-column">
                <?php foreach ($businesses as $branch) : ?>
                    <div class=" d-flex mx-5">
                        
                        <h4 class="my-3"><?= $branch['branchName'] ?></h4>
                        <form action="?page=client_package&businessCode=<?= $business['businessCode'] ?>&branchCode=<?= $branch['branchCode'] ?>" method="post">
                            <input type="hidden" name="branchCode" value="<?= $branch['branchCode'] ?>">
                            <input type="hidden" name="businessCode" value="<?= $business['businessCode'] ?>">
                            <button type="submit" class="btn btn-primary view-package m-2" data-business-code="<?= $branch['branchCode'] ?>" >
                                View
                            </button>
                        </form>
                        </div>
                    
                    <?php endforeach; ?> 
                    </div>                   
                </div>
                    <hr>
                

                <!-- Move the map initialization outside the loop -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var map = L.map('map').setView([<?= $business['coordinates'] ?>], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                        <?php foreach ($businesses as $branch) : ?>
                            // Get the coordinates from PHP for each branch
                            var branchCoordinates = <?= json_encode($branch['coordinates']) ?>;

                            // Split the coordinates into latitude and longitude
                            var [branchLat, branchLng] = branchCoordinates.split(',');

                            // Add a marker for each branch location
                            L.marker([branchLat, branchLng]).addTo(map)
                                .bindPopup('<b><?= $branch['branchName'] ?></b><br><?= $branch['coordinates'] ?>');
                        <?php endforeach; ?>
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?= element('footer') ?>

<style>
    @media (max-width: 700px) {
        #Branches div{
            display: flex;
  flex-direction: column;
        }
       
    }
</style>