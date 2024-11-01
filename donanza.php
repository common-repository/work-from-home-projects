<?php
/*
Plugin Name: Work-from-home Projects
Plugin URI: 
Description: Donanza Project Box Plugin For WordPress
Author: Eyal Benishti
Version: 2.0
Author URI: http://www.donanza.com/
*/
 
 
function showWidget()
{
	echo get_option("dnz_myProjectBox_code");  
}
 
function dnzWidget_myProjectBox($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?><?php echo $after_title;
  showWidget();  
  echo $after_widget;
}
 

function myProjectBox_init()
{
  register_sidebar_widget(__('Work-from-home Projects'), 'dnzWidget_myProjectBox');  
}

function myProjectBox_config_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', __('Work-from-home Projects Configuration'), __('Work-from-home Projects Configuration'), 'manage_options', 'myProjectBox-key-config', 'myProjectBox_conf');
}

function myProjectBox_conf() {
	
	if (isset($_GET['code']))
	{				
		$newCode = str_replace("\'", "'", $_GET['code']);
		$newCode = str_replace('\"', '"', $newCode);
		$newCode = str_replace('widgetan', 'wpan', $newCode);
		update_option("dnz_myProjectBox_code", $newCode);				
	}	
	
	$currentCode = get_option("dnz_myProjectBox_code");
	
	$startAt = strrpos($currentCode,"?");
	$length = strrpos($currentCode,"\"></script>") - 82;
	$currentCode = substr($currentCode,$startAt,$length);		
	
	$domain = $_SERVER['HTTP_HOST'];
	$url = "http://" . $domain . $_SERVER['REQUEST_URI'];
	$urlEndPos = strrpos($url,"key-config") + 10;
	$newurl = substr($url,0,$urlEndPos);

	echo '<iframe src="http://www.donanza.com/publishers/customize?rdurl=',$newurl,'&mustagree=yes&code=',urlencode($currentCode),'" scrolling="yes" frameborder="0" allowTransparency="true" style="border:none; overflow:scroll; width:1020px; height: 760px"/>';	
}

add_action('plugins_loaded', 'myProjectBox_init');
add_action('admin_menu', 'myProjectBox_config_page');

?>