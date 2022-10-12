<?php

function rmrf($dir)
{
    foreach (glob($dir) as $file) {
        if (is_dir($file)) {
            rmrf("$file/*");
            rmdir($file);
        } else {
            unlink($file);
        }
    }
}

function unzip($file, $tmp, $target)
{
    $zip = new ZipArchive;
    $res = $zip->open($file);
    if ($res === true) {
        // extract it to the path we determined above
        if (file_exists($tmp)) {
            rmrf($tmp);
        }
        mkdir($tmp, 0755, false);
        mkdir($target, 0755, false);
        $zip->extractTo($tmp);
        $files = glob("$tmp/*.{jpg,jpeg,webp,gif,png}", GLOB_BRACE);
        if (!empty($files)) {
            sort($files, SORT_STRING);
            $c = 1;
            foreach ($files as $file) {
                rename($file, $target . "/$c.jpeg");
                $c++;
            }
            $zip->close();
            rmrf($tmp);
            $out = "success";
        } else {
            $out = "No Images found. Maybe you zipped them wrong.";
        }
    } else {
        $out = "error";
    }
    return $out;
}

function checkAddChapterData($chapter, $volume, $order, $name, $short, $title)
{
    $error = false;
    $out = "";
    if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $chapter)) {
        $error = true;
        $out = "You messed with Chapter Number, didn't you?";
    }
    if (!is_numeric($volume) && !empty($volume)) {
        $error = true;
        $out = "You messed with the Volume Number, didn't you?";
    }
    if (!is_numeric($order) && !empty($order)) {
        $error = true;
        $out = "You messed with the Volume Number, didn't you?";
    }
    if (!empty($name)) {
        $nl = strlen($name);
        if ($nl < 1 || $nl > 101) {
            $error = true;
            $out = "Name needs to be between 2 and 100 characters.";
        }
    }
    if (!empty($short)) {
        $sl = strlen($short);
        if ($sl < 1 || $sl > 16) {
            $error = true;
            $out = "Short Name needs to be between 2 and 100 characters.";
        }
    }
    if (!empty($title)) {
        $tl = strlen($title);
        if ($tl < 1 || $tl > 201) {
            $error = true;
            $out = "Title needs to be between 2 and 200 characters.";
        }
    }

    if ($error == false) {
        $out = "success";
    }
    return $out;
}

function tryCreateChapter($tid, $uid, $order, $volume, $chapter, $name, $short, $title, $groups, $data, $awaiting, $deleted, $key)
{
    require("../core/config.php");
    require("../core/conn.php");
    $out = "";
    $sql = "INSERT INTO `chapters`(`title_id`, `user_id`, `order`, `volume`, `chapter`, `release_name`, `release_short`, `title`, `groups`, `data_path`, `awaiting_approval`, `deleted`, `key`)
    VALUES ('$tid','$uid','$order','$volume','$chapter','$name','$short','$title','$groups','$data','$awaiting','$deleted','$key')";
    if (!$conn->query($sql)) {
        $out = "MySQL Error: " . $conn->error;
        logs($uid, "tryCreateChapter", "Not Created", "Error: " . $conn->error);
    } else {
        $out = "success";
        logs($uid, "tryCreateChapter", "Not Created", "success; $tid; $uid; $order; $volume; $chapter; $name; $short; $title; $data; $awaiting; $deleted; $key;");
    }
    return $out;
}

function verifyGroups($groups, $uid, $mod)
{
    require("../core/config.php");
    require("../core/conn.php");
    $out = "";
    $c = 1;
    $groups = explode(",", $groups);
    foreach ($groups as $group) {
        $group = $conn->query("SELECT * FROM `groups` WHERE `id`='$group' LIMIT 1")->fetch_assoc();
        if (!empty($group["id"]) || ($group["status"] != 1 || $group["status"] != 3)) {
            if ($group["permission"] == 0) {
                $post = true;
            } else {
                $x = explode(",", $group["permission"]);
                if (in_array($uid, $x) || $mod == 1) {
                    $post = true;
                } else {
                    $post = false;
                }
            }
        } else {
            $post = false;
        }
        $d = $c != 1 ? ", " . $group["id"] : $group["id"];
        if ($post == true) $out .= $d;
        $c++;
    }
    return $out;
}
