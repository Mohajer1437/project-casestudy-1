<?php get_header(); ?>


<body dir="rtl">
    <svg class="hidden">
        <symbol id="Magnifer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none">
            <g clip-path="url(#clip0_24_99)">
                <circle cx="9.62496" cy="9.62499" r="8.70833" stroke="white" stroke-width="2" />
                <path opacity="0.5" d="M18.3334 18.3333L20.1667 20.1667" stroke="white" stroke-width="2.5"
                    stroke-linecap="round" />
            </g>
            <defs>
                <clipPath id="clip0_24_99">
                    <rect width="22" height="22" fill="white" />
                </clipPath>
            </defs>
        </symbol>
        <symbol id="User" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
            <ellipse cx="14" cy="7.00001" rx="4.66667" ry="4.66667" fill="#1F41A4" />
            <path
                d="M23.3333 20.4167C23.3333 23.3162 23.3333 25.6667 14 25.6667C4.66663 25.6667 4.66663 23.3162 4.66663 20.4167C4.66663 17.5172 8.8453 15.1667 14 15.1667C19.1546 15.1667 23.3333 17.5172 23.3333 20.4167Z"
                fill="#C5D4FF" />
        </symbol>
        <symbol id="cartCheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" fill="none">
            <path
                d="M26.2993 2.30753C26.1266 1.79284 25.5884 1.5223 25.0973 1.70325L24.7184 1.84282C23.9435 2.12828 23.2853 2.37073 22.7673 2.63705C22.2135 2.92182 21.7385 3.27262 21.3813 3.82036C21.0269 4.36386 20.8806 4.96014 20.813 5.61393C20.7828 5.9066 20.7668 6.23053 20.7584 6.58659H7.38671C5.26881 6.58659 3.36228 6.58659 2.80427 7.34668C2.24626 8.10676 2.46441 9.25204 2.90072 11.5426L3.52889 14.7362C3.92498 16.75 4.12303 17.7568 4.81651 18.349C5.51 18.9412 6.49106 18.9412 8.45319 18.9412H15.1187C18.6242 18.9412 20.3769 18.9412 21.466 17.7376C22.555 16.5339 22.6345 15.2553 22.6345 11.3809L22.6345 7.95418C22.6345 6.97958 22.6358 6.32732 22.6875 5.82655C22.7369 5.34797 22.8245 5.10901 22.938 4.93504C23.0487 4.76531 23.2167 4.60669 23.5978 4.41073C24.0036 4.20208 24.5551 3.99721 25.3943 3.68805L25.7226 3.5671C26.2138 3.38614 26.472 2.82222 26.2993 2.30753Z"
                fill="#C5D4FF" />
            <path
                d="M17.0153 10.6822C17.4002 10.298 17.3846 9.68983 16.9804 9.32388C16.5762 8.95793 15.9365 8.97277 15.5515 9.35701L12.4331 12.4696L11.6249 11.6629C11.2399 11.2786 10.6002 11.2638 10.196 11.6298C9.79178 11.9957 9.77618 12.6039 10.1611 12.9881L11.7012 14.5254C11.892 14.7158 12.1565 14.8235 12.4331 14.8235C12.7097 14.8235 12.9742 14.7158 13.165 14.5254L17.0153 10.6822Z"
                fill="#1F41A4" />
            <circle cx="10.2942" cy="22.647" r="2.05882" fill="#1F41A4" />
            <circle cx="17.7059" cy="22.647" r="2.05882" fill="#1F41A4" />
        </symbol>
        <symbol id="phone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none">
            <path
                d="M6.03759 1.31617L6.6866 2.4791C7.2723 3.52858 7.03718 4.90532 6.11471 5.8278C6.11471 5.8278 6.11471 5.8278 6.11471 5.8278C6.11459 5.82792 4.99588 6.94685 7.02451 8.97548C9.05248 11.0035 10.1714 9.8861 10.1722 9.88529C10.1722 9.88527 10.1722 9.88528 10.1722 9.88525C11.0947 8.96281 12.4714 8.7277 13.5209 9.31339L14.6838 9.96241C16.2686 10.8468 16.4557 13.0692 15.0628 14.4622C14.2258 15.2992 13.2004 15.9505 12.0669 15.9934C10.1588 16.0658 6.91828 15.5829 3.6677 12.3323C0.417128 9.08172 -0.0657854 5.84122 0.00655165 3.93309C0.0495219 2.7996 0.700803 1.77423 1.53781 0.937232C2.93076 -0.455718 5.15317 -0.268563 6.03759 1.31617Z"
                fill="white" />
        </symbol>
    </svg>

    <?php
    // شروع حلقه وردپرس برای نمایش محتوای صفحه
    if (have_posts()):
        while (have_posts()):
            the_post();

            ?>
            <main id="main-content" class="site-main">
                <?php
                function custom_breadcrumb()
                {
                    if (!is_front_page()) {
                        echo '<div class="container lg:px-10 mx-auto lg:mt-7 mt-4 px-5 gap-x-2 space-y-2 overflow-x-auto py-2 lg:py-4 rounded-xl text-wrap">';
                        echo '<div class="inline-flex items-center gap-x-1">';
                        echo '<a href="' . home_url() . '" class="font-sansRegular text-zinc-600">صفحه اصلی</a>';
                        echo '<div><svg class="w-[17px] h-[17px]"><use href="#arrowleftbread"></use></svg></div>';
                        echo '</div>';

                        if (is_page()) {
                            $post_ancestors = get_post_ancestors(get_the_ID());
                            if (!empty($post_ancestors)) {
                                foreach (array_reverse($post_ancestors) as $ancestor) {
                                    echo '<div class="inline-flex items-center gap-x-1">';
                                    echo '<a href="' . get_permalink($ancestor) . '" class="font-sansRegular text-zinc-600">' . get_the_title($ancestor) . '</a>';
                                    echo '<div><svg class="w-[17px] h-[17px]"><use href="#arrowleftbread"></use></svg></div>';
                                    echo '</div>';
                                }
                            }
                            echo '<div class="inline-flex items-center gap-x-1">';
                            echo '<p class="font-sansRegular text-mainBlue">' . get_the_title() . '</p>';
                            echo '</div>';
                        }

                        echo '</div>';
                    }
                }
                custom_breadcrumb();

                ?>
                <div class="container">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>




                        <div class="entry-content">
                            <?php
                            // نمایش محتوای اصلی صفحه
                            the_content();

                            // نمایش صفحات مرتبط با محتوا (در صورت تقسیم‌بندی محتوا با <!--nextpage--> )
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'atrinplus'),
                                'after' => '</div>',
                            ));
                            ?>
                        </div>
                    </article>
                </div>
            </main>
            <?php
        endwhile;
    else:
        // پیام در صورت نبود محتوا
        echo '<p>' . esc_html__('محتوا موجود نیست.', 'idealboresh') . '</p>';
    endif;
    ?>


    <?php
    get_footer();