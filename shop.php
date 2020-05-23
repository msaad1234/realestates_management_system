<?php
include_once "page/header.php";

if (!isset($_SESSION['preLogin']))
    return;

?>


<div id="shop">

    <div id="page-title"><span>معلومات المحل</span></div><br>

    <?php

    $shop_id = $_GET['id'];

    $sql_shop = "SELECT * FROM shops WHERE id='$shop_id'";
    $query_shop = mysqli_query($connect, $sql_shop);
    $row_shop = mysqli_fetch_array($query_shop);
    $renter_id = $row_shop['renter_id'];
    $renting_price = $row_shop['renting_price'];
    $contract_image = $row_shop['contract_image'];
    $contract_pdf = $row_shop['contract_pdf'];
    $id_image = $row_shop['id_image'];
    $id_pdf = $row_shop['id_pdf'];
    $mandate_image = $row_shop['mandate_image'];
    $mandate_pdf = $row_shop['mandate_pdf'];

    $sql_renter = "SELECT * FROM renters WHERE id='$renter_id'";
    $query_renter = mysqli_query($connect, $sql_renter);
    $row_renter = mysqli_fetch_array($query_renter);
    $renter_name = $row_renter['name'];
    $renter_phone_number = $row_renter['phone_number'];

    $sql_payments = "SELECT * FROM shops_payments WHERE shop_id = '$shop_id'";
    $query_payments = mysqli_query($connect, $sql_payments);
    $rows_payments = mysqli_num_rows($query_payments);


    ?>

    <form id="shopInformationForm" name="editShopInfo" class="col-sm-12 col-md-9 col-lg-5" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . $_GET['id']; ?>">
        <div class="form-group">
            <label>اسم التاجر</label>
            <input type="text" class="form-control" name="renter_name" value="<? echo $renter_name; ?>">
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
                <option value="1" <? echo $rows_payments == 1 ? 'selected' : '' ?>>دفعة</option>
                <option value="2" <? echo $rows_payments == 2 ? 'selected' : '' ?>>دفعتين</option>
                <option value="3" <? echo $rows_payments == 3 ? 'selected' : '' ?>>3 دفعات</option>
                <option value="4" <? echo $rows_payments == 4 ? 'selected' : '' ?>>4 دفعات</option>
                <option value="5" <? echo $rows_payments == 5 ? 'selected' : '' ?>>5 دفعات</option>
                <option value="6" <? echo $rows_payments == 6 ? 'selected' : '' ?>>6 دفعات</option>
                <option value="7" <? echo $rows_payments == 7 ? 'selected' : '' ?>>7 دفعات</option>
                <option value="8" <? echo $rows_payments == 8 ? 'selected' : '' ?>>8 دفعات</option>
                <option value="9" <? echo $rows_payments == 9 ? 'selected' : '' ?>>9 دفعات</option>
                <option value="10" <? echo $rows_payments == 10 ? 'selected' : '' ?>>10 دفعات</option>
            </select>


            <div id="payment" class="form-group payment col-sm-12">
                <?php

                $payments_prices = "";
                $payments_due_dates = "";

                $i = 0;
                while ($row_payments = mysqli_fetch_array($query_payments)) {

                    $row_payments_price = $row_payments['payment_price'];
                    $row_payments_order = $row_payments['payment_order'];
                    $row_payments_due_date = $row_payments['due_date'];

                    $payments_prices .= "{$row_payments_price},";
                    $payments_due_dates .= "{$row_payments_due_date},";

                    $payment_order = $i + 1;
                ?>

                    <label class="title">دفعة رقم <? echo $row_payments_order; ?> </label>
                    <div class="paymentFeild col-sm-5">
                        <label>قيمة الدفعة</label>
                        <input type="text" class="form-control" name="payment_<? echo $payment_order; ?>_price" value="<? echo $row_payments_price; ?>">
                    </div>
                    <div class="paymentFeild col-sm-5">
                        <label>تاريخ إنتهاء الدفعة</label>
                        <input type="date" placeholder="yy/mm/dd" name="payment_<? echo $payment_order; ?>_due_date" class="form-control" value="<? echo $row_payments_due_date; ?>">
                    </div>

                <?php

                    $i++;
                }
                ?>

                <input type="hidden" id="payments_prices" value="<? echo $payments_prices; ?>" />
                <input type="hidden" id="payments_due_dates" value="<? echo $payments_due_dates; ?>" />

            </div>

            <script type="text/javascript">
                $(document).ready(function() {


                    // get stored payments' prices 
                    let payments_prices = $("#payments_prices").val();
                    payments_prices = payments_prices.split(",");
                    payments_prices.pop();

                    // get stored payments' due dates
                    let payments_due_dates = $("#payments_due_dates").val();
                    payments_due_dates = payments_due_dates.split(",");
                    payments_due_dates.pop();


                    document.getElementById("paymentsNumber").addEventListener("change", function() {

                        let paymentsNumberElement = document.getElementById("paymentsNumber");

                        document.querySelector('.payment').innerText = "";

                        let paymentsElements = "";

                        for (let i = 0; i < paymentsNumberElement.value; i++) {

                            payments_prices[i] = payments_prices[i] == undefined ? '' : payments_prices[i];
                            payments_due_dates[i] = payments_due_dates[i] == undefined ? '' : payments_due_dates[i];

                            paymentsElements += `
             <label class="title">دفعة رقم ${(i+1)} </label>
             <div class="paymentFeild col-sm-5">
                 <label>قيمة الدفعة</label>
                 <input type="text" class="form-control" name="payment_${(i+1)}_price" value="${payments_prices[i]}">
             </div>
             <div class="paymentFeild col-sm-5">
                 <label>تاريخ إنتهاء الدفعة</label>
                 <input type="date" placeholder="yy/mm/dd" class="form-control" name="payment_${(i+1)}_due_date" value="${payments_due_dates[i]}" >
             </div>`;

                        }

                        document.querySelector('#payment').innerHTML = paymentsElements;
                    })

                })
            </script>

            <!-- Modal HTML embedded directly into document -->
            <div id="image_preview" class="modal">
                <p></p>
                <a href="#" rel="modal:close" class="btn btn-primary">Close</a>
            </div>


            <input type="file" name="upload_contract_image" id="uploadContractImage" />
            <input type="file" name="upload_id_image" id="uploadIdImage" />
            <input type="file" name="upload_mandate_image" id="uploadMandateImage" />

            <input type="file" name="upload_contract_pdf" id="uploadContractPDF" />
            <input type="file" name="upload_id_pdf" id="uploadIdPDF" />
            <input type="file" name="upload_mandate_pdf" id="uploadMandatePDF" />

            <div class="col-12" id="documentImages">
                <div id="contractSection">
                    <h4>صورة العقد</h4>
                    <div class="uploadImageSection">
                        <span class="btn btn-primary" id="uploadContractImageBtn">رفع الصورة <i class="fas fa-upload"></i></span>
                        <? if ($contract_image != "") { ?>
                            <span class="btn btn-success contractPreviewBtn" tag="<? echo "<img>" . $contract_image; ?>" rel="modal:open">عرض الصورة <i class="fas fa-eye"></i></span>
                            <a href="images/<? echo $contract_image; ?>" class="btn btn-warning">تحميل الصورة <i class="fas fa-download"></i></a>
                        <? } ?>
                    </div>

                    <div class="uploadPDFSection">
                        <span class="btn btn-primary" id="uploadContractPDFBtn">رفع pdf <i class="fas fa-upload"></i></span>
                        <? if ($contract_pdf != "") { ?>
                            <span class="btn btn-success contractPreviewBtn" tag="<? echo "<pdf>" . $contract_pdf; ?>" rel="modal:open">عرض pdf <i class="fas fa-eye"></i></span>
                            <a href="files/shopContracts/pdf_files/<? echo $contract_pdf; ?>" class="btn btn-warning">تحميل pdf <i class="fas fa-download"></i></a>
                        <? } ?>
                    </div>

                </div>


                <div id="IdSection">
                    <h4>صورة البطاقة</h4>
                    <div class="uploadImageSection">
                        <span class="btn btn-primary" id="uploadIdImageBtn">رفع الصورة <i class="fas fa-upload"></i></span>
                        <? if ($id_image != "") { ?>
                            <span class="btn btn-success contractPreviewBtn" tag="<? echo "<img>" . $id_image; ?>">عرض الصورة <i class="fas fa-eye"></i></span>
                            <a href="images/<? echo $id_image; ?>" class="btn btn-warning">تحميل الصورة <i class="fas fa-download"></i></a>
                        <? } ?>
                    </div>

                    <div class="uploadPDFSection">
                        <span class="btn btn-primary" id="uploadIdPDFBtn">رفع pdf <i class="fas fa-upload"></i></span>
                        <? if ($id_pdf != "") { ?>
                            <span class="btn btn-success contractPreviewBtn" tag="<? echo "<pdf>" . $id_pdf; ?>" rel="modal:open">عرض pdf <i class="fas fa-eye"></i></span>
                            <a href="images/<? echo $contract_image; ?>" class="btn btn-warning">تحميل pdf <i class="fas fa-download"></i></a>
                        <? } ?>
                    </div>

                </div>


                <div id="MandateSection">
                    <h4>صورة التفويض </h4>
                    <div class="uploadImageSection">
                        <span class="btn btn-primary" id="uploadMandateImageBtn">رفع الصورة <i class="fas fa-upload"></i></span>
                        <? if ($mandate_image != "") { ?>
                            <span class="btn btn-success contractPreviewBtn" tag="<? echo "<img>" . $mandate_image; ?>">عرض الصورة <i class="fas fa-eye"></i></span>
                            <a href="images/<? echo $mandate_image; ?>" class="btn btn-warning">تحميل الصورة <i class="fas fa-download"></i></a>
                        <? } ?>
                    </div>

                    <div class="uploadPDFSection">
                        <span class="btn btn-primary" id="uploadMandatePDFBtn">رفع pdf <i class="fas fa-upload"></i></span>
                        <? if ($mandate_pdf != "") { ?>
                            <span class="btn btn-success contractPreviewBtn" tag="<? echo "<pdf>" . $mandate_pdf; ?>" rel="modal:open">عرض pdf <i class="fas fa-eye"></i></span>
                            <a href="images/<? echo $contract_image; ?>" class="btn btn-warning">تحميل pdf <i class="fas fa-download"></i></a>
                        <? } ?>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {

                    $(".contractPreviewBtn").click(function() {


                        let image_name = $(this).attr("tag");

                        let image_window = "";

                        if (image_name.startsWith("<img>")) {
                            viewer_window = "<embed src='images/" + image_name.substr(image_name.indexOf('>') + 1) + "' style='width:100%; height: 100%;' />";
                        } else {
                            viewer_window = "<embed src='files/shopsContracts/pdf_files/" + image_name.substr(image_name.indexOf('>') + 1) + "' style='width:100%; height: 100%;' />";
                        }
                        $("#image_preview").modal();
                        $("#image_preview p").html(viewer_window);

                    });

                    $("#idPreviewBtn").click(function() {

                        let image_name = $(this).attr("tag");

                        let image_window = "";

                        if (image_name.startsWith("<img>")) {
                            viewer_window = "<embed src='images/" + image_name.substr(image_name.indexOf('>') + 1) + "' style='width:100%; height: 100%;' />";
                        } else {
                            viewer_window = "<embed src='files/shopsContracts/pdf_files/" + image_name.substr(image_name.indexOf('>') + 1) + "' style='width:100%; height: 100%;' />";
                        }
                        $("#image_preview").modal();
                        $("#image_preview p").html(viewer_window);
                    });

                    $("#mandatePreviewBtn").click(function(){

                        let image_name = $(this).attr("tag");

                        let image_window = "";

                        if (image_name.startsWith("<img>")) {
                            viewer_window = "<embed src='images/" + image_name.substr(image_name.indexOf('>') + 1) + "' style='width:100%; height: 100%;' />";
                        } else {
                            viewer_window = "<embed src='files/shopsContracts/pdf_files/" + image_name.substr(image_name.indexOf('>') + 1) + "' style='width:100%; height: 100%;' />";
                        }
                        $("#image_preview").modal();
                        $("#image_preview p").html(viewer_window);
                    });


                    // For Uploading Identification Card Image and PDF
                    $("#uploadContractImageBtn").click(function() { // upload image file
                        $("#uploadContractImage").click();
                        $("#uploadContractImage").change(function() {
                            let fileNameValue = this.files[0].name;
                            $("#contractSection .uploadImageSection").after("<div class='fileName col-5'>" + fileNameValue + "</div>");
                        })
                        return false;
                    });
                    $("#uploadContractPDFBtn").click(function() { // upload pdf file
                        $("#uploadContractPDF").click();
                        $("#uploadContractPDF").change(function() {
                            let fileNameValue = this.files[0].name;
                            $("#contractSection .uploadPDFSection").after("<div class='fileName col-5'>" + fileNameValue + "</div>");
                        })
                        return false;
                    });


                    // For Uploading Identification Card Image and PDF
                    $("#uploadIdImageBtn").click(function() { // upload image
                        $("#uploadIdImage").click();
                        $("#uploadIdImage").change(function() {
                            let fileNameValue = this.files[0].name;
                            $("#IdSection .uploadImageSection").after("<div class='fileName col-5'>" + fileNameValue + "</div>");

                        })
                        return false;
                    });
                    $("#uploadIdPDFBtn").click(function() { // upload pdf file
                        $("#uploadIdPDF").click();
                        $("#uploadIdPDF").change(function() {
                            let fileNameValue = this.files[0].name;
                            $("#IdSection .uploadPDFSection").after("<div class='fileName col-5'>" + fileNameValue + "</div>");

                        })
                        return false;
                    });


                    // For Uploading Mandate Image and PDF
                    $("#uploadMandateImageBtn").click(function() { // upload image file
                        $("#uploadMandateImage").click();
                        $("#uploadMandateImage").change(function() {
                            let fileNameValue = this.files[0].name;
                            $("#MandateSection .uploadImageSection").after("<div class='fileName col-5'>" + fileNameValue + "</div>");

                        })
                        return false;
                    });
                    $("#uploadMandatePDFBtn").click(function() { // upload pdf file
                        $("#uploadMandatePDF").click();
                        $("#uploadMandatePDF").change(function() {
                            let fileNameValue = this.files[0].name;
                            $("#MandateSection .uploadPDFSection").after("<div class='fileName col-5'>" + fileNameValue + "</div>");

                        })
                        return false;
                    });





                })
            </script>


        </div>

        <input type="submit" name="submit" value="تعديل المعلومات" class="btn btn-primary col-md-6 col-10" />

    </form>


</div>


<?php

include_once "models/shop.php";

include_once "page/footer.php";

?>