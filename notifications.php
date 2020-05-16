<?php

include_once "core/config.php";
include_once "page/header.php";

?>


<div id="unitContracts" class="row col-sm-12">

            <h3>التنبيهات</h3><br>

    <div id="section" class="col-12 col-md-7 col-lg-5">
        
        <?php
        
        
        date_default_timezone_set('Asia/Riyadh');
        $current_date = date("Y-m-d");        
        
        $sql = "SELECT *, (DATE(NOW()) - INTERVAL 7 DAY) AS diff FROM shops_payments WHERE due_date >= (DATE(NOW) - INTERVAL 7 DAYS)";
        $query = mysqli_query($connect, $sql);
        
        ?>
        
        <ul>
        
            <?php
            
            while($row = mysqli_fetch_array($query)){
                
                
                ?>
            <li>
                <p><? echo $row['due_date'] ?></p>
                <div class="operations">
                    <a href="files/unitsContracts/word_files/<? echo ""; ?>"><span class="btn btn-primary">تحميل العقد بصيغة word</span></a>
                    <a href="files/unitsContracts/pdf_files/<? echo ""; ?>"><span class="btn btn-primary">تحميل العقد بصيغة pdf</span></a>
                </div>
            </li>
            
            <?php
                
            }
            
            ?>
            
        </ul>
        
    </div>
    

</div>


<script>

    $(document).ready(function(){
        
        
        $("#addContractFormBTN").click(function(){
                
                
                $("#addContractForm").slideToggle(500);
                
            });
        
        
        $("#uplaodWord").click(function(){
            $("input[name='wordFile']").click();
        })
        
        $("#uploadPdf").click(function(){
            $("input[name='pdfFile']").click();
        })
        
        
    })

    

</script>

<form class="from-group col-10 col-md-4" id="addContractForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <input type="text" name="contractName" placeholder="اسم العقد" class="form-control" />
    <input type="file" name="wordFile" class="form-control" style="display: none;" />
    <input type="file" name="pdfFile" class="form-control" style="display: none;" />
    <span id="uplaodWord" class="btn btn-primary" >رفع ملف الوورد <i class="fas fa-upload"></i></span>
    <span id="uploadPdf" class="btn btn-primary" >رفع ملف pdf <i class="fas fa-upload"></i></span>
    <input type="submit" name="addContractBTN" value="إضافة" class="btn btn-primary" />
</form>


        <a id="addContractFormBTN"><i id="addNewContractBTN" class="fas fa-plus-circle"></i></a>



<?php


if(isset($_POST['addContractBTN'])){
    
    
    $contractName = $_POST['contractName'];
    
    $wordName = $_FILES['wordFile']['name'];
    $wordTmp = $_FILES['wordFile']['tmp_name'];
    
    $pdfName = $_FILES['pdfFile']['name'];
    $pdfTmp = $_FILES['pdfFile']['tmp_name'];
    
    
//    if($word_name != "" && $pdf_name != ""){
//        
//        
//        
//    }
    
    
    $sql = "INSERT INTO contracts (name, word_file_name, pdf_file_name, type) VALUES ('$contractName','$wordName','$pdfName','unit')";
    
    $query = mysqli_query($connect, $sql);
    
    if($query){
        
        if(isset($_FILES['wordFile'])){
        move_uploaded_file($wordTmp, "files/unitsContracts/word_files/".iconv('utf-8','windows-1256',$wordName));
        }
        
        if(isset($_FILES['pdfFile'])){
        move_uploaded_file($pdfTmp, "files/unitsContracts/pdf_files/".iconv('utf-8','windows-1256',$pdfName));
        }
        
    }else{
        
        echo "There is problem in inserting the files";
    }
    
    
}


include_once "page/footer.php";

?>

