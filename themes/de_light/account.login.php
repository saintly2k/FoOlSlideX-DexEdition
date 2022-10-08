<div class="col-span-5"></div>

<div class="col-span-2">
    <h1 class="text-center text-3xl">Login</h1>
    <h3 class="text-center text-xl mb-4">Good to see you back!</h3>
    <form method="POST" name="login" id="loginform">
        <input type="text" name="email" placeholder="Email" minlength="3" maxlength="50" class="w-full mb-2">
        <input type="password" name="password" placeholder="Password" minlength="8" class="w-full mb-2">
        <input type="submit" name="login" class="w-full p-2 bg-green-500 text-white border border-black hover:bg-green-800 cursor-pointer">
    </form>
    <?php if ($error == true) { ?>
        <div class="text-red-500 py-2 text-center" id="errortext"><?= $result ?></div>
    <?php } ?>
    <hr class="my-2">
    <p class="text-gray-500">Don't have one? <a href="<?= config("url") ?>account/signup" class="text-blue-500 hover:underline">Signup!</a></p>
</div>

<div class="col-span-5"></div>