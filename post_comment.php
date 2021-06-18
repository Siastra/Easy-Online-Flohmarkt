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
?>