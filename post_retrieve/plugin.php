<?php
/*
Plugin Name: Retrieve post
Description: A plugin to retrieve post with wordpress rest api and show in admin
Author: Iqbal Mohammad Rhidwan
*/
function post_retrieve_activate() {
   
}
register_activation_hook( __FILE__, 'post_retrieve_activate' );


function post_retrieve_admin_option()
{
    // get the data from post_retrieve and insert in the database 
    if (array_key_exists('submit_post_retrieve', $_POST))  
    {
        ?>
        <div class="updated settings-error notice is-dismissible" id="setting-error-settings_updated">
            <strong>Successfully inserted Student</strong>
        </div>
        <?php
    }
    ?>
    <div class="container wrap">
        <div class="row">
            <button id="sp_btn" class="btn btn-success ml-auto">Show last 3 posts</button>
        </div>
        <div class="row" id='content'></div>
    </div>
   <script>
    $(document).ready(function(){
        $('#sp_btn').click(function(e){
            if ($(this).text() === 'Show last 3 posts')
            {
                console.log('show');
                $.get( "http://localhost/wordpress/?rest_route=/wp/v2/posts", function( data ) {
                    // data[0].content['rendered']
                    // data[0].link
                    // data[0].title['rendered']
                    var length = data.length;
                    for (var i = 0; i < 3 && i<length ; i++) {
                        $('#content').append('<div class="col-md-12 card"><div class="card-body"><h3 class="card-title"><a href="'+data[i].link+'">'+data[i].title['rendered'] + '</a></h3><p>'+ data[i].content['rendered'] + '</p></div></div>');                        
                    }
                });
                $(this).html('hide');
            }else if ($(this).text() === 'hide')
            {
                $('#content').html('');
                $(this).html('Show last 3 posts');
            }             
        });
    });
   </script>
    <?php
}

function post_retrieve_admin_menu()
{
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( 'Retrieve Post', 'View Post', 'manage_options', 'post-retrieve-admin-menu', 'post_retrieve_admin_option', 'dashicons-screenoptions', 100 );
}
// action name, callback, 
add_action('admin_menu', 'post_retrieve_admin_menu');




function post_retrieve_admin_scripts() { 
    //     function load_custom_wp_admin_style($hook) {
    //         // Load only on ?page=mypluginname
    //         if($hook != 'toplevel_page_post_retrieve-admin-menu') {
                    
    //         }
    //         wp_enqueue_style( 'custom_wp_admin_css', plugins_url('admin-style.css', __FILE__) );
    // }
        add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );
        wp_register_script('post_retrieve_jquery', 'https://code.jquery.com/jquery-3.3.1.min.js');
        wp_enqueue_script('post_retrieve_jquery');
        wp_register_script('post_retrieve_bootstraps', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
        wp_enqueue_script('post_retrieve_bootstraps');
    
        // CSS
        wp_register_style('post_retrieve_bootstraps', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
        wp_enqueue_style('post_retrieve_bootstraps');
    }
    add_action('admin_enqueue_scripts', 'post_retrieve_admin_scripts');