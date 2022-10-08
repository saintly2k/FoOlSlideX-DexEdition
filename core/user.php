<?php

// Here we will try to load user-data (to-do)
if (isset($_COOKIE[config("cookie") . "_session"]) && !empty($_COOKIE[config("cookie") . "_session"])) {
    if (!empty($_COOKIE[config("cookie") . "_session"])) {
        $checking = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_session"]));
    } else {
        $checking = clean(mysqli_real_escape_string($conn, $_SESSION[config("cookie") . "_session"]));
    }
    $checking = $conn->query("SELECT * FROM `sessions` WHERE `token`='$checking'");
    if (mysqli_num_rows($checking) == 1) {
        // Perform user-check of all data
        $user = mysqli_fetch_assoc($checking);
        $user = $user["user"];
        $user = $conn->query("SELECT * FROM `user` WHERE `id`='$user' LIMIT 1")->fetch_assoc();
        $loggedin = true;
    } else {
        // Invalid session! (Hacking attempt or outdated? Who knows...)
        $loggedin = false;
    }
} else {
    $loggedin = false;
}
