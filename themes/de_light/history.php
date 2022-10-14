<?php

require("../../load.php");

$tab = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_historyTab"]));
$page = clean(mysqli_real_escape_string($conn, $_COOKIE[config("cookie") . "_currentPage"]));

?>

<div class="col-span-12">
    <h1 class="text-2xl">History - <?= $tab ?> - Page <?= $page ?></h1>
    <hr class="w-full mb-1">
    <div class="w-full grid grid-cols-2 gap-2">
        <a href="<?= config("url") ?>history?tab=titles&page=1" class="p-2 col-span-1 w-full text-center shadow-xl border border-black <?= $tab=="Titles" ? "bg-green-500 text-white hover:bg-green-800" : "bg-gray-200 hover:bg-gray-400" ?>">Titles</a>
        <a href="<?= config("url") ?>history?tab=chapters&page=1" class="p-2 col-span-1 w-full text-center shadow-xl border border-black <?= $tab=="Chapters" ? "bg-green-500 text-white hover:bg-green-800" : "bg-gray-200 hover:bg-gray-400" ?>">Chapters</a>
    </div>
    <hr class="w-full my-1">
</div>