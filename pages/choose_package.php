<?= element( 'header' ) ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<?php
$businessCode = isset($_GET['businessCode']) ? $_GET['businessCode'] : '';
$branchCode = isset($_GET['branchCode']) ? $_GET['branchCode'] : '';


$Bresult = "SELECT * FROM business WHERE businessCode = $businessCode";
$businessResult = $DB->query($Bresult);
$business = $businessResult->fetch_assoc();

$result = "SELECT * FROM branches WHERE businessCode = $businessCode AND branchCode = $branchCode";
$branchResult = $DB->query($result);
$branch = $branchResult->fetch_assoc();


?>
<?= element( 'owner-side-nav' ) ?>
<div class="business-branch" style="margin:120px 0 0 20%">
		<div class="d-flex">
		<a href="?page=branches&businesscode=<?=$businessCode?>" class=" col-1 btn-back btn-md text-dark float-center">
				<i class="bi bi-arrow-left"></i>
			</a>
			<h2><?= $business['busName'] ." (". $branch['branchName'] .")" ?> </h2>
			
		</div>
      


<div class="package-container">
        <div class="pack">
            <div class="pack-preview">
                <h2>Pre-Made Packages</h2>
                
            </div>
            <div class="pack-info">
				<p>Make a ready-made bundle with set items and cost for easy customer selection.</p>
                
                <a href="?page=package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="view"><i class="fas fa-eye"></i> View</a>      

            </div>
        </div>

        <div class="pack">
            <div class="pack-preview">
                <h2>Custom Package</h2>
            </div>
            <div class="pack-info">
                
				<p>Allow your customers to design their own personalized package.</p>

                
                <a href="?page=custom_package&businessCode=<?= $businessCode ?>&branchCode=<?= $branchCode ?>" class="view"><i class="fas fa-eye"></i> View</a>      

            </div>
        </div>
    </div>
</div>
</div>

<style>
@import url('https://fonts.googleapis.com/css?family=Muli&display=swap');

* {
	box-sizing: border-box;
}



.package-container {
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: row;
	
}

.pack {
	background-color: #fff;
	border-radius: 10px;
	box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
	display: flex;
	max-width: 100%;
	margin: 50px 50px 0 0;
	overflow: hidden;
	width: 700px;
}


.pack-preview {
	background-color: #0f3a4b;
	color: #fff;
	padding: 30px;
	max-width: 250px;
}

.pack-preview h2 {
	color: #fff;
}

.pack-info {
	padding: 30px;
	position: relative;
	width: 100%;
  height: 300px;
}

.add {
	background-color: #13475c;
	border: 0;
	border-radius: 30px;
	box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
	color: #fff;
	font-size: 16px;
	padding: 12px 25px;
	position: absolute;
	bottom: 30px;
	right: 160px;
	letter-spacing: 1px;
}

.view {
	background-color: #13475c;
	border: 0;
	border-radius: 30px;
	box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
	color: #fff;
	font-size: 16px;
	padding: 12px 25px;
	position: absolute;
	bottom: 30px;
	right: 30px;
	letter-spacing: 1px;
}


</style>


