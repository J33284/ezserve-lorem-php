<?php if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' ); 

$businesses = $DB->query("SELECT
v.codeName,
v.amount,
v.startDate,
v.endDate,
v.cond,
b.busName
FROM vouchers v
JOIN business b ON v.businessCode = b.businessCode;
");

$business = $businesses->fetch_assoc();

?>

<?= element( 'header' ) ?>

<div id="client-voucher" class="client-voucher mx-5 " style="margin-top: 120px; width: 80vw; height: 100vh">
  <div class="layout d-flex row d-flex justify-content-center align-items-center" style="height: 10vh">
    <div class="card small-card col-lg-2 col-sm-6 justify-content-center align-items-center " style="">
      <h1> <?= $business['amount'] ?> </h1> 
      <span> DISCOUNT </span>
    </div>
    <div class="card big-card col-lg-9 col-sm-4 py-3 px-5">
      <span class="mb-3"> <?= $business['busName'] ?> </span>
      <h1 class="text-uppercase m-0"> <?= $business['codeName'] ?> </h1>
      <span > <i class=" bi bi-stopwatch" style="margin-right: 5px"></i><?= $business['startDate'] ?> <?= $business['endDate'] ?> </span>
      <span > <?= $business['cond'] ?></span>
      <form action="?page=" method="post">
         <input type="hidden" name="branchCode" value="">
         <button type="submit" class="btn btn-primary float-end " data-business-code="">
             Apply
         </button>
      </form>
    </div>
    
  </div>
</div>
   

<?= element( 'footer' ) ?>

<style>
  @media(max-width:2000px){
    .small-card{
      padding: 72px 0 72px 0;
    }
  }
@media (max-width: 575px) {
  .big-card{
    width:65vw;
  }
  .big-card span{
    font-size: 1rem;
  
  }
  .small-card{
    width: 20vw;
    padding: 83px 0 83px 0;
  }
  .small-card button{
    width: 10px;
  }
  .client-voucher{
    width: 150vw;
    margin: 0px;
    padding: 0px;
    
  }
}

.small-card span{
  margin-top: -20px;
}
  </style>