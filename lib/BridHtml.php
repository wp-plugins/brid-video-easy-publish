<?php
/**
 * BridHtml class will manage all Html actions (will display forms or return responses for saved or requested actions)
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.1
 */
class BridHtml {

	//Get abs path to check is there crossdomain.xml
	public static function getAbsPath()
	{	
		if(defined('ABSPATH')){
			return ABSPATH;
		}

	    $base = dirname(__FILE__);
	    $path = false;

	    if (@file_exists(dirname(dirname($base))."/wp-config.php"))
	    {
	        $path = dirname(dirname($base));
	    }
	    else
	    if (@file_exists(dirname(dirname(dirname($base)))."/wp-config.php"))
	    {
	        $path = dirname(dirname(dirname($base)));
	    }
	    else
	    $path = false;

	    if ($path != false)
	    {
	        $path = str_replace("\\", "/", $path);
	    }
	    return $path;
	}
	//Ask for crossdomain
	public static function isThereCrossdomain(){

		$crossdomain = self::getAbsPath().'crossdomain.xml';
		return file_exists($crossdomain);
	}
	//Try to create crossdomain.xml
	public static function createCrossdomain(){

		$filename = self::getAbsPath().'crossdomain.xml';

			$crossdomain = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE cross-domain-policy SYSTEM "http://www.adobe.com/xml/dtds/cross-domain-policy.dtd">
<cross-domain-policy>
    <site-control permitted-cross-domain-policies="master-only"/>
    <allow-access-from domain="*"/>
    <allow-http-request-headers-from domain="*" headers="*"/>
</cross-domain-policy>';
	
		$return = array('success'=>false, 'msg'=>'Error');

			$handle = @fopen($filename, 'w') or false;
			if ($handle) {

		         $return['msg'] = "Cannot open file ($filename)";

		         // Write $somecontent to our opened file.
			    if (fwrite($handle, $crossdomain) === FALSE) {
			        $return['msg'] = "Cannot write to file ($filename)";
			    }
			    $return['success'] = true;
			    $return['msg'] = "Success, wrote to file ($filename)";

			    fclose($handle);
		        
		    }else{
		    	$return['msg'] = "Permission denied, file not writable.\n\nCannot open file ($filename).\n\nPlease create crossdomain file manually with this content:\n\n$crossdomain";
		        
		    }
		

		header('Content-Type: application/json');
		echo  json_encode($return);

		die(); 

	}

	public static function monetizeVideo(){

		$return = array('success'=>false, 'msg'=>'Error');

		$api = new BridAPI();

		if(!empty($_POST) && isset($_POST['id']) && isset($_POST['monetize']) && isset($_POST['video_type']) && isset($_POST['intro_enabled']))
		{	
			$videoId = intval($_POST['id']);
			$video_type = intval($_POST['video_type']);
			$intro_enabled = intval($_POST['intro_enabled']);
			$monetize = intval($_POST['monetize']);
			$partner = null;
			$partner_id = BridOptions::getOption('site');
			//Save submit
			if(!$intro_enabled && $video_type){
				//Update partner and set intro_video flag
				$_POST['id'] = $partner_id;
		    	$_POST['intro_video'] = 1;
		 		$partner = $api->updatePartnerField($_POST);
			}
			$data = array();
			$data['id'] = $videoId;
			$data['partner_id'] = $partner_id;
			$data['monetize'] = $monetize;

			$v = $api->editVideo($data, true);
			
			$return['success'] = true;
			$return['msg'] = 'Success';
			$return['Video'] = $v;
			$return['Partner'] = $partner;

		}
		header('Content-Type: application/json');
		echo  json_encode($return);
		die();
	}

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
     * Wp Callback, List all players by ajax call
     * ajax.php?action=brid_api_get_players 
     * - Will display and populate listPlayersSite div with all available players for the selected partner(site)
     * - Should receive $_POST['id'] (selected site id)
     * - By default response is JSON object
     * - If id is invalid throw error (json)
     * @see http://codex.wordpress.org/AJAX_in_Plugins
     * @return {String|JsonObject} players
     **/
    public static function getPartnerAndPlayersWithDefaultPlayer(){

      try{
          
          if(isset($_POST['id']) && is_numeric($_POST['id']))
          {
            
            $partnerId = intval($_POST['id']);
            
            $api = new BridAPI();


            $players = $api->call(array('url'=>'getPartnerAndPlayersWithDefaultPlayer/'.$partnerId), false); //false for do not decode (json expected)

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
		 
		 $partner = $api->partner(BridOptions::getOption('site'), true);

		 if(BridOptions::getOption('question')=='' || BridOptions::getOption('question')==0){
		 	//Get partner Info
 			
 			if(!empty($partner)){
	 			$ask = true;
	 			//Already asked (checked on server side also)
	 			if($partner->Partner->user_choice_upload){
	 				$ask = false;
	 			}
 			}
 		 }
 		 $upload = intval($partner->Partner->upload);


		//require videos list view
    	require_once(BRID_PLUGIN_DIR.'/html/list/library/videos.php');
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
        require_once(BRID_PLUGIN_DIR.'/html/list/library/playlists.php');

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
	/*
	 * Get new ad box
	 */
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
		
		require(BRID_PLUGIN_DIR.'/html/adBox.php');

		if($amIpost){
			die();
		}

		//return $adObject->adTagUrl;
	}
	/*
	 * Delete ad (video or player)
	 */
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

		        $partner = $api->partner(BridOptions::getOption('site'), true);

        		require_once(BRID_PLUGIN_DIR.'/html/form/edit_video.php');
		    }
    	}
       
       	die(); // this is required to return a proper result (By wordpress site)

	}

	public static function askMonetize(){

		$applyForAdProgram = 0;

		$partnerData = BridHtml::getPartnerData();


		$applyForAdProgram = $partnerData['Partner']->Partner->apply_ad_program;

		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			
			$api = new BridAPI();
      		$_POST['id'] = BridOptions::getOption('site');

      		header('Content-type: application/json');

			echo $api->askForMonetization($_POST);
			

       	}else{
       		global $current_user;
      		get_currentuserinfo();

	      require_once(BRID_PLUGIN_DIR.'/html/form/ask_monetization.php');
			die();
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

      		header('Content-type: application/json');
      		//echo json_encode(array('djokica'=>'moja'));

      		BridOptions::updateOption('question', 1);
      		//BridOptions::updateOption('upload', $_POST['upload']);
			//Save submit
			//echo $api->partnerUpload($_POST);
			echo $api->askForEnterprise($_POST);

       	}else{
       		global $current_user;
      		get_currentuserinfo();

	      require_once(BRID_PLUGIN_DIR.'/html/form/user_upload.php');
			die();
    	}
       
       	die(); // this is required to return a proper result (By wordpress site)
	}
	
	/**
	 *  Upload video
	 */
	public static function uploadVideo($internal=false){

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

            require_once(BRID_PLUGIN_DIR.'/html/form/upload_video.php');
          
        }
       if(!$internal)
      	die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * ADD video
	 */
	public static function addVideo($internal=false){

		$api = new BridAPI();

		if(!empty($_POST) && isset($_POST['action']) && isset($_POST['insert_via']))
		{
			//Save submit
			echo  $api->addVideo($_POST);
			die();

		}else{

            //Get partner Info
            //$partner = $api->partner(BridOptions::getOption('site'), true);

            $partnerData = BridHtml::getPartnerData();
        	$upload = $partnerData['upload']; 

            //Get Channel list
            $channels = $api->channelsList(true);
            
            //$upload = $partner->Partner->upload;

            require_once(BRID_PLUGIN_DIR.'/html/form/add_video.php');
          
        }
       if(!$internal)
      	die(); // this is required to return a proper result (By wordpress site)
	}
	/**
	 * List channles for Brid Playlist Widget
	 */
	public static function channelsList(){
		$api = new BridAPI();
		echo $api->channelsList(false);
		die();
	}
	/**
	 * List players for Brid Playlist Widget
	 */
	public static function playersList(){

		$api = new BridAPI();

		$partnerId = intval(BridOptions::getOption('site'));

        echo $api->call(array('url'=>'players/'.$partnerId), false); //false for do not decode (json expected)
        die();
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
	public static function getPartnerData(){
		$api = new BridAPI();
        $partner = $api->partner(BridOptions::getOption('site'), true);
        if(!empty($partner->error)){
 			wp_die('Partner error: '.$partner->error.ACCESS_ERROR_MSG);
 		}
 		$data['Partner'] = $partner;
 		$data['upload'] = intval($partner->Partner->upload);
 		return $data;
	}
	
	/**
     * Wp Callback, What will happen on Brid Video Media Library page cick
     *
     */
     public static function manage_videos(){

    	//Maybe parner has been deleted from cms?
    	$partnerId = BridOptions::getOption('site');
    	if(empty($partnerId)){
    		wp_die('Invalid partner id. Go to settings page.');
    	}
    	$api = new BridAPI();
    	//Get partner Info
 		$partner = $api->partner($partnerId, true);

 		if(!empty($partner->error)){
 			
          wp_die('Partner Error: '.$partner->error.ACCESS_ERROR_MSG);
        }
        else{
       
	 		wp_enqueue_media(); //include media for browsing files in Add/Edit Video screen

	 		$ask = intval(BridOptions::getOption('question'));


	      	require_once(BRID_PLUGIN_DIR.'/html/manage.php');
      	}
      	//Die will stop executing wordpress JS, and submenus wont show.
	    //die();
    }

    public static function updatePartnerField(){
    	
    	if(!empty($_POST['name']) && isset($_POST['value'])){
    		
    		//Maybe parner has been deleted from cms?
	    	$api = new BridAPI();
	    	//Get partner Info\
	    	$_POST['id'] = BridOptions::getOption('site');
	    	$_POST[$_POST['name']] = $_POST['value'];
	 		$partner = $api->updatePartnerField($_POST);
	 		
    	}
    	
    	die();
    }

    public static function updatePartnerId(){
    	
    	if(!empty($_GET['id'])){
    		BridOptions::updateOption('site', $_POST['id']);
    	}
    	
    	die();
    }
    
    //icon
    public static function addPostButton($context){

    	  
    	  $options = array_merge(get_option('brid_options'), BridShortcode::getSize());
    	  
		  $context .= "<div class='bridAjax' id='bridQuickPostIcon' href='".admin_url('admin-ajax.php')."?action=bridVideoLibrary'>
		    <img src='".BRID_PLUGIN_URL."/img/brid_tv.png'/></div><script>var convertedVideos = []; var BridOptions = ".json_encode(array_merge($options, array('ServicesUrl'=>CLOUDFRONT)))."; jQuery('.bridAjax').colorbox({innerWidth:'80%', innerHeight:'580px', onClosed : killVeeps});</script>";
			
		  return $context;
    }
    
    /*
     * Fancy checkbox option
     *
     * $opt array values
     * name = brid_options[ovr_def]
     * id = 'ovr_def'
     * value = 1/0
     * title = REPLACE DEFAULT PLAYER WITH BRID PLAYER
     * desc = Will try to replace all default wordpress video tags with Brid.tv player. Videos will be automatically monetized with your Ad Tag Url.
     * method = jsMethodToggle
     * marginTop -optional
     * marginBottom - optional
     */
    public static function checkbox($opt){

    	
    	if(!isset($opt['id'])){
    		echo "Checkbox Error: Id missing chechbox";
    		return false;
    	}
    	if(!isset($opt['name'])){
    		echo "Checkbox Error: Name missing chechbox";
    		return false;
    	}
    	if(!isset($opt['value'])){
    		echo "Checkbox Error: Value missing chechbox";
    		return false;
    	}
    	$opt['value'] = intval($opt['value']);
    	if(!isset($opt['title'])){
    		echo "Checkbox Error: Id missing chechbox";
    		return false;
    	}
    	$c = 'none';
        $inp = '';
        if($opt['value']){ 


          $c = 'block';
          $inp = 'checked';

        }
        $dataMethod = '';
        if(isset($opt['method'])){
        	$dataMethod='data-method="'.$opt['method'].'"';
        }
        $marginTop = '20';
        if(isset($opt['marginTop'])){
        	$marginTop=intval($opt['marginTop']);
        }
        $marginBottom = '0';
        if(isset($opt['marginBottom'])){
        	$marginBottom=intval($opt['marginBottom']);
        }

    	?>

    	<div class="checkboxRowSettings" style="margin-top:<?php echo $marginTop; ?>px;margin-bottom:<?php echo $marginBottom; ?>px;">
          <div id="checkbox-<?php echo $opt['id'];?>" class="bridCheckbox" <?php echo $dataMethod; ?> data-name="<?php echo $opt['id'];?>" style="top:4px;left:1px;">
            <div class="checkboxContent">
              <img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:<?php echo $c; ?>" alt="">
              <input type="hidden" name="<?php echo $opt['name'];?>" class="singleCheckbox <?php echo $inp;?>" id="<?php echo $opt['id'];?>" value="<?php echo $opt['value'];?>" data-value="<?php echo $opt['value'];?>" style="display:none;">
            </div>
            <div class="checkboxText"><?php echo $opt['title']; ?></div>
            <?php if(isset($opt['desc'])) {?>
            <div class="flashFalbackWarring"><?php echo $opt['desc']; ?></div>
            <?php } ?>
          </div>
        </div>
        <?php
    }

    public static function dynamics(){

    	$api = new BridAPI();
		//Get channel list
		$channels = $api->channelsList(true);
		
    	require_once(BRID_PLUGIN_DIR.'/html/form/dynamic.php');

    	die();

    }
    //Un-authorize user only
    public static function unauthorizeBrid(){
    	

        delete_option('brid_options');
        if(isset($_GET['red'])){
        	
        	wp_redirect(admin_url('admin.php?page=brid-video-config-setting'));
        }
    	die();
    }
    public static function admin_notice_message(){


    	if(!BridOptions::areThere() && !isset($_GET['code']))
    	{
	   		echo '<div class="updated"><p>You must <a href="options-general.php?page=brid-video-config-setting" id="ConfigureBrid">configure</a> the Brid Video plugin before you start using it.</p></div>';

	   	}
	}
	/**
	 * Send premium request
	 * @throws Exception
	 */
	public static function bridPremium(){

		try{
          
          if(isset($_POST['premium']) && is_numeric($_POST['premium']))
          {
            
            $premium = intval($_POST['premium']);
            
            $api = new BridAPI();

            $response = $api->call(array('url'=>'premium/'.BridOptions::getOption('site').'/'.$premium), false); //false for do not decode (json expected)
            /**
             * We have send premium request
             * set partner to be external
             */
		    BridOptions::updateOption('question', '1');
      		//BridOptions::updateOption('upload', 0);
            echo $response;
          }else{
            throw new Exception('Invalid request data');
          }
      }catch(Exception $e){

        echo json_encode(array('error'=>$e->getMessage()));
      }

      die(); // this is required to return a proper result (By wordpress site)
		
	}
	//Convert brid iframe into brid short code before saving into DB
	public static function my_filter_brid_iframe_to_short($content){

		$reg = "#<iframe[^>]+>.*?</iframe>#is";

		$content = stripslashes($content);

		$iframes = array();

		if(preg_match_all($reg, $content, $matches)){

			foreach ($matches[0] as $key => $match) {
				
				$iframe = $matches[0][$key];

				$iframes[] = $iframe;
				//Title
				$title='No title';
				$src = '';
				$shortcode = '';
				if(preg_match('/src=\"(.*)\"/isU', $iframe, $m)){


					if(isset($m[1])){

						if(strpos($m[1], CLOUDFRONT)!==false)
                      	{
						
							$src = str_replace(CLOUDFRONT,'',$m[1]);
							
							if(preg_match('/title=\"(.*)\"/isU', $iframe, $m)){

								if(isset($m[1])){
									$title = $m[1];
								}
							}
							//Params
							$d = explode('/', $src);
							
							if($src!='' && isset($d[2]) && isset($d[3]) && isset($d[5])){

								$shortcode = '[brid '.$d[2].'="'.$d[3].'" player="'.$d[5].'" title="'.addslashes($title).'"]';

								$content = str_replace($iframe, $shortcode, $content);
							}
						}
					}
				}

				
			}
		}


		return $content;
	}
	

}



//Pre save filter to brid code
add_filter('content_save_pre', array('BridHtml','my_filter_brid_iframe_to_short'), 9, 1 );

/* -------- ADD TO POST -------- */
add_action('wp_ajax_dynamics', array('BridHtml', 'dynamics'));							//Colorbox to open post screen
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
add_action('wp_ajax_askMonetize', array('BridHtml', 'askMonetize'));		//Ask for monetization program
add_action('wp_ajax_bridAction', array('BridHtml', 'bridAction'));			//Tab click get Videos view
add_action('wp_ajax_videos', array('BridHtml', 'videos'));					//Tab click get Videos view
add_action('wp_ajax_addVideo', array('BridHtml', 'addVideo'));				//Add video via url or via upload
add_action('wp_ajax_uploadVideo', array('BridHtml', 'uploadVideo'));				//Add video via url or via upload
add_action('wp_ajax_addYoutube', array('BridHtml', 'addYoutube')); 			//Add youtube video action
add_action('wp_ajax_editVideo', array('BridHtml', 'editVideo'));			//Edit video action
add_action('wp_ajax_ffmpegInfo', array('BridHtml', 'ffmpegInfo'));			//Get video ffmpeg info
add_action('wp_ajax_deleteVideos', array('BridHtml', 'deleteVideos'));		//Delete videos action
add_action('wp_ajax_checkUrl', array('BridHtml', 'checkUrl'));				//Check youtube url
add_action('wp_ajax_fetchVideo', array('BridHtml', 'fetchVideo'));			//Fetch Video
add_action('wp_ajax_deleteAd', array('BridHtml', 'deleteAd'));				//Delete Ad item from Video
add_action('wp_ajax_adBox', array('BridHtml', 'adBox'));					//Get Add Ad form for Video Monetization
add_action('wp_ajax_channelsList', array('BridHtml', 'channelsList'));		//Get Channel list
add_action('wp_ajax_playersList', array('BridHtml', 'playersList'));		//Get Players list

/* -------- PLAYLIST & VIDEO -------- */
add_action('wp_ajax_changeStatus', array('BridHtml', 'changeStatus'));		//Change Status on video or playlist

/*--------- PARTNER -------------- */
add_action('wp_ajax_updatePartnerId', array('BridHtml', 'updatePartnerId'));		//Update partner id
add_action('wp_ajax_updatePartnerField', array('BridHtml', 'updatePartnerField'));	//Update partner field
add_action('wp_ajax_bridPremium', array('BridHtml', 'bridPremium')); //Send premium request
//Try to create crossdomain.xml
add_action('wp_ajax_createCrossdomain', array('BridHtml', 'createCrossdomain')); //Send premium request
add_action('wp_ajax_monetizeVideo', array('BridHtml', 'monetizeVideo')); //Monetize videos
add_action('wp_ajax_unauthorizeBrid', array('BridHtml', 'unauthorizeBrid')); //Unauthorize account