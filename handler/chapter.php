<?php

require("../load.php");

$error = false;

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || empty($_GET["id"])) {
    $error = true;
} else {
    $id = clean(mysqli_real_escape_string($conn, $_GET["id"]));
    $chapter = $conn->query("SELECT * FROM `{$dbp}chapters` WHERE `id`='$id' LIMIT 1")->fetch_assoc();
    if (!empty($chapter["id"])) {
        $chapters = $conn->query("SELECT * FROM `{$dbp}chapters` WHERE `title_id`='" . $chapter["title_id"] . "' ORDER BY `order` DESC");
        $title = $conn->query("SELECT * FROM `{$dbp}titles` WHERE `id`='" . $chapter["title_id"] . "' LIMIT 1")->fetch_assoc();
        $ptit = chTtile("home", $chapter["volume"], $chapter["chapter"], $chapter["release_name"], $chapter["release_short"], $chapter["title"]);
        $ptitf = chTtile("list", $chapter["volume"], $chapter["chapter"], $chapter["release_name"], $chapter["release_short"], $chapter["title"]);
        $images = glob("../data/chapters/" . $chapter["data_path"] . "/*");
        natsort($images);
        $prev_page = $conn->query("SELECT * FROM `{$dbp}chapters` WHERE `title_id`='" . $chapter["title_id"] . "' AND `order` < '" . $chapter["order"] . "' ORDER BY `order` DESC LIMIT 1")->fetch_assoc();
        $next_page = $conn->query("SELECT * FROM `{$dbp}chapters` WHERE `title_id`='" . $chapter["title_id"] . "' AND `order` > '" . $chapter["order"] . "' ORDER BY `order` ASC LIMIT 1")->fetch_assoc();
        $imgind = [];
        $ic = 1;
        foreach ($images as $ii) {
            $ii = pathinfo($ii);
            $imgind[$ic]["order"] = $ic;
            $imgind[$ic]["name"] = $ii["filename"];
            $imgind[$ic]["ext"] = $ii["extension"];
            $ic++;
        }
        $page = isset($_GET["page"]) && !empty($_GET["page"]) && is_numeric($_GET["page"]) ? clean(mysqli_real_escape_string($conn, $_GET["page"])) : 1;
        $prev_img = $page > 1 ? $page - 1 : $page;
        $next_img = $page < $ic - 1 ? $page + 1 : $page;
        if (!isset($_GET["page"]) && $readingmode == "singlePage") {
            header("Location: " . config("url") . "chapter/" . $id . "/1");
        }
        if (!in_array($title["id"], $userhistory) && !isset($_POST["markUnread"])) {
            array_push($userhistory, $title["id"]);
            $userhistory = convArrayToString($userhistory);
            setCkie(config("cookie") . "_history", $userhistory);
        }
        if (!in_array($id, $userreadchapters) && (!isset($_POST["markUnread"]) || isset($_POST["markRead"]))) {
            array_push($userreadchapters, $id);
            $userreadchapters = convArrayToString($userreadchapters);
            setCkie(config("cookie") . "_readChapters", $userreadchapters);
        }
        if (isset($_POST["markUnread"])) {
            $userreadchapters = convArrayToString(array_diff($userreadchapters, [$id]));
            setCkie(config("cookie") . "_readChapters", $userreadchapters);
            $userreadchapters = isset($_COOKIE[config("cookie") . "_readChapters"]) ? explode(",", clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_readChapters"]))) : array();
            $otherChapters = "";
            $otc = 1;
            foreach ($userreadchapters as $c) {
                if ($c != $chapter["id"]) {
                    if ($otc != 1) $otherChapters .= ",";
                    $otherChapters .= $c;
                    $otc++;
                }
            }
            if (empty($otherChapters)) {
                $userhistory = convArrayToString(array_diff($userhistory, [$title["id"]]));
                setCkie(config("cookie") . "_history", $userhistory);
            }
        }
        $userreadchapters = isset($_COOKIE[config("cookie") . "_readChapters"]) ? explode(",", clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_readChapters"]))) : array();
        $userhistory = isset($_COOKIE[config("cookie") . "_history"]) ? explode(",", clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_history"]))) : array();
    } else {
        $error = true;
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
