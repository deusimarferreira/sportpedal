<?php
/*
  Plugin Name: Simple Sticky Footer
  Plugin URI: http://www.sandorkovacs.ro/simple-sticky-footer-wordpress-plugin/
  Description: Lightweight Sticky Footer plugin
  Author: Sandor Kovacs
  Version: 1.3.0
  Author URI: http://sandorkovacs.ro/en/
 */

// Do the magic stuff
add_action('wp_footer', 'simple_sf');

add_action('wp_head', 'simple_sf_ban_init');
add_action('admin_init', 'simple_sf_ban_init');
add_action('admin_menu', 'register_simple_sf_ban_submenu_page');

function simple_sf_ban_init() {

    wp_register_script('simple-sticky-footer', plugins_url('simple-sticky-footer.js', __FILE__));

    /* Register our stylesheet. */
    wp_register_style('simple-sticky-footer', plugins_url('simple-sticky-footer.css', __FILE__));
    wp_enqueue_style('simple-sticky-footer');
    
    wp_dequeue_script('jquery');
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-effects-core');
    wp_enqueue_script('jquery-effects-blind');
    wp_enqueue_script('jquery-effects-bounce');
    wp_enqueue_script('jquery-effects-clip');
    wp_enqueue_script('jquery-effects-drop');
    wp_enqueue_script('jquery-effects-explode');
    wp_enqueue_script('jquery-effects-fade');
    wp_enqueue_script('jquery-effects-fold');
    wp_enqueue_script('jquery-effects-highlight');
    wp_enqueue_script('jquery-effects-pulsate');
    wp_enqueue_script('jquery-effects-scale');
    wp_enqueue_script('jquery-effects-shake');
    wp_enqueue_script('jquery-effects-slide');
    wp_enqueue_script('jquery-effects-transfer');
    wp_enqueue_script('simple-sticky-footer');

}

function register_simple_sf_ban_submenu_page() {
    add_submenu_page(
            'themes.php', __('Sticky Footer'), __('Sticky Footer'), 'edit_posts', 'simple-simple-sticky-footer', 'simple_sf_ban_callback');
}

function simple_sf_ban_callback() {

    // By Default activate do not redirect for logged in users
    if (!get_option('simple_sf_width'))
        update_option('simple_sf_width', '960px');

    // define effect array 
    $simple_sf_effect_arr = array (
        'blind' => 'Blind',
        'bounce' => 'Bounce',
        'clip' => 'Clip',
        'drop' => 'Drop',
        'explode' => 'Explode',
        'fade' => 'Fade',
        'fold' => 'Fold',
        'highlight' => 'Highlight',
        'puff' => 'Puff',
        'pulsate' => 'Pulsate',
        'scale' => 'Scale',
        'shake' => 'Shake',
        'size' => 'Size',
        'slide' => 'Slide',
        'transfer' => 'Transfer'        
    );
    
    
    // form submit  and save values
    if (isset($_POST['submit'])) {
        update_option('simple_sf_pid', $_POST['page_id']);
        update_option('simple_sf_width', $_POST['simple_sf_width']);
        update_option('simple_sf_style', $_POST['simple_sf_style']);
        update_option('simple_sf_hide', isset($_POST['simple_sf_hide']) ? 1 : 0 );
        update_option('simple_sf_delay', isset($_POST['simple_sf_delay']) ? $_POST['simple_sf_delay'] : 0 );
        update_option('simple_sf_effect', $_POST['simple_sf_effect']);
        update_option('simple_sf_activate_shortcode', isset($_POST['simple_sf_activate_shortcode']) ? 1 : 0);
    }

    // read values from option table

    $width = get_option('simple_sf_width');
    $pid = get_option('simple_sf_pid');
    $style = get_option('simple_sf_style');
    $simple_sf_hide = (intval(get_option('simple_sf_hide')) == 1 ) ? 1 : 0;
    $simple_sf_delay = intval(get_option('simple_sf_delay')) ;
    $simple_sf_effect = get_option('simple_sf_effect', 'fade') ;
    $simple_sf_activate_shortcode = get_option('simple_sf_activate_shortcode', 'fade') ;
    
    
    ?>

    <div class="wrap" id='simple-sf'>
        <div class="icon32" id="icon-options-general"><br></div><h2><?php _e('Sticky Footer Configuration'); ?></h2>

        <p>
            <?php _e('Configure sticky footer by completing the following form.') ?>
        </p>    

        <form action="" method="post">
  
            <h3>Required</h3>
            
            <p>
            <label for='simple_sf_page'><strong><?php _e('Select page'); ?></strong></label> <br/>
            <?php wp_dropdown_pages(array('selected' => $pid)); ?>
            </p>
            

            <h3>Optional</h3>
<!--WIDTH-->
            <p>
                <label for='simple_sf_width'><strong><?php _e('Width'); ?></strong></label> <br/>
                <input  type='text' name='simple_sf_width' id='simple-sf-width' 
                        value='<?php echo $width; ?>' 
                        placeholder='<?php _e('960px') ?>' />
            </p>
            <small><?php _e('Adapt the width for your site ') ?></small>


<!-- EFFECT -->
            <p>
                <label for='simple_sf_effect'><strong><?php _e('Animation Effect'); ?></strong></label> <br/>
                <select name="simple_sf_effect" id="simple-sf-effect">
                <?php foreach ($simple_sf_effect_arr as $k => $v): ?>
                    <option value="<?php echo $k; ?>" <?php echo ($k==$simple_sf_effect) ? ' selected="selected"': '' ?> ><?php echo $v; ?></option>    
                <?php endforeach; ?>
                </select>
            </p>
            <small><?php _e('Select an animation.') ?></small>

<!-- DELAY -->
            <p>
                <label for='simple_sf_delay'><strong><?php _e('Delay (s)'); ?></strong></label> <br/>
                <input  type='text' name='simple_sf_delay' id='simple-sf-delay' 
                        value='<?php echo $simple_sf_delay; ?>' 
                        placeholder='<?php _e('3') ?>' />
            </p>
            <small><?php _e('Show the sticky footer after n seconds . Sometimes you want to show the sticky footer after 10-15 seconds. Now you can do this.') ?></small>


            
            
            <p>
                <label for='simple_sf_style'><strong><?php _e('Addition CSS Rules'); ?></strong></label> <br/>
                <textarea name='simple_sf_style' id='simple-sf-style' cols="80" rows="10"><?php echo $style; ?></textarea>
                <br/>
                <small><?php _e('Here you can define addition CSS rules like: rounded borders, gradient background, shadows, etc ...  ') ?></small>
                <br/>
                <small><?php _e('Do not use { }, just enter the css properties ex: background:gray;border-top:1px;') ?></small>

            </p>



            <p>
                <label for='simple_sf_hide'><strong><?php _e('Hide'); ?></strong></label> <br/>
                <input  type='checkbox' name='simple_sf_hide' id='simple-sf-hide'  value='1' 
                        <?php echo ($simple_sf_hide == 1 ) ? " checked='checked'" : "" ?>         />
                <br/>
                <small><?php _e('If this box is checked the Sticky Footer will be a hidden div. It is usefull when you want to put some tracking scripts or other hidden HTML elements ') ?></small>
            <p>
                

            <p>
                <label for='simple_sf_activate_shortcode'><strong><?php _e('I want to use shortcodes'); ?></strong></label> <br/>
                <input  type='checkbox' name='simple_sf_activate_shortcode' id='simple-sf-activate-shortcode'  value='1' 
                        <?php echo ($simple_sf_activate_shortcode == 1 ) ? " checked='checked'" : "" ?>         />
                <br/>
                <small><?php _e('If this box is checked the Sticky Footer will be showed only on the pages where the shortcodes were inserted.') ?></small>
            <p>
                

            <p>
                <input type='submit' name='submit' value='<?php _e('Save') ?>' />
            </p>


        </form>

    </div>

    <?php
}

/** Shortcode **/

function simple_sf_func($atts) {
    
    extract(shortcode_atts( array(
       'pid' => 1    
    ), $atts));
    
    $width =  get_option('simple_sf_width');
    $hide =  get_option('simple_sf_hide');
    $style =  get_option('simple_sf_style');
    $delay =  get_option('simple_sf_delay');
    $activate_shortcode =  get_option('simple_sf_activate_shortcode', 0);
    $effect = get_option('simple_sf_effect', 'fade') ;    
        
    
    ob_start();
// The Loop
   $query = new WP_Query(array('page_id'=>$pid));

    while ($query->have_posts()) :$query->the_post();
        ?>

        <div id="simple-sticky-footer-container">
            <div id="simple-sticky-footer" 
                 style="width: <?php echo $width; ?>; <?php echo ($hide == 1) ? 'display:none': '' ?>; <?php echo (!empty($style)) ? $style: ''?>;">
              <?php the_content(); ?>
            </div>
        </div>

<script>
   delay = <?php echo $delay; ?> * 1000;
   effect = '<?php echo $effect; ?>';
</script>

        <?php
    endwhile;
    wp_reset_postdata();
   
    
   $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
//        $output_string = 'sda';

    return '';
}


add_shortcode( 'simple_sf', 'simple_sf_func' );

// Do the magic stuff
// Front-End 

function simple_sf() {
    $pid = intval(get_option('simple_sf_pid'));
    if ($pid < 1)   return '';
    
    $width =  get_option('simple_sf_width');
    $hide =  get_option('simple_sf_hide');
    $style =  get_option('simple_sf_style');
    $delay =  get_option('simple_sf_delay');
    $activate_shortcode =  get_option('simple_sf_activate_shortcode', 0);
    $effect = get_option('simple_sf_effect', 'fade') ;    
    
    // Do not display if the shortcode was activated for simple sticky footer
    if ($activate_shortcode == 1) return '';
    
    $query = new WP_Query(array('page_id'=>$pid));
    // The Loop
    while ($query->have_posts()) :$query->the_post();
        ?>

        <div id="simple-sticky-footer-container">
            <div id="simple-sticky-footer" 
                 style="width: <?php echo $width; ?>; <?php echo ($hide == 1) ? 'display:none': '' ?>; <?php echo (!empty($style)) ? $style: ''?>;">
              <?php the_content(); ?>
            </div>
        </div>

<script>
   delay = <?php echo $delay; ?> * 1000;
   effect = '<?php echo $effect; ?>';

</script>

        <?php
    endwhile;
    wp_reset_postdata();
}
