<?php

include("includes/config.inc.php");
include("includes/function.php");
$page_name = "Add Scheme";
$_objAdmin = new Admin();
$_objItem = new Item();
$objArrayList = new ArrayList();

$usersCount = count($_POST["checkbox"]);


include("import.inc.php");

$usersCount = count($_POST["checkbox"]);
if($usersCount<1){

echo '<div class="alert alert-danger" >Please select any value</div>';
die;
}
$List = implode(', ', $_POST["checkbox"]);


    $dis_det_id = $_objAdmin->removeDiscountRetailer($_POST["discountid"],$List);
   

echo '<div class="alert alert-success" >Successfully Deleted</div>';

?>