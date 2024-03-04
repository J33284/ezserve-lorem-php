<?php
if (!defined('ACCESS')) die('DIRECT ACCESS NOT ALLOWED');
global $DB;

$businessID = $_SESSION['userID'];

$businesses = $DB->query("
    SELECT b.*, br.* FROM business b
    JOIN branches br ON b.businessCode = br.businessCode
    WHERE business.ownerID = '$businessID'
");

?>

<?= element('header') ?>

<?= element('owner-side-nav') ?>

<div class="owner-settings" id="owner-settings" style="width: 70vw; height:auto; margin: 120px 0 0 23%">
    <div class="">
        <h1 >Settings</h1>
    </div>
    <div class="card p-5">
        <h3>Business/Branch Deletion Request</h3>
        <hr>
        <p>Send a request to delete your business that is stored in our system. You will receive an email to verify your request. Once the email have been verified, we will take care of deleting your business</p>
        <p><strong>Note: Please be informed that your business will be deleted once the administrators have reviewed your business.</strong></p>       
    
    <div class="d-flex">
    <div>
            <label for="business">Choose which to delete:</label>
            <select name="business" id="business" class="form-select" required>
            <option disabled selected >--Select--</option>
            <option value="">Business and branches</option>
            <option value="saab">Branch only</option>
            </select>
        </div>
        <div class="mx-3">
            <label for="business">Choose which business:</label>
            <select name="business" id="business" class="form-select" required>
            <option disabled selected >--Select business--</option>
            <option value=""><? $business['']?></option>
            </select>
        </div>
        <div >
            <label for="branch">Choose which branch:</label>
            <select name="branch" id="branch" class="form-select" required>
            <option disabled selected >--Select branch--</option>
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="mercedes">Mercedes</option>
            <option value="audi">Audi</option>
            </select>
        </div>
    

    </div>
        <div class="reasons my-4">
            <p> Select a reason for the deletion request</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> Closure of business</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> Legal Issues</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> Duplicate Listings</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> Platform Migration</label>
            </div>
        </div>
        <button type="button" class="btn btn-primary float-end" style="width: 100px">Submit</button>
    </div>

    <div class="card p-5 my-5">
        <h3>Account Deletion Request</h3>
        <hr>
        <p>Send a request to delete your account that is stored in our system. You will receive an email to verify your request. Once the email have been verified, we will take care of deleting your business.</p>
        <p><strong>Note: Please be informed that all your business, branches, packages, and items registered under this account will also be deleted.</strong></p>
        <p><strong>Note: Please be informed that your account will be deleted once the administrators have reviewed your account.</strong></p>       
    
    <div class="d-flex">
    </div>
        <div class="reasons my-4">
            <p> Select a reason for the deletion request</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> Created another account</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> Privacy Concerns</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> I don't find it useful</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault"> Safety Concerns</label>
            </div>
        </div>
        <button type="button" class="btn btn-primary float-end" style="width: 100px">Submit</button>
    </div>
</div>


<?= element('footer') ?>


