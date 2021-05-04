<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/backend/utility/DB.php";
    //$post = (new DB())->getPost($post_id);
    //var_dump($post);
?>
<section class="container">
    <h1>Artikel</h1>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-4 image">
                <img style = "width : 400px" src="res/images/car.jpg" alt="Test">
            </div>
            <div class="col-2 offset-5 price ">
                <div class="row">  
                <div style = "font-size: larger; font-weight: 600; background-color: yellow; padding: 15px; margin-top: 20px;"> $12 </div>
            </div>
            <div class="row"> 
                <div>Max Mustermann</div>
            </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 description">
                Description
            </div>
        </div>
    </div>
</section>