<div class="login container row  justify-content-between d-flex align-items-center">
            <div class="logimg col-lg-6 d-flex my-5 mx-3 justify-content-center align-items-center">
                <img src="./assets/images/has shadow with tagline.png" alt="ezServe Logo" >
            </div>

            <div class="card justify-content-between border-0 col-sm-8 col-lg-5 shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h1>Login</h1>
                    <hr>
                    <form method="post">
                    <?= csrf_token()?>
                    <input type="hidden" name="action" value="validate_user">
                        <div class="row p-3">
                            <input type="text" class="form-control mb-3" name="username" required placeholder="Username or Email Address">
                            <input type="password" class="form-control" name="password" required placeholder="Password">
                        </div>
                        
                        <div class="reset-pw p-2">
                            <a href="/pages/reset">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary col-sm-12 m-2" name="submit">Login</button>

 
                        <div class="register p-2 d-flex align-items-center justify-content-center">
                            <p>Don't have an account?<a href="<?php echo SITE_URL?>/?page=register">Register</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            @media (max-width:1700px) {
                .login{
                    margin-left: 5%;
                }
                .card{
                    margin-left: 10px;
                }
            }
            @media (max-width: 700px) {
                .login{
                    width: 100%;
                    margin: 120px 0 0 0 ;
                }
            }
        </style>