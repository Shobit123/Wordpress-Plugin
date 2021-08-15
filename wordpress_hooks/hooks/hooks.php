<?php
/**
 * Plugin Name: Test Plugin Demo
 * Description: The very first plugin for Hooks concept
 * Version: 1.0
 * Author: Shobit
 * Author URI: localhost
 */

// bZ%S2IP&Tsr8JCHb8*   
if ( !defined( 'ABSPATH' ) ) exit;

if ( is_admin() ) {
    require_once dirname( __FILE__ ) . '/includes/admin/profile.php';
}

/**
* Print new_check in the header
*
* @return void
*/

function new_check() {
	echo '<h1>Hello Shobit</h1>';
	?>
	<!-- Start new_check-->
	<meta name="description" content="Shobit Singh">
	<meta name="keywords" content="php, ajax,angular, node">
    <!-- End new_check-->
	<?php
}

add_action( 'wp_head', 'new_check' );

function foot_wp_footer() {
	echo '<h1>Hello Shobit</h1>';
}

add_action( 'wp_footer', 'foot_wp_footer' );

function new_profile( $content ) {
	global $post;

    $author   = get_user_by( 'id', $post->post_author );

    $bio      = get_user_meta( $author->ID, 'description', true );
    $twitter  = get_user_meta( $author->ID, 'twitter', true );
    $facebook = get_user_meta( $author->ID, 'facebook', true );
    $linkedin = get_user_meta( $author->ID, 'linkedin', true );

    ob_start();
    ?>
    <div class="new-bio-wrap">

        <div class="avatar-image">
            <?php echo get_avatar( $author->ID, 64 ); ?>
        </div>

        <div class="new-bio-content">
            <div class="author-name"><?php echo $author->display_name; ?></div>

            <div class="new-author-bio">
                <?php echo wpautop( wp_kses_post( $bio ) ); ?>
            </div>

            <ul class="new-socials">
                <?php if ( $twitter ) { ?>
                    <li><a href="<?php echo esc_url( $twitter ); ?>"><?php _e( 'Twitter', 'shobit' ); ?></a></li>
                <?php } ?>

                <?php if ( $facebook ) { ?>
                    <li><a href="<?php echo esc_url( $facebook ); ?>"><?php _e( 'Facebook', 'shobit' ); ?></a></li>
                <?php } ?>

                <?php if ( $linkedin ) { ?>
                    <li><a href="<?php echo esc_url( $linkedin ); ?>"><?php _e( 'LinkedIn', 'shobit' ); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <style>
		.new-bio-wrap {
		    margin: 40px 0 20px 0;
		    border: 1px solid #eee;
		    padding: 20px;
		    display: block;
		    overflow: hidden;
		}

		.new-bio-wrap .avatar-image {
		    float: left;
		    margin-right: 15px;
		    margin-bottom: 15px;
		}

		.new-bio-content .author-name {
		    font-weight: bold;
		    padding-bottom: 10px;
		}

		ul.new-socials {
		    clear: both;
		    margin: 0;
		    padding: 0;
		    list-style: none;
		}

		ul.new-socials li {
		    display: inline-block;
		    border: 1px solid #eee;
		    padding: 3px 10px;
		}

		ul.wetuts-socials li a {
		    text-decoration: none;
		}
</style>
    <?php
    $bio_content = ob_get_clean();

    return $content . $bio_content;
}

add_filter( 'the_content', 'new_profile' );
