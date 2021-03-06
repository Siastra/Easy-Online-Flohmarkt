<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="res/css/bootstrap.min.css">
    <link rel="stylesheet" href="res/css/all.css">
    <link rel="stylesheet" href="res/css/eof.css">
    <link href="res/css/lightbox.css" rel="stylesheet">
    <link href="res/css/myCss.css" rel="stylesheet">
    <script src="res/js/lightbox-plus-jquery.js"></script>
    <link href="res/css/lightbox.css" rel="stylesheet">
    <title>EOF</title>
</head>
<body>
<header>
    <?php
    session_start();
    $_SESSION["path"] = getcwd();
    $_SESSION["relPath"] = ((dirname($_SERVER["PHP_SELF"]) == "\\") ? "" : dirname($_SERVER["PHP_SELF"]));
    include_once $_SESSION["path"] . "/backend/utility/MsgFactory.php";
    include_once $_SESSION["path"] . '/backend/utility/DB.php';

    $db = new DB();

    if (isset($_SESSION["email"])) {
        $user = $db->getUser($_SESSION["email"]);
    }

    //Message-Banner
    if (isset($_GET["registration"]) && ($_GET["registration"] == "success")) {
        echo MsgFactory::getSuccess("<b>Registration was successful!</b> User account was created!");
    } else if (isset($_GET["registration"]) && ($_GET["registration"] == "fail")) {
        echo MsgFactory::getWarning("<b>Registration failed!</b> Looks like there already exists an user account 
                                            with this E-Mail!");
    } else if (isset($_GET["login"])) {
        if ($_GET["login"] == "success") {
            echo MsgFactory::getSuccess("<b>Login successful!</b>");
        } else if ($_GET["login"] == "fail") {
            if ($_GET["fail"] == "wrongPassword") {
                echo MsgFactory::getWarning("<b>Login failed!</b> Looks like you have entered the wrong password!");
            } else if ($_GET["fail"] == "account404") {
                echo MsgFactory::getWarning("<b>Login failed!</b> Looks like there exists no account with this email!");
            }
        }
    } else if (isset($_GET["logout"])) {
        echo MsgFactory::getSuccess("<b>Logout successful!</b>");
    } else if (isset($_GET["update"])) {
        if ($_GET["update"] == "success") {
            echo MsgFactory::getSuccess("<b>Update successful!</b>");
        } else if ($_GET["update"] == "fail") {
            echo MsgFactory::getWarning("<b>Update failed!</b>");
        }
    } else if (isset($_GET["updatePassword"])) {
        if ($_GET["updatePassword"] == "success") {
            echo MsgFactory::getSuccess("<b>Password Update successful!</b>");
        } else if ($_GET["updatePassword"] == "fail") {
            echo MsgFactory::getWarning("<b>Password Update failed!</b> Looks like something went wrong while updating your password");
        } else if ($_GET["updatePassword"] == "wrongPassword") {
            echo MsgFactory::getWarning("<b>Password Update failed!</b> Looks like you have entered your password wrong!");
        }
    }else if (isset($_GET["resetPassword"])) {
        if ($_GET["resetPassword"] == "success") {
            echo MsgFactory::getSuccess("<b>Password Reset successful!</b> Your new password has been sent to your email!");
        } else if ($_GET["resetPassword"] == "fail") {
            echo MsgFactory::getWarning("<b>Password Reset failed!</b> Looks like something went wrong while resetting your password");
        } else if ($_GET["resetPassword"] == "userNotFound") {
            echo MsgFactory::getWarning("<b>Password Reset failed!</b> Looks like your entered user does not exist!");
        }
    } else if (isset($_GET["deleteUser"])) {
        if ($_GET["deleteUser"] == "success") {
            echo MsgFactory::getSuccess("<b>User account deleted successfully!</b>");
        } else if ($_GET["deleteUser"] == "fail") {
            echo MsgFactory::getWarning("<b>User account deletion failed!</b>");
        }
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php?section=dashboard"><img src="res/images/dashboard.svg"
                                                                        alt="Dashboard icon" class="navbar-icon">
            Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <?php
                if (isset($user)) {
                    echo '<li><a class="nav-link" href="index.php?section=create">
                       <img src="res/images/upload.svg" alt="Upload icon" class="navbar-icon"> New Ad</a></li>';
                                           echo '<li><a class="nav-link" href="index.php?section=chat">
                       <img src="res/images/chat-left-dots.svg" alt="Chat icon" class="navbar-icon"> Chat</a></li>';

                    echo '<li><a class="nav-link" href="index.php?section=favorites">
                        <i class="far fa-star" style = "color: black; font-size: 24px; vertical-align: middle;"></i>  Favorites</a></li>';
                }
                if (isset($user) && $user->isAdmin()) {
                    echo '<li class="nav-item">
                    <a class="nav-link" href="index.php?section=view">
                    <img src="res/images/administrator.svg" alt="Administration icon" class="navbar-icon">User Administration</a>
                </li>';
                }

                ?>
                <li><a class="nav-link" href="index.php?section=search">
                        <img src="res/images/lupe.svg" alt="Search icon" class="navbar-icon"> Search</a></li>
                <li><a class="nav-link" href="index.php?section=about">
                        <img src="res/images/about.svg" alt="About icon" class="navbar-icon"> About</a></li>
            </ul>
            <ul class="navbar-nav navbar-right">
                <?php
                if (isset($user) && (isset($_GET["section"]) && ($_GET["section"] == "profile"))) {
                    echo '<li><a class="nav-link" href="index.php?section=register&edit=true">
                        <img src="res/images/edit.svg" alt="Edit icon" class="navbar-icon">Edit profile</a></li>';
                } else if (isset($user)) {
                    echo '<li><a class="nav-link" href="index.php?section=profile"><img src="' . $user->getPicture() . '" 
                        alt="User icon" class="navbar-icon" id="profilePic">Profile</a></li>';
                }
                if (isset($user)) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="backend/userHandling.php?type=logout"><img src="res/images/logout.svg" 
                            alt="Logout" class="navbar-icon"> Logout</a>
                      </li>';
                } else {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="index.php?section=login"><img src="res/images/login.svg" 
                            alt="Login" class="navbar-icon"> Login</a>
                          </li>';
                }

                ?>
            </ul>
        </div>
    </nav>
</header>
<main>
    <?php
    //Section- Management
    if (isset($_REQUEST["section"])) {
        include "sites/" . $_REQUEST["section"] . ".php";
    } else {
        include "sites/dashboard.php";
    }
    ?>
    <script src="res/js/bootstrap.bundle.min.js"></script>
</main>
</body>
</html>
