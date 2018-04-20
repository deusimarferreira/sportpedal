<?php

function cwlsm_options_page() {

	global $cwlsm_options;

	ob_start(); ?>
	<div class="wrap">
		<h2>Login Screen Manager</h2>
		<?php
			$input = array(
				"logo_url" => array("text"=>"Logo Image URL","class"=>"cwlsm_file"),
				"fav_icon_url" => array("text"=>"Favicon Url","class"=>"cwlsm_file"),
				"hover_title" => array("text"=>"Hover Title","class"=>"cwlsm_file"),
				"url" => array("text"=>"Url","class"=>"cwlsm_file"),
				"body_bg_color" => array("text"=>"Body Background Color","class"=>"color {hash:true}","default"=>"#F1F1F1"),
				"login_form_bg_color" =>  array("text"=>"Login Form Background Color","class"=>"color {hash:true}","default"=>"#FFFFFF"),
				"text_input_color" => array("text"=>"Input Text Color","class"=>"color {hash:true}","default"=>"#000000"),
				"input_bg_color" => array("text"=>"Input Background Color","class"=>"color {hash:true}","default"=>"#FFFFFF"),
				"label_color" =>  array("text"=>"Label Color","class"=>"color {hash:true}","default"=>"#000000")
			);
		?>
		<form method="post" action="options.php">
			<?php settings_fields('cwlsm_settings_group'); ?>
			<table style="width:585px;float:left;">
				<!-- Media Uploader -->
				<!-- Media Uploader -->
				<?php foreach ($input as $name => $data) : ?>
				<tr>
					<td style="text-align:;"><label class="description" for="cwlsm_settings[<?php echo $name; ?>]"><?php _e($data["text"], 'cwlsm_domain'); ?></label></td>
					<?php if($data["class"]=="color {hash:true}"): ?>
					<td><input class="<?php echo $data["class"]; ?>" id="cwlsm_settings[<?php echo $name; ?>]" size="30" name="cwlsm_settings[<?php echo $name; ?>]" type="text" value="<?php if(empty($cwlsm_options[$name])){echo $data["default"]; }else{ echo $cwlsm_options[$name];} ?>"/>
					<input type="button" value="Restore Default" onclick="cw_df_<?php echo $name; ?>()" />
					<?php else:?>
					<td><input class="<?php echo $data["class"]; ?>" id="cwlsm_settings[<?php echo $name; ?>]" size="45" name="cwlsm_settings[<?php echo $name; ?>]" type="text" value="<?php if(empty($cwlsm_options[$name])){echo $data["default"]; }else{ echo $cwlsm_options[$name];} ?>"/>
					<?php endif;?>
					
					</td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td><label class="description" for="cwlsm_settings[css]"><?php _e("Custom Css", 'cwlsm_domain'); ?></label></td>
					<td><textarea id="cwlsm_settings[css]" style="height:250px;width:390px;"  name="cwlsm_settings[css]" type="text"><?php echo $cwlsm_options["css"]; ?></textarea></td>
				</tr>
				<tr><td></td><td><a style="text-decoration:none;" href="http://wordpress.org/extend/plugins/login-screen-manager/" target="_blank">Hey Rate this Plugin </a>and don't forget to visit my <a style="text-decoration:none;" href="http://www.NihalsCode.com/" target="_blank">site</a>.</td></tr>
				<tr>
					<td></td>
					<td class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Options', 'cwlsm_domain'); ?>" /></td>
				</tr>
			</table>
			<div style="float:right;text-align:center;width:200px;border:1px solid #D9D9D9;padding:10px;">
				<span style="font-size:18px;"><b>Need help?</b></span>
				<div style="padding:5px;">
					Visit <b><a style="text-decoration:none;" href="http://www.NihalsCode.com/" target="_blank">NihalsCode.com</a></b> <br />
				</div>
				<div style="padding:5px;">
					<span style="font-size:18px;"><b>Follow On Facebook</b></span>
					<br />
					<div style="margin-top:10px;">
					<a href="http://www.facebook.com/nazmul.hossain.nihal" target="_blank">
						<img src="http://graph.facebook.com/nazmul.hossain.nihal/picture?height=130&width=130" />
					</a>
					<iframe src="//www.facebook.com/plugins/follow.php?href=https%3A%2F%2Fwww.facebook.com%2Fnazmul.hossain.nihal&amp;width=200&amp;height=80&amp;colorscheme=light&amp;layout=standard&amp;show_faces=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:80px;" allowTransparency="true"></iframe>
					</div>
				</div>
			</div>
		</form>
		
	</div>
	<?php
	echo ob_get_clean();
}

function cwlsm_add_options_link() {
	add_options_page('Login Screen Manager', 'Login Screen', 'manage_options', 'cwlsm-options', 'cwlsm_options_page');
}
add_action('admin_menu', 'cwlsm_add_options_link');

function cwlsm_register_settings() {
	register_setting('cwlsm_settings_group', 'cwlsm_settings');
}
add_action('admin_init', 'cwlsm_register_settings');

?>

<?php

function cwlsm_scripts_method() {
	if(is_admin()){
    wp_enqueue_script('custom_admin_script',  plugins_url('/js/jscolor.js', __FILE__), array('jquery'));
	} 
}    

add_action('init', 'cwlsm_scripts_method');

?>