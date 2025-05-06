<?php
include("includes/config.inc.php");
include("includes/function.php");
$_objAdmin = new Admin();
$objArrayList = new ArrayList();
// geeta code
include("import.inc.php");
if(isset($_REQUEST['id']) &&  $_REQUEST['id'] != ""){
 $_SESSION['schmeid']=$_REQUEST['id']; 
}
 
// geeta end code
if (isset($_POST['add']) && $_POST['add'] == 'yes') {
    if($_REQUEST['id'] != ""){
		$discountId = $_REQUEST['id']; 
		//$schemeName = mysql_escape_string($_objAdmin->validateForm('/[^A-Za-z0-9" "]/', trim($_POST['dis_desc'])));
		$existsch 	= $_objAdmin->checkUniqueScheme($discountId,'',$_REQUEST['party_type']);
       
		if(!$existsch){ 
			$id = $_objAdmin->updateDiscount($_REQUEST['id']);
           
			if ($_POST['item_list'] != '') {
				$_objAdmin->mysql_query("delete from table_discount_item where discount_id='" . $_REQUEST['id'] . "'");
				$id = $_objAdmin->addDiscountCombo($_REQUEST['id']);
			}
			if ($_POST['party_type'] == 2) {
				$_objAdmin->mysql_query("delete from table_discount_party where discount_id='" . $_REQUEST['id'] . "'");
				$id = $_objAdmin->updateDiscountState($_REQUEST['id']);
			}
			if ($_POST['party_type'] == 3) {
				$_objAdmin->mysql_query("delete from table_discount_party where discount_id='" . $_REQUEST['id'] . "'");
				$id = $_objAdmin->updateDiscountCity($_REQUEST['id']);
			}
			if ($_POST['party_type'] == 4) {
                $retReccount = $_objAdmin->_getSelectList2('table_discount_party as p left join table_retailer as r on r.retailer_id=p.retailer_id', "r.retailer_name", '', " p.discount_id='" . $_REQUEST['id'] . "'");
                  if(count($retReccount)>0){                   
				$_objAdmin->mysql_query("delete from table_discount_party where discount_id='" . $_REQUEST['id'] . "'");
                  }
				$id = $_objAdmin->updateDiscountRetailer($_REQUEST['id']);
                
			}
			header("Location: editdiscount.php?id=" . $_REQUEST['id'] . "&sus=sus");
		}else{
			$existErr = "Unable to update the scheme, as another same scheme is already exist in active mode.";
		}
    }
}
if ($_REQUEST['sus'] == 'sus') {
    $sus = "Scheme has been updated successfully.";
}
if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
    $auRec = $_objAdmin->_getSelectList('table_discount as d left join table_discount_detail as dd on d.discount_id=dd.discount_id left join table_discount_item as dt on dt.discount_id=d.discount_id left join table_category as c on dt.category_id=c.category_id left join table_item as t on t.item_id=dt.item_id', "d.discount_id,d.discount,d.is_open,d.is_dis_discount,d.mode,d.item_type,d.party_type,d.start_date,d.end_date,d.status,dd.discount_desc,dd.discount_type,dd.foc_id,dd.minimum_quantity,dd.discount_percentage,dd.discount_amount,dd.minimum_amount,c.category_name,t.item_name,dt.item_id", '', " d.discount_id=" . $_REQUEST['id']);
    if (count($auRec) <= 0) header("Location: discount.php");
}
/***************************** Update For New Scheme (Gaurav) ********************************/
if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
    $stateArrStr = NULL;
    $cityArrStr = NULL;
    $retailerArr = array();
    $retailerMarArr = array();
    /* Retrive Scheme Details from Mapping table LIKE state_id, city_id */
    $auRecMap = $_objAdmin->_getSelectList2('table_discount_distributor_mapping', "*", '', " discount_id=" . $_REQUEST['id']);
    $classArr = array_filter(explode(',', $auRecMap[0]->relationship_id));
    $stateArr = array_filter(explode(',', $auRecMap[0]->state_id));
    $cityArr = array_filter(explode(',', $auRecMap[0]->city_id));
    $distributors = array_filter(explode(',', $auRecMap[0]->distributor_id));
    /* Retrive Distributor Detail from distributor table LIKE distributor Id */
    if (isset($distributors) && sizeof($distributors) > 0) {
        /* Get stateID from Mapping table if it's Null take stateID from Distributor Table */
        if (count($stateArr) > 0) {
            $stateArrStr = implode(',', $stateArr);
            //print_r($stateArr);
            //print_r($stateArrStr);
        } else {
            $stateArr = array();
            $auRecstate = $_objAdmin->_getSelectList('table_distributors', "Distinct(state)", '', " distributor_id IN (" . $auRecMap[0]->distributor_id . ")");
            foreach ($auRecstate as $key => $value) {
                $stateArr[] = $auRecstate[$key]->state;
            }
            $stateArrStr = implode(',', $stateArr);
            //print_r($stateArr);
            //print_r($stateArrStr);
        }
        // End of this Code
        /* Get CityID from Mapping table if it's Null take CityID from of Distributor Table */
        if (!empty($cityArr) && count($cityArr) > 0) {
            $cityArrStr = implode(',', $cityArr);
            //print_r($cityArr);
            //print_r($cityArrStr);
        } else {
            $cityArr = array();
            $auReccity = $_objAdmin->_getSelectList('table_distributors', "Distinct(city)", '', " distributor_id IN (" . $auRecMap[0]->distributor_id . ") AND city!=''");
            foreach ($auReccity as $key => $value) {
                $cityArr[] = $auReccity[$key]->city;
            }
            $cityArrStr = implode(',', $cityArr);
            //print_r($cityArr);
            //print_r($cityArrStr);
        }
        // End of this function
        /* Retailer Location */
        $auRecmarkets = $_objAdmin->_getSelectList('table_distributors', "distributor_id,distributor_name, city, state", '', " distributor_id IN (" . $auRecMap[0]->distributor_id . ") and city!=''");
        foreach ($auRecmarkets as $key => $value) {
            $retailerMarArr[] = $auRecmarkets[$key]->distributor_id;
        }
        //print_r($retailerMarArr);
        // End of this function
    } else {
        $stateArr = array();
        $cityArr = array();
    }
}
/***************************** End Update For New Scheme ********************************/
?>
<?php include("header.inc.php");
$pageAccess = 1;
$check = $objArrayList->checkAccess($pageAccess, basename($_SERVER['PHP_SELF']));
if ($check == false) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
<script src="javascripts/jquery-ui.js"></script>
<script src="javascripts/discount.js"></script>
<script src="javascripts/addrow.js"></script>
<!--  end content-outer -->
<div class="clear">&nbsp;</div>
<script>
    $(function () {
        $("#start_date").datepicker({
            dateFormat: "d M yy",
            defaultDate: "w",
            changeMonth: true,
            numberOfMonths: 1,
            minDate : new Date(("<?php echo date('Y, m, d',strtotime($auRec[0]->start_date)) ?>")),
            onSelect: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            dateFormat: "d M yy",
            defaultDate: "-w",
            changeMonth: true,
            numberOfMonths: 1,
            minDate : new Date(("<?php echo date('Y, m, d',strtotime($auRec[0]->start_date)) ?>")),
            onSelect: function (selectedDate) {
                $("#start_date").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>
<style>
    .ui-button {
        margin-left: -1px;
    }
    .ui-button-icon-only .ui-button-text {
        padding: 0.35em;
    }
    .ui-autocomplete-input {
        margin: 0;
        padding: 0.4em 0 0.4em 0.45em;
    }
</style>
<?php include("discount_list.php") ?>
<script type="text/javascript">
    $(document).ready(function () {
        var v = $("#frmPre").validate({
            rules: {
                fileToUpload: {
                    required: true,
                    accept: "csv"
                }
            },
            submitHandler: function (form) {
                document.frmPre.submit();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#loader').show();
        $('#loader').html('<div id="loader" align="center"><img src="images/ajax-loader.gif" /><br/>Please Wait...</div>');
        $.ajax({
            'type': 'POST',
            'url': 'discount_date.php',
            'data': '',
            'success': function (mystring) {
                //alert(mystring);
                //document.getElementById("div1").innerHTML = mystring;
                $('#div1').html(mystring);
                $('#loader').hide();
            }
        });
    });
</script>
<style type="text/css">
    .optlegend {
        background: none repeat scroll 0 0 #6E6E6E;
        border-radius: 0.2em 0.2em 0.2em 0.2em;
        color: #FFFFFF;
        font-family: arial;
        font-size: 17px;
        font-weight: normal;
        padding: 3px;
    }
</style>
<style>
    form:not(.form-horizontal) .inner-container .form-group {
        min-height: initial;
        margin-bottom: 15px;
    }
    .input_select .inner {
        clear: none;
        height: 170px;
        margin: 0;
        overflow-y: scroll;
        padding: 0;
    }
    .input_select > label {
        font-size: 13px;
        border-bottom: 1px dashed #bbb;
        margin-bottom: 5px;
        text-transform: uppercase
    }
    .input_select label {
        margin: 2px 0;
        padding: 2px 0;
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .input_select label input {
        margin: 0 6px 0 0
    }
</style>
<aside class="right-side">
     <!---- geeta code ---->
<div class="pull-right" style="margin-bottom:20px">
    <a href="export.inc.php?export_all_schemeretailer" class="btn btn-danger">Export Retailers</a>
        </div>
         <!---- end geeta code ---->
    <section class="content-header">
        <h1>Edit Scheme</h1>
        
    </section>
    <section id="content" class="content">
   
        <!--  start message-red -->
		<?php if ($existErr != '') { ?>
            <div id="message-red" class="alert alert-danger" style="margin-bottom: 15px">
                <?php echo $existErr; ?>
            </div>
        <?php } ?>
        <?php if ($err != '') { ?>
            <div id="message-red" class="alert alert-danger" style="margin-bottom: 15px">
                <?php echo $err; ?>
            </div>
        <?php } ?>
        <!--  end message-red -->
        <?php if ($sus != '') { ?>
            <!--  start message-green -->
            <div id="message-green" class="alert alert-success" style="margin-bottom: 15px">
                <?php echo $sus; ?>
            </div>
        <?php } ?>
        <!--  end message-green -->
        <!-- start id-form -->

        <form name="frmPre" id="frmPre" method="post" action="editdiscount.php" enctype="multipart/form-data">
            <!---- geeta code ---->
        <input type="hidden" name="isfileupload" id="isfileupload" value="0">
        <!---- end geeta code ---->
            <div class="inner-container clearfix">
                <div class="row">
                    <div class="form-group clearfix">
                        <label class="col-sm-2">Scheme Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="dis_desc" id="dis_desc" class="required form-control"
                                   value="<?php echo $auRec[0]->discount_desc; ?>" maxlength="255"/>
                        </div>
                    </div>

                    <!-- <div class="form-group clearfix">

                        <label class="col-sm-2">Scheme</label>
                        <div class="col-sm-10">
                            <?php if ($auRec[0]->discount == 1) { ?>
                                <label class="radio-inline"><input type="radio" name="discount" value="1"
                                                                   checked="checked"> Exclusive</label>
                            <?php } else { ?>
                                <label class="radio-inline"><input type="radio" name="discount" value="2"
                                                                   checked="checked"> Non Exclusive</label>
                            <?php } ?>
                        </div>

                    </div> -->
                    <input type="hidden" name="discount" value="1" >

                    <div class="form-group clearfix">
                        <label class="col-sm-2">Distributor Scheme</label>
                        <div class="col-sm-10">
                            <?php if ($auRec[0]->is_dis_discount == 1) { ?>
                                <label class="radio-inline"><input type="radio" name="dis_discount" value="1"
                                                                   checked="checked"> Yes</label>
                            <?php } else { ?>
                                <label class="radio-inline"><input type="radio" name="dis_discount" value="2"
                                                                   checked="checked"> No</label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <label class="col-sm-2">Scheme Mode</label>
                        <div class="col-sm-10">
                            <select name="" id="" class="form-control">
                                <option value="<?php echo $auRec[0]->mode; ?>"><?php if ($auRec[0]->mode == 1) {
                                        echo "Quantity";
                                    } else {
                                        echo "Amount";
                                    } ?></option>
                            </select>
                        </div>
                    </div>
                    <?php if ($auRec[0]->mode == 1) { ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Item Type</label>
                            <div class="col-sm-10">
                                <select name="" id="" class="form-control">
                                    <option value="<?php echo $auRec[0]->item_type; ?>">
                                        <?php if ($auRec[0]->item_type == 1) {
                                            echo "All";
                                        }
                                        if ($auRec[0]->item_type == 2) {
                                            echo "Category";
                                        }
                                        if ($auRec[0]->item_type == 3) {
                                            echo "Items";
                                        } ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <?php if ($auRec[0]->item_type == 2) { ?>
                            <div class="form-group clearfix">
                                <label class="col-sm-2">Select Category</label>
                                <div class="col-sm-10">
                                    <select name="" id="" class="form-control">
                                        <option value="<?php echo $auRec[0]->category_name; ?>"><?php echo $auRec[0]->category_name; ?></option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($auRec[0]->item_type == 3) { ?>
                            <div class="form-group clearfix">
                                <label class="col-sm-2">Select Item</label>
                                <div class="col-sm-10">
                                    <select name="" id="" class="form-control">
                                        <option value="<?php echo $auRec[0]->item_name; ?>"><?php echo $auRec[0]->item_name; ?></option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Minimum Quantity</label>
                            <div class="col-sm-10">
                                <input type="text" name="min_qty" id="min_qty" class="number form-control"
                                       maxlength="10" value="<?php echo $auRec[0]->minimum_quantity; ?>" readonly/>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($auRec[0]->mode == 2) { ?>
                        <?php if ($auRec[0]->item_id != '') { ?>
                            <div class="form-group clearfix">
                                <label class="col-sm-2"></label>
                                <div class="col-sm-10">
                                    <label class="radio-inline"><input type="radio" name="combo" value="2" id="combo"
                                                                       checked="checked"> Item Combo</label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-2">Item Code</label>
                                <div class="col-sm-10">
                                    <input readonly id="item_list" class="ui-autocomplete-input form-control"
                                           autocomplete="off" role="textbox" aria-autocomplete="list"
                                           aria-haspopup="true" name="item_list" placeholder="Search Item Code"
                                           value="<?php $itemRec = $_objAdmin->_getSelectList2('table_discount_item as d left join table_item as i on d.item_id=i.item_id', "i.item_code", '', " d.discount_id='" . $auRec[0]->discount_id . "'");
                                           for ($i = 0; $i < count($itemRec); $i++) {
                                               echo $itemRec[$i]->item_code . ",";
                                           } ?> ">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group clearfix">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-10">
                                    <label class="radio-inline"><input type="radio" name="combo" value="1" id="combo"
                                                                       checked="checked"> Invoice</label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-2">Open Discount</label>
                                <div class="col-sm-10">
                                    <?php if ($auRec[0]->is_open == 1) { ?>
                                        <label class="radio-inline"><input type="radio" name="open_discount" value="1"
                                                                           id="open_discount" checked="checked">
                                            Yes</label>
                                    <?php } else { ?>
                                        <label class="radio-inline"><input type="radio" name="open_discount" value="2"
                                                                           id="open_discount" checked="checked">
                                            No</label>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Minimum Amount</label>
                            <div class="col-sm-10">
                                <input type="text" name="min_amt" id="min_amt" class="form-control number"
                                       maxlength="10" value="<?php echo $auRec[0]->minimum_amount; ?>" readonly/>
                            </div>
                        </div>
                    <?php }
                    if ($auRec[0]->is_dis_discount == 2) { ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Party Type</label>
                            <div class="col-sm-10">
                                <select name="party_type" id="party_type" class="form-control">
                                    <option value="<?php echo $auRec[0]->party_type; ?>">
                                        <?php if ($auRec[0]->party_type == 1) {
                                            echo "All";
                                        }
                                        if ($auRec[0]->party_type == 2) {
                                            echo "State";
                                        }
                                        if ($auRec[0]->party_type == 3) {
                                            echo "City";
                                        }
                                        if ($auRec[0]->party_type == 4) {
                                            echo "Retailer";
                                        } ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <!---------- Add New Party Type Gaurav (25th June 2015) ---------->
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Party Type</label>
                            <div class="col-sm-10">
                                <div class="col-sm-3 input_select">
                                    <label>Select State</label>
                                    <div id="StateDiv" class="inner">
                                        <?php
                                        $stateID = array();
                                        $getListOfState = $_objAdmin->_getSelectList('table_distributors', "DISTINCT(state)", '', '');
                                        foreach ($getListOfState as $value) {
                                            $stateID[] = $value->state;
                                        }
                                        $stateIdList = implode(',', $stateID);
                                        $data = $_objAdmin->_getSelectList2('state', "state_id, state_name", '', " state_id IN (" . $stateIdList . ") and state_name!=''");
                                        foreach ($data as $value):?>
                                            <div class="newcheck">
                                                <label>
                                                    <input onclick="return false" type="checkbox" name="state[]"
                                                           value="<?php echo $value->state_id; ?>" <?php if (in_array($value->state_id, $stateArr)) { ?> checked="checked"<?php } ?> />
                                                    <?php echo $value->state_name; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if (isset($_GET['id'])) { ?>
                                    <!--<input type="text" name="route_id" id="rID" value="<?php //echo $_GET['id'];?>" />-->
                                    <div class="col-sm-3 input_select">
                                        <label>Select City</label>
                                        <div id="CityDiv" class="inner">
                                            <div id="11CityDiv"></div>
                                            <?php if (!empty($stateArr)) {
                                                $cityID = array();
                                                $getListOfCity = $_objAdmin->_getSelectList('table_distributors', "DISTINCT(city)", '', '');
                                                foreach ($getListOfCity as $value) {
                                                    if (isset($value->city) && !empty($value->city)) {
                                                        $cityID[] = $value->city;
                                                    }
                                                }
                                                $cityIdList = implode(',', $cityID);
                                                foreach ($stateArr as $Svalue):
                                                    $data = $_objAdmin->_getSelectList2('city LEFT JOIN state ON state.state_id = city.state_id', "city_id, state.state_id, city_name, state_name", '', " city.state_id IN (" . $Svalue . ") and city.city_id IN (" . $cityIdList . ")");
                                                    if (!empty($data)) {
                                                        ?>
                                                        <div id="state<?php echo $data['0']->state_id; ?>">
                                                            <label class="optlegend"><em><strong><?php echo $data['0']->state_name; ?></strong></em></label>
                                                            <?php foreach ($data as $value): ?>
                                                                <div class="citycheck">
                                                                    <label>
                                                                        <input onclick="return false" type="checkbox"
                                                                               name="city[]"
                                                                               value="<?php echo $value->city_id; ?>" <?php if (!empty($cityArr) && in_array($value->city_id, $cityArr)) { ?> checked="checked"<?php } ?>
                                                                               alt="<?php echo $data['0']->state_id; ?>"/>
                                                                        <?php echo $value->city_name; ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    <?php } ?>
                                                <?php endforeach; ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 input_select">
                                        <label><?php echo $AliaseUsers['distributor']; ?> Class</label>
                                        <div id="ClassDiv" class="inner">
                                            <?php
                                            $data = $_objAdmin->_getSelectList('table_relationship', "relationship_id, relationship_code", '', " relationship_code!='' and status='A'");
                                            foreach ($data as $value):?>
                                                <div class="newcheck">
                                                    <label>
                                                        <input onclick="return false" type="checkbox" name="class[]"
                                                               value="<?php echo $value->relationship_id; ?>" <?php if (in_array($value->relationship_id, $classArr)) { ?> checked="checked"<?php } ?> />
                                                        <?php echo $value->relationship_code; ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 input_select">
                                        <label>Select <?php echo $AliaseUsers['distributor']; ?></label>
                                        <div id="DistributorDiv" class="inner">
                                            <div id="11DistributorDiv"></div>
                                            <?php if (!empty($cityArr)) {
                                                foreach ($cityArr as $Cvalue):
                                                    $data = $_objAdmin->_getSelectList('table_distributors as d left join state as s on s.state_id=d.state left join city as c on d.city=c.city_id left join table_relationship as tr on tr.relationship_id=d.relationship_id', "d.distributor_name,d.distributor_id, c.city_name, c.city_id, s.state_id,d.city,tr.relationship_code", '', " d.city IN (" . $Cvalue . ") AND d.state IN(" . $stateArrStr . ") GROUP BY d.distributor_id");
                                                    //$data = $_objAdmin->_getSelectList('table_market',"location, city_name, city, state_id",'','  city IN ('.$Cvalue.') AND state_id IN ('.$stateArrStr.')');
                                                    $str = preg_replace("/[,.')( ]+/", '', $data['0']->city_name);
                                                    $str = str_replace('/', '', $str);
                                                    if (!empty($data)) {
                                                        ?>
                                                        <div class="mstate<?php echo $data['0']->state_id; ?>">
                                                            <div id="city<?php echo $data['0']->city; ?>">
                                                                <script type="text/javascript">
                                                                    $(document).ready(function () {
                                                                        checkAllSelectedCheckBOX('<?php echo $str?><?php echo $data['0']->state_id;?>', 'distributorcheck', 'SelectAllcity<?php echo $data['0']->city;?><?php echo $data['0']->state_id;?>');
                                                                    });
                                                                </script>
                                                                <label class="optlegend">
                                                                    <input onclick="return false" type="checkbox"
                                                                           class="selectAll" name="select"
                                                                           id="SelectAllcity<?php echo $data['0']->city; ?><?php echo $data['0']->state_id; ?>"
                                                                           value="<?php echo $str ?><?php echo $data['0']->state_id; ?>"
                                                                           alt="<?php echo $data['0']->state_id; ?>"
                                                                           title="<?php echo $data['0']->city; ?>"/>
                                                                    <?php echo $data['0']->city_name; ?>
                                                                </label>
                                                                <div id="<?php echo $str ?><?php echo $data['0']->state_id; ?>">
                                                                    <?php foreach ($data as $value): ?>
                                                                        <div class="distributorcheck">
                                                                            <label>
                                                                                <input onclick="return false"
                                                                                       type="checkbox"
                                                                                       name="distributor[]"
                                                                                       value="<?php echo $value->distributor_id; ?>"
                                                                                       onclick="loadretaildis(this.value, '<?php echo $str ?><?php echo $data['0']->state_id; ?>', <?php echo $data['0']->city; ?>,<?php echo $data['0']->state_id; ?>)" <?php if (!empty($retailerMarArr) && in_array($value->distributor_id, $retailerMarArr)) { ?> checked="checked"<?php } ?> />
                                                                                <?php echo ucwords($value->distributor_name) . "-" . ucwords($value->relationship_code); ?>
                                                                            </label>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php endforeach; ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-3 input_select">
                                        <label>Select City</label>
                                        <div id="CityDiv" class="inner">
                                            <div id="11CityDiv"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 input_select">
                                        <label>Select <?php echo $AliaseUsers['distributor']; ?></label>
                                        <div id="DistributorDiv" class="inner">
                                            <div id="11DistributorDiv"></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <!------   End  Add New Party Type ------>
                    <?php if ($auRec[0]->party_type == 2) { ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">State Name</label>
                            <div class="col-sm-10">
                                <input id="state_list" class="ui-autocomplete-input form-control" autocomplete="off"
                                       role="textbox" aria-autocomplete="list" aria-haspopup="true" name="state_list"
                                       placeholder="Search State Name"
                                       value="<?php $sateRec = $_objAdmin->_getSelectList2('table_discount_party as p left join state as s on s.state_id=p.state_id', "s.state_name", '', " p.discount_id='" . $auRec[0]->discount_id . "'");
                                       for ($i = 0; $i < count($sateRec); $i++) {
                                           echo $sateRec[$i]->state_name . ",";
                                       } ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($auRec[0]->party_type == 3) { ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">City Name</label>
                            <div class="col-sm-10">
                                <input id="city_list" class="ui-autocomplete-input form-control" autocomplete="off"
                                       role="textbox" aria-autocomplete="list" aria-haspopup="true" name="city_list"
                                       placeholder="Search City Name"
                                       value="<?php $cityRec = $_objAdmin->_getSelectList2('table_discount_party as p left join city as c on c.city_id=p.city_id', "c.city_name", '', " p.discount_id='" . $auRec[0]->discount_id . "'");
                                       for ($i = 0; $i < count($cityRec); $i++) {
                                           echo $cityRec[$i]->city_name . ",";
                                       } ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($auRec[0]->party_type == 4 && $auRec[0]->is_dis_discount == 2) { // Check for distributor scheme ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2"><?php echo $AliaseUsers['retailer']; ?> Name</label>
                            <div class="col-sm-10">
                                 <!---- geeta code ---->
                             <span id="showmsg" style="display:none;color:green">Imported Successfully</span>
                             <!---- end geeta code ---->
                                <input id="ret_list" class="ui-autocomplete-input form-control" required autocomplete="off"
                                       role="textbox" aria-autocomplete="list" aria-haspopup="true" name="ret_list"
                                       placeholder="Search <?php echo $AliaseUsers['retailer']; ?> Name"
                                       value="<?php $retRec = $_objAdmin->_getSelectList2('table_discount_party as p left join table_retailer as r on r.retailer_id=p.retailer_id', "r.retailer_name", '', " p.discount_id='" . $auRec[0]->discount_id . "'");
                                       for ($i = 0; $i < count($retRec); $i++) {
                                     //   echo $retRec[$i]->retailer_name ."(".$retRec[$i]->retailer_code. "),";
                                           echo $retRec[$i]->retailer_name . ",";
                                       }  ?>">
                            </div>
                            <!---- geeta code ---->
                            <p><strong> Customer Count : <?php  echo count($retRec);  ?></strong> &nbsp;&nbsp; <a href="view_uploaded_retailerscheme.php?id=<?php echo $_REQUEST['id']; ?>" target="_blank">View Detail</a></p>
                             
                        <?php  //include("retailer/import_retailerwise_scheme.php"); ?>
                        <!---- end geeta code ---->
                             <!---- geeta code ---->
                            <?php  //include("retailer/import_retailerwise_schemeform.php"); ?>
                             <!---- end geeta code ---->
                        </div>
                    <?php } ?>
                    <div class="form-group clearfix">
                        <label class="col-sm-2">Scheme Type</label>
                        <div class="col-sm-10">
                            <select name="" id="" class="form-control">
                                <option value="<?php echo $auRec[0]->discount_type; ?>">
                                    <?php
                                    if ($auRec[0]->discount_type == 1) {
                                        echo "Percentage";
                                    }
                                    if ($auRec[0]->discount_type == 2) {
                                        echo "Amount";
                                    }
                                    if ($auRec[0]->discount_type == 3) {
                                        echo "FOC";
                                    }
                                    ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <?php if ($auRec[0]->discount_type == 1) { ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Scheme Percentage</label>
                            <div class="col-sm-10">
                                <input type="text" name="dis_per" id="dis_per" class="form-control number"
                                       value="<?php echo $auRec[0]->discount_percentage; ?>" maxlength="2" readonly/>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($auRec[0]->discount_type == 2) { ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Scheme Amount</label>
                            <div class="col-sm-10">
                                <input type="text" name="dis_per" id="dis_per" class="form-control number"
                                       value="<?php echo $auRec[0]->discount_amount; ?>" readonly/>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($auRec[0]->discount_type == 3) { ?>
                        <div class="form-group clearfix">
                            <label class="col-sm-2">Free Item</label>
                            <div class="col-sm-10">
                                <table width="200" cellspacing="2" cellpadding="2">
                                    <tr bgcolor="#6E6E6E" style="color: #fff;font-weight: bold;">
                                        <td style="padding:10px;" width="175px"><span class="style1">Free Item</span>
                                        </td>
                                        <td style="padding:10px;"><span class="style1">Free Quantity </span></td>
                                    </tr>
                                    <?php
                                    $focRec = $_objAdmin->_getSelectList2('table_foc_detail as f left join table_item as i on f.free_item_id=i.item_id', "i.item_name,f.free_qty", '', " f.foc_id='" . $auRec[0]->foc_id . "'");
                                    for ($i = 0; $i < count($focRec); $i++) {
                                        ?>
                                        <tr>
                                            <td><input style="width: 150px; height: 20px;" type="text" name="" id=""
                                                       class="text" value="<?php echo $focRec[$i]->item_name; ?>"
                                                       readonly/></td>
                                            <td><input style="width: 90px; height: 20px;" type="text" name="" id=""
                                                       class="text" value="<?php echo $focRec[$i]->free_qty; ?>"
                                                       readonly/></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group clearfix col-sm-12">
                        <div class="row">
                            <label class="col-sm-2">Scheme Start Date</label>
                            <div class="col-sm-4">
                                <input type="text" name="start_date" id="start_date" class="form-control"
                                       value="<?php echo $_objAdmin->_changeDate($auRec[0]->start_date); ?>" readonly/>
                            </div>
                            <label class="col-sm-2">Scheme End Date</label>
                            <div class="col-sm-4">
                                <input type="text" id="to" name="to" class="date required form-control"
                                       value="<?php echo $_objAdmin->_changeDate($auRec[0]->end_date); ?>" readonly/>
                            </div>
                        </div>
                    </div>
                   <!-- <div class="form-group clearfix">
                        <label class="col-sm-2">Status</label>
                        <div class="col-sm-10">
                            <select name="status" id="status" class="form-control">
                                <option value="A" <?php //if ($auRec[0]->status == 'A') echo "selected"; ?> >Active
                                </option>
                                <option value="I" <?php //if ($auRec[0]->status == 'I') echo "selected"; ?> >Inactive
                                </option>
                            </select>
                        </div>
                    </div>-->
                </div>
            </div>

            <!----geeta code ----->
           <?php  unset($_SESSION['datalist']); unset($_SESSION['datalistcount']);
           // end geeta code
           ?>
            <div style="margin-top: 15px">
                <input name="account_id" type="hidden" value="<?php echo $_SESSION['accountId']; ?>"/>
                <input name="id" type="hidden" value="<?php echo $auRec[0]->discount_id; ?>"/>
                <input name="add" type="hidden" value="yes"/>
                <input type="reset" value="Reset!" class="btn btn-danger">
                <input type="button" value="Back" class="btn btn-default" onclick="location.href='discount.php';"/>
                <input name="submit" class="btn btn-success" type="submit" id="submit" value="Save"/>
            </div>
        </form>
        <!-- end id-form  -->
    </section>
</aside>
<!-- start footer -->
<?php include("footer.php") ?>
<!-- end footer -->
</body>
</html>