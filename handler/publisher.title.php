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
    if (!isset($_COOKIE[config("cookie") . "_currentTitle"]) || $_COOKIE[config("cookie") . "_currentTitle"] != $id) {
        setcookie(config("cookie") . "_currentTitle", $id, time() + (86400 * 30), "/");
        header("Refresh: 0");
    }
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
    if ($permission_upload["user_id"] == 0) {
        $can_upload = true;
    } else {
        $permission_upload = explode(",", $permission_upload["user_id"]);
        $can_upload = in_array($user["id"], $permission_upload) ? true : false;
    }
    if ($permission_modify["user_id"] == 0) {
        $can_modify = true;
    } else {
        $permission_modify = explode(",", $permission_modify["user_id"]);
        $can_modify = in_array($user["id"], $permission_modify) ? true : false;
    }
    if ($permission_edit["user_id"] == 0) {
        $can_edit = true;
    } else {
        $permission_edit = explode(",", $permission_edit["user_id"]);
        $can_edit = in_array($user["id"], $permission_edit) ? true : false;
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Publisher - Title - " . config("title") . "</title>";
    echo "<script type='text/javascript'>document.cookie = '" . config("cookie") . "_currentTitle=$id; path=/';</script>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.title.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
