<?php
/*
Plugin Name: Go To Top Button
Plugin URI: http://wpcode.ru/gototop
Description: Smoothly scroll to the top of Webpage
Version: 1.1
Author: artalex
Author URI: http://wpcode.ru
Text Domain: gototop
Domain Path: /languages/
*/

// localization
function gtt_plugin_init() {
 $plugin_dir = basename(dirname(__FILE__));
 load_plugin_textdomain( 'gototop', false, $plugin_dir.'/languages/' );
}
add_action('plugins_loaded', 'gtt_plugin_init');

// activate plugin
register_activation_hook(__FILE__, 'gtt_set_options');
register_deactivation_hook(__FILE__, 'gtt_unset_options');

// DB settings
$gtt_prefs_table = gtt_get_table_handle();
function gtt_get_table_handle() {
global $wpdb;
return $wpdb->prefix . "gtt";
}

// Get plugin options
function get_gtt_options(){
global $wpdb;
	$table = $wpdb->prefix . "gtt";
	$obj = $wpdb->get_results("SELECT * FROM $table");
	return $obj;
	}

// Initialization
function gtt_set_options() {
	global $wpdb;
	$gtt_prefs_table = gtt_get_table_handle(); 
	$charset_collate = ''; 
	if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') )
	$charset_collate = "DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci"; // unicode
	if($wpdb->get_var("SHOW TABLES LIKE '$gtt_prefs_table'") != $gtt_prefs_table) { # if table not exists
		$sql = "CREATE TABLE `" . $gtt_prefs_table . "` (
			`id` INT NOT NULL AUTO_INCREMENT,
		  	`gtt_position` varchar(24),
		  	`gtt_color` varchar(7),
			`gtt_transparent` varchar(2),
			`gtt_size` varchar(3),
			`gtt_corners` varchar(3),
			`gtt_icon` varchar(3),
			`gtt_icon_color` varchar(7),
			UNIQUE KEY id (id)
		)$charset_collate;

		INSERT INTO `" . $gtt_prefs_table ."` (`gtt_position`, `gtt_color`, `gtt_transparent`, `gtt_size`, `gtt_corners`, `gtt_icon`, `gtt_icon_color`) VALUES ('bottom_right', '#548dbf', '70', '40', '5', '000', '#FFFFFF')";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
    }
}


// delete plugin
function gtt_unset_options () {
	global $wpdb, $gtt_prefs_table;
	delete_option('gtt_modify_title');
	delete_option('gtt_modify_content');
	$sql = "DROP TABLE $gtt_prefs_table";
	$wpdb->query($sql);
}

// Admin menu plugin links
add_action('admin_menu', 'gtt_admin_page');
function gtt_admin_page() {
add_options_page( __('Go-To-Top Button settings' , 'gototop'), __('Go-To-Top Button' , 'gototop'), 'manage_options', plugin_dir_path( __FILE__ ).'/gtt_settings.php');
}

// Loads scripts and css to admin
add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker() {
	wp_enqueue_script('jquery');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
    wp_register_style('flaticon', plugin_dir_url( __FILE__ )  . 'css/flaticon.css');
    wp_enqueue_style( 'flaticon');
    wp_register_script('color-picker', plugins_url('js/color_picker.js', __FILE__ ));
    wp_enqueue_script('color-picker');  
}

// Loads scripts and css to frontend
function gtt_reg_scripts() {
	wp_enqueue_script('jquery');
	wp_register_style('flaticons', plugin_dir_url( __FILE__ )  . 'css/flaticon.css');
    wp_enqueue_style( 'flaticons');
    wp_register_script('scrolltop', plugin_dir_url( __FILE__ )  . 'js/scrolltop.js');
    wp_enqueue_script( 'scrolltop' );
}
add_action('wp_enqueue_scripts', 'gtt_reg_scripts');

// Add button code in footer
function add_gtt_button() {
	$set = get_gtt_options();
	echo '<a style="display:none" id="gtt_link" href="#"><span class="flaticon-'.$set[0]->gtt_icon.'"></span></a>';
}
add_action('wp_footer', 'add_gtt_button');

// CSS in header
function add_gtt_css() {
	$set = get_gtt_options();
	$return = "<style>\n";
	$return .= "#gtt_link {";
	$return .= "display:block; transition: all 0.5s ease 0s; position:fixed; z-index:999999; text-align:center; text-decoration:none;";
	$return .= "width:".$set[0]->gtt_size."px; height:".$set[0]->gtt_size."px; ";
		switch ($set[0]->gtt_position) {
			case 'bottom_right':
				$return .= "bottom:30px; right:30px; ";
				break;
			case 'bottom_left':
				$return .= "bottom:30px; left:30px; ";
				break;
			case 'top_left':
				$return .= "top:30px; left:30px; ";
				break;	
			case 'top_right':
				$return .= "top:30px; right:30px; ";
				break;		
		}
	$return .= "background-color:".$set[0]->gtt_color.";";	
	$return .= "border-radius:".$set[0]->gtt_corners."px;";
	$return .= "opacity: 0.".$set[0]->gtt_transparent.";";
	$return .= "color:".$set[0]->gtt_icon_color.";";
	$return .= "font-size:".(int)($set[0]->gtt_size / 1.9)."px; line-height:1.8;";
	$return .= "}\n";
	$return .= "#gtt_link:hover, #gtt_link:active, #gtt_link:visited, #gtt_link:focus {";
	$return .= "text-decoration:none; opacity:1;outline:none;";
	$return .= "}\n";
	$return .= "</style>\n";

	echo $return;
}
add_action('wp_head', 'add_gtt_css');