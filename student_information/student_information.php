<?php
/*
Plugin Name: Student Information plugin
Description: A simple student information plugin
Author: Iqbal Mohammad Rhidwan
*/
function student_information_activate() {
   global $wpdb;
   global $table_name;
   $table_name = $wpdb->prefix . 'student';
   $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        inserted_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        student mediumtext NOT NULL,
        institute mediumtext NULL,
        ssc float(4,2) NOT NULL,
        hsc float(4,2) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;"; 

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );

}
register_activation_hook( __FILE__, 'student_information_activate' );

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} 

function student_admin_option()
{
    // get the data from student and insert in the database 
    if (array_key_exists('submit_student', $_POST))  
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'student';

        $wpdb->insert( 
            $table_name, 
            array( 
                'inserted_at' => current_time( 'mysql' ), 
                'student' => test_input($_POST['name']), 
                'institute' => test_input($_POST['institute']),
                'ssc' => (float) test_input($_POST['ssc']), 
                'hsc' => (float) test_input($_POST['hsc']), 
            ) 
        );
        ?>
        <div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated">
            <strong>Successfully inserted Student</strong>
        </div>
        <?php
    }
    ?>
    <div class="container wrap">
        <div class="row">
            <h3 class="text-center"> Insert New Student Data </h3>
            <form method="post" action="">
                <div class="row">
                    <div class="input-field col-md-6">
                        <label for="st_name">Student name</label>
                        <input id="st_name"  name="name" type="text" class="form-control">
                    </div>
                    <div class="input-field col-md-6">
                        <label for="inst_name">Institute Name</label>
                        <input id="inst_name" name="institute" type="text" class="form-control">
                    </div>
                    <div class="input-field col-md-6">
                        <label for="ssc_gpa">SSC GPA</label>
                        <input id="ssc_gpa" name="ssc" type="text" class="form-control">
                    </div>
                    <div class="input-field col-md-6">
                        <label for="hsc_gpa">HSC GPA</label>
                        <input id="hsc_gpa" name="hsc" type="text" class="form-control">
                    </div>            
                    <div class="input-field mt-1 ml-2">
                        <input type="submit" name="submit_student" value="Insert Student" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div> 
        <div class="row mt-2 ">
            <h3 class="text-center"> Student Table</h3>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Institute</th>
                            <th scope="col">SSC</th>
                            <th scope="col">HSC</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        global $wpdb;
                        $table_name = $wpdb->prefix . 'student';
                        $result = $wpdb->get_results ( "SELECT * FROM $table_name" );
                        foreach ( $result as $td )   {
                                ?>
                                <tr>
                                    <td><?php echo $td->student;?></td>
                                    <td><?php echo $td->institute;?></td>
                                    <td><?php echo $td->ssc;?></td>
                                    <td><?php echo $td->hsc;?></td>
                                </tr>
                                <?php
                        };
                        ?>
                    </tbody>
                </table>  
            </div>
            
           
        </div>
    </div>
   
    <?php
}

function student_admin_menu()
{
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( 'Student Information', 'manage Student information', 'manage_options', 'student-admin-menu', 'student_admin_option', 'dashicons-screenoptions', 90 );
}
// action name, callback, 
add_action('admin_menu', 'student_admin_menu');


function student_admin_scripts() { 
//     function load_custom_wp_admin_style($hook) {
//         // Load only on ?page=mypluginname
//         if($hook != 'toplevel_page_student-admin-menu') {
                
//         }
//         wp_enqueue_style( 'custom_wp_admin_css', plugins_url('admin-style.css', __FILE__) );
// }
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

    wp_register_script('student_bootstraps', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
    wp_enqueue_script('student_bootstraps');

    // CSS
    wp_register_style('student_bootstraps', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
    wp_enqueue_style('student_bootstraps');
}
add_action('admin_enqueue_scripts', 'student_admin_scripts');

