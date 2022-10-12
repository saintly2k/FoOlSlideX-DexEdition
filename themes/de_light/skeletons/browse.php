<div class="col-span-12">
    <h1 class="text-left text-2xl flex">Browse Titles - Page <span class="h-7 bg-gray-200 rounded-full w-[30px] animate-pulse ml-1 mt-1"></span></h1>
    <hr class="w-full my-2">
    <p>
        <b>Order by:</b>
        <a href="#/" class="p-1 text-white bg-gray-500">Alphabetical &uarr;</a>
        <a href="#/" class="p-1 text-white bg-gray-500">Alphabetical &darr;</a>
        <a href="#/" class="p-1 text-white bg-gray-500">Created &uarr;</a>
        <a href="#/" class="p-1 text-white bg-gray-500">Created &darr;</a>
        <a href="#/" class="p-1 text-white bg-gray-500">Released &uarr;</a>
        <a href="#/" class="p-1 text-white bg-gray-500">Released &darr;</a>
    </p>
    <hr class="w-full my-2">
    <div class="w-full grid grid-cols-3 gap-2">
        <?php for ($i = 1; $i <= config("home_display_chapters"); $i++) { ?>
            <div class="col-span-1 grid grid-cols-3 gap-2">
                <div role="status" class="animate-pulse shadow">
                    <div class="flex justify-center items-center w-full h-60 bg-gray-300 rounded">
                        <svg class="w-12 h-12 text-gray-200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor" viewBox="0 0 640 512">
                            <path d="M480 80C480 35.82 515.8 0 560 0C604.2 0 640 35.82 640 80C640 124.2 604.2 160 560 160C515.8 160 480 124.2 480 80zM0 456.1C0 445.6 2.964 435.3 8.551 426.4L225.3 81.01C231.9 70.42 243.5 64 256 64C268.5 64 280.1 70.42 286.8 81.01L412.7 281.7L460.9 202.7C464.1 196.1 472.2 192 480 192C487.8 192 495 196.1 499.1 202.7L631.1 419.1C636.9 428.6 640 439.7 640 450.9C640 484.6 612.6 512 578.9 512H55.91C25.03 512 .0006 486.1 .0006 456.1L0 456.1z" />
                        </svg>
                    </div>
                </div>
                <div class="col-span-2 p-1 pt-2">
                    <div class="h-4 bg-gray-200 rounded-full mt-1 w-1/2"></div>
                    <div class="h-4 bg-gray-200 rounded-full mt-2 w-full"></div>
                    <div class="h-4 bg-gray-200 rounded-full mt-1 w-full"></div>
                    <div class="grid grid-cols-3 gap-2 mt-1">
                        <div class="col-span-1 text-left">
                            <div class="h-4 bg-gray-200 rounded-full mt-1 w-full"></div>
                        </div>
                        <div class="col-span-1 text-right flex justify-end items-right">
                            <div class="h-5 w-5 bg-gray-300 rounded-full flex justify-center items-center">
                                <svg class="w-3 h-3 text-gray-200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor" viewBox="0 0 640 512">
                                    <path d="M480 80C480 35.82 515.8 0 560 0C604.2 0 640 35.82 640 80C640 124.2 604.2 160 560 160C515.8 160 480 124.2 480 80zM0 456.1C0 445.6 2.964 435.3 8.551 426.4L225.3 81.01C231.9 70.42 243.5 64 256 64C268.5 64 280.1 70.42 286.8 81.01L412.7 281.7L460.9 202.7C464.1 196.1 472.2 192 480 192C487.8 192 495 196.1 499.1 202.7L631.1 419.1C636.9 428.6 640 439.7 640 450.9C640 484.6 612.6 512 578.9 512H55.91C25.03 512 .0006 486.1 .0006 456.1L0 456.1z" />
                                </svg>
                            </div>
                        </div>
                    <div class="h-4 bg-gray-200 rounded-full mt-1 w-full"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <hr class="w-full my-2">
    <div class="w-full text-center flex items-center justify-center">
        <div class="h-8 bg-gray-200 rounded-full w-2/12 animate-pulse"></div>
    </div>
</div>