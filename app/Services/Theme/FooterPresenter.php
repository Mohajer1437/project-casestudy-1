<?php

namespace IdealBoresh\Services\Theme;

use IdealBoresh\Domain\Settings\OptionRepositoryInterface;

class FooterPresenter implements FooterPresenterInterface
{
    public function __construct(private OptionRepositoryInterface $options)
    {
    }

    public function buildContext(): array
    {
        return [
            'logo'             => [
                'url' => (string) get_theme_mod('theme_logo'),
                'alt' => get_bloginfo('name'),
            ],
            'site_name'        => get_bloginfo('name'),
            'home_url'         => home_url('/'),
            'addresses'        => $this->normalizeAddresses(),
            'social_icons'     => $this->normalizeSocialIcons(),
            'enamad'           => wp_kses_post((string) $this->options->get('footer_enamad', '')),
            'floating_contact' => $this->normalizeFloatingContact(),
        ];
    }

    /**
     * @return array{text: string, email: string, phone: string}
     */
    private function normalizeAddresses(): array
    {
        $raw = $this->options->get('footer-addresses', []);
        if (!is_array($raw)) {
            $raw = [];
        }

        return [
            'text'  => isset($raw['text']) ? sanitize_text_field((string) $raw['text']) : '',
            'email' => isset($raw['email']) ? sanitize_text_field((string) $raw['email']) : '',
            'phone' => isset($raw['phone']) ? sanitize_text_field((string) $raw['phone']) : '',
        ];
    }

    /**
     * @return array<int, array{link: string, image: string}>
     */
    private function normalizeSocialIcons(): array
    {
        $raw = $this->options->get('footer_social_icons', '[]');
        $decoded = is_string($raw) ? json_decode($raw, true) : $raw;
        if (!is_array($decoded)) {
            return [];
        }

        $icons = [];
        foreach ($decoded as $icon) {
            if (!is_array($icon)) {
                continue;
            }

            $link = isset($icon['link']) ? esc_url_raw((string) $icon['link']) : '';
            $image = isset($icon['image']) ? esc_url_raw((string) $icon['image']) : '';

            if ($link && $image) {
                $icons[] = [
                    'link'  => $link,
                    'image' => $image,
                ];
            }
        }

        return $icons;
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function normalizeFloatingContact(): array
    {
        $raw = $this->options->get('floating_contact', []);
        if (!is_array($raw)) {
            $raw = [];
        }

        $whatsappNumber = isset($raw['whatsapp_number']) ? preg_replace('/[^0-9]/', '', (string) $raw['whatsapp_number']) : '';
        $whatsappNumber = ltrim($whatsappNumber, '0');

        $contactNumber = isset($raw['contact_number']) ? preg_replace('/[^0-9+]/', '', (string) $raw['contact_number']) : '';

        return [
            'whatsapp' => [
                'number' => $whatsappNumber,
                'icon'   => isset($raw['whatsapp_icon']) ? esc_url_raw((string) $raw['whatsapp_icon']) : '',
                'link'   => $whatsappNumber ? 'https://wa.me/+98' . $whatsappNumber : '',
            ],
            'phone'    => [
                'number' => $contactNumber,
                'icon'   => isset($raw['contact_icon']) ? esc_url_raw((string) $raw['contact_icon']) : '',
            ],
            'url'      => [
                'link' => isset($raw['contact_url']) ? esc_url_raw((string) $raw['contact_url']) : '',
                'icon' => isset($raw['contact_icon']) ? esc_url_raw((string) $raw['contact_icon']) : '',
            ],
        ];
    }
}
