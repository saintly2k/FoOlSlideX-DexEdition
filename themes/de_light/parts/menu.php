</head>

<body onload="loadContent();">
    <nav class="bg-slate-700 border-gray-200 px-2 sm:px-4 py-2.5 text-white mb-3">
        <div class="container flex flex-wrap justify-between items-center mx-auto">
            <a href="<?= config("url") ?>" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap"><?= config("title") ?></span>
            </a>
            <div class="flex md:order-2">
                <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="md:hidden text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 rounded-lg text-sm p-2.5 mr-1">
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only"><?= $lang["search"] ?></span>
                </button>
                <div class="hidden relative md:block">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only"><?= $lang["search_icon"] ?></span>
                    </div>
                    <input type="text" id="search-navbar" class="block p-2 pl-10 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="<?= $lang["search"] ?>...">
                </div>
                <button data-collapse-toggle="navbar-search" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-search" aria-expanded="false">
                    <span class="sr-only"><?= $lang["open_menu"] ?></span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="navbar-search">
                <div class="relative mt-3 md:hidden">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="search-navbar" class="block p-2 pl-10 w-full text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Search...">
                </div>
                <ul class="flex flex-col p-4 mt-4 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0">
                    <li>
                        <a href="<?= config("url") ?>home" class="block py-2 pr-4 pl-3 font-bold rounded md:hover:bg-transparent md:hover:underline md:p-0"><?= $lang["home"] ?></a>
                    </li>
                    <li>
                        <a href="<?= config("url") ?>latest" class="block py-2 pr-4 pl-3 font-bold rounded md:hover:bg-transparent md:hover:underline md:p-0"><?= $lang["latest"] ?></a>
                    </li>
                    <li>
                        <a href="<?= config("url") ?>browse" class="block py-2 pr-4 pl-3 font-bold rounded md:hover:bg-transparent md:hover:underline md:p-0"><?= $lang["browse"] ?></a>
                    </li>
                    <li>
                        <a href="<?= config("url") ?>search" class="block py-2 pr-4 pl-3 font-bold rounded md:hover:bg-transparent md:hover:underline md:p-0"><?= $lang["search"] ?></a>
                    </li>
                    <li>
                        <a href="<?= config("url") ?>history" class="block py-2 pr-4 pl-3 font-bold rounded md:hover:bg-transparent md:hover:underline md:p-0"><?= $lang["history"] ?></a>
                    </li>
                    <li>
                        <a href="<?= config("url") ?>settings" class="block py-2 pr-4 pl-3 font-bold rounded md:hover:bg-transparent md:hover:underline md:p-0"><?= $lang["settings"] ?></a>
                    </li>
                    <li>
                        <a href="<?= config("url") ?>account" class="block py-2 pr-4 pl-3 font-bold rounded md:hover:bg-transparent md:hover:underline md:p-0"><?= $lang["account"] ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="content" class="container mx-auto grid grid-cols-12 gap-2">