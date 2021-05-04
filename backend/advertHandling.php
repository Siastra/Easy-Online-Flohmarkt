<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/Upload.php';
$db = new DB();
$user=$db->getUser($_SESSION['email']);
$advertisement = new Advert(1, $_REQUEST["title"], $_REQUEST["price"], $user, new DateTime(), $_REQUEST["description"]);


    if ($db->createAdv($advertisement)) {
        $pic=$_FILES["picture"];
        Upload::uploadPost($_FILES, $pic["name"]);
        header("Location: ../index.php?section=dashboard");
    }else {
        header("Location: ../index.php?section=upload");
}

?>