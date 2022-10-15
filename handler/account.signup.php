<?php

require("../load.php");
require("../sql/account.php");

$error = false;

if ($loggedin == true || $userlevel["can_signup"] == 0) {
    header("Location: " . config("url") . "home");
    $error = true;
    die("You don't have permissions to perform this action. Contact Administration for further details. (Also, you are ignoring headers, this isn't a good sign!)");
}

$result2 = "success";
if (isset($_POST["signup"])) {
    $email = clean(mysqli_real_escape_string($conn, $_POST["email"]));
    $password = clean(mysqli_real_escape_string($conn, $_POST["password"]));
    $password2 = clean(mysqli_real_escape_string($conn, $_POST["password2"]));
    $result = checkFormData("signup", $email, $password, $password2);
    if ($result == "success") {
        $result2 = trySignup($email, $password);
        if ($result2 == "success") {
            header("Location: " . config("url") . "account/login");
        }
    }
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Signup - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/account.signup.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
