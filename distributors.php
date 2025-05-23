<?php
include("includes/config.inc.php");
include("includes/function.php");
$page_name = $AliaseUsers['distributor'] . " List";
$_objAdmin = new Admin();
$_objItem = new Item();
$objArrayList = new ArrayList();
// Get country phone no length
//Todo Start Sudhanshu 28 may 2024 : add status filtr
if (isset($_POST['showMaster']) && $_POST['showMaster'] == 'yes') {

    if ($_POST['status'] != "all") {
        $_SESSION['disStatus'] = $_POST['status'];
        //echo "Salesman id=".$_SESSION['SalOrderList'];die;
    }else{
        unset($_SESSION['disStatus']);
    }
    header("Location: distributors.php");
}

if (isset($_REQUEST['reset']) && $_REQUEST['reset'] == 'yes') {
    unset($_SESSION['disStatus']);
    header("Location: distributors.php");
}
//Todo End Sudhanshu 28 may 2024 : add status filtr
//Todo Start  Sudhanshu 11 june 2024 : reset error session on back button
if (isset($_REQUEST['resetback']) && $_REQUEST['resetback'] == 'yes') {
    unset($_SESSION['dis_err']);
    header("Location: distributors.php");
}
//Todo Start  Sudhanshu 11 june 2024 : reset error session on back button
$getCountryId = $_objAdmin->getCountryPhoneNoLenght($_SESSION['accountId']);

if (isset($_REQUEST['show']) && $_REQUEST['show'] == "yes") {
    $_objAdmin->showDistributors();
    die;
}


include("distributor.inc.php");
include("import.inc.php");
include("header.inc.php");
?>
<!--<script type="text/javascript">
function checkall(el){
   var ip = document.getElementsByTagName('input'), i = ip.length - 1;
   for (i; i > -1; --i){
       if(ip[i].type && ip[i].type.toLowerCase() === 'checkbox'){
           ip[i].checked = el.checked;
       }
   }
}
</script>
<script type="text/javascript">
function showStateCity(str,id)
{
//alert(str);
//alert(id);
   $.ajax({
       'type': 'POST',
       'url': 'dropdown_city.php',
       'data': 's='+str+'&c='+id,
       'success' : function(mystring) {
           //alert(mystring);
       document.getElementById("outputcity").innerHTML = mystring;
       }
   });
}
</script>-->
<aside class="right-side">
    <section class="content-header">
        <h1><?php echo $page_name; ?></h1>
        <div class="pull-right">
            <?php include("rightbar/distributor_bar.php") ?>
        </div>
    </section>
    <?php if ($_REQUEST['err'] != '') { ?>
        <div id="message-red" class="alert alert-danger">
            Error. <?php echo "you have exceeded the maximum limit of active users"; ?>
        </div>
    <?php } ?>
    <!-- start id-form -->
    <!--  Todo Start : sudhanshu 28 may 2024  add status filter -->
    <section class="content sts_filter">
        <div class="inner-contenr">
            <form name="report" id="report" action="#" method="post">
                <div class="row">

                    <div class="col-sm-4">
                        <label>Status</label>
                        <select name="status" id="sal" class="form-control" >
                            <option value="all">All</option>
                            <option value="A" <?php if($_SESSION['disStatus'] == 'A'){ ?> selected <?php } ?>>Active</option>
                            <option value="I" <?php if($_SESSION['disStatus'] == 'I'){ ?> selected <?php } ?>>Inactive</option>

                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label>&nbsp;</label>
                        <div class="flex" style="text-align: center">
                            <input name="showMaster" type="hidden" value="yes"/>
                            <input name="submit" class="btn btn-success" type="submit" id="submit"
                                   value="View Details"/>
                            <input type="button" value="Reset!" class="btn btn-danger"
                                   onclick="location.href='distributors.php?reset=yes';"/>


                        </div>
                    </div>

                </div>


            </form>



        </div>
    </section>
    <!--  Todo End : sudhanshu 28 may 2024  add status filter -->
    <section class="content" id="content">
        <?php
        if (isset($_REQUEST['add']) || $dis_name_err != '' || ($_POST) && $_POST['submit'] == 'Save & Add Next Distributor' || $_REQUEST['id'] != '' || $_SESSION['dis_err'] != '') {
            $pageAccess = 1;
            $check = $_objArrayList->checkAccess($pageAccess, 'add_distributors.php');
            if ($check == false) {
                header('Location:' . basename($_SERVER['PHP_SELF']));
            } else {
                include("distributors/add_distributors.php");
            }
        } else
            if ($dis_add_sus != '' || $login_err != '') {
                include("distributors/login_distributors.php");
            }
//        else if (isset ($_GET['skip']) || $login_sus != '') {
//                include("distributors/map_distributors.php");
//            }
            else
                if (isset ($_GET['import']) || $dis_err != '') {
                    //$pageAccess=2;
                    $check = $_objArrayList->checkAccess($pageAccess, 'import_distributor.php');
                    if ($check == false) {
                        header('Location:' . basename($_SERVER['PHP_SELF']));
                    } else {
                        include("distributors/import_distributor.php");
                    }
                } elseif (isset ($_GET['import_update']) || $dis_err != '') {
                    header('Location:import_update_distributor.php');
                }elseif(isset ($_GET['import_address']) || $dis_err != ''){
                    header('Location:import_distributor_address.php');
                }elseif (isset ($_GET['import']) || $cat_err != '') {
                    include("distributors/import_distributor.php");
                } else {
                    include("distributors/view_distributors.php");
                    unset($_SESSION['dis_err'], $_SESSION['disId'], $_SESSION['dis_login'], $_SESSION['update']);
                }
        ?>
        <!-- end id-form  -->
    </section>
</aside>
<?php include("footer.php"); ?>
</body>
</html>