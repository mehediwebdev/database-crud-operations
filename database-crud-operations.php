<?php
/*
 * Plugin Name:       Database CRUD Operations
 * Plugin URI:        
 * Description:       Database CRUD Operations is a WordPress plugin where shown the database CRUD.
 * Version:           1.0.0
 * Requires at least: 6.2
 * Requires PHP:      7.2
 * Author:            Mehedi Hasan
 * Author URI:        
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        
 * Text Domain:      database-crud-operations
 * Domain Path:       /languages
 */


 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


if (!class_exists('WPH_Database_Crud_Operations')){
    class WPH_Database_Crud_Operations{
        private $table_name;

        public function __construct(){
            global $wpdb;
            $this->table_name = $wpdb->prefix . 'wph_students'; //wp_custom_table
            add_action('init', [$this, 'init']);
            register_activation_hook(__FILE__, [$this, 'create_student_table']);
            register_deactivation_hook(__FILE__, [$this, 'deactivate']); 
     
        }

        public function init() {
            $this->define_constants();
           // $this->digital_school_delete_students($id);
            add_action('admin_menu', [$this, 'student_crud_menu']);
            add_action( 'admin_enqueue_scripts', [$this, 'load_admin_assets']);
            $id = intval($_GET['id']);
            $this->digital_school_delete_students($id);
        }

        public function define_constants() {
            define('WPH_DB_CRUD_PATH', plugin_dir_path(__FILE__));
            define('WPH_DB_CRUD_URL', plugin_dir_url(__FILE__));
            define('WPH_DB_CRUD_VERSION', '1.0.0');
        }

        function create_student_table() {
            global $wpdb;
            $table_name = $wpdb->prefix . 'wph_students';
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(100) NOT NULL,
                email varchar(100) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);


            if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){
                $id = intval($_GET['id']);
                $this->digital_school_delete_students($id); // Pass $id to the method
            }

        }

        function deactivate() {
            // Perform cleanup tasks if needed
        }
    
        function student_crud_menu() {
            add_menu_page(
                __('Database CRUD', 'database-crud-operations'), // Escaping and translation
                __('Database CRUD', 'database-crud-operations'), // Escaping and translation
                'manage_options',
                'database-crud',
                [$this, 'database_crud_page'],
                'dashicons-welcome-learn-more',
                7
            );
        }

        public function database_crud_page() {
            if ( file_exists( plugin_dir_path( __FILE__ ) . 'inc/wph-students-table.php' ) ) {
                require_once plugin_dir_path( __FILE__ ) . 'inc/wph-students-table.php';
            } 
        }

        // Admin assets enqueue callback function
        public function load_admin_assets($screen){
            $version = WPH_DB_CRUD_VERSION;
            $asset_directory = plugins_url('assets/', __FILE__);
            
            // Enqueue the css file for admin 
            wp_enqueue_style( 'wph-dbcrud-admin-style', $asset_directory . 'admin/css/admin-style.css', [], $version, 'all' );
            // Enqueue the JavaScript file for admin 
            wp_enqueue_script( 'wph-dbcrud-main-js', $asset_directory . 'admin/js/main.js', [], $version, true );

        }

        // Insert Student Function

function database_crud_insert_students(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'wph_students';
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
	$wpdb->insert(
	  $table_name,
	  array(
	  'name' => $name,
	  'email' => $email,
	  )
	
	);
  
   }



   //Delete student
   // Delete Students function

public function digital_school_delete_students($id){
    global $wpdb;

    $table_name = $wpdb->prefix . 'wph_students';

  //  $id = $_GET['id'];

    $wpdb->delete( $table_name, array( 'id' => $id ) );
}

 }
}

if ( class_exists('WPH_Database_Crud_Operations') ) {
    $wph_database_crud_operations = new WPH_Database_Crud_Operations();
}
