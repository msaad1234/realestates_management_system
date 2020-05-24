<?php

include_once "page/header.php";
if (!isset($_SESSION['preLogin']))
    return;
?>


<div id="units" class="row col-sm-12">

    <div id="page-title"><span>الوحدات</span></div><br>

    <div id="list">

        <?php

        $units_shelfs = ['A', 'B', 'C', 'D', 'E', 'F', "other"];

        // if the seconds character is number and the first one equal the current array element
        for ($i = 0; $i < count($units_shelfs); $i++) {

        ?>

            <ul>

                <?php

                $RegExp = "";
                if ($units_shelfs[$i] == "other") {
                    $RegExp = "name NOT REGEXP '^[A-Z]+[0-9]'";
                } else {
                    $RegExp = "name REGEXP '^$units_shelfs[$i]+[0-9]'";
                }

                $sql = "SELECT * FROM units WHERE $RegExp";

                $query = mysqli_query($connect, $sql);
                while ($row = mysqli_fetch_array($query)) {

                ?>

                    <a class="title" href="unit.php?id=<?php echo $row['id']; ?>">
                        <li><?php echo $row['name']; ?><a href="delete.php?type=units&id=<? echo $row['id']; ?>" class="btn btn-secondary deleteBtn">حذف</a></li>
                    </a>

                <?php


                }
                ?>


            </ul>

        <?

        }

        ?>

    </div>


    <form class="from-group col-6 col-md-3" id="addUnitForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="unitName" placeholder="اسم الوحدة" class="form-control" />
        <input type="submit" name="addUnitBTN" value="إضافة شقة" class="btn btn-primary" />
    </form>

    <a id="addUnitFormBTN"><i id="addNewUnitBTN" class="fas fa-plus-circle"></i></a>

    <script type="text/javascript">
        $(document).ready(function() {


            $("#addUnitFormBTN").click(function() {


                $("#addUnitForm").slideToggle(500);

            });


        })
    </script>



</div>



<?php

if (isset($_POST['addUnitBTN'])) {



    $sql = "INSERT INTO units (name) values ('" . $_POST['unitName'] . "')";

    if ($query = mysqli_query($connect, $sql)) {

?>

        <meta http-equiv="Refresh" content="0;url=<?php echo $_SERVER['PHP_SELF']; ?>">

<?php
    } else {

        echo "Problem in inserting data";
    }
}

include_once "page/footer.php";

?>