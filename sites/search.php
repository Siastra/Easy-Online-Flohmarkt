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
?>
<div class="container">
    <form action="index.php?section=search" type="GET">
    <label for="search">Search for Advertisments:</label><br>
    <input type="text" placeholder="Search " name="search" id="search"/><br>
    <button class="btn btn-success submit" type="submit">Search</button>
    </form>
</div>

