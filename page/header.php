<?php
session_start();
include_once "core/config.php";



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

if (!isset($_SESSION['preLogin'])) {

    $sql_select = "SELECT device_ip_address FROM allowedips WHERE device_ip_address='" . getUserIpAddr() . "'";
    $query_select = mysqli_query($connect, $sql_select);
    $rows = mysqli_num_rows($query_select);
    if ($rows > 0) {
        //register session

        $_SESSION['preLogin'] = getUserIpAddr();
    } else {

        // it's not allowed to enter the website
        return;
    }
}

?>

<html>


<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/main_style.css" rel="stylesheet" type="text/css" />
    <link href="css/all.min.css" rel="stylesheet" type="text/css" />
    <script src="js/all.min.js" type="text/javascript"></script>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="css/jquery.modal.min.css" />
    <title>لوحة التحكم</title>

</head>



<body>

    <div id="container" class="container-fluid">
        <header>

            <div id="rightSection" class="col-6"><a href="index.php">لوحة التحكم</a></div>
            <div id="leftSection" class="col-6"><a href="index.php">Dashboard</a></div>

        </header>