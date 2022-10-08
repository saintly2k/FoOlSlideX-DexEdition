<div class="col-span-12 text-center">
    <h1 class="text-3xl">Publisher's Home</h1>
    <h1 class="text-xl">What do you want to do?</h1>
</div>

<hr class="col-span-12 my-2">

<div class="col-span-3 bg-white border border-gray-200 shadow-xl w-full hover:bg-gray-200 cursor-normal hover:scale-105">
    <a href="<?= config("url") ?>publisher/my/titles">
        <img class="w-full" src="<?= config("url") ?>data/assets/img/mytitles.jpg" alt="My Titles">
    </a>
    <div class="p-5 text-center">
        <a href="<?= config("url") ?>publisher/my/titles" class="hover:underline">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">View my Titles</h5>
        </a>
    </div>
</div>

<div class="col-span-3 bg-white border border-gray-200 shadow-xl w-full hover:bg-gray-200 cursor-normal hover:scale-105">
    <a href="<?= config("url") ?>publisher/my/groups">
        <img class="w-full" src="<?= config("url") ?>data/assets/img/mygroups.jpg" alt="My Titles">
    </a>
    <div class="p-5 text-center">
        <a href="<?= config("url") ?>publisher/my/groups" class="hover:underline">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">View my Groups</h5>
        </a>
    </div>
</div>

<div class="col-span-3 bg-white border border-gray-200 shadow-xl w-full hover:bg-gray-200 cursor-normal hover:scale-105">
    <a href="<?= config("url") ?>publisher/new/title">
        <img class="w-full" src="<?= config("url") ?>data/assets/img/newtitle.jpg" alt="My Titles">
    </a>
    <div class="p-5 text-center">
        <a href="<?= config("url") ?>publisher/new/title" class="hover:underline">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Create new Title</h5>
        </a>
    </div>
</div>

<div class="col-span-3 bg-white border border-gray-200 shadow-xl w-full hover:bg-gray-200 cursor-normal hover:scale-105">
    <a href="<?= config("url") ?>publisher/new/group">
        <img class="w-full" src="<?= config("url") ?>data/assets/img/newgroup.jpg" alt="My Titles">
    </a>
    <div class="p-5 text-center">
        <a href="<?= config("url") ?>publisher/new/group" class="hover:underline">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Create new Group</h5>
        </a>
    </div>
</div>