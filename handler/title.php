<?php

require("../load.php");

$error = false;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || empty($_GET["id"])) {
    $error = true;
} else {
    $id = clean(mysqli_real_escape_string($conn, $_GET["id"]));
    $title = $conn->query("SELECT `title` FROM `titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();
    if (empty($title)) {
        $error = true;
    } else {
        $title = mysqli_real_escape_string($conn, $title["title"]);
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Title - " . config("title") . "</title>";
    echo "<script type='text/javascript'>document.cookie = 'currentTitle=$id; path=/';</script>";
    echo "<script type='text/javascript'>title('$title (Title)');</script>";
    echo callFile(config("url") . "themes/$usertheme/title.php");
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/skeletons/title.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    echo callFile(config("url") . "themes/$usertheme/error.php");
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/skeletons/error.php");
}
include("../themes/$usertheme/parts/footer.php");
