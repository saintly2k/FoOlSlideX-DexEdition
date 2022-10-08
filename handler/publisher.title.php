<?php

require("../load.php");
require("../sql/publisher.php");

$error = false;
$generated = false;

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login?redirect=publisher/title/" . clean(mysqli_real_escape_string($conn, $_GET["id"])));
    $error = true;
    die("You don't seem to be logged in? If you are, contact the developers - this is a bug! (Also, you are ignoring headers, this isn't a good sign!)");
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

if ($error == false) {
    $permission_upload = $conn->query("SELECT * FROM  `permissions_upload` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc();
    $permission_modify = $conn->query("SELECT * FROM  `permissions_modify` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc();
    $permission_edit = $conn->query("SELECT * FROM  `permissions_edit` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc();
    if (empty($permission_upload["id"])) {
        generatePermissions("upload", $id, "0", $user["id"]);
        $generated = true;
    }
    if (empty($permission_modify["id"])) {
        generatePermissions("modify", $id, "0", $user["id"]);
        $generated = true;
    }
    if (empty($permission_edit["id"])) {
        generatePermissions("edit", $id, "0", $user["id"]);
        $generated = true;
    }
    if ($generated == true) {
        header("Refresh: 0");
        die("Let this page refresh, ffs! Why are you always the one ignorign headers?? Fuck yu!!!!11!!11!!");
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Publisher - Title - " . config("title") . "</title>";
    echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_currentTitle', '$id')</script>";
    echo callFile(config("url") . "themes/$usertheme/publisher.title.php");
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/skeletons/publisher.title.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
