<?php

include_once "page/header.php";
if (!isset($_SESSION['preLogin']))
    return;
?>


<div id="shops" class="row col-sm-12">

    <div id="page-title"><span>المحلات</span></div><br>

    <div id="list">

        <ul>

            <?php

            $query = mysqli_query($connect, "SELECT * FROM shops");
            while ($row = mysqli_fetch_array($query)) {

            ?>
                <li>

                    <a class="title" href="shop.php?id=<?php echo $row['id']; ?>" class="col-10 col-md-3">
                        <?php echo $row['name']; ?>
                        <a href="delete.php?type=shops&id=<? echo $row['id']; ?>" class="btn btn-secondary deleteBtn">حدف</a>
                    </a>
                </li>


            <?php


            }

            ?>


        </ul>

    </div>

</div>


<form class="from-group col-6 col-md-3" id="addShopForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="shopName" placeholder="اسم المحل" class="form-control" />
    <input type="submit" name="addShopBTN" value="إضافة محل" class="btn btn-primary" />
</form>

<a id="addShopFormBTN"><i id="addNewShopBTN" class="fas fa-plus-circle"></i></a>

<script type="text/javascript">
    $(document).ready(function() {


        $("#addShopFormBTN").click(function() {


            $("#addShopForm").slideToggle(500);

        });


    })
</script>

<?php

if (isset($_POST['addShopBTN'])) {



    $sql = "INSERT INTO shops (name, renting_price, payment_id, contract_image, id_image, mandate_image) values ('" . $_POST['shopName'] . "','','','','','')";

    if ($query = mysqli_query($connect, $sql)) {

?>

        <script>
            window.location.href = window.location.href;
        </script>

<?php
    } else {

        echo "Problem in inserting data";
    }
}


include_once "page/footer.php";

?>