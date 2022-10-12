<?php

require("../../load.php");

$popular_titles = $conn->query("SELECT * FROM `titles` ORDER BY `id` DESC LIMIT " . config("home_display_titles"));
$latest_chapters = $conn->query("SELECT * FROM `chapters` WHERE `awaiting_approval`=0 AND `deleted`=0 ORDER BY `id` DESC LIMIT " . config("home_display_chapters"));

?>

<div class="col-span-12">
    <h1 class="text-2xl border-b mb-1"><?= $lang["popular_titles"] ?></h1>
    <div class="grid grid-cols-8 gap-1">
        <?php foreach ($popular_titles as $title) { ?>
            <div class="col-span-1 hover:scale-105">
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" title="<?= $title["title"] ?>">
                    <img alt="Cover" src="<?= config("url") ?>data/covers/<?= $title["id"] . "." . $title["cover"] ?>" class="w-full h-48 hover:rounded" title="<?= $title["title"] ?>">
                    <p class="hover:underline w-full -mt-1" title="<?= $title["title"] ?>"><?= shorten($title["title"], 22) ?></p>
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<div class="col-span-12">
    <h1 class="text-2xl border-b mb-1"><?= $lang["recent_chapters"] ?></h1>
    <div class="grid grid-cols-3 gap-2">
        <?php foreach ($latest_chapters as $chapter) { ?>
            <?php $title = $conn->query("SELECT * FROM `titles` WHERE `id`='" . $chapter["title_id"] . "' LIMIT 1")->fetch_assoc(); ?>
            <?php $lu = $conn->query("SELECT * FROM `user` WHERE `id`='" . $chapter["user_id"] . "' LIMIT 1")->fetch_assoc(); ?>
            <?php $genre = explode(", ", $title["genre"]); ?>
            <div class="col-span-1 grid grid-cols-3 gap-2">
                <div class="col-span-1">
                    <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>">
                        <img src="<?= config("url") ?>data/covers/<?= $title["id"] ?>.jpeg" class="w-full rounded shadow-xl" alt="Cover">
                    </a>
                </div>
                <div class="col-span-2 p-1 pt-2">
                    <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="font-bold hover:underline">
                        <?= $title["title"] ?>
                    </a>
                    <p>
                        <?php
                        $c = 1;
                        foreach ($genre as $g) {
                            if ($c != 1) echo ", ";
                            echo "<a href='" . config("url") . "search?genre=$g' class='hover:underline text-blue-500'>$g</a>";
                            $c++;
                        }
                        ?>
                    </p>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-left">
                            <a href="<?= config("url") ?>chapter/<?= $chapter["id"] ?>" class="text-blue-500 hover:underline"><?= chTtile("home", $chapter["volume"], $chapter["chapter"], $chapter["release_name"], $chapter["release_short"], $chapter["title"]) ?></a>
                        </div>
                        <div class="col-span-1 text-right flex justify-end items-right">
                            <a href="<?= config("url") ?>user/<?= $lu["id"] ?>/<?= cat($lu["username"], "username") ?>">
                                <img src="<?= config("url") ?>data/user/<?= $lu["id"] ?>.png" class="w-6 rounded-full" title="<?= $lu["username"] ?>'s Avatar" alt="Avatar">
                            </a>
                        </div>
                        <div class="col-span-1 text-right">
                            <?= timeAgo($chapter["timestamp"]) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>