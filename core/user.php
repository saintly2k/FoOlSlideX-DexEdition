<?php

// Here we will try to load user-data (to-do)
if (isset($_COOKIE[config("cookie") . "_session"]) && !empty($_COOKIE[config("cookie") . "_session"])) {
    if (!empty($_COOKIE[config("cookie") . "_session"])) {
        $checking = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_session"]));
    } else {
        $checking = clean(mysqli_real_escape_string($conn, $_SESSION[config("cookie") . "_session"]));
    }
    $checking = $conn->query("SELECT * FROM `{$dbp}sessions` WHERE `token`='$checking'");
    if (mysqli_num_rows($checking) == 1) {
        // Perform user-check of all data
        $user = mysqli_fetch_assoc($checking);
        $user = $conn->query("SELECT * FROM `{$dbp}user` WHERE `id`='" . $user["user"] . "' LIMIT 1")->fetch_assoc();
        $loggedin = true;
        $userlevel = $conn->query("SELECT * FROM `{$dbp}levels` WHERE `level`='" . $user["level"] . "' LIMIT 1")->fetch_assoc();
    } else {
        // Invalid session! (Hacking attempt or outdated? Who knows...)
        $loggedin = false;
        $userlevel = $conn->query("SELECT * FROM `{$dbp}levels` WHERE `level`='" . config("guestlevel") . "' LIMIT 1")->fetch_assoc();
    }
} else {
    $loggedin = false;
    $userlevel = $conn->query("SELECT * FROM `{$dbp}levels` WHERE `level`='" . config("guestlevel") . "' LIMIT 1")->fetch_assoc();
}

if ($userlevel["banned"] == 1 && $loggedin == true && !isset($loggingout)) {
    echo "You're banned. Don't ignore headers you idiot.";
    header("Location: " . config("url") . "account/logout");
    die("You're banned. Don't ignore headers you idiot.");
}
