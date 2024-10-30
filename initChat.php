<?php
/**
 * Plugin Name: initChat 
 * Plugin URI: https://www.initchat.com
 * Description: initChat will help to start quick support on your website. this plugin will work with third party application of WhatsApp,add support person contact number and show attractive popup dialog on your website, customer can send a support message directly via third party popular chatting applications. 

 * Version: 1.3.3
 * Author: initChat
 * Author URI: https://initchat.com
 * Text Domain: initchat
 * Domain Path: /
 * License: GPL2
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* Defines plugin's root folder. */
define( 'GWAC_PATH', plugin_dir_path( __FILE__ ) );
define( 'GWAC_URL', plugins_url('/assets', __FILE__ ) );


define( "GWAC_LICENSE", true );

/* General. */
require_once('inc/GWAC-init.php');

new gwac_main();
?>