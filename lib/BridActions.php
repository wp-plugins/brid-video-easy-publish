<?php
/**
 * BridActions class - Init all WP main hooks, add settings link, add Sub menu links, include all necessary JS files
 *
 * @package plugins.brid.lib
 * @author Brid Dev Team
 * @version 1.0
 */
class BridActions{
         /*
          * Include js and css only where we need them
          */
         public static function includeScripts(){

            global $pagenow;

            return (
                      $pagenow=='post-new.php' || 
                      $pagenow=='post.php' ||  
                      ($pagenow=='options-general.php' && isset($_GET['page']) && $_GET['page']=='brid-video-config-setting') || 
                      ($pagenow == 'admin.php') // && isset($_GET['page']) && (in_array($_GET['page'], array('brid-video-menu', 'brid-video-config', 'brid-video-config-setting'))))
                      );
         }
         public static function meta(){
             $content = BRID_PLUGIN_VERSION;
             try{
               $opt = get_option('brid_options');
               if($opt!=''){

                if(isset($opt['oauth_token']))
                  //unset($opt['oauth_token']);

                $opt = array_merge($opt, BridShortcode::getSize());

                $content = implode('|', array_map(function ($v, $k) { return $k . ':' . $v; }, $opt, array_keys($opt)));

              }else{
                //oauth_token
                $content .= ' auth:0';
              }
             }catch(Exception $e) {}
             echo '<meta name="BridPlugin" content="'.$content.'" />';
         }
        /**
         * Admin init
         *
         */
        public static function init(){

          // register Brid settings options (serialized options data)          
          register_setting('brid_options', 'brid_options'); // Array('site'=>ID, 'player'=>ID, 'oauth_token'=>String token)



          global $pagenow;
          if( $pagenow=='widgets.php'){

            wp_enqueue_script('jquery');
                wp_enqueue_script('bridWidgetsAdmin',  BRID_PLUGIN_URL.'js/brid.admin.widget.js', array(), null); //Add custom js

          }
          
          //Add necessary js
          if (BridActions::includeScripts()){
            
            add_action('admin_enqueue_scripts', array('BridActions', 'brid_scripts'));

          }
          if(BridOptions::areThere()){
               
              add_action('media_buttons_context', array('BridHtml', 'addPostButton'));
              
          }else{

            if (!is_plugin_active(BRID_PLUGIN_DIR.'/brid.php')) {
            
               add_action('admin_notices', array('BridHtml', 'admin_notice_message')); //Display message on activating Plugin
             }
          }
          

          //self::brid_scripts();
         
        }
       
      
        /**
         * Add settings link on plugin page
         *
         */
        public static function brid_settings_link($links) {
          $settings_link = '<a href="admin.php?page=brid-video-config-setting">Settings</a>';
          array_unshift($links, $settings_link);
          return $links;
        }

        /** Step 1. */
        
      
        /**
         * Called by add_action to add option page and all other necessary pages
         */
        public static function add_menu() {
            //Add plugins submenu page for Brid Settings
            //add_plugins_page('Brid Video Settings', 'Brid.tv', 'administrator', 'brid-video-config', array('BridActions', 'admin_html'));

           

            if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
                //Add Brid.tv Secion
                add_menu_page( 'Brid Video', 'Brid.tv', 'edit_posts', 'brid-video-menu', array('BridHtml', 'manage_videos'), BRID_PLUGIN_URL.'img/16x16.png', '10.121');
                //Add Brid.tv Library menu (will rename default)
                add_submenu_page('brid-video-menu', 'Brid Video Library', 'Video Library', 'edit_posts', 'brid-video-menu' );
                
                //add_action('load-'.$my_admin_page, array('BridActions','brid_scripts'));

                //Add submenu page into Brid.tv section with Brid.tv Settings options
                add_submenu_page( 'brid-video-menu', 'Brid Video Settings', 'Settings', 'manage_options', 'brid-video-config', array('BridActions', 'admin_html'));
                
            }
              //add_options_page( 'Brid Video', 'Brid.tv', 'administrator', 'brid-video-library', array('BridHtml', 'mediaLibrary') );

              //$page = add_media_page('Brid Video Manage Videos', 'Brid Video', 'manage_options', 'brid-video-manage', array('BridHtml', 'manage_videos'));

              /* Using registered $page handle to hook stylesheet loading */
              //add_action( 'admin_print_styles-' . $page, array('BridActions', 'brid_scripts'));
            

              
                //Add Brid.tv Settings page into Settings section
                add_options_page('Brid.tv Settings', 'Brid.tv', 'administrator', 'brid-video-config-setting', array('BridActions', 'admin_html'));

          
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
            $redirect_uri = admin_url('admin.php?page=brid-video-config-setting');

            // received authorization code, exchange it for an access token

            if (isset($_GET['code'])) {

              $params   = array('code' => $_GET['code'], 'redirect_uri' => $redirect_uri);
              $response = $api->accessToken($params);

              if (isset($response->error)) {
                $error =  "The following error occurred: ".$response->error;
                if(isset($response->error_description)){
                   $error .= '<br/>Error: '.$response->error_description;
                }
              }
              elseif (isset($response->access_token)) {
                

                BridOptions::updateOption('oauth_token', $response->access_token);
                BridOptions::updateOption('ver', BRID_PLUGIN_VERSION);
                /*if(empty($_POST['brid_options'])){
                  BridOptions::updateOption('ovr_yt', 1);
                  BridOptions::updateOption('ovr_def', 1);
                  BridOptions::updateOption('intro_enabled', 1);
                  BridOptions::updateOption('aspect', '1');
                }*/
                $api = new BridAPI(); // Refresh the API with the latest API token

              }
            }


            /*****


                API CALL


            ******/
            $user = $api->userinfo(true);


            if(!empty($user->error)){
              wp_die('User error: '.$user->error);
            }
              /*****


                API CALL


              ******/
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
                     
                     $numOfVideos = 0;
                     //Try to count videos (max 500)
                     $query_videos_args = array(
                          'post_type' => 'attachment', 'post_mime_type' =>'video', 'post_status' => 'inherit', 'posts_per_page' => 500,
                      );

                     delete_option('brid_options');

                      $query_videos = new WP_Query( $query_videos_args );
                     

                      $numOfVideos = count($query_videos->posts);

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

                    //Auto save site id - only first time after authorization
                    $selected  = BridOptions::getOption('site',true);
                    if(empty($selected) && !empty($sites)){
                      $t = (array)$sites;
                      if(!empty($t) && is_array($t))
                      {
                       
                        reset($t);
                        $firstSiteId = key($t);
                        //Only first time after auth
                        BridOptions::updateOption('site',$firstSiteId);
                      }

                    }
                    
                    if(!empty($_POST['brid_options'])){

                        foreach ($_POST['brid_options'] as $key => $value) {
                          BridOptions::updateOption($key, $value); 
                        }
                    }
                    
                    if(isset($_POST['Player'])){
                        
                        //widht, height, autoplay options
                        if(isset($_POST['Player'])){
                          if(isset($_POST['Player']['width'])){

                             BridOptions::updateOption('width', intval($_POST['Player']['width'])); 
                          }
                          if(isset($_POST['Player']['height'])){

                             BridOptions::updateOption('height', intval($_POST['Player']['height'])); 
                          }
                          if(isset($_POST['Player']['autoplay'])){

                             BridOptions::updateOption('autoplay', intval($_POST['Player']['autoplay'])); 
                          }
                          //Monetization on player level
                          //if(isset($_POST['Player']['monetize'])){

                             //BridOptions::updateOption('autoplay', intval($_POST['Player']['autoplay'])); 
                         // }


                          //Skin[templatized]
                          if(isset($_POST['Skin']['templatized']) && $_POST['Skin']['templatized']){
                            unset($_POST['Player']['skin_id']);
                          }
                          /*****
                              API CALL
                          ******/
                          $savePlayer = $api->editPlayer($_POST, true);
                        
                        }

                    }

                    if(!empty($selected) && isset($_POST['Partner'])){
                        /*****
                            API CALL
                        ******/
                        $resp = $api->updatePartnerField($_POST['Partner'], true);

                    }

                    $selected  = BridOptions::getOption('site',true);
                     /*****
                          API CALL
                     ******/
                    //Get current partner selected
                    $partner = $api->partner($selected, true);
                     if(!empty($partner->error)){
                      wp_die('Partner Error: '.$partner->error.ACCESS_ERROR_MSG);
                    }

                    $playerSelected  = BridOptions::getOption('player',true); //Is there any selected player saved?
                    $oAuthToken  = BridOptions::getOption('oauth_token'); //Oauth token

                    $width  = BridOptions::getOption('width',true); //Width
                    $width =  $width!='' ?  $width : '640';
                    BridOptions::updateOption('width', $width); //Do update imediatley for none-existing sites
                    
                    $height  = BridOptions::getOption('height',true); //Height
                    $height =  $height!='' ?  $height : '480';
                    BridOptions::updateOption('height', $height); //Do update imediatley for none-existing sites

                    $autoplay  = BridOptions::getOption('autoplay',true); //Autoplay
                    $autoplay =  $autoplay!='' ?  $autoplay : '0';
                    BridOptions::updateOption('autoplay', $autoplay); //Do update imediatley for none-existing sites

                    $aspect  = BridOptions::getOption('aspect',true); //Aspect (responsive width/height)
                    $aspect =  $aspect!='' ?  $aspect : '1';
                    BridOptions::updateOption('aspect', $aspect); //Do update imediatley for none-existing values

                    $user_id  = BridOptions::getOption('user_id',true); //User id
                    $user_id  = $user_id!='' ? $user_id : $user->id;
                    BridOptions::updateOption('user_id', $user_id); //Do update imediatley for none-existing sites

                    //intro_enabled - Update it via partner data to sync it with cms
                    //$intro_enabled  = BridOptions::getOption('intro_enabled',true); //User id
                    $intro_enabled  = $partner->Partner->intro_video; //$intro_enabled!='' ? $intro_enabled : 1;
                    BridOptions::updateOption('intro_enabled', $intro_enabled); //Do update imediatley for none-existing sites
                    
                    //Visual enabled
                    $visual_preview  = BridOptions::getOption('visual',true); //Visual preview
                    $visual_preview  = $visual_preview!='' ? $visual_preview : 0;
                    BridOptions::updateOption('visual', $visual_preview); //Do update imediatley for none-existing sites

                    //Override default YT shortcode
                    $override_youtube  = BridOptions::getOption('ovr_yt',true); //User id
                    $override_youtube  = $override_youtube!='' ? $override_youtube : 1;
                    BridOptions::updateOption('ovr_yt', $override_youtube); //Do update imediatley for none-existing sites

                    //Override default Video element in WP
                    $override_def_player  = BridOptions::getOption('ovr_def',true); //User id
                    $override_def_player  = $override_def_player!='' ? $override_def_player : 1;
                    BridOptions::updateOption('ovr_def', $override_def_player); //Do update imediatley for none-existing sites
                    
                    if(!BridOptions::areThere())
                    {
                      $error .= 'Settings are not saved yet.';
                    }
                   


                    //Host video files question
                    if(isset($_GET['settings-updated'])){

                      //$partner = $api->partner($selected, true);
                      if(!empty($partner)) {
                        BridOptions::updateOption('question', $partner->Partner->user_choice_upload); 
                        BridOptions::updateOption('upload', $partner->Partner->upload); 
                      }

                    }
                    
                    //$api = new BridAPI();
                   

                    $players = array();

                    $skins = array();
                    

                    if($selected!=''){
                      /*****


                          API CALL


                      ******/
                      //Get players list
                      $players = $api->call(array('url'=>'players/'.$selected), true);

                      //Auto save player id - only first time after authorization
                      $playerSel  = BridOptions::getOption('player',true);

                      if(!empty($players) && isset($players[0]->Player->id) && empty($playerSel)){
                        //Only first time after auth
                       

                        $player = $players[0]->Player;
                      }else{
                        foreach ($players as $key => $value) {
                          if($playerSel==$players[$key]->Player->id){
                            $player = $players[$key]->Player;
                            break;
                          }
                        }
                        
                      }
                      //Ako je neko setovao player u WP kao default, a obrisao ga u CMS
                      if(!empty($players) && isset($players[0]->Player->id) && empty($player)){
                         $player = $players[0]->Player;
                      }
                      //Update these to sync with cms
                      if(!empty($player)){

                        BridOptions::updateOption('player',$player->id);
                        BridOptions::updateOption('width',$player->width);
                        BridOptions::updateOption('height',$player->height);
                        $width = $player->width;
                        $height = $player->height;
                        $autoplay = $player->autoplay;
                      }
                      /*****

                          API CALL

                      ******/
                      //Get skins list
                      $skins = $api->call(array('url'=>'skins/'.$selected), true);

                    }
                   
                    
                    $playerIdOpt  = BridOptions::getOption('player'); //Height
                   
                    //$premium = ($upload=='' || $upload==0) ? 0 : 1;

                     $premium = $user->plan_id;
                     $ask = true;
                     //if(BridOptions::getOption('question')=='' || BridOptions::getOption('question')==0){
                      //Get partner Info

                      //$partner = $api->partner(BridOptions::getOption('site'), true);
                      if(!empty($partner)){
                        //$premium = true;
                        //Already asked (checked on server side also)
                        /*if($partner->Partner->upload && $partner->Partner->upload_on){
                          $premium = true;
                        }*/
                        if($partner->Partner->user_choice_upload){
                          $ask = false;
                        }
                      }
                     ///}
                  
                    $playerId = $playerIdOpt!='' ? $playerIdOpt : DEFAULT_PLAYER_ID;

                    require_once(BRID_PLUGIN_DIR.'/html/form/settings.php');

                 }
              
              wp_enqueue_media();
        }

        public static function canInclude(){
          global $pagenow, $typenow;
      

          if(in_array($pagenow, array('post-new.php', 'post.php'))){
            return true;
          }

        }
         
        /**
         * Proper way to enqueue scripts and styles
         * @todo Merge these into one file
         */
        public static function brid_scripts() {
          //Include necessary js files

          self::canInclude();
          //Include player
          wp_enqueue_script('jquery');
          wp_enqueue_script('bridPlayer',  CLOUDFRONT.'player/build/brid.min.js', array(), null); //Add custom js
          if(!defined('BRID_DEV'))
          {
            //Include scripts optimized
            wp_enqueue_script('bridDatePicker', BRID_PLUGIN_URL.'js/brid.admin.min.js'); //Add custom js
            //css
            wp_enqueue_style('brid-css', BRID_PLUGIN_URL.'css/brid.min.css'); //Add custom css
          }else{
            //Include scripts optimized
            $scripts = array('brid.save', 'bridWordpress', 'handlebars', 'jquery.chosen', 'jquery.colorbox-min', 'jquery.date', 'jquery.thumbnailScroller');

            foreach ($scripts as $value) {
              wp_enqueue_script($value, BRID_PLUGIN_URL.'js/dev/'.$value.'.js'); //Save handler
            }
            
            //css
            wp_enqueue_style('brid-css', BRID_PLUGIN_URL.'css/brid.css'); //Add custom css
          }
          //wp_enqueue_style('brid-css-player', '//losmi-services.brid.tv/ugc/partners/style/brid.css'); //Add custom css
          wp_enqueue_style('brid-css-font', '//fonts.googleapis.com/css?family=Fjalla+One'); //Add custom css
		      
         
          
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

$phpVersion =  phpversion();
if ( version_compare( phpversion(), '5.3-z', '>=' )) {
  //5.3
  function register_bridplaylist_widget() {
    register_widget( 'BridPlaylist_Widget' );
  }
  add_action( 'widgets_init', 'register_bridplaylist_widget' );
}else{
  //5.2
  add_action('widgets_init',
     create_function('', 'return register_widget("BridPlaylist_Widget");')
  );
}

add_filter( 'http_request_timeout', array('BridActions','wp_smushit_filter_timeout_time'));


add_action('admin_init', array('BridActions', 'init'));

//add_action('init', array('BridActions', 'myStartSession'), 1);
//add_action('wp_logout', array('BridActions', 'myEndSession'));
//add_action('wp_login', array('BridActions','myEndSession'));

//On partner change in select menu (get players list for a specific partner)
add_action('wp_ajax_getPartnerAndPlayersWithDefaultPlayer', array('BridHtml', 'getPartnerAndPlayersWithDefaultPlayer'));
//Menu init
add_action('admin_menu', array('BridActions', 'add_menu'));
//Add settings link
add_filter('plugin_action_links_'.PLUGIN_BASE_FILE , array('BridActions', 'brid_settings_link'));

add_action('wp_head', array('BridActions', 'meta'));