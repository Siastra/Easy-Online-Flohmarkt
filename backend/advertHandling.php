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

if($_REQUEST["type"] == "insert"){
    if ($db->createAdv($advertisement)) {
        $advId=$db->getLatestAdvId();
        for($i=0; $i<sizeof($pic["name"]); $i++){
            Upload::uploadPost($_FILES, $pic["name"][$i],0,$i,$advId);
        }
        $db->assignCategories($advId,$_REQUEST["categories"]);
        header("Location: ../index.php?section=dashboard");
    }else {
        header("Location: ../index.php?section=upload");
    }
}else{
    $ad = $db->getAdById($_REQUEST["type"]);
    $title = (isset($_REQUEST["title"]) ?  $_REQUEST["title"] : $ad->getTitle());
    $price = (isset($_REQUEST["price"]) ?  $_REQUEST["price"] : $ad->getPrice());
    $description = (isset($_REQUEST["description"]) ?  $_REQUEST["description"] : $ad->getDescription());
    $db->editAdv($_REQUEST["type"], $title, $price, $description);
    if($_FILES["picture"]["size"][0] > 0){
        $dir = $_SESSION["path"] . "/pictures/Adds/" . $_REQUEST["type"] . "/full";
        $latestPic = scandir($dir);
        $start = sizeof($latestPic) - 2;
        for($i=0; $i<sizeof($pic["name"]); $i++){
            $start++;
            Upload::uploadPost($_FILES, $pic["name"][$i],$i,sizeof($latestPic) - 2,$_REQUEST["type"]);
        }
    }
    header("Location: ../index.php?section=dashboard");
}
?>