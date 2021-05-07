<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/model/Advert.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';

$db = new DB();
$adverts = $db->getAllPosts();
?>
<section id="dashboard" class="container-fluid section-dash">
    <h1 style="text-align: center">Dash</h1>
    <br>
    <div class="h-100 row align-items-center dash-container">
        <?php
        foreach ($adverts as $ad) {
            echo "<div class='col-lg-2 col-sm-3 col-6 dash-ad-container'>
                        <a href='index.php?section=post&id=" . $ad->getId() . "' class='dash-ad-title'>" . $ad->getTitle() . "</a>
                        <a class='dash-img-container'><img class='dash-ad-img' src='/res/images/car.jpg'></a>
                        <p class='dash-ad-price'>" . $ad->getPrice() . "€</p>" .
                "</div>";
        }
        ?>
    </div>
</section>
