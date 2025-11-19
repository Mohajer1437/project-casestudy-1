<?php

namespace IdealBoresh\Services\WooCommerce;

use WP_Term;

class ProductCategoryMetaService implements ProductCategoryMetaInterface
{
    /** @var string[] */
    private array $brandTaxonomies = ['product_brand', 'pwb-brand', 'yith_product_brand'];

    public function register(): void
    {
        add_action('admin_footer', [$this, 'hideDefaultDescription']);
        add_action('product_cat_edit_form_fields', [$this, 'renderFullDescriptionField'], 5, 2);
        add_action('edited_product_cat', [$this, 'saveFullDescription'], 10, 2);

        add_action('product_cat_add_form_fields', [$this, 'renderCategoryShortDescriptionAddField'], 10, 1);
        add_action('product_cat_edit_form_fields', [$this, 'renderCategoryShortDescriptionEditField'], 10, 2);
        add_action('created_product_cat', [$this, 'saveCategoryShortDescription'], 10, 2);
        add_action('edited_product_cat', [$this, 'saveCategoryShortDescription'], 10, 2);

        add_action('product_cat_edit_form_fields', [$this, 'renderFaqField'], 30, 2);
        add_action('edited_product_cat', [$this, 'saveFaqField'], 30, 2);

        add_action('init', [$this, 'registerBrandShortDescriptionHooks'], 20);
    }

    public function hideDefaultDescription(): void
    {
        if (!is_admin()) {
            return;
        }

        $taxonomy = filter_input(INPUT_GET, 'taxonomy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($taxonomy !== 'product_cat') {
            return;
        }
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var wrapper = document.querySelector('.term-description-wrap');
                if (wrapper) {
                    wrapper.remove();
                }
            });
        </script>
        <?php
    }

    public function renderFullDescriptionField(WP_Term $term, string $taxonomy): void
    {
        unset($taxonomy);
        $value = (string) get_term_meta($term->term_id, 'full_description', true);
        wp_nonce_field('save_full_description_nonce', 'full_description_nonce');
        ?>
        <tr class="form-field term-full-description-wrap">
            <th scope="row">
                <label for="full_description"><?php esc_html_e('توضیحات کامل'); ?></label>
            </th>
            <td>
                <?php
                wp_editor(
                    wp_kses_post(htmlspecialchars_decode($value)),
                    'full_description',
                    [
                        'textarea_name' => 'full_description',
                        'editor_height' => 200,
                        'media_buttons' => true,
                        'teeny'         => false,
                    ]
                );
                ?>
            </td>
        </tr>
        <?php
    }

    public function saveFullDescription(int $termId, int $ttId = 0): void
    {
        unset($ttId);
        if (!$this->isNonceValid('full_description_nonce', 'save_full_description_nonce')) {
            return;
        }

        if (isset($_POST['full_description'])) {
            update_term_meta(
                $termId,
                'full_description',
                wp_kses_post(wp_unslash($_POST['full_description']))
            );
        }
    }

    public function renderCategoryShortDescriptionAddField(string $taxonomy): void
    {
        unset($taxonomy);
        wp_nonce_field('save_category_short_description', 'category_short_description_nonce');
        ?>
        <div class="form-field">
            <label for="category_short_description"><?php esc_html_e('توضیح کوتاه', 'atrinplus'); ?></label>
            <?php
            wp_editor(
                '',
                'category_short_description',
                [
                    'textarea_name' => 'category_short_description',
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    'teeny'         => true,
                ]
            );
            ?>
            <p class="description"><?php esc_html_e('یک توضیح کوتاه برای این دسته‌بندی وارد کنید.', 'atrinplus'); ?></p>
        </div>
        <?php
    }

    public function renderCategoryShortDescriptionEditField(WP_Term $term, string $taxonomy): void
    {
        unset($taxonomy);
        $shortDescription = (string) get_term_meta($term->term_id, 'category_short_description', true);
        wp_nonce_field('save_category_short_description', 'category_short_description_nonce');
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="category_short_description"><?php esc_html_e('توضیح کوتاه', 'atrinplus'); ?></label>
            </th>
            <td>
                <?php
                wp_editor(
                    wp_kses_post($shortDescription),
                    'category_short_description',
                    [
                        'textarea_name' => 'category_short_description',
                        'media_buttons' => false,
                        'textarea_rows' => 5,
                        'teeny'         => true,
                    ]
                );
                ?>
                <p class="description"><?php esc_html_e('یک توضیح کوتاه برای این دسته‌بندی وارد کنید.', 'atrinplus'); ?></p>
            </td>
        </tr>
        <?php
    }

    public function saveCategoryShortDescription(int $termId, int $ttId = 0): void
    {
        unset($ttId);
        if (!$this->isNonceValid('category_short_description_nonce', 'save_category_short_description')) {
            return;
        }

        if (isset($_POST['category_short_description'])) {
            update_term_meta(
                $termId,
                'category_short_description',
                wp_kses_post(wp_unslash($_POST['category_short_description']))
            );
        }
    }

    public function renderFaqField(WP_Term $term, string $taxonomy): void
    {
        unset($taxonomy);
        $categoryFaqs = get_term_meta($term->term_id, 'product_category_faqs', true);
        if (!is_array($categoryFaqs)) {
            $categoryFaqs = [];
        }
        wp_nonce_field('save_product_category_faqs', 'category_faq_nonce');
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="product_category_faqs"><?php esc_html_e('سوالات متداول', 'atrinplus'); ?></label></th>
            <td>
                <div id="product_category_faqs_container">
                    <?php foreach ($categoryFaqs as $index => $faq) :
                        $question = isset($faq['question']) ? sanitize_text_field($faq['question']) : '';
                        $answer   = isset($faq['answer']) ? wp_kses_post($faq['answer']) : '';
                        ?>
                        <div class="category-faq-item">
                            <input type="text" class="category-faq-question" name="product_category_faqs[<?php echo esc_attr((string) $index); ?>][question]" placeholder="سوال" value="<?php echo esc_attr($question); ?>" style="width:100%; margin-bottom:5px;" />
                            <textarea class="category-faq-answer" name="product_category_faqs[<?php echo esc_attr((string) $index); ?>][answer]" placeholder="پاسخ" rows="3" style="width:100%;"><?php echo esc_textarea($answer); ?></textarea>
                            <input type="button" class="button remove-category-faq-item" value="<?php esc_attr_e('حذف', 'atrinplus'); ?>" /><br><br>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="button" id="add-category-faq-button" class="button" value="<?php esc_attr_e('افزودن سوال', 'atrinplus'); ?>" />
            </td>
        </tr>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var container = document.getElementById('product_category_faqs_container');
                var addButton = document.getElementById('add-category-faq-button');
                if (!container || !addButton) {
                    return;
                }

                addButton.addEventListener('click', function () {
                    var index = container.querySelectorAll('.category-faq-item').length;
                    var template = <?php echo wp_json_encode($this->getFaqTemplate()); ?>;
                    var html = template.replace(/__index__/g, index);
                    container.insertAdjacentHTML('beforeend', html);
                });

                container.addEventListener('click', function (event) {
                    if (event.target && event.target.classList.contains('remove-category-faq-item')) {
                        var parent = event.target.closest('.category-faq-item');
                        if (parent) {
                            parent.remove();
                        }
                    }
                });
            });
        </script>
        <?php
    }

    public function saveFaqField(int $termId, int $ttId = 0): void
    {
        unset($ttId);
        if (!$this->isNonceValid('category_faq_nonce', 'save_product_category_faqs')) {
            return;
        }

        if (!isset($_POST['product_category_faqs']) || !is_array($_POST['product_category_faqs'])) {
            delete_term_meta($termId, 'product_category_faqs');
            return;
        }

        $faqs = [];
        foreach ($_POST['product_category_faqs'] as $faq) {
            if (!is_array($faq)) {
                continue;
            }
            $question = isset($faq['question']) ? sanitize_text_field(wp_unslash($faq['question'])) : '';
            $answer   = isset($faq['answer']) ? wp_kses_post(wp_unslash($faq['answer'])) : '';
            if ($question === '' && $answer === '') {
                continue;
            }
            $faqs[] = [
                'question' => $question,
                'answer'   => $answer,
            ];
        }

        if (!empty($faqs)) {
            update_term_meta($termId, 'product_category_faqs', $faqs);
        } else {
            delete_term_meta($termId, 'product_category_faqs');
        }
    }

    public function registerBrandShortDescriptionHooks(): void
    {
        foreach ($this->brandTaxonomies as $taxonomy) {
            if (!taxonomy_exists($taxonomy)) {
                continue;
            }

            add_action("{$taxonomy}_add_form_fields", [$this, 'renderBrandShortDescriptionAddField'], 10, 1);
            add_action("created_{$taxonomy}", [$this, 'saveBrandShortDescription'], 10, 2);
            add_action("{$taxonomy}_edit_form_fields", [$this, 'renderBrandShortDescriptionEditField'], 10, 2);
            add_action("edited_{$taxonomy}", [$this, 'saveBrandShortDescription'], 10, 2);
        }
    }

    public function renderBrandShortDescriptionAddField(string $taxonomy): void
    {
        unset($taxonomy);
        wp_nonce_field('save_brand_short_description', 'brand_short_description_nonce');
        ?>
        <div class="form-field">
            <label for="brand_short_description"><?php esc_html_e('توضیح کوتاه برند', 'atrinplus'); ?></label>
            <?php
            wp_editor(
                '',
                'brand_short_description',
                [
                    'textarea_name' => 'brand_short_description',
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    'teeny'         => true,
                ]
            );
            ?>
            <p class="description"><?php esc_html_e('یک توضیح کوتاه برای این برند وارد کنید.', 'atrinplus'); ?></p>
        </div>
        <?php
    }

    public function renderBrandShortDescriptionEditField(WP_Term $term, string $taxonomy): void
    {
        unset($taxonomy);
        $shortDescription = (string) get_term_meta($term->term_id, 'brand_short_description', true);
        wp_nonce_field('save_brand_short_description', 'brand_short_description_nonce');
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="brand_short_description"><?php esc_html_e('توضیح کوتاه برند', 'atrinplus'); ?></label>
            </th>
            <td>
                <?php
                wp_editor(
                    wp_kses_post($shortDescription),
                    'brand_short_description',
                    [
                        'textarea_name' => 'brand_short_description',
                        'media_buttons' => false,
                        'textarea_rows' => 5,
                        'teeny'         => true,
                    ]
                );
                ?>
                <p class="description"><?php esc_html_e('یک توضیح کوتاه برای این برند وارد کنید.', 'atrinplus'); ?></p>
            </td>
        </tr>
        <?php
    }

    public function saveBrandShortDescription(int $termId, int $ttId = 0): void
    {
        unset($ttId);
        if (!$this->isNonceValid('brand_short_description_nonce', 'save_brand_short_description')) {
            return;
        }

        if (isset($_POST['brand_short_description'])) {
            update_term_meta(
                $termId,
                'brand_short_description',
                wp_kses_post(wp_unslash($_POST['brand_short_description']))
            );
        }
    }

    private function getFaqTemplate(): string
    {
        return '<div class="category-faq-item">'
            . '<input type="text" class="category-faq-question" name="product_category_faqs[__index__][question]" placeholder="سوال" style="width:100%; margin-bottom:5px;" />'
            . '<textarea class="category-faq-answer" name="product_category_faqs[__index__][answer]" placeholder="پاسخ" rows="3" style="width:100%;"></textarea>'
            . '<input type="button" class="button remove-category-faq-item" value="' . esc_attr__('حذف', 'atrinplus') . '" /><br><br>'
            . '</div>';
    }

    private function isNonceValid(string $field, string $action): bool
    {
        if (!isset($_POST[$field])) {
            return false;
        }

        $nonce = wp_unslash($_POST[$field]);
        return (bool) wp_verify_nonce($nonce, $action);
    }
}
