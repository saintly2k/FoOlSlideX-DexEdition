<?php

require("../load.php");

$error = false;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || empty($_GET["id"])) {
    $error = true;
} else {
    $id = clean(mysqli_real_escape_string($conn, $_GET["id"]));
    if (!isset($_GET["page"]) && $readingmode == "singlePage") {
        header("Location: " . config("url") . "chapter/" . $id . "/1");
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Chapter (Title) - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/chapter.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
