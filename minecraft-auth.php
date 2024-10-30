<?php
/*
   Plugin Name: Minecraft Auth
   Description: This plugin restricts users from registering unless the username registered is a premium Minecraft username.
   Version: 1.0
   Author: CraftZA
   Author URI: http://www.craftza.co.za
*/

/* Rewrite registration form */
function mca_registration_form() {
	wp_enqueue_script( 'login_form', plugins_url() . '/minecraft-auth/usernamerewrite.js', array('jquery'), false, false );
}
add_action('login_head', 'mca_registration_form');

/* Register actions */
add_action('register_post', 'auth_mc_account', 10, 3);

/* Check account on minecraft.net */
function auth_mc_account($login, $email, $errors) {
	$options = array(
        'timeout' => 5,
    );
    $mcacct = wp_remote_get('http://minecraft.net/haspaid.jsp?user='.rawurlencode($login), $options);
    $mcacct = $mcacct['body'];
		
    if ( $mcacct != 'true' ) {
        if ( $mcacct == 'false' ) {
            $errors->add('mca_error',__('<strong>ERROR:</strong> Minecraft account is invalid.'));
            return $errors;
        } else {
            $errors->add('mca_error',__('<strong>ERROR:</strong> Unable to contact minecraft.net.'));
            return $errors;
        }
        add_filter('registration_errors', 'auth_mc_account', 10, 3);
    }
}
?>