<?php

require("../load.php");
require("../sql/group.php");

$error = false;
$serror = false;

if ($userlevel["can_add_group"] == 0) {
    $error = true;
}

if ($error == false && $userlevel["can_add_group"] == 1) {
    if (isset($_POST["addGroup"])) {
        $group["name"] = clean(mysqli_real_escape_string($conn, $_POST["name"]));
        if (isset($_FILES["banner"])) {
            $group["banner"]["base"] = basename($_FILES["banner"]["name"]);
            $group["banner"]["tmp"] = $_FILES["banner"]["tmp_name"];
            $group["banner"]["file"] = strtolower(pathinfo($group["banner"]["base"], PATHINFO_EXTENSION));
        } else {
            $group["banner"]["base"] = "";
        }
        $group["description"] = clean(mysqli_real_escape_string($conn, $_POST["description"]));
        if ($userlevel["mod"] == 1) {
            $group["upload_permissions"] = clean(mysqli_real_escape_string($conn, $_POST["upload"]));
            $group["edit_permissions"] = clean(mysqli_real_escape_string($conn, $_POST["edit"]));
            $group["status"] = clean(mysqli_real_escape_string($conn, $_POST["mod_status"]));
            $group["owner"] = clean(mysqli_real_escape_string($conn, $_POST["mod_owner"]));
            $group["redirect"] = clean(mysqli_real_escape_string($conn, $_POST["mod_redirect"]));
        } else {
            $group["upload_permissions"] = "";
            $group["edit_permissions"] = "";
            $group["status"] = "";
            $group["owner"] = "";
            $group["redirect"] = "";
        }
        $group["creator"] = $user["id"];

        $return = checkGroupFormData($group["name"], $group["upload_permissions"], $group["edit_permissions"], $group["status"], $group["owner"], $group["redirect"], $group["creator"], $userlevel["mod"]);
        if ($return == "success") {
            $return = tryCreateGroup($group["name"], $group["description"], $group["upload_permissions"], $group["edit_permissions"], $group["status"], $group["owner"], $group["redirect"], $group["creator"], $userlevel["mod"], $user["id"]);
            if ($return == "success") {
                $grp = $conn->query("SELECT * FROM `{$dbp}groups` ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
                if (!empty($group["banner"]["base"])) {
                    $return = uploadImage($group["banner"]["tmp"], $group["banner"]["file"], "../data/group/" . $grp["id"] . ".jpeg", $user["id"]);
                    if ($return == "success") {
                        header("Location: " . config("url") . "group/" . $grp["id"] . "/" . cat($grp["name"]));
                        $error = true;
                    } else {
                        $serror = true;
                    }
                } else {
                    header("Location: " . config("url") . "group/" . $grp["id"] . "/" . cat($grp["name"]));
                    $error = true;
                }
            }
        } else {
            $serror = true;
        }
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Publisher - New Group - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.new.group.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
