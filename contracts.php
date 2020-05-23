<?php

include_once "page/header.php";
if (!isset($_SESSION['preLogin']))
    return;

?>


<div id="contracts" class="row col-sm-12">

    <div id="page-title"><span>العقود</span></div><br>

    <div id="list">
        <ul>
            <a href="shopsContracts.php">
                <li>محلات</li>
            </a>
            <a href="unitsContracts.php">
                <li>وحدات</li>
            </a>

        </ul>

    </div>


</div>



<?php


include_once "page/footer.php";

?>