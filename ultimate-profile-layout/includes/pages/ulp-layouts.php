<?php
global $post, $wpdb;
$sql = "SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type = 'et_pb_layout' AND post_status = 'publish' ";
$layout_results = $wpdb->get_results($sql);
$layoutCount = count($layout_results);
if($layoutCount == 0){
    echo '<div class="notice notice-success is-dismissible">
            <p> There is no layout. Please create layout first.</p>
        </div>';
}
?>
<div class="upl_fullwidth">
    <div class="upl_row"> <h2>Business Profile Layouts</h2> </div>
    <div class="upl_row">
        <lable class="upl_lable">Choose Layout</lable>
        <select name="layout" class="upl_layout" id="upl_layout">
        <option value=""> --Select layout-- </option>
        <?php
        $ultimate_profile_layout = get_option( 'ultimate_profile_layout' );
        if( $layoutCount > 0 ) {
        foreach( $layout_results as $layout_result ) {
        ?>
        <option <?php if( $ultimate_profile_layout == $layout_result->ID ) { echo "selected"; } ?> value="<?php echo $layout_result->ID; ?>"><?php echo $layout_result->post_title; ?></option>
        <?php } } ?>
        </select> <span class="hide"><img src="/wp-admin/images/loading.gif"></span>
    </div>
</div>