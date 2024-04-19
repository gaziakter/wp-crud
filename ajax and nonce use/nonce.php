<?php 
add_action('wp_ajax_my_plugin_ajax_action', 'my_plugin_ajax_callback');

function my_plugin_ajax_callback() {
    check_ajax_referer('my-plugin-nonce', 'nonce');

    // Nonce verification passed, proceed with your logic here
}
