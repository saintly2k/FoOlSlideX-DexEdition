<?php

// Include must-have files for the site to work properly
require("core/config.php");
require("core/conn.php");
require("core/funky.php");
require("core/user.php");

// Get all Cookies, etc
$usertheme = isset($_COOKIE[config("cookie") . "_theme"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_theme"])) : config("default_theme");
$userlang = isset($_COOKIE[config("cookie") . "_lang"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_lang"])) : config("default_language");
$userhistory = isset($_COOKIE[config("cookie") . "_history"]) ? explode(",", clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_history"]))) : array();
$userreadchapters = isset($_COOKIE[config("cookie") . "_readChapters"]) ? explode(",", clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_readChapters"]))) : array();
$readingmode = isset($_COOKIE[config("cookie") . "_readingMode"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_readingMode"])) : config("default_readingmode");

// Include default files
require("languages/default/$userlang.def.php");
if (file_exists("languages/custom/$userlang.cus.php")) require("languages/custom/$userlang.cus.php");
