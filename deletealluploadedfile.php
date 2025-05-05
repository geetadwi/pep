<?php

include("includes/config.inc.php");
include("includes/function.php");
$page_name = "Add Scheme";
$_objAdmin = new Admin();
$_objItem = new Item();
$objArrayList = new ArrayList();

$usersCount = count($_POST["checkbox"]);


include("import.inc.php");



    $dis_det_id = $_objAdmin->removeDiscountRetailer($_POST["discountid"],0);
   

echo '<div class="alert alert-success" >Successfully Deleted</div>';

?>