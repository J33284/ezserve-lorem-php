<?= element('header') ?>
<div class="login container row justify-content-center align-items-center">
    <div class="logimg col-xl-7 d-flex justify-content-center align-items-center">
        <img src="./assets/images/has shadow with tagline.png" alt="Webworks Logo">
    </div>

    <div class="card justify-content-between border-0 col-sm-8 col-xl-5 shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h1>Email Verification</h1>
            <hr>
            <form method="post">
                <input type="hidden" name="action" value="email_verify">
                <input type="hidden" name="usertype" value="<?= isset($_GET['usertype']) ? $_GET['usertype'] : ''; ?>">
                <div class="row p-3">
                    <!-- Add any other necessary input fields -->
                <input type="text" class="form-control mb-3" name="email" value="<?= isset($_GET['email']) ? $_GET['email'] : ''; ?>" readonly>
                <input type="text" class="form-control mb-3" name="verification_code" required placeholder="Input Verification Code">
                
                </div>
                <div class="reset-pw p-2">
                    <a href="?page=register">Create New Account</a>
                </div>
                <button type="submit" class="btn btn-primary col-sm-12 m-2" name="submit">Verify</button>

            </form>
        </div>
    </div>
</div>
<?= element('footer') ?>
