<?php

require("../load.php");
require("../sql/account.php");

$error = false;

if ($loggedin == false) {
    header("Location: " . config("url") . "account/login?redirect=publisher/home");
    $error = true;
    die("You don't seem to be logged in? If you are, contact the developers - this is a bug! (Also, you are ignoring headers, this isn't a good sign!)");
}

if (!isset($_GET["tab"])) {
    header("Location: " . config("url") . "publisher/home");
    $error = true;
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Publisher - Home - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.home.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
