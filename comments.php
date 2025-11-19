<?php
/**
 * The template for displaying comments
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            printf(
                _nx('یک دیدگاه', '%1$s دیدگاه', get_comments_number(), 'comments title'),
                number_format_i18n(get_comments_number())
            );
            ?>
        </h3>

        <ul class="comment-list">
            <?php
            wp_list_comments([
                'callback' => 'custom_comments_list',
                'style'    => 'ul',
                'max_depth' => 3
            ]);
            ?>
        </ul>

        <?php if (get_comment_pages_count() > 1) : ?>
            <nav class="comment-navigation">
                <?php paginate_comments_links(); ?>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open()) : ?>
        <p class="no-comments">ارسال دیدگاه بسته شده است.</p>
    <?php endif; ?>

    <?php comment_form(); ?>
</div>