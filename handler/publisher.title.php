<?php

require("../load.php");

$error = false;

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login?redirect=publisher/title/" . clean(mysqli_real_escape_string($conn, $_GET["id"])));
    die("You didn't want to login?");
    $error = true;
}

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
    echo "<title>Publisher - Title - " . config("title") . "</title>";
    echo "<script type='text/javascript'>document.cookie = 'currentTitle=$id; path=/';</script>";
    echo "<script type='text/javascript'>title('Publisher - $title (Title)');</script>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.title.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
