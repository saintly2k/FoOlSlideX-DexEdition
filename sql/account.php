<?php

function checkFormData($type, $email, $password, $password2 = null)
{
    $error = false;
    $out = "error";
    if ($type == "signup") {
        if ($password != $password2) {
            $error = true;
            $out = "Passwords don't match!";
        }
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $out = "Invalid Email!";
    }
    if ($error == false) {
        $eml = strlen($email);
        $pwl = strlen($password);
        if ($eml < 7 || $eml > 50) {
            $error = true;
            $out = "Email needs to be between 8 and 50 characters!";
        }
        if ($pwl < 7 || $pwl > 200) {
            $error = true;
            $out = "Password needs to be between 8 and 200 characters!";
        }
        if ($error == false) {
            $out = "success";
        }
    }
    return $out;
}

function trySignup($email, $password)
{
    require("../core/config.php");
    require("../core/conn.php");

    $email = clean($email);
    $password = clean($password);

    $emailcheck = $conn->query("SELECT * FROM `{$dbp}user` WHERE `email`='$email' LIMIT 1")->fetch_assoc();
    if (!empty($emailcheck["id"])) {
        $out = "Email already in use!";
        logs("0", "trySignup", "Not Created", "Error: Email");
    } else {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $username = genUsername();
        $conn->query("INSERT INTO `{$dbp}user`(`level`,`username`,`email`,`password`,`avatar`,`public`,`gender`,`biography`,`banned`,`banned_reason`) VALUES('" . config("defaultlevel") . "', '$username', '$email', '$password', 'png', '1', '0', NULL, '0', NULL)");
        $c = $conn->query("SELECT * FROM `{$dbp}user` ORDER BY `id` DESC LIMIT 1")->fetch_assoc();
        $c = $c["id"];
        copy("../data/user/0.png", "../data/user/$c.png");
        $out = "success";
        logs("0", "trySignup", "Not Created", "success");
    }
    return $out;
}

function tryLogin($email, $password)
{
    require("../core/config.php");
    require("../core/conn.php");

    $email = clean($email);
    $password = clean($password);

    $error = false;
    $check = $conn->query("SELECT * FROM `{$dbp}user` WHERE `email`='$email' LIMIT 1");
    if (mysqli_num_rows($check) == 1 && $error == false) {
        // Account exists!
        $check = mysqli_fetch_assoc($check);
        $check = password_verify($password, $check["password"]);
        if ($check == true) {
            // Yay, user exists & passowrd matches!
            $user = $conn->query("SELECT * FROM `{$dbp}user` WHERE `email`='$email' LIMIT 1")->fetch_assoc();
            if ($user["banned"] == true) {
                $error = true;
                $out = "This account has been banned. Reason: " . $user["banned_reason"];
                logs($user["id"], "tryLogin", "Not Loggedin", "Error: Banned");
            } else {
                $token = md5(rand());
                $ip = getIpAddress();
                $browser = getBrowser();
                $browserDetails = $browser["userAgent"];
                $browser = $browser["name"] . " " . $browser["version"] . ", " . ucfirst($browser["platform"]);
                $conn->query("INSERT INTO `{$dbp}sessions`(`user`,`token`,`browser`,`browser_details`,`ip`) VALUES('" . $user["id"] . "','$token','$browser','$browserDetails','$ip')");
                setcookie(config("cookie") . "_session", $token, time() + (10 * 365 * 24 * 60 * 60), "/");
                $out = "success";
                logs($user["id"], "tryLogin", "Not Loggedin", "success");
            }
        } else {
            // Ewww error
            $error = true;
            $out = "Password is wrong!";
            logs($user["id"], "tryLogin", "Not Loggedin", "Error: Wrong Password");
        }
    } else {
        // Email doesn't match
        $error = true;
        $out = "Email is wrong!";
        logs($user["id"], "tryLogin", "Not Loggedin", "Error: Wrong Email");
    }
    return $out;
}

function checkProfileData($username, $public, $gender)
{
    $error = false;
    $out = "error";
    $unl = strlen($username);

    if ($unl < 4 || $unl > 50) {
        $error = true;
        $out = "Username needs to be between 5 and 50 characters long.";
    } else {
        if ($public != "0" && $public != "1") {
            $error = true;
            $out = "Something went wrong - YOU messed up.";
        } else {
            if ($gender != "0" && $gender != "1" && $gender != "2" && $gender != "3" && $gender != "4") {
                $error = true;
                $out = "Something went wrong - YOU messed up.";
            }
        }
    }
    if ($error == false) {
        $out = "success";
    }
    return $out;
}

function tryEditProfile($uid, $username, $public, $gender, $biography)
{
    require("../core/config.php");
    require("../core/conn.php");

    $uid = stripNumbers($uid);
    $username = clean($username);
    $public = stripNumbers($public);
    $gender = stripNumbers($gender);
    $biography = clean($biography);

    $sql = "UPDATE `{$dbp}user` SET `username`='$username', `public`='$public', `gender`='$gender', `biography`='$biography' WHERE `id`='$uid'";
    $user = $conn->query("SELECT * FROM `{$dbp}user` WHERE `id`='$uid' LIMIT 1")->fetch_assoc();
    logs($uid, "tryEditProfileData", $user["username"] . "; " . $user["gender"] . "; " . $user["biography"], "$username; $gender; $biography;");
    if (!$conn->query($sql)) {
        $out = "MySQL Error: " . $conn->error;
        logs($user["id"], "tryEditProfile", "Not Edited", "Error: " . $conn->error);
    } else {
        $out = "success";
        logs($user["id"], "tryEditProfile", "Not Edited", "success");
    }
    return $out;
}

function delSession($sid, $uid)
{
    require("../core/config.php");
    require("../core/conn.php");
    $conn->query("DELETE FROM `{$dbp}sessions` WHERE `id`='$sid' AND `user`='$uid'");
    logs($uid, "delSession", "Not Deleted", "success");
}

function checkPassData($masterPassword, $passwordOld, $passwordNew1, $passwordNew2)
{
    $check = password_verify($passwordOld, $masterPassword);
    if ($check == true) {
        $error = empty($passwordOld) ? true : false;
        if ($error == false) {
            if ($passwordNew1 == $passwordNew2) {
                $pwl = strlen($passwordNew1);
                if ($pwl < 7 || $pwl > 200) {
                    $error = true;
                    $return = "New Password needs to be between 8 and 200 characters.";
                } else {
                    $error = empty($passwordNew1) ? true : false;
                    if ($error == false) {
                        $error = empty($passwordNew2) ? true : false;
                        if ($error == false) {
                            $error = false;
                            $return = "success";
                        } else {
                            $return = "You need to repeat the new password!";
                        }
                    } else {
                        $return = "You need to enter the new password!";
                    }
                }
            } else {
                $error = true;
                $return = "New Passwords don't match!";
            }
        } else {
            $return = "You need to enter the current password!";
        }
    } else {
        $error = true;
        $return = "Old Password is wrong!";
    }
    return $return;
}

function tryEditPassword($uid, $pwd)
{
    require("../core/config.php");
    require("../core/conn.php");

    $uid = stripNumbers($uid);
    $password = clean($password);

    $pwd = password_hash($pwd, PASSWORD_BCRYPT);
    $sql = "UPDATE `{$dbp}user` SET `password`='$pwd' WHERE `id`='$uid'";
    $user = $conn->query("SELECT * FROM `{$dbp}user` WHERE `id`='$uid' LIMIT 1")->fetch_assoc();
    logs($user["id"], "tryEditPasswordData", $user["password"], $pwd);
    setcookie(config("cookie") . "_session", "", time() - 3600, "/", "");
    if (!$conn->query($sql)) {
        $out = "MySQL Error: " . $conn->error;
        logs($user["id"], "tryEditPassword", "Not Edited", "Error: " . $conn->error);
    } else {
        $sql = "DELETE FROM `{$dbp}sessions` WHERE `user`='$uid'";
        if (!$conn->query($sql)) {
            $out = "MySQL Error: " . $conn->error;
            logs($user["id"], "tryEditPassword", "Session Not Deleted", "Error: " . $conn->error);
        } else {
            $out = "success";
            logs($user["id"], "tryEditPassword", "Not Edit", "success");
        }
    }
    return $out;
}
