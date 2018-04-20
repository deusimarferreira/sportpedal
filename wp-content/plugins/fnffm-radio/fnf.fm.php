<?php
/*
Plugin Name: FnF.fm Radio
Plugin URI: http://wp.fnf.fm/wp-radio
Description: This plugin will add a FnF.fm Radio Player on your website, by using this sortcode [fnffm].
Author: Arifur Rahman
Author URI: http://www.tstudio.org
Version: 1.0
*/

/*-- Create Sortcode For FnF.fm Radio --*/
function fnf_fm_source( $atts ){
?>
<iframe height="440" scrolling="no" src="http://big.fnf.fm" width="100%"></iframe>

<?php
}
add_shortcode('fnffm', 'fnf_fm_source');
add_filter('widget_text', 'do_shortcode');


/*-- Widget For FnF.fm Radio Player --*/
class fnffmradiowidget extends WP_Widget
{
  function fnffmradiowidget()
  {
    $widget_ops = array('classname' => 'fnffmradiowidget', 'description' => 'FnF.fm Radio Player widget.' );
    $this->WP_Widget('fnffmradiowidget', 'FnF.fm Radio', $widget_ops);
  }
 
  function form($instance) 
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    //echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
    echo $before_title . $title . $after_title;;
 
    // WIDGET CODE GOES HERE
  ?>
<iframe height="40" scrolling="no" src="http://big.fnf.fm" width="100%"></iframe>
 <?php
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("fnffmradiowidget");') );
?>