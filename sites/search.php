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
<div class="container">
    <form action="index.php?section=search" type="GET">
    <label for="search">Search for Advertisments:</label><br>
    <input type="text" placeholder="Search " name="search" id="search"/><br>
    <button class="btn btn-success submit" type="submit">Search</button>
    </form>
</div><br><br>
<div class="container">
    <form action="index.php?section=search" type="GET">
        <label for="category">Categories:</label><br>
        <?php foreach ($tags as $tag) :?>
        <button type="submit" value="<?= $tag?>" name="category"/><?= $tag?></button>
        <?php endforeach; ?>
    </form>
</div>

