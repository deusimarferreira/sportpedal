<?php
/**
Plugin Name: Spotify Master
Plugin URI: http://wordpress.techgasp.com/spotify-master/
Version: 4.4.2.7
Author: TechGasp
Author URI: http://wordpress.techgasp.com
Text Domain: spotify-master
Description: Spotify Master allows you to display in your wordpress website musics, playlists and albums of the cool and "booming" music network Spotify.
License: GPL2 or later
*/
/* Copyright 2013 TechGasp  (email : info@techgasp.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if(!class_exists('spotify_master')) :
///////DEFINE VERSION///////
define( 'SPOTIFY_MASTER_VERSION', '4.4.2.7' );

global $spotify_master_name;
$spotify_master_name = "Spotify Master"; //pretty name
if( is_multisite() ) {
update_site_option( 'spotify_master_name', $spotify_master_name );
}
else{
update_option( 'spotify_master_name', $spotify_master_name );
}

class spotify_master{
public static function content_with_quote($content){
$quote = '<p>' . get_option('tsm_quote') . '</p>';
	return $content . $quote;
}
//SETTINGS LINK IN PLUGIN MANAGER
public static function spotify_master_links( $links, $file ) {
if ( $file == plugin_basename( dirname(__FILE__).'/spotify-master.php' ) ) {
		if( is_network_admin() ){
		$techgasp_plugin_url = network_admin_url( 'admin.php?page=spotify-master' );
		}
		else {
		$techgasp_plugin_url = admin_url( 'admin.php?page=spotify-master' );
		}
	$links[] = '<a href="' . $techgasp_plugin_url . '">'.__( 'Settings' ).'</a>';
	}
	return $links;
}

//END CLASS
}
add_filter('the_content', array('spotify_master', 'content_with_quote'));
add_filter( 'plugin_action_links', array('spotify_master', 'spotify_master_links'), 10, 2 );
endif;

// HOOK ADMIN
require_once( dirname( __FILE__ ) . '/includes/spotify-master-admin.php');
// HOOK ADMIN ADDONS
require_once( dirname( __FILE__ ) . '/includes/spotify-master-admin-addons.php');
// HOOK ADMIN WIDGETS
require_once( dirname( __FILE__ ) . '/includes/spotify-master-admin-widgets.php');
// HOOK WIDGET BUTTONS
require_once( dirname( __FILE__ ) . '/includes/spotify-master-widget-buttons.php');
