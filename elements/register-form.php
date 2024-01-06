<div class="login container row justify-content-center align-items-center">
    <div class="logimg col-xl-7 my-5 d-flex justify-content-center align-items-center">
        <img src="./assets/images/new logo.png" alt="ezServe Logo">
    </div>

    <div class="card justify-content-between border-0 col-sm-8 col-xl-5 shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h1>Sign Up</h1>
            <hr>
            <form method="post">
              <input type="hidden" name="action" value="register_user">
              <div class="row">
                  <p class="col-sm-4">Sign up as</p>
                  <select class="select col-sm-4 mb-3" name="data[usertype]" required>
                      <option value="" selected disabled>Select</option>
                      <option value="client">Client</option>
                      <option value="business owner">Business Owner</option>
                  </select>
              </div>
                        
              <!-- DEFAULT FORM FIELD -->
              <div class="mb-2">
                  <label for="exampleInputEmail1" class="form-label">First Name</label>
                  <input type="text"  class="form-control" name="data[fname]" value="<?php echo isset($_GET['fname']) ? htmlspecialchars($_GET['fname']) : ''; ?>" required>

                  		
              </div>
              <div class="mb-2">
                  <label for="exampleInputEmail1" class="form-label">Last Name</label>
                  <input type="text"  class="form-control" name="data[lname]" value="<?php echo isset($_GET['lname']) ? htmlspecialchars($_GET['lname']) : ''; ?>" required>

              </div>
              <div class="mb-2">
                  <label for="exampleInputEmail1" class="form-label">Birthday</label>
                  <input type="date"  class="form-control" name="data[birthday]" value="<?php echo isset($_GET['birthday']) ? htmlspecialchars($_GET['birthday']) : ''; ?>" required>
              </div>
              <div class="mb-2"> 
                  <label for="exampleInputEmail1" class="form-label">Email</label>
                  <input type="email"  class="form-control" name="data[email]" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>

              </div>
              <div class="mb-2">
                  <label for="exampleInputEmail1" class="form-label">Mobile Number</label>
                  <input type="text"  class="form-control" name="data[number]" value="<?php echo isset($_GET['number']) ? htmlspecialchars($_GET['number']) : ''; ?>" required>	
              </div>
              <div class="mb-2">
                  <label for="exampleInputPassword1" class="form-label">Username</label>
                  <input type="text"  class="form-control" name="data[username]" value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>" required>
              </div>
              <div class="mb-2">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password"  class="form-control" name="data[password]" value="<?php echo isset($_GET['password']) ? htmlspecialchars($_GET['password']) : ''; ?>" required>
              </div>
        
              <button type="submit" class="btn btn-primary">Register</button>        
            </form>
          </div>
        </div>
      </div>
