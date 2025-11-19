<?php

defined('ABSPATH') || exit;

if (!defined('IDEALBORESH_THEME_PATH')) {
    define('IDEALBORESH_THEME_PATH', get_template_directory());
}

if (!defined('IDEALBORESH_THEME_URI')) {
    define('IDEALBORESH_THEME_URI', get_template_directory_uri());
}

if (!defined('IDEALBORESH_THEME_VERSION')) {
    $theme = wp_get_theme();
    define('IDEALBORESH_THEME_VERSION', $theme->get('Version') ?: '1.0.0');
}
