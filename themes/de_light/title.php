<?php

require("../../load.php");

$error = false;
$id = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_currentTitle"]));
$title = $conn->query("SELECT * FROM `titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();
if (!empty($title["id"])) {
    $authors = explode(", ", $title["authors"]);
    $artists = explode(", ", $title["artists"]);
    $genre = explode(", ", $title["genre"]);
    $resources = $conn->query("SELECT * FROM `resources` WHERE `title_id`='$id' ORDER BY `name` ASC");
    $chapters = $conn->query("SELECT * FROM `chapters` WHERE `title_id`='$id' ORDER BY `order` DESC");
} else {
    $error = true;
}

if ($error == false) {

?>

    <script>
        $("title").html("<?= $title["title"] ?> (Title) - <?= config("title") ?>");
    </script>

    <div class="col-span-12">
        <h1 class="text-3xl hover:underline"><a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>"><?= $title["title"] ?></a></h1>
        <?php if (!empty($title["alt_names"])) { ?><h3><?= $title["alt_names"] ?></h3><?php } ?>
    </div>

    <hr class="col-span-12">

    <div class="col-span-2">
        <a href="<?= config("url") ?>data/covers/<?= $title["id"] . "." . $title["cover"] ?>" target="_blank">
            <img src="<?= config("url") ?>data/covers/<?= $title["id"] . "." . $title["cover"] ?>" alt="Cover" class="w-full shadow-xl">
        </a>
    </div>

    <div class="col-span-10">
        <div>
            <h2 class="text-xl font-bold underline"><?= $lang["details"] ?></h2>
            <b class="text-gray-500"><?= $lang["authors"] ?>:</b>
            <?php if (!empty($authors)) {
                $c = 1;
                foreach ($authors as $a) {
                    if ($c != 1) echo ", ";
                    echo "<a href='" . config("url") . "search?author=$a' class='hover:underline text-blue-500'>$a</a>";
                    $c++;
                }
            } else {
                echo $lang["unknown"];
            } ?><br>
            <b class="text-gray-500"><?= $lang["artists"] ?>:</b>
            <?php if (!empty($artists)) {
                $c = 1;
                foreach ($artists as $a) {
                    if ($c != 1) echo ", ";
                    echo "<a href='" . config("url") . "search?artist=$a' class='hover:underline text-blue-500'>$a</a>";
                    $c++;
                }
            } else {
                echo $lang["unknown"];
            } ?><br>
            <b class="text-gray-500"><?= $lang["genres"] ?>:</b>
            <?php if (!empty($genre)) {
                $c = 1;
                foreach ($genre as $g) {
                    if ($c != 1) echo ", ";
                    echo "<a href='" . config("url") . "search?genre=$g' class='hover:underline text-blue-500'>$g</a>";
                    $c++;
                }
            } else {
                echo $lang["unknown"];
            } ?><br>
            <b class="text-gray-500"><?= $lang["original_language"] ?>:</b> <?= !empty($title["original_language"]) ? "<a href='" . config("url") . "search?language=" . $title["original_language"] . "' class='text-blue-500 hover:underline'>" . $title["original_language"] . "</a>" : $lang["unknown"] ?><br>
            <b class="text-gray-500"><?= $lang["original_work"] ?>:</b> <?= !empty($title["original_work"]) ? convertWork($title["original_work"]) : $lang["unknown"] ?><br>
            <b class="text-gray-500"><?= $lang["upload_status"] ?>:</b> <?= !empty($title["original_work"]) ? convertUpload($title["upload_status"]) : $lang["unknown"] ?><br>
            <b class="text-gray-500"><?= $lang["year_of_release"] ?>:</b> <?= !empty($title["release_year"]) ? $title["release_year"] : $lang["unknown"] ?><br>
            <b class="text-gray-500"><?= $lang["year_of_completion"] ?>:</b> <?= !empty($title["complete_year"]) ? $title["complete_year"] : $lang["unknown"] ?>
            <?php if (!empty($title["summary"])) { ?>
                <h2 class="text-xl font-bold underline"><?= $lang["summary"] ?></h2>
                <p class="just"><?= $title["summary"] ?></p>
            <?php } ?>
            <h2 class="text-xl font-bold underline"><?= $lang["resources"] ?></h2>
            <?php if (mysqli_num_rows($resources) != 0) {
                $c = 1;
                foreach ($resources as $r) {
                    if ($c != 1) echo ", ";
                    echo "<a href='" . $r["link"] . "' class='text-blue-500 hover:underline' target='_blank'>" . $r["name"] . "</a>";
                    $c++;
                }
            } else {
                echo $lang["there_are_no_linked_resources"];
            } ?>
        </div>
    </div>

    <div class="col-span-12">
        <h2 class="text-xl font-bold underline">Chapters</h2>
        <?php foreach ($chapters as $ch) { ?>
            <?php $groups = explode(",", $ch["groups"]); ?>
            <div class="border border-black p-1 grid grid-cols-8 hover:bg-gray-100">
                <p class="col-span-4 font-bold">
                    <a href="<?= config("url") ?>chapter/<?= $ch["id"] ?>" class="text-blue-700 hover:underline">
                        <?= chTtile("list", $ch["volume"], $ch["chapter"], $ch["release_name"], $ch["release_short"], $ch["title"]) ?>
                    </a>
                </p>
                <div class="col-span-2 text-center">
                    <?php $gc = 1;
                    if (!empty($groups)) {
                        foreach ($groups as $group) {
                            if ($gc != 1) echo ", ";
                            echo "<a href='" . config("url") . "group/$group/" . cat(getGroup($group, "username")["name"]) . "' class='text-blue-500 hover:underline'>" . getGroup($group)["name"] . "</a>";
                            $gc++;
                        }
                    } ?>
                </div>
                <div class="col-span-1 text-center">
                    <a href="<?= config("url") ?>user/<?= $ch["user_id"] ?>/<?= cat(getUser($ch["user_id"])["name"], "username") ?>" class="text-blue-500 hover:underline flex">
                        <img src="<?= config("url") ?>data/user/<?= $ch["user_id"] ?>.png" class="w-6 mr-1 rounded-full" alt="Avatar">
                        <?= getUser($ch["user_id"])["name"] ?>
                    </a>
                </div>
                <div class="col-span-1 text-right">
                    <?= formatDate($ch["timestamp"], true) ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="col-span-12">
        Comments
    </div>

    <div class="col-span-12 mb-2 text-center">
        <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>">
            <div class="bg-blue-500 hover:bg-blue-800 w-full p-1 text-white border border-black shadow-xl">
                Open and Manage in Publisher
            </div>
        </a>
    </div>

<?php } else { ?>
    <script>
        $("title").html("Error - <?= config("title") ?>");
    </script>

    <div class="col-span-12 mx-auto">
        <img src="<?= config("url") ?>data/assets/img/error.jpg" class="w-25 rounded" alt="Error!">
    </div>
<?php } ?>