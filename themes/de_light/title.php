<?php

require("../../load.php");

$id = clean(mysqli_real_escape_string($conn, $_COOKIE["currentTitle"]));
$title = $conn->query("SELECT * FROM `titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();
$authors = explode(", ", $title["authors"]);
$artists = explode(", ", $title["artists"]);
$genre = explode(", ", $title["genre"]);
$resources = $conn->query("SELECT * FROM `resources` WHERE `title_id`='$id' ORDER BY `name` ASC");

?>

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
        <h2 class="text-xl font-bold underline">Details</h2>
        <b class="text-gray-500">Author(s):</b>
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
        <b class="text-gray-500">Artist(s):</b>
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
        <b class="text-gray-500">Genre(s):</b>
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
        <b class="text-gray-500">Original Language:</b> <?= !empty($title["original_language"]) ? "<a href='" . config("url") . "search?language=" . $title["original_language"] . "' class='text-blue-500 hover:underline'>" . $title["original_language"] . "</a>" : $lang["unknown"] ?><br>
        <b class="text-gray-500">Original work:</b> <?= !empty($title["original_work"]) ? convertWork($title["original_work"]) : $lang["unknown"] ?><br>
        <b class="text-gray-500">Upload status:</b> <?= !empty($title["original_work"]) ? convertUpload($title["upload_status"]) : $lang["unknown"] ?><br>
        <b class="text-gray-500">Year of Release:</b> <?= !empty($title["release_year"]) ? $title["release_year"] : $lang["unknown"] ?>
        <?php if (!empty($title["summary"])) { ?>
            <h2 class="text-xl font-bold underline">Summary</h2>
            <p class="just"><?= $title["summary"] ?></p>
        <?php } ?>
        <h2 class="text-xl font-bold underline">Resources</h2>
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