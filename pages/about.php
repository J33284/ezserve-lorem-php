<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); ?>
<?php element( 'header' ); ?>
<div class="aboutContainer" style="margin: 150px 100px 100px 100px; height: auto">
    <div class="quotenquote">
        <h1 class="mb-5">ABOUT ezServe</h1>
        <p class="text-justify">"EzServe is your one-stop online platform designed to streamline and simplify the process of searching services and customizing service packages. Our mission is to provide a user-friendly and efficient experience for both customers and service providers, ensuring that your needs are met with ease and convenience."</p>
    </div>

    <div class="contactus" style="width: 40vw">
        <div class="card rounded p-5">
            <h1>Get in Touch</h1>
            <p>Explore our Help Docs or contact our team.</p>
            <hr>
            <div class="d-flex mb-3">
            <input type="text" class="form-control" style="margin-right:15px" id=""  placeholder="First Name">
            <input type="text" class="form-control " id=""  placeholder="Last Name">
    
            </div>
            <input type="email" class="form-control " id=""  placeholder="Enter email">
            <p class=" mt-3 mb-0">What can we help you with?</p>
            <textarea class="form-control" id="" rows="3"></textarea>
            <button type="submit" class="btn btn-primary my-4">Send</button>
        </div>
    </div>


</div>
<?php element( 'footer' ); ?>