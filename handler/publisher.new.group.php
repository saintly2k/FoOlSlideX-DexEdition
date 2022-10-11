<?php

require("../load.php");
require("../sql/publisher.php");

$error = false;
$serror = false;

if ($userlevel["can_add_group"] == 0) {
    $error = true;
}

include("../themes/$usertheme/parts/header.php");
if ($error == false) {
    echo "<title>Publisher - New Grouop - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/publisher.new.group.php");
} else {
    echo "<title>Error - " . config("title") . "</title>";
    include("../themes/$usertheme/parts/menu.php");
    include("../themes/$usertheme/error.php");
}
include("../themes/$usertheme/parts/footer.php");
