<?php

// This file contains all functions regarding groups

function checkGroupFormData($name, $uplperms, $editperms, $status, $owner, $redirect, $creator, $mod)
{
    $error = false;
    $out = "error";
    $nl = strlen($name);
    if ($nl < 9 || $nl > 101) {
        $error = true;
        $out = "Name of Group needds to be between 10 and 100 characters.";
    }
    if ($mod == 1) {
        if (preg_match('#[^0-9,]#', $uplperms) == true && !empty($uplperms)) {
            $error = true;
            $out = "Upload Permissions Array has been messed with (Tip: Numbers and commas only!). That's clearly YOUR fault!";
        }
        if (preg_match('#[^0-9,]#', $editperms) == true && !empty($editperms)) {
            $error = true;
            $out = "Upload Permissions Array has been messed with (Tip: Numbers and commas only!). That's clearly YOUR fault!";
        }
        if ($status != 1 && $status != 2 && $status != 3 && !empty($status)) {
            $error = true;
            $out = "Group Status has been messed with (Tip: 1, 2 or 3 only!). That's clearly YOUR fault!";
        }
        if (!is_numeric($owner) && !empty($owner)) {
            $error = true;
            $out = "The ID of the Group owner is obviously a number, baka.";
        }
        if (!is_numeric($redirect) && !empty($redirect)) {
            $error = true;
            $out = "The ID of the Group group redirect obviously a number, baka.";
        }
    }
    if (!is_numeric($creator) || empty($creator)) {
        $error = true;
        $out = "The ID of the Group Creator is obviously a number, baka.";
    }
    if ($error == false) {
        $out = "success";
    }
    return $out;
}

function tryCreateGroup($name, $description, $uplperms, $editperms, $status, $owner, $redirect, $creator, $mod, $uid)
{
    require("../core/config.php");
    require("../core/conn.php");
    $error = false;
    $out = "";

    $check = $conn->query("SELECT * FROM `groups` WHERE `name`='$name' LIMIT 1")->fetch_assoc();
    if (!empty($check["id"])) {
        $error = true;
        $out = "A Group with that name already exists.";
    } else {
        // Group doesn't exist yet
        $description = !empty($description) ? "'" . $description . "'" : "NULL";
        if ($mod == 1) {
            $uplperms = !empty($uplperms) ? "'" . $uplperms . "'" : "NULL";
            $editperms = !empty($editperms) ? "'" . $editperms . "'" : "NULL";
            $status = !empty($status) ? "'" . $status . "'" : "NULL";
            $owner = !empty($owner) ? "'" . $owner . "'" : "NULL";
            $redirect = !empty($redirect) ? "'" . $redirect . "'" : "NULL";
        } else {
            $uplperms = "NULL";
            $editperms = "NULL";
            $status = "NULL";
            $owner = "NULL";
            $redirect = "NULL";
        }
        $sql = "INSERT INTO `groups`(`name`, `description`, `permission`, `modify`, `status`, `owner`, `redirect`, `creator`) VALUES ('$name',$description,$uplperms,$editperms,$status,$owner,$redirect,'$creator')";
        if (!$conn->query($sql)) {
            $out = "MySQL Error: " . $conn->error;
            logs($uid, "tryCreateGroup", "Not Created", "Error: " . $conn->error);
        } else {
            $out = "success";
            logs($uid, "tryCreateGroup", "Not Created", "success; $name; $description; $uplperms; $editperms; $status; $owner; $redirect; $creator; $mod;");
        }
    }

    if ($error == false) {
        $out = "success";
    }
    return $out;
}
