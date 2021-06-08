<?php
include_once $_SESSION["path"] . '/backend/model/Advert.php';
include_once $_SESSION["path"] . '/backend/utility/DB.php';

$db = new DB();
if(isset($_GET['search'])){
    $searchTerm=$_GET["search"];
    $adverts = $db->getAdvByText($searchTerm);
}elseif(isset($_GET["category"])){
    $searchTerm=$_GET["category"];
    $adverts = $db->getAdvByCategory($searchTerm);
}
elseif(isset($_GET["sortTerm"])){
    $sortTerm=$_GET["sortTerm"];
    $adverts = $db->getAdvSorted($sortTerm);
}else{
    $adverts = $db->getAllPosts();
}
?>
<section id="dashboard" class="container-fluid section-dash">
    <h1 style="text-align: center">Dash</h1>
    <br>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sort By
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="index.php?section=dashboard&sortTerm=DateDown">Sort by Date(newest First)</a>
            <a class="dropdown-item" href="index.php?section=dashboard&sortTerm=DateDown">Sort by Date(oldest First)</a>
            <a class="dropdown-item" href="index.php?section=dashboard&sortTerm=NameUp">Sort by Name(Ascending)</a>
            <a class="dropdown-item" href="index.php?section=dashboard&sortTerm=NameDown">Sort by Name(Descending)</a>
            <a class="dropdown-item" href="index.php?section=dashboard&sortTerm=PriceUp">Sort by Price(Ascending)</a>
            <a class="dropdown-item" href="index.php?section=dashboard&sortTerm=PriceDown">Sort by Price(Descending)</a>

        </div>
    </div>
    <div class="row align-items-center dash-container">
        <?php foreach ($adverts as $ad) :?>
            <div class="col-lg-2 col-sm-3 col-6 card m-2 p-0">
                <a class="link-dark" href="index.php?section=post&id=<?=$ad->getId()?>">
                <div class="card-header text-center text-dark"><?=$ad->getTitle()?></div>
                <div class="card-body text-center">
                        <img class='dash-ad-img' src="<?=$ad->getPicture()?>">
                        <p class='dash-ad-price text-dark'><?=$ad->getPrice()?>€</p>
                        </div>
                        </a>
                </div>
        <?php endforeach; ?>
    </div>
</section>
