  
<?php
/**
 * Adds additional contact methods to user profile
 *
 * @param  array $methods
 * @return array
 */

function hooks_user_contact_methods( $methods ) {

    $methods['twitter'] = __( 'Twitter', 'shobit' );
    $methods['facebook'] = __( 'Facebook', 'shobit' );
    $methods['linkedin'] = __( 'LinkedIn', 'shobit' );

    return $methods;
}

add_filter( 'user_contactmethods', 'hooks_user_contact_methods' );