<?php

function uploadImage($imgTmp, $imgFile, $target, $uid)
{
    require("../core/config.php");
    require("../core/conn.php");
    $targetFile = $target;
    $uploadOk = 1;
    $imageFileType = $imgFile;

    // Check if image file is a actual image or fake image
    $check = getimagesize($imgTmp);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $out = "An error occured - YOUR fault!";
        logs($uid, "uploadImage", "Not Uploaded", "Error: Fake Image");
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
        $out = "Unsupported Image. Only JPG, JPEG, PNG, GIF and WEBP.";
        $uploadOk = 0;
        logs($uid, "uploadImage", "Not Uploaded", "Error: Unsupported Format");
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (rename($imgTmp, $targetFile)) {
            $out = "success";
            logs($uid, "uploadImage", "Not Uploaded", "success");
        } else {
            $out = "An error occured - server sided, you're not at fault (I think).";
            logs($uid, "uploadImage", "Not Uploaded", "Error: Server Fault");
        }
    }
    return $out;
}

function checkTitleFormData($title, $cover, $alt, $authors, $artists, $language, $origwork, $uplstatus, $release, $complete, $type = "create")
{
    $error = false;
    $out = "error";
    if (!empty($title)) {
        if ((!empty($cover) && $type == "create") || $type == "edit") {
            if (!empty($alt)) {
                $altl = strlen($alt);
                if ($altl > 501) {
                    $error = true;
                    $out = "Alt Names are longer than 500 characters.";
                }
            }
            if (!empty($authors)) {
                $autl = strlen($authors);
                if ($autl < 2 || $autl > 101) {
                    $error = true;
                    $out = "Author Names are longer than 100 characters.";
                }
            }
            if (!empty($artists)) {
                $artl = strlen($artists);
                if ($artl < 2 || $artl > 101) {
                    $error = true;
                    $out = "Artists Names are longer than 100 characters.";
                }
            }
            if (!empty($artists)) {
                $artl = strlen($artists);
                if ($artl < 2 || $artl > 101) {
                    $error = true;
                    $out = "Artists Names are longer than 100 characters.";
                }
            }
            if (!empty($language)) {
                $lanl = strlen($language);
                if ($lanl < 4 || $lanl > 21) {
                    $error = true;
                    $out = "Artists Names are longer than 100 characters.";
                }
            }
            if ($origwork != 0 && $origwork != 1 && $origwork != 2 && $origwork != 3 && $origwork != 4) {
                $error = true;
                $out = "You messed with the Original Work Status, didn't you?";
            }
            if ($uplstatus != 0 && $uplstatus != 1 && $uplstatus != 2 && $uplstatus != 3 && $uplstatus != 4) {
                $error = true;
                $out = "You messed with the Upload Status, didn't you?";
            }
            if (!empty($release)) {
                $rell = strlen($release);
                if ($rell != 4) {
                    $error = true;
                    $out = "I think a year has four digits. (Release Year)";
                }
            }
            if (!empty($complete)) {
                $coml = strlen($complete);
                if ($coml != 4) {
                    $error = true;
                    $out = "I think a year has four digits. (Completion Year)";
                }
            }
        } else {
            $error = true;
            $out = "Cover is missing.";
        }
    } else {
        $error = true;
        $out = "Title is missing.";
    }
    if ($error == false) {
        $out = "success";
    }
    return $out;
}

function tryCreateTitle($title, $cover, $alt, $authors, $artists, $genre, $language, $origwork, $uplstatus, $release, $complete, $summary, $notes, $uid)
{
    require("../core/config.php");
    require("../core/conn.php");
    $release = empty($release) ? "NULL" : "'$release'";
    $complete = empty($complete) ? "NULL" : "'$complete'";
    $sql = "INSERT INTO `titles`(`cover`, `title`, `alt_names`, `authors`, `artists`, `genre`, `original_language`, `original_work`, `upload_status`, `release_year`, `complete_year`, `summary`, `notes`, `user_id`)
    VALUES ('$cover','$title','$alt','$authors','$artists','$genre','$language','$origwork','$uplstatus',$release,$complete,'$summary','$notes','$uid')";
    if (!$conn->query($sql)) {
        $out = "MySQL Error: " . $conn->error;
        logs($uid, "tryCreateTitle", "Not Created", "Error: " . $conn->error);
    } else {
        $out = "success";
        logs($uid, "tryCreateTitle", "Not Created", "success; $title; $alt; $authors; $artists; $genre; $language; $origwork; $uplstatus; $release; $complete; $summary; $notes;");
    }
    return $out;
}

function tryEditTitle($tid, $title, $alt, $authors, $artists, $genre, $language, $origwork, $uplstatus, $release, $complete, $summary, $notes, $uid)
{
    require("../core/config.php");
    require("../core/conn.php");
    $release = empty($release) ? "NULL" : "'$release'";
    $complete = empty($complete) ? "NULL" : "'$complete'";
    $sql = "UPDATE `titles` SET `title`='$title',`alt_names`='alt',`authors`='$authors',`artists`='$artists',`genre`='$genre',`original_language`='$language',`original_work`='$origwork',`upload_status`='$uplstatus',`release_year`=$release,`complete_year`=$complete,`summary`='$summary',`notes`='$notes' WHERE `id`='$tid'";
    if (config("logs") == 1) {
        $title = $conn->query("SELECT * FROM `titles` WHERE `id`='$tid' LIMIT 1")->fetch_assoc();
        $oldCover = "../data/old/covers/" . $title["id"] . ".jpeg";
        $newCover = "../data/covers/" . $title["id"] . ".jpeg";
        rename("../data/covers/" . $title["id"] . ".jpeg", $oldCover);
        logs($uid, "tryEditTitleData", $title["title"] . "; " . $oldCover . "; " . $title["alt_names"] . "; " . $title["authors"] . "; " . $title["artists"] . "; " . $title["genre"] . "; " . $title["original_language"] . "; " . $title["original_work"] . "; " . $title["upload_status"] . "; " . $title["release_year"] . "; " . $title["complete_year"] . "; " . $title["summary"], $title . "; " . $newCover . "; " . $alt . "; " . $authors . "; " . $artists . "; " . $genre . "; " . $language . "; " . $origwork . "; " . $uplstatus . "; " . $release . "; " . $complete . "; " . $summary . "; " . $notes . ";");
    }
    if (!$conn->query($sql)) {
        $out = "MySQL Error: " . $conn->error;
        logs($uid, "tryEditTitle", "Not Edited", "Error: " . $conn->error);
    } else {
        $out = "success";
        logs($uid, "tryEditTitle", "Not Edited", "success");
    }
    return $out;
}

function generatePermissions($which, $title, $uid, $creator)
{
    require("../core/config.php");
    require("../core/conn.php");
    if ($which == "all") {
        $conn->query("DELETE FROM `permissions_upload` WHERE `title_id`='$title'");
        $sql = "INSERT INTO `permissions_upload`(`title_id`, `user_id`, `creator_id`) VALUES('$title','$uid','$creator')";
        if (!$conn->query($sql)) {
            $out = "MySQL Error: " . $conn->error;
            logs($uid, "generatePermissionsUpload", "Not Generated", "Error: " . $conn->error);
        } else {
            $conn->query("DELETE FROM `permissions_modify` WHERE `title_id`='$title'");
            $sql = "INSERT INTO `permissions_modify`(`title_id`, `user_id`, `creator_id`) VALUES('$title','$uid','$creator')";
            if (!$conn->query($sql)) {
                $out = "MySQL Error: " . $conn->error;
                logs($uid, "generatePermissionsModify", "Not Generated", "Error: " . $conn->error);
            } else {
                $conn->query("DELETE FROM `permissions_edit` WHERE `title_id`='$title'");
                $sql = "INSERT INTO `permissions_edit`(`title_id`, `user_id`, `creator_id`) VALUES('$title','$uid','$creator')";
                if (!$conn->query($sql)) {
                    $out = "MySQL Error: " . $conn->error;
                    logs($uid, "generatePermissionsEdit", "Not Generated", "Error: " . $conn->error);
                } else {
                    $out = "success";
                    logs($uid, "generatePermissions", "Not Generated", "success");
                }
            }
        }
    }
    if ($which == "upload") {
        $conn->query("DELETE FROM `permissions_upload` WHERE `title_id`='$title'");
        $sql = "INSERT INTO `permissions_upload`(`title_id`, `user_id`, `creator_id`) VALUES('$title','$uid','$creator')";
        if (!$conn->query($sql)) {
            $out = "MySQL Error: " . $conn->error;
            logs($uid, "generatePermissionsUpload", "Not Generated", "Error: " . $conn->error);
        } else {
            $out = "success";
            logs($uid, "generatePermissionsUpload", "Not Generated", "success");
        }
    }
    if ($which == "modify") {
        $conn->query("DELETE FROM `permissions_modify` WHERE `title_id`='$title'");
        $sql = "INSERT INTO `permissions_modify`(`title_id`, `user_id`, `creator_id`) VALUES('$title','$uid','$creator')";
        if (!$conn->query($sql)) {
            $out = "MySQL Error: " . $conn->error;
            logs($uid, "generatePermissionsModify", "Not Generated", "Error: " . $conn->error);
        } else {
            $out = "success";
            logs($uid, "generatePermissionsModify", "Not Generated", "success");
        }
    }
    if ($which == "edit") {
        $conn->query("DELETE FROM `permissions_edit` WHERE `title_id`='$title'");
        $sql = "INSERT INTO `permissions_edit`(`title_id`, `user_id`, `creator_id`) VALUES('$title','$uid','$creator')";
        if (!$conn->query($sql)) {
            $out = "MySQL Error: " . $conn->error;
            logs($uid, "generatePermissionsEdit", "Not Generated", "Error: " . $conn->error);
        } else {
            $out = "success";
            logs($uid, "generatePermissionsEdit", "Not Generated", "success");
        }
    }
    return $out;
}
