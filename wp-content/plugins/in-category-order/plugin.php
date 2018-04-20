<?php
/*
Plugin Name: In Category Order 
Plugin URI: http://en.bainternet.info 
Description: This plugin lets you set the order of posts per category 
Version: 0.0.1 
Author: bainternet 
Author Email: admin@bainternet.info 
License:

  Copyright @ bainternet (admin@bainternet.info)

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
if (!class_exists('in_cat_order')){

    class in_cat_order {
		/****************
		 *  Public Vars *
		 ***************/
		 
        /**
         * $dir 
         * 
         * olds plugin directory
         * @var string
         */
		public $dir = '';
		/**
		 * $url 
		 * 
		 * holds assets url
		 * @var string
		 */
        public $url = '';
        /**
         * $txdomain 
         *
         * holds plugin textDomain
         * @var string
         */
        public $txdomain = 'in-cat-order';
		
		/****************
		 *    Methods   *
		 ***************/ 

        /**
         * Plugin class Constructor
         */
        function __construct() {
			$this->setProperties();
        	$this->dir = plugin_dir_path(__FILE__);
        	$this->url = plugins_url('assets/', __FILE__);
			$this->hooks();
        }
        
        /**
         * hooks 
         *
         * function used to add action and filter hooks 
         * Used with `adminHooks` and `clientHokks`
         *
         * hooks for both admin and client sides should be added at the buttom
         * 
         * @return void
         */
		public function hooks(){
			if(is_admin())
				$this->adminHooks();
			else
				$this->clientHooks();
			
			/**
			 * hooks for both admin and client sides
			 * hooks should be here
			 */
			add_action('pre_get_posts',array($this,'pre_get_posts'));
		}
		
		/**
		 * adminHooks 
		 * 
		 * Admin side hooks should go here
		 * @return void
		 */
		function adminHooks(){
			//add extra fields to category edit form hook
			add_action ( 'edit_category_form_fields', array($this,'extra_category_fields'));
			//save extra fields
			add_action ( 'edited_category', array($this,'save_extra_fields_callback'));

			
		}

		/**
		 * clientHooks
		 *
		 *  client side hooks should go here
		 * @return void
		 */
		function clientHooks(){}
		
		/**
 		 * setProperties 
 		 *
 		 * function to set class Properties
 		 * @param array   $args       array of arguments
 		 * @param boolean $properties arguments to set
 		 */
 		public function setProperties($args = array(), $properties = false){
			if (!is_array($properties))
				$properties = array_keys(get_object_vars($this));
 
			foreach ($properties as $key ) {
			  $this->$key = (isset($args[$key]) ? $args[$key] : $this->$key);
			}
		}

		
		/**
		 * createNewView 
		 *
		 * This create a new EasyView instance
		 * @param  array  $args [description]
		 * @return object EasyView instance
		 */
		public function createNewView($args = array('vars' => array())){
			if(!class_exists('EasyView'))
				require_once($this->dir.'/classes/EasyView.php');
			return new EasyView('',$args);
		}
		/**
		 * createViewGet 
		 *
		 * This is a shorthand function for creating a new EasyView object 
		 * and geting the rendered template.
		 *
		 * 
		 * @param  string $template    Template File
		 * @param  string $templatedir templates directory
		 * @param  array  $args        view args
		 * @return string rendered view as astring
		 */
		public function createViewGet($template = '', $templatedir = '', $args = array('vars' => array())){
			$v = $this->createNewView($templatedir, $args);
			return $v->getRender($template);
		}

		public function pre_get_posts($q){
			if ($q->is_main_query() && $q->is_category()){
				$order  = $this->get_all_category_posts(get_queried_object_id());
				if (count($order)> 0 ){
					$q->set('post__in',$order);
					$q->set('orderby','post__in');
				}
			}
		}

		/**
		 * extra_category_fields 
		 *
		 * add the drag and drop interface to the edit category
		 * @param  object $tag 
		 * @return void
		 */
		function extra_category_fields($tag){
			wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('jquery-ui-sortable');
			$t_id  = $tag->term_id;
			$rows  = '';
			$posts = $this->get_all_category_posts($t_id);
			$table = $this->createNewView();
			$table->label      = __('In Category Order',$this->txdomain);
			$table->tname      = __('Name',$this->txdomain);
			$table->tid        = __('ID',$this->txdomain);
			$table->labelClear = __('Clear Order',$this->txdomain);
			$table->tthumb     = __('Thumbnail',$this->txdomain);
			$table->tsure     = __('Are you sure?',$this->txdomain);			
		    foreach ($posts as $post) {
		    	$row= $this->createNewView();
				$row->name    = get_post_field( 'post_title', $post);
				$row->tremove = __('Remove',$this->txdomain);
				$row->id      = $post;
		    	$row->thumb  = (has_post_thumbnail($post))? get_the_post_thumbnail($post, array(80,80)): 'none';
		    	$rows  .= $row->getRender($this->dir.'/views/in_row_view.php');
		    }

		    $table->rows = $rows;
		    $table->render($this->dir.'/views/in_table_view.php');
		}

		/**
		 * save_extra_fields_callback
		 *
		 * save the post order on category save.
		 * @param  int $term_id 
		 * @return void
		 */
        function save_extra_fields_callback( $term_id ) {
            $t_id = $term_id;
            $terms_meta = get_option( 'in_category');
            $term_meta = isset($terms_meta[$term_id])? $terms_meta[$term_id]: array();
            if (isset($_POST['clear_in_cat_order'])){
            	//save the option array
            	unset($terms_meta[$term_id]);
            	update_option( 'in_category', $terms_meta );
            	return $y_id;
            }
            $keys = array('in_cat_order');
            foreach ($keys as $key){
                if (isset($_POST[$key])){
                    $term_meta = $_POST[$key];
                }else{
                    unset($term_meta[$key]);
                }
            }
            //save the option array
            $terms_meta[$term_id] = $term_meta;
            update_option( 'in_category', $terms_meta );
        }

        /**
         * get_all_category_posts 
         *
         * gets a list of all posts from a category
         * @param  int $cat_id 
         * @return array
         */
		function get_all_category_posts($cat_id = null){
			if ($cat_id == null) return array();
			$cat_meta = get_option( "in_category");
    		$order = isset($cat_meta[$cat_id])? $cat_meta[$cat_id]: array();
    		$posts = get_posts(array(
    			'post_type' => 'post',
    			'posts_per_page' => -1,
    			'post__not_in' => $order,
    			'fields' => 'ids',
    			'cat' => $cat_id
    			)
    		);
    		foreach ((array)$posts as $p) {
    			$order[] = $p;
    		}
    		return $order;
		}
		
    } // end class
}//end if
$GLOBALS['in_cat_order'] = new in_cat_order();