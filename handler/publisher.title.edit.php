<?php

require("../load.php");
require("../sql/publisher.php");

$error = false;
$generated = false;
$serror = false;

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login?redirect=publisher/title/" . clean(mysqli_real_escape_string($conn, $_GET["id"])) . "/edit");
    $error = true;
    die("You don't seem to be logged in? If you are, contact the developers - this is a bug! (Also, you are ignoring headers, this isn't a good sign!)");
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || empty($_GET["id"])) {
    $error = true;
} else {
    $id = clean(mysqli_real_escape_string($conn, $_GET["id"]));
    $title = $conn->query("SELECT * FROM `titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();
    if (empty($title["id"])) {
        $error = true;
        $serror = true;
        $return = "Title doesn't exist!";
    }
}

if ($error == false) {
    $permission_edit = $conn->query("SELECT * FROM  `permissions_edit` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc();
    if (empty($permission_edit["id"])) {
        generatePermissions("edit", $id, "0", $user["id"]);
        $generated = true;
    }
    if ($generated == true) {
        header("Refresh: 0");
        die("Let this page refresh, ffs! Why are you always the one ignoring headers?? Fuck yu!!!!11!!11!!");
    }
}

if (isset($_POST["editTitle"])) {
    $comic = array();
    $comic["title"] = clean(mysqli_real_escape_string($conn, $_POST["title"]));
    if (isset($_FILES["cover"])) {
        $comic["cover"]["base"] = basename($_FILES["cover"]["name"]);
        $comic["cover"]["tmp"] = $_FILES["cover"]["tmp_name"];
        $comic["cover"]["file"] = strtolower(pathinfo($comic["cover"]["base"], PATHINFO_EXTENSION));
    } else {
        $comic["cover"]["base"] = "";
    }
    $comic["alt_names"] = clean(mysqli_real_escape_string($conn, $_POST["alt_names"]));
    $comic["authors"] = clean(mysqli_real_escape_string($conn, $_POST["authors"]));
    $comic["artists"] = clean(mysqli_real_escape_string($conn, $_POST["artists"]));
    $comic["genres"] = clean(mysqli_real_escape_string($conn, $_POST["genres"]));
    $comic["language"] = clean(mysqli_real_escape_string($conn, $_POST["language"]));
    $comic["original_work"] = clean(mysqli_real_escape_string($conn, $_POST["original_work"]));
    $comic["upload_status"] = clean(mysqli_real_escape_string($conn, $_POST["upload_status"]));
    $comic["release_year"] = clean(mysqli_real_escape_string($conn, $_POST["release_year"]));
    $comic["complete_year"] = clean(mysqli_real_escape_string($conn, $_POST["complete_year"]));
    $comic["summary"] = clean(mysqli_real_escape_string($conn, $_POST["summary"]));
    $comic["notes"] = clean(mysqli_real_escape_string($conn, $_POST["notes"]));

    $return = checkTitleFormData($comic["title"], $comic["cover"]["base"], $comic["alt_names"], $comic["authors"], $comic["artists"], $comic["language"], $comic["original_work"], $comic["upload_status"], $comic["release_year"], $comic["complete_year"], "edit");
    if ($return == "success") {
        $return = tryEditTitle($title["id"], $comic["title"], $comic["alt_names"], $comic["authors"], $comic["artists"], $comic["genres"], $comic["language"], $comic["original_work"], $comic["upload_status"], $comic["release_year"], $comic["complete_year"], $comic["summary"], $comic["notes"], $user["id"]);
        if ($return == "success") {
            if (!empty($comic["cover"]["base"])) {
                $return = uploadImage($comic["cover"]["tmp"], $comic["cover"]["file"], "../data/covers/" . $title["id"] . ".jpeg", $user["id"]);
                if ($return == "success") {
                    header("Refresh: 0");
                    die("Let this page refresh you #*?!+>-2");
                } else {
                    $serror = true;
                }
            } else {
                header("Refresh: 0");
                die("Let this page refresh you #*?!+>-2");
            }
        } else {
            $serror = true;
        }
    } else {
        $serror = true;
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Publisher - Edit Title - " . config("title") . "</title>";
    echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_currentTitle', '$id')</script>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.title.edit.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
