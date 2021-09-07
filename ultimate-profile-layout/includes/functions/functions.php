<?php
// add menu page
function acutions_recent_bids_add_admin_page(){

    add_menu_page('Business Profile Layouts',
                  'Business Profile Layouts',
                  'manage_options',
                  'ulp-layouts',
                  'acutions_recent_bids_list',
                  'dashicons-layout', 56);   
    
    add_submenu_page(
        'ulp-layouts',       // parent slug
        'Business Profile Layouts',    // page title
        'Business Profile Layouts',             // menu title
        'manage_options',           // capability
        'ulp-layouts', // slug
        'acutions_customers_spendings_list' // callback
    ); 
    
    function acutions_customers_spendings_list(){
        require_once( UPL_PLUGIN_PATH . 'includes/pages/'.$_GET['page'].'.php');
    }
    
}

add_action('admin_menu','acutions_recent_bids_add_admin_page'); 

// check activated theme
function UPL_site_active_theme() {

    if (get_template_directory() === get_stylesheet_directory()) {
        $theme_dir = get_template_directory();
    } else {
        $theme_dir = get_stylesheet_directory();
    }

    return $theme_dir;
}

// Ajax handler
function my_ajax_handler() {
    global $wpdb;
    if($_POST['ajaxType'] == 'save_layout') {
        update_option( 'ultimate_profile_layout', $_POST['layoutIDS'] );
    }
    wp_die();
}

add_action( 'wp_ajax_my_ajax_handler', 'my_ajax_handler' );
add_action( 'wp_ajax_nopriv_my_ajax_handler', 'my_ajax_handler' );

function get_user_id_by_display_name( $display_name ) {
    global $wpdb;

    if ( ! $user = $wpdb->get_row( $wpdb->prepare(
        "SELECT `ID` FROM $wpdb->users WHERE `user_login` = %s", $display_name
    ) ) )
        return false;

    return $user->ID;
}

// Add custom field on profile edit page
function fb_add_custom_user_profile_fields( $user ) {
    global $post, $wpdb;
    $sql = "SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type = 'et_pb_layout' AND post_status = 'publish' ";
    $layout_results = $wpdb->get_results($sql);
    $layoutCount = count($layout_results);

?>
    <h3><?php _e('User Business Layouts', 'your_textdomain'); ?></h3>
    
    <table class="form-table">
        <tr>
            <th>
                <label for="ultimate_profile_layout"><?php _e('Choose Layout', 'your_textdomain'); ?>
            </label></th>
            <td>
                <select name="layout" class="upl_layout" id="upl_layout">
                <option value=""> --Select layout-- </option>
                <?php
                $ultimate_profile_layout = esc_attr( get_the_author_meta( 'ultimate_profile_layout', $user->ID ) );
                if( $layoutCount > 0 ) {
                foreach( $layout_results as $layout_result ) {
                ?>
                <option <?php if( $ultimate_profile_layout == $layout_result->ID ) { echo "selected"; } ?> value="<?php echo $layout_result->ID; ?>"><?php echo $layout_result->post_title; ?></option>
                <?php } } ?>
                </select><br />
                <span class="description"><?php _e('Please select your layout for profile page.', 'your_textdomain'); ?></span>
            </td>
        </tr>
    </table>
<?php }

function fb_save_custom_user_profile_fields( $user_id ) {
    
    if ( !current_user_can( 'edit_user', $user_id ) )
        return FALSE;
    
    update_usermeta( $user_id, 'ultimate_profile_layout', $_POST['layout'] );
}

add_action( 'show_user_profile', 'fb_add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'fb_add_custom_user_profile_fields' );

add_action( 'personal_options_update', 'fb_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'fb_save_custom_user_profile_fields' ); 