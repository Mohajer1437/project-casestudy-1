<?php

namespace IdealBoresh\Presentation\Menu;

use Walker_Nav_Menu;

class FooterUsefulLinksWalker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0): void
    {
        $title = isset($item->title) ? wp_strip_all_tags($item->title) : '';
        $url   = isset($item->url) ? esc_url($item->url) : '#';

        $classAttr = 'hover:text-white transition-colors duration-150';

        $output .= sprintf('<a class="%s" href="%s">%s</a>', esc_attr($classAttr), $url, esc_html($title));
    }
}
