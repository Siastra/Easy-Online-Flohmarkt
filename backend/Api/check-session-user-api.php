<?php
session_start();

include_once $_SESSION['path'] . '/backend/utility/DB.php';

header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: POST' );

// header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );
// $data = json_decode( file_get_contents( 'php://input' ), true );

$db = new DB();
$sessionUser = $db->getUser( $_SESSION['email']);
$data['userId'] = $sessionUser->getID(); 
$user = $db->fetchUserById($data);
echo json_encode($user, JSON_PRETTY_PRINT);
// $data['userId'] = 2;
// $user = $db->fetchUserById($data);

//  if($sessionUser->getId() === $user[0]())
//  echo json_encode( array( 'Session user' => 'true' ) );
//  else
// echo json_encode( array( 'Session user' => 'false' ) );