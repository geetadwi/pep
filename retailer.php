<?php
include("includes/config.inc.php");
include("includes/function.php");
$page_name = $AliaseUsers['retailer'] . " List";
$_objAdmin = new Admin();
$_objItem = new Item();
$_objModuleClass = new ModuleClass();
$feature_array = $_objModuleClass->getFeatureModulel();
//print_r($feature_array);
//print_r($feature_array);

// Get country phone no length
$getCountryId = $_objAdmin->getCountryPhoneNoLenght($_SESSION['accountId']);

if (in_array(21, $feature_array)) {
    $flag = 1;
    // for  show.
} else {
    $flag = 0;
    // for not show.
}
//echo $flag;
//Todo Start Sudhanshu 28 may 2024 : add status filtr
if (isset($_POST['showMaster']) && $_POST['showMaster'] == 'yes') {

    if ($_POST['status'] != "all") {
        $_SESSION['retStatus'] = $_POST['status'];
        //echo "Salesman id=".$_SESSION['SalOrderList'];die;
    }else{
        unset($_SESSION['retStatus']);
    }

    header("Location: retailer.php");
}

if (isset($_REQUEST['reset']) && $_REQUEST['reset'] == 'yes') {
    unset($_SESSION['retStatus']);
    header("Location: retailer.php");
}
//Todo End Sudhanshu 28 may 2024 : add status filtr
if (isset($_REQUEST['show']) && $_REQUEST['show'] == "yes") {
    $_objAdmin->showRetailer($flag);
    die;
}
if ($_REQUEST['retid'] != '') {
    $_SESSION['RetailerID'] = $_REQUEST['retid'];
    header('location:RetOpeningStockByDate.php');
}
if (isset($_REQUEST['retId']) && $_REQUEST['retId'] != "") {
    $_SESSION['RetMap'] = $_REQUEST['retId'];
    header("Location: retailermap.php");
}
if (isset($_POST['delete']) && $_POST['delete'] == 'yes' && $_POST['id'] != "") {
    //print_r($_POST);die;
    $id = $_objAdmin->_dbUpdate(array("last_update_date" => date('Y-m-d'), "last_update_status" => 'Delete', "status" => 'D'), 'table_retailer', " retailer_id='" . $_POST['id'] . "'");
    $del = mysql_query("DELETE FROM table_route_retailer WHERE retailer_id='" . $_POST['id'] . "'");
    $get_surveyid = mysql_query("SELECT survey_id FROM table_survey WHERE retailer_id='" . $_POST['id'] . "'");
    while ($row = mysql_fetch_array($get_surveyid)) {
        $survey_id = $row['survey_id'];
        $get_image = mysql_query("SELECT image_url FROM table_image WHERE ref_id='" . $survey_id . "' AND image_type='3'");
        while ($row1 = mysql_fetch_array($get_image)) {
            $dir = 'photo';
            unlink($dir . '/' . $row1['image_url']);
        }
        mysql_query("DELETE FROM table_image WHERE ref_id='" . $survey_id . "' AND image_type='3'");
    }
    mysql_query("DELETE FROM table_survey WHERE retailer_id='" . $_POST['id'] . "'");
    mysql_query("DELETE FROM table_web_users WHERE retailer_id='" . $_POST['id'] . "'");
}
include("retailer.inc.php");
include("import.inc.php");
include("header.inc.php");
?>
<script type="text/javascript">
    function showUser(str) {
//alert(str);
//alert(id);
        $.ajax({
            'type': 'POST',
            'url': 'disuser.php',
            'data': 'd=' + str,
            'success': function (mystring) {
                //alert(mystring);
                document.getElementById("disList").innerHTML = mystring;
            }
        });
    }
</script>
<!--<script type="text/javascript">
function showStateCity(str,id)
{
//alert(str);
//alert(id);
	$.ajax({
		'type': 'POST',
		'url': 'ret_dropdown_city.php',
		'data': 's='+str+'&c='+id,
		'success' : function(mystring) {
			//alert(mystring);
		document.getElementById("outputcity").innerHTML = mystring;
		}
	});
}
</script>-->
<!-- start content-outer -->
<style>
    .retailer_address_div {
        width: 50% !important;
    }
</style>
<input name="pagename" type="hidden" id="pagename" value="retailer.php"/>
<aside class="right-side">
    <section class="content-header">
        <h1><?php echo $page_name; ?></h1>
        <div class="pull-right">
            <?php include("rightbar/retailer_bar.php") ?>
        </div>
    </section>
    <?php if ($_REQUEST['err'] != '') { ?>
        <div class="col-lg-12">
            <div id="message-red" class="alert alert-danger alert-dismissable text-center"
                 style="width: 50%;margin: 20px auto;">
                Error. <?php echo "You have exceeded the maximum limit of active users"; ?>
            </div>
        </div>
    <?php } ?>

    <!--  start message-red -->

    <?php if ($err != '') { ?>
        <div class="col-lg-12">
            <div id="message-red" class="alert alert-danger alert-dismissable text-center"
                 style="width: 50%;margin: 20px auto;">
                Error. <?php echo $err; ?>
            </div>
        </div>
    <?php } ?>

    <!--  end message-red -->

    <?php if ($sus != '' || $ret_sus != '' || $login_sus != '') { ?>
        <!--  start message-green -->
        <div class="col-lg-12">
            <div id="message-green" class="alert alert-success alert-dismissable text-center"
                 style="width: 50%;margin: 20px auto;">
                <?php echo $sus;
                echo $ret_sus;
                echo $login_sus; ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <!--  end message-green -->
    <?php } ?>
    <!--  Todo Start : sudhanshu 28 may 2024  add status filter -->
    <section class="content sts_filter">
        <div class="inner-contenr">
            <form name="report" id="report" action="#" method="post">
                <div class="row">

                    <div class="col-sm-4">
                        <label>Status</label>
                        <select name="status" id="sal" class="form-control" >
                            <option value="all">All</option>
                            <option value="A" <?php if($_SESSION['retStatus'] == 'A'){ ?> selected <?php } ?>>Active</option>
                            <option value="I" <?php if($_SESSION['retStatus'] == 'I'){ ?> selected <?php } ?>>Inactive</option>

                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label>&nbsp;</label>
                        <div class="flex" style="text-align: center">
                            <input name="showMaster" type="hidden" value="yes"/>
                            <input name="submit" class="btn btn-success" type="submit" id="submit"
                                   value="View Details"/>
                            <input type="button" value="Reset!" class="btn btn-danger"
                                   onclick="location.href='retailer.php?reset=yes';"/>


                        </div>
                    </div>

                </div>


            </form>



        </div>
    </section>
    <!--  Todo End : sudhanshu 28 may 2024  add status filter -->
    <section class="content" id="content">
        <!-- start id-form -->
        <?php
        if (isset($_REQUEST['add']) || $ret_name_err != '' || ($_POST) && $_POST['submit'] == 'Save & Add Next Retailer' || $_REQUEST['id'] != '' || $_SESSION['ret_err'] != '') {
            $pageAccess = 1;
            $check = $_objArrayList->checkAccess($pageAccess, 'add_retailer.php');
            if ($check == false) {
                header('Location:' . basename($_SERVER['PHP_SELF']));
            } else {
                include("retailer/add_retailer.php");
            }
        } else
            if ($ret_add_sus != '' || $login_err != '') {
                include("retailer/login_retailer.php");
            }
//            else
//                if (isset ($_GET['skip']) || $login_sus != '') {
//                    include("retailer/map_retailer.php");
//                }
            else
                if (isset ($_GET['import']) || $ret_err != '') {
                    $pageAccess = 1;
                    $check = $_objArrayList->checkAccess($pageAccess, 'import_retailer.php');
                    if ($check == false) {
                        header('Location:' . basename($_SERVER['PHP_SELF']));
                    } else {
                        include("retailer/import_retailer.php");
                    }
                } elseif (isset ($_GET['import_update']) || $ret_err != '') {
//                    $pageAccess = 1;
//                    $check = $_objArrayList->checkAccess($pageAccess, 'import_update_retailer.php');
//
//
//                    if ($check == false) {
//                        header('Location:' . basename($_SERVER['PHP_SELF']));
//                    } else {
//                        include("retailer/import_update_retailer.php");
//                    }
                    //include("retailer/import_update_retailer.php");
                }elseif(isset ($_GET['import_address']) || $ret_err != '') {
                    header('Location:import_address.php');

                }elseif (isset ($_GET['import']) || $cat_err != '') {
                    include("retailer/import_retailer.php");
                }else {
                    include("retailer/view_retailer.php");
                    unset($_SESSION['ret_err'], $_SESSION['retId'], $_SESSION['ret_login'], $_SESSION['update']);
                }
        ?>
        <!--end id-form-->
    </section>
</aside>
<?php include("footer.php"); ?>
</body>
</html>