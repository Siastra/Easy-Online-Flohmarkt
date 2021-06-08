<?php
session_start();
include_once $_SESSION["path"] . "/backend/utility/DB.php";

$db = new DB();
if ($db->deletePostById($_POST["id"])) {
    echo json_encode("Success");
}