<?php
/**
 * The template for displaying header navigationbar
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<!-- header desktop -->
<header class="hidden lg:block">
    <div class="w-full xl:w-[90%] 2xl:container  bg-silver-100  mx-auto mt-4 flex justify-between items-center py-5 pl-[70px] pr-[19px] rounded-Cradius">


        <div class="flex justify-start gap-x-2">
            <div>
                <img src="<?php echo get_stylesheet_directory_uri().'/assets/img/lOGO.png' ?>">
            </div>

            <div class="bg-white h-fit p-2 flex items-center justify-start gap-x-3 rounded-xl">
                <input class="font-sansRegular text-input h-11 lg:w-[200px] xl:w-[360px] outline-none  px-2" placeholder="جستجوی محصولات">

                <button class="bg-mainBlue p-3 rounded-xl">
                    <svg class="w-6 h-6">
                        <use href="#Magnifer"></use>
                    </svg>
                </button>
            </div>

        </div>




        <div class="flex items-center justify-start gap-x-2">

            <div class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2">

                <svg class="w-7 h-7">
                    <use href="#User"></use>
                </svg>

                <div class="text-detail font-sansBold">ورود  |  ثبت‌نام</div>
            </div>


            <div class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2 w-fit relative">

                <svg class="w-7 h-7">
                    <use href="#cartCheck"></use>
                </svg>

            </div>
        </div>
    </div>
</header>

<!-- navigationbar Desktop -->
<nav class=" w-full xl:w-[95%] 2xl:container mx-auto hidden z-50 lg:block sticky top-0">
    <div class="bg-mainBlue w-[90%] py-[10px] rounded-bl-Cradius mx-auto rounded-br-Cradius px-11 font-sansFanumRegular text-white flex justify-between items-center relative ">

        <ul class="flex items-center lg:gap-x-4 xl:gap-x-6 text-detail text-white h-[55px]">

            <!-- has sub menu -->
            <li class="cursor-pointer  h-full group relative">
                <a href="#" class="h-full">
                    <div class="flex items-center justify-start gap-x-2 h-full">
                        <div class="group-hover:scale-110 transition-all duration-500">ایده آل برش</div>
                        <svg class="w-[18px] h-[18px] group-hover:rotate-180 transition-all duration-500">
                            <use href="#chevron-down"></use>
                        </svg>
                    </div>
                </a>


                <ul class="bg-white border-4 border-nili-200 shadow-2xl hidden group-hover:flex group-hover:flex-col rounded-xl absolute text-nowrap  top-[90%] px-12 py-3 text-zinc-700 space-y-4 font-sansFanumRegular">
                    <li  class="hover:scale-110 transition-all duration-300">مورد دوم</li>
                    <li  class="hover:scale-110 transition-all duration-300">مورد سوم</li>
                    <li  class="hover:scale-110 transition-all duration-300">مورد چهارم که عنوانش طولانیه</li>
                </ul>




            </li>


            <!-- has submenu -->
            <li class="cursor-pointer  h-full group relative">
                <a href="#" class="h-full">
                    <div class="flex items-center justify-start gap-x-2 h-full">
                        <div class="group-hover:scale-110 transition-all duration-500">دستگاه برش</div>
                        <svg class="w-[18px] h-[18px] group-hover:rotate-180 transition-all duration-500">
                            <use href="#chevron-down"></use>
                        </svg>
                    </div>
                </a>


                <ul class="bg-white border-4 border-nili-200 shadow-2xl hidden group-hover:flex group-hover:flex-col rounded-xl absolute text-nowrap  top-[90%] px-12 py-3 text-zinc-700 space-y-4 font-sansFanumRegular">
                    <li class="hover:scale-110 transition-all duration-300">مورد پنجم</li>
                    <li class="hover:scale-110 transition-all duration-300">مورد ششم</li>
                    <li class="hover:scale-110 transition-all duration-300">مورد هفتم</li>
                    <li class="hover:scale-110 transition-all duration-300">مورد هشتم</li>
                </ul>




            </li>


            <!-- has mega menu -->
            <li class="cursor-pointer h-full flex items-center group " data-megamenu="menu1">
                <ul>
                    <li class="flex items-center justify-start gap-x-2">
                        <div class="group-hover:scale-110 transition-all duration-500">مگامنو 1</div>
                        <svg class="w-[18px] h-[18px] group-hover:rotate-180 transition-all duration-500">
                            <use href="#chevron-down"></use>
                        </svg>
                    </li>
                </ul>
            </li>

            <div class="hidden scale-x-125 rotate-180"></div>

            <!-- has mega menu -->
            <li class="cursor-pointer h-full flex items-center group " data-megamenu="menu2">
                <ul>
                    <li class="flex items-center justify-start gap-x-2">
                        <div class="group-hover:scale-110 transition-all duration-500">مگامنو 2</div>
                        <svg class="w-[18px] h-[18px] group-hover:rotate-180 transition-all duration-500">
                            <use href="#chevron-down"></use>
                        </svg>
                    </li>
                </ul>
            </li>







            <li>
                <ul>
                    <li class="flex items-center justify-start gap-x-2">
                        <div>درباره ما</div>
                    </li>
                </ul>
            </li>


            <li>
                <ul>
                    <li class="flex items-center justify-start gap-x-2">
                        <div>تماس با ما</div>
                    </li>
                </ul>
            </li>

        </ul>


        <div class="flex justify-start items-center gap-x-2">
            <div class="tracking-wider">09121234567</div>



            <div class="p-[6px] border-2 border-white w-fit rounded-full relative">
                <div class="bg-sky-950 p-3 rounded-full ">
                    <svg class="w-4 h-4">
                        <use href="#phone"></use>
                    </svg>
                </div>

                <div class="w-[9px] h-[9px] rounded-full bg-Cyellow absolute -top-[1px]"></div>
            </div>



        </div>


        <!-- Mega Menu -->


        <div id="MegamenuContent" class="bg-white border-8 border-nili-200 shadow-2xl absolute w-[93%] h-[70vh] group-hover:flex-col rounded-xl  text-nowrap  top-[78%] px-12 py-3 text-mainBlue space-y-4 font-sansFanumRegular mx-auto hidden pt-9 overflow-y-auto">
            <div id="menu1" class="hidden a_mega__menu__part">
                <div class="grid grid-cols-3 xl:grid-cols-4 gap-x-12 gap-y-12">
                    <div class="space-y-4">
                        <p class="font-sansBold text-xl border-b-2 text-zinc-700 border-zinc-200 pb-2">وسایل نماز</p>

                        <ul class="space-y-2 text-zinc-600 pr-2 cursor-pointer">
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">چادر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">سجاده</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">مهر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">تسبیح</a>
                            </li>
                        </ul>

                    </div>
                    <div class="space-y-4">
                        <p class="font-sansBold text-xl border-b-2 text-zinc-700 border-zinc-200 pb-2">وسایل نماز</p>

                        <ul class="space-y-2 text-zinc-600 pr-2 cursor-pointer">
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">چادر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">سجاده</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">مهر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">تسبیح</a>
                            </li>
                        </ul>

                    </div>
                    <div class="space-y-4">
                        <p class="font-sansBold text-xl border-b-2 text-zinc-700 border-zinc-200 pb-2">وسایل نماز</p>

                        <ul class="space-y-2 text-zinc-600 pr-2 cursor-pointer">
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">چادر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">سجاده</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">مهر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">تسبیح</a>
                            </li>
                        </ul>

                    </div>
                    <div class="space-y-4">
                        <p class="font-sansBold text-xl border-b-2 text-zinc-700 border-zinc-200 pb-2">وسایل نماز</p>

                        <ul class="space-y-2 text-zinc-600 pr-2 cursor-pointer">
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">چادر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">سجاده</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">مهر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">تسبیح</a>
                            </li>
                        </ul>

                    </div>
                    <div class="space-y-4">
                        <p class="font-sansBold text-xl border-b-2 text-zinc-700 border-zinc-200 pb-2">وسایل نماز</p>

                        <ul class="space-y-2 text-zinc-600 pr-2 cursor-pointer">
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">چادر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">سجاده</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">مهر</a>
                            </li>
                            <li class="transition-all duration-300 hover:scale-110">
                                <a href="#">تسبیح</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <div id="menu2" class="hidden a_mega__menu__part">
                2
            </div>
        </div>

    </div>


</nav>


<!-- menu mobile -->

<div class="lg:hidden bg-silver-100  pr-5 flex items-center justify-between fixed top-0 w-full z-30">



    <div id=" ">
        <svg id="humbergerr" class="w-6 h-6">
            <use href="#humberger"></use>
        </svg>
    </div>





    <div id="mobile__menu__bar" class="flex items-center justify-end pl-5   py-4  h-full w-full transition-all duration-300">



        <div class="w-[89px] block mx-auto">
            <img class="w-[89px] mr-8" src="./imgs/lOGO.png">
        </div>


        <div id="controler__icon__menu__bar" class="flex items-center justify-start gap-x-2 transition-all duration-300">

            <a href="#2" class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2">

                <svg class="w-7 h-7">
                    <use href="#User"></use>
                </svg>

            </a>


            <div class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2 w-fit relative">

                <svg class="w-7 h-7">
                    <use href="#cartCheck"></use>
                </svg>

            </div>
        </div>


    </div>



    <div id="first__level" class="w-64 md:w-[384px] -right-64 md:-right-[384px] fixed top-0 h-full bg-silver-100  overflow-y-auto transition-all duration-300">


        <div>
            <div class="w-[89px] mt-1 mr-3">
                <img class="w-[89px]" src="./imgs/lOGO.png">
            </div>
        </div>


        <ul class="font-sansFanumBold mt-12 px-4 parent__item__menu">

            <li class="item__menu__mobile has__subMenu border-b-2 border-zinc-200 w-full">

                <div class="flex items-center justify-between text-zinc-700 py-3">
                    <a href="#1">1</a>
                    <div>
                        <svg class="w-6 h-6 text-mainBlue">
                            <use href="#chevron-left"></use>
                        </svg>
                    </div>
                </div>


                <ul class="parent__item__menu font-sansFanumBold mt-12 px-4  hidden">

                    <li class="item__menu__mobile has__subMenu border-b-2 border-zinc-200">

                        <div class="flex items-center justify-between text-zinc-700 py-3">
                            <p>1.1</p>
                            <div>
                                <svg class="w-6 h-6 text-mainBlue">
                                    <use href="#chevron-left"></use>
                                </svg>
                            </div>
                        </div>

                        <ul class="font-sansFanumBold mt-12 px-4 hidden parent__item__menu">

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>1.11</p>
                                </div>



                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>1.12</p>
                                </div>

                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>1.13</p>
                                </div>

                            </li>


                        </ul>

                    </li>

                    <li class="item__menu__mobile has__subMenu border-b-2 border-zinc-200">

                        <div class="flex items-center justify-between text-zinc-700 py-3">
                            <p>1.2</p>
                            <div>
                                <svg class="w-6 h-6 text-mainBlue">
                                    <use href="#chevron-left"></use>
                                </svg>
                            </div>
                        </div>

                        <ul class="font-sansFanumBold mt-12 px-4 hidden parent__item__menu">

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>1.21</p>
                                </div>



                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>1.22</p>
                                </div>

                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>1.23</p>
                                </div>

                            </li>


                        </ul>

                    </li>

                    <li class="item__menu__mobile border-b-2 border-zinc-200">

                        <div class="flex items-center justify-between text-zinc-700 py-3">
                            <p>1.3</p>
                        </div>

                    </li>


                </ul>

            </li>

            <li class="item__menu__mobile has__subMenu border-b-2 border-zinc-200 w-full">

                <div class="flex items-center justify-between text-zinc-700 py-3">
                    <p>2</p>
                    <div>
                        <svg class="w-6 h-6 text-mainBlue">
                            <use href="#chevron-left"></use>
                        </svg>
                    </div>
                </div>


                <ul class="parent__item__menu font-sansFanumBold mt-12 px-4  hidden">

                    <li class="item__menu__mobile has__subMenu border-b-2 border-zinc-200">

                        <div class="flex items-center justify-between text-zinc-700 py-3">
                            <p>2.1</p>
                            <div>
                                <svg class="w-6 h-6 text-mainBlue">
                                    <use href="#chevron-left"></use>
                                </svg>
                            </div>
                        </div>

                        <ul class="font-sansFanumBold mt-12 px-4 hidden parent__item__menu">

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>2.11</p>
                                </div>



                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>2.12</p>
                                </div>

                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>2.13</p>
                                </div>

                            </li>


                        </ul>

                    </li>

                    <li class="item__menu__mobile has__subMenu border-b-2 border-zinc-200">

                        <div class="flex items-center justify-between text-zinc-700 py-3">
                            <a href="https://www.w3schools.com/jsref/event_preventdefault.asp">2.2</a>
                            <div>
                                <svg class="w-6 h-6 text-mainBlue">
                                    <use href="#chevron-left"></use>
                                </svg>
                            </div>
                        </div>

                        <ul class="font-sansFanumBold mt-12 px-4 hidden parent__item__menu">

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>2.21</p>
                                </div>



                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>2.22</p>
                                </div>

                            </li>

                            <li class="item__menu__mobile border-b-2 border-zinc-200">

                                <div class="flex items-center justify-between text-zinc-700 py-3">
                                    <p>2.23</p>
                                </div>

                            </li>


                        </ul>

                    </li>

                    <li class="item__menu__mobile border-b-2 border-zinc-200">

                        <div class="flex items-center justify-between text-zinc-700 py-3">
                            <a href="https://www.w3schools.com/jsref/event_preventdefault.asp">2.3</a>
                        </div>

                    </li>


                </ul>

            </li>

            <li class="item__menu__mobile border-b-2 border-zinc-200">

                <div class="flex items-center justify-between text-zinc-700 py-3">
                    <a href="#3">مورد سوم</a>
                </div>

            </li>


        </ul>


    </div>

    <div id="second__level" class="w-64 md:w-[384px] -right-64 md:-right-[384px] fixed top-0 h-full bg-silver-100  overflow-y-auto transition-all duration-300 pt-6 px-4">

        <div>


            <div class="flex items-center bg-sky-100 py-2 px-4 w-fit rounded-lg back__state">

                <div>

                    <svg class="w-6 h-6 text-sky-800 rotate-180">
                        <use href="#chevron-left"></use>
                    </svg>

                </div>



                <div>
                    <p class="font-sansBold text-sky-800">بازگشت</p>
                </div>



            </div>


        </div>


        <div id="placeHolder__two">

        </div>

    </div>

    <div id="three__level" class="w-64 md:w-[384px] -right-64 md:-right-[384px] fixed top-0 h-full bg-silver-100   overflow-y-auto transition-all duration-300 pt-6 px-4">

        <div>


            <div class="flex items-center bg-sky-100 py-2 px-4 w-fit rounded-lg back__state">

                <div>

                    <svg class="w-6 h-6 text-sky-800 rotate-180">
                        <use href="#chevron-left"></use>
                    </svg>

                </div>



                <div>
                    <p class="font-sansBold text-sky-800">بازگشت</p>
                </div>



            </div>


        </div>


        <div id="placeHolder__three">

        </div>

    </div>

</div>


<!-- searchbar for mobile -->
<div class="lg:hidden h-fit px-4 flex items-center justify-between overflow-x-hidden  gap-x-3 rounded-xl mt-24">

    <div class="flex items-center justify-between bg-white w-4/5 p-[5px] rounded-xl border-2 border-[#C5D4FF]">

        <div class="">
            <input class="font-sansRegular text-input h-10  outline-none  px-2" placeholder="جستجوی محصولات">
        </div>


        <button class="bg-mainBlue p-3 rounded-xl">
            <svg class="w-4 h-4">
                <use href="#Magnifer"></use>
            </svg>
        </button>

    </div>

    <div class="p-[6px] border-2 border-[#C5D4FF] w-fit rounded-full relative">
        <div class="bg-sky-950 p-3 rounded-full ">
            <svg class="w-4 h-4">
                <use href="#phone"></use>
            </svg>
        </div>

        <div class="w-[9px] h-[9px] rounded-full bg-Cyellow absolute -top-[1px]"></div>
    </div>

</div>