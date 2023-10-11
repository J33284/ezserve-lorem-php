<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../main.js"></script>
    
    <?= element( 'header' ) ?>

    <main>
      <?= element( 'client-side-nav' ) ?>
      <!--main content-->
      <div id= "profile"class="profile">
        <div class="d-flex justify-content-between p-3">
          <h1>My Profile</h1>
          <a href="#" class="btn-edit btn-lg float-end mt-4">
            <i class="bi bi-pencil-fill"></i>
        </a>
        </div>
        <br>
        <div class="form "> <!-- naka only read format dapat, unless gn edit-->
          <div class="row g-3 p-4">
            <input type="text" class="form-control" id="fname" placeholder="First Name">
            <input type="text" class="form-control" id="lname" placeholder="Last Name">
            <input type="date" class="date form-control" id="birthday" placeholder="Birthday">     
            <input type="text" class="form-control" id="email" placeholder="Email Address">     
            <input type="text" class="form-control" id="email" placeholder="Username">     

            <input type="text" class="form-control " id="mobile" placeholder="Mobile Number">
            <input type="text" class="form-control " id="username" placeholder="Username">
            <input type="password" class="form-control " id="password" placeholder="Password">
          </div>
        </div>
      </div>

      <div id="purchase" class="purchase">
        <h1>My Purchases</h1>
        <br>

        <div class="card flex-row border-0">
          <img class="card-img col-xl-2" src="../icons/jh.jpg" alt="Card image cap">
          <div class="card-body col-xl-8">
            <h5 class="card-title">Business name</h5>
            <p class="card-text">Address and other info</p>
            <a href="#" class="btn btn-primary">View</a>
          </div>
        </div>
     
      </div>

      <div id="voucher" class="voucher">
        <h1>My Vouchers</h1>
          <br>
          <div class="card flex-row border-0">
            <div class="card-body col-xl-8">
              <h5 class="card-title">Discount</h5>
                <p class="card-text">minimum price req</p>
                <p class="card-text">code name</p>
                <p class="card-text">applied product</p>
            </div>
            <div class="ext card-body col-xl-4">
              <h5 class="card-title">Date Range</h5>
              <p class="card-text">Expiry Date</p>
            </div>
          </div>
            
          </div>
      </div>
    </main>
    <?= element( 'footer' ) ?>
  </body>
</html> 