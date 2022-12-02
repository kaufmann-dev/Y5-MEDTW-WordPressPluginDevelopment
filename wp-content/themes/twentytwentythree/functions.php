<?php

function mw_plugin_scripts() {
    if (is_admin()) {
        wp_enqueue_style(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css',
            array(),
            false,
            'all'
        );
    }
}

add_action('admin_enqueue_scripts', 'mw_plugin_scripts');