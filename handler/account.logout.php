<?php

require("../load.php");
require("../sql/account.php");

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login");
    $error = false;
    die("You're not even logged in? If you are, contact the developers - this is a bug! (Also, you are ignoring headers, this isn't a good sign!)");
}

// Removing token from Database and destroy entire session and so on
$token = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_session"]));
$conn->query("DELETE FROM `sessions` WHERE `token`='$token'");
setcookie(config("cookie") . "_session", "", time() - 3600, "/", "");
if (isset($_GET["redirect"])) {
    header("Location: " . config("url") . clean(mysqli_real_escape_string($conn, $_GET["redirect"])));
} else {
    header("Location: " . config("url") . "home");
}
die("Lass' es gut sein.");
