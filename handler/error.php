<?php

require("../load.php");

include("../themes/$usertheme/parts/header.php");
echo "<title>Error - " . config("title") . "</title>";
echo callFile("themes/$usertheme/error.php");
include("../themes/$usertheme/parts/menu.php");
include("../themes/$usertheme/skeletons/error.php");
include("../themes/$usertheme/parts/footer.php");
