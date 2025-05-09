<?php
/**** This file is a dynamic filter generator, This needs to be included in every report inside filter section along with filter configuration******/
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include_once("includes/config.inc.php");
include_once("includes/globalarraylist.php");
$_objArrayList = new ArrayList();
$DynamicFilterObj = new DynamicFilterList();

$DynamicFilterObj->salesmanList = $salesman;
if ((isset($_POST['action']) && $_POST['action'] == "add_filter") || (isset($_POST['addFilters']) && count($_POST['addFilters']) > 0)) {
    $filterArr = array();
    $filterArr['filterList'] = $_POST['addFilters'];
    if (isset($_POST['addFilters']) && count($_POST['addFilters']) > 0) {
        foreach ($filterArr['filterList'] as $key => $filter) {
            if ($filter != '') {
                $filterArr['filterOptions'][$filter] = $DynamicFilterObj->getDefaultFilterOptions($filter);
            }
        }
    }

//	echo '<pre>';
//	print_r($filterArr);
//	die(' die here');
}
/*******************Default selection section set here********************************/
$currentDis = (in_array('distributor', $filterArr['filterList']) && (isset($filterArr['filterOptions']['distributor']) && !empty($filterArr['filterOptions']['distributor']['defaultSelection'])) ? $filterArr['filterOptions']['distributor']['defaultSelection'] : (($_SESSION['userLoginType'] == 3) ? $_SESSION['distributorId'] : ''));
$currentSalesman = (in_array('salesman', $filterArr['filterList']) && (isset($filterArr['filterOptions']['salesman']) && !empty($filterArr['filterOptions']['salesman']['defaultSelection'])) ? $filterArr['filterOptions']['salesman']['defaultSelection'] : @$_POST['fil_salesman']);
$currentRet = (in_array('retailer', $filterArr['filterList']) && (isset($filterArr['filterOptions']['retailer']) && !empty($filterArr['filterOptions']['retailer']['defaultSelection'])) ? $filterArr['filterOptions']['retailer']['defaultSelection'] : @$_POST['fil_retailer']);
$currentRetAuto = (in_array('fil_retailer_auto', $filterArr['filterList']) && (isset($filterArr['filterOptions']['fil_retailer_auto']) && !empty($filterArr['filterOptions']['fil_retailer_auto']['defaultSelection'])) ? $filterArr['filterOptions']['fil_retailer_auto']['defaultSelection'] : @$_POST['fil_retailer_auto']);
$currentStockist = (in_array('stockist', $filterArr['filterList']) && (isset($filterArr['filterOptions']['stockist']) && !empty($filterArr['filterOptions']['stockist']['defaultSelection'])) ? $filterArr['filterOptions']['stockist']['defaultSelection'] : (($_SESSION['userLoginType'] == 7) ? $_SESSION['stockistId'] : ''));
$currentSalesmanManager = (in_array('salesman_manager', $filterArr['filterList']) && (isset($filterArr['filterOptions']['salesman_manager']) && !empty($filterArr['filterOptions']['salesman_manager']['defaultSelection'])) ? $filterArr['filterOptions']['salesman_manager']['defaultSelection'] : @$_POST['fil_salesman_manager']);
/*******************Default selection section set here********************************/
if (isset($_SESSION['fil_salesman']) && $_SESSION['fil_salesman'] > 0) {
$sal_id=$_SESSION['fil_salesman'];
} else if (isset($_SESSION['fil_salesman_manager']) && ($_SESSION['fil_salesman_manager'] > 0)) {
    $sal_id=$_SESSION['fil_salesman_manager'];
}else{
    $sal_id='';
}

//$salesmanList2 = $_objAdmin->_getSelectList('table_salesman AS s LEFT JOIN state AS ST ON ST.state_id = s.state',
//    ' s.salesman_id, s.salesman_name, ST.state_id', '', " $depotSalCondition AND s.status='A' AND s.salesman_id>0 $salesman  ORDER BY s.salesman_name ASC");
?>
<input type="hidden" id="SalesmanId" value="<?php echo $sal_id; ?>">
<div class="row" style="margin:5px;">
   
    <?php 
        $stateList = $DynamicFilterObj->getStates('sal_state'); ?>
        <div class="form-group col-12 col-sm-2" style="width:20%">
            <label for="<?php echo $filterArr['filterOptions']['salesman_state']['id']; ?>">Salesman State</label>
            <select name="fil_salesman_state" id="sal_state" class="form-control" fdprocessedid="z0e1i">
                <option value="">All</option>
                <?php
                if (is_array($stateList)) {
                    foreach ($stateList as $key => $data) { ?>
                        <option value="<?php echo $data->state_id; ?>"
                            <?php if ($data->state_id == $_SESSION['fil_salesman_state']) { ?> selected <?php } ?>>
                            <?php echo ucwords($data->state_name); ?></option>
                    <?php }
                }
                ?>
            </select>
        </div>
    
   
    
    <?php

//        $rtndata = $_objArrayList->GetSalesmenMenu($salsList, $currentSalesman, $flexiLoad = ''); ?>
       <div class="form-group col-12 col-sm-2" style="width:20%">
            <label for="<?php echo $filterArr['filterOptions']['salesman']['id']; ?>">Sales Hierarchy : </label>
            <select name="fil_salesman" id="sal" class="form-control" fdprocessedid="pl6tfl">
                <?php echo $rtndata; ?>
            </select>
        </div>
   

    <?php
   
        $categoryList = $DynamicFilterObj->getCategory(); ?>
       <div class="form-group col-12 col-sm-2" style="width:20%">
            <label for="<?php echo $filterArr['filterOptions']['category']['id']; ?>">Category</label>
            <select name="fil_category" id="category" class="form-control" fdprocessedid="ka72l">
                <option value="">All</option>
                <?php
                if (is_array($categoryList)) {
                    foreach ($categoryList as $key => $data) { ?>
                        <option value="<?php echo $data->category_id; ?>"
                            <?php if ($data->category_id == $_SESSION['fil_category']) { ?> selected <?php } ?>>
                            <?php echo ucwords($data->category_name); ?></option>
                    <?php }
                }
                ?>
            </select>
        </div>
   
    <!-- Todo End : add new filer distributor type: sudhanshu 05 july  2024 -->
   
        <div class="form-group col-12 col-sm-2" style="width:20%">
            <label for="<?php echo $filterArr['filterOptions']['month']['id']; ?>">Month</label>
            <select name="fil_month"
                    id="month"
                    class="form-control">
                <!--		<option value="">All</option>-->
                <?php
                if (is_array($DynamicFilterObj->ARR_MONTHS)) {
                    $selectedMonth = (isset($_SESSION['fil_month']) && !empty($_SESSION['fil_month'])) ? $_SESSION['fil_month'] : date('m');
                    foreach ($DynamicFilterObj->ARR_MONTHS as $month_num => $month_name) { ?>
                        <option value="<?php echo $month_num; ?>"
                            <?php if ($month_num == $selectedMonth) { ?> selected <?php } ?>>
                            <?php echo ucwords($month_name); ?></option>
                    <?php }
                }
                ?>
            </select>
        </div>
    
  
       <div class="form-group col-12 col-sm-2" style="width:20%">
            <label for="<?php echo $filterArr['filterOptions']['year']['id']; ?>">Year</label>
            <select name="fil_year" id="year" class="form-control" fdprocessedid="ft4oxp">
                <!--		<option value="">All</option>-->
                <?php

                if (is_array($DynamicFilterObj->thisYear)) {
                    $selectedYear = (isset($_SESSION['fil_year']) && !empty($_SESSION['fil_year'])) ? $_SESSION['fil_year'] : date('Y');
                    foreach ($DynamicFilterObj->thisYear as $year) { ?>
                        <option value="<?php echo $year; ?>"
                            <?php if ($year == $selectedYear) { ?> selected <?php } ?>>
                            <?php echo $year; ?></option>
                    <?php }
                }
                ?>
            </select>
        </div>
 
</div>

<script>
    $(function () {
        $("#from").datepicker({
            dateFormat: "d M yy",
            defaultDate: "w",
            changeMonth: true,
            numberOfMonths: 1,
            minDate: new Date("<?php echo date('Y, m, d', strtotime($_SESSION['StartDate'])) ?>"),
            maxDate: new Date(),
            onSelect: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            dateFormat: "d M yy",
            defaultDate: "-w",
            changeMonth: true,
            numberOfMonths: 1,
            minDate: new Date("<?php echo date('Y, m, d', strtotime($_SESSION['StartDate'])) ?>"),
            maxDate: new Date(),
            onSelect: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>

<!-- universal search for retailer order -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script>
    $('#order_category').select2({
        placeholder: "Select ",
        allowClear: true
    });
    $("#retId").autocomplete({

// source: availableTags,

        source: function (request, response) {
            //console.log('hii');

            $.ajax({
                url: "ajax_dynamic_filters.php",
                method: 'POST',
                data: {
                    'term': request.term,
                    'action': "retailerSearch",
                },
                success: function (data) {
                    const dt = JSON.parse(data)
                    if (dt[0].value !== '') {
                        response(JSON.parse(data));
                    } else {
                        alert('Retailer Not Found');
                    }
                }
            });


        },
        minLength: 3,
        select: function (event, ui) {
            var retailer_id = ui.item.value;
            var retailer_name = ui.item.label;

            $('#retl_id').val(retailer_id);
            ui.item.value = retailer_name;
        },
        change: function (event, ui) {
            if (ui.item == null) {
                $(this).val('');

                $('#retl_id').val('');
            }
        }

    });
</script>
<script type="text/javascript">

    function loadSalesmanStateZoneWise(sltdZoneId, sltdStateId, sltdSalesmanId) {
        // console.log(sltdZoneId);
        // console.log(sltdStateId);
        var zoneId = sltdZoneId;
        // $.ajax({
        //     url: 'ajax_dynamic_filters.php',
        //     type: 'POST',
        //     async : false,
        //     data: {'action': 'getZoneStateList', 'zoneid': sltdZoneId, 'stateFor': 'sal_state','sltdStateId':sltdStateId},
        //     success: function (resp) {
        //         if ($.trim(resp) != '') {
        //             $("#sal_state").html(resp);
        //         }
        //     }
        // });

        if ($("#sal_state").length > 0) {
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {
                    'action': 'getZoneStateList',
                    'zoneid': zoneId,
                    'stateFor': 'sal_state',
                    'sltdStateId': sltdStateId
                },
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        if ($("#sal_state").length > 0) {
                            $("#sal_state").html(resp);
                        }
                    }
                }
            });
        } else if ($("#salesman_manager").length > 0) {
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'getZoneWiseManagerOrHierarchy', 'zoneid': zoneId, 'sltdSalesmanId': sltdSalesmanId},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        if ($('#salesman_manager').length > 0) {
                            $("#salesman_manager").html(resp);
                        } else {
                            $("#sal").html(resp);
                        }
                    }
                }
            });
        } else if ($("#sal").length > 0) {
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'getZoneWiseManagerOrHierarchy', 'zoneid': zoneId, 'sltdSalesmanId': sltdSalesmanId},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        $("#sal").html(resp);
                    }
                }
            });
        }
    }

    function loadSalesManagerOrSalesHierarchyStateWise(sltdStateId, sltdSalesmanId) {
        var SalesmanId = $('#SalesmanId').val();
       
        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {'action': 'sal_state', 'st_id': sltdStateId, 'sltdSalesmanId': SalesmanId},
            success: function (resp) {
                if ($.trim(resp) != '') {
                    if ($('#salesman_manager').length) {
                        $("#salesman_manager").html(resp);
                    } else {
                        $("#sal").html(resp);
                    }
                }
            }
        });
    }

    function loadSalesHierarchySalesManagerWise(sltdSalesManagerId, sltdSalesmanId) {
        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {'action': 'getBottomUsers', 'selectedMngrId': sltdSalesManagerId, 'sltdSalesmanId': sltdSalesmanId},
            success: function (resp) {
                $("#sal").html(resp);
            }
        });
    }

    function loadRetailerStateZoneWise(sltdZoneId, sltdStateId, sltdRetailerId) {
        if ($("#ret_state").length > 0) {
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {
                    'action': 'getZoneStateList',
                    'zoneid': sltdZoneId,
                    'stateFor': 'ret_state',
                    'sltdStateId': sltdStateId
                },
                success: function (resp) {

                    if ($.trim(resp) != '') {
                        $("#ret_state").html(resp);
                    }
                }
            });
        } else if ($("#ret").length > 0) {
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'getZoneWiseRetailers', 'zoneid': sltdZoneId, 'sltdRetailerId': sltdRetailerId},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        $("#ret").html(resp);
                    }
                }
            });
        }
    }

    function loadRetailerStateWise(sltdStateId, sltdRetailerId) {
        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {'action': 'ret_state', 'st_id': sltdStateId, 'sltdRetailerId': sltdRetailerId},
            success: function (resp) {
                if ($.trim(resp) != '') {
                    $("#ret").html(resp);
                }
            }
        });
    }

    function loadDistributorStateZoneWise(sltdZoneId, sltdStateId) {
        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {
                'action': 'getZoneStateList',
                'zoneid': sltdZoneId,
                'stateFor': 'dis_state',
                'sltdStateId': sltdStateId
            },
            success: function (resp) {

                if ($.trim(resp) != '') {
                    $("#dis_state").html(resp);
                }
            }
        });
    }

    function loadDistributorStateWise(sltdStateId, sltdDistributorId) {
        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {'action': 'dis_state', 'st_id': sltdStateId, 'sltdDistributorId': sltdDistributorId},
            success: function (resp) {
                if ($.trim(resp) != '') {
                    $("#dis").html(resp);
                }
            }
        });
    }

    function loadStockistStateZoneWise(sltdZoneId, sltdStateId) {
        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {
                'action': 'getZoneStateList',
                'zoneid': sltdZoneId,
                'stateFor': 'stockist_state',
                'sltdStateId': sltdStateId
            },
            success: function (resp) {

                if ($.trim(resp) != '') {
                    $("#stockist_state").html(resp);
                }
            }
        });
    }

    function loadStockistStateWise(sltdStateId, sltdStockistId) {
        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {'action': 'stockist_state', 'st_id': sltdStateId, 'sltdStockistId': sltdStockistId},
            success: function (resp) {
                if ($.trim(resp) != '') {
                    $("#stockist").html(resp);
                }
            }
        });
    }

    function loadCityStateWise(state_id, city) {
        $.ajax({
            url: "ajax_dynamic_filters.php",
            type: 'POST',
            async: false,
            data: {'action': 'city', 'c_id': state_id, 'sltdcity': city},
            success: function (resp) {
                $("#city").html(resp);
            }
        })
    }

    function loadCatWiseItem(cat, itm) {
        $.ajax({
            url: "ajax_dynamic_filters.php",
            type: "POST",
            async: false,
            data: {'action': 'category', 'c_id': cat, 'item': itm},
            success: function (resp) {
                $("#item").html(resp);
            }
        })
    }

    function loadSalesHierarchyOrSalesManagerDesignationWise(sltdSalesmanDesignationId, sltdSalesmanId) {
        var selectdStateId = ($('#sal_state').length > 0) ? $('#sal_state').val() : '';

        $.ajax({
            url: 'ajax_dynamic_filters.php',
            type: 'POST',
            async: false,
            data: {
                'action': 'getDesignationWiseSalesman',
                'designationId': sltdSalesmanDesignationId,
                'sltdSalesmanId': sltdSalesmanId,
                'selectdStateId': selectdStateId
            },
            success: function (resp) {
                if ($.trim(resp) != '') {
                    if ($('#salesman_manager').length > 0) {
                        $("#salesman_manager").html(resp);
                    } else {
                        $("#sal").html(resp);
                    }
                }
            }
        });
    }

    $(document).ready(function () {
        var filterval = $("#grpfltr").val();

        if (filterval != 'undefined' && filterval != "") {
            //alert(filterval);
            $.ajax({
                url: 'getFilterGraphs.php',
                type: 'POST',
                async: false,
                data: {'action': 'order_list', 'filterval': filterval},
                success: function (resp) {
                    $("#graphsContainer").html(resp);
                }
            });
        }

        //load dependent filters

        if ($('#sal_zone').length > 0) {
            //if salesman zone filter exists then load salesman state filter zone wise
            let sltdZoneId = $('#sal_zone').val();
            let sltdStateId = $('#sal_state').val();
            let sltdSalesmanId = ($('#salesman_manager').length > 0) ? $('#salesman_manager').val() : $('#sal').val();
            loadSalesmanStateZoneWise(sltdZoneId, sltdStateId, sltdSalesmanId);
        }


        if ($('#sal_state').length > 0) {
            //if salesman state filter exists then load salesman Manager filter state wise or sales Hierarchy filter state wise if salesman Manager filter does not exists
            let sltdStateId = $('#sal_state').val();

            if ($('#salesman_designation').length <= 0) {
                let sltdSalesmanId = ($('#salesman_manager').length > 0) ? $('#salesman_manager').val() : $('#sal').val();
                loadSalesManagerOrSalesHierarchyStateWise(sltdStateId, sltdSalesmanId);
            }

            if ($('#city').length > 0) {
                let state_id = sltdStateId;
                let city = $('#city').val();
                loadCityStateWise(state_id, city);
            }
        }
        if ($('#salesman_designation').length > 0) {
            //if salesman Manager filter exists then load sales Hierarchy filter Manager wise
            var sltdSalesmanDesignationId = $('#salesman_designation').val();
            if (sltdSalesmanDesignationId != '') {
                var sltdSalesmanId = ($('#salesman_manager').length > 0) ? $('#salesman_manager').val() : $('#sal').val();
                loadSalesHierarchyOrSalesManagerDesignationWise(sltdSalesmanDesignationId, sltdSalesmanId);
            }
        }

        if ($('#salesman_manager').length > 0) {
            //if salesman Manager filter exists then load sales Hierarchy filter Manager wise
            var sltdSalesManagerId = $('#salesman_manager').val();
            var sltdSalesmanId = $('#sal').val();
            loadSalesHierarchySalesManagerWise(sltdSalesManagerId, sltdSalesmanId);
        }

        if ($('#ret_zone').length > 0) {
            //if Retailer  zone filter exists then load Retailer state filter zone wise
            let sltdZoneId = $('#ret_zone').val();
            let sltdStateId = $('#ret_state').val();
            let sltdRetailerId = $('#ret').val();
            loadRetailerStateZoneWise(sltdZoneId, sltdStateId, sltdRetailerId);
        }

        if ($('#ret_state').length > 0) {
            //if Retailer state filter exists then load Retailer filter state wise
            let sltdStateId = $('#ret_state').val();
            let sltdRetailerId = $('#ret').val();
            loadRetailerStateWise(sltdStateId, sltdRetailerId);
        }

        if ($('#dis_zone').length > 0) {
            //if Distributor  zone filter exists then load Distributor state filter zone wise
            let sltdZoneId = $('#dis_zone').val();
            let sltdStateId = $('#dis_state').val();
            loadDistributorStateZoneWise(sltdZoneId, sltdStateId);
        }

        if ($('#dis_state').length > 0) {
            //if Distributor state filter exists then load Distributor filter state wise
            let sltdStateId = $('#dis_state').val();
            let sltdDistributorId = $('#dis').val();
            loadDistributorStateWise(sltdStateId, sltdDistributorId);
        }

        if ($('#stockist_zone').length > 0) {
            //if Stockist zone filter exists then load Stockist state filter zone wise
            let sltdZoneId = $('#stockist_zone').val();
            let sltdStateId = $('#stockist_state').val();
            loadStockistStateZoneWise(sltdZoneId, sltdStateId);
        }

        if ($('#stockist_state').length > 0) {
            //if Stockist state filter exists then load Stockist filter state wise
            let sltdStateId = $('#stockist_state').val();
            let sltdStockistId = $('#stockist').val();
            loadStockistStateWise(sltdStateId, sltdStockistId);
        }

        if ($('#category').length > 0) {
            let cat = $('#category').val();
            let itm = $('#item').val();
            if ((cat != '') && (parseInt(cat) > 0)) {
                loadCatWiseItem(cat, itm);
            }
        }
    });
    $(function () {

        $('#addFilters').select2({
            placeholder: "Select Filters",
            allowClear: true
        });

        $(document).on('select2:select', '#addFilters', function (e) {
            var slctdFilter = e.params.data.id;
            var slctdFilters = (($(this).val() != null) ? $(this).val() : []);
            var newFiltersArr = [];
            if (slctdFilter === "date_range") {
                newFiltersArr = $.grep(slctdFilters, function (value) {
                    return ((value != 'month') && (value != 'year'));
                });

                $(this).val(newFiltersArr).trigger('change');
            }

            if (slctdFilter === "salesman_designation") {
                slctdFilters.push('salesman_manager');
                $(this).val(slctdFilters).trigger('change');
            }

            if (slctdFilter === "salesman_manager") {
                slctdFilters.push('salesman_designation');
                $(this).val(slctdFilters).trigger('change');
            }

            if ((slctdFilter === "month") || (slctdFilter === "year")) {
                newFiltersArr = $.grep(slctdFilters, function (value) {
                    return value != 'date_range';
                });

                if (slctdFilter === "month") {
                    newFiltersArr.push('year');
                }
                if (slctdFilter === "year") {
                    newFiltersArr.push('month');
                }

                $(this).val(newFiltersArr).trigger('change');
            }
        });

        $(document).on('select2:unselect', '#addFilters', function (e) {
            var unslctdFilter = e.params.data.id;
            var slctdFilters = (($(this).val() != null) ? $(this).val() : []);
            var newFiltersArr = [];

            if (unslctdFilter === "date_range") {
                slctdFilters.push('month');
                slctdFilters.push('year');
                $(this).val(slctdFilters).trigger('change');
            }

            if ((unslctdFilter === "month") || (unslctdFilter === "year")) {
                newFiltersArr = $.grep(slctdFilters, function (value) {
                    return ((value != 'month') && (value != 'year'));
                });

                newFiltersArr.push('date_range');
                $(this).val(newFiltersArr).trigger('change');
            }

            if (unslctdFilter === "salesman_designation") {
                newFiltersArr = $.grep(slctdFilters, function (value) {
                    return (value != 'salesman_manager');
                });

                $(this).val(newFiltersArr).trigger('change');
            }

            if (unslctdFilter === "salesman_manager") {
                newFiltersArr = $.grep(slctdFilters, function (value) {
                    return (value != 'salesman_designation');
                });

                $(this).val(newFiltersArr).trigger('change');
            }
        });


        $(document).on("click", "#show_filter", function () {
            var selectedFilters = $("#addFilters").val();
            // console.log(selectedFilters);
            if (selectedFilters.length > 0) {
                $.ajax({
                    url: 'dynamic_filters.php',
                    type: 'POST',
                    async: false,
                    data: {'action': 'add_filter', 'addFilters': selectedFilters},
                    success: function (resp) {

                        if ($.trim(resp) != '') {
                            $(".filter-container").html(resp);
                        }
                    }
                });
            }
        });

        $(document).on("change", "#sal_zone", function () {
            var zoneId = parseInt($(this).val());

            if (zoneId == '') {
                zoneId = 0;
            }

            if ($("#sal_state").length > 0) {
                $.ajax({
                    url: 'ajax_dynamic_filters.php',
                    type: 'POST',
                    async: false,
                    data: {'action': 'getZoneStateList', 'zoneid': zoneId, 'stateFor': 'sal_state'},
                    success: function (resp) {
                        if ($.trim(resp) != '') {
                            if ($("#sal_state").length > 0) {
                                $("#sal_state").html(resp);
                            }
                        }
                    }
                });
            } else if ($("#salesman_manager").length > 0) {
                $.ajax({
                    url: 'ajax_dynamic_filters.php',
                    type: 'POST',
                    async: false,
                    data: {'action': 'getZoneWiseManagerOrHierarchy', 'zoneid': zoneId},
                    success: function (resp) {
                        if ($.trim(resp) != '') {
                            if ($('#salesman_manager').length > 0) {
                                $("#salesman_manager").html(resp);
                            } else {
                                $("#sal").html(resp);
                            }
                        }
                    }
                });
            } else if ($("#sal").length > 0) {
                $.ajax({
                    url: 'ajax_dynamic_filters.php',
                    type: 'POST',
                    async: false,
                    data: {'action': 'getZoneWiseManagerOrHierarchy', 'zoneid': zoneId},
                    success: function (resp) {
                        if ($.trim(resp) != '') {
                            $("#sal").html(resp);
                        }
                    }
                });
            }

        });


        $(document).on('change', "#sal_state", function () {
            var selectedsal_state = $(this).val();
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'sal_state', 'st_id': selectedsal_state},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        if ($('#salesman_manager').length > 0) {
                            $("#salesman_manager").html(resp);
                        } else {
                            $("#sal").html(resp);
                        }

                        $('#salesman_designation').val('');
                    }
                }
            });

            if ($("#city").length > 0) {
                var selectsalStateId = $(this).val();

                $.ajax({
                    url: 'ajax_dynamic_filters.php',
                    type: 'POST',
                    async: false,
                    data: {'action': 'city', 'c_id': selectsalStateId},
                    success: function (resp) {
                        if ($.trim(resp) != '') {
                            $("#city").html(resp);
                        }
                    }
                });
            }
        });

        $(document).on("change", "#salesman_manager", function () {
            var selectedMngrId = parseInt($(this).val());
            // if (selectedMngrId > 0) {
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'getBottomUsers', 'selectedMngrId': selectedMngrId},
                success: function (resp) {
                    $("#sal").html(resp);
                }
            });
            // }
        });


        $(document).on("change", "#ret_zone", function () {
            var zoneId = parseInt($(this).val());
            if (zoneId == '') {
                zoneId = 0;
            }

            if ($("#ret_state").length > 0) {
                $.ajax({
                    url: 'ajax_dynamic_filters.php',
                    type: 'POST',
                    async: false,
                    data: {'action': 'getZoneStateList', 'zoneid': zoneId, 'stateFor': 'ret_state'},
                    success: function (resp) {

                        if ($.trim(resp) != '') {
                            $("#ret_state").html(resp);
                        }
                    }
                });
            } else if ($("#ret").length > 0) {
                $.ajax({
                    url: 'ajax_dynamic_filters.php',
                    type: 'POST',
                    async: false,
                    data: {'action': 'getZoneWiseRetailers', 'zoneid': zoneId},
                    success: function (resp) {
                        if ($.trim(resp) != '') {
                            $("#ret").html(resp);
                        }
                    }
                });
            }
        });

        $(document).on('change', "#ret_state", function () {
            var selectedret_state = $("#ret_state").val();
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'ret_state', 'st_id': selectedret_state},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        $("#ret").html(resp);
                    }
                }
            });
        });


        $(document).on("change", "#dis_zone", function () {
            var zoneId = parseInt($(this).val());

            if (zoneId == '') {
                zoneId = 0;
            }
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'getZoneStateList', 'zoneid': zoneId, 'stateFor': 'dis_state'},
                success: function (resp) {

                    if ($.trim(resp) != '') {
                        $("#dis_state").html(resp);
                    }
                }
            });
        });

        $(document).on('change', "#dis_state", function () {
            var selectedDistStateId = $(this).val();
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'dis_state', 'st_id': selectedDistStateId},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        $("#dis").html(resp);
                    }
                }
            });
        });

        $(document).on("change", "#stockist_zone", function () {
            var zoneId = parseInt($(this).val());
            if (zoneId == '') {
                zoneId = 0;
            }

            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'getZoneStateList', 'zoneid': zoneId, 'stateFor': 'stockist_state'},
                success: function (resp) {

                    if ($.trim(resp) != '') {
                        $("#stockist_state").html(resp);
                    }
                }
            });

        });

        $(document).on('change', "#stockist_state", function () {
            var selectedStockistStateId = $(this).val();
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'stockist_state', 'st_id': selectedStockistStateId},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        $("#stockist").html(resp);
                    }
                }
            });
        });
        $(document).on('change', "#category", function () {
            var selectCategoryId = $(this).val();
            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {'action': 'category', 'c_id': selectCategoryId},
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        $("#item").html(resp);
                    }
                }
            });
        });

        $(document).on('change', "#salesman_designation", function () {
            var selectdSalDesigId = $(this).val();
            var selectdStateId = ($('#sal_state').length > 0) ? $('#sal_state').val() : '';

            $.ajax({
                url: 'ajax_dynamic_filters.php',
                type: 'POST',
                async: false,
                data: {
                    'action': 'getDesignationWiseSalesman',
                    'designationId': selectdSalDesigId,
                    'selectdStateId': selectdStateId
                },
                success: function (resp) {
                    if ($.trim(resp) != '') {
                        if ($('#salesman_manager').length > 0) {
                            $("#salesman_manager").html(resp);
                        } else {
                            $("#sal").html(resp);
                        }
                    }
                }
            });
        });


        $(document).on('select2:select', '#order_category', function (e) {
            var slctdFilter = e.params.data.id;
            var slctdFilters = (($(this).val() != null) ? $(this).val() : []);
            var newFiltersArr = [];

            console.log(slctdFilters);

            if (slctdFilter === "all") {
                newFiltersArr = $.grep(slctdFilters, function (value) {
                    return ((value != 'no') && (value != 'yes') && (value != 'adhoc'));
                });
                $(this).val(newFiltersArr).trigger('change');
            }
            if ((slctdFilter === 'no') || (slctdFilter === 'yes') || (slctdFilter === 'adhoc')) {
                newFiltersArr = $.grep(slctdFilters, function (value) {
                    return value != 'all';
                });

                // if (slctdFilter === '9') {
                //     newFiltersArr.push('8');
                // }
                $(this).val(newFiltersArr).trigger('change');
            }
        });
    });
</script>