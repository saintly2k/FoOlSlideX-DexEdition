<?php

require("../load.php");
require("../sql/history.php");

$error = false;
$cerror = 0;
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

if ($loggedin == true) {
    if (isset($_POST["syncCloudTitles"]) && !empty($userhistory)) {
        $return = cloudSync($user["id"], "titles", "merge", $userhistory);
        if ($return != "success") $cerror = $return;
    }
    if (isset($_POST["syncCloudChapters"]) && !empty($userreadchapters)) {
        $return = cloudSync($user["id"], "chapters", "merge", $userreadchapters);
        if ($return == "error") $cerror = $return;
    }
    if (isset($_POST["syncLocalTitles"])) {
        $return = cloudSync($user["id"], "titles", "fetch", null);
        if ($return == "error") {
            $cerror = "Something went wrong. Try again.";
        } else {
            setCkie(config("cookie") . "_history", $return);
        }
    }
    if (isset($_POST["syncLocalChapters"])) {
        $return = cloudSync($user["id"], "chapters", "fetch", null);
        if ($return == "error") {
            $cerror = "Something went wrong. Try again.";
        } else {
            setCkie(config("cookie") . "_readChapters", $return);
        }
    }
    if (isset($_POST["deleteSync"])) {
        $return = deleteSync($user["id"]);
        setCkie(config("cookie") . "_history", "");
        setCkie(config("cookie") . "_readChapters", "");
    }
}

include("../themes/$usertheme/parts/header.php");
echo "<title>History - " . ucfirst($tab) . " - Page $page" . config("title") . "</title>";
echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_historyTab', '" . ucfirst($tab) . "')</script>";
echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_currentPage', '$page')</script>";
echo "<script type='text/javascript'>Cookies.set('" . config("cookie") . "_cloudError', '$cerror')</script>";
echo callFile(config("url") . "themes/$usertheme/history.php");
include("../themes/$usertheme/parts/menu.php");
include("../themes/$usertheme/skeletons/history.php");
include("../themes/$usertheme/parts/footer.php");
