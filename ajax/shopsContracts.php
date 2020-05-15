<?php
    
include_once "../core/config.php";
    
    $contractName = $_POST['contractName'];
    
    $sql_select = "SELECT * FROM contracts";
    $query_select = mysqli_query($connect, $sql_select);
    

    if($query_select){
        
        $ids = array();
        $names = array();
        $images = array();
        $types = array();
        
        while($row = mysqli_fetch_array($query_select)){
            
            $ids[] = $row['id'];
            $names[] = $row['name'];
            $images[] = $row['image'];
            $types[] = $row['type'];
                        
        }

        $res = array($ids, $names, $images, $types);
        echo json_encode($res);
        
        
    }else{
        
        echo "Error: query ".$sql_select;
    }
    



?>