<?php

include("includes/config.inc.php");

include("includes/function.php");

$page_name="Scheme Wise Report";

$_objAdmin = new Admin();



if(isset($_POST['showReport']) && $_POST['showReport'] == 'yes')

{	

	if($_REQUEST['sal']!="") 

	{

	$sal_list=$_REQUEST['sal'];

	//$sal_id=$_REQUEST['sal'];

	$sal_query=" AND o.salesman_id='".$sal_list."' ";

	}

	if($_REQUEST['from']!="") 

	{

	$from_date=date('Y-m-d', strtotime($_REQUEST['from']));	

	}

	if($_REQUEST['to']!="") 

	{

	$to_date=date('Y-m-d', strtotime($_REQUEST['to']));	

	}

} else {

$from_date= date("Y-m-d",strtotime("-1 day"));

$to_date= date("Y-m-d",strtotime("-1 day"));

}

if($_REQUEST['sal']!=''){

$SalName=$_objAdmin->_getSelectList('table_salesman','salesman_name',''," salesman_id='".$_REQUEST['sal']."'"); 

$sal_name=$SalName[0]->salesman_name;

} else {

$sal_name="All ".$AliaseUsers['salesman'];

}



$order_by_amt="desc";

$order_by_qty="desc";

$List= "total_amt ".$order_by_amt;



if(isset($_POST['order_qty']) && $_POST['order_qty'] == 'yes')

{

	if($_REQUEST['order_by_qty']=='desc'){

	$order_by_qty="asc";

	$order_by_amt="asc";

	$List="total_qty ".$order_by_qty;

	} else {

	$order_by_qty="desc";

	$order_by_amt="desc";

	$List="total_qty ".$order_by_qty;

	}

}



if(isset($_POST['order_amt']) && $_POST['order_amt'] == 'yes')

{

	if($_REQUEST['order_by_amt']=='desc'){

	$order_by_amt="asc";

	$order_by_qty="asc";

	$List= "total_amt ".$order_by_amt;

	} else {

	$order_by_amt="desc";

	$order_by_qty="desc";

	$List= "total_amt ".$order_by_amt;

	}	

}

?>

<?php include("header.inc.php") ?>

<!-- start content-outer -->

<script src="javascripts/dateNextPrev.js" type="text/javascript"></script>

<script type="text/javascript">



    // function PrintElem(elem)
    //
    // {
    //
    //     Popup($(elem).html());
    //
    // }



    //function Popup(data)
    //
    //{
    //
	//
    //
    //    var mywindow = window.open('', 'Report');
    //
	//
    //
    //    mywindow.document.write('<html><head><title>Scheme Wise Report</title>');
    //
	//	mywindow.document.write('<table><tr><td><b>Salesman Name:</b> <?php //echo $sal_name; ?>//</td><td><b>From Date:</b> <?php //echo $_objAdmin->_changeDate($from_date); ?>//</td><td><b>To Date:</b> <?php //echo $_objAdmin->_changeDate($to_date); ?>//</td></tr></table>');
    //
    //    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    //
    //    mywindow.document.write('</head><body >');
    //
    //    mywindow.document.write(data);
    //
    //    mywindow.document.write('</body></html>');
    //
    //
    //
    //    mywindow.print();
    //
    //    mywindow.close();
    //
    //    return true;
    //
    //}

$(document).ready(function() {

    

   <?php 

   if($_POST['submit']=='Export to Excel'){?>

  tableToExcel('report_export', 'Scheme Wise Report', 'Scheme Wise Report.xls');



   <?php } ?> 



	

});		

	

	$(document).ready(function(){

		$('.maintr').click(function() {

			//alert("Hello");

		$('#lists tr').removeClass('trbgcolor');	

		$(this).addClass('trbgcolor');

		});

	});

	

	$(document).keydown(function(e) {

		//alert(e);

		if(e.keyCode==113){

			var id = $('.trbgcolor input').val();

			var from = document.getElementById('from').value;

			var to = document.getElementById('to').value;

			var sal = document.getElementById('sal').value;

			if(typeof id!='undefined')

			//alert(to); 

			window.open("scheme_salesman_report.php?id="+id+"&from="+from+"&to="+to+"&sal="+sal, '_blank');

			else 

			alert('Please Select One Record');

			}

		if(e.keyCode==114){

			var id = $('.trbgcolor input').val();

			var from = document.getElementById('from').value;

			var to = document.getElementById('to').value;

			var sal = document.getElementById('sal').value;

			if(typeof id!='undefined')

			//alert(to); 

			window.open("scheme_retailer_report.php?id="+id+"&from="+from+"&to="+to+"&sal="+sal, '_blank');

			else 

			alert('Please Select One Record');

			}

		});

</script>

<style>

	.font-bold td {

		font-weight: 500;

		font-size: 14px;

		line-height: 16px !important

	}

</style>

<aside class="right-side">

    <section class="content-header">

        <h1>Scheme Wise Report</h1>

    </section>

    <section class="content">

        <div class="inner-contenr">

            <form name="frmPre" id="frmPre" method="post" action="" enctype="multipart/form-data" class="row">

                <div class="form-group col-sm-4">

                    <label><?php echo $AliaseUsers['salesman'];  ?> Name</label>

                    <div class="clearfix">

                        <select name="sal" id="sal" class="menulist form-control">

                            <option value="" >All <?php echo $AliaseUsers['salesman'];  ?></option>

                            <?php $aSal=$_objAdmin->_getSelectList('table_salesman as s  
                            LEFT JOIN table_salesman_hierarchy_relationship AS SH ON SH.salesman_id = s.salesman_id
							LEFT JOIN table_salesman_hierarchy AS H ON H.hierarchy_id = SH.hierarchy_id
                            ','s.*,H.description AS desig','',"s.status='A' ORDER BY s.salesman_name");

                            if(is_array($aSal)){

                                for($i=0;$i<count($aSal);$i++){

                                    ?>

                                    <option value="<?php echo $aSal[$i]->salesman_id;?>" <?php if ($aSal[$i]->salesman_id==$sal_list){ ?> selected <?php } ?>><?php echo ucwords(strtolower($aSal[$i]->salesman_name));?>&nbsp  <?php echo '('.$aSal[$i]->employee_code.'-'.ucwords(strtolower($aSal[$i]->desig)).')'; ?></option>

                                <?php } }?>

                        </select>

                    </div>

                </div>

                <div class="form-group col-sm-4">

                    <label>From Date</label>

                    <div class="calendar flex">

                        <span class="btn btn-primary" onclick="dateFromPrev();"><i class="fa fa-angle-left" aria-hidden="true"></i></span>

                        <input type="text" id="from" name="from" class="date form-control" value="<?php  echo $_objAdmin->_changeDate($from_date); ?>"  readonly />

                        <span class="btn btn-primary" onclick="dateFromNext();"><i class="fa fa-angle-right" aria-hidden="true"></i></span>

                    </div>

                </div>

                <div class="form-group col-sm-4">

                    <label>To Date</label>

                    <div class="calendar flex">

                        <span class="btn btn-primary" onclick="dateToPrev();"><i class="fa fa-angle-left" aria-hidden="true"></i></span>

                        <input type="text" id="to" name="to" class="date form-control" value="<?php echo $_objAdmin->_changeDate($to_date); ?>"  readonly />

                        <span class="btn btn-primary" onclick="dateToNext();"><i class="fa fa-angle-right" aria-hidden="true"></i></span>

                    </div>

                </div>

                <div class="col-sm-12 text-center form-group">

                    <input name="showReport" type="hidden" value="yes" />

                    <input name="submit" class="btn btn-success" type="submit" id="submit" value="View Details" />

                    <input type="button" value="Reset!" class="btn btn-danger" onclick="location.href='scheme_report.php?reset=yes';" />

<!--                    <input type="button" value="Print" class="btn btn-info" onclick="PrintElem('#Report')" />-->

                    <input input type="submit" name="submit" value="Export to Excel" class="btn btn-primary export"  >

                    <a id="dlink"  style="display:none;"></a>

                </div>

            </form>

            Press F2 to Check <?php echo $AliaseUsers['salesman'];  ?> Wise Breakup of Scheme<br />

            Press F3 to Check <?php echo $AliaseUsers['retailer'];  ?> Wise Breakup of Scheme<br /><br />

            <div id="Report">

                <?php

                $Rec = mysqli_query($_objAdmin->db_connect_id,"SELECT Count(distinct total.order_id) as total_order,sum(total.qty) as total_qty,
				sum(total.amt) as total_amt, Count(distinct total.retailer_id) as total_ret, total.dis, d.discount_desc, 
				d.discount_type, d.discount_amount, f.free_qty from (SELECT o.order_id, o.acc_discount_id as dis,
				o.acc_free_item_qty as qty, o.acc_discount_amount as amt, o.salesman_id, o.retailer_id 
				FROM table_order as o left join table_retailer as r on o.retailer_id=r.retailer_id 
				WHERE o.account_id='".$_SESSION['accountId']."' and o.order_type != 'No' and r.new='' and 
				o.acc_discount_id!='' and (o.date_of_order BETWEEN '".$from_date."' AND '".$to_date."') $sal_query 
				Group by o.order_id 
				union all SELECT o.order_id, d.acc_discount_id as dis,d.acc_free_item_qty as qty, 
				d.acc_discount_amount as amt, o.salesman_id, o.retailer_id FROM table_order as o 
				inner join table_order_detail as d on o.order_id=d.order_id left join table_retailer as r on 
				o.retailer_id=r.retailer_id WHERE o.account_id='".$_SESSION['accountId']."' and o.order_type != 'No' and 
				r.new='' and d.acc_discount_id!='' and (o.date_of_order BETWEEN '".$from_date."' AND '".$to_date."') 
				$sal_query 
				union all SELECT o.order_id, c.acc_discount_id as dis, c.acc_free_item_qty as qty, 
				c.acc_discount_amount as amt, o.salesman_id, o.retailer_id FROM table_order as o 
				inner join table_order_combo_detail as c on c.order_id=o.order_id left join table_retailer as r on 
				o.retailer_id=r.retailer_id WHERE o.account_id='".$_SESSION['accountId']."' and c.acc_discount_id!='' 
				and (o.date_of_order BETWEEN '".$from_date."' AND '".$to_date."') and o.order_type != 'No' and 
				r.new='' $sal_query ) as total left join table_discount_detail as d on d.discount_id=total.dis 
				left join table_foc_detail as f on f.foc_id=d.foc_id Group by total.dis ORDER BY total_order desc") or die(mysqli_error($_objAdmin->db_connect_id));

                $num = mysqli_num_rows($Rec);

                if($num > 0){?>

                <table class="table table-bordered" id="lists">

                    <?php

                        $i=0;

                        $total_Retailer=array();

                        $total_order=array();

                        $total_dis=array();

                        ?>

                        <tr class="font-weight">

                            <td width="5%">SNO.</td>

                            <td width="55%">Schemes</td>

                            <td width="10%">Total</td>

                            <!--<td style="padding:10px;" width="10%">Total In Order</td>-->

                            <td width="20%">Total Sold to (No of <?php echo $AliaseUsers['retailer'];  ?>)</td>

                        </tr>

                        <?php

                        while ($auRec = mysqli_fetch_array($Rec)){

                            $i++;

                            ?>

                            <tr class="maintr">

                                <td width="5%"><?php echo $i; ?></td>

                                <td width="55%"><?php echo $auRec['discount_desc'];?></td>

                                <td width="10%">

                                    <?php

                                    if($auRec['discount_type']==1){
                                        $total_discount=$auRec['total_order'];
                                    }

                                    if($auRec['discount_type']==2){

                                        $total_discount=round($auRec['total_amt']/$auRec['discount_amount'],1);

                                    }

                                    if($auRec['discount_type']==3){

                                        $total_discount= round($auRec['total_qty']/$auRec['free_qty'],1);

                                    }

                                    echo floatval($total_discount);

                                    $total_dis[]=$total_discount;

                                    ?>

                                </td>

                                <!--<td style="padding:10px;" width="10%"><?php echo $auRec['total_order']; $total_order[]=$auRec['total_order'] ;?></td>-->

                                <td width="20%"><?php echo $auRec['total_ret']; $total_Retailer[]=$auRec['total_ret']; ?></td>

                                <input type="hidden" id="<?php echo $i+1; ?>" value="<?php echo $auRec['dis'];;?>">

                            </tr>

                        <?php } ?>

                        <tr>

                            <td colspan="2" align="right">Total</td>

                            <td width="10%"><?php echo array_sum($total_dis);?></td>

                            <!--<td style="padding:10px;" width="10%"><?php// echo array_sum($total_order);?></td>-->

                            <td width="20%"><?php echo array_sum($total_Retailer);?></td>

                        </tr>

                    </table>

                <?php } else { ?>

                   <div class="alert alert-danger text-center">

                       Report Not Available

                   </div>

                <?php }  ?>

            </div>

        </div>

    </section>

</aside>

            <!-- start footer -->

<?php include("footer.php") ?>

<!-- end footer -->

 <script src="javascripts/jquery-1.8.2.js" type="text/javascript"></script>

<script src="javascripts/jquery-ui.js"></script>

<script type="text/javascript" src="javascripts/validate.js"></script>

<script type="text/javascript">

// Popup window code

function newPopup(url) {

	popupWindow = window.open(

		url,'popUpWindow','height=500,width=600,left=200,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')

}

</script>

<script>

    $(function() {

        $( "#from" ).datepicker({

			dateFormat: "d M yy",

            defaultDate: "w",

            changeMonth: true,

            numberOfMonths: 1,

            onSelect: function( selectedDate ) {

                $( "#to" ).datepicker( "option", "minDate", selectedDate );

            }

        });

        $( "#to" ).datepicker({

			dateFormat: "d M yy",

            defaultDate: "-w",

            changeMonth: true,

            numberOfMonths: 1,

            onSelect: function( selectedDate ) {

                $( "#from" ).datepicker( "option", "maxDate", selectedDate );

            }

        });

    });

</script>

<script type='text/javascript'>//<![CDATA[ 

var tableToExcel = (function () {

        var uri = 'data:application/vnd.ms-excel;base64,'

        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table><tr><td><b><?php echo $AliaseUsers['salesman'];?> Name:</b> <?php echo $sal_name; ?></td><td><b>From Date:</b> <?php echo $_objAdmin->_changeDate($from_date); ?></td><td><b>To Date:</b> <?php echo $_objAdmin->_changeDate($to_date); ?></td></tr></table><table>{table}</table></body></html>'

        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }

        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }

        return function (table, name, filename) {

            if (!table.nodeType) table = document.getElementById(table)

            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }



            document.getElementById("dlink").href = uri + base64(format(template, ctx));

            document.getElementById("dlink").download = filename;

            document.getElementById("dlink").click();



        }

    })()



//]]>  

</script>

</body>

</html>