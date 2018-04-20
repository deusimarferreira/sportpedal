<?php
/*
Plugin Name: Login Screen Manager
Plugin URI: http://www.NihalsCode.com/
Description: This plugin is for managing your login screen of WordPress site.
Tags: login screen,login logo,wp-login.php,admin,Nazmul Hossain Nihal,logos,login screen manager,nihal's,code
Version: 2.1
Author:	Nazmul Hossain Nihal
Author URI: http://www.NihalsCode.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


/******************************
* global variables
******************************/

$cwlsm_options = get_option('cwlsm_settings');

/******************************
* includes
******************************/

include('inc/admin.php'); //Admin Panel

include('inc/display.php'); //Display

include('inc/meta.php'); //Meta Tags
