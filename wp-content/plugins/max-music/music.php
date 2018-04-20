<?php

/*
	Plugin Name: Max Music
	Plugin URI: http://www.turboindir.org/p/max-music-wordpress-muzik-eklentisi/
	Description: Easily add your site to the background music through YouTube.
	Version: 1.0
	Author: Orçun Tuna
	Author URI: http://www.www.turboindir.org/
	Licence: GPL2
*/


class maxmusic extends WP_Widget{

 	function __construct(){
 	$widget_option =  array('classname'=>'maxmusic','description'=>'Easily add your site to the background music through YouTube.');
 	parent::WP_Widget('maxmusic','Max Music',$_widget_options);
 	}

 	function widget($arg,$instance){
 		extract($arg,EXTR_SKIP);
 		$youtubeid = ($instance['youtubeid']) ? $instance['youtubeid'] : 'Qh8wV1J7Mkg';
 		
 		?>

 		<iframe width="0" height="0" src="http://www.youtube.com/embed/<?php echo $instance['youtubeid']; ?>?rel=0&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>

 		<?php

 	}

 	function form($instance){
 		$default = array('youtubeid'=>'');
 		$instance = wp_parse_args((array) $instance,$default);
 		$youtubeid = $instance['youtubeid'];

 		?>

 		<p><b>Youtube Music ID:</b></p>
 		<p><input type="text" name="<?php echo $this->get_field_name('youtubeid'); ?>" value="<?php echo esc_attr($youtubeid); ?>" /></p>
		<p><b>Example ID:</b></p>
		<p>https://www.youtube.com/watch?v=<b style="color:#c0392b;">YzjzOmiUJXY</b></p>
 		
 		<?php
 	}

 	function update($new_instance, $old_instance){
 		$instance = $old_instance;
 		$instance['youtubeid'] = strip_tags($new_instance['youtubeid']);
 		return $instance;
 	}

}

	function widget_init(){
		register_widget('maxmusic');
	}

	add_action('widgets_init','widget_init');

?>
