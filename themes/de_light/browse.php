<?php

require("../../load.php");

$page = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_currentPage"]));
$orderBy = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_orderBy"]));

if ($orderBy == "name_asc") $order = "ORDER BY `title` ASC";
if ($orderBy == "name_desc") $order = "ORDER BY `title` DESC";
if ($orderBy == "created_asc") $order = "ORDER BY `timestamp` ASC";
if ($orderBy == "created_desc") $order = "ORDER BY `timestamp` DESC";
if ($orderBy == "released_asc") $order = "ORDER BY `release_year` ASC";
if ($orderBy == "released_desc") $order = "ORDER BY `release_year` DESC";
if (!isset($order) || empty($order)) $order = "";

$results_per_page = 36;
$result = $conn->query("SELECT * FROM `{$dbp}titles` $order");
$number_of_result = mysqli_num_rows($result);
$number_of_page = ceil($number_of_result / $results_per_page);
$page_first_result = ($page - 1) * $results_per_page;
$result = $conn->query("SELECT * FROM `{$dbp}titles` $order LIMIT " . $page_first_result . "," . $results_per_page);

?>

<div class="col-span-12">
    <h1 class="text-left text-2xl">Browse Titles - Page <?= $page ?></h1>
    <hr class="w-full my-2">
    <p>
        <b>Order by:</b>
        <a href="<?= config("url") ?>browse?page=1&order=name_asc" class="p-1 text-white <?= $orderBy == "name_asc" ? "bg-green-500 hover:bg-green-800" : "bg-gray-500 hover:bg-gray-800" ?>">Alphabetical &uarr;</a>
        <a href="<?= config("url") ?>browse?page=1&order=name_desc" class="p-1 text-white <?= $orderBy == "name_desc" ? "bg-green-500 hover:bg-green-800" : "bg-gray-500 hover:bg-gray-800" ?>">Alphabetical &darr;</a>
        <a href="<?= config("url") ?>browse?page=1&order=created_asc" class="p-1 text-white <?= $orderBy == "created_asc" ? "bg-green-500 hover:bg-green-800" : "bg-gray-500 hover:bg-gray-800" ?>">Created &uarr;</a>
        <a href="<?= config("url") ?>browse?page=1&order=created_desc" class="p-1 text-white <?= $orderBy == "created_desc" ? "bg-green-500 hover:bg-green-800" : "bg-gray-500 hover:bg-gray-800" ?>">Created &darr;</a>
        <a href="<?= config("url") ?>browse?page=1&order=released_asc" class="p-1 text-white <?= $orderBy == "released_asc" ? "bg-green-500 hover:bg-green-800" : "bg-gray-500 hover:bg-gray-800" ?>">Released &uarr;</a>
        <a href="<?= config("url") ?>browse?page=1&order=released_desc" class="p-1 text-white <?= $orderBy == "released_desc" ? "bg-green-500 hover:bg-green-800" : "bg-gray-500 hover:bg-gray-800" ?>">Released &darr;</a>
    </p>
    <hr class="w-full my-2">
    <div class="w-full grid grid-cols-3 gap-2">
        <?php foreach ($result as $title) { ?>
            <?php $genre = explode(", ", $title["genre"]); ?>
            <?php $lc = getLastChData($title["id"]); ?>
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
                    <?php if (!empty($lc["chapter"]["id"])) { ?>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="col-span-1 text-left">
                                <a href="<?= config("url") ?>chapter/<?= $lc["chapter"]["id"] ?>" class="text-blue-500 hover:underline"><?= chTtile("home", $lc["chapter"]["volume"], $lc["chapter"]["chapter"], $lc["chapter"]["name"], $lc["chapter"]["short"], $lc["chapter"]["title"]) ?></a>
                            </div>
                            <div class="col-span-1 text-right flex justify-end items-right">
                                <a href="<?= config("url") ?>user/<?= $lc["user"]["id"] ?>/<?= cat($lc["user"]["name"], "username") ?>">
                                    <img src="<?= config("url") ?>data/user/<?= $lc["user"]["id"] ?>.png" class="w-6 rounded-full" title="<?= $lc["user"]["name"] ?>'s Avatar" alt="Avatar">
                                </a>
                            </div>
                            <div class="col-span-1 text-center just">
                                <?= timeAgo($lc["chapter"]["time"]) ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <hr class="w-full my-2">
    <div class="w-full text-center">
        <p>
            <?php for ($pagex = 1; $pagex <= $number_of_page; $pagex++) { ?>
                <a href="<?= config("url") ?>browse?page=<?= $pagex ?>&order=<?= $orderBy ?>" class="p-2 text-white <?= $pagex == $page ? "bg-green-500 hover:bg-green-800" : "bg-gray-500 hover:bg-gray-800" ?>"><?= $pagex ?></a>
            <?php } ?>
        </p>
    </div>
</div>