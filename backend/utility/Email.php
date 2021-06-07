<?php
session_start();

class Email
{


    public static function sendNewPw(User $user) : void
    {
        $config = json_decode(file_get_contents($_SESSION["path"] . "/config/config.json"), true);
        $to = $user->getEmail();
        $subject = 'Your new password!';
        $message = "Dear ". (($user->getTitle() == 'kA') ? '' : $user->getTitle()) . ' ' . $user->getLname() . "!\nYour new password: " .
            $user->getPassword() . "\nBest regards,\nThe Admin";
        $headers = "From: " . $config["email"] . "\r\n";
        if (mail($to, $subject, $message, $headers)) {
            echo "SUCCESS";
        } else {
            echo "ERROR";
        }
    }

}