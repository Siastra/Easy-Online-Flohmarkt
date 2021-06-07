<?php
session_start();
include_once $_SESSION["path"] . '/backend/utility/DB.php';
include_once $_SESSION["path"] . '/backend/utility/create.php';
$db = new DB();
$user=$db->getUser($_SESSION['email']);
$id=$user->getId();
$advertisement = new Advert(1, $_REQUEST["title"], $_REQUEST["price"] ,$user, new DateTime(),$_REQUEST["description"]);
$pic=$_FILES["picture"];
$id=$user->getId();

    if ($db->createAdv($advertisement)) {
        $advId=$db->getLatestAdvId();
        for($i=0;$i<sizeof($pic["name"]);$i++){
            Upload::uploadPost($_FILES, $pic["name"][$i],$id,$i,$advId);

        }
        $db->assignCategories($advId,$_REQUEST["categories"]);
        header("Location: ../index.php?section=dashboard");
    }else {
        header("Location: ../index.php?section=upload");
}

?>