<?php
    include_once $_SESSION["path"] . "/backend/utility/DB.php";
    $db = new DB();
    $post = $db->getAdById(intval($_REQUEST["id"]));
    $id = $post->getId();
    $category = $post->getCategory();

    //$images = ["/res/images/car.jpg",  "/res/images/car.jpg", "/res/images/car2.jpeg", "/res/images/baguette.png"];

    $images = scandir($_SESSION["path"]."/pictures/Adds/$id/full/");
    $images = array_filter($images, function($el){
        return $el != "." && $el != "..";
    });
    // $images = array_map(function($el) use ($id){
    //     return "/pictures/Adds/$id/full/".$el;
    // }, $images);
    // var_dump($images);
    // die;
    function cropThumbnail ($image) {
        $root = $_SESSION["path"] . "/";
        $filepath = pathinfo($image);
        $filename = '/res/images/thumb/' . $filepath['filename'].'.jpg';
        if (is_dir($root . '/res/images/thumb/') && is_file( $root . $filename)) {
            return $filename;
        }
        try {
        
        if (in_array($filepath['extension'], ['jpeg', 'jpg'])) {
            $image = imagecreatefromjpeg($root . $image);
        } else if ($filepath['extension'] == 'png') {
            $image = imagecreatefrompng($root . $image);
        } else {
            return "/res/images/No-Image-Found.png";
        }
        if (!is_dir($root . '/res/images/thumb/')) {
            mkdir($root . '/res/images/thumb/', 0755, true);
        }

        $thumb_width = 150;
        $thumb_height = 150;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $width >= $height)
        {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
        }
        else
        {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

        // Resize and crop
        imagecopyresampled($thumb,
                        $image,
                        0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                        0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                        0, 0,
                        $new_width, $new_height,
                        $width, $height);
        imagejpeg($thumb, $root . $filename, 80);
        return $filename;
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }
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
                    <a href="<?="/pictures/Adds/$id/full/".$limage?>" data-lightbox="roadtrip"><img class = "col-12" src="<?="/pictures/Adds/$id/half/".$limage?>" ></a>
                </div>
                <div class="row col-12 mt-2 ">
                    <?php if (count($images)) : ?>
                        <?php foreach($images as $image): ?>
                            <a class = "col-3 p-0" href="<?="/pictures/Adds/$id/full/".$image?>" data-lightbox="roadtrip">
                                <img class = "col-12 p-1" src = "<?="/pictures/Adds/$id/thumbnail/".$image?>" >
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
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
    $(document).ready(function(){
        console.log("jquery is working");
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
    })
</script>