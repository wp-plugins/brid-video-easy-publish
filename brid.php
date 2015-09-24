<?php
/**
 * Plugin Name: Brid Video
 * Plugin URI: https://wordpress.org/plugins/brid-video-easy-publish/
 * Description: This plugin allows for the easy insertion of <a href="https://cms.brid.tv" target="_blank">BridTv</a> videos and playlists into your Wordpress site or blog. Brid.tv plugin seamlessly integrates with the Wordpress Media feature and provides an easy way to publish and monetize your video library.
 * Version: 2.1.0
 * Author: Brid.tv
 * Settings: Brid
 * Author URI: https://brid.tv
 * License: This software is not free to modify.
 */

//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//DO NOT CHANGE
define('BRID_PLUGIN_VERSION', '2.1.0'); //Change in upper comment
define('DEFAULT_PLAYER_ID', '1');
define('DEFAULT_PARTNER_ID', '264');
define('BRID_PLUGIN_DIR', dirname( __FILE__ ));
define('BRID_PLUGIN_LIB', BRID_PLUGIN_DIR.'/lib/');
define('BRID_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('DEFAULT_VIDEO_ID', 2);
define('PLUGIN_BASE_FILE', plugin_basename(__FILE__));
//define('BRID_DEV', true);
//Auth url
define('OAUTH_PROVIDER', 'https://cms.brid.tv'); //bridWordpress.js
//Services url
define('CLOUDFRONT', '//services.brid.tv/');
//Ugc url
define('CDN_HTTP_UGC', '//cdn.brid.tv/');
//Ugc prefix
define('UGC', CDN_HTTP_UGC.'live/');
define('ACCESS_ERROR_MSG', '<br/>Access to this place or content is restricted. If you think this is a mistake, please contact us at <a href="mailto:contact@brid.tv?subject=Wp Issue Question ('.get_site_url().')">contact@brid.tv</a>.<br/><a href="'.admin_url('admin-ajax.php?action=unauthorizeBrid&red=1').'">Unauthorize account</a>');


if(!class_exists('Brid')){
//Options helper
require_once BRID_PLUGIN_LIB. 'BridOptions.php';
// A class with some methods to do mostly various WordPress-related stuff
require_once BRID_PLUGIN_LIB. 'BridApi.php';

	class Brid {
	    
	    public static $instance = null;
	    
	    static $brid_options  = array('brid_options');

		public static function activate(){
			if(get_option('brid_options')==''){
				update_option('brid_options','');
				self::notice('activated');
			}else {
				self::notice('reactivated');
			}
			
        }
        public static function getConst($const){
        	return defined($const) ? constant($const) : '';
        }
        public static function notice($action, $email='support@brid.tv'){
        	$blog = get_site_url();
        	@wp_mail($email, 'Brid.tv WP plugin '.$action, 'Blog ('.$blog.') has '.$action.' Brid.tv plugin at:'.date('Y-m-d H:i:s').' Plugin Ver:'.BRID_PLUGIN_VERSION.' Php Ver.:'.phpversion());
        }
        public static function deactivate(){
           self::notice('deactivated');
        }
        public static function uninstall(){
        	//Remove oauth_token from Brid
        	$api = new BridAPI();
        	$token =  BridOptions::getOption('oauth_token',true);
        	$api->uninstall($token, true);
        	//Delete brid options from options table
            delete_option('brid_options');
            //Send notice
            self::notice('uninstalled');
        }
		public function __construct() {
		    register_activation_hook( __FILE__, array( 'Brid', 'activate' ) );
		    register_deactivation_hook( __FILE__, array( 'Brid', 'deactivate' ) );
		    register_uninstall_hook( __FILE__, array( 'Brid', 'uninstall' ) );
		   
		    self::$instance = $this;
		}

		private static function instance() {
		    if ( self::$instance ) return self::$instance;
		    else return new Brid();
		}

	}
}


if(class_exists('Brid'))
{
	/* Runs when plugin is activated */
	//register_activation_hook(__FILE__, array('Brid','activate')); 
	/* Runs on plugin deactivation*/
	//register_deactivation_hook( __FILE__, array('Brid','deactivate'));
	
	$brid = new Brid();
	//Most of the Html, templates, pages
	require_once BRID_PLUGIN_LIB. 'BridHtml.php';
	//Manage views from post screen
	require_once BRID_PLUGIN_LIB. 'BridQuickPost.php';
	//Manage shortcodes
	require_once BRID_PLUGIN_LIB. 'BridShortcode.php';
	//Tiny plugin
	require_once BRID_PLUGIN_LIB. 'BridTiny.php';
	// All Main actions used
	require_once BRID_PLUGIN_LIB. 'BridActions.php';
	//Brid Playlist Widget
	require_once BRID_PLUGIN_LIB. 'BridPlaylist_Widget.php';
	//JoyRide
	require_once BRID_PLUGIN_LIB. 'BridJoyRide.php';
}