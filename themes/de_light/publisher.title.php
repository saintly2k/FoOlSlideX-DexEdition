<?php

require("../../load.php");

$id = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_currentTitle"]));
$title = $conn->query("SELECT * FROM `{$dbp}titles` WHERE `id`='$id' LIMIT 1")->fetch_assoc();

$permission_upload = explode(",", $conn->query("SELECT `user_id` FROM  `{$dbp}permissions_upload` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc()["user_id"]);
$permission_modify = explode(",", $conn->query("SELECT `user_id` FROM  `{$dbp}permissions_modify` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc()["user_id"]);
$permission_edit = explode(",", $conn->query("SELECT `user_id` FROM  `{$dbp}permissions_edit` WHERE `title_id`='$id' LIMIT 1")->fetch_assoc()["user_id"]);
$can_upload = $permission_upload == 0 || in_array($user["id"], $permission_upload) ? true : false;
$can_modify = $permission_modify == 0 || in_array($user["id"], $permission_modify) ? true : false;
$can_edit = $permission_edit == 0 || in_array($user["id"], $permission_edit) ? true : false;

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
            <?php if ($can_upload == true || $user["id"] == $title["user_id"] || $permission_upload[0] == "0") { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/upload" target="_blank">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Upload Chapters</div>
                </a>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Upload Chapters</div>
            <?php } ?>
            <p class="text-gray-500 text-left">Who can perform this action?
                <span class="text-gray-800">
                    <?php if ($permission_upload[0] == "0") { ?>
                        Everyone
                    <?php } else { ?>
                        <?php $c = 1;
                        foreach ($permission_upload as $uploader) {
                            if ($c != 1) echo ", ";
                            $u = getUser($uploader, "html");
                            echo '<a href="' . config("url") . 'user/' . $u["id"] . '/' . cat($u["name"]) . '" class="text-blue-500 hover:underline">' . $u["name"] . '</a>';
                            $c++;
                        } ?>
                    <?php } ?>
                </span>
            </p>
        </div>
        <div class="mb-2">
            <?php if ($can_modify == true || $user["id"] == $title["user_id"] || $permission_modify[0] == "0") { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/chapters" target="_blank">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Modify Chapters</div>
                </a>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Modify Chapters</div>
            <?php } ?>
            <p class="text-gray-500 text-left">Who can perform this action?
                <span class="text-gray-800">
                    <?php if ($permission_modify[0] == "0") { ?>
                        Everyone
                    <?php } else { ?>
                        <?php $c = 1;
                        foreach ($permission_modify as $modifier) {
                            if ($c != 1) echo ", ";
                            $u = getUser($modifier, "html");
                            echo '<a href="' . config("url") . 'user/' . $u["id"] . '/' . cat($u["name"]) . '" class="text-blue-500 hover:underline">' . $u["name"] . '</a>';
                            $c++;
                        } ?>
                    <?php } ?>
                </span>
            </p>
        </div>
        <div class="mb-2">
            <?php if ($can_edit == true || $user["id"] == $title["user_id"] || $permission_edit[0] == "0") { ?>
                <a href="<?= config("url") ?>publisher/title/<?= $title["id"] ?>/edit" target="_blank">
                    <div class="p-1 bg-green-500 text-white border border-black hover:bg-green-800 shadow-xl">Edit Title</div>
                </a>
            <?php } else { ?>
                <div class="p-1 bg-red-500 text-white border border-black cursor-not-allowed shadow-xl">Edit Title</div>
            <?php } ?>
            <p class="text-gray-500 text-left">Who can perform this action?
                <span class="text-gray-800">
                    <?php if ($permission_edit[0] == "0") { ?>
                        Everyone
                    <?php } else { ?>
                        <?php $c = 1;
                        foreach ($permission_edit as $editor) {
                            if ($c != 1) echo ", ";
                            $u = getUser($editor, "html");
                            echo '<a href="' . config("url") . 'user/' . $u["id"] . '/' . cat($u["name"]) . '" class="text-blue-500 hover:underline">' . $u["name"] . '</a>';
                            $c++;
                        } ?>
                    <?php } ?>
                </span>
            </p>
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