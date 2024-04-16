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
            $this->table_name = $wpdb->prefix . 'students'; //wp_custom_table
            add_action('init', [$this, 'init']);
            register_activation_hook(__FILE__, [$this, 'create_student_table']);
            register_deactivation_hook(__FILE__, [$this, 'deactivate']); 
     
        }

      public  function init() {
        add_action('admin_menu', [$this, 'student_crud_menu']);
     }

        function create_student_table() {
            global $wpdb;
            $table_name = $wpdb->prefix . 'students';
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(100) NOT NULL,
                email varchar(100) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

        function deactivate() {
            global $wpdb;
            // $wpdb->query("DROP TABLE IF EXISTS $this->table_name");
        }
    
        function student_crud_menu() {
            add_menu_page(
                'Database CRUD',
                'Database CRUD',
                'manage_options',
                'database-crud',
                [$this, 'database_crud_page'],
                'dashicons-admin-generic',
            );
        }


        function database_crud_page() {
          ?>
          <div class="wrap">
        <h2>Manage Students</h2>
        <!-- Add New button -->
        <!-- <button id="addNewButton">Add New</button> -->
        <!-- Form for adding new student (initially hidden) -->
        <!-- <div id="addNewForm" style="display: none;"> -->
            <h3>Add New Student</h3>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <input type="text" name="student_name" placeholder="Student Name" required>
                <input type="email" name="student_email" placeholder="Student Email" required>
                <input type="submit" name="submit_add_student" value="Add Student">
            </form>
        </div>
           <?php
        }
        
       
 }
}
if ( class_exists('WPH_Database_Crud_Operations') ) {
    $wph_database_crud_operations = new WPH_Database_Crud_Operations();
}