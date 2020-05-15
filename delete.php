<?php


include_once "core/config.php";

$table = $_GET['type'];
$id = $_GET['id'];

$file_name = "";

switch($table){
    case "shops": $file_name="shops.php";
        break;
    case "units": $file_name="units.php"; 
}

$sql_delete = "DELETE FROM $table WHERE id='$id'";
$query_delete = mysqli_query($connect, $sql_delete);

if($query_delete){
    echo "<h2>Data is deleted ...</h2>";
    ?>

<meta http-equiv="refresh" content="2;url=<? echo $file_name; ?>" />
<?
}else{
    
    echo "There is problem in deleting data : $sql_delete";
    
}



?>
