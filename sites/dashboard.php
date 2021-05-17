<?php
include_once $_SESSION["path"] . '/backend/model/Advert.php';
include_once $_SESSION["path"] . '/backend/utility/DB.php';

$db = new DB();
$adverts = $db->getAllPosts();
?>
<section id="dashboard" class="container-fluid section-dash">
    <h1 style="text-align: center">Dash</h1>
    <br>
    <div class="row align-items-center dash-container">
        <?php foreach ($adverts as $ad) : $path = "/pictures/Adds/".$ad->getId()."/thumbnail/";?>
            <div class="col-lg-2 col-sm-3 col-6 card m-2 p-0">
                <a class="link-dark" href="index.php?section=post&id=<?=$ad->getId()?>">
                <div class="card-header text-center text-dark"><?=$ad->getTitle()?></div>
                <div class="card-body text-center">
                        <img class='dash-ad-img' src="<?= ((is_file($_SESSION["path"].$path."1.png")) ? $path."1.PNG" : $path."1.jpg")?>">
                        <p class='dash-ad-price text-dark'><?=$ad->getPrice()?>€</p>
                        </div>
                        </a>
                </div>
        <?php endforeach; ?>
    </div>
</section>
