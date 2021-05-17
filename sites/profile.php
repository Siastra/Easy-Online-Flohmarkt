<?php

echo '<script>
    $(document).ready(function () {
        let x = document.getElementsByTagName("TITLE")[0];
        x.innerHTML = "Profile Page";
    });
</script>';

$db = new DB();
$user = $db->getUser($_SESSION["email"]);
$ads = $db->getAdsByUser($user->getId());
?>


<section class="container">
    <!--User header-->
    <div class="row user-header">
        <div class="col-3">
            <img src="<?php echo $user->getPicture(); ?>" alt="Profile Picture" class="img-fluid user-picture">
        </div>
        <div class="col-9">
            <?php
                echo '<h1>' . $user->getFname() . ' ' . $user->getLname() . '</h1>';
                echo '<p>' . $user->getEmail() . '</p>';
                echo '<p>' . $user->getAddress() . ', ' . $user->getPlz() . ' ' . $user->getCity() . '</p>';
                echo '<p>' . sizeof($ads) . ' Ads</p>';
            ?>
        </div>
    </div>
    <?php
        //Post thumbnails
        for ($i = 0; $i < sizeof($ads); $i++) {
            if ($i == 0) {
                echo '<div class="galleryRow row">';
            }

            echo '<div class="galleryItem">
                    <div class="row itemHeader">
                        <div class="col">
                            <button class="btn btn-danger float-right" onclick="deletePost(' .
                                ($ads[$i]->getId()) . ')">X</button>
                        </div>
                    </div>
                    <div class="row">
                        <a class="col" href="index.php?section=post&id=' . ($ads[$i]->getId()) . '"><img alt="' . $ads[$i]->getTitle() .
                '" src="' . $ads[$i]->getPicture() . '"></a>
                    </div>
                </div>';
            if (($i == (sizeof($ads)-1)) && (sizeof($ads) % 6) != 0) {
                echo '</div>';
            }
        }
    ?>
</section>

<script>

    function deletePost(id) {
        $.ajax({
            type: "POST",
            url: 'ajax/deletePost.php',
            data:{id: id},
        }).then(
            function() {
                location.reload();
            }, function() {
            }
        );

    }
</script>