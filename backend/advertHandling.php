<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Easy-Online-Flohmarkt/backend/utility/DB.php';

$db = new DB();
$advertisment = new Advert(1,1, $_REQUEST["title"], $_REQUEST["price"], $_REQUEST["description"]);

    if ($db->createAdv($advertisment)) {
        header("Location: ../index.php?section=dashboard");
    }else {
        header("Location: ../index.php?section=upload");
}

?>