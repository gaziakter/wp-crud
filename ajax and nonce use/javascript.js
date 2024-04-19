jQuery(document).ready(function($) {
    $('#my-button').click(function(e) {
        e.preventDefault();
        
        var data = {
            action: 'my_plugin_ajax_action',
            nonce: my_plugin_ajax_object.nonce, // Nonce value
            // Add other data parameters here
        };
        
        $.post(my_plugin_ajax_object.ajax_url, data, function(response) {
            // Handle response
        });
    });
});
