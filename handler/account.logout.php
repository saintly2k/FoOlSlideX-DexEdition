<?php

$loggingout = true;

require("../load.php");
require("../sql/account.php");

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login");
    $error = true;
    logs("0", "tryLogout", "Not Loggedout", "Error: Not Loggedin");
    die("You're not even logged in? If you are, contact the developers - this is a bug! (Also, you are ignoring headers, this isn't a good sign!)");
}

// Removing token from Database and destroy entire session and so on
logs($user["id"], "tryLogout", "Not Loggedout", "success");
$token = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_session"]));
$conn->query("DELETE FROM `{$dbp}sessions` WHERE `token`='$token'");
setcookie(config("cookie") . "_session", "", time() - 3600, "/", "");
if (isset($_GET["redirect"])) {
    header("Location: " . config("url") . clean(mysqli_real_escape_string($conn, $_GET["redirect"])));
} else {
    header("Location: " . config("url") . "home");
}
die("Lass' es gut sein.");
