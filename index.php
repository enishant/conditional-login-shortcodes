<?php
/**
 * @package Conditional Login Shortcodes
 * @author Nishant Vaity
 * @version 1.0
 * Plugin Name: Conditional Login Shortcodes
 * Plugin URI: https://github.com/enishant
 * Description: Provides shortcodes for conditional login to include content in a post based on context. Example : [is_user_logged_in]Welcome user [not_user_logged_in] Show login form using shortcode [clslf][/is_user_logged_in]
 * Author: Nishant Vaity
 * Version: 1.0
 * Author URI: https://github.com/enishant
*/

class conditional_login_shortcodes 
{

	function generic_handler ($atts, $content, $condition, $elsecode)
	{
		list ($if, $else) = explode ($elsecode, $content, 2);
		return do_shortcode($condition ? $if : $else);
	}
    
	function is_user_logged_in_shortcode_handler ($atts, $content="") 
	{
		return $this->generic_handler ($atts, $content, is_user_logged_in(), '[not_user_logged_in]');
	}

	function conditional_login_shortcode_login_form()
	{
		$atts = shortcode_atts( array(
		      'redirect' => site_url() ,
		), $atts );

		$args = array(
				'echo'           => false,
				'redirect'       => $redirect, 
				'form_id'        => 'loginform',
				'label_username' => 'Username',
				'label_password' => 'Password',
				'label_remember' => 'Remember Me',
				'label_log_in'   => 'Login',
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'remember'       => true,
				'value_username' => NULL,
				'value_remember' => false
		);
		return wp_login_form($args);
	}
}
$conditional_login_shortcodes = new conditional_login_shortcodes;
add_shortcode('is_user_logged_in',     array($conditional_login_shortcodes, 'is_user_logged_in_shortcode_handler'));
add_shortcode('clslf', array($conditional_login_shortcodes, 'conditional_login_shortcode_login_form'));
?>
