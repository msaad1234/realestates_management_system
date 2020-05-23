<?php
session_start();

######################################################################

// if (isset($_GET['allowed']) && $_GET['allowed'] == "allowedUser") {

//     $ip_address = getUserIpAddr();

//     echo $ip_address;

//     $sql_select = "SELECT * FROM allowedIPs WHERE device_ip_address='$ip_address'";
//     $query_select = mysqli_query($connect, $sql_select);
//     $rows = mysqli_num_rows($query_select);
//     if ($rows == 0) {

//         $sql = "INSERT INTO allowedIPs (device_ip_address) VALUES ('$ip_address')";
//         $query = mysqli_query($connect, $sql);

//         if (!$query) {
//             echo "ERROR in Login";
//         }
//     } else {
//         echo "<br/>you are added";
//     }
// }
##############################################################

include_once "page/header.php";

if(!isset($_SESSION['preLogin']))
return;

$notifications_num = 0;


$payments_tables = ['units_payments', 'shops_payments'];

for ($i = 0; $i <= sizeof($payments_tables); $i++) {

    $list_name = substr($payments_tables[$i], 0, strpos($payments_tables[$i], '_'));
    $element_name = substr($list_name, 0, strlen($list_name) - 1);
    $sql = "SELECT * FROM " . $payments_tables[$i] . " as payments JOIN $list_name ON " . $element_name . "_id = $list_name.id WHERE due_date >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)";
    $query = mysqli_query($connect, $sql);
    $rows = @mysqli_num_rows($query);

    $notifications_num += $rows;
}


?>

<div id="main" class="row">

    <ul class="col-10">
        <a href="units.php">
            <li class="col-5 col-md-3">الوحدات</li>
        </a>
        <a href="shops.php">
            <li class="col-5 col-md-3">المحلات</li>
        </a>
        <a href="contracts.php">
            <li class="col-5 col-md-3">العقود</li>
        </a>
        <a href="notifications.php">
            <li class="col-5 col-md-3">
                <span>التنبيهات</span><span id="notification_icon"><? echo $notifications_num; ?></span>
            </li>
        </a>


    </ul>


</div>

<?php

include_once "page/footer.php";

?>