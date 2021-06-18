<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/MsgFactory.php';

$db = new DB();
$edit = isset($_GET["edit"]);
$user = null;
echo '<script>
    $(document).ready(function () {
        let x = document.getElementsByTagName("TITLE")[0];
        x.innerHTML = "Register user";
    });
</script>';

if ($edit) {
    $user = $db->getUser($_SESSION["email"]);
}

?>
<section class="container">
    <h1><?php echo (($edit) ? 'Edit user' : 'User-Registration'); ?></h1>
    <hr>
    <form method="POST" action="backend/userHandling.php" enctype="multipart/form-data" class="was-validated">
        <input type="hidden" name="type" value="<?php echo (($edit) ? 'update' : 'insert'); ?>">
        <input type="hidden" name="id" <?php echo 'value="' . (($edit) ? $user->getId() : '') . '"'; ?>>
        <div class="row">
            <div class="form-group col">
                <label for="picture">Profile image<?php echo (($edit) ? '' : '(optional)')?></label><br><br>
                <input type="file" id="picture" name="picture" accept="image/x-png,image/jpeg">
            </div>
            <div class="form-group col">
                <label for="previewImg">Preview</label><br><br>
                <img id="previewImg" src="<?php echo (($edit) ? $user->getPicture() : 'res/images/user.svg');?> " alt="Placeholder" width="150px"
                     height="150px">
            </div>
        </div>
        <label for="title">Title</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="title" id="male" value="Mr."
                <?php echo(($edit && ($user->getTitle() == "Mr.")) ? ' checked' : ''); ?>>
            <label class="form-check-label" for="male">
                Mr.
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="title" id="female" value="Mrs."
                <?php echo(($edit && ($user->getTitle() == "Mrs.")) ? ' checked' : ''); ?>>
            <label class="form-check-label" for="female">
                Mrs.
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="title" id="diverse" value="kA"
                <?php echo(($edit && ($user->getTitle() == "kA")) ? ' checked' : '');
                echo((!$edit) ? ' checked' : ''); ?>>
            <label class="form-check-label" for="diverse">
                diverse
            </label>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="fname">First name</label>
                <input type="text" class="form-control" id="fname" name="fname"
                       pattern="([A-Z][a-z]+)((\s|-)[A-Z][a-z]+)?" required
                       placeholder="First Name" <?php echo 'value="' . (($edit) ? $user->getFname() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
            <div class="form-group col">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" id="lname" name="lname"
                       pattern="([A-Z][a-z]+)((\s|-)[A-Z][a-z]+)?" required
                       placeholder="Last Name" <?php echo 'value="' . (($edit) ? $user->getLname() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                       pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" required
                    <?php echo 'value="' . (($edit) ? $user->getEmail() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>

            <div class="form-group col">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Sample-street 12"
                       pattern="[A-Z]([a-z]|(ö|ß|ä|ü))+(-[A-Z]([a-z]|(ö|ß|ä|ü))+)* [1-9][0-9]*[a-z]?(/[1-9][0-9]*)*"
                       required
                    <?php echo 'value="' . (($edit) ? $user->getAddress() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
        </div>
        <div class="row">


            <div class="form-group col">
                <label for="plz">PLZ</label>
                <input type="number" class="form-control" id="plz" name="plz"
                       min="1000" max="9999" placeholder="1234"
                       required <?php echo 'value="' . (($edit) ? $user->getPlz() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>

            <div class="form-group col">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Vienna"
                       pattern="[A-Z]([a-z]|(ö|ß|ä|ü))+(( |-)[A-Z]([a-z]|(ö|ß|ä|ü))+)*"
                       required
                    <?php echo 'value="' . (($edit) ? $user->getCity() : '') . '"'; ?>>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field correctly.</div>
            </div>
        </div>
        <?php
        $passwordInput = '
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
        </div>';
        if (!$edit)
         echo $passwordInput;
        ?>

        <button type="submit" class="btn btn-success submit pwSubmit">Submit</button>
    </form>
    <?php
        if ($edit) {
            echo '<h1>Change password</h1><hr>
                    <form enctype="multipart/form-data" method="post" action="backend/userHandling.php">
                      <input type="hidden" name="type" value="updatePw"><div class="row">
                                <div class="form-group col">
                                    <label for="oldPw">Old Password</label>
                                    <input type="password" class="form-control" id="oldPw" placeholder="Old Password" name="oldPw"
                                           pattern="([A-Z]|[a-z]|(ö|ß|ä|ü)|[1-9]){1,32}" required>
                                </div>
                                <div class="col"></div>
                            </div>' .
            $passwordInput . '<button type="submit" class="btn btn-success submit pwSubmit" disabled>Submit</button></form>';
            echo '<h1>Delete user account</h1><hr><br><a type="button" style="color: red;margin-bottom: 5%" href="' . $_SESSION["relPath"] . '/backend/userHandling.php?type=deleteUser&id='
                . $user->getId() . '">Delete account permanently</a>';
        }
    ?>
</section>

<script>
    $('#pw, #pwRepeat').on('keyup', function () { //Shows on key-input, if the two passwords match
        if ($('#pw').val() === $('#pwRepeat').val()) {
            $('#message').html('Matching').css('color', '#28a745');
            $('.pwSubmit').removeAttr('disabled');
        } else {
            $('#message').html('Not Matching').css('color', '#dc3545');
            $('.pwSubmit').attr('disabled', 'disabled');
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