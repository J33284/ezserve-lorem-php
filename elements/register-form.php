<div class="login container row justify-content-center align-items-center">
    <div class="signimg col-lg-5 my-5 d-flex justify-content-center align-items-center">
        <img src="./assets/images/has shadow with tagline.png" alt="ezServe Logo">
    </div>

    <div class="card justify-content-between border-0 col-sm-8 col-lg-6 shadow p-3 mb-5 bg-white rounded">
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

              <div class="mb-2">
                <label for="exampleInputPassword2" class="form-label">Re-type Password</label>
                <input type="password" class="form-control" name="data[repassword]" value="<?php echo isset($_GET['repassword']) ? htmlspecialchars($_GET['repassword']) : ''; ?>" required>
            </div>

            <div class="mb-2 form-check">
                <input type="checkbox" class="form-check-input" id="showPassword">
                <label class="form-check-label" for="showPassword">Show Password</label>
            </div>
            <div class="pwWarning mb-3">
                <p >Password must contain the following:</p>
                <li>Minimum of 8 characters</li>
                <li>One or more lowercase letter</li>
                <li>One or more uppercase letter</li>
                <li>One or more digit characters</li>
                <li>One or more special characters</li>
            </div>

              <button type="submit" class="btn btn-primary mb-3">Register</button>     
              <div class="register p-2 d-flex align-items-center justify-content-start">
                            <p>Already have an account?<a href="<?php echo SITE_URL?>/?page=login">Login</a></p>
                        </div>   
            </form>
          </div>
        </div>
      </div>

<style>
    .pwWarning p, li{
        margin:5px!important;
        font-size: 12px;
        color: #009933;
    }
.signimg img{
    width: 50vw;
}
@media (max-width:1700px) {
                .login{
                    margin-left: 5%;
                }
                .card{
                    margin-left: 50px;
                }
            }
@media (max-width: 700px) {
    .login{
        width: 100%;
        margin: 120px 0 0 0 ;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.querySelector('input[name="data[password]"]');
    const rePasswordInput = document.querySelector('input[name="data[repassword]"]');
    const showPasswordCheckbox = document.getElementById('showPassword');

    showPasswordCheckbox.addEventListener('change', function () {
        const type = showPasswordCheckbox.checked ? 'text' : 'password';
        passwordInput.type = type;
        rePasswordInput.type = type;
    });
});
</script>
