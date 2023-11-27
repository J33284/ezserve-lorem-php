<?= element('header') ?>

<div class="login container row justify-content-center align-items-center">
    <div class="logimg col-xl-7 d-flex justify-content-center align-items-center">
        <img src="./assets/images/webworks-logo(with name).png" alt="Webworks Logo">
    </div>

    <div class="card justify-content-between border-0 col-sm-8 col-xl-5 shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <h1>Email Verification</h1>
            <hr>
            <form method="post" action="?action=email_verify">
                
                <?php
                if (isset($_GET['email'])) {
                    $email = htmlspecialchars($_GET['email']);
                    echo '<input type="text" class="form-control mb-3" name="email" value="' . $email . '" readonly>';
                } else {
                    // Handle the case where email parameter is missing
                    echo '<div class="alert alert-danger" role="alert">Invalid or missing email parameter</div>';
                }
                ?>
                
                <input type="text" class="form-control mb-3" name="verification_code" required placeholder="Input Verification Code">

                <div class="reset-pw p-2">
                    <a href="<?php echo SITE_URL ?>?page=register">Change Email</a>
                </div>
                <button type="submit" class="btn btn-primary col-sm-12 m-2" name="submit">Verify</button>
            </form>
        </div>
    </div>
</div>

<?= element('footer') ?>
