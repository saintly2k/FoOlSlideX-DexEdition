<?php

// Include must-have files for the site to work properly
require("core/config.php");
require("core/conn.php");
require("core/funky.php");
require("core/user.php");
require("core/custom.php");

if (config("debug") == 1) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

if (in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $banned_ips) || in_array($_SERVER['REMOTE_ADDR'], $banned_ips) || in_array($_SERVER["HTTP_CF_CONNECTING_IP"], $banned_ips)) die("You are banned because of abnormal behaviour (indicating you are maybe a Bot or someone with malicious intent). Please contact the administration if it's a bug.");

// Get all Cookies, etc
$usertheme = isset($_COOKIE[config("cookie") . "_theme"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_theme"])) : config("default_theme");
$userlang = isset($_COOKIE[config("cookie") . "_lang"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_lang"])) : config("default_language");
$userhistory = isset($_COOKIE[config("cookie") . "_history"]) ? explode(",", clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_history"]))) : array();
$userreadchapters = isset($_COOKIE[config("cookie") . "_readChapters"]) ? explode(",", clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_readChapters"]))) : array();
$readingmode = isset($_COOKIE[config("cookie") . "_readingMode"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_readingMode"])) : config("default_readingmode");

// Include default files
require("languages/default/$userlang.def.php");
if (file_exists("languages/custom/$userlang.cus.php")) require("languages/custom/$userlang.cus.php");
if (file_exists("languages/custom/universal.php")) require("languages/custom/universal.php");
