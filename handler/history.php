<?php

require("../load.php");

if (!isset($_GET["tab"]) || empty($_GET["tab"]) || is_numeric($_GET["tab"]) || ($_GET["tab"] != "chapters" && $_GET["tab"] != "titles")) {
    header("Location: " . config("url") . "history?tab=titles");
    $error = true;
}
$tab = clean(mysqli_real_escape_string($conn, $_GET["tab"]));
if (!isset($_GET["page"]) || empty($_GET["page"]) || !is_numeric($_GET["page"])) {
    header("Location: " . config("url") . "history?tab=$tab&page=1");
    $error = true;
}
$page = clean(mysqli_real_escape_string($conn, $_GET["page"]));

include("../themes/$usertheme/parts/header.php");
echo "<title>History - " . ucfirst($tab) . " - Page $page" . config("title") . "</title>";
echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_historyTab', '" . ucfirst($tab) . "')</script>";
echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_currentPage', '$page')</script>";
echo callFile(config("url") . "themes/$usertheme/history.php");
include("../themes/$usertheme/parts/menu.php");
include("../themes/$usertheme/skeletons/history.php");
include("../themes/$usertheme/parts/footer.php");
