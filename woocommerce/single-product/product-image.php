<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns        = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
<div class="col-span-2 px-5 space-y-8" data-columns="<?php echo esc_attr( $columns ); ?>">
        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 w-[400px] h-[200px] lg:mb-8">
            <div class="swiper-wrapper">
		<?php
        if ( $attachment_ids && $product->get_image_id() ) {
            foreach ( $attachment_ids as $key => $attachment_id ) {
                /**
                 * Filter product image thumbnail HTML string.
                 *
                 * @since 1.6.4
                 *
                 * @param string $html          Product image thumbnail HTML string.
                 * @param int    $attachment_id Attachment ID.
                 */
                echo '<div class="swiper-slide"><img class="rounded-xl" src='.wp_get_attachment_url($attachment_id ).'></div>';
            }
        } else {
			$wrapper_classname = $product->is_type( 'variable' ) && ! empty( $product->get_available_variations( 'image' ) ) ?
				'woocommerce-product-gallery__image woocommerce-product-gallery__image--placeholder' :
				'woocommerce-product-gallery__image--placeholder';
			$html              = sprintf( '<div class="%s">', esc_attr( $wrapper_classname ) );
			$html             .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html             .= '</div>';
		}

//		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

//		do_action( 'woocommerce_product_thumbnails' );
		?>
            </div>
            <div class="next-gallery set-arrow-right-gallery z-50 cursor-pointer right-0">
                <svg class="w-7 h-7">
                    <use href="#redarrowright"></use>
                </svg>
            </div>

            <div class="prev-gallery set-arrow-left-gallery z-50 cursor-pointer">
                <svg class="w-7 h-7">
                    <use href="#redarrowleft"></use>
                </svg>
            </div>

<!--            <div class="absolute top-[5%] right-[5%] bg-[#D0082C] z-50 px-3 py-2 rounded-xl">-->
<!--                <p class="font-sansFanumBold text-white">15%</p>-->
<!--            </div>-->
        </div>
        <?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>
