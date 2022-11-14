<?php

require("../load.php");
require("../sql/chapter.php");

$error = false;
$generated = false;
$serror = false;

if ($userlevel["can_add_chapter"] == 0) {
    $error = true;
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || empty($_GET["id"])) {
    $error = true;
} else {
    $id = clean(mysqli_real_escape_string($conn, $_GET["id"]));
    $title = $conn->query("SELECT * FROM `{$dbp}titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();
    if (empty($title["id"])) {
        $error = true;
        $serror = true;
        $return = "Title doesn't exist!";
    }
}

if ($error == false && $userlevel["can_add_chapter"] == 1) {
    // define default stuff
    $add["chapter_number"] = "";
    $add["volume_number"] = "";
    $add["oder_numer"] = "";
    $add["release_name"] = "";
    $add["release_short_name"] = "";
    $add["release_title"] = "";
    $add["groups"] = "";

    if (isset($_POST["addChapter"])) {
        if (!empty($_FILES["archive"]["name"])) {
            $chapter["archive"]["base"] = basename($_FILES["archive"]["name"]);
            $chapter["archive"]["tmp"] = $_FILES["archive"]["tmp_name"];
            $chapter["archive"]["file"] = strtolower(pathinfo($chapter["archive"]["base"], PATHINFO_EXTENSION));

            $chapter["chapter_number"] = clean(mysqli_real_escape_string($conn, $_POST["chapter_number"]));
            $chapter["volume_number"] = clean(mysqli_real_escape_string($conn, $_POST["volume_number"]));
            $chapter["order_number"] = clean(mysqli_real_escape_string($conn, $_POST["order_number"]));
            $chapter["release_name"] = clean(mysqli_real_escape_string($conn, $_POST["release_name"]));
            $chapter["release_short_name"] = clean(mysqli_real_escape_string($conn, $_POST["release_short_name"]));
            $chapter["release_title"] = clean(mysqli_real_escape_string($conn, $_POST["release_title"]));
            $chapter["groups"] = verifyGroups(clean(mysqli_real_escape_string($conn, $_POST["groups"])), $user["id"], $userlevel["mod"]);
            $chapter["awaiting_approval"] = $userlevel["mod"] = 1 ? 0 : 1;
            $chapter["deleted"] = 0;
            $chapter["key"] = gen_uuid();
            $return = checkAddChapterData($chapter["chapter_number"], $chapter["volume_number"], $chapter["order_number"], $chapter["release_name"], $chapter["release_short_name"], $chapter["release_title"]);
            if ($return == "success") {
                $cdata = gen_uuid();
                $return = unzip($chapter["archive"]["tmp"], "../data/chapters/tmp", "../data/chapters/$cdata");
                if ($return == "success") {
                    if (empty($chapter["order_number"])) $chapter["order_number"] = $chapter["chapter_number"];
                    $return = tryCreateChapter($title["id"], $user["id"], $chapter["order_number"], $chapter["volume_number"], $chapter["chapter_number"], $chapter["release_name"], $chapter["release_short_name"], $chapter["release_title"], $chapter["groups"], $cdata, $chapter["awaiting_approval"], $chapter["deleted"], $chapter["key"]);
                    if ($return == "success") {
                        if (!isset($_POST["stay"])) {
                            $chapter = $conn->query("SELECT `id` FROM `{$dbp}chapters` ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
                            header("Location: " . config("url") . "chapter/" . $chapter["id"]);
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
        } else {
            $serror = true;
            $return = "You need to select a ZIP archive, moron.";
        }
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Publisher - Upload Chapter - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.title.upload.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
