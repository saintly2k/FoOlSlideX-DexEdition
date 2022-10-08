<?php

require("../load.php");
require("../sql/account.php");

$error = false;
$serror = false;

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login?redirect=account/home");
    die("You don't seem to be logged in! (Also, you are ignoring headers, this isn't a good sign!)");
    $error = true;
}

if (!isset($_GET["tab"])) {
    header("Location: " . config("url") . "account/home");
    $error = true;
}

if ($_GET["tab"] == "home") $tab = "home";
if ($_GET["tab"] == "profile") $tab = "profile";
if ($_GET["tab"] == "avatar") $tab = "avatar";
if ($_GET["tab"] == "email") $tab = "email";
if ($_GET["tab"] == "password") $tab = "password";
if ($_GET["tab"] == "sessions") $tab = "sessions";
if ($_GET["tab"] != "home" && $_GET["tab"] != "profile" && $_GET["tab"] != "avatar" && $_GET["tab"] != "email" && $_GET["tab"] != "password" && $_GET["tab"] != "sessions") $error = true;

if (isset($_POST["editProfile"])) {
    $uid = $user["id"];
    $username = clean(mysqli_real_escape_string($conn, $_POST["username"]));
    $public = clean(mysqli_real_escape_string($conn, $_POST["public"]));
    $gender = clean(mysqli_real_escape_string($conn, $_POST["gender"]));
    $biography = clean(mysqli_real_escape_string($conn, $_POST["biography"]));
    $return = checkProfileData($username, $public, $gender);
    if ($return == "success") {
        // Right!
        $return = tryEditProfile($uid, $username, $public, $gender, $biography);
        if ($return == "success") {
            $user["username"] = $username;
            $user["public"] = $public;
            $user["gender"] = $gender;
            $user["biography"] = $biography;
        } else {
            $serror = true;
        }
    } else {
        $serror = true;
    }
}

if (isset($_POST["deleteSession"])) {
    $sid = clean(mysqli_real_escape_string($conn, $_POST["sid"]));
    $token = $conn->query("SELECT `token` FROM `sessions` WHERE `id`='$sid' AND `user`='" . $user["id"] . "' LIMIT 1")->fetch_assoc();
    delSession($sid, $user["id"]);
    if ($token["token"] == clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_session"]))) {
        header("Location: " . config("url") . "account/login?redirect=account/sessions");
        $error = true;
    }
}

if (isset($_POST["editPassword"])) {
    $password1 = clean(mysqli_real_escape_string($conn, $_POST["password_old"]));
    $password2 = clean(mysqli_real_escape_string($conn, $_POST["password_new1"]));
    $password3 = clean(mysqli_real_escape_string($conn, $_POST["password_new2"]));
    $return = checkPassData($user["password"], $password1, $password2, $password3);
    if ($return == "success") {
        // Right!
        $return = tryEditPassword($user["id"], $password2);
        if ($return == "success") {
            header("Location: " . config("url") . "account/login?redirect=account/password");
            $error = true;
        } else {
            $serror = true;
        }
    } else {
        $serror = true;
    }
}

include("../themes/$usertheme/parts/header.php");
include("../themes/$usertheme/parts/menu.php");
if ($error == false) {
    echo "<title>Account - " . ucfirst($tab) . " - " . config("title") . "</title>";
    include("../themes/$usertheme/account.home.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
