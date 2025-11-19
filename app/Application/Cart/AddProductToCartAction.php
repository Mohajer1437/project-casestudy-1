<?php

namespace IdealBoresh\Application\Cart;

use IdealBoresh\Contracts\RegistersHooks;
use IdealBoresh\Domain\Cart\CartService;

class AddProductToCartAction implements RegistersHooks
{
    public function __construct(private CartService $service)
    {
    }

    public function register(): void
    {
        add_action('wp_ajax_ideal_add_to_cart', [$this, 'handle']);
        add_action('wp_ajax_nopriv_ideal_add_to_cart', [$this, 'handle']);
    }

    public function handle(): void
    {
        $productId = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
        $added = $this->service->addProduct($productId);

        wp_send_json(['success' => $added]);
    }
}
