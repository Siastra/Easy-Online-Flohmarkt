<?php    
    session_start();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/backend/utility/MsgFactory.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/model/Comment.php';


    $db = new DB();
    if (isset($_SESSION["email"])) {
        $score = new Comment(0, $_POST["author_id"], $_POST["user_id"], (int) $_POST["score"], $_POST["comment"] );
        $score->save();
    }
    $comments = $db->getCommentsByUser($_POST["user_id"]);
    foreach ($comments as $comment):
?>
    <hr>
<div class = "row">
<div class = "col-3 text-center align-middle my-auto">
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
<?= $c_User->getFname() . " \t" . $c_User->getLname();  ?>
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
<div class = "row">
<?= $comment["created_at"]; ?>
</div>
</div>
</div>
<?php endforeach; ?>