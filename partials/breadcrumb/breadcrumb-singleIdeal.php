<?php
/**
 * The template for displaying breadcrumb
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="lg:w-[90%] mx-auto bg-white rounded-xl mt-[110px] lg:mt-0">
        <div class="container lg:px-10 mx-auto lg:mt-7 mt-4 px-5  gap-x-2 space-y-2 overflow-x-auto  py-2 lg:py-4 rounded-xl text-wrap">
            <?php woocommerce_breadcrumb(); ?>
        </div>
</div>