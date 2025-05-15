<?php
include("includes/config.inc.php");
include("includes/function.php");
$page_name = $AliaseUsers['retailer'] . " Wise Breakup of (Scheme) Sold";
$_objAdmin = new Admin();

if ($_REQUEST['id'] != '') {
    $discount_name = $_objAdmin->_getSelectList2('table_discount_detail as d left join table_foc_detail as f on f.foc_id=d.foc_id', 'd.discount_desc, d.discount_type, d.discount_amount, f.free_qty', '', " d.discount_id='" . $_REQUEST['id'] . "'");
}
if ($_REQUEST['sal'] != "") {
    $sal_query = " and o.salesman_id='" . $_REQUEST['sal'] . "' ";
} else {
    $sal_query = " ";
}
if ($_REQUEST['sal'] != '') {
    $SalName = $_objAdmin->_getSelectList('table_salesman', 'salesman_name', '', " salesman_id='" . $_REQUEST['sal'] . "'");
    $sal_name = $SalName[0]->salesman_name;
} else {
    $sal_name = "All Salesman";
}

?>

<?php include("header.inc.php") ?>

<script type="text/javascript">

    // function PrintElem(elem)
    // {
    //     Popup($(elem).html());
    // }

    //function Popup(data)
    //{
    //
    //    var mywindow = window.open('', 'Report');
    //
    //    mywindow.document.write('<html><head><title>Retailer Wise Breakup of (Scheme) Sold</title>');
    //	mywindow.document.write('<table><tr><td><b>Scheme:</b> <?php //echo $discount_name[0]->discount_desc; ?>//</td><td><b>Salesman Name:</b> <?php //echo $sal_name; ?>//</td><td><b>From Date:</b> <?php //echo $_objAdmin->_changeDate($_REQUEST['from']); ?>//</td><td><b>To Date:</b> <?php //echo $_objAdmin->_changeDate($_REQUEST['to']); ?>//</td></tr></table>');
    //    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    //    mywindow.document.write('</head><body >');
    //    mywindow.document.write(data);
    //    mywindow.document.write('</body></html>');
    //
    //    mywindow.print();
    //    mywindow.close();
    //    return true;
    //}

    $(document).ready(function () {
        $('.maintr').click(function () {
            //alert("Hello");
            $('#report_export tr').removeClass('trbgcolor');
            $(this).addClass('trbgcolor');
        });
    });
</script>

<style>
    .font-bold td {
        font-weight: 500;
        font-size: 14px;
        line-height: 16px !important
    }
</style>

<script src="javascripts/dateNextPrev.js" type="text/javascript"></script>
<!-- start content -->
<aside class="right-side">
    <section class="content-header">
        <h1><?php echo $page_name ?></h1>
    </section>
    <section class="content">
        <div class="inner-contenr">
            <table class="table table-bordered">
                <tr>
                    <th valign="top" style="width: 100px; line-height:14px;;" align="left">Scheme:</th>
                    <td align="left" style="min-width: 150px;"><?php echo $discount_name[0]->discount_desc; ?></td>
                </tr>
                <tr>
                    <th valign="top" style="width: 100px; line-height:28px;;"
                        align="left"><?php echo $AliaseUsers['salesman']; ?> Name:
                    </th>
                    <td align="left" style="min-width: 150px;"><?php echo $sal_name; ?></td>
                </tr>
                <tr>
                    <th valign="top" style="width: 100px;line-height: 14px;" align="left">From Date:</th>
                    <td align="left"
                        style="min-width: 150px;"><?php echo $_objAdmin->_changeDate($_REQUEST['from']); ?></td>
                </tr>
                <tr>
                    <th valign="top" style="width: 100px;line-height: 28px;" align="left">To Date:</th>
                    <td align="left"
                        style="min-width: 150px;"><?php echo $_objAdmin->_changeDate($_REQUEST['to']); ?></td>
                </tr>

            </table>

            <?php //if ($_REQUEST['sal'] == "") { ?>
            <!--            <div style="width:1100px;overflow:auto; height:400px;overflow:auto;">-->
            <?php //} else { ?>
            <!--                <div style="width:1100px;overflow:auto; ">-->
            <?php // } ?>

            <?php
            //$Rec = mysql_query("SELECT total.dis,total.retailer_id,r.retailer_name from (SELECT o.order_id,count(o.acc_discount_id) as dis, o.retailer_id, o.salesman_id FROM table_order as o left join table_retailer as r on o.retailer_id=r.retailer_id WHERE o.acc_discount_id='".$_REQUEST['id']."' and r.new='' and (o.date_of_order BETWEEN '".date('Y-m-d', strtotime($_REQUEST['from']))."' AND '".date('Y-m-d', strtotime($_REQUEST['to']))."') $sal_query  Group by o.retailer_id union all SELECT o.order_id, count(d.acc_discount_id) as dis, o.retailer_id, o.salesman_id FROM table_order as o inner join table_order_detail as d on o.order_id=d.order_id left join table_retailer as r on o.retailer_id=r.retailer_id WHERE  d.acc_discount_id='".$_REQUEST['id']."'  and r.new='' and (o.date_of_order BETWEEN '".date('Y-m-d', strtotime($_REQUEST['from']))."' AND '".date('Y-m-d', strtotime($_REQUEST['to']))."') $sal_query Group by o.retailer_id union all SELECT o.order_id, count(c.acc_discount_id) as dis, o.retailer_id, o.salesman_id FROM table_order as o inner join table_order_combo_detail as c on c.order_id=o.order_id left join table_retailer as r on o.retailer_id=r.retailer_id WHERE c.acc_discount_id='".$_REQUEST['id']."' and r.new='' and (o.date_of_order BETWEEN '".date('Y-m-d', strtotime($_REQUEST['from']))."' AND '".date('Y-m-d', strtotime($_REQUEST['to']))."') $sal_query  Group by o.retailer_id) as total left join table_retailer as r on total.retailer_id=r.retailer_id order by total.dis desc");
            $Rec = mysqli_query($con, "SELECT total.dis,total.retailer_id,r.retailer_name, total.qty as total_qty, total.amt as total_amt from (
SELECT o.order_id,count(o.acc_discount_id) as dis, o.retailer_id, o.salesman_id,sum(o.acc_free_item_qty) as qty, sum(o.acc_discount_amount) as amt FROM table_order as o left join table_retailer as r on o.retailer_id=r.retailer_id WHERE o.acc_discount_id='" . $_REQUEST['id'] . "' and r.new='' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') $sal_query  Group by o.retailer_id 
union all 
SELECT o.order_id, count(d.acc_discount_id) as dis, o.retailer_id, o.salesman_id, sum(d.acc_free_item_qty) as qty, sum(d.acc_discount_amount) as amt FROM table_order as o inner join table_order_detail as d on o.order_id=d.order_id left join table_retailer as r on o.retailer_id=r.retailer_id WHERE  d.acc_discount_id='" . $_REQUEST['id'] . "'  and r.new='' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') $sal_query Group by o.retailer_id 
union all 
SELECT o.order_id, count(c.acc_discount_id) as dis, o.retailer_id, o.salesman_id, sum(c.acc_free_item_qty) as qty, sum(c.acc_discount_amount) as amt FROM table_order as o inner join table_order_combo_detail as c on c.order_id=o.order_id left join table_retailer as r on o.retailer_id=r.retailer_id WHERE c.acc_discount_id='" . $_REQUEST['id'] . "' and r.new='' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') $sal_query  Group by o.retailer_id
) as total left join table_retailer as r on total.retailer_id=r.retailer_id order by total.qty desc, total.amt");
            $num = mysqli_num_rows($Rec);
            if ($num > 0) {
                $i = 0;
                $total_order = array();
                ?>
                <div id="Report" class="table-responsive" style="max-height:400px; margin-top: 15px">
                    <table class="table table-bordered" id="report_export" name="report_export" style="margin: 0">
                        <tr bgcolor="#6E6E6E" style="color: #fff;font-weight: bold;">
                            <td style="padding:10px;">
                                <div style="width: 20px;">SNO.</div>
                            </td>
                            <td style="padding:10px;">
                                <div style="width: 125px;"><?php echo $AliaseUsers['retailer']; ?> Name</div>
                            </td>
                            <td style="padding:10px;">
                                <div style="width: 125px;" align="center">Total Schemes Sold</div>
                            </td>
                            <?php
                            $RecTotal = mysqli_query($con, "SELECT max(dis) as max from (SELECT o.order_id,count(o.acc_discount_id) as dis, o.retailer_id FROM table_order as o left join table_retailer as r on o.retailer_id=r.retailer_id WHERE o.acc_discount_id='" . $_REQUEST['id'] . "' and r.new='' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') $sal_query Group by o.retailer_id union all SELECT o.order_id, count(d.acc_discount_id) as dis, o.retailer_id FROM table_order as o inner join table_order_detail as d on o.order_id=d.order_id left join table_retailer as r on o.retailer_id=r.retailer_id WHERE  d.acc_discount_id='" . $_REQUEST['id'] . "'  and r.new='' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') $sal_query Group by o.retailer_id union all SELECT o.order_id, count(c.acc_discount_id) as dis, o.retailer_id FROM table_order as o inner join table_order_combo_detail as c on c.order_id=o.order_id left join table_retailer as r on o.retailer_id=r.retailer_id WHERE c.acc_discount_id='" . $_REQUEST['id'] . "' and r.new='' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') $sal_query Group by o.retailer_id) as total left join table_retailer as r on total.retailer_id=r.retailer_id order by total.dis desc");
                            $net = mysqli_fetch_array($RecTotal);
                            for ($a = 0; $a < $net['max']; $a++) {
                                ?>
                                <td style="padding:10px;">
                                    <div style="width: 100px;" align="center">Date of Order</div>
                                </td>
                                <td style="padding:10px;" align="center"><?php echo $AliaseUsers['salesman']; ?></td>
                            <?php } ?>
                        </tr>
                        <?php
                        while ($auRec = mysqli_fetch_array($Rec)) {
                            $i++;
                            ?>
                            <tr class="maintr" style="border-bottom:2px solid #6E6E6E;">
                                <td style="padding:10px;" width="5%"><?php echo $i; ?></td>
                                <td style="padding:10px;" width="20%"><?php echo $auRec['retailer_name']; ?></td>
                                <td style="padding:10px;" width="15%" align="center">
                                    <?php
                                    if ($discount_name[0]->discount_type == 1) {
                                        $total_discount = $auRec['dis'];
                                    }
                                    if ($discount_name[0]->discount_type == 2) {
                                        $total_discount = round($auRec['total_amt'] / $discount_name[0]->discount_amount, 1);
                                    }
                                    if ($discount_name[0]->discount_type == 3) {
                                        $total_discount = round($auRec['total_qty'] / $discount_name[0]->free_qty, 1);
                                    }
                                    echo $total_discount;

                                    $total_order[] = $total_discount;
                                    //	echo $auRec['total_qty']; $total_order[]=$auRec['total_qty'];
                                    ?>
                                    <?php //echo $auRec['dis']; $total_order[]=$auRec['dis'];
                                    ?>
                                </td>
                                <input type="hidden" id="<?php echo $i + 1; ?>"
                                       value="<?php echo $auRec['dis']; ?>">
                                <?php
                                $total_ret = array();
                                $Ret = mysqli_query($con, "SELECT total.date_of_order,total.order_id,total.salesman_name from (SELECT o.order_id,o.date_of_order,s.salesman_name FROM table_order as o left join table_salesman as s on o.salesman_id=s.salesman_id WHERE o.acc_discount_id='" . $_REQUEST['id'] . "' and o.retailer_id='" . $auRec['retailer_id'] . "' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') union all SELECT o.order_id,o.date_of_order,s.salesman_name FROM table_order as o inner join table_order_detail as d on o.order_id=d.order_id left join table_salesman as s on o.salesman_id=s.salesman_id WHERE d.acc_discount_id='" . $_REQUEST['id'] . "' and o.retailer_id='" . $auRec['retailer_id'] . "' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "') union all SELECT o.order_id,o.date_of_order,s.salesman_name FROM table_order as o inner join table_order_combo_detail as c on c.order_id=o.order_id left join table_salesman as s on o.salesman_id=s.salesman_id WHERE c.acc_discount_id='" . $_REQUEST['id'] . "' and o.retailer_id='" . $auRec['retailer_id'] . "' and (o.date_of_order BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['from'])) . "' AND '" . date('Y-m-d', strtotime($_REQUEST['to'])) . "')) as total");
                                while ($auRet = mysqli_fetch_array($Ret)) {
                                    ?>
                                    <td style="padding:10px;" bgcolor="#98FB98">
                                        <div style="width: 100px;"
                                             align="center"><?php echo $_objAdmin->_changeDate($auRet['date_of_order']);
                                            $total_ret[] = $auRet['order_id'] ?></div>
                                    </td>
                                    <td style="padding:10px;"><?php echo $auRet['salesman_name']; ?></td>
                                <?php } ?>
                                <?php for ($c = 0; $c < $net['max'] - count($total_ret); $c++) { ?>
                                    <td style="padding:10px;" bgcolor="#98FB98">
                                        <div style="width: 100px;" align="center"></div>
                                    </td>
                                    <td style="padding:10px;"></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        <tr bgcolor="#6E6E6E" style="color: #fff;font-weight: bold;">
                            <td style="padding:10px;" colspan="2" align="right">Total</td>
                            <td style="padding:10px;" width="15%">
                                <?php echo array_sum($total_order); ?>
                            </td>
                            <td style="padding:10px;" width="20%"></td>
                            <td style="padding:10px;" colspan="<?php echo $net['max'] * 2 - 1; ?>"></td>
                        </tr>
                    </table>
                </div>
                <div style="margin-top: 15px">
                    <input type="button" value="Close" class="form-cen" onclick="javascript:window.close();"/>
                    <a id="dlink" style="display:none;"></a>
                    <input input type="button" value="Export to Excel" class="result-submit"
                           onclick="tableToExcel('report_export', 'Retailer Wise Breakup of (Scheme) Sold', 'Retailer Wise Breakup of (Scheme) Sold.xls')">
                </div>

            <?php } else { ?>
                <div class="alert alert-danger text-center" style="margin-top: 15px">
                    Report Not Available
                </div>
            <?php } ?>
        </div>
    </section>
</aside>
<!-- start footer -->
<?php include("footer.php") ?>
<?php unset($_SESSION['SalAttList']); ?>
<!-- end footer -->
<script src="javascripts/jquery-1.8.2.js" type="text/javascript"></script>
<script src="javascripts/jquery-ui.js"></script>
<script type="text/javascript" src="javascripts/validate.js"></script>
<script type="text/javascript">
    // Popup window code
    function newPopup(url) {
        popupWindow = window.open(
            url, 'popUpWindow', 'height=500,width=600,left=200,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
    }
</script>
<script>
    $(function () {
        $("#from").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: "w",
            changeMonth: true,
            numberOfMonths: 1,
            onSelect: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: "-w",
            changeMonth: true,
            numberOfMonths: 1,
            onSelect: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>
<script type='text/javascript'>//<![CDATA[ 
    var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
            ,
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table><tr><td><b>Scheme:</b></td><td> <?php echo $discount_name[0]->discount_desc; ?></td><td><b><?php echo $AliaseUsers['salesman'];?> Name:</b> <?php echo $sal_name; ?></td><td><b>From Date:</b> <?php echo $_objAdmin->_changeDate($_REQUEST['from']); ?></td><td><b>To Date:</b> <?php echo $_objAdmin->_changeDate($_REQUEST['to']); ?></td></tr></table><table>{table}</table></body></html>'
            , base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            }
            , format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
                    return c[p];
                })
            }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()

    //]]>
</script>
</body>
</html>