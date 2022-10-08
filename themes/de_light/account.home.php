<?php

if ($tab == "sessions") $sessions = $conn->query("SELECT * FROM `sessions` WHERE `user`='" . $user["id"] . "' ORDER BY `id` DESC");

?>

<div class="col-span-12 grid grid-cols-11 gap-2">
    <div class="col-span-4"></div>

    <div class="col-span-3">
        <h1 class="text-center text-3xl">My Account</h1>
        <hr class="my-2">
        <img src="<?= config("url") ?>data/user/<?= $user["id"] . "." . $user["avatar"] ?>" class="shadow-xl w-1/2 mx-auto mb-3 rounded-full" alt="Avatar">
        <ul class="flex flex-wrap text-sm text-center text-gray-500 border-gray-200 grid grid-cols-6 mb-2">
            <li class="w-full">
                <a href="<?= config("url") ?>account/home" class="inline-block p-2 <?= $tab == "home" ? "text-blue-600 bg-gray-100 border-b border-gray-100" : "hover:text-gray-600 hover:bg-gray-50 border-b" ?> hover:underline w-full">Home</a>
            </li>
            <li class="w-full">
                <a href="<?= config("url") ?>account/profile" class="inline-block p-2 <?= $tab == "profile" ? "text-blue-600 bg-gray-100 border-b border-gray-100" : "hover:text-gray-600 hover:bg-gray-50 border-b" ?> hover:underline w-full">Profile</a>
            </li>
            <li class="w-full">
                <a href="<?= config("url") ?>account/avatar" class="inline-block p-2 <?= $tab == "avatar" ? "text-blue-600 bg-gray-100 border-b border-gray-100" : "hover:text-gray-600 hover:bg-gray-50 border-b" ?> hover:underline w-full">Avatar</a>
            </li>
            <li class="w-full">
                <a href="<?= config("url") ?>account/email" class="inline-block p-2 <?= $tab == "email" ? "text-blue-600 bg-gray-100 border-b border-gray-100" : "hover:text-gray-600 hover:bg-gray-50 border-b" ?> hover:underline w-full">Email</a>
            </li>
            <li class="w-full">
                <a href="<?= config("url") ?>account/password" class="inline-block p-2 <?= $tab == "password" ? "text-blue-600 bg-gray-100 border-b border-gray-100" : "hover:text-gray-600 hover:bg-gray-50 border-b" ?> hover:underline w-full">Pass</a>
            </li>
            <li class="w-full">
                <a href="<?= config("url") ?>account/sessions" class="inline-block p-2 <?= $tab == "sessions" ? "text-blue-600 bg-gray-100 border-b border-gray-100" : "hover:text-gray-600 hover:bg-gray-50 border-b" ?> hover:underline w-full">Sessions</a>
            </li>
        </ul>
        <div class="grid grid-cols-4 gap-2">
            <?php if ($tab == "home") { ?>
                <a href="<?= config("url") ?>user/<?= $user["id"] ?>/<?= cat($user["username"]) ?>" class="col-span-4 p-2 bg-blue-500 text-white text-center font-bold hover:underline hover:bg-blue-800 border border-black w-full shadow-xl">View Profile</a>
                <a href="<?= config("url") ?>" class="col-span-4 p-2 bg-blue-500 text-white text-center font-bold hover:underline hover:bg-blue-800 border border-black w-full shadow-xl">Return to <?= config("title") ?></a>
                <hr class="col-span-4 my-2">
                <a href="<?= config("url") ?>account/logout" class="col-span-4 p-2 bg-red-500 text-white text-center font-bold hover:underline hover:bg-red-800 border border-black w-full shadow-xl">Logout</a>
            <?php } ?>
            <?php if ($tab == "profile") { ?>
                <?php if ($serror == true) { ?>
                    <div id="alert-border-2" class="col-span-4 flex p-4 bg-red-100 border-t-4 border-red-500" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3 text-sm font-medium text-red-700">
                            <?= $return ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#alert-border-2" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                <?php } ?>
                <form method="POST" id="epform" name="editProfile" class="col-span-4 grid grid-cols-4 gap-2">
                    <label for="user_id" class="text-right pt-2.5">User ID</label>
                    <div class="col-span-3">
                        <input required type="number" name="user_id" id="user_id" class="w-full" readonly value="<?= $user["id"] ?>" title="Your User ID">
                        <p class="text-sm text-gray-500">This is your User ID.</p>
                    </div>
                    <label for="username" class="text-right pt-2.5">Username</label>
                    <div class="col-span-3">
                        <input required type="text" name="username" id="username" class="w-full" value="<?= $user["username"] ?>" title="Your Username">
                        <p class="leading-none text-sm text-gray-500">This is your Username, it should be between <span class="text-black font-bold">5</span> and <span class="text-black font-bold">50</span> characters and may only contain <span class="text-black font-bold">letters</span>, <span class="text-black font-bold">numbers</span>, <span class="text-black font-bold">dashes</span> and <span class="text-black font-bold">underscores</span>. Your name is public and changing it won't have any effects on links to your account.</p>
                    </div>
                    <label for="public" class="text-right pt-2.5">Visibility</label>
                    <div class="col-span-3">
                        <select required name="public" id="public" class="w-full" title="Your Account Visibility">
                            <option value="1" <?= $user["public"] == 1 ? "selected" : "" ?>>Public</option>
                            <option value="0" <?= $user["public"] == 0 ? "selected" : "" ?>>Private</option>
                        </select>
                        <p class="text-sm text-gray-500">Your Account visibility for others.</p>
                    </div>
                    <label for="gender" class="text-right pt-2.5">Gender</label>
                    <div class="col-span-3">
                        <select required name="gender" id="gender" class="w-full" title="Your Gender">
                            <option value="0" <?= $user["gender"] == 0 ? "selected" : "" ?>>Secret</option>
                            <option value="1" <?= $user["gender"] == 1 ? "selected" : "" ?>>Male</option>
                            <option value="2" <?= $user["gender"] == 2 ? "selected" : "" ?>>Female</option>
                            <option value="3" <?= $user["gender"] == 3 ? "selected" : "" ?>>Non-binary</option>
                            <option value="4" <?= $user["gender"] == 4 ? "selected" : "" ?>>Unicorn</option>
                        </select>
                        <p class="text-sm text-gray-500">This is your gender.</p>
                    </div>
                    <label for="biography" class="col-span-4 text-center">Biography</label>
                    <div class="col-span-4">
                        <textarea id="biography" name="biography" class="w-full" placeholder="Write something about you..."><?= $user["biography"] ?></textarea>
                        <p class="text-sm text-gray-500">This is about you. Supports BBCode.</p>
                    </div>
                    <input type="submit" name="editProfile" class="col-span-4 p-2 border border-black bg-green-500 hover:bg-green-800 text-white cursor-pointer shadow-xl">
                </form>
            <?php } ?>
            <?php if ($tab == "avatar") { ?>
                <div class="shadow-xl col-span-4 flex p-4 text-sm text-red-700 bg-red-100" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-bold">Error!</span> This is still in work!
                    </div>
                </div>
            <?php } ?>
            <?php if ($tab == "email") { ?>
                <div class="shadow-xl col-span-4 flex p-4 text-sm text-red-700 bg-red-100" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-bold">Error!</span> This is still in work!
                    </div>
                </div>
            <?php } ?>
            <?php if ($tab == "password") { ?>
                <div class="shadow-xl col-span-4 flex p-4 text-sm text-blue-700 bg-blue-100" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-bold">Info!</span> After changing, all sessions will be destroyed!
                    </div>
                </div>
                <?php if ($serror == true) { ?>
                    <div id="alert-border-2" class="shadow-xl col-span-4 flex p-4 bg-red-100 border-t-4 border-red-500" role="alert">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3 text-sm font-medium text-red-700">
                            <?= $return ?>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" data-dismiss-target="#alert-border-2" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                <?php } ?>
                <div class="col-span-4">
                    <form method="POST" name="editPassword" class="grid grid-cols-4 gap-2 w-full">
                        <div class="col-span-4">
                            <input required type="password" name="password_old" minlength="8" maxlength="200" placeholder="Old Password" class="w-full" title="Old Password">
                            <p class="text-sm text-gray-500">Your old Password. Between 8 and 200 characters.</p>
                        </div>
                        <div class="col-span-4">
                            <input required type="password" name="password_new1" minlength="8" maxlength="200" placeholder="New Password" class="w-full" title="New Password">
                            <p class="text-sm text-gray-500">Your new Password. Between 8 and 200 characters.</p>
                        </div>
                        <div class="col-span-4">
                            <input required type="password" name="password_new2" minlength="8" maxlength="200" placeholder="Repeat New Password" class="w-full" title="Repeat New Password">
                            <p class="text-sm text-gray-500">Repeat your new Password. Between 8 and 200 characters.</p>
                        </div>
                        <input type="submit" name="editPassword" class="col-span-4 p-2 border border-black bg-green-500 hover:bg-green-800 text-white cursor-pointer shadow-xl">
                    </form>
                </div>
            <?php } ?>
            <?php if ($tab == "sessions") { ?>
                <div class="shadow-xl col-span-4 flex p-4 text-sm text-blue-700 bg-blue-100" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-bold">Info!</span> Destroying your current session will log you out!
                    </div>
                </div>
                <div class="col-span-4 grid grid-cols-4 gap-2">
                    <?php foreach ($sessions as $session) { ?>
                        <button class="col-span-4 block w-full md:w-auto text-white border border-black bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 shadow-xl" type="button" data-modal-toggle="session_<?= $session["id"] ?>">
                            <span class="font-bold"><?= $session["browser"] ?></span> on <span class="font-bold"><?= formatDate($session["timestamp"]) ?></span>
                        </button>
                        <div id="session_<?= $session["id"] ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative bg-white shadow">
                                    <!-- Modal header -->
                                    <div class="flex justify-between items-center p-5 border-b">
                                        <h3 class="text-xl font-medium text-gray-900">
                                            Info on Session <span class="font-bold"><?= formatDate($session["timestamp"]) ?></span>
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="session_<?= $session["id"] ?>">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-6">
                                        <?php if ($session["token"] == $_COOKIE[config("cookie") . "_session"]) { ?>
                                            <div class="shadow-xl flex p-4 mb-4 text-sm text-blue-700 bg-blue-100" role="alert">
                                                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Info</span>
                                                <div>
                                                    <span class="font-bold">Info!</span> This is your current session!
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <p><b>Token:</b> <?= asteristk($session["token"], 20) ?></p>
                                        <p><b>Browser:</b> <?= $session["browser"] ?></p>
                                        <p><b>Details:</b> <?= $session["browser_details"] ?></p>
                                        <p><b>IP:</b> <?= asteristk($session["ip"]) ?></p>
                                        <p><b>Date:</b> <?= formatDate($session["timestamp"]) ?></p>
                                        <p><b>Timestamp:</b> <?= $session["timestamp"] ?></p>
                                    </div>
                                    <!-- Modal footer -->
                                    <form method="POST" name="deleteSession" class="flex items-center p-6 space-x-2 border-t border-gray-200">
                                        <input type="number" name="sid" value="<?= $session["id"] ?>" readonly class="hidden">
                                        <button data-modal-toggle="session_<?= $session["id"] ?>" type="button" class="shadow-xl text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm px-5 py-2.5 text-center">Close</button>
                                        <button type="submit" name="deleteSession" class="shadow-xl text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-200 text-sm font-medium px-5 py-2.5 focus:z-10">Destroy Session</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="col-span-4"></div>
</div>