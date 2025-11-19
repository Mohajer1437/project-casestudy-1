<?php
remove_action('woocommerce_before_main_content','woocommerce_output_content_wrapper',10);
remove_action('woocommerce_after_main_content','woocommerce_output_content_wrapper_end',10);
remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);
/**
 * Change several of the breadcrumb defaults
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '<div><svg class="w-[17px] h-[17px]"><use href="#arrowleftbread"></use></svg></div>',
        'wrap_before' => '<nav class="woocommerce-bread-single-custom inline-flex items-center gap-x-1 font-sansRegular " itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '<div class="text-zinc-600 mx-1">',
        'after'       => '</div>',
        'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
    );
}
add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs', 20 );
