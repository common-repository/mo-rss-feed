<?php
/*
Plugin Name: Mo RSS Feed
Plugin URI: https://moduet.com/wordpress-plugins/
Description: A WordPress plugin that displays an RSS feed within a responsive slider. This plugin will display an RSS feed using a shortcode on any page, post or widget. The RSS feed can be displayed in a slider or column layout. The RSS slider or column layout are responsive; visibly clean display and functionality on any device (mobile or desktop). 
Version: 1.1
Contributors: MoDuet
Author: MoDuet
Author URI: http://moduet.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

$mo_rss_feed = new mo_rss_feed();
class mo_rss_feed{
	public function __construct() {
		add_action( 'wp_footer', array($this, 'register_plugin_styles') );
     }
     
	public function register_plugin_styles() {
		wp_register_style( 'mo-rss-feed-css', plugins_url( 'css/mo-rss-feed.css', __FILE__ ) . '' );
		wp_enqueue_style( 'mo-rss-feed-css' );
	}
}
	
/* Shortcodes */
include('shortcode/slider.php');
include('shortcode/column.php');