<?php
/*
Plugin Name: wp-picasa
Plugin URI: http://www.roadrunner.cx
Description: A plugin that embeds Jon Design's smooth gallery with picasa images into your wordpress pages / posts..
Version: 1.0.4
Author: Oskari Rauta
Author URI: http://www.roadrunner.cx
License: GPL2
*/

/*  Copyright 2010  Oskari Rauta  (email : oskari.rauta@gmail.com)

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

// Necessary includes
include_once(WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__), "", plugin_basename(__FILE__)) . 'common.php');

if ( file_exists( WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__), "", plugin_basename(__FILE__)) . 'lang/' . get_locale() . '.mo' ) )
load_textdomain('wp-picasa', WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__), "", plugin_basename(__FILE__)) . 'lang/' . get_locale() . '.mo' );

// create custom plugin settings menu
add_action('admin_menu', 'wpg_create_menu');

if (!is_admin()) {

	wp_enqueue_style('jd-layout', plugins_url('/css/layout.css', __FILE__), false);
	wp_enqueue_style('jd-gallery', plugins_url('/css/jd.gallery.css', __FILE__), false);
	wp_enqueue_style('wpg-gallery', plugins_url('/css/wpg.gallery.css', __FILE__), false);

	wp_enqueue_script('mootools-core', plugins_url('/js/mootools-1.2.1-core-yc.js', __FILE__), NULL, '1.2.1');
	wp_enqueue_script('mootools-more', plugins_url('/js/mootools-1.2-more.js', __FILE__), NULL, '1.2');
	wp_enqueue_script('jd-gallery', plugins_url('/js/jd.gallery.js', __FILE__));
	wp_enqueue_script('jd-gallery-set', plugins_url('/js/jd.gallery.set.js', __FILE__));
	wp_enqueue_script('wpg-support', plugins_url('/js/wpg.support.js', __FILE__), NULL, '1.0');

}

function wpg_create_menu() {

	//create new sub-menu to plugins page
	add_submenu_page('options-general.php', __('WP-Picasa Settings', 'wp-picasa'), __('WP-Picasa'), 'administrator', __FILE__, 'wp_picasa_settings_page',plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_wp_picasa_settings' );
}


function register_wp_picasa_settings() {
	//register our settings
	register_setting( 'wp-picasa-settings-group', 'wp-picasa_userid' );
}

function wp_picasa_settings_page() {
?>
<div class="wrap">
<h2><?php _e('WP-Picasa Settings', 'wp-picasa') ?></h2>

<form method="post" action="options.php">
    <?php settings_fields( 'wp-picasa-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('Picasa Web Album UserID', 'wp-picasa') ?></th>
        <td><input type="text" name="wp-picasa_userid" value="<?php echo get_option('wp-picasa_userid'); ?>" /></td>
        </tr>        
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'wp-picasa') ?>" />
    </p>

</form>
</div>
<?php } 

function wp_picasa_shortcode( $atts, $content = null ) {
   extract( shortcode_atts( array(
      'userid' => NULL,
      'albumid' => NULL,
      ), $atts ) );

	$attrs = array(
		'userid' => $atts['userid'] == NULL ? get_option('wp-picasa_userid') : $atts['userid'],
		'albumid' => $atts['albumid'],
	);

	if ( !is_writable( WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__), "", plugin_basename(__FILE__)) . 'cache' ))
		{
			return(__('Error. Folder \'cache\' does not exist or is not writable. Folder \'cache\' must exist in wp-picasa plugin\'s folder and must be writable by web server user.', 'wp-picasa'));
		}

	if ( $attrs['albumid'] != NULL )
		{
			$photolist = xml_loader('http://picasaweb.google.com/data/feed/api/user/' . $attrs['userid'] . '/albumid/' . $attrs['albumid'] . '?imgmax=640&access=public&thumbsize=72u', WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__), "", plugin_basename(__FILE__)) . 'cache/album-' . $attrs['userid'] . '.' . $attrs['albumid']);
			$gphoto = $photolist->children('http://schemas.google.com/photos/2007');
			$imgAmount = $gphoto->numphotos;
			return(__('Error. Incorrect albumID or album is empty. Empty albums are not supported.'));
		}

	$content = '
			<div class="WPGgalleryContainer">
				<div id="myGallerySet" class="jdGallery">
				</div>
			</div>
			<script type="text/javascript">
				var gCont = document.getElementById(\'myGallerySet\');
				var gContFx = new Fx.Tween(gCont, {
					duration: \'500\',
					property: \'opacity\'
				});

				gContFx.start(1,0).chain(
					function(){
						gCont.set(\'html\', \'<div class="loadingElement"></div>\');
						this.start(0,1);
					})
				var jsonReq = new Request.JSON({
					url: "' . plugins_url('/getpicasa.php' , __FILE__) . 
					'?path=' . urlencode(plugins_url('/getpicasa.php', __FILE__)) .
					'&albumlist=' . urlencode(( $attrs['albumid'] == NULL ? 'false' : 'true' )) .
					'&userid=' . urlencode($attrs['userid']) . 
					'&AlbumsTxt=' . urlencode(__('Albums', 'wp-picasa')) .
					'&ImageTxt=' . urlencode(__('Image', 'wp-picasa')) .
					'&ImagesTxt=' . urlencode(__('Images', 'wp-picasa')) .
					'&LoadingTxt=' . urlencode(__('Loading', 'wp-picasa')) .
					( $attrs['albumid'] == NULL ? '' : ( '&albumid=' . urlencode($attrs['albumid'] ))) . '",					
					method: \'post\',
					data: {
						json: \'yes\'
					},
					onSuccess: function(response) {
						gContFx.start(1,0).chain(
							function(){ 
								gCont.set(\'html\', response);' . ( $attrs['albumid'] != NULL ? ( $imgAmount > 1 ? '
									document.myGallerySet = new gallery($(\'myGallerySet\'), {
										timed: false,
										textGallerySelector: \'' . __('Albums', 'wp-picasa') . '\',
										textShowGallerySelector: \'' . __('Albums', 'wp-picasa') . '\',
										textGalleryInfo: \'{0} ' . __('Images','wp-picasa') . '\',
										textShowCarousel: \'' . __('Image', 'wp-picasa') . ' {0}/{1}\',
										textPreloadingCarousel: \'' . __('Loading', 'wp-picasa') . '...\',
										carouselMinimizedOpacity: 0.5,
										carouselMaximizedOpacity: 0.95,
										slideInfoZoneOpacity: 0.85,
										thumbIdleOpacity: 0.45,
										embedLinks: false
									});' : '
									document.myGallerySet = new gallery($(\'myGallerySet\'), {
										timed: false,
										textGallerySelector: \'' . __('Albums', 'wp-picasa') . '\',
										textShowGallerySelector: \'' . __('Albums', 'wp-picasa') . '\',
										textGalleryInfo: \'{0} ' . __('Images','wp-picasa') . '\',
										textShowCarousel: \'' . __('Image', 'wp-picasa') . ' {0}/{1}\',
										textPreloadingCarousel: \'' . __('Loading', 'wp-picasa') . '...\',
										carouselMinimizedOpacity: 0.5,
										carouselMaximizedOpacity: 0.95,
										slideInfoZoneOpacity: 0.85,
										thumbIdleOpacity: 0.45,
										embedLinks: false,
										showCarousel: false,
										showArrows: false,
										embedLinks: false
									});') : '' ) .'
								this.start(0,0);
							},
							function (){
								this.start(0,1);
							});
				}}).get();
			</script>
';
	
	return $content;
}

if (function_exists('add_shortcode')) add_shortcode('wp_picasa', 'wp_picasa_shortcode');

?>
