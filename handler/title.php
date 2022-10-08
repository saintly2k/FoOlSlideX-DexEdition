<?php

require("../load.php");

$error = false;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || empty($_GET["id"])) {
    $error = true;
} else {
    $id = clean(mysqli_real_escape_string($conn, $_GET["id"]));
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Title (Title) - " . config("title") . "</title>";
    echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_currentTitle', '$id')</script>";
    echo callFile(config("url") . "themes/$usertheme/title.php");
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/skeletons/title.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
