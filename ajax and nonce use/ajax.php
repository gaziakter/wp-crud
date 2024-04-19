<?php
add_action('admin_enqueue_scripts', 'my_plugin_enqueue_scripts');

function my_plugin_enqueue_scripts() {
    wp_enqueue_script('my-plugin-script', plugin_dir_url(__FILE__) . 'js/my-plugin-script.js', array('jquery'), '1.0', true);

    wp_localize_script('my-plugin-script', 'my_plugin_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('my-plugin-nonce'),
    ));
}
