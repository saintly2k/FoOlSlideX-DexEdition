</div>

<hr class="my-2">

<div class="container mx-auto mb-8">
    <div>
        <a href="<?= config("url") ?>home" class="hover:underline text-blue-500">Home</a> |
        <a href="<?= config("url") ?>latest" class="hover:underline text-blue-500">Latest</a> |
        <a href="<?= config("url") ?>browse" class="hover:underline text-blue-500">Browse</a> |
        <a href="<?= config("url") ?>search" class="hover:underline text-blue-500">Search</a> |
        <a href="<?= config("url") ?>history" class="hover:underline text-blue-500">History</a> |
        <a href="<?= config("url") ?>settings" class="hover:underline text-blue-500">Settings</a> |
        <a href="<?= config("url") ?>account" class="hover:underline text-blue-500">Account</a>
    </div>
    <div class="text-gray-400 text-sm">
        Copyright &copy; <?= date("Y") != config("site_started") ? config("site_started") . "-" . date("Y") : config("site_started") ?> <a href="<?= config("url") ?>" class="hover:underline text-blue-500"><?= config("title") ?></a>, all rights reserved.
    </div>
    <?php if (config("display_credits") == 1) { ?>
        <div class="text-gray-400 text-sm">
            Proudly powered by <a href="https://github.com/saintly2k/FoOlSlideX-DexEdition" target="_blank" class="hover:underline text-blue-500">FoOlSlideX DexEdition</a>, an open-source project made by the community.
        </div>
    <?php } else { ?>
        <!-- Sadly, the owner(s) of this website decided to hide the credits, so instead of hiding them, it'll only be now shown because this project is licensed under the MIT license :) -->
        <div class="text-gray-400 text-sm hidden">
            Proudly powered by <a href="https://github.com/saintly2k/FoOlSlideX-DexEdition" target="_blank" class="hover:underline text-blue-500">FoOlSlideX DexEdition</a>, an open-source project made by the community.
        </div>
    <?php } ?>
</div>

<script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js" type="text/javascript"></script>

</body>

</html>