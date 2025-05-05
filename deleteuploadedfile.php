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

$retRecc = $_objAdmin->_getSelectList2('table_discount_party as p left join table_retailer as r on r.retailer_id=p.retailer_id', "r.retailer_name, r.retailer_id", '', " p.discount_id='" . $_POST['discountid'] . "' and p.retailer_id>0");
   
$total_product=count($retRecc);

if($usersCount==$total_product){

    echo '<div class="alert alert-danger" >You cant remove all retailers. Please unselect any of the retailer</div>';
    die;
    }

$List = implode(', ', $_POST["checkbox"]);


    $dis_det_id = $_objAdmin->removeDiscountRetailer($_POST["discountid"],$List);
   

echo '<div class="alert alert-success" >Successfully Deleted</div>';

?>