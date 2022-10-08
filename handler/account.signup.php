<?php

require("../load.php");
require("../sql/account.php");

if ($loggedin == true) {
    header("Location: " . config("url") . "account/home");
    die("Didn't you already login? If not, contact the developers - this is a bug! (Also, you are ignoring headers, this isn't a good sign!)");
}

$error = false;

if (isset($_POST["signup"])) {
    $email = clean(mysqli_real_escape_string($conn, $_POST["email"]));
    $password = clean(mysqli_real_escape_string($conn, $_POST["password"]));
    $password2 = clean(mysqli_real_escape_string($conn, $_POST["password2"]));
    $result = checkFormData("signup", $email, $password, $password2);
    if ($result == "success") {
        $result = trySignup($email, $password);
        if ($result == "success") {
            header("Location: " . config("url") . "account/login");
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}

include("../themes/$usertheme/parts/header.php");
echo "<title>Signup - " . config("title") . "</title>";
include("../themes/$usertheme/parts/menu.php");
include("../themes/$usertheme/account.signup.php");
include("../themes/$usertheme/parts/footer.php");
