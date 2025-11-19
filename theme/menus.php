<?php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= "\n<ul class=\"parent__item__menu font-sansFanumBold mt-12 px-4 hidden\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= "</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $has_children = in_array('menu-item-has-children', (array) $item->classes) ? 'has__subMenu' : '';
        
        $output .= '<li class="item__menu__mobile ' . $has_children . ' border-b-2 border-zinc-200 w-full">';
        $output .= '<div class="flex items-center justify-between text-zinc-700 py-3">';
        $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
        
        if ($has_children) {
            $output .= '<div><svg class="w-6 h-6 text-mainBlue"><use href="#chevron-left"></use></svg></div>';
        }

        $output .= '</div>';
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

class Footer_Useful_Links_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        // برای شروع زیرمنو، اگر نیازی به آن ندارید، می‌توانید این متد را خالی بگذارید
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        // پایان زیرمنو
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        // ساخت لینک‌ها به صورت مورد نظر
        $output .= '<a href="' . esc_url($item->url) . '" target="_blank">' . esc_html($item->title) . '</a>';
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        // نیازی به بستن تگ <li> نداریم چون <a> خارج از <li> قرار می‌دهیم
    }
}
