<?php
include_once "page/header.php";

if (!isset($_SESSION['preLogin']))
    return;

$type = $_GET['type'];
$id = $_GET['id'];

$table = $type . 's';

$sql = "SELECT * FROM $table WHERE id='$id'";
$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($query);
$renter_id = $row['renter_id'];
$item_name = $row['name'];
$renting_price = $row['renting_price'];

$sql_renter = "SELECT * FROM renters WHERE id='$renter_id'";
$query_renter = mysqli_query($connect, $sql_renter);
$row_renter = mysqli_fetch_array($query_renter);
$renter_name = $row_renter['name'];
$renter_phone_number = $row_renter['phone_number'];


$sql_payments = "SELECT * FROM {$table}_payments WHERE {$type}_id = '$id'";
$query_payments = mysqli_query($connect, $sql_payments);
$payments_number = mysqli_num_rows($query_payments);

$page_title_type = $type == 'unit' ? 'وحدة' : 'محل';

?>


<div id="info">

<div id="page-title"><span>تقرير عن <? echo $page_title_type; ?> <? echo $item_name;?></span></div><br>

    <div id="report" style="text-align: right;" class="col-11 col-md-7">
        <div class="info-row">
            <span class="info-heading">اسم المستأجر</span>
            <span class="info-value">
                <? echo $renter_name;?></span>
        </div>
        <div class="info-row">
            <span class="info-heading">رقم الهوية</span>
            <span class="info-value">
                <? echo $renter_id; ?></span>
        </div>
        <div class="info-row">
            <span class="info-heading">رقم الهاتف</span>
            <span class="info-value">
                <? echo $renter_phone_number;?></span>
        </div>
        <div class="info-row">
            <span class="info-heading">قيمة الإيجار</span>
            <span class="info-value">
                <? echo $renting_price; ?></span>
        </div>
        <div class="info-row">
            <span class="info-heading">عدد الدفعات</span>
            <span class="info-value">
                <? echo $payments_number; ?></span>
        </div>
        <div class="info-row">
            <span class="info-heading">الدفعات</span>
            <ul>
                <?php
                if($payments_number == 0){
                    echo "<h3>لاتوجد دفعات</h3>";
                }

                $i=1;
                while ($row_payments = mysqli_fetch_array($query_payments)) {
                    $payment_price = $row_payments['payment_price'];
                    $payment_due_date = $row_payments['due_date'];
                ?>
                    <li>
                        <span class="payment-number"><? echo $i; ?></span>
                        <span class="payment-price"><span class="item-heading">قيمة الدفعة</span><span class="item-value"><? echo $payment_price;?></span></span>
                        <span class="payment-date"><span class="item-heading">تاريخ الدفعة</span><span class="item-value"><? echo $payment_due_date;?></span></span>
                    </li>
                <?php
                $i++;
                }
                ?>
            </ul>
        </div>
    </div>


</div>