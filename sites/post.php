<?php
    include_once $app_dir . "/backend/utility/DB.php";
    $post = (new DB())->getPost($post_id);
    //var_dump($post);
?>
<section class="container">
    <h1><?= $post["post"]["title"]?></h1>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-4 image">
                <img style = "width : 400px" src="<?= $post["post"]["path"]?>">
            </div>
            <div class="col-2 offset-5 price ">
                <div class="row">  
                <div style = "font-size: larger; font-weight: 600; background-color: yellow; padding: 15px; margin-top: 20px;"> $<?= $post["post"]["price"]?> </div>
            </div>
            <div class="row"> 
                <div><?= $post["author"]["fname"]?> <?= $post["author"]["lname"]?></div>
            </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 description">
                <?= $post["post"]["text"]?>
            </div>
        </div>
    </div>
</section>