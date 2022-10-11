<div class="col-span-12 text-center">
    <h1 class="text-3xl">Add new Group</h1>
    <h3 class="text-xl">The friends we made along the way.</h3>
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

    <form method="POST" name="addGroup" class="col-span-12 w-full" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="title" class="text-xl pl-5">Title <span class="text-gray-600">(Required)</span></label>
            <input required type="text" minlength="10" maxlength="100" id="title" name="title" class="w-full" placeholder="Title of Group" value="<?= isset($_POST["title"]) ? clean(mysqli_real_escape_string($conn, $_POST["title"])) : "" ?>">
            <p class="text-gray-500 leading-none">This is the Title of the Group. It needs to be between 10 and 100 Characters. It may contain special Characters.</p>
        </div>
        <div class="form-group mb-3">
            <label for="banner" class="text-xl pl-5">Banner <span class="text-gray-600">(Optional)</span></label>
            <input required class="block w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 cursor-pointer" id="banner" name="banner" type="file">
            <p class="text-gray-500 leading-none">This is the banner image. Allowed formats: JPG, JPEG, PNG, GIF or WEBP.
            </p>
        </div>
        <div class="form-group mb-3">
            <label for="description" class="text-xl pl-5">Description <span class="text-gray-600">(Optional)</span></label>
            <textarea class="w-full" id="description" name="description" placeholder="We are a really cool group...!"><?= isset($_POST["description"]) ? $_POST["description"] : "" ?></textarea>
            <p class="text-gray-500 leading-none">Description of the Group, supports BBCode.</p>
        </div>
        <?php if ($userlevel["mod"] == 1) { ?>
            <div class="form-group mb-3">
                <label for="mod_upload" class="text-xl pl-5">Mod: Upload Permissions <span class="text-gray-600">(Optional)</span></label>
                <input required type="text" id="mod_upload" name="mod_upload" class="w-full" placeholder="Array of User IDs seperated by comma" value="<?= isset($_POST["mod_upload"]) ? clean(mysqli_real_escape_string($conn, $_POST["mod_upload"])) : "" ?>">
                <p class="text-gray-500 leading-none">People who can upload to this. Set to 0 (or blank) to enable for everyone. Seperate User IDs with a comma. Like 1, 2, 3, 48, 69</p>
            </div>
            <div class="form-group mb-3">
                <label for="mod_edit" class="text-xl pl-5">Mod: Edit Permissions <span class="text-gray-600">(Optional)</span></label>
                <input required type="text" id="mod_edit" name="mod_edit" class="w-full" placeholder="Array of User IDs seperated by comma" value="<?= isset($_POST["mod_edit"]) ? clean(mysqli_real_escape_string($conn, $_POST["mod_edit"])) : "" ?>">
                <p class="text-gray-500 leading-none">People who can edit this group. Set to 0 (or blank) to enable for everyone. Seperate User IDs with a comma. Like 1, 2, 3, 48, 69</p>
            </div>
            <div class="form-group mb-3">
                <label for="mod_status" class="text-xl pl-5">Mod: Group Status</label>
                <select class="w-full" id="mod_status" name="mod_status">
                    <option value="1" <?php if (isset($_POST["mod_status"])) {
                                            if ($_POST["mod_status"] == 1) {
                                                echo "selected";
                                            }
                                        } ?>>
                        Pending</option>
                    <option value="2" <?php if (isset($_POST["mod_status"])) {
                                            if ($_POST["mod_status"] == 2) {
                                                echo "selected";
                                            }
                                        } ?>>
                        Approved</option>
                    <option value="3" <?php if (isset($_POST["mod_status"])) {
                                            if ($_POST["mod_status"] == 3) {
                                                echo "selected";
                                            }
                                        } ?>>
                        Deleted</option>
                </select>
                <p class="text-gray-500 leading-none">The availability Status of the group.</p>
            </div>
            <div class="form-group mb-3">
                <label for="mod_owner" class="text-xl pl-5">Mod: Group Owner <span class="text-gray-600">(Optional)</span></label>
                <input required type="text" id="mod_owner" name="mod_owner" class="w-full" placeholder="Singe User ID of user" value="<?= isset($_POST["mod_owner"]) ? clean(mysqli_real_escape_string($conn, $_POST["mod_owner"])) : "" ?>">
                <p class="text-gray-500 leading-none">Single User ID of a user. Leave Blank for your own.</p>
            </div>
            <div class="form-group mb-3">
                <label for="mod_redirect" class="text-xl pl-5">Mod: Redirect to <span class="text-gray-600">(Optional)</span></label>
                <input required type="text" id="mod_redirect" name="mod_redirect" class="w-full" placeholder="Singe Group ID" value="<?= isset($_POST["mod_redirect"]) ? clean(mysqli_real_escape_string($conn, $_POST["mod_redirect"])) : "" ?>">
                <p class="text-gray-500 leading-none">ID of another group. Used to merge duplicate groups. This group will be redirected to that group you filled in.</p>
            </div>
        <?php } ?>
        <div class="form-group">
            <input type="submit" name="addGroup" class="p-2 bg-green-500 text-white hover:bg-green-800 w-full shadow-xl border border-black cursor-pointer">
        </div>
    </form>
</div>

<div class="col-span-2"></div>