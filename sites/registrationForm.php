<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/MsgFactory.php';

$db = new DB();
$fill = false;
$user = null;
echo '<script>
    $(document).ready(function () {
        let x = document.getElementsByTagName("TITLE")[0];
        x.innerHTML = "Register user";
    });
</script>';

//password has not matched, so form must be filled
if (isset($_POST["pw"]) && ($_POST["pw"] != $_POST["pwRepeat"])) {
    echo MsgFactory::getWarning("Please make sure your password matches!");
    $user = new User(1, $_REQUEST["title"], $_REQUEST["fname"], $_REQUEST["lname"],
        $_REQUEST["address"], $_REQUEST["plz"], $_REQUEST["city"], $_REQUEST["email"], " ");
    $fill = true;
}else if (isset($_POST["type"])) {
    echo '<form id="myForm" action="backend/userHandling.php" 
    method="post" enctype="multipart/form-data">';
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="' . $a . '" value="' . $b . '">';
    }
    echo '</form>';
    echo '<script type="text/javascript">document.getElementById("myForm").submit();</script>';
}


?>
<section class="container">
    <h1>User-Registration</h1>
    <hr>
    <form method="POST" action="index.php?section=register" enctype="multipart/form-data" class="was-validated">
        <input type="hidden" name="type" value="insert">
        <input type="hidden" name="id" <?php echo 'value="' . (($fill) ? $user->getId() : '') . '"'; ?>>
        <label for="title">Title</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="title" id="male" value="Mr."
                <?php echo(($fill && ($user->getTitle() == "Mr.")) ? ' checked' : ''); ?>>
            <label class="form-check-label" for="male">
                Mr.
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="title" id="female" value="Mrs."
                <?php echo(($fill && ($user->getTitle() == "Mrs.")) ? ' checked' : ''); ?>>
            <label class="form-check-label" for="female">
                Mrs.
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="title" id="diverse" value="kA"
                <?php echo(($fill && ($user->getTitle() == "kA")) ? ' checked' : '');
                echo((!$fill) ? ' checked' : ''); ?>>
            <label class="form-check-label" for="diverse">
                diverse
            </label>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="fname">First name</label>
                <input type="text" class="form-control" id="fname" name="fname"
                       pattern="([A-Z][a-z]+)((\s|-)[A-Z][a-z]+)?" required
                       placeholder="First Name" <?php echo 'value="' . (($fill) ? $user->getFname() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
            <div class="form-group col">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" id="lname" name="lname"
                       pattern="([A-Z][a-z]+)((\s|-)[A-Z][a-z]+)?" required
                       placeholder="Last Name" <?php echo 'value="' . (($fill) ? $user->getLname() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                       pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" required
                    <?php echo 'value="' . (($fill) ? $user->getEmail() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>

            <div class="form-group col">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Sample-street 12"
                       pattern="[A-Z]([a-z]|(ö|ß|ä|ü))+(-[A-Z]([a-z]|(ö|ß|ä|ü))+)* [1-9][0-9]*[a-z]?(/[1-9][0-9]*)*"
                       required
                    <?php echo 'value="' . (($fill) ? $user->getAddress() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
        </div>
        <div class="row">


            <div class="form-group col">
                <label for="plz">PLZ</label>
                <input type="number" class="form-control" id="plz" name="plz"
                       min="1000" max="9999" placeholder="1234"
                       required <?php echo 'value="' . (($fill) ? $user->getPlz() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>

            <div class="form-group col">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Vienna"
                       pattern="[A-Z]([a-z]|(ö|ß|ä|ü))+(( |-)[A-Z]([a-z]|(ö|ß|ä|ü))+)*"
                       required
                    <?php echo 'value="' . (($fill) ? $user->getCity() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="pw">Password</label>
                <input type="password" class="form-control" id="pw" placeholder="Password" name="pw"
                       pattern="([A-Z]|[a-z]|(ö|ß|ä|ü)|[1-9]){1,32}" aria-describedby="pwHelp" required>
                <small id="pwHelp" class="form-text text-muted">Make sure your password only contains letters and digits
                    ;)</small>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>

            <div class="form-group col">
                <label for="pwRepeat">Repeat password</label>
                <input type="password" class="form-control" id="pwRepeat" name="pwRepeat"
                       pattern="([A-Z]|[a-z]|(ö|ß|ä|ü)|[1-9]){1,32}" placeholder="Password repeat" required>
                <span id="message" style="font-size: 80%;"></span>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
        </div>

        <button type="submit" class="btn btn-success submit">Submit</button>
    </form>
</section>

<script>
    $('#pw, #pwRepeat').on('keyup', function () { //Shows on key-input, if the two passwords match
        if ($('#pw').val() === $('#pwRepeat').val()) {
            $('#message').html('Matching').css('color', '#28a745');
            $('.submit').disabled = false;

        } else {
            $('#message').html('Not Matching').css('color', '#dc3545');
            $('.submit').disabled = false;
        }
    });

    function readURL(input) { //Image-Preview
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#picture").change(function() { //Image-Preview
        readURL(this);
    });
</script>