<?php
session_start();

include_once $_SESSION['path'] . '/backend/utility/DB.php';

header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: POST' );

// header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With' );
$data = json_decode( file_get_contents( 'php://input' ), true );

$db = new DB();

$user = $db->getUser( $_SESSION['email'] );

$post_id = $data['_post_id'];
$db->insertFriend( $user->getID(),$post_id );

echo json_encode( array( 'Message' => '- New chat is created' ) );