<?php
/**
 * Plugin Name: Brid Video
 * Plugin URI: https://wordpress.org/plugins/brid-video-easy-publish/
 * Description: Brid plugin will manage Brid.tv Platform videos.
 * Version: 1.0.8
 * Author: Brid.tv
 * Settings: Brid
 * Author URI: https://brid.tv
 * License: This sottware is not free to modify.
 */

define('BRID_PLUGIN_VERSION', '1.0.8');
define('DEFAULT_PLAYER_ID', '1');
define('BRID_PLUGIN_DIR', dirname( __FILE__ ));
define('BRID_PLUGIN_LIB', BRID_PLUGIN_DIR.'/lib/');
define('BRID_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('DEFAULT_VIDEO_ID', 2);
define('PLUGIN_BASE_FILE', plugin_basename(__FILE__));
//Auth url
define('OAUTH_PROVIDER', 'https://cms.brid.tv'); //bridWordpress.js
//Services url
define('CLOUDFRONT', '//services.brid.tv/');
//Ugc url
define('CDN_HTTP_UGC', '//cdn.brid.tv/');
//Ugc prefix
define('UGC', CDN_HTTP_UGC.'live/');


if(!class_exists('Brid')){

	class Brid {
	    
	    public static $instance = null;
	    
	    static $brid_options  = array('brid_options');

		public static function activate(){
			update_option('brid_options','');
			
        }
        public static function getConst($const){
        	return defined($const) ? constant($const) : '';
        }
        public static function deactivate(){
            delete_option('brid_options');
        }
		public function __construct() {
		    register_activation_hook( __FILE__, array( $this, 'activate' ) );
		    register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		   
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
	register_activation_hook(__FILE__, array('Brid','activate')); 
	/* Runs on plugin deactivation*/
	register_deactivation_hook( __FILE__, array('Brid','deactivate'));
	
	$brid = new Brid();
	//Options helper
	require_once BRID_PLUGIN_LIB. 'BridOptions.php';
	//Most of the Html, templates, pages
	require_once BRID_PLUGIN_LIB. 'BridHtml.php';
	// A class with some methods to do mostly various WordPress-related stuff
	require_once BRID_PLUGIN_LIB. 'BridApi.php';
	// All Main actions used
	require_once BRID_PLUGIN_LIB. 'BridActions.php';
}

?>