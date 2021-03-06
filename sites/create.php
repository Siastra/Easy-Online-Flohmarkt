<?php
include_once $_SESSION["path"] . '/backend/utility/DB.php';
include_once $_SESSION["path"] . '/backend/utility/MsgFactory.php';
$db = new DB();
$categories = $db->getAllCategories();
$edit = 0;
if(isset($_GET["edit"])){
    $edit = $_GET["edit"];
    $ad = $db->getAdById($_GET["edit"]);
}
?>

<script>
    $(document).ready(function () {
        let x = document.getElementsByTagName("TITLE")[0];
        x.innerHTML = "Upload Post";
        document.getElementById("title").value = "<?php echo (isset($ad) ? $ad->getTitle() : ''); ?>";
        document.getElementById("price").value = "<?php echo (isset($ad) ? $ad->getPrice() : ''); ?>";
        document.getElementById("description").value = "<?php echo (isset($ad) ? $ad->getDescription() : ''); ?>";
        <?php echo (isset($ad) ?  'document.getElementById("'.$ad->getCategory()["id"].'").checked = true;' : ''); ?>
    });

</script>

<section class="container">
    <h1>Sell your old Stuff!</h1><br><br>
    <form method="post" action="backend/advertHandling.php" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <input type="hidden" name="type" value="<?php echo (($edit) ? $edit : 'insert'); ?>">
                <div class="row">
                    <div class="col form-group">
                        <label for="picture">Post image</label><br><br>
                        <input type="file" id="picture" name="picture[]" accept="image/x-png,image/jpeg" multiple>
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="title">Title:</label>
                        <input type="text" placeholder="Title" name="title" id="title" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="tags">Price:</label>
                        <input type="number" placeholder="444 " name="price" id="price" maxlength="16"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col form-group">
                        <label for="description">Description:</label>
                        <input type="text" placeholder="Text " name="description" id="description"/>
                    </div>
                </div>

                        <?php
                        foreach ($categories as $category):

                        echo "<div class='form-check'>
                    <input class='form-check-input' type='radio' name='categories' value=".$category['id']."  id=".$category['id'].">
                    <label class='form-check-label' for=".$category['id'].">
                       ".$category['name']."
                    </label>
                </div>";
                        endforeach;
                        ?>


                <button class="btn btn-success submit" type="submit" name="upload">Upload</button>
            </div>
            <div class="form-group col">
                <label for="previewPost">Preview</label><br><br>
                <img id="previewPost" src="res/images/user.svg" alt="Placeholder" width="450px"
                     height="450px">
            </div>
        </div>
    </form>
</section>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                console.log(e.target.result);
                $('#previewPost').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#picture").change(function () {
        readURL(this);
    });
</script>
   