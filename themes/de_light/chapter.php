<script>
    $("title").html("Read <?= $ptit ?> (<?= $title["title"] ?>) - <?= config("title") ?>");
</script>

<div class="col-span-1"></div>

<div class="col-span-10">
    <h1 class="text-3xl"><a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="text-blue-500 hover:underline"><?= $title["title"] ?></a></h1>
    <h2 class="text-2xl flex">
        <?= $ptitf ?>
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
</div>

<div class="col-span-1"></div>

<?php if ($readingmode == "singlePage") { ?>
    <a href="<?= config("url") ?>chapter/<?= $chapter["id"] ?>/<?= $prev_img ?>" class="col-span-3"></a>
<?php } else { ?>
    <div class="col-span-3" onclick="scrollPx(800);"></div>
<?php } ?>

<div class="col-span-6">
    <?php if ($readingmode == "allPages") { ?>
        <?php foreach ($images as $i) { ?>
            <?php $i = substr($i, 3); ?>
            <?php $c = 1; ?>
            <img src="<?= config("url") . $i ?>" id="img-<?= $c ?>" onclick="scrollTo('img-4', 200);" alt="Image" class="w-full cursor-pointer" data-drawer-target="chapterdrawer" data-drawer-toggle="chapterdrawer" data-drawer-placement="right" aria-controls="chapterdrawer" data-drawer-body-scrolling="true" data-drawer-backdrop="false">
            <?php $c++; ?>
        <?php } ?>
    <?php } elseif ($readingmode == "singlePage") { ?>
        <img src="<?= config("url") . "data/chapters/" . $chapter["data_path"] . "/" . $imgind[$page]["name"] . "." . $imgind[$page]["ext"] ?>" alt="Image" class="w-full cursor-pointer" data-drawer-target="chapterdrawer" data-drawer-toggle="chapterdrawer" data-drawer-placement="right" aria-controls="chapterdrawer" data-drawer-body-scrolling="true" data-drawer-backdrop="false">
    <?php } ?>
</div>

<div id="chapterdrawer" class="fixed z-40 h-screen p-4 w-80 overflow-y-auto bg-white grid grid-cols-12 gap-1 border-l border-black" tabindex="-1" aria-labelledby="chapterdrawer">
    <div class="col-span-3">
        <button type="button" data-drawer-dismiss="chapterdrawer" aria-controls="chapterdrawer" class="text-gray-400 bg-gray-200 hover:bg-gray-400 p-2 hover:text-gray-900">
            <svg aria-hidden="true" class="w-full h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
    </div>
    <div class="col-span-9 p-2 text-center">
        <h5 id="drawer-right-label" class="text-base font-semibold text-gray-500">
            Navigation
        </h5>
    </div>
    <div class="col-span-12 grid grid-cols-12 gap-1 h-5">
        <p class="col-span-12"><b>Title:</b> <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="text-blue-500 hover:underline"><?= $title["title"] ?></a></p>
        <p class="col-span-12"><b>Chapter:</b> <?= $ptitf ?></p>
        <?php if ($readingmode == "allPages") { ?>
            <select onchange="j = document.getElementById('pageSelect22'); Cookies.set('<?= config("cookie") ?>_readingMode', j.value); location.href = '<?= config("url") ?>chapter/<?= $chapter["id"] ?>';" class="col-span-12" id="pageSelect22">
                <option value="allPages" selected>All Pages</option>
                <option value="singlePage">Single Page</option>
            </select>
        <?php } else { ?>
            <select onchange="n = document.getElementById('pageSelect56'); Cookies.set('<?= config("cookie") ?>_readingMode', n.value); location.href = '<?= config("url") ?>chapter/<?= $chapter["id"] ?>';" class="col-span-8" id="pageSelect56">
                <option value="allPages">All Pages</option>
                <option value="singlePage" selected>Single Page</option>
            </select>
            <select onchange="this.options[this.selectedIndex].value&&window.open('<?= config("url") ?>chapter/<?= $chapter["id"] ?>/' + this.options[this.selectedIndex].value,'_self')" class="col-span-4">
                <?php foreach ($imgind as $i) { ?>
                    <option value="<?= $i["order"] ?>" <?= $i["order"] == $page ? "selected" : "" ?>><?= $i["name"] ?></option>
                <?php } ?>
            </select>
        <?php } ?>
        <?php if (!empty($prev_page["id"])) { ?>
            <a class="col-span-2 py-2 text-center border border-black hover:bg-gray-200" href="<?= config("url") ?>chapter/<?= $prev_page["id"] ?>">
                Prev
            </a>
        <?php } else { ?>
            <a class="col-span-2 py-2 text-center border border-black hover:bg-gray-200" href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>">
                Title
            </a>
        <?php } ?>
        <select onchange="z = document.getElementById('chSelect44'); location.href = '<?= config("url") ?>chapter/' + z.value + '/1';" class="col-span-8" id="chSelect44">
            <?php foreach ($chapters as $cha) { ?>
                <option value="<?= $cha["id"] ?>" <?= $chapter["id"] == $cha["id"] ? "selected" : "" ?>><?= chTtile("home", $cha["volume"], $cha["chapter"], $cha["release_name"], $cha["release_short"], $cha["title"]) ?></option>
            <?php } ?>
        </select>
        <?php if (!empty($next_page["id"])) { ?>
            <a class="col-span-2 py-2 text-center border border-black hover:bg-gray-200" href="<?= config("url") ?>chapter/<?= $next_page["id"] ?>">
                Next
            </a>
        <?php } else { ?>
            <a class="col-span-2 py-2 text-center border border-black hover:bg-gray-200" href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>">
                Title
            </a>
        <?php } ?>
    </div>
</div>

<?php if ($readingmode == "singlePage") { ?>
    <a href="<?= config("url") ?>chapter/<?= $chapter["id"] ?>/<?= $next_img ?>" class="col-span-3"></a>
<?php } else { ?>
    <div class="col-span-3" onclick="scrollPx(800);"></div>
<?php } ?>

<div class="col-span-1"></div>

<div class="col-span-10">
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

<div class="col-span-1"></div>

<script>
    function scrollPx(px) {
        var y = $(window).scrollTop();
        $("html, body").animate({
            scrollTop: y + px
        }, 600);
    }
</script>