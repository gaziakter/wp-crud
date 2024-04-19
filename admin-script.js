jQuery(document).ready(function($) {
    $('.delete-record').click(function(e) {
        e.preventDefault();
        
        var recordId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'my_plugin_delete_record',
                    recordId: recordId
                },
                success: function(response) {
                    console.log(response);
                    // Refresh the page or update the table after successful deletion
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
