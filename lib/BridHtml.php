<?php
/**
 * BridHtml class will manage all Html actions (will display forms or return responses for saved or requested actions)
 * @package plugins.brid.lib
 * @author Brid Dev Team
 * @version 1.0
 */
class BridHtml {

	public static function timeFormat($timeData, $format ='F jS, Y')
	{
		//2014-02-06 22:16:36
		$t = explode(' ', $timeData);
		$timestamp = 0;
		if(isset($t[0])){
			$date = explode('-', $t[0]); //0 year, 1 month, 2 day
			$time = explode(':', $t[1]); //0 hour, 1 /min, 2 /sec
			$timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
		}
		return date($format, $timestamp);
	}

	public static function format_time($t,$f=':') // t = seconds, f = separator
	{
		$hours = floor($t/3600);
		$mins = ($t/60)%60;
		$seconds = $t%60;
		
		$a = array();
		
		if($hours!=0){
			$a[] = sprintf("%02d", $hours);
		}
		if($mins!=0){
			$a[] = sprintf("%02d", $mins);
		}else{
			$a[] = '00';
		}
		if($seconds!=0){
			$a[] = sprintf("%02d", $seconds);
		}else{
			$a[] = '00';
		}
		return implode($f,$a); //sprintf("%02d%s%02d%s%02d", floor($t/3600), $f, ($t/60)%60, $f, $t%60);
	}
	public static function getPath($options = array()){
		return (!isset($options['type']) || !isset($options['id'])) ? '' : UGC.'partners/'.$options['id'].'/'.$options['type'].'/';
	}

    /**
     * Wp Callback, List all players by ajax call
     * ajax.php?action=brid_api_get_players 
     * - Will display and populate listPlayersSite div with all available players for the selected partner(site)
     * - Should receive $_POST['id'] (selected site id)
     * - By default response is JSON object
     * - If id is invalid throw error (json)
     * @see http://codex.wordpress.org/AJAX_in_Plugins
     * @return {String|JsonObject} players
     **/
    public static function brid_api_get_players(){

      try{
          
          if(isset($_POST['id']) && is_numeric($_POST['id']))
          {
            
            $partnerId = intval($_POST['id']);
            
            $api = new BridAPI();

            $players = $api->call(array('url'=>'players/'.$partnerId), false); //false for do not decode (json expected)

            echo $players;
          }else{
            throw new Exception('Invalid partner id');
          }
      }catch(Exception $e){

        echo json_encode(array('error'=>$e->getMessage()));
      }

      die(); // this is required to return a proper result (By wordpress site)

    }
	/**
	 * [VIDEO LSIT]
	 * Get paginated video list by partner id
	 */
	public static function videos(){

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
		
		 //Get video list
		 $videosDataset = $api->videos($partner_id, true);
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

		//require videos list view
    	require_once(BRID_PLUGIN_DIR.'/html/list/videos.php');
	    die(); // this is required to return a proper result (By wordpress site)
        
	}
	/**
	 * List playlists
	 */
	public static function playlists(){

		 $api = new BridAPI();

		 $partner_id = BridOptions::getOption('site');

		 //Turn off buttons and quick icons if we are on post screen
		 $buttonsOff = isset($_POST['buttons']) ? $_POST['buttons'] : false;
		
		//Sanitize search text if there is any
		 if(isset($_POST['search'])){
    		$_POST['search'] = sanitize_text_field($_POST['search']);
		 }
		$playlists = $api->playlists($partner_id, true);
       
        //Is there anu search string set?
		 $search = '';
		 if(isset($_SESSION['Brid.Playlist.Search']))
		 {
		 	$search = $_SESSION['Brid.Playlist.Search'];
		 }

		//require videos list view
        require_once(BRID_PLUGIN_DIR.'/html/list/playlists.php');

        die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * ffmpeg info
	 */
	public static function ffmpegInfo(){

		$ffmpeg_info = array();

		if(isset($_POST) && !empty($_POST) && isset($_POST['url'])){
			
			$api = new BridAPI();

			header('Content-type: application/json');

			//Get Video Info
			echo $api->ffmpegInfo($_POST);
	        
		}

		die();
	}
	/**
	 * Edit playlist
	 */
	public static function editPlaylist(){

		
		$api = new BridAPI();
        
        if(!empty($_POST) && isset($_POST['action']) && isset($_POST['id']) && isset($_POST['insert_via']))
		{

			//Save submit
			echo $api->editPlaylist($_POST);

       	}else{
	        //Get Video Info via partner id
	        if(!empty($_POST) && isset($_POST['id']) && is_numeric($_POST['id'])){
		    
		        $playlist = $api->playlist($_POST['id'], true);
        		require_once(BRID_PLUGIN_DIR.'/html/form/edit_playlist.php');
		    }
    	}
       
       	die(); // this is required to return a proper result (By wordpress site)

	}
	/**
	 * Add videos to the playlist
	 */
	public static function addVideoPlaylist(){

		$playlist_id = 0;

		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['ids']))
		{
			//echo 'save me';

			//print_r($_POST);
			$_POST['partner_id'] = BridOptions::getOption('site');

			$api = new BridAPI();

			echo $api->addVideoPlaylist($_POST);


		}else{ 
			$playlist_id = intval($_POST['id']);
			$playlistType = isset($_POST['playlistType'])?$_POST['playlistType']:0;
			require_once(BRID_PLUGIN_DIR.'/html/form/add_video_playlist.php');
		}
		
      die(); // this is required to return a proper result (By wordpress site)
	}

	public static function addPartner(){

		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			//print_r($_POST);
			$_POST['user_id'] = BridOptions::getOption('user_id');

			$api = new BridAPI();

			echo $api->addPartner($_POST);


		}else{
			
			require_once(BRID_PLUGIN_DIR.'/html/form/add_site.php');
		}
		
      die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * ADD Playlist
	 */
	public static function addPlaylist(){
		
		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			
			$api = new BridAPI();
			echo $api->addPlaylist($_POST);

		}else{
			$videoType = isset($_GET['video_type'])?$_GET['video_type']:'';
			$playlistType = isset($_GET['playlistType'])? $_GET['playlistType'] : 0;
			
			require_once(BRID_PLUGIN_DIR.'/html/form/add_playlist.php');
		}
		
      die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * Add Youtube
	 */
	public static function addYoutube(){

		$api = new BridAPI();
		//Get channel list
		$channels = $api->channelsList(true);
 		//Get partner Info
 		$partner = $api->partner(BridOptions::getOption('site'), true);

		require_once(BRID_PLUGIN_DIR.'/html/form/add_youtube.php');
        
        die(); // this is required to return a proper result (By wordpress site)
	}
	public static function adBox($iterator=0, $adObject=null){

		$ad_types = array(0=>'preroll', 1=>'midroll', 2=>'postroll', 3=>'overlay');
		$midroll_type = array('s'=>'sec', '%'=>'%');

		$amIpost = false;
		if(!empty($_POST) && $_POST['action']=='adBox'){

			$iterator = intval($_POST['cnt']);
			$adType = $_POST['type'];
			$amIpost = true;
		}else{
			$adType = $ad_types[$adObject->adType];
		}
		/*
		 stdClass Object ( 
		 					[id] => 44 
		 					[player_id] => 0 
		 					[video_id] => 3457 
		 					[adTagUrl] => http://moja-djoka-pre-roll.com 
		 					[adType] => 0 
		 					[adTimeType] => s 
		 					[overlayStartAt] => 
		 					[overlayDuration] => 
		 					[cuepoints] => 
		 				) 
		 */
		
		require(BRID_PLUGIN_DIR.'/html/adBox.php');

		if($amIpost){
			die();
		}

		//return $adObject->adTagUrl;
	}
	public static function deleteAd(){

		$api = new BridAPI();
        
        if(!empty($_POST) && isset($_POST['id']))
		{
			//Delete Ad
			$_POST['id'] = intval($_POST['id']);
			echo $api->deleteAd($_POST);

       	}
		die();
	}
	/**
	 * Edit video
	 */
	public static function editVideo(){

		
		$api = new BridAPI();
        
        if(!empty($_POST) && isset($_POST['action']) && isset($_POST['id']) && isset($_POST['insert_via']))
		{
			//Save submit
			echo $api->editVideo($_POST);

       	}else{
	        //Get Video Info
	        if(!empty($_POST) && isset($_POST['id']) && is_numeric($_POST['id'])){
		        
		        $video = $api->video($_POST['id'], true);
		        $ads = array();
		        if(isset($video->Ad)){
		        	$ads = $video->Ad;
		        }
		        $channels = $api->channelsList(true);

		        $amIEncoded = ($video->Video->encoded || $video->Video->fetched) ? 1 : 0;

        		require_once(BRID_PLUGIN_DIR.'/html/form/edit_video.php');
		    }
    	}
       
       	die(); // this is required to return a proper result (By wordpress site)

	}
	/*
	 * Ask question about hosting video files
	 */
	public static function askQuestion(){

        if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			$api = new BridAPI();
      		$_POST['id'] = BridOptions::getOption('site');

      		BridOptions::updateOption('question', '1');
      		BridOptions::updateOption('upload', $_POST['upload']);
			//Save submit
			echo $api->partnerUpload($_POST);

       	}else{
	      require_once(BRID_PLUGIN_DIR.'/html/form/user_upload.php');
			die();
    	}
       
       	die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * ADD video
	 */
	public static function addVideo(){

		$api = new BridAPI();

		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			//Save submit
			echo $api->addVideo($_POST);
			die();

		}else{

            //Get partner Info
            //$partner = $api->partner(BridOptions::getOption('site'), true);

            $upload = BridOptions::getOption('upload');

            $upload = ($upload=='' || $upload==0) ? 0 : 1;

            //Get Channel list
            $channels = $api->channelsList(true);
            
            //$upload = $partner->Partner->upload;

            require_once(BRID_PLUGIN_DIR.'/html/form/add_video.php');
          
        }
      die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * Remove item from playlsit
	 */
	public static function removeVideoPlaylist(){

		$api = new BridAPI();
		$_POST['id'] = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$_POST['video_id'] = isset($_POST['video_id']) ? intval($_POST['video_id']) : 0;
		$_POST['partner_id'] = intval(BridOptions::getOption('site'));
		if($_POST['id']!=0 && $_POST['video_id']!=0)
			echo $api->removeVideoPlaylist($_POST);
		die();
	}
	/**
	 * Sort videos in playlist
	 */
	public static function sortVideos(){

		if(!empty($_POST) && isset($_POST['action']))
		{
			$api = new BridAPI();
			$_POST['partner_id'] = intval(BridOptions::getOption('site'));
			echo $api->sortVideos($_POST);
		}
		die();
	}
	/**
	 * Clear all playlist items
	 */
	public static function clearPlaylist(){

		$api = new BridAPI();
		$_POST['partner_id'] = intval(BridOptions::getOption('site'));
		echo $api->clearPlaylist($_POST);
		die();
	}
	/**
	 * Delete video
	 */
	public static function deleteVideos(){

		if(!empty($_POST) && isset($_POST['action']))
		{
			$api = new BridAPI();
			$_POST['partner_id'] = intval(BridOptions::getOption('site'));
			$_POST['ids'] = $_POST['data']['Video']['ids'];
			echo $api->deleteVideos($_POST);
		}
		die();
	}
	/**
	 * Delete playlist
	 */
	public static function deletePlaylists(){

		if(!empty($_POST) && isset($_POST['action']))
		{
			$api = new BridAPI();
			$_POST['partner_id'] = intval(BridOptions::getOption('site'));
			$_POST['ids'] = $_POST['data']['Playlist']['ids'];
			echo $api->deletePlaylists($_POST);
		}
		die();
	}
	/**
	* Check YouTube Url
	* Api needs:
	* $_POST['url'] = 'http://www.youtube.com?v=32124'
	*/
	public static function checkUrl(){

		if(isset($_POST['external_url']) && !empty($_POST['external_url']))
		{
			$api = new BridAPI();
			$_post['url'] = $_POST['external_url'];
			echo $api->checkUrl($_post);
		}
		die();
	}
	/**
	* Fetch YouTube Video
	* Api needs:
	* $_POST['videoUrl'] = 'http://www.youtube.com?v=32124'
	* $_POST['partner_id'] = 1
	*/
	public static function fetchVideo(){

		if(isset($_POST['videoUrl']) && !empty($_POST['videoUrl']))
		{
			$api = new BridAPI();
			$_post['partner_id'] = BridOptions::getOption('site');
			$_post['videoUrl'] = $_POST['videoUrl'];
			echo $api->fetchVideoViaUrl($_post);
		}
		die();
	}
	/**
	 * Change Video or Playlist status flag
	 */
	public static function changeStatus(){

		 header('Content-type: application/json');
		 $api = new BridAPI();
		 $_POST['partner_id'] = BridOptions::getOption('site');
		 //Change status
		 echo $api->changeStatus($_POST);
		die();
	}

	/**
     * Wp Callback, What will happen on Brid Video Media Library page cick
     *
     */
    public static function manage_videos(){

    	//Maybe parner has been deleted from cms?
    	$api = new BridAPI();
    	//Get partner Info
 		$partner = $api->partner(BridOptions::getOption('site'), true);
 		
 		//print_r($partner); die('kraj');

 		if(!empty($partner->error)){
 			wp_die('Partner error: '.$partner->error);
 		}

      	require_once(BRID_PLUGIN_DIR.'/html/manage.php');
      	//Die will stop executing wordpress JS, and submenus wont show.
	    //die();
    }

    public static function bridVideoPost (){
    	
    	$playerSelected  = BridOptions::getOption('player'); //Is there any selected player saved?
        $width  = BridOptions::getOption('width'); //Width
        $width =  $width!='' ?  $width : '640';
        
        $height  = BridOptions::getOption('height'); //Height
        $height =  $height!='' ?  $height : '480';

        $playerSettings = json_encode(array('id'=>$playerSelected, 'width'=>$width, 'height'=>$height));

    	require_once(BRID_PLUGIN_DIR.'/html/post.php');
    	die();
    }

    public static function updatePartnerId(){
    	
    	if(!empty($_GET['id'])){
    		BridOptions::updateOption('site', $_POST['id']);
    	}
    	
    	die();
    }

    public static function addPostButton($context){

    	  //path to my icon
		  $img = BRID_PLUGIN_URL.'/img/brid_tv.png';
		  
		  $context .= "<a class='bridAjax opacityButton' href='".admin_url('admin-ajax.php')."?action=bridVideoPost'>
		    <img src='{$img}'  style='margin-top:2px;'/></a><script>jQuery('.bridAjax').colorbox({innerWidth:900, innerHeight:780}); initButtonOpacity();</script>";
			
		  /*$context .= "<a class='various opacityButton'data-fancybox-type='ajax' data-action='bridVideoPost'
		    href='".admin_url('admin-ajax.php')."'>
		    <img src='{$img}'  style='margin-top:2px;'/></a><script>initFancybox(); initButtonOpacity();</script>";*/
		  
		  return $context;
    }
    /**
     * Render short code into brid iframe
     */
    public static function brid_shortcode($attrs){

    	$url = array();
    	$url[] = isset($attrs['type']) ? $attrs['type'] : 'iframe';	//action

    	$modes = array('video', 'playlist', 'latest', 'tag', 'channel', 'source');

    	$mode = 'video';
    	$id = DEFAULT_VIDEO_ID;

    	foreach($modes as $k=>$v){
    		if(isset($attrs[$v])){
    			$mode = $v;
    			$id = $attrs[$v];
    			break;
    		}
    	}
    	$url[] = $mode; //mode
    	$iframeId[] = $id; //content id

    	
    	$iframeId[] = BridOptions::getOption('site');	//partner id
    	//Force player override
    	/*$iframeId[] = isset($attrs['player']) ? $attrs['player'] : BridOptions::getOption('player');	//player id
    	$iframeId[] = isset($attrs['autoplay']) ? $attrs['autoplay'] : BridOptions::getOption('autoplay');	//autoplay
    	$iframeId[] = isset($attrs['items']) ? $attrs['items'] : 1;	//num of items
    	*/
    	$playerOptions = array();
    	$playerOptions['id'] = isset($attrs['player']) ? $attrs['player'] : BridOptions::getOption('player');	//player id;
    	//$playerOptions['autoplay'] = isset($attrs['autoplay']) ? intval($attrs['autoplay']) : intval(BridOptions::getOption('autoplay'));	//autoplay
    	if(isset($attrs['autoplay'])){
    		$playerOptions['autoplay'] = intval($attrs['autoplay']);
    	}
    	
    	if($mode == 'video' || $mode == 'playlist'){
    		$playerOptions[$mode] = $id;
    		if($mode=='playlist'){
    			$playerOptions['video_type'] = isset($attrs['video_type']) ? $attrs['video_type'] : 0;	//video type[Brid|Yt]
    		}
    	}
    	else {
    		$playerOptions['playlist']['id'] = $id;
    		$playerOptions['playlist']['mode'] = $mode;
    		$playerOptions['playlist']['items'] = isset($attrs['items']) ? $attrs['items'] : 1;
    		$playerOptions['video_type'] = isset($attrs['video_type']) ? $attrs['video_type'] : 0;	//video type[Brid|Yt]
    	}
    	
    	
    	$t = time();
    	$tl = strlen($t);
    	
    	$divId = substr(time(),($tl-8),$tl).rand();
    	$url = array_merge($url, $iframeId);

    	$playerOptions['width'] = isset($attrs['width']) ? $attrs['width'] : BridOptions::getOption('width');
    	$playerOptions['height'] = isset($attrs['height']) ? $attrs['height'] : BridOptions::getOption('height');

    	//Iframe
    	//return '<script type="text/javascript" src="'.CDN_HTTP.'player/build/brid.api.min.js"></script><iframe id="'.implode('-', $iframeId).'" src="'.CDN_HTTP.'services/'.implode('/',$url).'" width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>';
    	$embedCode =  '<!--WP embed code - Brid Ver.'.BRID_PLUGIN_VERSION.' -->';
    	$embedCode .= '<script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script><div id="Brid_'.$divId.'" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><div id="Brid_'.$divId.'_adContainer"></div></div>';
		$embedCode .= '<script type="text/javascript">$bp("Brid_'.$divId.'", '.json_encode($playerOptions).');</script><script type="text/javascript" src="http://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>';
		
		return $embedCode;
    }

    public static function dynamics(){

    	$api = new BridAPI();
		//Get channel list
		$channels = $api->channelsList(true);
		
    	require_once(BRID_PLUGIN_DIR.'/html/form/dynamic.php');

    	die();

    }
    public static function admin_notice_message(){    
	   echo '<div class="updated"><p>You must <a href="options-general.php?page=brid-video-config">configure</a> the Brid Video plugin before you start using it.</p></div>';
	}

}
//@see http://codex.wordpress.org/AJAX_in_Plugins


/* -------- ADD TO POST -------- */
add_action('wp_ajax_bridVideoPost', array('BridHtml', 'bridVideoPost'));							//Fancybox to open post screen
add_action('wp_ajax_dynamics', array('BridHtml', 'dynamics'));							//Fancybox to open post screen

/* -------- PLAYLIST -------- */
add_action('wp_ajax_sortVideos', array('BridHtml', 'sortVideos')); 						//Sort videos in playlist edit mode
add_action('wp_ajax_removeVideoPlaylist', array('BridHtml', 'removeVideoPlaylist')); 	//Remove single item from playlist
add_action('wp_ajax_clearPlaylist', array('BridHtml', 'clearPlaylist')); 				//Remove all items - clearPlaylist
add_action('wp_ajax_addPlaylist', array('BridHtml', 'addPlaylist'));					//Tab click get Add playlist view
add_action('wp_ajax_addVideoPlaylist', array('BridHtml', 'addVideoPlaylist'));			//Add videos into playlist
add_action('wp_ajax_playlists', array('BridHtml', 'playlists'));						//Tab click get Playlist view
add_action('wp_ajax_editPlaylist', array('BridHtml', 'editPlaylist'));					//Edit playlist action
add_action('wp_ajax_deletePlaylists', array('BridHtml', 'deletePlaylists'));			//Delete playlist/s action

/* -------- VIDEO -------- */
add_action('wp_ajax_askQuestion', array('BridHtml', 'askQuestion'));		//Ask question about hosting video files
add_action('wp_ajax_bridAction', array('BridHtml', 'bridAction'));			//Tab click get Videos view
add_action('wp_ajax_videos', array('BridHtml', 'videos'));					//Tab click get Videos view
add_action('wp_ajax_addVideo', array('BridHtml', 'addVideo'));				//Add video via url or via upload
add_action('wp_ajax_addYoutube', array('BridHtml', 'addYoutube')); 			//Add youtube video action
add_action('wp_ajax_editVideo', array('BridHtml', 'editVideo'));			//Edit video action
add_action('wp_ajax_ffmpegInfo', array('BridHtml', 'ffmpegInfo'));			//Get video ffmpeg info
add_action('wp_ajax_deleteVideos', array('BridHtml', 'deleteVideos'));		//Delete videos action
add_action('wp_ajax_checkUrl', array('BridHtml', 'checkUrl'));				//Check youtube url
add_action('wp_ajax_fetchVideo', array('BridHtml', 'fetchVideo'));			//Fetch Video
add_action('wp_ajax_deleteAd', array('BridHtml', 'deleteAd'));				//Delete Ad item from Video
add_action('wp_ajax_adBox', array('BridHtml', 'adBox'));					//Get Add Ad form for Video Monetization

/* -------- PLAYLIST & VIDEO -------- */
add_action('wp_ajax_changeStatus', array('BridHtml', 'changeStatus'));		//Change Status on video or playlist

/*--------- PARTNER -------------- */
add_action('wp_ajax_addPartner', array('BridHtml', 'addPartner'));		//Change Status on video or playlist
add_action('wp_ajax_updatePartnerId', array('BridHtml', 'updatePartnerId'));		//Change Status on video or playlist

?>