<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="res/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/eof.css">
    <link href="res/css/lightbox.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="res/js/lightbox-plus-jquery.js"></script>

    <title>EOF</title>
</head>
<body>
<header>
    <?php
    $app_dir = dirname(__FILE__);
    include_once dirname(__FILE__) . "/backend/utility/MsgFactory.php";

    //Message-Banner
    if (isset($_GET["registration"]) && ($_GET["registration"] == "success")) {
        echo MsgFactory::getSuccess("<b>Registration was successful!</b> User account was created!");
    }else if (isset($_GET["registration"]) && ($_GET["registration"] == "fail")){
        echo MsgFactory::getWarning("<b>Registration failed!</b> Looks like there already exists an user account 
                                            with this E-Mail!");
    }
    ?>
</header>
<main>
    <?php
    //Section- Management
    if (isset($_GET["section"])) {
        switch ($_GET["section"]) {
            case "register":
                include "sites/registrationForm.php";
                break;
            case "post":
                if (isset($_GET["post"])) {
                    $post_id = $_GET["post"];
                    include "sites/post.php";
                    break;
                }
            case "upload":
                include  "sites/createAdv.php";
                break;
            default:
                include "sites/dashboard.php";
                break;
        }
    }else {
        include "sites/dashboard.php";
    }
    ?>
    <script src="res/js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
</main>
</body>
</html>