<?php
	// plugin deactivation
	register_deactivation_hook( __FILE__, 'my_fn_deactivate' );
	function my_fn_deactivate() {
	    // some code for deactivation...
	    echo "string";
	    wp_die();
	}

	// plugin uninstallation
	register_uninstall_hook( __FILE__, 'my_fn_uninstall' );
	function my_fn_uninstall() {
	    delete_option( 'my_plugin_option' );
	}
?>