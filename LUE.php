<?php
session_start();
include_once("core/config.php");

function getUserIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


if(isset($_GET['enter']) && $_GET['enter'] == "dargon_user_admin"){


    $sql_select = "SELECT device_ip_address FROM allowedips WHERE device_ip_address='".getUserIpAddr()."'";
    $query_select = mysqli_query($connect, $sql_select);
    $rows = mysqli_num_rows($query_select);
if($rows < 1){
    //register in database

$sql = "INSERT INTO allowedips (device_ip_address) VALUES ('".getUserIpAddr()."')";
$query = mysqli_query($connect, $sql);

if($query){
    echo "Data is inserted";
}else{
    echo "Data is not inserted for login";
}

}

    $_SESSION['preLogin'] = getUserIpAddr();

}



?>