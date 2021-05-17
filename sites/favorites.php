<?php if (!isset($user)) {
    header("Location: /index.php?section=dashboard");
} ?>
<?php
include_once $_SESSION["path"] . '/backend/model/Advert.php';
include_once $_SESSION["path"] . '/backend/utility/DB.php';

$db = new DB();
$adverts = $db->getFavoritesAdverts($user->getId());
?>
<section id="dashboard" class="container-fluid section-dash">
    <h1 style="text-align: center">Favorites</h1>
    <br>
    <div class="h-100 row align-items-center dash-container">
        <?php foreach ($adverts as $ad) : ?>
            <div class="col-lg-2 col-sm-3 col-6 card m-2 p-0">
                <a class="link-dark" href="index.php?section=post&id=<?=$ad->getId()?>">
                <div class="card-header text-center text-dark"><?=$ad->getTitle()?></div>
                <div class="card-body text-center">
                        <img class='dash-ad-img' src="<?= $ad->getPicture() ?>">
                        <p class='dash-ad-price text-dark'><?=$ad->getPrice()?>€</p>
                        </div>
                        </a>
                        <a href="#" data-id = "<?=$ad->getId()?>" class="delete-favorite btn btn-danger"><i class="fas fa-trash"></i> Remove</a>
                </div>
        <?php endforeach; ?>
    </div>
</section>
<script>
    $(document).ready(function(){    
        $(".delete-favorite").click(function (e) {
            e.preventDefault();
            let ct = e.currentTarget;
            let id = $(ct).data("id");
            console.log(id);
            $.get("<?php echo $_SESSION["relPath"] ?>/favorite.php", {advert_id : id}, function () {
                $(ct).parents(".card").hide();
            })
        })
    })
</script>