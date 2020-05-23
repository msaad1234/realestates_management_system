<?php

include_once "page/header.php";

if (!isset($_SESSION['preLogin']))
    return;

?>


<div id="notifications" class="row col-sm-12">

    <div id="page-title"><span>التنبيهات</span></div>

    <div id="section" class="col-12 col-md-10 col-lg-5">

        <?php


        //        date_default_timezone_set('Asia/Riyadh');
        //        $current_date = date("Y-m-d");        

        $payments_tables = ['units_payments', 'shops_payments'];


        for ($i = 0; $i < sizeof($payments_tables); $i++) {

            $list_name = substr($payments_tables[$i], 0, strpos($payments_tables[$i], '_'));
            $element_name = substr($list_name, 0, strlen($list_name) - 1);

            $sql = "SELECT * FROM " . $payments_tables[$i] . " as payments JOIN $list_name ON " . $element_name . "_id = $list_name.id WHERE due_date >= DATE_SUB(CURDATE(), INTERVAL 5 DAY)";
            $query = mysqli_query($connect, $sql);

        ?>

            <ul>

                <?php

                while ($row = mysqli_fetch_array($query)) {

                    $renter_id = $row['renter_id'];
                    $name = $row['name'];
                    $payment_order = $row['payment_order'];

                    $shopOrUnitLabel = $element_name == "shop" ? 'اسم المحل : ' : 'رقم الوحدة : ';

                    $sql_renters = "SELECT * FROM renters WHERE id = '$renter_id'";
                    $query_renters = mysqli_query($connect, $sql_renters);
                    $row_renters = mysqli_fetch_array($query_renters);
                    $renter_name = $row_renters['name'];
                ?>
                    <a href="<? echo $element_name . ".php?id=" . $row['id']; ?>">
                        <li>
                            <div class="rightSection col-12 col-md-6">
                                <p class="renterName"><? echo $renter_name; ?></p>
                                <p class="shopName"><? echo $shopOrUnitLabel . $name; ?></p>
                            </div>
                            <div class="leftSection col-12 col-md-6">
                                <p class="paymentOrder">رقم الدفعة : <? echo $payment_order; ?></p>
                            </div>
                            <div class="operations">
                                <a href="files/images/<? echo $row['contract_image']; ?>"><span class="btn btn-primary col-12 col-md-5">تحميل صورة العقد</span></a>
                                <a href="files/unitsContracts/pdf_files/<? echo $row['contract_pdf']; ?>"><span class="btn btn-primary col-12 col-md-5">تحميل العقد بصيغة pdf</span></a>
                            </div>
                        </li>
                    </a>

                <?php

                }

                ?>

            </ul>

        <?php

        }

        ?>


    </div>


</div>


<script>


</script>



<?php


include_once "page/footer.php";

?>