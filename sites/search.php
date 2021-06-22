<?php
echo '<script>
    $(document).ready(function () {
        let x = document.getElementsByTagName("TITLE")[0];
        x.innerHTML = "Search";
    });
</script>';
if(isset($_GET["search"])){
    header("Location: index.php?section=dashboard&search=".$_GET["search"]."");
}
$db = new DB();
$tags = $db->getAllCategories();
?>
<div id="searchBody">
    <div class="container">
        <form action="index.php?section=search" type="GET">
            <h2>Search for Advertisments:</h2><br>
            <!--<div>
                <input type="text" placeholder="Search " name="search" id="search"/>
                <button class="btn btn-success submit" type="submit">Search</button>
            </div>-->
            <div class="input-group w-50">
                <div class="input-group-prepend">
                    <button class="btn btn-success submit" type="submit">Search</button>
                </div>
                <input type="text" placeholder="Search " name="search" id="search" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
            </div>
        </form>
    </div><br><br>
    <div class="container">
        <form action="index.php?section=search" type="GET">
            <h2>Categories:</h2><br>
            <?php foreach ($tags as $tag) :?>
                <button class="categoryButton"type="submit" value="<?= $tag['name']?>" name="category"/><?= $tag['name']?></button><br>
            <?php endforeach; ?>
        </form>
    </div>
</div>


