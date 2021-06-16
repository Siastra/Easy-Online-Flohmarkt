<?php
    include_once $_SESSION["path"] . "/backend/utility/DB.php";
    $db = new DB();
    $post = $db->getAdById(intval($_REQUEST["id"]));
    $comments = $db->getCommentsByUser($post->getUser()->getId());
    $id = $post->getId();
    $category = $post->getCategory();

    $images = scandir($_SESSION["path"]."/pictures/Adds/$id/full/");
    $images = array_filter($images, function($el){
        return $el != "." && $el != "..";
    });
?>
<section class="container">
<div class="row d-flex">
    <h5 class="container row mb-2"><?= $category?$category["name"]:"" ?></h5>
    <h1 class="mr-auto"><?= $post->getTitle() ?></h1>

    <?php if (isset($user)) : ?>
        <?php if ($user->haveFavorite($post->getId()))  :?>
    <a id = "js-favorite" class="btn btn-outline-primary mt-2" style ="height: 60%" href="#"><i class="fas fa-star"></i> favorite</a>
    <?php else :?>
    <a id = "js-favorite" class="btn btn-outline-primary mt-2" style ="height: 60%" href="#"><i class="far fa-star"></i> favorite</a>
    <?php endif; ?>
    <?php endif; ?>

    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-8 image mr-auto">
                <div class="row mx-auto">
                    <?php
                        if (count($images)) {
                            $limage = array_shift($images);
                        } else {
                            $limage = "/res/images/No-Image-Found.png";
                        }
                    ?>
                    <a href="<?=$_SESSION["relPath"]."/pictures/Adds/$id/full/".$limage?>" data-lightbox="roadtrip">
                        <img class = "col-12" alt="<?=$limage?>" src="<?=$_SESSION["relPath"]."/pictures/Adds/$id/half/".$limage?>" >
                    </a>
                </div>
                <div class="row col-12 mt-2 ">
                    <?php if (count($images)) : ?>
                        <?php foreach($images as $image): ?>
                            <a class = "col-3 p-0" href="<?=$_SESSION["relPath"]."/pictures/Adds/$id/full/".$image?>" data-lightbox="roadtrip">
                                <img class = "col-12 p-1" alt="<?=$image?>" src = "<?=$_SESSION["relPath"]."/pictures/Adds/$id/thumbnail/".$image?>" >
                            </a>
                        <?php endforeach;?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-4 price px-0">
                <div class="row">  
                <div class="col-12 text-center"  style = "font-size: larger; font-weight: 600; background-color: yellow; padding: 15px; margin-top: 20px;"><?= $post->getPrice()?>€ </div>
            </div>
            <div class="row"> 
                <a href="#" class="button btn-primary p-2 my-2 col-12 text-center">Chat</a>
            </div>
            <div class="row"> 
                <div class="container"><div class="row"><?= $post->getUser()->getFname() ?> <?= $post->getUser()->getLname() ?></div>
                <div class="row"><?= $post->getUser()->getAddress() ?></div>
                <div class="row">
                <div class="score">
                <?= sprintf("%01.2f", $post->getUser()->getScore());?>
                </div>
                <div class="score_star">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php $tmp = $post->getUser()->getScore() - $i;?>
                    <?php if ($tmp >= 0): ?>
                        <i class="fas fa-star"></i>
                    <?php elseif ($tmp > -1): ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php else: ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                <?php endfor; ?>
                </div>
                <a href="#" id="js-showcomments">See comments</a>
                </div></div>
            </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 description">
            <?= $post->getDescription() ?>
            </div>
        </div>
    </div>
</section>
<form action="" class="modal_form" style="display: none">
<?php if (isset($user) && $user->getId() != $post->getUser()->getId()):  ?>
<i id="1" class="fas fa-star js-score"></i>
<i id="2" class="far fa-star js-score"></i>
<i id="3" class="far fa-star js-score"></i>
<i id="4" class="far fa-star js-score"></i>
<i id="5" class="far fa-star js-score"></i>
<?php endif;  ?>
<i id="js-mfClose" class="fas fa-times " style="position : absolute; right : 0px; top: 0px; font-size: 20px;"></i>
<?php if (isset($user) && $user->getId() != $post->getUser()->getId()):  ?>
<input type="hidden" id="score" value="1">
<br>
<textarea name="comment" id="comment" cols="60" rows="3"></textarea>
<br>
<a href="#" id="js-submit" class="button btn btn-primary">Save</a>
<?php endif;  ?>
<?php foreach($comments as $comment) :?>
<hr>
<div class = "row">
<div class = "col-3">
<?php $c_User = $db->getUserById($comment["author_id"]); ?>   
<?php if (!is_null($c_User )):  ?>
<img src="<?= $c_User->getPicture();  ?>" style="width: 50px">
<?php else:  ?>
<img src="/res/images/user.svg" style="width: 50px">
<?php endif;  ?>
</div>
<div class = "col-8">
<div class = "row">
<?php if (!is_null($c_User )):  ?>
<?= $c_User->getFname();  ?>
<?= $c_User->getLname();  ?>
<?php else:  ?>
noname
<?php endif;  ?>
</div>
<div class = "row">
<div class="score_star">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php $tmp = (int)$comment["score"] - $i;?>
                    <?php if ($tmp >= 0): ?>
                        <i class="fas fa-star"></i>
                    <?php elseif ($tmp > -1): ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php else: ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                <?php endfor; ?>
                </div>
</div>
<div class = "row">
<?= $comment["comment"]; ?>
</div>
</div>
</div>
    <?php endforeach;?>
</form>
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
    $(document).ready(function(){
        console.log("jquery is working");
        $(".js-score").on("mouseenter", function(e){
            let score = parseInt(this.id);
            //console.log(score);
            let score_stars = $(".js-score");
            //console.log(score_stars);
            score_stars.map(function(i, el){
                //console.log(el);
                if(parseInt(el.id) <= score){
                    el.classList.add("fas");
                    el.classList.remove("far");
                }
            });
        });
        $(".js-score").on("click", function(e){
            let hidden_score = $("#score");
            hidden_score.val(this.id);
        });
        $("#js-submit").on("click", function(e){
            e.preventDefault();
            let hidden_score = $("#score");
            let comment = $("#comment");
            $.post("/post_comment.php", {
                score : hidden_score.val(), 
                comment : comment.val(),
                user_id : <?= $post->getUser()->getId() ?>,
                author_id : <?= isset($user)?$user->getId(): 0 ?>
            })
        });
        $(".js-score").on("mouseleave", function(e){
            let hidden_score = $("#score");
            let score_stars = $(".js-score");
            console.log(hidden_score.val());
            score_stars.map(function(i, el){
                //console.log(el);
                if(parseInt(el.id) <= parseInt(hidden_score.val())){
                    el.classList.add("fas");
                    el.classList.remove("far");
                } else {
                    el.classList.add("far");
                    el.classList.remove("fas");
                }
            });
            //this.classList.add("far");
            //this.classList.remove("fas");
        })
        $("#js-favorite").click(function(e){
            e.preventDefault()
            $.get("<?php echo $_SESSION["relPath"] ?>/favorite.php", {
                "advert_id":<?= $post->getId(); ?>
            },function (){
                let star = $("#js-favorite").find("i");
                if (star.hasClass("fas")){
                    star.removeClass("fas");
                    star.addClass("far");
                }
                else {
                    star.removeClass("far");
                    star.addClass("fas");
                }
            })
        })
        $("#js-showcomments").click(function(e){
            e.preventDefault()
            $(".modal_form").show();
        })
        $("#js-mfClose").click(function(){
            $(".modal_form").hide();
        })
    })
</script>