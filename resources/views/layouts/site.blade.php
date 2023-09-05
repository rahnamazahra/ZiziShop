<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="boxicons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <section class="p-5">
        <div class="flex justify-between gap-6">
            <div class="flex justify-start">
                <span class="font-extrabold">Shop.</span>
                <span class="font-extrabold text-color4">zizi</span>
            </div>
            <div class="w-[20rem]">
                <form method="GET">
                    <div class="relative text-gray-600 focus-within:text-gray-400">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </span>
                        <input type="search" name="search" class="w-full py-2 text-sm text-white bg-color2 rounded-md pl-2 border-none focus:border-color4" placeholder="جست‌و‌جو" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="flex justify-between gap-6">
                <div class="relative flex items-center">
                    <span class="badge absolute top-0 right-3 bg-color4 rounded-full px-1 py-0.5 text-white text-xs leading-none mr-1">2</span>
                    <i class="bx bx-heart text-2xl"></i>
                </div>
                <div class="relative flex items-center">
                    <span class="badge absolute top-0 right-3 bg-color4 rounded-full px-1 py-0.5 text-white text-xs leading-none mr-1">24</span>
                    <i class="bx bx-shopping-bag bx-tada text-2xl"></i>
                </div>

                <div class="w-[7rem]">
                    <button class="w-full bg-white border border-gray-300 py-2 px-4 rounded-lg flex justify-between gap-1">
                        <span class="text-color3 text-sm">ورود</span>
                        <span class="text-color3 text-sm">/</span>
                        <span class="text-color3 text-sm">ثبت‌نام</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <nav class="flex">
                <div class="text-sm lg:flex-grow">
                    <a href="#responsive-header" class="block font-bold mt-4 lg:inline-block lg:mt-0 text-color3 hover:text-color1">
                        خانه
                    </a>
                    <a href="#responsive-header" class="block font-bold mt-4 lg:inline-block lg:mt-0 text-color3 hover:text-color1 mr-4">
                       لباس
                    </a>
                    <a href="#responsive-header" class="block font-bold mt-4 lg:inline-block lg:mt-0 text-color3 hover:text-color1 mr-4">
                      کیف و کفش
                    </a>
                    <a href="#responsive-header" class="block font-bold mt-4 lg:inline-block lg:mt-0 text-color3 hover:text-color1 mr-4">
                       اکسسوری
                    </a>
                </div>
            </nav>
            <hr class="border-color2 my-6">
        </div>
    </section>
    <section class="p-5">
        @yield('content')
    </section>
    <section class="">
<div class="bg-color2">
    <div class="max-w-2xl mx-auto text-color3 py-10">
        <div class="text-center">
            <h3 class="text-3xl mb-3"> Download our fitness app </h3>
            <p> Stay fit. All day, every day. </p>
            <div class="flex justify-center my-10">
                <div class="flex items-center border w-auto rounded-lg px-4 py-2 w-52 mx-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/888/888857.png" class="w-7 md:w-8">
                    <div class="text-left ml-3">
                        <p class='text-xs text-color3'>Download on </p>
                        <p class="text-sm md:text-base"> Google Play Store </p>
                    </div>
                </div>
                <div class="flex items-center px-4 py-2 mx-2">
                    <img src="images/enamad/enamad.png" class="">

                </div>
            </div>
        </div>
        <div class="mt-28 flex flex-col md:flex-row md:justify-between items-center text-sm text-gray-400">
            <p class="order-2 md:order-1 mt-8 md:mt-0"> &copy; Beautiful Footer, 2021. </p>
            <div class="order-1 md:order-2">
                <span class="px-2">About us</span>
                <span class="px-2 border-l">Contact us</span>
                <span class="px-2 border-l">Privacy Policy</span>
            </div>
        </div>
    </div>
</div>
    </section>
</body>
</html>
