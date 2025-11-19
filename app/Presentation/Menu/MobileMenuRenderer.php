<?php

namespace IdealBoresh\Presentation\Menu;

class MobileMenuRenderer
{
    /**
     * @param array<int, array<string, mixed>> $items
     */
    public static function render(array $items): void
    {
        echo '<ul class="font-sansFanumBold mt-12 px-4 parent__item__menu">';
        foreach ($items as $item) {
            self::renderItem($item, false);
        }
        echo '</ul>';
    }

    /**
     * @param array<string, mixed> $item
     */
    private static function renderItem(array $item, bool $isNested): void
    {
        $hasChildren = !empty($item['children']);
        $classes = ['item__menu__mobile', 'border-b-2', 'border-zinc-200'];
        if (!$isNested) {
            $classes[] = 'w-full';
        }
        if ($hasChildren) {
            $classes[] = 'has__subMenu';
        }

        printf('<li class="%s">', esc_attr(implode(' ', $classes)));
        echo '<div class="flex items-center justify-between text-zinc-700 py-3">';
        printf('<a href="%s">%s</a>', esc_url($item['url'] ?? '#'), esc_html($item['title'] ?? ''));

        if ($hasChildren) {
            echo '<div><svg class="w-6 h-6 text-mainBlue"><use href="#chevron-left"></use></svg></div>';
        }

        echo '</div>';

        if ($hasChildren) {
            echo '<ul class="parent__item__menu font-sansFanumBold mt-12 px-4 hidden">';
            foreach ($item['children'] as $child) {
                self::renderItem($child, true);
            }
            echo '</ul>';
        }

        echo '</li>';
    }
}
