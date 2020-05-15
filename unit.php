<?php

include_once "core/config.php";
include_once "page/header.php";

?>


<div id="unit">

            <h3 class="col-12" style="text-align: right;">معلومات الوحدة</h3><br>
    
    <?php
    
    $unit_id = $_GET['id'];
    
    $sql_unit = "SELECT * FROM units WHERE id='$unit_id'";
    $query_unit = mysqli_query($connect, $sql_unit);
    $row_unit = mysqli_fetch_array($query_unit);
    $renter_id = $row_unit['renter_id'];
    $renting_price = $row_unit['renting_price'];
    $contract_image = $row_unit['contract_image'];
    $id_image = $row_unit['id_image'];
    $mandate_image = $row_unit['mandate_image'];
    
    $sql_renter = "SELECT * FROM renters WHERE id='$renter_id'";
    $query_renter = mysqli_query($connect, $sql_renter);
    $row_renter = mysqli_fetch_array($query_renter);
    $renter_name = $row_renter['name'];
    $renter_phone_number = $row_renter['phone_number'];
    
    $sql_payments = "SELECT * FROM units_payments WHERE unit_id = '$unit_id'";
    $query_payments = mysqli_query($connect, $sql_payments);
    $rows_payments = mysqli_num_rows($query_payments);
    
    
    ?>
    
<form id="unitInformationForm" name="editunitInfo" class="col-sm-12 col-md-9 col-lg-6" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id']; ?>" >
   <div class="form-group">
    <label>اسم التاجر</label>
    <input type="text" class="form-control" name="renter_name" value="<? echo $renter_name;?>">
  </div>
   <div class="form-group">
    <label>رقم الهوية</label>
    <input type="text" class="form-control" name="renter_SSN" value="<? echo $renter_id; ?>">
  </div>
    
  <div class="form-group">
    <label>رقم الهاتف</label>
    <input type="text" class="form-control" name="renter_phone_number" value="<? echo $renter_phone_number; ?>">
  </div>
      <div class="form-group">
    <label>قيمة الإيجار</label>
    <input type="text" class="form-control" name="renting_price" value="<? echo $renting_price; ?>">
  </div>
     <div class="form-group">
    <label>عدد الدفعات</label>
    <select class="form-control" id="paymentsNumber" name="payments_number">
        <option value="1" <? echo $rows_payments == 1 ? 'selected':'' ?>>دفعة</option>
        <option value="2" <? echo $rows_payments == 2 ? 'selected':'' ?>>دفعتين</option>
        <option value="3" <? echo $rows_payments == 3 ? 'selected':'' ?>>3 دفعات</option>
        <option value="4" <? echo $rows_payments == 4 ? 'selected':'' ?>>4 دفعات</option>
        <option value="5" <? echo $rows_payments == 5 ? 'selected':'' ?>>5 دفعات</option>
        <option value="6" <? echo $rows_payments == 6 ? 'selected':'' ?>>6 دفعات</option>
        <option value="7" <? echo $rows_payments == 7 ? 'selected':'' ?>>7 دفعات</option>
        <option value="8" <? echo $rows_payments == 8 ? 'selected':'' ?>>8 دفعات</option>
        <option value="9" <? echo $rows_payments == 9 ? 'selected':'' ?>>9 دفعات</option>
        <option value="10" <? echo $rows_payments == 10 ? 'selected':'' ?>>10 دفعات</option>
         </select>
         
         <div id="payment" class="form-group payment col-sm-12">
             <?php
    
    
             $i = 0;
                 while($row_payments = mysqli_fetch_array($query_payments)){
                 
                 $row_payments_price = $row_payments['payment_price'];
                 $row_payments_order = $row_payments['payment_order'];
                 $row_payments_due_date = $row_payments['due_date'];
                    
                    $payment_order = $i + 1;
                 ?>
             
             <label class="title">دفعة رقم <? echo $row_payments_order; ?> </label>
             <div class="paymentFeild col-sm-5">
                 <label>قيمة الدفعة</label>
                 <input type="text" class="form-control" name="payment_<? echo $payment_order; ?>_price" value="<? echo $row_payments_price;?>">
             </div>
             <div class="paymentFeild col-sm-5">
                 <label>تاريخ إنتهاء الدفعة</label>
                 <input type="date" placeholder="yy/mm/dd" name="payment_<? echo $payment_order;?>_due_date" class="form-control" value="<? echo $row_payments_due_date;?>">
             </div>
             
             <?php
                     
                     $i++;
             }
                 ?>
         </div>
         
         <script type="text/javascript">
         
             
         document.getElementById("paymentsNumber").addEventListener("change",function(){
             
             let paymentsNumberElement = document.getElementById("paymentsNumber");
             
             document.querySelector('.payment').innerText = "";
             
             let paymentsElements = "";
             
             for(let i=0; i<paymentsNumberElement.value; i++){
                                  
                 paymentsElements += `
             <label class="title">دفعة رقم ${(i+1)} </label>
             <div class="paymentFeild col-sm-5">
                 <label>قيمة الدفعة</label>
                 <input type="text" class="form-control" name="payment_${(i+1)}_price">
             </div>
             <div class="paymentFeild col-sm-5">
                 <label>تاريخ إنتهاء الدفعة</label>
                 <input type="date" placeholder="yy/mm/dd" class="form-control" name="payment_${(i+1)}_due_date" >
             </div>`;
                 
             }
             
             document.querySelector('#payment').innerHTML = paymentsElements;
         })
        
             
         </script>
         
<!-- Modal HTML embedded directly into document -->
<div id="image_preview" class="modal">
  <p></p>
  <a href="#" rel="modal:close" class="btn btn-primary">Close</a>
</div>

         
         <input type="file" name="upload_contract" id="uploadContract"/>
         <input type="file" name="upload_id" id="uploadId"/>
         <input type="file" name="upload_mandate" id="uploadMandate"/>
         
         <div class="col-12" id="documentImages">
             <div id="contractSection">
         <h4>صورة العقد</h4>
         <span class="btn btn-primary" id="uploadContractBtn">رفع الصورة <i class="fas fa-upload"></i></span>
                 <? if($contract_image != ""){ ?>
                 <span class="btn btn-success" id="contractPreviewBtn" tag="<? echo $contract_image;?>" rel="modal:open">عرض الصورة <i class="fas fa-eye"></i></span>
         <a href="images/<? echo $contract_image; ?>" class="btn btn-warning">تحميل الصورة <i class="fas fa-download"></i></a>
                 <? } ?>
                 </div>
             <div id="IdSection">
         <h4>صورة البطاقة</h4>
         <span class="btn btn-primary" id="uploadIdBtn">رفع الصورة <i class="fas fa-upload"></i></span>
                 <? if($id_image != ""){ ?>
         <span class="btn btn-success" id="idPreviewBtn" tag="<? echo $id_image;?>" >عرض الصورة <i class="fas fa-eye"></i></span>
         <a href="images/<? echo $id_image; ?>" class="btn btn-warning">تحميل الصورة <i class="fas fa-download"></i></a>
                 <? } ?>
             </div>
             <div id="MandateSection">
         <h4>صورة التفويض </h4>
         <span class="btn btn-primary" id="uploadMandateBtn">رفع الصورة <i class="fas fa-upload"></i></span>
                 <? if($mandate_image != ""){ ?>
         <span class="btn btn-success" id="mandatePreviewBtn" tag="<? echo $mandate_image;?>" >عرض الصورة <i class="fas fa-eye"></i></span>
         <a href="images/<? echo $mandate_image; ?>" class="btn btn-warning">تحميل الصورة <i class="fas fa-download"></i></a>
                 <? } ?>
             </div>
         </div>
         
         <script>
         
         $(document).ready(function(){
             
             $("#contractPreviewBtn").click(function(){
                 
                 let image_name = $(this).attr("tag");
                 
                 $("#image_preview").modal();
                 $("#image_preview p").html("<img src='images/"+image_name+"' style='width: 100%;' />");
                 
             })
             
             $("#idPreviewBtn").click(function(){
                 
                 let image_name = $(this).attr("tag");
                                  
                 $("#image_preview").modal();
                 $("#image_preview p").html("<img src='images/"+image_name+"' style='width: 100%;' />");
                 
             })
             
             $("#mandatePreviewBtn").click(function(){
                 
                 let image_name = $(this).attr("tag");
                 
                 $("#image_preview").modal();
                 $("#image_preview p").html("<img src='images/"+image_name+"' style='width: 100%;' />");
                 
             })
             
             $("#uploadContractBtn").click(function(){
                 $("#uploadContract").click();
                 $("#uploadContract").change(function(){ 
                     let fileNameValue = this.files[0].name;
                    $("#contractSection").after("<div class='fileName col-5'>"+fileNameValue+"</div>");  
             })
                 return false;
             });
             
             $("#uploadIdBtn").click(function(){
                 $("#uploadId").click();
                 $("#uploadId").change(function(){ 
                     let fileNameValue = this.files[0].name;
                     $("#IdSection").after("<div class='fileName col-5'>"+fileNameValue+"</div>");  

             })
                 return false;
             });
             
             $("#uploadMandateBtn").click(function(){
                 $("#uploadMandate").click();
                 $("#uploadMandate").change(function(){ 
                     let fileNameValue = this.files[0].name;
                     $("#MandateSection").after("<div class='fileName col-5'>"+fileNameValue+"</div>");  

             })
                 return false;
             });
             
             
         })
         
         </script>
         
         
  </div>
    
    <input type="submit" name="submit" value="تعديل المعلومات" class="btn btn-primary col-md-6 col-10"/>
    
</form>
    
    
</div>


<?php

include_once "models/unit.php";

include_once "page/footer.php";

?>

