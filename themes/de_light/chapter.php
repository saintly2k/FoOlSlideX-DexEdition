<script>
    $("title").html("Read <?= $ptit ?> (<?= $title["title"] ?>) - <?= config("title") ?>");
</script>

<div class="col-span-3"></div>

<div class="col-span-6">
    <h1 class="text-3xl"><a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="text-blue-500 hover:underline"><?= $title["title"] ?></a></h1>
    <h2 class="text-2xl flex">
        <?= $ptit ?>
        <form method="POST" class="ml-3">
            <?php if (!isset($_POST["markUnread"]) || isset($_POST["markRead"])) { ?>
                <button name="markUnread" type="submit" class="text-blue-500 hover:underline">(Mark Unread)</button>
            <?php } else { ?>
                <button name="markRead" type="submit" class="text-blue-500 hover:underline">(Mark Read)</button>
            <?php } ?>
        </form>
    </h2>
    <hr class="w-full mb-2">
    <div class="w-full grid grid-cols-9 gap-2">
        <?php if ($readingmode == "allPages") { ?>
            <select onchange="c = document.getElementById('chSelect'); location.href = '<?= config("url") ?>chapter/' + c.value;" class="col-span-3" id="chSelect">
                <?php foreach ($chapters as $ch) { ?>
                    <option value="<?= $ch["id"] ?>" <?= $chapter["id"] == $ch["id"] ? "selected" : "" ?>><?= chTtile("home", $ch["volume"], $ch["chapter"], $ch["release_name"], $ch["release_short"], $ch["title"]) ?></option>
                <?php } ?>
            </select>
            <select onchange="s = document.getElementById('pageSelect'); Cookies.set('<?= config("cookie") ?>_readingMode', s.value); location.href = '<?= config("url") ?>chapter/<?= $chapter["id"] ?>/1';" class="col-span-2" id="pageSelect">
                <option value="allPages" selected>All Pages</option>
                <option value="singlePage">Single Page</option>
            </select>
            <?php if (!empty($prev_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $prev_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Previous</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
            <?php if (!empty($next_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $next_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Next</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
        <?php } elseif ($readingmode == "singlePage") { ?>
            <select onchange="c = document.getElementById('chSelect'); location.href = '<?= config("url") ?>chapter/' + c.value + '/1';" class="col-span-2" id="chSelect">
                <?php foreach ($chapters as $ch) { ?>
                    <option value="<?= $ch["id"] ?>" <?= $chapter["id"] == $ch["id"] ? "selected" : "" ?>><?= chTtile("home", $ch["volume"], $ch["chapter"], $ch["release_name"], $ch["release_short"], $ch["title"]) ?></option>
                <?php } ?>
            </select>
            <select onchange="s = document.getElementById('pageSelect'); Cookies.set('<?= config("cookie") ?>_readingMode', s.value); location.href = '<?= config("url") ?>chapter/<?= $chapter["id"] ?>';" class="col-span-2" id="pageSelect">
                <option value="allPages">All Pages</option>
                <option value="singlePage" selected>Single Page</option>
            </select>
            <select onchange="this.options[this.selectedIndex].value&&window.open('<?= config("url") ?>chapter/<?= $chapter["id"] ?>/' + this.options[this.selectedIndex].value,'_self')" class="col-span-1">
                <?php foreach ($imgind as $i) { ?>
                    <option value="<?= $i["order"] ?>" <?= $i["order"] == $page ? "selected" : "" ?>><?= $i["name"] ?></option>
                <?php } ?>
            </select>
            <?php if (!empty($prev_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $prev_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Previous</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
            <?php if (!empty($next_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $next_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Next</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
        <?php } ?>
    </div>
    <hr class="w-full my-2">

    <?php if ($readingmode == "allPages") { ?>
        <?php foreach ($images as $i) { ?>
            <?php $i = substr($i, 3); ?>
            <img src="<?= config("url") . $i ?>" alt="Image" class="w-full" onclick="scrollPx(800);">
        <?php } ?>
    <?php } elseif ($readingmode == "singlePage") { ?>
        <a href="<?= config("url") ?>chapter/<?= $chapter["id"] ?>/<?= $next_img ?>">
            <img src="<?= config("url") . "data/chapters/" . $chapter["data_path"] . "/" . $imgind[$page]["name"] . "." . $imgind[$page]["ext"] ?>" alt="Image" class="w-full">
        </a>
    <?php } ?>

    <hr class="w-full my-2">
    <div class="w-full grid grid-cols-9 gap-2">
        <?php if ($readingmode == "allPages") { ?>
            <select onchange="q = document.getElementById('chSelect2'); location.href = '<?= config("url") ?>chapter/' + q.value + '/1';" class="col-span-3" id="chSelect2">
                <?php foreach ($chapters as $ch) { ?>
                    <option value="<?= $ch["id"] ?>" <?= $chapter["id"] == $ch["id"] ? "selected" : "" ?>><?= chTtile("home", $ch["volume"], $ch["chapter"], $ch["release_name"], $ch["release_short"], $ch["title"]) ?></option>
                <?php } ?>
            </select>
            <select onchange="a = document.getElementById('pageSelect2'); Cookies.set('<?= config("cookie") ?>_readingMode', a.value); location.href = '<?= config("url") ?>chapter/<?= $chapter["id"] ?>/1';" class="col-span-2" id="pageSelect2">
                <option value="allPages" selected>All Pages</option>
                <option value="singlePage">Single Page</option>
            </select>
            <?php if (!empty($prev_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $prev_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Previous</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
            <?php if (!empty($next_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $next_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Next</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
        <?php } elseif ($readingmode == "singlePage") { ?>
            <select onchange="q = document.getElementById('chSelect2'); location.href = '<?= config("url") ?>chapter/' + q.value + '/1';" class="col-span-2" id="chSelect2">
                <?php foreach ($chapters as $ch) { ?>
                    <option value="<?= $ch["id"] ?>" <?= $chapter["id"] == $ch["id"] ? "selected" : "" ?>><?= chTtile("home", $ch["volume"], $ch["chapter"], $ch["release_name"], $ch["release_short"], $ch["title"]) ?></option>
                <?php } ?>
            </select>
            <select onchange="a = document.getElementById('pageSelect2'); Cookies.set('<?= config("cookie") ?>_readingMode', a.value); location.href = '<?= config("url") ?>chapter/<?= $chapter["id"] ?>';" class="col-span-2" id="pageSelect2">
                <option value="allPages">All Pages</option>
                <option value="singlePage" selected>Single Page</option>
            </select>
            <select onchange="this.options[this.selectedIndex].value&&window.open('<?= config("url") ?>chapter/<?= $chapter["id"] ?>/' + this.options[this.selectedIndex].value,'_self')" class="col-span-1">
                <?php foreach ($imgind as $i) { ?>
                    <option value="<?= $i["order"] ?>" <?= $i["order"] == $page ? "selected" : "" ?>><?= $i["name"] ?></option>
                <?php } ?>
            </select>
            <?php if (!empty($prev_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $prev_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Previous</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
            <?php if (!empty($next_page["id"])) { ?>
                <a href="<?= config("url") ?>chapter/<?= $next_page["id"] ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Next</a>
            <?php } else { ?>
                <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="col-span-2 p-2 border border-black text-center hover:bg-gray-200">Title</a>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<div class="col-span-3"></div>

<script>
    function scrollPx(px) {
        var y = $(window).scrollTop();
        $("html, body").animate({
            scrollTop: y + px
        }, 600);
    }
</script>