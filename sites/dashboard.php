<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/model/Advert.php';
    $testAd1 = new Advert(1, 1, "testAd1", 69, "this is a test1");
    $testAd2 = new Advert(2, 1, "testAd2", 70, "this is a test2");
    $testAd3 = new Advert(3, 1, "testAd3", 71, "this is a test3");
    $testAd4 = new Advert(4, 1, "testAd4", 72, "this is a test4");
    $testAd5 = new Advert(5, 1, "testAd5", 73, "this is a test5");
    $testAd6 = new Advert(6, 1, "testAd6", 74, "this is a test6");
    $testAds = array($testAd1,$testAd2,$testAd3,$testAd4,$testAd5,$testAd6);
?>
<section id="dashboard" class="container">
    <h1 style="text-align: center">Dash</h1>
    <br>
    <div class="h-100 row align-items-center">
        <?php
        $a = 0;
        foreach ($testAds as $testAd){
            echo    "<div class='col-lg-3 col-sm-4 col-6 p-0'>
                        <a href='' class='dash-ad-title'>".$testAd->getTitle()."</a>
                        <a href='' class='dash-img-container'><img class='dash-ad-img' src='/res/images/baguette.png'></a>
                        <p class='dash-ad-price'>".$testAd->getPrice()."€</p>".
                    "</div>";
            $a++;
        }
        ?>
    </div>
</section>
