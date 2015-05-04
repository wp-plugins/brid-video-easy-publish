<?php
/**
 * BridShortcode class will manage all shortcode manipulation
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.0
 */
class BridShortcode {

    public $counter = 0;
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
   
    	$playerOptions = array();
    	$playerOptions['id'] = isset($attrs['player']) ? $attrs['player'] : BridOptions::getOption('player');	//player id;
    
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
    	
    	
    	$divId = self::genRandId();
    	$url = array_merge($url, $iframeId);

    	$playerOptions['width'] = strval(isset($attrs['width']) ? $attrs['width'] : BridOptions::getOption('width'));
    	$playerOptions['height'] = strval(isset($attrs['height']) ? $attrs['height'] : BridOptions::getOption('height'));

       
        //<script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script>
        //Brid.forceConfigLoad = true;

    	$embedCode =  '<!--WP embed code - Brid Ver.'.BRID_PLUGIN_VERSION.' -->';
    	$embedCode .= '<div id="Brid_'.$divId.'" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><div id="Brid_'.$divId.'_adContainer"></div></div>';
		$embedCode .= '<script type="text/javascript">$bp("Brid_'.$divId.'", '.json_encode($playerOptions).');</script>';
        //<script type="text/javascript" src="//imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
		
		return $embedCode;
    }
    /**
     * Render short code for override YT players
     */
    public static function brid_override_yt_shortcode($attrs){

      $partnerId = BridOptions::getOption('site');
      $playerId = BridOptions::getOption('player');
      $width = BridOptions::getOption('width');
      $height = BridOptions::getOption('height');      
      $introEnabled = BridOptions::getOption('intro_enabled',true);
      $id = $attrs['src'];

      $image = 'https://i.ytimg.com/vi/'.$id.'/hqdefault.jpg';
      $time = self::genRandId();

      $embedCode = '<!--WP embed code replace YT object - Brid Ver.'.BRID_PLUGIN_VERSION.' -->
       <div id="Brid_'.$time.'" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"> 
       <div id="Brid_'.$time.'_adContainer"></div></div>';

       $override = intval($introEnabled);

       if($introEnabled){
          $embedCode .= '<script type="text/javascript"> $bp("Brid_'.$time.'", {"id":"'.$playerId.'", "yt" : {"src" : "'.$id.'",name: "'.htmlspecialchars(get_the_title()).'", image:"'.$image.'"} ,"video":"http:'.CLOUDFRONT.'services/ytvideo/'.$partnerId.'.json", "width":"'.$width.'","height":"'.$height.'"}); </script>';
      }else{
        $embedCode .= '<script type="text/javascript"> $bp("Brid_'.$time.'", {"id":"'.$playerId.'","video": {src : "'.$id.'"}, "width":"'.$width.'","height":"'.$height.'"}); </script>';
      }

      return $embedCode;
    }
    //Check enqueued scripts
    private static function checkScriptEnqueued($name, $handle){

         $list = 'enqueued';
         if (wp_script_is( $handle, $list )) {
           return;
         } else {
           wp_register_script( $name, $handle);
           wp_enqueue_script( $handle, $handle, array(), null, false);
         }
    }
    /*
     * Replace youtube links with Brid embed code
     */
	public static function wp_embed_handler_youtube( $matches, $attr, $url, $rawattr ) {
	   
     global $pagenow;

	 $embed  = $url;
     $src = '';

     //render different embed in admin area
     if($pagenow=='admin-ajax.php'){
        
        $src .='<script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script>';
         $src .= BridShortcode::brid_override_yt_shortcode(array('src'=>$matches[1]));
     }else{ 
      //This is the short code for front end area only
      if(isset($matches[1]))
      {
        
        $src .= '[brid_override_yt src="'.$matches[1].'"]';

      }
    }

      $embed = sprintf(
		      $src,
		      get_template_directory_uri(),
		      esc_attr($matches[1]),
		      '',
		      '',
		      ''
		   );

	   return apply_filters( 'embed_ytnocookie', $embed, $matches, $attr, $url, $rawattr );


	}
 
	/*
	 * Replace default video with Brid embed code
	 */
	public static function replace_video_code($atts, $content=null) {
    	
     global $pagenow;
     $partnerId = BridOptions::getOption('site');
	   $playerId = BridOptions::getOption('player');
	   $width = BridOptions::getOption('width');
	   $height = BridOptions::getOption('height');
	   $src = '';
	   $time = self::genRandId();

	   $feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));

     //Only for admin area (for visual editor)
		 if($pagenow=='admin-ajax.php'){
        
        $src .='<script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script>';
       
     }
     //Fe part
	   $src .= '<!--WP embed code replace Video object - Brid Ver.'.BRID_PLUGIN_VERSION.' -->
	   <div id="Brid_'.$time.'" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"> 
	   <div id="Brid_'.$time.'_adContainer">Initialize ads</div> </div> 
	   <script type="text/javascript"> $bp("Brid_'.$time.'", {"id":"'.$playerId.'", "video": {src: "'.$atts['mp4'].'", name: "'.htmlspecialchars(get_the_title()).'", image:"'.$feat_image.'"}, "width":"'.$width.'","height":"'.$height.'"}); </script> 
	   ';
    
		return $src;

	}
	/*
	 * Get rand_id for brid player
	 */
    private static function genRandId(){

    	$tl = strlen(time());
    	return substr(time(),($tl-8),$tl).rand();
    }

    public static function add_brid_js(){
        global $post;
        $overrideDefaultVideo = BridOptions::getOption('ovr_def',true);
        $overrideYt = BridOptions::getOption('ovr_yt');

        if( is_a( $post, 'WP_Post' ) && (has_shortcode( $post->post_content, 'brid') )) {
                self::checkScriptEnqueued('brid.min.js', CLOUDFRONT.'player/build/brid.min.js');
         }
         //Override Default HTML5 element
          if( is_a( $post, 'WP_Post' ) && $overrideDefaultVideo && (has_shortcode( $post->post_content, 'video') )) {
                self::checkScriptEnqueued('brid.min.js', CLOUDFRONT.'player/build/brid.min.js');
         }
        //Check are there YT links
        if($overrideYt){
         if(preg_match('/https?:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $post->post_content, $vresult)) {
         
            self::checkScriptEnqueued('brid.min.js', CLOUDFRONT.'player/build/brid.min.js');

          }
        }
        
    }
} 



$overrideYt = BridOptions::getOption('ovr_yt',true);
$overrideDefaultVideo = BridOptions::getOption('ovr_def',true);

//Override default video object
if($overrideDefaultVideo){
    add_shortcode( 'video', array('BridShortcode','replace_video_code'));
}
//Override youtube links if enabled
if($overrideYt){

    wp_embed_register_handler( 'ytnocookie', '#https?://www\.youtube\-nocookie\.com/embed/([a-z0-9\-_]+)#i', array('BridShortcode','wp_embed_handler_youtube'));
    wp_embed_register_handler( 'ytnormal', '#https?://www\.youtube\.com/watch\?v=([a-z0-9\-_]+)#i', array('BridShortcode','wp_embed_handler_youtube' ));
    wp_embed_register_handler( 'ytnormal2', '#https?://www\.youtube\.com/watch\?feature=player_embedded&amp;v=([a-z0-9\-_]+)#i', array('BridShortcode','wp_embed_handler_youtube') );
    //Shortcode for Brid YT
    add_shortcode('brid_override_yt', array('BridShortcode' ,'brid_override_yt_shortcode'));

}
//Enque brid.min.js only if post contain brid shortcode
add_action('wp_enqueue_scripts', array('BridShortcode' ,'add_brid_js'));
//Brid shortcode function
add_shortcode('brid', array('BridShortcode' ,'brid_shortcode'));

