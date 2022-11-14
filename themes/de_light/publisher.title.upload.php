<div class="col-span-12">
    <h1 class="text-3xl text-center">Add a Chapter</h1>
    <h3 class="text-xl text-center">For Title: <a href="<?= config("url") ?>title/<?= $title["id"] ?>/<?= cat($title["title"]) ?>" class="text-blue-500 hover:underline" target="_blank"><?= $title["title"] ?></a></h3>
</div>

<div class="col-span-2"></div>

<div class="col-span-8">
    <div class="block space-y-4 md:flex md:space-y-0 md:space-x-4">
        <button class="block w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center" type="button" data-modal-toggle="large-modal">
            New to <?= config("title") ?>? Read the Upload- & Naming-Guidelines!
        </button>
    </div>
    <!-- Large Modal -->
    <div id="large-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-4xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white shadow">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-5 border-b">
                    <h3 class="text-xl font-medium text-gray-900">
                        Upload- & Naming-Guidelines
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="large-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6">
                    <?php include("custom/guidelines.html"); ?>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200">
                    <button data-modal-toggle="large-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center w-full">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php if ($serror == true) { ?>
        <div id="alert-border-2" class="col-span-12 flex p-4 mb-4 mt-4 bg-red-100 border-t-4 border-red-500 dark:bg-red-200" role="alert">
            <svg class="flex-shrink-0 w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="ml-3 text-sm font-medium text-red-700">
                <b>Error!</b> <?= $return ?>
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 dark:bg-red-200 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 dark:hover:bg-red-300 inline-flex h-8 w-8" data-dismiss-target="#alert-border-2" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    <?php } ?>

    <form method="POST" name="addChapter" class="col-span-12 w-full" enctype="multipart/form-data">
        <label for="dropzone-file" class="text-xl pl-5">Archive <span class="text-gray-600">(Required)</span></label>
        <div class="flex justify-center items-center w-full">
            <label for="dropzone-file" class="flex flex-col justify-center items-center w-full h-30 bg-gray-50 border-2 border-gray-300 border-dashed cursor-pointer">
                <div class="flex flex-col justify-center items-center pt-5 pb-6">
                    <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500">ZIP only (Max. <?= ini_get("upload_max_filesize"); ?>B)</p>
                </div>
                <input id="dropzone-file" type="file" class="hidden" name="archive">
            </label>
        </div>

        <div class="form-group mb-3">
            <label for="chapter_number" class="text-xl pl-5">Chapter Number <span class="text-gray-600">(Required)</span></label>
            <input required type="number" step=".01" id="chapter_number" name="chapter_number" class="w-full" placeholder="Chapter Number" value="<?= isset($_POST["chapter_number"]) ? clean(mysqli_real_escape_string($conn, $_POST["chapter_number"])) + 1 : $add["chapter_number"] ?>">
            <p class="text-gray-500 leading-none">This is the chapter number. It can be a decimal.</p>
        </div>
        <div class="form-group mb-3">
            <label for="volume_number" class="text-xl pl-5">Volume Number <span class="text-gray-600">(Optional)</span></label>
            <input type="number" id="volume_number" name="volume_number" class="w-full" placeholder="Volume Number" value="<?= isset($_POST["volume_number"]) ? clean(mysqli_real_escape_string($conn, $_POST["volume_number"])) : $add["volume_number"] ?>">
            <p class="text-gray-500 leading-none">This is the volume number, it will be used for sorting if the order number is left blank.</p>
        </div>
        <div class="form-group mb-3">
            <label for="order_number" class="text-xl pl-5">Order Number <span class="text-gray-600">(Optional)</span></label>
            <input type="number" id="order_number" name="order_number" class="w-full" placeholder="Order Number" value="<?= isset($_POST["order_number"]) ? clean(mysqli_real_escape_string($conn, $_POST["order_number"])) : $add["oder_numer"] ?>">
            <p class="text-gray-500 leading-none">In which order it should be displayed on the Title page. Leave blank to order after chapter numbers. Number only.</p>
        </div>
        <div class="form-group mb-3">
            <label for="release_name" class="text-xl pl-5">Release Name <span class="text-gray-600">(Optional)</span></label>
            <input type="text" id="release_name" minlength="2" maxlength="100" name="release_name" class="w-full" placeholder="Release Name" value="<?= isset($_POST["release_name"]) ? clean(mysqli_real_escape_string($conn, $_POST["release_name"])) : $add["release_name"] ?>">
            <p class="text-gray-500 leading-none">Will be generated automatically if left blank. Overwrites on display Chapter and Volume. Between 2 and 100 Characters</p>
        </div>
        <div class="form-group mb-3">
            <label for="release_short_name" class="text-xl pl-5">Release Short Name <span class="text-gray-600">(Optional)</span></label>
            <input type="text" id="release_short_name" minlength="2" maxlength="15" name="release_short_name" class="w-full" placeholder="Release Short Name" value="<?= isset($_POST["release_short_name"]) ? clean(mysqli_real_escape_string($conn, $_POST["release_short_name"])) : $add["release_short_name"] ?>">
            <p class="text-gray-500 leading-none">Will be generated automatically if left blank. Used for smaller devices such as phones. Between 2 and 15 Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="release_title" class="text-xl pl-5">Release Title <span class="text-gray-600">(Optional)</span></label>
            <input type="text" id="release_title" minlength="2" maxlength="200" name="release_title" class="w-full" placeholder="Release Title" value="<?= isset($_POST["release_title"]) ? clean(mysqli_real_escape_string($conn, $_POST["release_title"])) : $add["release_title"] ?>">
            <p class="text-gray-500 leading-none">This will be displayed after Release Name on the Title page. Needs to be between 2 and 200 Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="groups" class="text-xl pl-5">Groups ID <span class="text-gray-600">(Optional)</span></label>
            <input type="text" id="groups" name="groups" class="w-full" placeholder="Groups ID" value="<?= isset($_POST["groups"]) ? clean(mysqli_real_escape_string($conn, $_POST["groups"])) : $add["groups"] ?>">
            <p class="text-gray-500 leading-none">Seperate Group IDs by comma. Make sure you have enough permissions to post to that group or else you won't post as it.</p>
        </div>
        <div class="flex items-center mb-4">
            <input id="default-checkbox" type="checkbox" <?= isset($_POST["stay"]) ? "checked" : "" ?> name="stay" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
            <label for="default-checkbox" class="ml-2 text-gray-900">Upload another chapter (Stay here, Chapter number +1)</label>
        </div>
        <div class="form-group">
            <input type="submit" name="addChapter" class="p-2 bg-green-500 text-white hover:bg-green-800 w-full shadow-xl border border-black cursor-pointer">
        </div>
    </form>
</div>

<div class="col-span-2"></div>