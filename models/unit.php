<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
    
    
    
    $renter_name = $_POST['renter_name'];
    $renter_SSN = $_POST['renter_SSN'];
    $renter_phone_number = $_POST['renter_phone_number'];
    $renting_price = $_POST['renting_price'];
    $payments_number = $_POST['payments_number'];
    
    $upload_contract = $_FILE['upload_contract'];
    $upload_id = $_FILE['upload_id'];
    $upload_mandate = $_FILE['upload_mandate'];   
    
    
    $upload_contract_name = $_FILES['upload_contract']['name'];
    $upload_contract_tmp = $_FILES['upload_contract']['tmp_name'];
    
    $upload_id_name = $_FILES['upload_id']['name'];
    $upload_id_tmp = $_FILES['upload_id']['tmp_name'];
    
    $upload_mandate_name = $_FILES['upload_mandate']['name'];
    $upload_mandate_tmp = $_FILES['upload_mandate']['tmp_name'];
        
    
    $unit_id = $_GET['id'];
    
        $imagesSqlText = "";
    
    
        if($upload_contract_name !== ""){
            $imagesSqlText .= ", contract_image='$upload_contract_name'";
                 if(isset($_FILES['upload_contract'])){
                     
                     move_uploaded_file($upload_contract_tmp,"images/".iconv('utf-8','windows-1256', $upload_contract_name));
                 }
        }

        
        if($upload_id_name !== ""){
            $imagesSqlText .= ", id_image='$upload_id_name'";
            if(isset($_FILES['upload_contract'])){
                     
                     move_uploaded_file($upload_id_tmp,"images/".iconv('utf-8','windows-1256', $upload_id_name));
                 }
        }
        
        if($upload_mandate_name !== ""){
            $imagesSqlText .= ", mandate_image='$upload_mandate_name'";
            if(isset($_FILES['upload_contract'])){
                     
                     move_uploaded_file($upload_mandate_tmp,"images/".iconv('utf-8','windows-1256', $upload_mandate_name));
                 }
        }
    
    
    $sql = "UPDATE units SET renter_id='$renter_SSN' , renting_price='$renting_price'".$imagesSqlText." WHERE id='$unit_id'";
    
    $query = mysqli_query($connect, $sql);
    if($query){
        
        //echo "unit information is updated";
    }else{
        echo "There is problem in updating the unit information : ".$sql;
    }
    
    $sql_renter = "SELECT * FROM renters WHERE id='$renter_SSN'";
    $query_renter = mysqli_query($connect, $sql_renter);
    $rows = mysqli_num_rows($query_renter);
    if($rows > 0){
        
        // update renter
        
        $sql_update = "UPDATE renters SET name='$renter_name' , phone_number='$renter_phone_number' WHERE id='$renter_SSN'";
        $query_update = mysqli_query($connect, $sql_update);
        
        if($query_update){
            
            //echo "Renter's information is updated";
        }else{
            
            echo "Renter's information is not updated, problem occured !";
        }
                
    }else{
        
        //insert new renter
        $sql_insert = "INSERT INTO renters (id, name, phone_number) VALUES ('$renter_SSN' , '$renter_name', '$renter_phone_number')";
        
        $query_insert = mysqli_query($connect, $sql_insert);
        
        
        
        if($query_insert){
            
            //echo "Renter's information is inserted";
        }else{
            
            echo "Renter's information is not inserted, problem occured !";
        }
    }
    
    
    for($i=0;$i<$payments_number;$i++){
        
        $payment_order = $i + 1;
        
        $payment_price = $_POST["payment_".$payment_order."_price"];
        $payment_due_date = $_POST["payment_".$payment_order."_due_date"];
        
        $sql_select = "SELECT * FROM units_payments WHERE unit_id = '$unit_id' && payment_order = '$payment_order'";
        $query_select = mysqli_query($connect, $sql_select);
        
        if(mysqli_num_rows($query_select) > 0){
                    
            echo $payment_price."<br>";
            
            $sql_update = "UPDATE units_payments SET payment_price = '$payment_price' , due_date = '$payment_due_date' WHERE unit_id = '$unit_id' && payment_order = '$payment_order'";
            
            if($query_update = mysqli_query($connect, $sql_update)){
                
                // delete other related payments if number of payments selected are less than the ones saved in the database
                if($payment_order == $payments_number){
                    $sql_clean = "DELETE FROM units_payments WHERE unit_id = '$unit_id' && payment_order > $payment_order";
                    $query_clean = mysqli_query($connect, $sql_clean);
                    
                    if($query_clean){
                        //echo "Records are cleaned";
                    }else{
                        echo "There is problem in cleaning the records";
                    }
                }
                
                
                //echo "payment is updated";
            }else{
                
                echo "payment is not update";
            }
        }else{
            $sql_insert = "INSERT INTO units_payments (payment_price, due_date, status, unit_id, payment_order) VALUES ('$payment_price','$payment_due_date', 0, '$unit_id', '$payment_order')";
            
            if($query_insert = mysqli_query($connect, $sql_insert)){
                
                //echo "payment is inserted";
            }else{
                
                echo "payment is not inserted";
            }
            
            
        }
        
        
    }
    
    
    ?>

<meta http-equiv="refresh" content="0;url=<?php echo $_SERVER['PHP_SELF']."?id=".$unit_id;?>" />

<?
 
    
    
}