<?php

require("../load.php");

$id = clean(mysqli_real_escape_string($conn, $_COOKIE["currentTitle"]));
$title = $conn->query("SELECT * FROM `titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();

?>

<div class="col-span-4"></div>

<div class="col-span-4">
    <img src="<?= config("url") ?>data/covers/<?= $title["id"] . "." . $title["cover"] ?>" class="w-1/2 shadow-xl mx-auto" alt="Cover">
    <div class="text-center mt-4">
        <p class="text-gray-500 text-sm">
            You are editing
        </p>
        <p><a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" target="_blank" class="text-blue-500 hover:underline">#<?= $title["id"] ?></a></p>
        <p class="text-3xl"><a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" target="_blank" class="text-blue-500 hover:underline"><?= $title["title"] ?></a></p>
        <p class="text-gray-500">Created by <?= getUser($title["user_id"], "html") ?> on <?= $title["timestamp"] ?></p>
        <hr class="my-2">
        <div class="mb-2">
            <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/upload">
                <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Upload Chapters</div>
            </a>
            <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800">Everyone</span>!</p>
        </div>
        <div class="mb-2">
            <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/chapters">
                <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Modify Chapters</div>
            </a>
            <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800">Everyone</span>!</p>
        </div>
        <div class="mb-2">
            <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/edit">
                <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Edit Title</div>
            </a>
            <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800">Everyone</span>!</p>
        </div>
        <div class="mb-2">
            <?php if ($user["id"] == $title["user_id"]) { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/permission">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Manage Permissions</div>
                </a>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Manage Permissions</div>
            <?php } ?>
            <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800">Creator only</span>!</p>
        </div>
    </div>
</div>

<div class="col-span-4"></div>