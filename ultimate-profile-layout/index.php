<?php
/**
 * Plugin Name: Ultimate Profile Layout
 * Plugin URI: localhost
 * Description: The very first plugin that I have ever created.
 * Version: 1.0
 * Author: Shobit
 */

// notive on plugin activation
// class Activation {

//     public static function init() {
//         add_action('admin_notices', array(__CLASS__, 'text_admin_notice'));
//     }

//     public static function text_admin_notice() {

//        echo '<div class="notice notice-success is-dismissible">
//                 <p> TEST MESSAGE</p>
//             </div>';

//     }

// }
//add_action('init', array('Activation', 'init'));

define( 'UPL_PLUGIN_PATH', plugin_dir_path(__FILE__) );

function upl_script(){
    // JS Files
    wp_enqueue_script( 'upl-custom-js', plugins_url( '/js/custom.js', __FILE__ ), 'jQuery', '1.0.0', true);
    wp_localize_script( 'upl-custom-js', 'readmelater_ajax', array( 'ajax_url' => admin_url('admin-ajax.php')) );

    // CSS Files
    wp_enqueue_style( 'upl-style', plugins_url( '/css/style.css', __FILE__ ) );
}
add_action( 'admin_print_styles', 'upl_script' );

require_once( UPL_PLUGIN_PATH . 'includes/functions/functions.php');

// plugin activation
register_activation_hook( __FILE__, 'UPL_move_files_to_theme' );
// move file to theme
function UPL_move_files_to_theme(){

    $theme_dir = UPL_site_active_theme() . '/ultimate-member/templates';

    if (! is_dir($theme_dir)) {
    mkdir( $theme_dir, 0777, true );
    }

    $src = UPL_PLUGIN_PATH.'/includes/core/profile-mycustomprofile.php';
    $dest = $theme_dir.'/profile-mycustomprofile.php';

    $src1 = UPL_PLUGIN_PATH.'/includes/core/profile.php';
    $dest1 = $theme_dir.'/profile.php';

    copy( $src, $dest);
    copy( $src1, $dest1);
}

// UPL_move_files_to_theme();

// plugin deactivation
register_deactivation_hook( __FILE__, 'my_fn_deactivate' );
function my_fn_deactivate() {
    // some code for deactivation...
    $dirPath = UPL_site_active_theme() . '/ultimate-member/templates';
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}
