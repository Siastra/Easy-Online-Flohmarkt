<?php
    include_once $_SERVER["DOCUMENT_ROOT"] . "/backend/utility/DB.php";
    $post = (new DB())->getPost($_GET['post']);
    //var_dump($post);
    $images = [
    //];
    "/res/images/car.jpg",  "/res/images/car.jpg", "/res/images/car2.jpeg", "/res/images/baguette.png"];
    function cropThumbnail ($image) {
        $filepath = pathinfo($image);
        $filename = '/res/images/thumb/' . $filepath['filename'].'.jpg';
        if (is_dir($_SERVER["DOCUMENT_ROOT"] . '/res/images/thumb/') && is_file( $_SERVER["DOCUMENT_ROOT"] . $filename)) {
            return $filename;
        }
        try {
        
        if (in_array($filepath['extension'], ['jpeg', 'jpg'])) {
            $image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"] . $image);
        } else if ($filepath['extension'] == 'png') {
            $image = imagecreatefrompng($_SERVER["DOCUMENT_ROOT"] . $image);
        } else {
            return "/res/images/No-Image-Found.png";
        }
        if (!is_dir($_SERVER["DOCUMENT_ROOT"] . '/res/images/thumb/')) {
            mkdir($_SERVER["DOCUMENT_ROOT"] . '/res/images/thumb/', 0755, true);
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
        imagejpeg($thumb, $_SERVER["DOCUMENT_ROOT"] . $filename, 80);
        return $filename;
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }
?>
<section class="container">
    <h1><?= $post["post"]["title"] ?></h1>
    <hr>
    <div class="container">
        <div class="row">
            <div class="row col-8 image">
                <div class="row mx-auto">
                    <?php
                        if (count($images)) {
                            $limage = array_shift($images);
                        } else {
                            $limage = "/res/images/No-Image-Found.png";
                        }
                    ?>
                    <a href="<?=$limage?>" data-lightbox="roadtrip"><img class = "col-12" src="<?=$limage?>" ></a>
                </div>
                <div class="row col-12 mt-2 ">
                    <?php if (count($images)) : ?>
                        <?php foreach($images as $image): ?>
                            <a class = "col-3 p-0" href="<?=$image?>" data-lightbox="roadtrip">
                                <img class = "col-12 p-1" src = "<?=cropThumbnail($image)?>" >
                            </a>
                        <?php endforeach;?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-4 price ">
                <div class="row">  
                <div class="col-12 text-center"  style = "font-size: larger; font-weight: 600; background-color: yellow; padding: 15px; margin-top: 20px;"> $<?= $post["post"]["price"]?> </div>
            </div>
            <div class="row"> 
                <a href="#" class="button btn-primary p-2 my-2 col-12 text-center">Chat</a>
            </div>
            <div class="row"> 
                <div><?= $post["author"]["fname"] ?> <?= $post["author"]["lname"] ?></div>
            </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 description">
            <?= $post["post"]["text"] ?>
            </div>
        </div>
    </div>
</section>
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>