<?php

function cloudSync($uid, $type, $method, $array = null)
{
    require("../core/config.php");
    require("../core/conn.php");

    $uid = stripNumbers($uid);
    $type = clean($type);
    $method = clean($method);
    $array = clean($array);

    $out = "";
    $error = false;
    if (empty($uid) || empty($type) || empty($method)) $error = true;
    if ($method == "merge" && empty($array)) $error = true;
    if ($error == false) {
        if ($method == "merge") {
            if ($type == "titles") {
                $cloudHistory = [];
                $cloudHistorySql = $conn->query("SELECT `id`, `array` FROM `{$dbp}history_titles` WHERE `user_id`='$uid' LIMIT 1")->fetch_assoc();
                if (empty($cloudHistorySql["id"])) {
                    $conn->query("INSERT INTO `{$dbp}history_titles`(`user_id`,`array`) VALUES('$uid', NULL)");
                } else {
                    $cloudHistory = convStringToArray($cloudHistorySql["array"]);
                }
                $finalArray = convArrayToString(array_unique(array_merge($cloudHistory, $array), SORT_REGULAR));
                $conn->query("UPDATE `{$dbp}history_titles` SET `array`='$finalArray' WHERE `user_id`='$uid'");
            } elseif ($type == "chapters") {
                $cloudHistory = [];
                $cloudHistorySql = $conn->query("SELECT `id`, `array` FROM `{$dbp}history_chapters` WHERE `user_id`='$uid' LIMIT 1")->fetch_assoc();
                if (empty($cloudHistorySql)) {
                    $conn->query("INSERT INTO `{$dbp}history_chapters`(`user_id`,`array`) VALUES('$uid', NULL)");
                } else {
                    $cloudHistory = convStringToArray($cloudHistorySql["array"]);
                }
                $finalArray = convArrayToString(array_unique(array_merge($cloudHistory, $array), SORT_REGULAR));
                $conn->query("UPDATE `{$dbp}history_chapters` SET `array`='$finalArray' WHERE `user_id`='$uid'");
            }
        } elseif ($method == "fetch") {
            if ($type == "titles") {
                $cloudHistory = $conn->query("SELECT `id`, `array` FROM `{$dbp}history_titles` WHERE `user_id`='$uid' LIMIT 1")->fetch_assoc();
                if (empty($cloudHistory["id"])) {
                    $conn->query("INSERT INTO `{$dbp}history_titles`(`user_id`,`array`) VALUES('$uid', NULL)");
                    return "error";
                } else {
                    return $cloudHistory["array"];
                }
            } elseif ($type == "chapters") {
                $cloudHistory = $conn->query("SELECT `id`, `array` FROM `{$dbp}history_chapters` WHERE `user_id`='$uid' LIMIT 1")->fetch_assoc();
                if (empty($cloudHistory["id"])) {
                    $conn->query("INSERT INTO `{$dbp}history_chapters`(`user_id`,`array`) VALUES('$uid', NULL)");
                    return "error";
                } else {
                    return $cloudHistory["array"];
                }
            }
        }
    }
    if ($error == false && $method == "merge") $out = "success";
    return $out;
}

function deleteSync($uid)
{
    require("../core/config.php");
    require("../core/conn.php");
    $out = "";
    $conn->query("DELETE FROM `{$dbp}history_titles` WHERE `user_id`='$uid'");
    $conn->query("DELETE FROM `{$dbp}history_chapters` WHERE `user_id`='$uid'");
    return $out;
}
