<?php
/*
 * Plugin Name:       WP Crud
 * Plugin URI:        https://gaziakter.com/plugins/wp-crud/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gazi Akter
 * Author URI:        https://gaziakter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-crud
 * Domain Path:       /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class My_Plugin_CRUD {

    public function __construct() {
        register_activation_hook(__FILE__, array($this, 'create_custom_table'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_my_plugin_delete_record', array($this, 'delete_record_callback'));
    }

    public function create_custom_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'custom_table';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function add_admin_menu() {
        add_menu_page('My Plugin CRUD', 'My Plugin CRUD', 'manage_options', 'my-plugin-crud', array($this, 'render_crud_page'));
    }

    public function render_crud_page() {
        ?>
        <div class="wrap">
            <h1>My Plugin CRUD</h1>
            <h2>Records</h2>
            <table class="wp-list-table widefat striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'custom_table';
                    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

                    foreach ($data as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="#" class="button-primary edit-record" data-id="<?php echo $row['id']; ?>">Edit</a>
                                <a href="#" class="button delete-record" data-id="<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function enqueue_admin_scripts() {
        wp_enqueue_script('my-plugin-crud-admin-script', plugin_dir_url(__FILE__) . 'js/admin-script.js', array('jquery'), '1.0', true);
    }

    public function delete_record_callback() {
        global $wpdb;

        $record_id = intval($_POST['recordId']);

        $table_name = $wpdb->prefix . 'custom_table';

        $result = $wpdb->delete(
            $table_name,
            array('id' => $record_id)
        );

        if ($result !== false) {
            echo 'Record deleted successfully!';
        } else {
            echo 'Error deleting record.';
        }

        wp_die();
    }
}

new My_Plugin_CRUD();