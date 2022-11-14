<?php

require("../load.php");
require("../sql/publisher.php");

$error = false;
$serror = false;

if ($userlevel["can_add_title"] == 0) {
    $error = true;
}

if (isset($_POST["addTitle"])) {
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

    $return = checkTitleFormData($comic["title"], $comic["cover"]["base"], $comic["alt_names"], $comic["authors"], $comic["artists"], $comic["language"], $comic["original_work"], $comic["upload_status"], $comic["release_year"], $comic["complete_year"]);
    if ($return == "success") {
        $return = tryCreateTitle($comic["title"], "jpeg", $comic["alt_names"], $comic["authors"], $comic["artists"], $comic["genres"], $comic["language"], $comic["original_work"], $comic["upload_status"], $comic["release_year"], $comic["complete_year"], $comic["summary"], $comic["notes"], $user["id"]);
        if ($return == "success") {
            $title = $conn->query("SELECT * FROM `{$dbp}titles` ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
            $return = generatePermissions("all", $title["id"], "0", $user["id"]);
            if ($return == "success") {
                $return = uploadImage($comic["cover"]["tmp"], $comic["cover"]["file"], "../data/covers/" . $title["id"] . ".jpeg", $user["id"]);
                if ($return == "success") {
                    move_uploaded_file($_FILES["cover"]["tmp_name"], "../data/covers/" . $title["id"] . ".jpeg");
                    header("Location: " . config("url") . "publisher/title/" . $title["id"] . "/" . cat($title["title"]));
                    $serror = true;
                } else {
                    $serror = true;
                }
            } else {
                $serror = true;
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
    echo "<title>Publisher - New Title - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.new.title.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
