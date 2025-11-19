<?php

namespace IdealBoresh\Application\Cart;

use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Domain\Cart\CartServiceInterface;

class AddProductToCartAction implements RegistersHooks
{
    public const NONCE_ACTION = 'ideal_add_to_cart';

    public function __construct(private CartServiceInterface $service)
    {
    }

    public function register(): void
    {
        add_action('wp_ajax_ideal_add_to_cart', [$this, 'handle']);
        add_action('wp_ajax_nopriv_ideal_add_to_cart', [$this, 'handle']);
    }

    public function handle(): void
    {
        check_ajax_referer(self::NONCE_ACTION, 'nonce');

        $productId = isset($_POST['product_id']) ? absint(wp_unslash($_POST['product_id'])) : 0;
        $quantity  = isset($_POST['quantity']) ? absint(wp_unslash($_POST['quantity'])) : 1;

        $quantity = max(1, $quantity);

        $added = $this->service->addProduct($productId, $quantity);
        if (!$added) {
            wp_send_json_error([
                'success'    => false,
                'product_id' => $productId,
            ], 400);
        }

        wp_send_json_success([
            'success'    => true,
            'product_id' => $productId,
        ]);
    }
}
