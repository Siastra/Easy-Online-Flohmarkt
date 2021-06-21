<?php

session_start();
include_once $_SESSION["path"] . '/backend/utility/DB.php';

 header( 'Content-Type: application/json' );
 header( 'Access-Control-Allow-Origin: *' );
 header( 'Access-Control-Allow-Methods: GET' );

// header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );

$data = json_decode( file_get_contents( 'php://input' ), true );
$db = new DB();
echo json_encode($db->fetchUser($data['_post_id']), JSON_PRETTY_PRINT);