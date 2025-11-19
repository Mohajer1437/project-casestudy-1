<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<?php get_header('shop'); ?>

<body>






    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* .swiper-slide img {
          display: block;
          width: 100%;
          height: 100%;
          object-fit: cover;
        } */


        .swiper {
            width: 100%;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        /* .mySwiper2 {
          height: 80%;
          width: 100%;
        } */

        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }


        ul.tabs li {
            list-style: none;
            text-align: center;
        }

        @media (max-width: 768px) {
            ul.tabs li {
                min-width: 100px;
                font-size: 13px;
                list-style: none;
                text-align: center;
            }
        }
    </style>
    <?php get_template_part('partials/icons/icons', 'ideal'); ?>
    <?php get_template_part('partials/breadcrumb/breadcrumb', 'singleIdeal') ?>



    <?php
    /**
     * woocommerce_before_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     */
    do_action('woocommerce_before_main_content');
    ?>

    <?php while (have_posts()): ?>
        <?php the_post(); ?>

        <?php wc_get_template_part('content', 'single-product'); ?>

    <?php endwhile; // end of the loop. ?>

    <?php
    /**
     * woocommerce_after_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action('woocommerce_after_main_content');
    ?>

    <?php
    /**
     * woocommerce_sidebar hook.
     *
     * @hooked woocommerce_get_sidebar - 10
     */
    do_action('woocommerce_sidebar');
    ?>
    <div class="overlay_section transition-all duration-300"></div>

    <?php
    wp_enqueue_script('single_script');
    ?>
    <script src="<?php echo get_template_directory_uri() . '/assets/js/swiper-bundle.min.js'; ?>"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            //   loop: true,
            slidesPerView: 4,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: ".next-gallery",
                prevEl: ".prev-gallery",
            },
            thumbs: {
                swiper: swiper,
            },
        });
    </script>
<?php
get_footer('shop');