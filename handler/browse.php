<?php

require("../load.php");

if (!isset($_GET["page"]) || !is_numeric($_GET["page"])) {
    header("Location: " . config("url") . "browse?page=1");
    $page = 1;
}
$page = clean(mysqli_real_escape_string($conn, $_GET["page"]));
if (!isset($_GET["order"])) {
    header("Location: " . config("url") . "browse?page=$page&order=name_asc");
}
$orderBy = clean(mysqli_real_escape_string($conn, $_GET["order"]));

include("../themes/$usertheme/parts/header.php");
echo "<title>Browse - Page $page - " . config("title") . "</title>";
echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_currentPage', '$page')</script>";
echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_orderBy', '$orderBy')</script>";
echo callFile(config("url") . "themes/$usertheme/browse.php");
include("../themes/$usertheme/parts/menu.php");
include("../themes/$usertheme/skeletons/browse.php");
include("../themes/$usertheme/parts/footer.php");
