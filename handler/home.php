<?php

require("../load.php");

include("../themes/$usertheme/parts/header.php");
echo "<title>" . config("title") . " - " . config("description") . "</title>";
echo callFile(config("url") . "themes/$usertheme/home.php");
include("../themes/$usertheme/parts/menu.php");
include("../themes/$usertheme/skeletons/home.php");
include("../themes/$usertheme/parts/footer.php");
