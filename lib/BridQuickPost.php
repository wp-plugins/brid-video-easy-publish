<?php
/**
 * BridHtml class will manage all forms from Post/Page screen
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.0
 */

class BridQuickPost {

	/**
	 * Main video library pop-up
	 */
    public static function bridVideoLibrary(){

    	$playerSelected  = BridOptions::getOption('player'); //Is there any selected player saved?
        $width  = BridOptions::getOption('width'); //Width
        $width =  $width!='' ?  $width : '640';
        
        $height  = BridOptions::getOption('height'); //Height
        $height =  $height!='' ?  $height : '480';

        $playerSettings = json_encode(array('id'=>$playerSelected, 'width'=>$width, 'height'=>$height));

        
        $partnerData = BridHtml::getPartnerData();
        $partner = $partnerData['Partner'];
        $upload = $partnerData['upload'];

    	require_once(BRID_PLUGIN_DIR.'/html/library.php');
    	die();
    }
	/**
	 * [VIDEO LSIT Library from Post screen]
	 * Get paginated video list by partner id
	 */
	public static function videoLibraryPost(){

		 $api = new BridAPI();
		 $partner_id = BridOptions::getOption('site');
		 //Sanitize search text if there is any
		 if(isset($_POST['search'])){
    		$_POST['search'] = sanitize_text_field($_POST['search']);
		 }
		 $subaction = isset($_POST['subaction']) ? $_POST['subaction'] : '';

		 $mode = isset($_POST['mode']) ? $_POST['mode'] : '';

		 $playlistType = isset($_POST['playlistType']) ? $_POST['playlistType'] : 0;

		 //Turn off buttons and quick icons if we are on post screen
		 $buttonsOff = isset($_POST['buttons']) ? $_POST['buttons'] : false;
			
		 $_POST['limit'] = 8;
		 //Get video list
		 $videosDataset = $api->videos($partner_id, true);

		 //print_r($videosDataset);
		 //Is there anu search string set?
		 $search = '';
		 if(isset($_SESSION['Brid.Video.Search']))
		 {
		 	$search = $_SESSION['Brid.Video.Search'];
		 }
		 //Do we need to ask upload question?
		 $ask = false;
		 if(BridOptions::getOption('question')=='' || BridOptions::getOption('question')==0){
		 	//Get partner Info
 			$partner = $api->partner(BridOptions::getOption('site'), true);
 			if(!empty($partner)){
	 			$ask = true;
	 			//Already asked (checked on server side also)
	 			if($partner->Partner->user_choice_upload){
	 				$ask = false;
	 			}
 			}
 		 }
 		  $view = isset($_POST['view']) ? false : true;
 		 //Return json only
 		  if(!$view){
 		  	//echo $videosDataset;
 		  	require_once(BRID_PLUGIN_DIR.'/html/list/videos/videos_list.php');
 		  	die();
 		  }

		//require videos list view
    	require_once(BRID_PLUGIN_DIR.'/html/list/videos/videoLibrary.php');
	    die(); // this is required to return a proper result (By wordpress site)
        
	}
	/*
	 * Add Youtube video
	 */
	public static function addYoutubePost(){
		$api = new BridAPI();
		//Get channel list
		$channels = $api->channelsList(true);
 		//Get partner Info
 		$partner = $api->partner(BridOptions::getOption('site'), true);

		require_once(BRID_PLUGIN_DIR.'/html/form/post/add_youtube.php');
        
        die(); // this is required to return a proper result (By wordpress site)
	}


	/*
	 * List all playlists created to post them into Post
	 */
	public static function playlistLibraryPost(){

		 $api = new BridAPI();

		 $partner_id = BridOptions::getOption('site');

		 //Turn off buttons and quick icons if we are on post screen
		 $mode = isset($_POST['mode']) ? $_POST['mode'] : '';
		 $buttonsOff = isset($_POST['buttons']) ? $_POST['buttons'] : false;
		 $playlistType = '';
		 $subaction = '';
		 $_POST['limit'] = 8;
		
		//Sanitize search text if there is any
		 if(isset($_POST['search'])){
    		$_POST['search'] = sanitize_text_field($_POST['search']);
		 }
		 //Is there anu search string set?
		 $search = '';
		 if(isset($_SESSION['Brid.Playlist.Search']))
		 {
		 	$search = $_SESSION['Brid.Playlist.Search'];
		 }

		$playlists = $api->playlists($partner_id, true);
       
        
		   $view = isset($_POST['view']) ? false : true;
 		 //Return json only
 		  if(!$view){
 		  	//echo $videosDataset;
 		  	require_once(BRID_PLUGIN_DIR.'/html/list/playlist/playlist_list.php');
 		  	die();
 		  }

		require_once(BRID_PLUGIN_DIR.'/html/list/playlist/playlistLibrary.php');
	    die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * ADD playlist quick
	 */
	public static function addPlaylistPost($internal=false){

		 $api = new BridAPI();
		 $partner_id = BridOptions::getOption('site');
		 //Sanitize search text if there is any
		 if(isset($_POST['search'])){
    		$_POST['search'] = sanitize_text_field($_POST['search']);
		 }

		 $subaction = isset($_POST['subaction']) ? $_POST['subaction'] : '';

		 $mode = isset($_POST['mode']) ? $_POST['mode'] : '';
		 if(!isset($_POST['playlistType'])){
		 	//regular videos
		 	$_POST['playlistType'] = 0;
		 }
		 
		 $playlistType = isset($_POST['playlistType']) ? $_POST['playlistType'] : 0;

		 //Turn off buttons and quick icons if we are on post screen
		 $buttonsOff = isset($_POST['buttons']) ? $_POST['buttons'] : false;
			
		 $_POST['limit'] = 8;
		 //print_r($videosDataset);
		 //Is there anu search string set?
		 $search = '';
		 if(isset($_SESSION['Brid.Video.Search']))
		 {
		 	$search = $_SESSION['Brid.Video.Search'];
		 }
		 //Get video list
		 $videosDataset = $api->videos($partner_id, true);

		 //Do we need to ask upload question?
		 $ask = false;
		 if(BridOptions::getOption('question')=='' || BridOptions::getOption('question')==0){
		 	//Get partner Info
 			$partner = $api->partner(BridOptions::getOption('site'), true);
 			if(!empty($partner)){
	 			$ask = true;
	 			//Already asked (checked on server side also)
	 			if($partner->Partner->user_choice_upload){
	 				$ask = false;
	 			}
 			}
 		 }
 		  $view = isset($_POST['view']) ? false : true;
 		 //Return json only
 		  if(!$view){
 		  	//echo $videosDataset;
 		  	require_once(BRID_PLUGIN_DIR.'/html/list/playlist/video_list.php');
 		  	die();
 		  }

		//require videos list view
    	require_once(BRID_PLUGIN_DIR.'/html/list/playlist/addPlaylist.php');
    	if(!$internal)
      	die(); 
	    
	}
	/**
	 * ADD video quick
	 */
	public static function addVideoPost($internal=false){

		$api = new BridAPI();

		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			//Save submit
			echo $api->addVideo($_POST);
			die();

		}else{

            //Get partner Info
            //$partner = $api->partner(BridOptions::getOption('site'), true);
			
        	$partnerData = BridHtml::getPartnerData();
        	$upload = $partnerData['upload']; 

            //Get Channel list
            $channels = $api->channelsList(true);
            
            //$upload = $partner->Partner->upload;

            require_once(BRID_PLUGIN_DIR.'/html/form/post/add_video.php');
          
        }
       if(!$internal)
      	die(); // this is required to return a proper result (By wordpress site)
	}
	
	/*
	 * Show Upload form only for premium partners
	 */
	public static function uploadVideoPost(){

		$api = new BridAPI();
		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			//Save submit
			echo $api->addVideo($_POST);
			die();

		}else{
			 //echo 'uploadVideoPost';
			
			
	        $partnerData = BridHtml::getPartnerData();
	        $partner = $partnerData['Partner'];
	        $upload = $partnerData['upload'];
            //Get Channel list
            $channels = $api->channelsList(true);
        }
		 require_once(BRID_PLUGIN_DIR.'/html/form/post/add_upload.php');

		die();
	}
	/*
	 *  Show quick Video or Playlist library
	 *  @todo Should be merged with bridVideoLibrary
	 */
	public static function quickLibrary(){


    	$file = isset($_POST['file']) ? $_POST['file'] : 'video_library';

    	if(!in_array($file, array('video_library', 'playlist_library', 'widget_library')))
    	{
    		$file = 'video_library';
    	}

    	$playerSelected  = BridOptions::getOption('player'); //Is there any selected player saved?
        $width  = BridOptions::getOption('width'); //Width
        $width =  $width!='' ?  $width : '640';
        
        $height  = BridOptions::getOption('height'); //Height
        $height =  $height!='' ?  $height : '480';

        $playerSettings = json_encode(array('id'=>$playerSelected, 'width'=>$width, 'height'=>$height));

        $partnerData = BridHtml::getPartnerData();
        $partner = $partnerData['Partner'];
        $upload = $partnerData['upload'];
        //$upload = ($upload=='' || $upload==0) ? 0 : 1;

    	require_once(BRID_PLUGIN_DIR.'/html/'.$file.'.php');

    	die();

    }


}

//Add actions
add_action('wp_ajax_videoLibraryPost', array('BridQuickPost', 'videoLibraryPost'));	//List videos to add to post from post screen
add_action('wp_ajax_addYoutubePost', array('BridQuickPost', 'addYoutubePost')); 		//Add youtube video action
add_action('wp_ajax_playlistLibraryPost', array('BridQuickPost', 'playlistLibraryPost'));	//Open playlist library
add_action('wp_ajax_uploadVideoPost', array('BridQuickPost', 'uploadVideoPost'));			//Upload video
add_action('wp_ajax_addVideoPost', array('BridQuickPost', 'addVideoPost'));				//Add video via url or via upload
add_action('wp_ajax_addPlaylistPost', array('BridQuickPost', 'addPlaylistPost'));				//Add video via url or via upload
add_action('wp_ajax_quickLibrary', array('BridQuickPost', 'quickLibrary'));		//Switch between tabs in add quick video to post
add_action('wp_ajax_bridVideoLibrary', array('BridQuickPost', 'bridVideoLibrary'));	//Colorbox to open post screen