<?php

namespace IdealBoresh\Application\Contact;

use IdealBoresh\Contracts\RegistersHooks;

class ContactFormController implements RegistersHooks
{
    private const AJAX_ACTION = 'submit_contact_form';
    private const NONCE_ACTION = 'ideal_contact_form';

    public function register(): void
    {
        add_action('wp_ajax_' . self::AJAX_ACTION, [$this, 'handle']);
        add_action('wp_ajax_nopriv_' . self::AJAX_ACTION, [$this, 'handle']);
        add_action('wp_head', [$this, 'exposeAjaxData']);
    }

    public function exposeAjaxData(): void
    {
        if (!is_page_template('page-front.php') && !is_page_template('page-contact.php')) {
            return;
        }

        $data = [
            'ajax_url'   => esc_url_raw(admin_url('admin-ajax.php')),
            'ajax_nonce' => wp_create_nonce(self::NONCE_ACTION),
            'action'     => self::AJAX_ACTION,
        ];

        $script = 'window.contactForm = Object.assign({}, window.contactForm || {}, ' . wp_json_encode($data) . ');';
        if (function_exists('wp_print_inline_script_tag')) {
            wp_print_inline_script_tag($script, ['id' => 'idealboresh-contact-form-data']);
            return;
        }

        printf('<script id="idealboresh-contact-form-data">%s</script>', $script); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    public function handle(): void
    {
        check_ajax_referer(self::NONCE_ACTION, 'security');

        $name    = isset($_POST['fullname']) ? sanitize_text_field(wp_unslash($_POST['fullname'])) : '';
        $phone   = isset($_POST['phone']) ? preg_replace('/[^0-9+]/', '', wp_unslash($_POST['phone'])) : '';
        $message = isset($_POST['message']) ? wp_kses_post(wp_unslash($_POST['message'])) : '';

        if ($name === '' || $phone === '' || $message === '') {
            wp_send_json_error(__('لطفاً تمام فیلدها را تکمیل کنید.', 'idealboresh'), 400);
        }

        $adminEmail = get_option('admin_email');
        $subject    = sprintf(__('پیام جدید از %s', 'idealboresh'), $name);
        $body       = sprintf(
            "%s\n%s: %s\n%s: %s\n\n%s",
            __('پیام جدید از فرم تماس دریافت شد.', 'idealboresh'),
            __('شماره تماس', 'idealboresh'),
            $phone,
            __('نام', 'idealboresh'),
            $name,
            wp_strip_all_tags($message)
        );

        if ($adminEmail) {
            wp_mail($adminEmail, $subject, $body);
        }

        wp_send_json_success(__('پیام شما با موفقیت ارسال شد.', 'idealboresh'));
    }
}
