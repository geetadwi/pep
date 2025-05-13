<?php
include("includes/config.inc.php");
include("includes/function.php");
$page_name = "Tertiary Dashboard";
$_objAdmin = new Admin();

ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');

if (isset($_POST['submit']) && $_POST['submit'] == 'View Details') {

    include_once('set_session_from_filter.inc.php');
}

if (isset($_REQUEST['reset']) && $_REQUEST['reset'] == 'yes') {

    include_once('reset_filter.inc.php');
    header("Location: tertiary_report.php");

}
$_SESSION['SalsInCondilr'] = $salesman;
include("header.inc.php");
?>
<script src="javascripts/jquery-1.7.1.min.js" type="text/javascript"></script>
<!-- <script src="javascripts/highcharts.js"></script>
<script src="javascripts/exporting.js"></script>
<script src="graphs/charts.js"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .swal-footer {
        text-align: center !important;
    }

    .swal-text {
        font-size: 18px !important;
        text-align: center !important;
    }

    .swal-button {
        /*background-color : red;*/
        font-size: 15px !important;
    }

    .swal-icon {
        border-color: red !important;
    }

    .swal-icon--warning__body {
        background-color: red;
    }

    .swal-icon--warning__dot {
        background-color: red;
    }


    @media (min-width: 576px) {
        .form-group {
            margin-bottom: 1rem;
        }

        #divFilter{
            width:100%;
        }
    }



     /* .responsive-row {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  gap: 1rem;
  padding-bottom: 1rem;
}
.responsive-row .col {
  flex: 0 0 auto;
  width: 300px; 
} */


@media (max-width: 768px) {
  #card-col {
    flex: 1 1 50%; /* 2 per row */
  }
}

@media (max-width: 576px) {
  #card-col {
    flex: 1 1 100%; /* 1 per row */
  }
}
</style>

<style>
  .table-wrapper {
    max-height: 300px; 
    overflow-y: auto;
    min-height: 300px; 
  }

  .table thead th {
    position: sticky;
    top: 0;
    background-color:#adadad;
    z-index: 1;
 
  }

  .table th, .table td {
    text-align: center;
    vertical-align: center;
  }

  .line-graph{
    max-height: 300px;
    min-height: 300px; 
  }



</style>

<aside class="right-side">
    <section class="content-header">
        <h1><?php echo $page_name ?></h1>
    </section>

    <section class="content">
        <form id="filtrForm" method="post" action="">
            <div class="inner-container">
                <div class="row">
                    <!-- Dynamic Filters Options Listing here-->
                    <?php
                    $requireFilters = ["category", "product", "salesman", "salesman_designation", "salesman_manager", "salesman_state", "salesman_zone", "retailer", "retailer_state", "retailer_zone", "date_range", "month", "year"];

                    $fromDate = (($_SESSION['fil_from'] != '') ? $_objAdmin->_changeDate($_SESSION['fil_from']) : $_objAdmin->_changeDate(date('Y-m-d')));
                    $todate = (($_SESSION['fil_to'] != '') ? $_objAdmin->_changeDate($_SESSION['fil_to']) : $_objAdmin->_changeDate(date('Y-m-d')));

                    $filterArr = ["filterList" => ["category",  "month", "year"],
                        "filterOptions" =>
                            [
                                "category" => ["name" => "fil_category", "defaultSelection" => $_SESSION['fil_category'], "id" => "category", "class" => "form-control"],
                                "month" => ["name" => "fil_month", "defaultSelection" => @$_POST['fil_month'], "id" => "month", "class" => "form-control"],
                                "year" => ["name" => "fil_year", "defaultSelection" => @$_POST['fil_year'], "id" => "year", "class" => "form-control"],
                            ]
                    ];
                    //include_once('add_filter_form.php'); ?>
                    <div class="filter-container">
                        <?php include('terdashboard_filters.php'); ?>
                    </div>
                </div>

                <!--                <div class="col-lg-6">-->
                <div class="text-center">
                    <input id="sbmtForm" name="submit" type="submit" style="display: none;"
                           value="View Details"/>
                    <span class="btn btn-success" id="submtBtn">Submit</span>

                    <span class="btn btn-danger"
                          onclick="location.href = 'tertiary_report.php?reset=yes';"><i
                                class="fa fa-refresh" aria-hidden="true"></i> Reset</span>

                  
                </div>
            </div>
        </form>
                </section>

        <?php


        // ---------------start dynamic filter condition-----------
        $salesmanCnd = '';
        //        $salCond = '';

        if (isset($_SESSION['fil_salesman']) && $_SESSION['fil_salesman'] > 0) {
            $salesmanCnd = ' AND tto.salesman_id = "' . $_SESSION['fil_salesman'] . '"';
        } else if (isset($_SESSION['fil_salesman_manager']) && ($_SESSION['fil_salesman_manager'] > 0)) {
            $salesmanManagerId = $_SESSION['fil_salesman_manager'];
            $account_id = $_SESSION['accountId'];
            $res = $_objAdmin->_getSelectList2('table_salesman_hierarchy_relationship AS SHR 
    LEFT JOIN table_salesman_hierarchy AS SH ON SH.hierarchy_id = SHR.hierarchy_id
    LEFT JOIN table_salesman AS s ON s.salesman_id = SHR.salesman_id', 's.salesman_id,SH.hierarchy_id,SH.sort_order', '', " SH.account_id=" . $account_id . " AND SHR.salesman_id = $salesmanManagerId ORDER BY SH.sort_order ASC ");
            $_objArrayList = new ArrayList();
            if (is_array($res) && (count($res) > 0)) {
                $sortOrder = $res[0]->sort_order;
                $getBottomUsersIdArr = $_objArrayList->getSalesmansBottomUsers(array($salesmanManagerId), $sortOrder,
                    $account_id);

                if (is_array($getBottomUsersIdArr) && (count($getBottomUsersIdArr) > 0)) {
                    $bottomUsersIds = implode(',', $getBottomUsersIdArr);
                }

                $salesmanCnd = " AND tto.salesman_id IN($bottomUsersIds) ";
            }
        } else if (isset($_SESSION['fil_salesman_designation']) && ($_SESSION['fil_salesman_designation'] > 0)) {
            $account_id = $_SESSION['accountId'];
            $getDesignationWiseBottomUsersIdArr = $_objArrayList->getDesignationWiseBottomUsers($_SESSION['fil_salesman_designation'], $account_id);

            if (is_array($getDesignationWiseBottomUsersIdArr) && (count($getDesignationWiseBottomUsersIdArr) > 0)) {
                $bottomUsersIds = implode(',', $getDesignationWiseBottomUsersIdArr);
                $salesmanCnd = " AND tto.salesman_id IN($bottomUsersIds) ";
            }
        } else {
            $salesmanCnd .= $salesman;
        }
        if (isset($_SESSION['fil_salesman_zone']) && $_SESSION['fil_salesman_zone'] > 0) {
            $salesmanCnd .= ' AND zsm1.zone_id = "' . $_SESSION['fil_salesman_zone'] . '"';
        }
        if (isset($_SESSION['fil_salesman_state']) && $_SESSION['fil_salesman_state'] > 0) {
            $salesmanCnd .= ' AND st2.state_id= "' . $_SESSION['fil_salesman_state'] . '"';
        }
        if (isset($_SESSION['fil_item']) && !empty($_SESSION['fil_item'])) {
            $salesmanCnd .= " AND stk.item_id = '" . $_SESSION['fil_item'] . "' ";
        }
        if (isset($_SESSION['fil_category']) && $_SESSION['fil_category'] > 0) {
            $salesmanCnd .= ' AND ti.category_id = "' . $_SESSION['fil_category'] . '"';
        }
        if (isset($_SESSION['fil_retailer_state']) && $_SESSION['fil_retailer_state'] > 0) {
            $salesmanCnd .= ' AND r.state= "' . $_SESSION['fil_retailer_state'] . '"';
        }
        if (isset($_SESSION['fil_retailer_zone']) && $_SESSION['fil_retailer_zone'] > 0) {
            $salesmanCnd .= ' AND zsm.zone_id = "' . $_SESSION['fil_retailer_zone'] . '"';
        }
        // Date range , month and year
        if (!isset($_SESSION['fil_from']) && empty($_SESSION['fil_from'])) {
            $_SESSION['fil_from'] = date('d M Y');
        }

        if (!isset($_SESSION['fil_to']) && empty($_SESSION['fil_to'])) {
            $_SESSION['fil_to'] = date('d M Y');
        }
        if (isset($_SESSION['fil_month']) && !empty($_SESSION['fil_month']) && isset($_SESSION['fil_year']) && !empty($_SESSION['fil_year'])) {
            $_SESSION['fil_from'] = date('Y-m-d', strtotime($_SESSION['fil_year'] . '-' . $_SESSION['fil_month'] . '-01'));
            $_SESSION['fil_to'] = date('Y-m-t', strtotime($_SESSION['fil_year'] . '-' . $_SESSION['fil_month'] . '-01'));
        }

        //echo "<pre>";print_r($_SESSION);die;
        // -------------End dynamic filter condition------------


        //get transactions
      

        ?>

<?php  
$account_id = $_SESSION['accountId'];
 $days = date('t');

 $fromDate = date('Y') .'-'.date('m') .'-01';
 
 $toDate = date('Y-m-t');

 if (isset($_SESSION['fil_month']) && isset($_SESSION['fil_year']) && $_SESSION['fil_month'] != "" && $_SESSION['fil_year'] != "") {

$days = date('t', strtotime($_SESSION['fil_year'] . '-' . $_SESSION['fil_month']));

$fromDate = date('Y-m-d', strtotime($_SESSION['fil_year'] . '-' . $_SESSION['fil_month']));

$toDate = date('Y-m-t', strtotime($_SESSION['fil_year'] . '-' . $_SESSION['fil_month']));

}
$date1 = strtotime($fromDate); 
$date2 = strtotime($toDate);

$date_difference = $date2 - $date1;
$noofday =  round( $date_difference / (60 * 60 * 24) );

$try_odrcounts = $_objAdmin->_getSelectList('table_tertiary_order as tto
LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 

LEFT JOIN state as st2 on st2.state_id = s.state 
LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,st2.state_name as salesman_state,
z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
   "' AND '" . $toDate . "')  $salesman $salesmanCnd group by tto.salesman_id ORDER BY sum(ttod.acc_total) DESC limit 20");
   $totalattendence=0;
   $totalsoldqty=0;
   $totalsoldamt=0;
   if (!empty($try_odrcounts)) {

    for ($i = 0; $i < count($try_odrcounts); $i++) {
       
            $salArrcount = $_objAdmin->_getSelectList2("table_activity_salesman_attendance as a1 
            left join table_tags as tg on tg.tag_id = a1.attendance_type
            LEFT JOIN table_salesman as s ON s.salesman_id = a1.salesman_id", 'COUNT(*) as TotalWorkDays', '', " s.account_id = $account_id AND a1.activity_type = 11 AND (a1.activity_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "') AND a1.start_time != '00:00:00'  AND s.salesman_id='".$try_odrcounts[$i]->salesman_id."'
            GROUP BY a1.salesman_id
            ORDER BY a1.salesman_id ASC, a1.activity_date ASC, a1.start_time ASC");
            $totalattendence +=$salArrcount[0]->TotalWorkDays;
            $totalsoldqty +=$try_odrcounts[$i]->order_quantity;
            $totalsoldamt +=$try_odrcounts[$i]->total_invoice_amount;

    }

}
        ?>

<section class="content" style="margin-top:15px;">
    <!-- <div class="inner-container"> -->
            <div class="row">


            

                <div class="col-sm-2" style="width:20%" id="card-col">
                    <div class="card bg-primary card-img-holder text-white">
                        <div class="card-body" id="ttlCalls">
                            <img src="images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h5 class="font-weight-normal  mb-3">Total Working days<i class="fa fa-line-chart"></i></h5>
                            <h3><span class="TNS"><?php echo $totalattendence; ?></span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2" style="width:20%" id="card-col">
                    <div class="card bg-warning card-img-holder text-white">
                        <div class="card-body" id="ttlProductCalls">
                            <img src="images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h5 class="font-weight-normal  mb-3">Total Sold Qty<i class="fa fa-bar-chart"></i></h5>
                            <h3><span class="TNS"><?php echo $totalsoldqty; ?></span></h3>
                        </div>
                    </div>
                </div>

                

                <div class="col-sm-2" style="width:20%" id="card-col">
                    <div class="card bg-info card-img-holder text-white">
                        <div class="card-body" id="ttlCalls">
                            <img src="images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h5 class="font-weight-normal  mb-3">Total sale Amount<i class="fa fa-cubes"></i></h5>
                            <h3><span class="TNS"><?php echo $totalsoldamt; ?></span></h3>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-2" style="width:20%" id="card-col">
                    <div class="card bg-success card-img-holder text-white">
                        <div class="card-body" id="ttlCalls">
                            <img src="images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h5 class="font-weight-normal  mb-3">Avergage Sale Qty<i class="fa fa-user"></i></h5>
                            <h3><span class="TNS"><?php echo round($totalsoldqty/$noofday); ?></span></h3>
                        </div>
                    </div>
                </div>

                
                <div class="col-sm-2" style="width:20%" id="card-col">
                    <div class="card bg-info card-img-holder text-white">
                        <div class="card-body" id="ttlCalls">
                            <img src="images/circle.svg" class="card-img-absolute" alt="circle-image">
                            <h5 class="font-weight-normal  mb-3">Average Sale Amt<i class="fa fa-money"></i></h5>
                            <h3><span class="TNS"><?php echo round($totalsoldamt/$noofday); ?></span></h3>
                        </div>
                    </div>
                </div>


            
            </div>
        <!-- </div> -->
        </section>


        
   <section class="content">

<!-- 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<div class="container-fluid my-4">
  <div class="row g-3">

    <!-- Table 1 -->


    <section class="col-lg-6 connectedSortable">
        <div class="box box-success">
            <div class="box-header"> <i class="fa fa-signal"></i>
                <h3 class="box-title"> Top 20 BA sales</h3>
                <div class="pull-right box-tools">
                    <button class="btn btn-info btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse" fdprocessedid="bappo3"><i class="fa fa-minus"></i></button>
                </div>

          </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:25%">Salesman Name</th>
                                    <th style="width:25%">No. of Working Days</th>
                                    <th style="width:25%">Total Quantity Sold</th>
                                    <th style="width:25%">Total Total Amount</th>
                                    
                                </tr>
                            </thead>

                            
                            <tbody>
                                  <?php


$salArr1 = $_objAdmin->_getSelectList2("table_activity_salesman_attendance as a2 
LEFT JOIN table_salesman as s ON s.salesman_id = a2.salesman_id", "MIN(a2.activity_id) as activity_id", "", "s.account_id = $account_id AND a2.activity_type = 11 AND a2.start_time != '00:00:00' AND (a2.activity_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "') $salesman GROUP BY a2.salesman_id, a2.activity_date ORDER BY a2.salesman_id ASC, a2.activity_date ASC");

$minActIdArr = [];
if (is_array($salArr1) && (count($salArr1) > 0)) {
    foreach ($salArr1 as $key => $salArr1Data) {
        $minActIdArr[] = $salArr1Data->activity_id;
    }

    $minActIds = implode(',', $minActIdArr);

   
}



                        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'wv') !== false)) {
                            $targetBlank = '';
                        } else {
                            $targetBlank = 'target="_blank"';
                        }

                         //  select ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name from table_tertiary_order_detail as ttod LEFT JOIN table_tertiary_order as tto ON tto.order_id= ttod.order_id LEFT JOIN table_item as ti on ti.item_id = ttod.item_id LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id group by tto.salesman_id ORDER BY sum(ttod.quantity) DESC
                         $try_odr = $_objAdmin->_getSelectList('table_tertiary_order as tto
                         LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
                         LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
                         LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
                         LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
                         LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
                         LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 
                        
                         LEFT JOIN state as st2 on st2.state_id = s.state 
                         LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
                         LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,st2.state_name as salesman_state,
 z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
                            "' AND '" . $toDate . "')  $salesman $salesmanCnd group by tto.salesman_id ORDER BY sum(ttod.acc_total) DESC limit 20");
                     $odr_id = array();
                        if (count($try_odr) > 0) {
                            for ($i = 0; $i < count($try_odr); $i++) {
                                $odr_id[$try_odr[$i]->order_id] = $try_odr[$i]->order_id;
                                $salIdArr[$try_odr[$i]->salesman_id] = $inactiveSalData;
                            }
                        }

                        if (isset($odr_id) && !empty($odr_id)) {

                            $auRec2 = $_objAdmin->_getSelectList2('table_tertiary_order_detail', "order_id, count( distinct(item_id)) as total_item,sum(quantity) as order_quantity", '', " order_id IN(" . implode(',', $odr_id) . ") group by order_id");
                            $orderitms = array();
                            if (count($auRec2) > 0) {
                                for ($i = 0; $i < count($auRec2); $i++) {
                                    $orderitms[$auRec2[$i]->order_id] = $auRec2[$i]->total_item;
                                    $orderqty[$auRec2[$i]->order_id] = $auRec2[$i]->order_quantity;
                                }
                            }

                        }

                        if (!empty($try_odr)) {

                            for ($i = 0; $i < count($try_odr); $i++) {
                                $ttl_item = $orderitms[$try_odr[$i]->order_id] ? $orderitms[$try_odr[$i]->order_id]
                                    : 0;
                                $ttl_qty = $orderqty[$try_odr[$i]->order_id] ? $orderqty[$try_odr[$i]->order_id]
                                    : 0;
                                  /*  $salArr = $_objAdmin->_getSelectList2("table_activity_salesman_attendance as a1 
                                    left join table_tags as tg on tg.tag_id = a1.attendance_type
                                    LEFT JOIN table_salesman as s ON s.salesman_id = a1.salesman_id", 'COUNT(*) as TotalWorkDays', '', " s.account_id = $account_id AND a1.activity_type = 11 AND (a1.activity_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "') AND a1.start_time != '00:00:00' AND a1.activity_id IN($minActIds) AND s.salesman_id='".$try_odr[$i]->salesman_id."'
                                    GROUP BY a1.salesman_id
                                    ORDER BY a1.salesman_id ASC, a1.activity_date ASC, a1.start_time ASC"); */
                                    $salArr = $_objAdmin->_getSelectList2("table_activity_salesman_attendance as a1 
                                    left join table_tags as tg on tg.tag_id = a1.attendance_type
                                    LEFT JOIN table_salesman as s ON s.salesman_id = a1.salesman_id", 'COUNT(*) as TotalWorkDays', '', " s.account_id = $account_id AND a1.activity_type = 11 AND (a1.activity_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "') AND a1.start_time != '00:00:00'  AND s.salesman_id='".$try_odr[$i]->salesman_id."'
                                    GROUP BY a1.salesman_id
                                    ORDER BY a1.salesman_id ASC, a1.activity_date ASC, a1.start_time ASC");
                                ?>
                                <tr>
                                   
                                    <td style="width:25%"><?php echo $try_odr[$i]->salesman_name; ?></td>
                                    <td style="width:25%"><?php echo $salArr[0]->TotalWorkDays; ?>
                                        <?php //echo $try_odr[$i]->employee_code; ?></td>
                                   
                                   
                              
                                    <td style="width:25%"><?php echo  $try_odr[$i]->order_quantity; ?></td>
                                     <td style="width:25%"><?php echo
                                        $try_odr[$i]->total_invoice_amount
                                        ?> </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-danger text-center">
                                        Report Not Available
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                         </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Table 2 -->
    <section class="col-lg-6 connectedSortable">
        <div class="box box-info">
            <div class="box-header"> <i class="fa fa-location-dot"></i>
                <h3 class="box-title"> Top 20 State's</h3>
                <div class="pull-right box-tools">
                    <button class="btn btn-info btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse" fdprocessedid="59rvb"><i class="fa fa-minus"></i></button>
                </div>

          </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:20%">State Name</th>
                                    <th style="width:20%">No. of Working Days</th>
                                    <th style="width:20%">Sales Pcs</th>
                                    <th style="width:20%">Sales amount</th>
                                     <th style="width:20%">Av. Sales per BA </th>
                                </tr>
                            </thead>
                            <tbody>  <?php

$account_id = $_SESSION['accountId'];

                        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'wv') !== false)) {
                            $targetBlank = '';
                        } else {
                            $targetBlank = 'target="_blank"';
                        }

                     //   $step2 = $_objAdmin->_getSelectList('table_order AS O LEFT JOIN table_salesman AS s ON s.salesman_id = O.salesman_id  LEFT JOIN state AS ST ON ST.state_id = s.state LEFT JOIN table_retailer AS R ON R.retailer_id = O.retailer_id LEFT JOIN table_order_detail AS OD ON OD.order_id = O.order_id LEFT JOIN table_item AS I ON I.item_id = OD.item_id', " O.order_id, O.date_of_order,O.salesman_id,s.salesman_name,s.employee_code,ST.state_name ", '', " O.date_of_order = '" . $datevalue . "' AND ST.state_id =" . $statevalue . "  AND LOWER(O.order_type)='yes' $salesman GROUP BY O.salesman_id,O.date_of_order  ORDER BY O.date_of_order DESC");

                         //  select ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name from table_tertiary_order_detail as ttod LEFT JOIN table_tertiary_order as tto ON tto.order_id= ttod.order_id LEFT JOIN table_item as ti on ti.item_id = ttod.item_id LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id group by tto.salesman_id ORDER BY sum(ttod.quantity) DESC
                         $try_odr = $_objAdmin->_getSelectList('table_tertiary_order as tto
                         LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
                         LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
                         LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
                         LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
                         LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
                         LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 
                        
                         LEFT JOIN state as st2 on st2.state_id = s.state 
                         LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
                          LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id, count( distinct(tto.salesman_id)) as total_salesman,count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,st2.state_name as salesman_state,
 z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
                            "' AND '" . $toDate . "')  $salesman $salesmanCnd group by st2.state_id ORDER BY sum(ttod.acc_total) DESC limit 20");
                     $odr_id = array();
                        if (count($try_odr) > 0) {
                            for ($i = 0; $i < count($try_odr); $i++) {
                                $odr_id[$try_odr[$i]->order_id] = $try_odr[$i]->order_id;
                                $salIdArr[$try_odr[$i]->salesman_id] = $inactiveSalData;
                            }
                        }

                        if (isset($odr_id) && !empty($odr_id)) {

                            $auRec2 = $_objAdmin->_getSelectList2('table_tertiary_order_detail', "order_id, count( distinct(item_id)) as total_item,sum(quantity) as order_quantity", '', " order_id IN(" . implode(',', $odr_id) . ") group by order_id");
                            $orderitms = array();
                            if (count($auRec2) > 0) {
                                for ($i = 0; $i < count($auRec2); $i++) {
                                    $orderitms[$auRec2[$i]->order_id] = $auRec2[$i]->total_item;
                                    $orderqty[$auRec2[$i]->order_id] = $auRec2[$i]->order_quantity;
                                }
                            }

                        }

                        if (!empty($try_odr)) {

                            for ($i = 0; $i < count($try_odr); $i++) {
                                $ttl_item = $orderitms[$try_odr[$i]->order_id] ? $orderitms[$try_odr[$i]->order_id]
                                    : 0;
                                $ttl_qty = $orderqty[$try_odr[$i]->order_id] ? $orderqty[$try_odr[$i]->order_id]
                                    : 0;
                                
                                    $salArr = $_objAdmin->_getSelectList2("table_activity_salesman_attendance as a1 
                                    left join table_tags as tg on tg.tag_id = a1.attendance_type
                                    LEFT JOIN table_salesman as s ON s.salesman_id = a1.salesman_id", 'COUNT(*) as TotalWorkDays', '', " s.account_id = $account_id AND a1.activity_type = 11 AND (a1.activity_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "') AND a1.start_time != '00:00:00'  AND s.salesman_id='".$try_odr[$i]->salesman_id."'
                                    GROUP BY a1.salesman_id
                                    ORDER BY a1.salesman_id ASC, a1.activity_date ASC, a1.start_time ASC");
                                ?>
                                <tr>
                                   
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo $try_odr[$i]->salesman_state; ?></td>
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo $salArr[0]->TotalWorkDays; ?>
                                        <?php //echo $try_odr[$i]->employee_code; ?></td>
                                   
                                        <td style="min-width: 100px;max-width: 150px;"><?php echo  $try_odr[$i]->order_quantity; ?></td>
                                     <td style="min-width: 100px;max-width: 150px;"><?php echo
                                        $try_odr[$i]->total_invoice_amount
                                        ?> </td>
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo  round($try_odr[$i]->total_invoice_amount/$try_odr[$i]->total_salesman); ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger text-center">
                                        Report Not Available
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                                                            
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Table 3 -->
    <section class="col-lg-6 connectedSortable">
        <div class="box box-primary">
            <div class="box-header"> <i class="fa fa-city"></i>
                <h3 class="box-title">Top 20 Cities</h3>
                <div class="pull-right box-tools">
                    <button class="btn btn-info btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse" fdprocessedid="s361b3"><i class="fa fa-minus"></i></button>
                </div>

          </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:20%">City Name</th>
                                    <th style="width:20%">No. of Working Days</th>
                                    <th style="width:20%">Sales Pcs</th>
                                    <th style="width:20%">Sales amount</th>
                                     <th style="width:20%">Av. Sales per BA </th>
                                </tr>
                            </thead>
                            <tbody> <?php

$account_id = $_SESSION['accountId'];

                        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'wv') !== false)) {
                            $targetBlank = '';
                        } else {
                            $targetBlank = 'target="_blank"';
                        }

                     //   $step2 = $_objAdmin->_getSelectList('table_order AS O LEFT JOIN table_salesman AS s ON s.salesman_id = O.salesman_id  LEFT JOIN state AS ST ON ST.state_id = s.state LEFT JOIN table_retailer AS R ON R.retailer_id = O.retailer_id LEFT JOIN table_order_detail AS OD ON OD.order_id = O.order_id LEFT JOIN table_item AS I ON I.item_id = OD.item_id', " O.order_id, O.date_of_order,O.salesman_id,s.salesman_name,s.employee_code,ST.state_name ", '', " O.date_of_order = '" . $datevalue . "' AND ST.state_id =" . $statevalue . "  AND LOWER(O.order_type)='yes' $salesman GROUP BY O.salesman_id,O.date_of_order  ORDER BY O.date_of_order DESC");

                         //  select ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name from table_tertiary_order_detail as ttod LEFT JOIN table_tertiary_order as tto ON tto.order_id= ttod.order_id LEFT JOIN table_item as ti on ti.item_id = ttod.item_id LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id group by tto.salesman_id ORDER BY sum(ttod.quantity) DESC
                         $try_odr = $_objAdmin->_getSelectList('table_tertiary_order as tto
                         LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
                         LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
                         LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
                         LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
                         LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
                         LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 
                        
                         LEFT JOIN state as st2 on st2.state_id = s.state 
                          left join table_location as tl on tl.location_id = s.location
                         LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
                          LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id, count( distinct(tto.salesman_id)) as total_salesman,count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,tl.location_name as city_name,
 z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
                            "' AND '" . $toDate . "')  $salesman $salesmanCnd group by tl.location_id ORDER BY sum(ttod.acc_total) DESC limit 20");
                     $odr_id = array();
                        if (count($try_odr) > 0) {
                            for ($i = 0; $i < count($try_odr); $i++) {
                                $odr_id[$try_odr[$i]->order_id] = $try_odr[$i]->order_id;
                                $salIdArr[$try_odr[$i]->salesman_id] = $inactiveSalData;
                            }
                        }

                        if (isset($odr_id) && !empty($odr_id)) {

                            $auRec2 = $_objAdmin->_getSelectList2('table_tertiary_order_detail', "order_id, count( distinct(item_id)) as total_item,sum(quantity) as order_quantity", '', " order_id IN(" . implode(',', $odr_id) . ") group by order_id");
                            $orderitms = array();
                            if (count($auRec2) > 0) {
                                for ($i = 0; $i < count($auRec2); $i++) {
                                    $orderitms[$auRec2[$i]->order_id] = $auRec2[$i]->total_item;
                                    $orderqty[$auRec2[$i]->order_id] = $auRec2[$i]->order_quantity;
                                }
                            }

                        }

                        if (!empty($try_odr)) {

                            for ($i = 0; $i < count($try_odr); $i++) {
                                $ttl_item = $orderitms[$try_odr[$i]->order_id] ? $orderitms[$try_odr[$i]->order_id]
                                    : 0;
                                $ttl_qty = $orderqty[$try_odr[$i]->order_id] ? $orderqty[$try_odr[$i]->order_id]
                                    : 0;
                                
                                    $salArr = $_objAdmin->_getSelectList2("table_activity_salesman_attendance as a1 
                                    left join table_tags as tg on tg.tag_id = a1.attendance_type
                                    LEFT JOIN table_salesman as s ON s.salesman_id = a1.salesman_id", 'COUNT(*) as TotalWorkDays', '', " s.account_id = $account_id AND a1.activity_type = 11 AND (a1.activity_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "') AND a1.start_time != '00:00:00'  AND s.salesman_id='".$try_odr[$i]->salesman_id."'
                                    GROUP BY a1.salesman_id
                                    ORDER BY a1.salesman_id ASC, a1.activity_date ASC, a1.start_time ASC");
                                ?>
                                <tr>
                                   
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo $try_odr[$i]->city_name; ?></td>
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo $salArr[0]->TotalWorkDays; ?>
                                        <?php //echo $try_odr[$i]->employee_code; ?></td>
                                   
                                        <td style="min-width: 100px;max-width: 150px;"><?php echo  $try_odr[$i]->order_quantity; ?></td>
                                     <td style="min-width: 100px;max-width: 150px;"><?php echo
                                        $try_odr[$i]->total_invoice_amount
                                        ?> </td>
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo  round($try_odr[$i]->total_invoice_amount/$try_odr[$i]->total_salesman); ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger text-center">
                                        Report Not Available
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                                                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Table 4 -->
    <section class="col-lg-6 connectedSortable">
        <div class="box box-danger">
            <div class="box-header"> <i class="fa fa-signal"></i>
                <h3 class="box-title"> Top 20 SKU</h3>
                <div class="pull-right box-tools">
                    <button class="btn btn-info btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse" fdprocessedid="yc22fl"><i class="fa fa-minus"></i></button>
                </div>

          </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:25%">SKU Name</th>
                                    <th style="width:25%">Sale (PCS)</th>
                                    <th style="width:25%">Sale Amount</th>
                                    <th style="width:25%">No of Retailer's</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
 <?php

$account_id = $_SESSION['accountId'];

                        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'wv') !== false)) {
                            $targetBlank = '';
                        } else {
                            $targetBlank = 'target="_blank"';
                        }

                     //   $step2 = $_objAdmin->_getSelectList('table_order AS O LEFT JOIN table_salesman AS s ON s.salesman_id = O.salesman_id  LEFT JOIN state AS ST ON ST.state_id = s.state LEFT JOIN table_retailer AS R ON R.retailer_id = O.retailer_id LEFT JOIN table_order_detail AS OD ON OD.order_id = O.order_id LEFT JOIN table_item AS I ON I.item_id = OD.item_id', " O.order_id, O.date_of_order,O.salesman_id,s.salesman_name,s.employee_code,ST.state_name ", '', " O.date_of_order = '" . $datevalue . "' AND ST.state_id =" . $statevalue . "  AND LOWER(O.order_type)='yes' $salesman GROUP BY O.salesman_id,O.date_of_order  ORDER BY O.date_of_order DESC");

                         //  select ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name from table_tertiary_order_detail as ttod LEFT JOIN table_tertiary_order as tto ON tto.order_id= ttod.order_id LEFT JOIN table_item as ti on ti.item_id = ttod.item_id LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id group by tto.salesman_id ORDER BY sum(ttod.quantity) DESC
                         $try_odr = $_objAdmin->_getSelectList('table_tertiary_order as tto
                         LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
                         LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
                         LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
                         LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
                         LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
                         LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 
                        LEFT JOIN table_retailer as tr on tr.retailer_id = tto.retailer_id 
                         LEFT JOIN state as st2 on st2.state_id = s.state 
                          left join table_location as tl on tl.location_id = s.location
                         LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
                          LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id, count( distinct(tto.retailer_id)) as total_retailers,count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,ti.item_name,
 z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
                            "' AND '" . $toDate . "')  $salesman $salesmanCnd group by ttod.item_id ORDER BY sum(ttod.acc_total) DESC limit 20");
                     $odr_id = array();
                        if (count($try_odr) > 0) {
                            for ($i = 0; $i < count($try_odr); $i++) {
                                $odr_id[$try_odr[$i]->order_id] = $try_odr[$i]->order_id;
                                $salIdArr[$try_odr[$i]->salesman_id] = $inactiveSalData;
                            }
                        }

                        if (isset($odr_id) && !empty($odr_id)) {

                            $auRec2 = $_objAdmin->_getSelectList2('table_tertiary_order_detail', "order_id, count( distinct(item_id)) as total_item,sum(quantity) as order_quantity", '', " order_id IN(" . implode(',', $odr_id) . ") group by order_id");
                            $orderitms = array();
                            if (count($auRec2) > 0) {
                                for ($i = 0; $i < count($auRec2); $i++) {
                                    $orderitms[$auRec2[$i]->order_id] = $auRec2[$i]->total_item;
                                    $orderqty[$auRec2[$i]->order_id] = $auRec2[$i]->order_quantity;
                                }
                            }

                        }

                        if (!empty($try_odr)) {

                            for ($i = 0; $i < count($try_odr); $i++) {
                                $ttl_item = $orderitms[$try_odr[$i]->order_id] ? $orderitms[$try_odr[$i]->order_id]
                                    : 0;
                                $ttl_qty = $orderqty[$try_odr[$i]->order_id] ? $orderqty[$try_odr[$i]->order_id]
                                    : 0;
                                
                                 
                                ?>
                                <tr>
                                   
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo $try_odr[$i]->item_name; ?></td>
                                    
                                        <td style="min-width: 100px;max-width: 150px;"><?php echo  $try_odr[$i]->order_quantity; ?></td>
                                     <td style="min-width: 100px;max-width: 150px;"><?php echo
                                        $try_odr[$i]->total_invoice_amount
                                        ?> </td>
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo  $try_odr[$i]->total_retailers; ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-danger text-center">
                                        Report Not Available
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>                             
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Table 5 -->
    <section class="col-lg-6 connectedSortable">
        <div class="box box-info">
            <div class="box-header"> <i class="fa fa-tags"></i>
                <h3 class="box-title">  Top 20 Sub-Category</h3>
                <div class="pull-right box-tools">
                    <button class="btn btn-info btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse" fdprocessedid="yc6cc"><i class="fa fa-minus"></i></button>
                </div>

          </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:25%">Sub Category</th>
                                    <th style="width:25%">Sales (PCS) </th>
                                    <th style="width:25%">Sales amount</th>
                                    <th style="width:25%">No. of Retailer</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                        <?php

$account_id = $_SESSION['accountId'];

                        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'wv') !== false)) {
                            $targetBlank = '';
                        } else {
                            $targetBlank = 'target="_blank"';
                        }

                     //   $step2 = $_objAdmin->_getSelectList('table_order AS O LEFT JOIN table_salesman AS s ON s.salesman_id = O.salesman_id  LEFT JOIN state AS ST ON ST.state_id = s.state LEFT JOIN table_retailer AS R ON R.retailer_id = O.retailer_id LEFT JOIN table_order_detail AS OD ON OD.order_id = O.order_id LEFT JOIN table_item AS I ON I.item_id = OD.item_id', " O.order_id, O.date_of_order,O.salesman_id,s.salesman_name,s.employee_code,ST.state_name ", '', " O.date_of_order = '" . $datevalue . "' AND ST.state_id =" . $statevalue . "  AND LOWER(O.order_type)='yes' $salesman GROUP BY O.salesman_id,O.date_of_order  ORDER BY O.date_of_order DESC");

                         //  select ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name from table_tertiary_order_detail as ttod LEFT JOIN table_tertiary_order as tto ON tto.order_id= ttod.order_id LEFT JOIN table_item as ti on ti.item_id = ttod.item_id LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id group by tto.salesman_id ORDER BY sum(ttod.quantity) DESC
                         $try_odr = $_objAdmin->_getSelectList('table_tertiary_order as tto
                         LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
                         LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
                         LEFT JOIN table_category AS c ON c.category_id=ti.category_id
                         LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
                         LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
                         LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
                         LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 
                        LEFT JOIN table_retailer as tr on tr.retailer_id = tto.retailer_id 
                         LEFT JOIN state as st2 on st2.state_id = s.state 
                          left join table_location as tl on tl.location_id = s.location
                         LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
                          LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id, count( distinct(tto.retailer_id)) as total_retailers,count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,c.category_name,
 z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
                            "' AND '" . $toDate . "')  $salesman $salesmanCnd group by ti.category_id ORDER BY sum(ttod.acc_total) DESC limit 20");
                     $odr_id = array();
                        if (count($try_odr) > 0) {
                            for ($i = 0; $i < count($try_odr); $i++) {
                                $odr_id[$try_odr[$i]->order_id] = $try_odr[$i]->order_id;
                                $salIdArr[$try_odr[$i]->salesman_id] = $inactiveSalData;
                            }
                        }

                        if (isset($odr_id) && !empty($odr_id)) {

                            $auRec2 = $_objAdmin->_getSelectList2('table_tertiary_order_detail', "order_id, count( distinct(item_id)) as total_item,sum(quantity) as order_quantity", '', " order_id IN(" . implode(',', $odr_id) . ") group by order_id");
                            $orderitms = array();
                            if (count($auRec2) > 0) {
                                for ($i = 0; $i < count($auRec2); $i++) {
                                    $orderitms[$auRec2[$i]->order_id] = $auRec2[$i]->total_item;
                                    $orderqty[$auRec2[$i]->order_id] = $auRec2[$i]->order_quantity;
                                }
                            }

                        }

                        if (!empty($try_odr)) {

                            for ($i = 0; $i < count($try_odr); $i++) {
                                $ttl_item = $orderitms[$try_odr[$i]->order_id] ? $orderitms[$try_odr[$i]->order_id]
                                    : 0;
                                $ttl_qty = $orderqty[$try_odr[$i]->order_id] ? $orderqty[$try_odr[$i]->order_id]
                                    : 0;
                                
                                 
                                ?>
                                <tr>
                                   
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo $try_odr[$i]->category_name; ?></td>
                                    
                                        <td style="min-width: 100px;max-width: 150px;"><?php echo  $try_odr[$i]->order_quantity; ?></td>
                                     <td style="min-width: 100px;max-width: 150px;"><?php echo
                                        $try_odr[$i]->total_invoice_amount
                                        ?> </td>
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo  $try_odr[$i]->total_retailers; ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-danger text-center">
                                        Report Not Available
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                                                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Table 6 -->
    <section class="col-lg-6 connectedSortable">
        <div class="box box-success">
            <div class="box-header"> <i class="fa fa-line-chart"></i>
                <h3 class="box-title"> Top 20 Retailers</h3>
                <div class="pull-right box-tools">
                    <button class="btn btn-info btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse" fdprocessedid="pzp1qc"><i class="fa fa-minus"></i></button>
                </div>

          </div>
             <div class="card-body">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:20%">Retailer Name</th>
                                    <th style="width:20%">Qty</th>
                                    <th style="width:20%">Amount</th>
                                    <th style="width:20%">No of Check-in</th>
                                     <th style="width:20%">Current Stock </th>
                                </tr>
                            </thead>
                            <tbody>   <?php

$account_id = $_SESSION['accountId'];

                        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) || (strpos($_SERVER['HTTP_USER_AGENT'], 'wv') !== false)) {
                            $targetBlank = '';
                        } else {
                            $targetBlank = 'target="_blank"';
                        }

                 /*       $try_odr = $_objAdmin->_getSelectList('table_tertiary_order as tto
                        LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
                        LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
                        LEFT JOIN table_tertiary_stock AS stk on ti.item_id = stk.item_id
                        LEFT JOIN table_category AS c ON c.category_id=ti.category_id
                        LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
                        LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
                        LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
                        LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 
                       LEFT JOIN table_retailer as tr on tr.retailer_id = tto.retailer_id 
                       
                        LEFT JOIN state as st2 on st2.state_id = s.state 
                         left join table_location as tl on tl.location_id = s.location
                        LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
                         LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id,stk.stock_qty, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,tr.retailer_name,tr.retailer_id,
z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
                           "' AND '" . $toDate . "')  $salesman $salesmanCnd group by tto.retailer_id  ORDER BY sum(ttod.quantity) DESC limit 20");
                  */

                  
                        $try_odr = $_objAdmin->_getSelectList('table_tertiary_order as tto
                         LEFT JOIN table_tertiary_order_detail as ttod ON tto.order_id= ttod.order_id 
                         LEFT JOIN table_item as ti on ti.item_id = ttod.item_id 
                        
                         LEFT JOIN table_category AS c ON c.category_id=ti.category_id
                         LEFT JOIN table_salesman as s on s.salesman_id = tto.salesman_id 
                         LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id 
                         LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id 
                         LEFT JOIN table_salesman AS S2 ON S2.salesman_id = SH.rpt_user_id 
                        LEFT JOIN table_retailer as tr on tr.retailer_id = tto.retailer_id 
                        
                         LEFT JOIN state as st2 on st2.state_id = s.state 
                          left join table_location as tl on tl.location_id = s.location
                         LEFT JOIN table_zone_state_mapping as zsm2 on zsm2.state_id = s.state AND zsm2.account_id = s.account_id 
                          LEFT JOIN table_zone as z2 on z2.zone_id = zsm2.zone_id', 'ti.item_id,sum(ttod.acc_total) as total_invoice_amount,tto.salesman_id,ttod.order_id, count( distinct(ttod.item_id)) as total_item,sum(ttod.quantity) as order_quantity,s.salesman_name,tr.retailer_name,tr.retailer_id,tr.retailer_code,
 z2.zone_name as salesman_zone,s.employee_code', '', " (tto.date_of_order BETWEEN '" . $fromDate .
                            "' AND '" . $toDate . "')  $salesman $salesmanCnd group by tto.retailer_id,ttod.item_id  ORDER BY sum(ttod.acc_total) DESC limit 20");
                     $odr_id = array();
                       
                /*     $auRec = $_objAdmin->_getSelectList('table_tertiary_stock as stk
                     LEFT JOIN table_retailer as r ON r.retailer_id = stk.retailer_id
                     LEFT JOIN table_distributors as d on d.distributor_id = r.distributor_id
                     LEFT JOIN table_item as itm ON itm.item_id = stk.item_id
                     LEFT JOIN table_price as p on p.item_id = itm.item_id
                     LEFT JOIN state as s on s.state_id = r.state 
                     LEFT JOIN table_zone_state_mapping as zsm on zsm.state_id=r.state AND zsm.account_id = r.account_id
                     LEFT JOIN table_zone as z on z.zone_id = zsm.zone_id 
                     LEFT JOIN table_location as l on l.location_id = r.location_id 
                     LEFT JOIN city as c on c.city_id = r.city', " stk.stock_id,r.retailer_id,r.retailer_name,r.retailer_code,itm.item_id,itm.item_name,itm.item_code,p.item_dp,stk.stock_qty,s.state_name,z.zone_name,c.city_name,d.distributor_name,d.distributor_code,l.location_name,stk.created_at,stk.updated_at", '', $where . " ORDER BY stk.stock_id ASC  ");
                     */

                        if (!empty($try_odr)) {

                            for ($i = 0; $i < count($try_odr); $i++) {
                                $auAttSt = $_objAdmin->_getSelectList2('table_capture_checkin_out as cc
                                LEFT JOIN table_salesman AS s ON s.salesman_id = cc.salesman_id
                                LEFT JOIN table_retailer as r ON r.retailer_id = cc.retailer_id', 'count(checkin_time) as totalcheckin', '', " cc.checkin_date BETWEEN '" . $fromDate . "' AND '" . $toDate . "' AND s.status='A' AND r.status = 'A' and cc.retailer_id='".$try_odr[$i]->retailer_id."' and cc.salesman_id='".$try_odr[$i]->salesman_id."' group by cc.retailer_id ORDER BY cc.checkin_date ASC, cc.retailer_id ASC, cc.checkin_time ASC ");
                                
                                $auAttStstock = $_objAdmin->_getSelectList2('table_tertiary_stock ', 'stock_qty', '', "  retailer_id='".$try_odr[$i]->retailer_id."' and item_id='".$try_odr[$i]->item_id."'  ");
                                
                               
                                ?>
                                <tr>
                                   
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo $try_odr[$i]->retailer_name; ?></td>
                                    
                                        <td style="min-width: 100px;max-width: 150px;"><?php echo  $try_odr[$i]->order_quantity; ?></td>
                                     <td style="min-width: 100px;max-width: 150px;"><?php echo
                                        $try_odr[$i]->total_invoice_amount
                                        ?> </td>
                                          <td style="min-width: 100px;max-width: 150px;"><?php echo
                                        $auAttSt[0]->totalcheckin;
                                        ?></td>
                                    <td style="min-width: 100px;max-width: 150px;"><?php echo  $auAttStstock[0]->stock_qty; ?></td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger text-center">
                                        Report Not Available
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                                                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



  </div>
</div>



        </section>
   
</aside>

<?php include("footer.php"); ?>
<script src="form-validator/jquery.form-validator.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $.validate({
            modules: 'security'
        });

        $('#retailer_id').select2({
            placeholder: "Select <?php echo $AliaseUsers['retailer'] ?>",
            allowClear: true
        });

        $('#smc_part_id').select2({
            placeholder: "Select Item",
            allowClear: true
        });

        //submits the form
        $(document).on('click', '#submtBtn', function () {
            $('#sbmtForm').click();
        });

        // $(".smc_part_no").autocomplete({
        //     minLength: 3,
        //     autoFocus: true,
        //     source: function(request,response) {
        //         var slctdItms =  $('.smc_part_ids').map(function(idx, elem) {
        //             var itmId = $(elem).val();
        //             if($.trim(itmId) != '') {
        //                 return itmId;
        //             }
        //         }).get().toString();
        //         $.ajax({
        //             url: "ajax_order_entry_actions.php",
        //             method:'POST',
        //             data: {'term':request.term,'selected_items' : slctdItms},
        //             success: function(data) {
        //                 response(JSON.parse(data));
        //             }
        //         });
        //     },
        //     classes: {
        //         "ui-autocomplete": "highlight"
        //     },
        //     search: function(event, ui) {
        //         $(this).parent().find('.ajax-loader').show();
        //     },
        //     response: function(event,ui) {
        //         $(this).parent().find('.ajax-loader').hide();
        //     },
        //     select: function(event,ui){
        //         var smcPartNo = ui.item.value;
        //
        //         if(smcPartNo != ''){
        //             $.ajax({
        //                 url:'ajax_order_entry_actions.php',
        //                 method:'POST',
        //                 data:{'action':'get_SMC_Part_Id_Price','smcPartNo' : smcPartNo},
        //                 success : function (resp) {
        //                     var smcObj = JSON.parse(resp);
        //                     $('#smc_part_id').val(smcObj.smc_part_id);
        //                 }
        //             });
        //         }
        //     },
        //     change: function(event,ui) {
        //         if(ui.item == null){
        //             $(this).val('');
        //             $('#smc_part_id').val('');
        //         }
        //     }
        // });

    });
</script>
