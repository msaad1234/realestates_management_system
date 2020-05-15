<?php

include_once "core/config.php";
include_once "page/header.php";

?>


<div id="units" class="row col-sm-12">

            <h3>الوحدات</h3><br>
                    

        <ul>
            
    <?php
    
    $query = mysqli_query($connect,"SELECT * FROM units");
    while($row = mysqli_fetch_array($query)){
        
        ?>
            
                    <a href="unit.php?id=<?php echo $row['id']; ?>"><li><?php echo $row['name']; ?></li></a>
            
            <?php
        
        
    }
    
    ?>

    
    </ul>
        
        

</div>



<?php


include_once "page/footer.php";

?>

