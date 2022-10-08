<?php

require("../load.php");
require("../sql/account.php");

$error = false;

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login?redirect=publisher/home");
    die("You don't seem to be logged in! (Also, you are ignoring headers, this isn't a good sign!)");
    $error = true;
}

if (!isset($_GET["tab"])) {
    header("Location: " . config("url") . "publisher/home");
    $error = true;
}

include("../themes/$usertheme/parts/header.php");
include("../themes/$usertheme/parts/menu.php");
if ($error == false) {
    echo "<title>Publisher - Home - " . config("title") . "</title>";
    include("../themes/$usertheme/publisher.home.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
