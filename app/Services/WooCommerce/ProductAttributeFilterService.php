<?php

namespace IdealBoresh\Services\WooCommerce;

class ProductAttributeFilterService implements ProductAttributeFilterInterface
{
    private const FILTER_HOOK = 'idealboresh/archive/popular_attributes';
    private const CACHE_GROUP = 'idealboresh_archive_attributes';

    public function register(): void
    {
        add_filter(self::FILTER_HOOK, [$this, 'getPopularAttributes'], 10, 3);
    }

    /**
     * @param array<int|string, mixed> $attributes
     * @return array<string, array<int, array{id:int,name:string}>>
     */
    public function getPopularAttributes(array $attributes, int $categoryId, int $minProducts = 4): array
    {
        if ($categoryId <= 0) {
            return [];
        }

        $minProducts = max(1, $minProducts);
        $cacheKey = sprintf('%d_%d', $categoryId, $minProducts);
        $cached = wp_cache_get($cacheKey, self::CACHE_GROUP);
        if (is_array($cached)) {
            return $cached;
        }

        $termIds = $this->getTermIds($categoryId);
        if (empty($termIds)) {
            wp_cache_set($cacheKey, [], self::CACHE_GROUP, HOUR_IN_SECONDS);
            return [];
        }

        $taxonomies = $this->queryAttributeTaxonomies($termIds, $minProducts);
        if (empty($taxonomies)) {
            wp_cache_set($cacheKey, [], self::CACHE_GROUP, HOUR_IN_SECONDS);
            return [];
        }

        $results = [];
        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => true,
            ]);
            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            $results[$taxonomy] = array_map(
                static function ($term): array {
                    return [
                        'id'   => (int) $term->term_id,
                        'name' => $term->name,
                    ];
                },
                $terms
            );
        }

        wp_cache_set($cacheKey, $results, self::CACHE_GROUP, HOUR_IN_SECONDS);

        return $results;
    }

    /**
     * @return int[]
     */
    private function getTermIds(int $categoryId): array
    {
        $termIds = [$categoryId];
        $children = get_terms([
            'taxonomy'   => 'product_cat',
            'child_of'   => $categoryId,
            'fields'     => 'ids',
            'hide_empty' => false,
        ]);

        if (!is_wp_error($children) && !empty($children)) {
            $termIds = array_merge($termIds, array_map('absint', $children));
        }

        $termIds = array_map('absint', $termIds);
        $termIds = array_filter($termIds, static fn (int $id): bool => $id > 0);

        return array_values(array_unique($termIds));
    }

    /**
     * @param int[] $termIds
     * @return string[]
     */
    private function queryAttributeTaxonomies(array $termIds, int $minProducts): array
    {
        global $wpdb;

        $termIdsString = implode(',', array_map('absint', $termIds));
        if ($termIdsString === '') {
            return [];
        }

        $query = "
            SELECT tax.taxonomy
            FROM {$wpdb->posts} AS p
            INNER JOIN {$wpdb->term_relationships} AS cat_rel ON p.ID = cat_rel.object_id
            INNER JOIN {$wpdb->term_taxonomy} AS cat_tax ON cat_rel.term_taxonomy_id = cat_tax.term_taxonomy_id
            INNER JOIN {$wpdb->term_relationships} AS attr_rel ON p.ID = attr_rel.object_id
            INNER JOIN {$wpdb->term_taxonomy} AS tax ON attr_rel.term_taxonomy_id = tax.term_taxonomy_id
            WHERE p.post_type = 'product'
              AND p.post_status = 'publish'
              AND cat_tax.taxonomy = 'product_cat'
              AND cat_tax.term_id IN ($termIdsString)
              AND tax.taxonomy LIKE 'pa_%'
            GROUP BY tax.taxonomy
            HAVING COUNT(DISTINCT p.ID) >= %d
        ";

        $prepared = $wpdb->prepare($query, $minProducts);
        if (!$prepared) {
            return [];
        }

        $rows = $wpdb->get_col($prepared);
        if (empty($rows)) {
            return [];
        }

        return array_map('sanitize_key', $rows);
    }
}
