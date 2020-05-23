<?php

include_once "page/header.php";
if (!isset($_SESSION['preLogin']))
    return;
?>


<div id="units" class="row col-sm-12">

    <div id="page-title"><span>الوحدات</span></div><br>

    <div id="list">

        <ul>

            <?php

            $query = mysqli_query($connect, "SELECT * FROM units");
            while ($row = mysqli_fetch_array($query)) {

            ?>

                <a href="unit.php?id=<?php echo $row['id']; ?>">
                    <li><?php echo $row['name']; ?></li>
                </a>

            <?php


            }

            ?>


        </ul>

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



</div>



<?php


include_once "page/footer.php";

?>