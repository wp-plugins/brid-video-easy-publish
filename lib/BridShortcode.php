<?php
/**
 * BridShortcode class will manage all shortcode manipulation
 * @package plugins.brid.lib
 * @author Brid Dev Team, contact@brid.tv
 * @version 1.1
 */
class BridShortcode {

    public $counter = 0;

    /**
     * Brid widget short code
     * [brid_widget items="25" player="1" height="540" type="1"] //YT
     * [brid_widget items="25" player="1" height="540" type="0"] //Brid videos
     * [brid_widget items="25" player="1" height="540" type="0" autoplay="1"] //Brid videos with autoplay
     * [brid_widget items="25" player="1" height="540" type="0" player="1789"] //Brid videos with player id 1789
     * [brid_widget items="25" player="1" height="540" type="1" category="14"] //Youtube Brid videos from category id 14
     * [brid_widget items="25" player="1" height="540" type="0" category="14"] //Brid videos from category id 14
     * Type is for playlist type 0/1 yt or brid
     */
    public static function brid_widget($attrs, $content){

       global $wp_widget_factory;
      

        extract(shortcode_atts(array(
            'widget_name' => 'BridPlaylist_Widget',
            'items'=>10,
            'height'=>360,
            'player'=>BridOptions::getOption('player'),
            'category'=>null,
            'autoplay'=>null,
            'color'=>0,
            'type'=>0
        ), $attrs));
        
        $widget_name = wp_specialchars($widget_name);

        if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
            $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
            
            if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
                return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$wp_class.'</strong>').'</p>';
            else:
                $class = $wp_class;
            endif;
        endif;
        
        ob_start();
        wp_register_script('jquery','jquery');
        wp_print_scripts('jquery','jquery');

        wp_register_script('brid.min.js', CLOUDFRONT.'player/build/brid.min.js', array(), null);
        wp_print_scripts('brid.min.js', CLOUDFRONT.'player/build/brid.min.js', array(), null);

        wp_register_script('brid.widget.min.js', BRID_PLUGIN_URL.'js/brid.widget.min.js', array(), null);
        wp_print_scripts('brid.widget.min.js');
       
        $instance['items'] = $items;
        $instance['height'] = $height;
        $instance['playerId'] = $player;
        $instance['bgColor'] = $color;
        $instance['playlist_id'] = $type;
        if($category!==NULL){
          $instance['category_id'] = $category;
        }

        if($autoplay!==NULL){
          $instance['autoplay'] = $autoplay;
        }

        the_widget($widget_name, $instance, array('widget_id'=>'brid-arbitrary-instance-'.$id,
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => ''
        ));
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
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

      $appendStyle = '';
      if(isset($attrs['align']) && $attrs['align']=='center'){
        $appendStyle = 'style="margin:0px auto;display:inline-block"';
      }
      if(isset($attrs['style']) && !empty($attrs['style'])){
        $appendStyle = 'style="'.$attrs['style'].'"';
      }


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
      $size = BridShortcode::getSize();

    	$playerOptions['width'] = strval(isset($attrs['width']) ? $attrs['width'] : $size['width']);
    	$playerOptions['height'] = strval(isset($attrs['height']) ? $attrs['height'] : $size['height']);

       
      //<script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script>
      //Brid.forceConfigLoad = true;

      $embedCode =  '<!--WP embed code - Brid Ver.'.BRID_PLUGIN_VERSION.' -->';
    	$embedCode .=  '<script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script>';
    	$embedCode .= '<div id="Brid_'.$divId.'" class="brid" '.$appendStyle.' itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><div id="Brid_'.$divId.'_adContainer"></div></div>';
		  $embedCode .= '<script type="text/javascript">$bp("Brid_'.$divId.'", '.json_encode($playerOptions).');</script>';
      
		
		return $embedCode;
    }
    /**
     * Render short code for override YT players
     */
    public static function brid_override_yt_shortcode($attrs){

      $partnerId = BridOptions::getOption('site');
      $playerId = BridOptions::getOption('player');
      $sizeSettings = BridShortcode::getSize();

      $size['width'] = strval(isset($attrs['width']) ? $attrs['width'] : $sizeSettings['width']);
      $size['height'] = strval(isset($attrs['height']) ? $attrs['height'] : $sizeSettings['height']);
        
      $introEnabled = BridOptions::getOption('intro_enabled',true);
      $id = $attrs['src'];

      $image = 'https://i.ytimg.com/vi/'.$id.'/hqdefault.jpg';
      $time = self::genRandId();

      $embedCode = '<!--WP embed code replace YT object - Brid Ver.'.BRID_PLUGIN_VERSION.' --><script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script><div id="Brid_'.$time.'" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><div id="Brid_'.$time.'_adContainer"></div></div>';

       $override = intval($introEnabled);

       if($introEnabled){
          $embedCode .= '<script type="text/javascript"> $bp("Brid_'.$time.'", {"id":"'.$playerId.'", "yt" : {"src" : "'.$id.'", image:"'.$image.'"} ,"video":"'.CLOUDFRONT.'services/ytvideo/'.$partnerId.'.json", "width":"'.$size['width'].'","height":"'.$size['height'].'"}); </script>';
      }else{
        $embedCode .= '<script type="text/javascript"> $bp("Brid_'.$time.'", {"id":"'.$playerId.'", "video": {"src" : "'.$id.'"}, "width":"'.$size['width'].'","height":"'.$size['height'].'"}); </script>';
      }

      return $embedCode;
    }
   
    /*
     * Replace youtube links with Brid embed code
     */
	public static function wp_embed_handler_youtube( $matches, $attr, $url, $rawattr ) {
	   
     global $pagenow;

	   $embed  = $url;
     $src = '';

      //This is the short code for front end area only
      if(isset($matches[1]))
      {
        $src .= BridShortcode::brid_override_yt_shortcode(array('src'=>$matches[1]));
        //$src .= '[brid_override_yt src="'.$matches[1].'"]';

      }
    //}

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
    /* Get Player size */
    public static function getSize(){

        $aspect = BridOptions::getOption('aspect');
        if($aspect=='1'){
            return BridShortcode::aspectSize();
        }     
        return array('width'=>BridOptions::getOption('width'), 'height'=>BridOptions::getOption('height'));
    }
 
	/*
	 * Replace default video with Brid embed code
	 */
	public static function replace_video_code($atts, $content=null) {
    	
     $partnerId = BridOptions::getOption('site');
	   $playerId = BridOptions::getOption('player');
     $size = BridShortcode::getSize();
	   $src = '';
	   $time = self::genRandId();

	   $feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));

     //Front-end part
	   $src .= '<!--WP embed code replace Video object - Brid Ver.'.BRID_PLUGIN_VERSION.' --><script type="text/javascript" src="'.CLOUDFRONT.'player/build/brid.min.js"></script><div id="Brid_'.$time.'" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><div id="Brid_'.$time.'_adContainer"></div></div><script type="text/javascript"> $bp("Brid_'.$time.'", {"id":"'.$playerId.'", "video": {src: "'.$atts['mp4'].'", name: "'.htmlspecialchars(get_the_title()).'", image:"'.$feat_image.'"}, "width":"'.$size['width'].'","height":"'.$size['height'].'"});</script>';
    
		return $src;

	}
	/*
	 * Get rand_id for brid player
	 */
    private static function genRandId(){

    	$tl = strlen(time());
    	return substr(time(),($tl-8),$tl).rand();
    }
    /*
     * Try to override YT plugin links
     */
    public static function overrideYTEmbed($content){

        $aspect = BridOptions::getOption('aspect');

        $reg = "#<iframe[^>]+>.*?</iframe>#is";
        if(preg_match_all($reg, $content, $matches)){

                $playerId = BridOptions::getOption('player');

                foreach ($matches[0] as $key => $match) {
               
                    $iframe = $matches[0][$key];

                    $iframes[] = $iframe;

                    $src = '';
                    $shortcode = '<!-- Brid YT Try -->'.$match;
                    if(preg_match('/src=\"(.*)\"/isU', $iframe, $m)){

                        $src = $m[1];
                    }
                    if($src!=''){
                      //Is iframe Youtube?
                      if(strpos($src, '//www.youtube')!==false || strpos($src, '//youtu.be')!==false)
                      {

                          if($aspect=='1'){
                            preg_match('/width=\"(.*)\"/isU', $iframe, $mW);
                            preg_match('/height=\"(.*)\"/isU', $iframe, $mH);
                          }

                          
                        //Params
                        $d = explode('/', $src);
                        if(!empty($d) && isset($d[4]))
                        {
                            $d2 = explode('?', $d[4]);

                           if(isset($d2[0]))
                            {
                                if($src!=''){

                                    $opt = array('src'=>$d2[0]);

                                    if($aspect=='1'){
                                      if(isset($mW[1])){
                                        $w = intval($mW[1]);
                                        if($w>0)
                                          $opt['width'] = $mW[1];
                                      }
                                      if(isset($mH[1])){
                                         $h = intval($mH[1]);
                                         if($h>0)
                                            $opt['height'] = $mH[1];
                                      }
                                    }
                                    $shortcode = '<!-- Brid Filter YTEmbed Plugin -->'.BridShortcode::brid_override_yt_shortcode($opt);
                                    $content = str_replace($iframe, $shortcode, $content);
                                }
                            }
                        }
                      }
                      //Is iframe brid iframe?
                      if(strpos($src, CLOUDFRONT)!==false){

                          $src = str_replace(CLOUDFRONT.'services/iframe/','',$src);

                          $d = explode('/', $src);

                          $opt[$d[0]] = $d[1]; //video = video_id_num
                          $opt['id'] = $d[2];  //id = player id
                          $opt['autoplay'] = $d[4]; //check autoplay option

                          $shortcode =  '<!-- Brid Filter Brid Iframe Plugin -->'.BridShortcode::brid_shortcode($opt);

                          $content = str_replace($iframe, $shortcode, $content);
                      }
                    }
                }
        }
        return $content;
    } 
    /*
     * Get responsive aspect size
     */  
    public static function aspectSize()
    {
        $width = null;
        try
        {
            $embed_size_w = intval(get_option('embed_size_w'));

            global $content_width;
            if (empty($content_width))
            {
                $content_width = $GLOBALS['content_width'];
            }

            $width = $embed_size_w ? $embed_size_w : ($content_width ? $content_width : BridOptions::getOption('width'));
        }
        catch (Exception $ex)
        {
            
        }

        $width = intval(preg_replace('/\D/', '', $width)); //may have px

        //Protect width
        if(!is_numeric($width) || $width==0 || $width<200){
            $width = BridOptions::getOption('width');
        }
        
        // attempt to get aspect ratio correct height from oEmbed
        $height = round(($width * 9) / 16, 0);

        return array('width'=>$width, 'height'=>$height);


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
    wp_embed_register_handler( 'ytnormal3', '#https?://youtu\.be/([a-z0-9\-_]+)#i', array('BridShortcode','wp_embed_handler_youtube') );
    //https://www.youtube.com/embed/VZa-Z-cEWsM?feature=oembed&wmode=opaque&vq=hd720
    wp_embed_register_handler( 'ytnormal4', '#https?://youtube\.com/watch\?v=([a-z0-9\-_]+)#i', array('BridShortcode','wp_embed_handler_youtube') );
    add_filter('the_content', array('BridShortcode', 'overrideYTEmbed'), 99);
}
//Shortcode for Brid YT
add_shortcode('brid_override_yt', array('BridShortcode' ,'brid_override_yt_shortcode'));
//Brid shortcode function
add_shortcode('brid', array('BridShortcode' ,'brid_shortcode'));
add_shortcode('brid_widget', array('BridShortcode' ,'brid_widget'));