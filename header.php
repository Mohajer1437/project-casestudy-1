<?php
/**
 * The template for displaying header
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (has_site_icon()): ?>
        <link rel="icon" href="<?php echo esc_url(get_site_icon_url()); ?>" type="image/png">
    <?php endif; ?>
    <?php wp_head() ?>
</head>
<!-- navbar -->
<!-- header desktop -->
<header class="hidden lg:block">
    <style>
        * {
            direction: rtl;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: black;
            font-weight: bold;
            line-height: 2.5rem;
        }

        h1 {
            font-size: 23px !important;
        }

        h2 {
            font-size: 20px !important;
        }

        h3 {
            font-size: 18px !important ;
        }

        p a {
            color: blue;
        }

        .font-sansFanumRegular ul {
            list-style-type: disc;
            list-style-position: inside;
            margin: 1em 0;
            padding-right: 20px;
        }

        .font-sansFanumRegular ol {
            list-style-type: decimal;
            list-style-position: inside;
            margin: 1em 0;
            padding-right: 20px;
        }

        .font-sansFanumRegular ul li,
        .font-sansFanumRegular ol li {
            margin-bottom: 0.5em;
        }

        .bg-red-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(63.7% 0.237 25.331 / var(--tw-bg-opacity, 1));
        }

        body {
            background-color: #F9F9F9;
        }

        @media (max-width: 1926px) {
            .font-sansFanumRegular ul {
                padding-right: 0 !important;
            }

            .font-sansFanumRegular ol {
                padding-right: 0 !important;
            }
        }

        .z-20 {
            z-index: 20;
        }

        .z-50 {
            z-index: 50;
        }
    </style>
    <div
        class="w-full xl:w-[90%] 2xl:container  bg-silver-100  mx-auto mt-4 flex justify-between items-center py-5 pl-[70px] pr-[19px] rounded-Cradius">


        <div class="flex justify-start gap-x-2">
            <a href="<?php echo get_home_url(); ?>">
                <?php
                $logo = get_theme_mod('theme_logo');
                if (!empty($logo)) {
                    echo '<img
                        src="' . esc_url($logo) . '"
                        alt="logo" />';
                } else {
                    echo '<h1 class="site-title">' . get_bloginfo('name') . '</h1>'; // نمایش نام سایت در صورت نبود لوگو
                }
                ?>
            </a>
            <div class="relative">
                <div class="bg-white h-fit p-2 flex items-center justify-start gap-x-3 rounded-xl">
                    <input
                        class="header-search-input font-sansRegular text-input h-11 lg:w-[200px] xl:w-[360px] outline-none  px-2"
                        placeholder="جستجوی محصولات">

                    <button class="bg-mainBlue p-3 rounded-xl">
                        <svg class="w-6 h-6">
                            <use href="#Magnifer"></use>
                        </svg>
                    </button>
                </div>
                <div
                    class="w-full absolute top-[45px] bg-white z-50 shadow-lg rounded-xl overflow-y-auto max-h-[200px]">
                    <div class="search-result-container">

                    </div>

                </div>
            </div>

        </div>




        <div class="flex items-center justify-start gap-x-2">

            <a href="<?php echo get_home_url(); ?>/my-account"
                class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2">

                <svg class="w-7 h-7">
                    <use href="#User"></use>
                </svg>

                <div class="text-detail font-sansBold">ورود | ثبت‌نام</div>
            </a>


            <a href="<?php echo get_home_url(); ?>/cart"
                class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2 w-fit relative">
                <div style="font-size: 10px;"
                    class="absolute top-0 right-0 bg-red-500 rounded-full w-4 h-4 font-sansFanumBold flex items-center justify-center text-white">
                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                </div>

                <svg class="w-7 h-7">
                    <use href="#cartCheck"></use>
                </svg>

            </a>
        </div>
    </div>
</header>

<nav class=" w-full xl:w-[90%] 2xl:container mx-auto hidden lg:block sticky top-0 z-20">
    <div
        class="bg-[#3c4f87] w-[90%] py-[10px] rounded-bl-Cradius mx-auto rounded-br-Cradius px-11 font-sansFanumRegular text-white flex justify-between items-center relative ">







        <ul class="flex items-center lg:gap-x-4 xl:gap-x-6 text-detail text-white h-[55px]">
            <?php
            $menu_name = 'header-mega-menu'; // نام جایگاه منو در وردپرس
            $locations = get_nav_menu_locations();
            $menu_counter = 1; // شمارنده برای ID منوها
            
            if (isset($locations[$menu_name])) {
                $menu_id = $locations[$menu_name];
                $menu_items = wp_get_nav_menu_items($menu_id);

                $menu_structure = []; // ساختار درختی منو
                foreach ($menu_items as $item) {
                    if ($item->menu_item_parent == 0) {
                        $menu_structure[$item->ID] = [
                            'item' => $item,
                            'children' => []
                        ];
                    } else {
                        if (!isset($menu_structure[$item->menu_item_parent])) {
                            $menu_structure[$item->menu_item_parent] = ['children' => []];
                        }
                        $menu_structure[$item->menu_item_parent]['children'][] = $item;
                    }
                }

                foreach ($menu_structure as $menu_id => $menu_data) {
                    if (!isset($menu_data['item'])) {
                        continue; // اگر مقدار item وجود نداشت، ادامه بده تا خطا ندهد
                    }

                    $menu_item = $menu_data['item'];
                    $children = $menu_data['children'] ?? [];
                    $has_children = !empty($children); // بررسی وجود زیرمنو
            
                    // فقط اگر زیرمنو دارد، data-megamenu و id را اضافه کن
                    $menu_id_attr = $has_children ? "menu" . $menu_counter : "";
                    // echo '<pre>';
                    // var_dump($menu_item);
                    // echo '</pre>';
                    ?>
                    <li class="cursor-pointer h-full flex items-center group relative" <?php echo $has_children ? 'data-megamenu="' . esc_attr($menu_id_attr) . '"' : ''; ?>>
                        <ul>
                            <li class="flex items-center justify-start gap-x-2">
                                <a href="<?php echo esc_url($menu_item->url); ?>" class="depth0 group-hover:scale-110 transition-all duration-500">
                                    <?php echo esc_html($menu_item->title); ?>
                                </a>
                                <?php if ($has_children): ?>
                                    <svg class="w-[18px] h-[18px] group-hover:rotate-180 transition-all duration-500">
                                        <use href="#chevron-down"></use>
                                    </svg>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </li>
                    <?php
                    if ($has_children) {
                        $menu_counter++; // شمارنده را افزایش بده فقط اگر زیرمنو دارد
                    }
                }
            } else {
                echo '<li>منوی مورد نظر یافت نشد</li>';
            }
            ?>
        </ul>





        <!-- مگا منو -->
        <div id="MegamenuContent"
            class="bg-white border-8 border-nili-200 shadow-2xl absolute w-[93%] h-[70vh] group-hover:flex-col rounded-xl text-nowrap top-[78%] px-12 py-3 text-mainBlue space-y-4 font-sansFanumRegular mx-auto hidden pt-9 overflow-y-auto">
            <?php
            $menu_counter = 1;
            foreach ($menu_structure as $menu_id => $menu_data) {
                if (!isset($menu_data['item']))
                    continue;

                $menu_item = $menu_data['item'];
                $children = $menu_data['children'] ?? [];

                // فقط اگر زیرمنو دارد `a_mega__menu__part` ایجاد شود
                if (!empty($children)) {
                    $menu_id_attr = "menu" . $menu_counter;
                    ?>
                    <div id="<?php echo esc_attr($menu_id_attr); ?>" class="hidden a_mega__menu__part">
                        <div class="grid grid-cols-3 xl:grid-cols-4 gap-x-12 gap-y-12">
                            <?php foreach ($children as $child) { ?>
                                <div class="space-y-4">
                                    <a href="<?php echo esc_attr($child->url); ?>"
                                        class="depth2 font-sansBold text-xl border-b-2 text-zinc-700 border-zinc-200 pb-2">
                                        <?php echo esc_html($child->title); ?>
                                    </a>
                                    <ul class="space-y-2 text-zinc-600 pr-2 cursor-pointer">
                                        <?php
                                        foreach ($menu_items as $sub_item) {
                                            if ($sub_item->menu_item_parent == $child->ID) { ?>
                                                <li class="transition-all duration-300 hover:scale-110">
                                                    <a class="depth3" href="<?php echo esc_url($sub_item->url); ?>">
                                                        <?php echo esc_html($sub_item->title); ?>
                                                    </a>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    $menu_counter++;
                }
            }
            ?>
        </div>





        <div class="flex justify-start items-center gap-x-2">
            <?php
            $phone_number = get_option('header_phone_number', '');
            if ($phone_number):
                ?>
                <div class="tracking-wider"><?php echo esc_html($phone_number); ?></div>

            <?php endif; ?>

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




    </div>


</nav>

<!-- menu mobile -->

<div class="lg:hidden bg-silver-100 fixed top-0 w-full z-30">


    <div class="flex items-center">




        <div id="mobile__menu__bar" style="justify-content: space-between;"
            class="flex items-center justify-end pl-5 py-2 h-full w-full transition-all duration-300">


            <div class="pr-5">
                <svg id="humbergerr" class="w-6 h-6">
                    <use href="#humberger"></use>
                </svg>
            </div>

            <a href="<?php echo get_home_url(); ?>">
                <?php
                $logo = get_theme_mod('theme_logo');
                if (!empty($logo)) {
                    echo '<img
                        src="' . esc_url($logo) . '"
                        alt="logo" />';
                } else {
                    echo '<h1 class="site-title">' . get_bloginfo('name') . '</h1>';
                }
                ?>
            </a>



            <div id="controler__icon__menu__bar"
                class="flex items-center justify-start gap-x-2 transition-all duration-300">

                <a href="<?php echo get_home_url(); ?>/my-account"
                    class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2">

                    <svg class="w-7 h-7">
                        <use href="#User"></use>
                    </svg>

                </a>


                <a href="<?php echo get_home_url(); ?>/cart"
                    class="p-[11px] flex justify-start items-center bg-white rounded-xl gap-x-2 w-fit relative">
                    <div style="font-size: 10px;"
                        class="absolute top-0 right-0 bg-red-500 rounded-full w-4 h-4 font-sansFanumBold flex items-center justify-center text-white">
                        <?php echo WC()->cart->get_cart_contents_count(); ?>
                    </div>
                    <svg class="w-7 h-7">
                        <use href="#cartCheck"></use>
                    </svg>

                </a>
            </div>


        </div>



        <div id="first__level"
            class="z-50 w-64 -right-64 fixed top-0 h-full bg-silver-100  overflow-y-auto transition-all duration-300">


            <div>
                <a href="<?php echo get_home_url(); ?>" class="w-[89px] mt-1 mr-3">
                    <?php
                    $logo = get_theme_mod('theme_logo');
                    if (!empty($logo)) {
                        echo '<img
                        src="' . esc_url($logo) . '"
                        alt="logo" />';
                    } else {
                        echo '<h1 class="site-title">' . get_bloginfo('name') . '</h1>';
                    }
                    ?>
                </a>
            </div>


            <?php
            wp_nav_menu(array(
                'theme_location' => 'header-mega-menu',
                'container' => false,
                'menu_class' => 'font-sansFanumBold mt-12 px-4 parent__item__menu',
                'walker' => new Custom_Walker_Nav_Menu()
            ));

            ?>


        </div>

        <div id="second__level"
            class="z-50 w-64 -right-64 fixed top-0 h-full bg-silver-100  overflow-y-auto transition-all duration-300 pt-6 px-4">

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

        <div id="three__level"
            class="z-50 w-64 -right-64 fixed top-0 h-full bg-silver-100   overflow-y-auto transition-all duration-300 pt-6 px-4">

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



    <div style="gap: 20px;" id="mobile-serach" class="relative flex items-center mb-3 w-[90%] block mx-auto">
        <div style="width: 100%;" class="bg-white h-fit p-2 flex items-center justify-start gap-x-3 rounded-xl">
            <input class="mobile-header-search-input font-sansRegular text-input h-6 w-full outline-none px-2"
                placeholder="جستجوی محصولات">

            <button class="bg-mainBlue p-2 rounded-xl">
                <svg class="w-4 h-4">
                    <use href="#Magnifer"></use>
                </svg>
            </button>
        </div>
        <div class="w-full absolute top-[45px] bg-white z-50 shadow-lg rounded-xl overflow-y-auto max-h-[200px]">
            <div class="mobile-search-result-container">

            </div>

        </div>
        <?php
        $phone_number = get_option('header_phone_number', '');
        if ($phone_number):
            ?>
            <a href="<?php echo esc_url('tel:' . $phone_number); ?>"
                class="p-[6px] border-2 border-white w-fit rounded-full relative">
                <div class="bg-sky-950 p-3 rounded-full ">
                    <svg class="w-4 h-4">
                        <use href="#phone"></use>
                    </svg>
                </div>

                <div class="w-[9px] h-[9px] rounded-full bg-Cyellow absolute -top-[1px]"></div>
            </a>
        <?php else: ?>

            <div class="p-[6px] border-2 border-white w-fit rounded-full relative">
                <div class="bg-sky-950 p-3 rounded-full ">
                    <svg class="w-4 h-4">
                        <use href="#phone"></use>
                    </svg>
                </div>

                <div class="w-[9px] h-[9px] rounded-full bg-Cyellow absolute -top-[1px]"></div>
            </div>
        <?php endif; ?>

    </div>

</div>

<div class="overlay_section hidden transition-all duration-300 fixed top-0 bottom-0 left-0 right-0 bg-black/60 z-20">
</div>