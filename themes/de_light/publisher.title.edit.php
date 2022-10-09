<div class="col-span-12 text-center">
    <h1 class="text-3xl">Edit Title</h1>
    <h3 class="text-xl">Mistakes were made.</h3>
</div>

<div class="col-span-2"></div>

<div class="col-span-8 grid grid-cols-12 gap-2">
    <?php if ($serror == true) { ?>
        <div id="alert-border-2" class="col-span-12 flex p-4 mb-4 bg-red-100 border-t-4 border-red-500 dark:bg-red-200" role="alert">
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

    <form method="POST" name="editTitle" class="col-span-12 w-full" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="title" class="text-xl pl-5">Title <span class="text-gray-600">(Required)</span></label>
            <input required type="text" minlength="10" maxlength="100" id="title" name="title" class="w-full" placeholder="Title of Comic" value="<?= $title["title"] ?>">
            <p class="text-gray-500 leading-none">This is the Title of the Comic. It needs to be between 10 and 100 Characters. It may contain special Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="cover" class="text-xl pl-5">Cover <span class="text-gray-600">(Don't select for not edit)</span></label>
            <input class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer" id="cover" name="cover" type="file">
            <p class="text-gray-500 leading-none">This is the cover image. Allowed formats: JPG, JPEG, PNG, GIF or WEBP.
            </p>
            <div class="flex">
                <p class="mr-3 mt-5">
                    Current Cover:<br>
                </p>
                <a href="<?= config("url") ?>data/covers/<?= $title["id"] ?>.jpeg" target="_blank" class="p-1 mt-2 border border-black hover:border-gray-500 hover:bg-gray-200 hover:scale-105">
                    <img src="<?= config("url") ?>data/covers/<?= $title["id"] ?>.jpeg" class="w-36" alt="Current Cover">
                </a>
                <p class="ml-3 mt-5 text-gray-500">If it shows the old image after changing,<br>make sure to clear your cache.</p>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="altnames" class="text-xl pl-5">Alternative Names <span class="text-gray-600">(Optional)</span></label>
            <input type="text" minlength="3" maxlength="500" id="altnames" name="alt_names" class="w-full" placeholder="Alt Name, Another One, This is wrong , This is right, You see" value="<?= $title["alt_names"] ?>">
            <p class="text-gray-500 leading-none">Seperate new name by a comma, don't leave a space before the comma, only after one. Maximal 500 Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="authors" class="text-xl pl-5">Author(s) <span class="text-gray-600">(Optional)</span></label>
            <input type="text" minlength="3" maxlength="100" id="authors" name="authors" class="w-full" placeholder="Author, Another Author" value="<?= $title["authors"] ?>">
            <p class="text-gray-500 leading-none">Seperate new Author by a comma, don't leave a space before the comma, only after one. Maximal 100 Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="artists" class="text-xl pl-5">Artist(s) <span class="text-gray-600">(Optional)</span></label>
            <input type="text" minlength="3" maxlength="100" id="artists" name="artists" class="w-full" placeholder="Artist, Another Artist" value="<?= $title["artists"] ?>">
            <p class="text-gray-500 leading-none">Seperate new Artist by a comma, don't leave a space before the comma, only after one. Maximal 100 Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="genres" class="text-xl pl-5">Genre(s) <span class="text-gray-600">(Optional)</span></label>
            <textarea class="w-full" id="genres" name="genres" placeholder="Seinen, Isekai, Ecchi, Whatever"><?= $title["genre"] ?></textarea>
            <p class="text-gray-500 leading-none">Seperate new Genre by a comma, don't leave a space before the comma, only after one.</p>
        </div>
        <div class="form-group mb-3">
            <label for="language" class="text-xl pl-5">Original Language <span class="text-gray-600">(Optional)</span></label>
            <input type="text" minlength="5" maxlength="20" id="language" name="language" class="w-full" placeholder="E.g. Japanese, Korea, English, etc." value="<?= $title["original_language"] ?>">
            <p class="text-gray-500 leading-none">The Original Language of the Comic. It needs to be between 5 and 20 Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="originalwork" class="text-xl pl-5">Original Work Status <span class="text-gray-600">(Optional)</span></label>
            <select class="w-full" id="originalwork" name="original_work">
                <option value="0" <?= $title["original_work"] == 0 ? "selected" : "" ?>>Unknown</option>
                <option value="1" <?= $title["original_work"] == 1 ? "selected" : "" ?>>Publishing</option>
                <option value="2" <?= $title["original_work"] == 2 ? "selected" : "" ?>>Hiatus</option>
                <option value="3" <?= $title["original_work"] == 3 ? "selected" : "" ?>>Completed</option>
                <option value="4" <?= $title["original_work"] == 4 ? "selected" : "" ?>>Canceled</option>
            </select>
            <p class="text-gray-500 leading-none">The Status of the Original Work.</p>
        </div>
        <div class="form-group mb-3">
            <label for="uploadstatus" class="text-xl pl-5"><?= config("title") ?> Upload Status <span class="text-gray-600">(Optional)</span></label>
            <select class="w-full" id="uploadstatus" name="upload_status">
                <option value="0" <?= $title["upload_status"] == 0 ? "selected" : "" ?>>Unknown</option>
                <option value="1" <?= $title["upload_status"] == 1 ? "selected" : "" ?>>Uploading</option>
                <option value="2" <?= $title["upload_status"] == 2 ? "selected" : "" ?>>Paused</option>
                <option value="3" <?= $title["upload_status"] == 3 ? "selected" : "" ?>>Completed</option>
                <option value="4" <?= $title["upload_status"] == 4 ? "selected" : "" ?>>Dropped</option>
            </select>
            <p class="text-gray-500 leading-none">The Upload Status of the Comic on <?= config("title") ?>.</p>
        </div>
        <div class="form-group mb-3">
            <label for="releaseyear" class="text-xl pl-5">Release Year <span class="text-gray-600">(Optional)</span></label>
            <input type="number" id="releaseyear" name="release_year" class="w-full" placeholder="Year of Release" value="<?= $title["release_year"] ?>">
            <p class="text-gray-500 leading-none">The Year when the Comic started to Release first.</p>
        </div>
        <div class="form-group mb-3">
            <label for="completionyear" class="text-xl pl-5">Completion Year <span class="text-gray-600">(Optional)</span></label>
            <input type="number" id="completionyear" name="complete_year" class="w-full" placeholder="Year of Completion" value="<?= $title["complete_year"] ?>">
            <p class="text-gray-500 leading-none">The Year when the Comic was completed releasing.</p>
        </div>
        <div class="form-group mb-3">
            <label for="summary" class="text-xl pl-5">Summary <span class="text-gray-600">(Optional)</span></label>
            <textarea class="w-full" id="summary" name="summary" placeholder="Once upon a time..."><?= $title["summary"] ?></textarea>
            <p class="text-gray-500 leading-none">Summary of the Comic, supports BBCode.</p>
        </div>
        <div class="form-group mb-3">
            <label for="notes" class="text-xl pl-5">Notes <span class="text-gray-600">(Optional)</span></label>
            <textarea class="w-full" id="notes" name="notes" placeholder="Hello, I'm under the water. Can you hear me?"><?= $title["notes"] ?></textarea>
            <p class="text-gray-500 leading-none">Notes, alas what you want to tell other people.</p>
        </div>
        <div class="form-group">
            <input type="submit" name="editTitle" class="p-2 bg-green-500 text-white hover:bg-green-800 w-full shadow-xl border border-black cursor-pointer">
        </div>
    </form>
</div>

<div class="col-span-2"></div>