<?php

session_start();
include_once $_SESSION['path'] . '/backend/utility/DB.php';

header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: GET' );

// header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );

$db = new DB();
$sessionUser = $db->getUser( $_SESSION['email']);
$data['userId'] = $sessionUser->getID(); 
$user = $db->fetchUserById($data);
echo json_encode($user, JSON_PRETTY_PRINT);