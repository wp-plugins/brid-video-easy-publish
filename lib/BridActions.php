<?php
/**
 * BridActions class - Init all WP main hooks, add settings link, add Sub menu links, include all necessary JS files
 *
 * @package plugins.brid.lib
 * @author Brid Dev Team
 * @version 1.0
 */
class BridActions{

        /**
         * Admin init
         *
         */
        public static function init(){
          // register Brid settings options (serialized options data)          
          register_setting('brid_options', 'brid_options'); // Array('site'=>ID, 'player'=>ID, 'oauth_token'=>String token)
          if(BridOptions::areThere()){
            add_action('media_buttons_context', array('BridHtml', 'addPostButton'));
          }else{

            if (!is_plugin_active(BRID_PLUGIN_DIR.'/brid.php')) {
               add_action('admin_notices', array('BridHtml', 'admin_notice_message')); //Display message on activating Plugin
             }
          }
          self::brid_scripts();
        }
        /**
         * Add settings link on plugin page
         *
         */
        public static function brid_settings_link($links) {
          $settings_link = '<a href="options-general.php?page=brid-video-config">Settings</a>';
          array_unshift($links, $settings_link);
          return $links;
        }
        /**
         * Called by add_action to add option page and all other necessary pages
         */
        public static function add_menu() {
            //Add plugins submenu page for Brid Settings
            //add_plugins_page('Brid Video Settings', 'Brid.tv', 'administrator', 'brid-video-config', array('BridActions', 'admin_html'));

            add_options_page('Brid Video Settings', 'Brid.tv', 'administrator', 'brid-video-config', array('BridActions', 'admin_html'));

            //Add subpage (Brid Video Media Library) to the Media Library - @see callback BridHtml::manage_videos()
            if(BridOptions::areThere()){
              $page = add_media_page('Brid Video Manage Videos', 'Brid Video', 'administrator', 'brid-video-manage', array('BridHtml', 'manage_videos'));

              /* Using registered $page handle to hook stylesheet loading */
              add_action( 'admin_print_styles-' . $page, array('BridActions', 'brid_scripts'));
            }

          
        }
        /**
         * Settings page for configuring Brid.tv options
         */
        public static function admin_html(){

            if(!current_user_can('manage_options'))
            {
                wp_die(__('You do not have sufficient permissions to access this page.'));
            }

            if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== false || strpos($_SERVER['SERVER_NAME'], '127.0.0.1') !== false) { 

               wp_die(__('We do not support installing this plugin on localhost.'));
            }
           
            $api = new BridAPI();
            $error = '';
            $success = '';
            $redirect_uri = admin_url('options-general.php?page=brid-video-config');

            // received authorization code, exchange it for an access token

            if (isset($_GET['code'])) {

              $params   = array('code' => $_GET['code'], 'redirect_uri' => $redirect_uri);
              $response = $api->accessToken($params);

              if (isset($response->error)) {
                $error =  "The following error occurred: ".$response->error;
              }
              elseif (isset($response->access_token)) {
              
                BridOptions::updateOption('oauth_token', $response->access_token);
                
                $api = new BridAPI(); // Refresh the API with the latest API token

              }
            }

            $user = $api->userinfo(true);


            if(!empty($user->error)){
              wp_die('User error: '.$user->error);
            }
              //Get site list via Api
              $sites = $api->sitesList(true);


                //User is not authorized yet, no valid access token.
                if ($api->code == 401) {

                     if (isset($_GET['debug'])) { //print debug returns @todo should be removed in production

                        if(isset($api->body->error)){
                            ?>
                                <h3><?php echo $api->body->error; ?></h3>
                            <?php
                        }
                        if(isset($api->body->error_description)){
                            ?>
                                <h5><?php echo $api->body->error_description; ?></h5>
                            <?php
                        }
                      }
                     $error .= (isset($_GET['error_description']) && $_GET['error_description']!='') ? $_GET['error_description'] : ''; 
                     require_once(BRID_PLUGIN_DIR.'/html/form/auth.php');

                 } else {
                    if(empty($user) || !isset($user->id)){

                       if(isset($api->body->error)){
                          $error .= $api->body->error; 
                        }
                        
                        if(isset($api->body->error_description)){
                            $error .=  $api->body->error_description;
                        }

                        require_once(BRID_PLUGIN_DIR.'/html/error.php');

                    }
                  //User is authorized, so show settings page

                    $selected  = BridOptions::getOption('site');   //Is there any selected site saved?
                    $playerSelected  = BridOptions::getOption('player'); //Is there any selected player saved?
                    $oAuthToken  = BridOptions::getOption('oauth_token'); //Oauth token
                    $width  = BridOptions::getOption('width'); //Width
                    $width =  $width!='' ?  $width : '640';
                    BridOptions::updateOption('width', $width); //Do update imediatley for none-existing sites
                    
                    $height  = BridOptions::getOption('height'); //Height
                    $height =  $height!='' ?  $height : '480';
                    BridOptions::updateOption('height', $height); //Do update imediatley for none-existing sites

                    $autoplay  = BridOptions::getOption('autoplay'); //Autoplay
                    $autoplay =  $autoplay!='' ?  $autoplay : '0';
                    BridOptions::updateOption('autoplay', $autoplay); //Do update imediatley for none-existing sites

                    $user_id  = BridOptions::getOption('user_id'); //User id
                    $user_id  = $user_id!='' ? $user_id : $user->id;
                    BridOptions::updateOption('user_id', $user_id); //Do update imediatley for none-existing sites

                    if(!BridOptions::areThere())
                    {
                      $error .= 'Settings are not saved yet.';
                    }

                    //Host video files question
                    if(isset($_GET['settings-updated'])){

                      $partner = $api->partner($selected, true);
                      if(!empty($partner)) {
                        BridOptions::updateOption('question', $partner->Partner->user_choice_upload); 
                        BridOptions::updateOption('upload', $partner->Partner->upload); 
                      }

                    }

                    //User has just authentificated himself, and has only 1 player and 1 site, so redirect him to upload.php
                    if (isset($_GET['code']) && isset($_GET['settings-updated'])) {
                    
                      
                       //wp_safe_redirect( admin_url('upload.php?page=brid-video-manage') ); exit;
                       ?>

                       <script type="text/javascript">
                       <!--
                          window.location= <?php echo "'" . admin_url('upload.php?page=brid-video-manage') . "'"; ?>;
                       //-->
                       </script>
                       <?php
                    }


                    
                    require_once(BRID_PLUGIN_DIR.'/html/form/settings.php');

                 }
              
            
        }
         
        /**
         * Proper way to enqueue scripts and styles
         * @todo Merge these into one file
         */
        public static function brid_scripts() {
          //Include necessary js files
          
          wp_enqueue_script('bridPlayer', 'http://cms.brid.tv/player/build/brid.min.js', array(), null); //Add custom js
          wp_enqueue_script('bridWordpress', BRID_PLUGIN_URL.'js/bridWordpress.js'); //Add custom js
          wp_enqueue_script('bridWordpressSave', BRID_PLUGIN_URL.'js/brid.save.js'); //Add custom js
          // wp_enqueue_script('bridUi', BRID_PLUGIN_URL.'js/jquery.ui.js'); //Add custom js	  
		  $jquueryUiLibrarys = array('core','datepicker','sortable','draggable','droppable','resizable','button','datepicker','dialog','effect-blind','effect-bounce','effect-clip','effect-drop','effect-explode','effect-fade'
		  ,'effect-fold','effect-highlight','effect-pulsate','effect-scale','effect-shake','effect-slide','effect-transfer','menu','position','progressbar','slider','spinner','tabs','tooltip','widget','effect'
		  ,'accordion','autocomplete');
		  
		  foreach($jquueryUiLibrarys as $library){
			wp_enqueue_script('jquery-ui-'.$library);
		  }
		  
          wp_enqueue_script('bridDatePicker', BRID_PLUGIN_URL.'js/jquery.date.js'); //Add custom js
          wp_enqueue_script('bridHandlebars', BRID_PLUGIN_URL.'js/handlebars.js'); //Add custom js
          wp_enqueue_script('bridThumbScroll', BRID_PLUGIN_URL.'js/jquery.thumbnailScroller.js'); //Playlist scroller
          wp_enqueue_script('bridColorbox', BRID_PLUGIN_URL.'js/jquery.colorbox-min.js'); //Add custom lightbox
          wp_enqueue_script('bridChosen', BRID_PLUGIN_URL.'js/jquery.chosen.js'); //Add custom selectbox

          //css
          wp_enqueue_style('brid-css', BRID_PLUGIN_URL.'css/brid.css'); //Add custom css
          wp_enqueue_style('brid-css-font', 'http://fonts.googleapis.com/css?family=Fjalla+One'); //Add custom css
		  wp_enqueue_style('brid-css-colorbox', BRID_PLUGIN_URL.'css/colorbox.css');//lightbox css
          
        }
        /**
         * Used to manipulate search string (video search, playlist search)
         */
        public static function myStartSession() {
          if(!session_id()) {
              session_start();
          }
        }

        public static function myEndSession() {
          session_destroy ();
        }
        public static function wp_smushit_filter_timeout_time($time) {
           $time = 60; //new number of seconds
           return $time;
      }

}
add_filter( 'http_request_timeout', array('BridActions','wp_smushit_filter_timeout_time'));
//Shortcode function
add_shortcode('brid', array('BridHtml' ,'brid_shortcode'));
//Add necessary js
add_action('admin_enqueue_scripts', array('BridActions', 'brid_scripts'));

add_action('admin_init', array('BridActions', 'init'));

//add_action('init', array('BridActions', 'myStartSession'), 1);
//add_action('wp_logout', array('BridActions', 'myEndSession'));
//add_action('wp_login', array('BridActions','myEndSession'));

//@see http://codex.wordpress.org/AJAX_in_Plugins
add_action('wp_ajax_brid_api_get_players', array('BridHtml', 'brid_api_get_players'));

add_action('admin_menu', array('BridActions', 'add_menu'));

add_filter('plugin_action_links_'.PLUGIN_BASE_FILE , array('BridActions', 'brid_settings_link'));

?>