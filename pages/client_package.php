

<style>
      html{
        scroll-padding-top: 250px;
      }
</style>
</head>
<body>
    <main>
    <?= element( 'header' ) ?>
      <div class=" container pack-head sticky-top ">
        <div class="row">
          <a href="?page=client_profile" class=" col-xl-1 btn-back btn-lg float-end ">
            <i class="bi bi-arrow-left"></i></a>
          <h1 class="col-xl-7 d-flex justify-content-start">My Packages</h1>
          <div class="col-xl-3">
            <a href="#" class="btn-edit btn-lg float-end mt-4">
              <i class="bi bi-plus-square"></i>
              <span>create your own package!</span>
          </a>
          </div>
          </div>    
       </div>         
     
       <div id= "pack"class="pack">
        
        <div class="d-flex">
          <!-- sample 1-->
          <div class="card m-3 shadow p-3 mb-5 bg-white rounded border-0" >
          <img class="card-img-top" src="assets/images/jh.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Business Name</h5>
            <p class="card-text">Some Info</p>
            <a href="details.php" class="btn btn-primary">View</a>
          </div>
        </div>
        <!-- sample 2-->
        <div class="card m-3 shadow p-3 mb-5 bg-white rounded border-0" >
          <img class="card-img-top" src="assets/images/jh.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Business Name</h5>
            <p class="card-text">Some Info</p>
            <a href="details.php" class="btn btn-primary">View</a>
          </div>
        </div>
        <!--sample 3-->
        <div class="card m-3 shadow p-3 mb-5 bg-white rounded border-0" >
          <img class="card-img-top" src="assets/images/jh.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Business Name</h5>
            <p class="card-text">Some Info</p>
            <a href="details.php" class="btn btn-primary">View</a>
          </div>
        </div>
        <!--sample 4-->
        <div class="card m-3 shadow p-3 mb-5 bg-white rounded border-0" >
          <img class="card-img-top" src="assets/images/jh.jpg" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Business Name</h5>
            <p class="card-text">Some Info</p>
            <a href="details.php" class="btn btn-primary">View</a>
          </div>
        </div>
        </div>
      </div>
    </main>
    <?= element( 'footer' ) ?>
</body>
</html>

