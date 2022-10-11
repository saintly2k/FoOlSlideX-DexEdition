<?php

require("../load.php");
require("../sql/account.php");

$error = false;

if ($userlevel["can_login"] == 0) {
    header("Location: " . config("url") . "account/home");
    $error = false;
    die("You don't have permissions to perform this action. Contact Administration for further details. (Also, you are ignoring headers, this isn't a good sign!)");
}

$result2 = "success";
if (isset($_POST["login"])) {
    $email = clean(mysqli_real_escape_string($conn, $_POST["email"]));
    $password = clean(mysqli_real_escape_string($conn, $_POST["password"]));
    $result = checkFormData("login", $email, $password, null);
    if ($result == "success") {
        $result2 = tryLogin($email, $password);
        if ($result2 == "success") {
            if (isset($_GET["redirect"])) {
                header("Location: " . config("url") . clean(mysqli_real_escape_string($conn, $_GET["redirect"])));
            } else {
                header("Location: " . config("url") . "account/home");
            }
        }
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
