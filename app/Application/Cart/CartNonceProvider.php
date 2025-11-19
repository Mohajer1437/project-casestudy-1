<?php

namespace IdealBoresh\Application\Cart;

use IdealBoresh\Contracts\RegistersHooks;

class CartNonceProvider implements RegistersHooks
{
    public function __construct(private string $action)
    {
    }

    public function register(): void
    {
        add_action('wp_head', [$this, 'injectAjaxObject'], 1);
    }

    public function injectAjaxObject(): void
    {
        if (is_admin() || wp_doing_ajax()) {
            return;
        }

        $data = [
            'ajaxurl' => esc_url_raw(admin_url('admin-ajax.php')),
            'nonce'   => wp_create_nonce($this->action),
        ];

        $script = 'window.ideal_ajax_object = Object.assign({}, window.ideal_ajax_object || {}, ' . wp_json_encode($data) . ');';
        $script .= 'window.ajax = Object.assign({}, window.ajax || {}, { ajaxurl: window.ideal_ajax_object.ajaxurl });';

        if (function_exists('wp_print_inline_script_tag')) {
            wp_print_inline_script_tag($script, ['id' => 'idealboresh-cart-ajax-data']);
            return;
        }

        printf('<script id="idealboresh-cart-ajax-data">%s</script>', $script); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
