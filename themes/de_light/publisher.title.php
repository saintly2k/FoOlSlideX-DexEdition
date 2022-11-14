<?php

require("../../load.php");

$id = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_currentTitle"]));
$title = $conn->query("SELECT * FROM `{$dbp}titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();

$permission_upload = $conn->query("SELECT * FROM  `{$dbp}permissions_upload` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc();
$permission_modify = $conn->query("SELECT * FROM  `{$dbp}permissions_modify` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc();
$permission_edit = $conn->query("SELECT * FROM  `{$dbp}permissions_edit` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc();
$can_upload = $permission_upload["user_id"] == 0 || in_array($user["id"], explode(",", $permission_upload["user_id"])) ? true : false;
$can_modify = $permission_modify["user_id"] == 0 || in_array($user["id"], explode(",", $permission_modify["user_id"])) ? true : false;
$can_edit = $permission_edit["user_id"] == 0 || in_array($user["id"], explode(",", $permission_edit["user_id"])) ? true : false;

?>

<script>
    $("title").html("Publisher - <?= $title["title"] ?> (Title) - <?= config("title") ?>");
</script>

<div class="col-span-4"></div>

<div class="col-span-4">
    <img src="<?= config("url") ?>data/covers/<?= $title["id"] . "." . $title["cover"] ?>" class="w-1/2 shadow-xl mx-auto" alt="Cover">
    <div class="text-center mt-4">
        <p class="text-gray-500 text-sm">
            You are editing
        </p>
        <p><a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" target="_blank" class="text-blue-500 hover:underline">#<?= $title["id"] ?></a></p>
        <p class="text-3xl"><a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" target="_blank" class="text-blue-500 hover:underline"><?= $title["title"] ?></a></p>
        <p class="text-gray-500">Created by <a href="<?= config("url") ?>user/<?= $title["user_id"] ?>/<?= cat(getUser($title["user_id"])["name"], "username") ?>" class="text-blue-500 hover:underline"><?= getUser($title["user_id"])["name"] ?></a> on <?= $title["timestamp"] ?></p>
        <hr class="my-2">
        <div class="mb-2">
            <?php if ($can_upload == true || $user["id"] == $title["user_id"]) { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/upload" target="_blank">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Upload Chapters</div>
                </a>
                <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800"><?= $can_upload == false && $user["id"] == $title["user_id"] ? "Only You" : "Everyone" ?></span>!</p>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Upload Chapters</div>
                <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800">
                        <?php $c = 1;
                        foreach ($permission_upload as $uploader) {
                            if ($c != 1) echo ", ";
                            echo getUser($uploader, "html");
                            $c++;
                        } ?></span>!</p>
            <?php } ?>
        </div>
        <div class="mb-2">
            <?php if ($can_modify == true || $user["id"] == $title["user_id"]) { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/chapters" target="_blank">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Modify Chapters</div>
                </a>
                <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800"><?= $can_modify == false && $user["id"] == $title["user_id"] ? "Only You" : "Everyone" ?></span>!</p>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Modify Chapters</div>
                <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800">
                        <?php $c = 1;
                        foreach ($permission_modify as $modifier) {
                            if ($c != 1) echo ", ";
                            echo getUser($modifier, "html");
                            $c++;
                        } ?></span>!</p>
            <?php } ?>
        </div>
        <div class="mb-2">
            <?php if ($can_edit == true || $user["id"] == $title["user_id"]) { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/edit" target="_blank">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Edit Title</div>
                </a>
                <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800"><?= $can_edit == false && $user["id"] == $title["user_id"] ? "Only You" : "Everyone" ?></span>!</p>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Edit Title</div>
                <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800">
                        <?php $c = 1;
                        foreach ($permission_edit as $editors) {
                            if ($c != 1) echo ", ";
                            echo getUser($editors, "html");
                            $c++;
                        } ?></span>!</p>
            <?php } ?>
        </div>
        <div class="mb-2">
            <?php if ($user["id"] == $title["user_id"]) { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/permission" target="_blank">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Manage Permissions</div>
                </a>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Manage Permissions</div>
            <?php } ?>
            <p class="text-gray-500 text-left">Who can perform this action? <span class="text-gray-800"><?= $user["id"] == $title["user_id"] ? "Only You (and Staff)" : "Creator (and Staff) Only" ?></span>!</p>
        </div>
    </div>
</div>

<div class="col-span-4"></div>