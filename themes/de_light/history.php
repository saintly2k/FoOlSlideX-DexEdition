<?php

require("../../load.php");
require("../../sql/history.php");

$tab = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_historyTab"]));
$page = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_currentPage"]));
$cerror = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_cloudError"]));
$home_display_chapters = config("home_display_chapters");
if ($tab == "Titles") {
    $min = $page * $home_display_chapters - $home_display_chapters;
    $max = $min + $home_display_chapters;
    $total = ceil(count($userhistory) / $home_display_chapters);
    $userhistoryp = array_reverse($userhistory);
    $userhistoryp = array_slice($userhistoryp, $min, $max);
} elseif ($tab == "Chapters") {
    $home_display_chapters = $home_display_chapters * 2;
    $min = $page * $home_display_chapters - $home_display_chapters;
    $max = $min + $home_display_chapters;
    $total = ceil(count($userreadchapters) / $home_display_chapters);
    $userreadchaptersp = array_reverse($userreadchapters);
    $userreadchaptersp = array_slice($userreadchaptersp, $min, $max);
}

?>

<div class="col-span-12">
    <h1 class="text-2xl">History - <?= $tab ?> - Page <?= $page ?></h1>
    <hr class="w-full mb-1">
    <div class="w-full grid grid-cols-2 gap-2">
        <a href="<?= config("url") ?>history?tab=titles&page=1" class="p-2 col-span-1 w-full text-center shadow-xl border border-black <?= $tab == "Titles" ? "bg-green-500 text-white hover:bg-green-800" : "bg-gray-200 hover:bg-gray-400" ?>">Titles</a>
        <a href="<?= config("url") ?>history?tab=chapters&page=1" class="p-2 col-span-1 w-full text-center shadow-xl border border-black <?= $tab == "Chapters" ? "bg-green-500 text-white hover:bg-green-800" : "bg-gray-200 hover:bg-gray-400" ?>">Chapters</a>
    </div>
    <hr class="w-full my-1">
    <?php if ($loggedin == true) { ?>
        <form method="POST" class="grid grid-cols-6 gap-2">
            <div class="col-span-6 flex p-4 text-sm text-red-700 bg-red-100 shadow-xl" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Alert!</span> Syncing with the Cloud will add to data in the Cloud! Fetching from Cloud will overwrite local data and your history on your current device will be lost!
                </div>
            </div>
            <?php if ($cerror != "0") { ?>
                <div id="alert-border-2" class="col-span-6 flex p-4 bg-red-100 border-t-4 border-red-500" role="alert">
                    <svg class="flex-shrink-0 w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3 text-sm text-red-700">
                        <span class="font-medium">Error with Cloud!</span> <?= $cerror ?>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#alert-border-2" aria-label="Close">
                        <span class="sr-only">Dismiss</span>
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            <?php } ?>
            <?php if (($tab == "Titles") && !empty($userhistory) || ($tab == "Chapters") && !empty($userreadchapters)) { ?>
                <button type="submit" name="syncCloud<?= $tab ?>" class="col-span-3 p-2 bg-green-500 text-white hover:bg-green-800 border border-black shadow-xl">Sync <?= $tab ?> with Cloud</button>
                <button type="submit" name="syncLocal<?= $tab ?>" class="col-span-2 p-2 bg-red-500 text-white hover:bg-red-800 border border-black shadow-xl">Fetch <?= $tab ?> from Cloud</button>
                <button type="submit" name="deleteSync" class="col-span-1 p-2 bg-black text-white border border-black shadow-xl" onclick="return confirmDelete();">Delete History from Cloud</button>
            <?php } else { ?>
                <button type="submit" name="syncLocal<?= $tab ?>" class="col-span-5 p-2 bg-green-500 text-white hover:bg-green-800 border border-black shadow-xl">Fetch <?= $tab ?> from Cloud</button>
                <button type="submit" name="deleteSync" class="col-span-1 p-2 bg-black text-white border border-black shadow-xl" onclick="return confirmDelete();">Delete History from Cloud</button>
            <?php } ?>
        </form>
    <?php } else { ?> <div class="grid grid-cols-2 gap-2">
            <div class="col-span-2 flex p-4 my-1 text-sm text-red-700 bg-red-100 shadow-xl" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Alert!</span> Please <a href="<?= config("url") ?>account/login?redirect=history" class="text-blue-500 hover:underline">login</a> or <a href="<?= config("url") ?>account/signup" class="text-blue-500 hover:underline">signup</a> to save your History to the cloud!
                </div>
            </div>
        </div>
    <?php } ?>
    <hr class="w-full my-1">
    <?php if ($tab == "Titles") { ?>
        <?php if (!empty($userhistoryp)) { ?>
            <div class="grid grid-cols-3 gap-2">
                <?php foreach ($userhistoryp as $tid) { ?>
                    <?php $title = $conn->query("SELECT * FROM `titles` WHERE `id`='$tid' LIMIT 1")->fetch_assoc(); ?>
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
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>There are no Results on this page...</p>
        <?php } ?>
    <?php } elseif ($tab == "Chapters") { ?>
        <?php if (!empty($userreadchaptersp)) { ?>
            <?php foreach ($userreadchaptersp as $cid) { ?>
                <?php $ch = $conn->query("SELECT * FROM `chapters` WHERE `id`='$cid' LIMIT 1")->fetch_assoc(); ?>
                <?php $tl = $conn->query("SELECT `id`, `title` FROM `titles` WHERE `id`='" . $ch["title_id"] . "' LIMIT 1")->fetch_assoc(); ?>
                <div class="col-span-3 border border-black p-1 grid grid-cols-8 hover:bg-gray-100">
                    <p class="col-span-2 font-bold">
                        <a href="<?= config("url") ?>title/<?= $tl["id"] ?>/<?= cat($tl["title"]) ?>" class="text-blue-700 hover:underline">
                            <?= $tl["title"] ?>
                        </a>
                    </p>
                    <p class="col-span-2 font-bold">
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
        <?php } else { ?>
            <p>There are no Results on this page...</p>
        <?php } ?>
    <?php } ?>
    <hr class="w-full my-1">
    <div class="grid grid-cols-3 gap-2">
        <a class="col-span-1 p-2 w-full text-center border border-black shadow-xl hover:bg-gray-200" href="<?= $page > 1 ?  config("url") . "history?tab=titles&page=" . ($page - 1) : "#/" ?>">Previous</a>
        <a class="col-span-1 p-2 w-full text-center border border-black shadow-xl" href="#/">Page <?= $page ?>/<?= $total ?></a>
        <a class="col-span-1 p-2 w-full text-center border border-black shadow-xl hover:bg-gray-200" href="<?= $page > $total ?  config("url") . "history?tab=titles&page=" . ($page + 1) : "#/" ?>">Next</a>
    </div>
</div>

<script>
    function confirmDelete() {
        let x = confirm("Are you sure you want to delete your complete History from the cloud? This includes Titles AND Chapter! THIS CANNOT BE UNDONE!");
        if (x === true) {
            return true;
        } else {
            return false;
        }
    }
</script>