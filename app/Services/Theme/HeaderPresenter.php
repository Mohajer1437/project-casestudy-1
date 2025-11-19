<?php

namespace IdealBoresh\Services\Theme;

use IdealBoresh\Domain\Settings\OptionRepositoryInterface;

class HeaderPresenter implements HeaderPresenterInterface
{
    public function __construct(private OptionRepositoryInterface $options)
    {
    }

    public function buildContext(): array
    {
        $menuData = $this->buildMenuData();

        return [
            'logo'        => [
                'url' => (string) get_theme_mod('theme_logo'),
                'alt' => get_bloginfo('name'),
            ],
            'site_name'   => get_bloginfo('name'),
            'cart_count'  => $this->resolveCartCount(),
            'home_url'    => home_url('/'),
            'account_url' => home_url('/my-account'),
            'cart_url'    => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart'),
            'phone'       => $this->sanitizePhone($this->options->get('header_phone_number', '')),
            'nav_items'   => $menuData['items'],
            'nav_panels'  => $menuData['panels'],
            'mobile_menu' => $menuData['tree'],
        ];
    }

    private function resolveCartCount(): int
    {
        if (function_exists('WC')) {
            $cart = WC()->cart ?? null;
            if ($cart) {
                return (int) $cart->get_cart_contents_count();
            }
        }

        return 0;
    }

    private function sanitizePhone($phone): array
    {
        $raw = is_string($phone) ? trim($phone) : '';
        $digits = preg_replace('/[^0-9+]/', '', $raw);

        return [
            'display' => $raw,
            'href'    => $digits ? 'tel:' . $digits : '',
        ];
    }

    /**
     * @return array{items: array<int, array<string, mixed>>, panels: array<int, array<string, mixed>>, tree: array<int, array<string, mixed>>}
     */
    private function buildMenuData(): array
    {
        $locations = get_nav_menu_locations();
        $locationKey = 'header-mega-menu';

        if (!isset($locations[$locationKey])) {
            return ['items' => [], 'panels' => [], 'tree' => []];
        }

        $menuItems = wp_get_nav_menu_items($locations[$locationKey]);

        if (empty($menuItems)) {
            return ['items' => [], 'panels' => [], 'tree' => []];
        }

        $tree = $this->buildTree($menuItems);
        [$items, $panels] = $this->transformTreeToNavigation($tree);

        return [
            'items'  => $items,
            'panels' => $panels,
            'tree'   => $tree,
        ];
    }

    /**
     * @param array<int, \WP_Post> $items
     * @return array<int, array<string, mixed>>
     */
    private function buildTree(array $items): array
    {
        $grouped = [];
        foreach ($items as $item) {
            $parentId = (int) ($item->menu_item_parent ?? 0);
            $grouped[$parentId][] = $item;
        }

        return $this->buildTreeLevel($grouped, 0);
    }

    /**
     * @param array<int, array<int, \WP_Post>> $grouped
     * @return array<int, array<string, mixed>>
     */
    private function buildTreeLevel(array $grouped, int $parentId): array
    {
        if (!isset($grouped[$parentId])) {
            return [];
        }

        $branch = [];
        foreach ($grouped[$parentId] as $item) {
            $branch[] = [
                'id'       => (int) $item->ID,
                'title'    => $item->title ?? '',
                'url'      => $item->url ?? '',
                'children' => $this->buildTreeLevel($grouped, (int) $item->ID),
            ];
        }

        return $branch;
    }

    /**
     * @param array<int, array<string, mixed>> $tree
     * @return array{0: array<int, array<string, mixed>>, 1: array<int, array<string, mixed>>}
     */
    private function transformTreeToNavigation(array $tree): array
    {
        $items = [];
        $panels = [];
        $counter = 1;

        foreach ($tree as $node) {
            $panelId = null;
            if (!empty($node['children'])) {
                $panelId = 'menu' . $counter++;
                $panels[] = [
                    'panel_id' => $panelId,
                    'columns'  => $this->buildPanelColumns($node['children']),
                ];
            }

            $items[] = [
                'id'           => $node['id'],
                'title'        => $node['title'],
                'url'          => $node['url'],
                'panel_id'     => $panelId,
                'has_children' => !empty($node['children']),
            ];
        }

        return [$items, $panels];
    }

    /**
     * @param array<int, array<string, mixed>> $children
     * @return array<int, array<string, mixed>>
     */
    private function buildPanelColumns(array $children): array
    {
        $columns = [];
        foreach ($children as $child) {
            $columns[] = [
                'title' => $child['title'],
                'url'   => $child['url'],
                'links' => array_map(static function (array $item): array {
                    return [
                        'title' => $item['title'],
                        'url'   => $item['url'],
                    ];
                }, $child['children'] ?? []),
            ];
        }

        return $columns;
    }
}
