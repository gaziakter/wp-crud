<?php
add_action('wp_ajax_my_plugin_ajax_action', 'my_plugin_ajax_callback');

function my_plugin_ajax_callback() {
    if (!check_ajax_referer('my-plugin-nonce', 'nonce', false)) {
        wp_send_json_error('Nonce verification failed.', 403);
    }

    // Nonce verification passed, proceed with your logic here
}
