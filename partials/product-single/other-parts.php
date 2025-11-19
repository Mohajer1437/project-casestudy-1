<?php

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

// logic attribute

remove_action('woocommerce_product_additional_information', 'wc_display_product_attributes', 10);
add_action('woocommerce_product_additional_information', 'custom_product_attribute', 10);

function custom_product_attribute() {
    global $product;

    // همهٔ ویژگی‌ها را بگیر
    $attributes = $product->get_attributes();

    // تنظیمات گروه‌بندی شده از تنظیمات سایت
    $group_attributes = get_option( 'group_attributes', [] );
    if ( ! is_array( $group_attributes ) ) {
        $group_attributes = [];
    }

    $grouped_attributes = [];
    $other_attributes   = [];

    // یک بار به ازای هر ویژگی محصول
    foreach ( $attributes as $attribute ) {
        $taxonomy = $attribute->get_name();

        // تشخیص نوع اتربیوت و گرفتن گزینه‌ها
        if ( $attribute->is_taxonomy() ) {
            // taxonomy-based attribute: تبدیل ID ترم‌ها به نام ترم
            $options = wc_get_product_terms(
                $product->get_id(),
                $taxonomy,
                [ 'fields' => 'names' ]
            );
        } else {
            // custom attribute: خود رشته‌های واردشده
            $options = $attribute->get_options();
        }

        // حذف موارد خالی
        $options = array_filter( $options, 'strlen' );

        // آماده‌سازی برچسب و مقدار
        $label = wc_attribute_label( $taxonomy );
        $value = implode( ', ', $options );

        // قرار دادن در آرایه‌های گروه‌بندی شده یا سایر
        $found = false;
        foreach ( $group_attributes as $group ) {
            if (
                ! empty( $group['name'] ) &&
                ! empty( $group['tags'] ) &&
                is_array( $group['tags'] ) &&
                in_array( $taxonomy, $group['tags'], true )
            ) {
                $grouped_attributes[ $group['name'] ][] = [
                    'label' => $label,
                    'value' => $value,
                ];
                $found = true;
                break;
            }
        }

        if ( ! $found ) {
            $other_attributes[] = [
                'label' => $label,
                'value' => $value,
            ];
        }
    }

    // خروجی HTML
    echo '<div class="mt-12 lg:mt-8 pb-6 lg:pb-8 text-black">';

    // نمایش گروه‌های تعریف‌شده
    foreach ( $grouped_attributes as $group_name => $attrs ) {
        echo "<h3 class='m-y-2 col-span-2 lg:col-span-5 font-bold text-lg mt-4'>{$group_name}</h3>";
        echo '<div class="gap-x-[10px] gap-y-[12px] grid grid-cols-2 lg:grid-cols-5">';
        foreach ( $attrs as $attr ) {
            echo '<div class="px-4 py-3 bg-nili-100 rounded-[10px] lg:col-span-2 text-xs">'
                . esc_html( $attr['label'] ) .
                '</div>';
            echo '<div class="px-4 py-3 bg-nili-100 lg:col-span-3 rounded-[10px] text-xs">'
                . esc_html( $attr['value'] ) .
                '</div>';
        }
        echo '</div>';
    }

    // نمایش سایر ویژگی‌ها
    if ( ! empty( $other_attributes ) ) {
        echo "<h3 class='m-y-2 col-span-2 lg:col-span-5 font-bold text-lg mt-4'>سایر ویژگی‌ها</h3>";
        echo '<div class="gap-x-[10px] gap-y-[12px] grid grid-cols-2 lg:grid-cols-5">';
        foreach ( $other_attributes as $attr ) {
            echo '<div class="px-4 py-3 bg-nili-100 rounded-[10px] lg:col-span-2 text-xs">'
                . esc_html( $attr['label'] ) .
                '</div>';
            echo '<div class="px-4 py-3 bg-nili-100 lg:col-span-3 rounded-[10px] text-xs">'
                . esc_html( $attr['value'] ) .
                '</div>';
        }
        echo '</div>';
    }

    echo '</div>';
}



// remove comments from tab bar

add_filter('woocommerce_product_tabs', 'delete_comments_from_tabs');
function delete_comments_from_tabs($tabs)
{
    unset($tabs['reviews']);
    return $tabs;
}


function custom_comment_redirect($location)
{
    if (!is_admin()) {
        $location = add_query_arg('comment_status', 'waiting', $location);
    }
    return $location;
}
add_filter('comment_post_redirect', 'custom_comment_redirect');

function can_current_user_approve_comments()
{
    return current_user_can('moderate_comments');
}

function allow_admin_comments($open, $post_id)
{
    if (current_user_can('moderate_comments')) {
        return true;
    }
    return $open;
}
add_filter('comments_open', 'allow_admin_comments', 10, 2);



add_action('woocommerce_after_single_product_summary', 'custom_hook_content_layout', 12);

function custom_hook_content_layout()
{

    get_template_part('partials/product-single/thecontent', 'product');
}