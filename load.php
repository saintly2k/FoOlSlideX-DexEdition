<?php

// Include must-have files for the site to work properly
require("core/config.php");
require("core/conn.php");
require("core/funky.php");
require("core/user.php");

// Get all Cookies, etc
$usertheme = isset($_COOKIE[config("cookie") . "_theme"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_theme"])) : config("default_theme");
$userlang = isset($_COOKIE[config("cookie") . "_lang"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_lang"])) : config("default_language");
$userhistory = isset($_COOKIE[config("cookie") . "_history"]) ? clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_history"])) : array();

// Include default files
require("languages/default/$userlang.def.php");
if (file_exists("languages/custom/$userlang.cus.php")) require("languages/custom/$userlang.cus.php");
