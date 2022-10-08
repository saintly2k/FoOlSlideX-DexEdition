<?php

require("../load.php");

?>

<div class="col-span-5"></div>

<div class="col-span-2">
    <h1 class="text-center text-3xl">Signup</h1>
    <h3 class="text-center text-xl mb-4">Welcome to the Family!</h3>
    <form method="POST" name="signup" id="signupform">
        <input required type="email" name="email" placeholder="Email" value="<?= isset($_POST["email"]) ? clean(mysqli_real_escape_string($conn, $_POST["email"])) : "" ?>" minlength="3" maxlength="50" class="w-full mb-2">
        <input required type="password" name="password" placeholder="Password" minlength="8" class="w-full mb-2">
        <input required type="password" name="password2" placeholder="Repeat Password" minlength="8" class="w-full mb-2">
        <?php if (config("captcha_enabled") == 1) { ?>
            <div class="h-captcha w-full mb-2" data-sitekey="<?= config("captcha_key") ?>"></div>
        <?php } ?>
        <input type="submit" name="signup" class="w-full p-2 bg-green-500 text-white border border-black hover:bg-green-800 cursor-pointer">
    </form>
    <?php if ($error == true) { ?>
        <div class="text-red-500 py-2 text-center" id="errortext"><?= $result ?></div>
    <?php } ?>
    <hr class="my-2">
    <p class="text-gray-500">Already have one? <a href="<?= config("url") ?>account/login" class="text-blue-500 hover:underline">Login!</a></p>
</div>

<div class="col-span-5"></div>