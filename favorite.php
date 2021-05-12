<?php
    session_start();
    include_once $_SERVER["DOCUMENT_ROOT"] . "/backend/utility/MsgFactory.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';

    $db = new DB();
    $user = NULL;
    $advert_id = $_GET["advert_id"] ?? NULL;
    if (isset($_SESSION["email"])) {
        $user = $db->getUser($_SESSION["email"]);
    }
    if (is_null ($user) || is_null ($advert_id)) {
        echo "{}"; die;
    }
    $db->updateFavoritesForUser($user, $advert_id);
    //var_dump ($user);