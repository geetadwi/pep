<!--  start message-red -->

<!--  end message-red -->
<!-- start id-form -->
<script type="text/javascript">
   $(document).on('click', '.s-inte',function(e){
    e.preventDefault();
    var formData = new FormData( $("#frmPre")[0] );
      //  var uploadedFile = document.getElementById('file_1').files[0];
        $.ajax({
            url: "deleteuploadedfile.php",
            type: "POST",
            data:  formData,
         //   data: { "fileToUpload": uploadedFile },
            contentType: false,
            cache: false,
            processData:false,
            beforeSend:function(){
     return confirm("Are you sure you want to delete?");
},
            success: function(data)
            {
              $("#message-greenshow").html(data);
              $("#message-greenshow").show().fadeOut(6000);
               // window.location = 'checkuploadedfile.php';
                //alert(data);
                setTimeout(function() {
    location.reload();
}, 2000);
           // $("#targetLayer").html(data);
                      //  $("#errorLayer").html(data);
            },
            error: function() 
            {
            }           
       });
});



</script>
<style>
.dt-input{
  border-top: 2px solid #ddd;
    border-color: #ddd;
    border-left: 2px solid #ddd;
    border: 2px solid #ddd;
}
  </style>
 <script>
function shwhide(){
$("#message-red").hide();

}
      function checkall(){

        if ($('.chk_boxes1:checked').length == $('.chk_boxes1').length) {
      $('.chk_boxes1').prop('checked', false);
    }
    else {
      $('.chk_boxes1').prop('checked', true);
    }
      }

      $(document).on('click', '.select-allintege',function(e){
    e.preventDefault();
    var formData = new FormData( $("#frmPre")[0] );
      //  var uploadedFile = document.getElementById('file_1').files[0];
        $.ajax({
            url: "deletealluploadedfile.php",
            type: "POST",
            data:  formData,
         //   data: { "fileToUpload": uploadedFile },
            contentType: false,
            cache: false,
            processData:false,
            beforeSend:function(){
     return confirm("Are you sure you want to delete complete data?");
},
            success: function(data)
            {
              $("#message-greenshow").html(data);
              $("#message-greenshow").show().fadeOut(6000);
               // window.location = 'checkuploadedfile.php';
                //alert(data);
                setTimeout(function() {
    location.reload();
}, 2000);
           // $("#targetLayer").html(data);
                      //  $("#errorLayer").html(data);
            },
            error: function() 
            {
            }           
       });
});
    </script>
<div class="inner-container">
<div id="message-greenshow" style="margin-bottom: 15px; display:none">
                
            </div>
            <?php  include("retailer/import_retailerwiseedit_scheme.php"); ?>
            <div class="inner-container">
<form name="frmPre" id="frmPre" method="post" action="view_uploaded_retailerscheme.php" enctype="multipart/form-data">
   
    <?php 
    
    $retRecc = $_objAdmin->_getSelectList2('table_discount_party as p left join table_retailer as r on r.retailer_id=p.retailer_id', "r.retailer_name, r.retailer_id", '', " p.discount_id='" . $_REQUEST['id'] . "' and p.retailer_id>0");
   
    $total_product=count($retRecc);
        ?>
       <p>  <strong> Customer Count : <?php echo count($retRecc); ?></strong></p><br>
       <?php
    if(count($retRecc)>0){ ?>
         <span name="btn_checkall" class="select-allintege btn btn-success" style="margin-bottom:10px;">Delete all</span>
         <span name="btn_checkall" class="select-inte btn btn-success" style="margin-bottom:10px;" onclick="checkall()">Select all</span>
        <br>
        
<table class="table table-bordered" id="datatbl">
    <thead>
      <tr>
        <th>Option</th>
        <th>Retailer</th>
       
      </tr>
    </thead>
    <tbody>
    <?php  
  $orderRec = mysqli_query($con, "SELECT r.retailer_name, r.retailer_id from table_discount_party as p left join table_retailer as r on r.retailer_id=p.retailer_id where p.discount_id='" . $_REQUEST['id'] . "' order by discount_id desc  ");
           $retRec=mysqli_num_rows($orderRec);
    while( $achievedRec = mysqli_fetch_array($orderRec)){
                                         ?>
                                     
      <tr>
        <td><input name="checkbox[]" type="checkbox" class="chk_boxes1" value="<?php echo $achievedRec['retailer_id'] ; ?>"></td>
        <td><?php echo $achievedRec['retailer_name']; ?> (<?php echo $achievedRec['retailer_id'] ; ?>)</td>
       <input type="hidden" name="discountid" value="<?php echo $_REQUEST['id']; ?>">
      </tr>
   <?php  } ?>

   
                                     
    </tbody>
  </table> 
  <p><strong>Total:</strong> <?php echo $total_product;?></p>
  <a href="" class="s-inte btn btn-danger">Remove </a>
  <?php } ?>
    </form>
</div>

          </div>