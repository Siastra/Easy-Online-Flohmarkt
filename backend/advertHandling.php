<?php
session_start();
include_once $_SESSION["path"] . '/backend/utility/DB.php';
include_once $_SESSION["path"] . '/backend/utility/Upload.php';
$db = new DB();
$user=$db->getUser($_SESSION['email']);
$id=$user->getId();
$advertisement = new Advert(1,$id, $_REQUEST["title"], $_REQUEST["price"],$_REQUEST["description"] ,$user, new DateTime());
$pic=$_FILES["picture"];
$id=$user->getId();
$advId=$db->getLatestAdvId();
var_dump($pic);
    if ($db->createAdv($advertisement)) {
        for($i=0;$i<sizeof($pic["name"]);$i++){
            Upload::uploadPost($_FILES, $pic["name"][$i],$id,$i,$advId);

        }
        header("Location: ../index.php?section=dashboard");
    }else {
        header("Location: ../index.php?section=upload");
}

?>