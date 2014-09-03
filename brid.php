<?php
/**
 * Plugin Name: Brid Video
 * Plugin URI: http://www.brid.tv
 * Description: Brid plugin will manage Brid.tv Platform videos.
 * Version: 1.0.0
 * Author: Brid.tv
 * Settings: Yuhu
 * Author URI: http://brid.tv
 * License: This sottware is not free to modify.
 * @todo Podkomentarisati deo za ini_set
 */

define('BRID_PLUGIN_VERSION', '1.0.0');
define('BRID_PLUGIN_DIR', dirname( __FILE__ ));
define('BRID_PLUGIN_LIB', BRID_PLUGIN_DIR.'/lib/');

define('BRID_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('DEFAULT_VIDEO_ID', 2);
define('PLUGIN_BASE_FILE', plugin_basename(__FILE__));

define('CDN_HTTP', 'http://cms.brid.tv/'); //BridApi.php and bridWordpress.js
define('UGC', CDN_HTTP.'ugc/');

if(!class_exists('Brid')){

	class Brid {
	    
	    public static $instance = null;
	    
	    static $brid_options  = array('brid_options');

		public static function activate(){
			update_option('brid_options','');
			
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