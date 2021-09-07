<?php /* Template: Divi Profile Layout */ ?>
<div id="et-boc" class="et-boc">
	<div id="et_builder_outer_content" class="et_builder_outer_content">
    <div class="et-l et-l--post">
    <div class="et_builder_inner_content et_pb_gutters3">
<?php 

function get_user_id_by_display_name( $display_name ) {
    global $wpdb;

    if ( ! $user = $wpdb->get_row( $wpdb->prepare(
        "SELECT `ID` FROM $wpdb->users WHERE `user_login` = %s", $display_name
    ) ) )
        return false;

    return $user->ID;
}

global $post, $wpdb;
$ultimate_profile_layout = get_option( 'ultimate_profile_layout' );
$sql = "SELECT * FROM ".$wpdb->prefix."posts WHERE ID = '$ultimate_profile_layout' AND post_status = 'publish'";
$results = $wpdb->get_results($sql);
$layoutCount = count($results);

if($layoutCount > 0){

    foreach( $results as $result ) {

        $content = $result->post_content;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

    }

    $current_user = wp_get_current_user();
    // $userID = get_current_user_id();
    // $all_meta_for_user = get_user_meta( $userID );
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $refer_split = explode("/", $actual_link);
    $display_name = $refer_split[ count($refer_split) - 2];     

    $userID = get_user_id_by_display_name( $display_name );
    $all_meta_for_user = get_user_meta( $userID );

    // $avatar = maybe_unserialize( $all_meta_for_user['simple_local_avatar'][0] );
    // $full = $avatar['full'];

    $full = um_get_user_avatar_url( $user_id = $userID, $size = '96' );
    
    $avatar_img = '<img src="'.$full.'">';
    $default_profile = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'um_form' AND post_name = 'default-profile'";
	$results_profile = $wpdb->get_results($default_profile) or die(mysql_error());
	$default_profile_ID = $results_profile['0']->ID;
	$_um_custom_fields = get_post_meta( $default_profile_ID, '_um_custom_fields', true );
	// echo "<pre>";
	// print_r($_um_custom_fields);
	// echo "</pre>";
	$PlaceholdersFieldsArray = [];
	foreach($_um_custom_fields as $key => $value){
		$PlaceholdersFieldsArray[$key] = $value['label'];
	}

	// echo "<pre>";
	// print_r($PlaceholdersFieldsArray);
	// echo "</pre>";

	foreach($PlaceholdersFieldsArray as $key => $value){
		if( $key == 'gender' ){
			$gender = maybe_unserialize( get_user_meta( $userID, $key, true) );
			$content = str_replace('{{'.$value.'}}', ucwords($gender[0]), $content);
		}
		$content = str_replace('{{'.$value.'}}', ucwords(get_user_meta( $userID, $key, true)), $content);
	}

	if( $full!='' ) {
		$content = str_replace('{{profile_img}}',$avatar_img,$content);
	} else {
		$content = str_replace('{{profile_img}}',get_avatar( $userID ),$content);
	}

	$content = str_replace('{{description}}',get_user_meta( $userID, 'description', true),$content);

    echo $content;

} else {
	echo "<strong>Selected profile layout deleted by the user.</strong>";
}

?>
</div></div></div></div>
