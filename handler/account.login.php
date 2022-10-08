<?php

require("../load.php");
require("../sql/account.php");

$error = false;

if ($loggedin == true) {
    header("Location: " . config("url") . "account/home");
    $error = false;
    die("Didn't you already login? If not, contact the developers - this is a bug! (Also, you are ignoring headers, this isn't a good sign!)");
}

if (isset($_POST["login"])) {
    $email = clean(mysqli_real_escape_string($conn, $_POST["email"]));
    $password = clean(mysqli_real_escape_string($conn, $_POST["password"]));
    $result = checkFormData("login", $email, $password, null);
    if ($result == "success") {
        $result = tryLogin($email, $password);
        if ($result == "success") {
            if (isset($_GET["redirect"])) {
                header("Location: " . config("url") . clean(mysqli_real_escape_string($conn, $_GET["redirect"])));
            } else {
                header("Location: " . config("url") . "account/home");
            }
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Login - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/account.login.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
