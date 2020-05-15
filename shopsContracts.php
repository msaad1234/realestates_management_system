<?php

include_once "core/config.php";
include_once "page/header.php";

?>


<div id="shopContracts" class="row col-sm-12">

            <h3>العقود</h3><br>
    
    <div id="section" class="col-12 col-md-7 col-lg-5">
    
    <form class="form-group col-lg-9" id="searchForm" method="post">
        
        <input type="text" class="form-control" id="searchBox" name="contractName" placeholder="أبحث عن عقد المحل"/>
        
        <input type="submit" class="btn btn-primary" value="بحث" />
        
    </form>
        
        <ul>
        
            
        </ul>
        
    </div>

</div>


<script>

    $(document).ready(function(){
        
        
        $("#searchBox").on('input',function(){
            
            let searchBoxValue = $(this).val();
            
            $.post("ajax/shopsContracts.php",$("#searchBox").serialize(),function(data){
                
                let contractsList = JSON.parse(data);
                
                // Conver the array from column-wise array to row-wise array
                
                
                
                contractsList.map(item => {
                    
                    $("ul").append(`<li><p>${item[]}</p>
                <span class="operations">
                <span class="btn btn-primary" >رفع</span>
                <span class="btn btn-success" >عرض</span>
                <span class="btn btn-danger" >تحميل</span>
                    </span>
            </li>`);
                    
                    
                })
                

                
                
            })
    
            
            
        })
        
        
    })

    

</script>



<?php


include_once "page/footer.php";

?>

