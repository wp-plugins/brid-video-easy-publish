<?php
require_once BRID_PLUGIN_DIR.'/vendor/PHP-OAuth2/client.php';
/**
 * Brid Api Class
 * @package plugins.brid.lib
 * @author Brid Dev Team
 * @version 1.0
 */
class BridAPI {

  public $api_endpoint;
  public $options;
  public $client;
  public $code;

  // DON'T CHANGE THIS
  const OAUTH_CONSUMER_KEY    = 'NTMxNmU1MGRkMzFkZDFl';
  const OAUTH_CONSUMER_SECRET = '774ec6a3eb700518d34e94f3a066ba326fb4c955';
  const OAUTH_PROVIDER     = 'http://cms.brid.tv'; 
  const API_ENDPOINT       = 'http://cms.brid.tv/api'; 
  
  const AUTHORIZATION_PATH = '/api/authorize';
  const TOKEN_PATH         = '/api/token';

  static $default_options = array('api_version' => 1, 'content_type' => 'json');

  public function __construct($options=array()) {
    $this->oauth_token    = BridOptions::getOption('oauth_token');
    $this->oauth_provider = self::OAUTH_PROVIDER;
    $this->api_endpoint   = self::API_ENDPOINT;
    $this->options        = array_merge(self::$default_options, $options);
    $this->client         = new OAuth2Client(self::OAUTH_CONSUMER_KEY, self::OAUTH_CONSUMER_SECRET, OAuth2Client::AUTH_TYPE_FORM);
    $this->client->setAccessTokenType(OAuth2Client::ACCESS_TOKEN_BEARER);
    $this->client->setAccessToken($this->oauth_token);
    
  }
  /*
   * Set access token
   * @param (string) $token
   */
  public function setAccessToken($token){
    $this->oauth_token =  $token;
    $this->client->setAccessToken($this->oauth_token);
  }
  /**
   * Get authorization URL
   * @param (string) $redirect_uri Redirect Uri
   * @return (string) Authentication Url
   */
  public function authorizationUrl($redirect_uri) {
    return $this->client->getAuthenticationUrl($this->oauth_provider.self::AUTHORIZATION_PATH, $redirect_uri);
  }
  /**
   * Get access token
   * @param (array) $params['refresh_token'] = 'refresh_token_value'
   */
  public function accessToken($params) {
    $response = $this->client->getAccessToken($this->oauth_provider.self::TOKEN_PATH, OAuth2Client::GRANT_TYPE_AUTH_CODE, $params);
    return $response['body'];
  }
  /**
   * Refresh access token
   */
  public function refreshToken($params) {
    $response = $this->client->getAccessToken($this->oauth_provider.self::TOKEN_PATH, OAuth2Client::GRANT_TYPE_REFRESH_TOKEN, $params);
    return $response['body'];
  }
  /**
   * Make APi GET/POST call
   * @param (array) $arguments - array('url'=>'method_name', 'params'=>'POST ARRAY if we want to make post request - optional')
   * @param bool $encode (if true response will be json_encode if false it will be stdClass object)
   */
  public function call($arguments, $encode=false){

    $url = $this->api_endpoint.'/'.$arguments['url'].'.json';
    
   
      if(isset($arguments['params']))
      {
        //POST
        $response = $this->client->fetch($url, $arguments['params'], OAuth2Client::HTTP_METHOD_POST, $this->http_headers(), $encode);

      }else{ 
        //GET
        $response = $this->client->fetch($url, array(), OAuth2Client::HTTP_METHOD_GET, $this->http_headers(), $encode);

      }
   
      if (isset($response['body'])){ 
        $return = $response['body'];
        $this->body = $response['body'];
      }
      else {
        $return = null;
      }
      $this->code = $response['code'];
      if(!headers_sent()){
          header('Brid-Api-Url: '.$url);
      }
      if(!$encode && !headers_sent()) {
        header('Content-type: application/json');
      
        if(isset($arguments['params']))
          header('Brid-Api-Post: '.json_encode($arguments['params']));

         header('Brid-Api-Resonse: '.json_encode($response));
      }
      //Return body on success
      if($this->code==200)
      {
        return $return;

      }else{

        if($this->code==500 || $this->code==404){
          $response['body'] = $response['body'];
          if(!is_object($response['body'])){ 
              $response['body'] = (isset($response['body']) && !empty($response['body'])) ? json_decode($response['body']) : new StdClass();
          }
          if($response['body']==''){
            $response['body'] = new StdClass();
          }

          $response['body']->error = isset($response['body']->name) ? $response['body']->name : 'Unknown error or empty error response.';
          if(isset($this->code)){
             $response['body']->error .= ' Code:'. $this->code;
          }
          if(!$encode){
            $response['body'] = json_encode($response['body']);
          }
        }else
        //Return custom Api object on error that will be checked in JS to show friendly message if API is down
        if(is_object($response['body']) && $response['body']!=false){
          $response['body']->error = isset($response['body']->name) ? $response['body']->name : 'Unknown error or empty error response.';
          if($encode){
            $response['body'] = json_encode($response['body']);
          }
        }else{
          $response['body'] = new StdClass();
          $response['body']->error = 'Unknown error or empty error response. No response from api.';
          if($encode){
            $response['body'] = json_encode($response['body']);
          }
        }

        return $response['body'];

      }
  }
  /**
  * Set custom WP headers
  */
  public function http_headers() {
    global $wp_version;

    return array(
      'User-Agent' => "WordPress/{$wp_version} | BridVideo/".BRID_PLUGIN_VERSION,
      'X-Site' => $_SERVER['HTTP_HOST'],
    );
  }

  /**
  * Dataset players - All player data info
  * @param (int) $id Site id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function players($id=null, $encode=false){

    $id = intval($id);
    if($id==null || $id==0 || !is_numeric($id)){
      throw new InvalidArgumentException('Partner id is required.');
    }

    $players = $this->call(array('url'=>'players/'.$id), $encode);

    return $players;
  }

  /**
  * List players id => name
  * @param (int) $id Site id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function playersList($id=null, $encode=false){

    $id = intval($id);
    if($id==null || $id==0 || !is_numeric($id)){
      throw new InvalidArgumentException('Partner id is required.');
    }

    $players = $this->call(array('url'=>'playersList/'.$id), $encode);

    return $players;
  }
  /**
   * Get api instance for pretty calls $api->get()->video($id)
   */
  public function get(){

    return $this;
  }

  /**
  * Add Video
  * @param (array) $_post - Post array video
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function addVideo($_post=array(),  $encode=false){

   
    if(isset($_post['data']['Video'])){
      $_post = $_post['data']['Video'];
    }

    if(!isset($_post) || empty($_post)){
      throw new InvalidArgumentException('Post is empty.');
    }
    if(isset($_post['channel_id_youtube'])){
        $_post['channel_id'] = $_post['channel_id_youtube'];
    }
    if(!isset($_post['channel_id']) || empty($_post['channel_id'])){
      throw new InvalidArgumentException('Channel id is required.');
    }
    if(!isset($_post['partner_id']) || empty($_post['partner_id'])){
      throw new InvalidArgumentException('Partner id is required.');
    }
    if(!isset($_post['external_url']) && empty($_post['external_url']))
    {
      if(!isset($_post['mp4']) || empty($_post['mp4'])){
        throw new InvalidArgumentException('Mp4 Url is required.');
      }
    }
    if(!isset($_post['name']) || empty($_post['name'])){
      throw new InvalidArgumentException('Video title is required.');
    }
    


    $post = array();
    foreach($_post as $k=>$v){
      $post['data[Video]['.$k.']'] = $v;
    }
    return $this->call(array('url'=>'addVideo', 'params'=>$post), $encode);
  }
  /**
  * Edit Video
  * @param (array) $_post - Post fetch array with url
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function fetchVideoViaUrl($_post=array(), $encode=false){
      if(!isset($_post) || empty($_post)){
        throw new InvalidArgumentException('Post is empty.');
      }
      if(!isset($_post['partner_id']) || empty($_post['partner_id'])){
        throw new InvalidArgumentException('Partner id is required.');
      }
      if(!isset($_post['videoUrl']) || empty($_post['videoUrl'])){
        throw new InvalidArgumentException('videoUrl is required.');
      }
      $post = array();
      foreach($_post as $k=>$v){
        $post['data[Video]['.$k.']'] = $v;
      }
    return $this->call(array('url'=>'fetchVideoViaUrl', 'params'=>$post), $encode);
  }
  
  /**
  * Edit Video
  * @param (array) $_post - Post array video
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function editVideo($_post=array(),  $encode=false){
     if(!isset($_post) || empty($_post)){
      throw new InvalidArgumentException('Post is empty.');
    }
    if(!isset($_post['id']) || $_post['id']==0 || !is_numeric($_post['id'])) {
      throw new InvalidArgumentException('Video id is required.');
    }
     $post = array();
    foreach($_post as $k=>$v){
      $post['data[Video]['.$k.']'] = $v;
      if($k=='Ad'){
        foreach($v as $my=>$ad){
          $post['data[Ad]['.$my.']'] = $ad;
        }
      }
    }
    //return json_encode($post);

    return $this->call(array('url'=>'editVideo', 'params'=>$post), $encode);
  }
  /**
  * Add Playlist
  * @param (array) $_post - Post array playlist with videos
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function addPlaylist($_post=array(), $encode=false){
    
    if(!isset($_post) || empty($_post)){
      throw new InvalidArgumentException('Post is empty.');
    }
    if(!isset($_post['name'])){ //Name
      throw new InvalidArgumentException('Playlist name is required.');
    }
    if(!isset($_post['partner_id'])){ //Name
      throw new InvalidArgumentException('Playlist partner_id is required.');
    }
    if(!isset($_post['ids'])){ //Video ids
      throw new InvalidArgumentException('Videos Ids (ids) is required post param.');
    }
     $post = array();
    foreach($_post as $k=>$v){
      if($k!='ids'){
        $post['data[Playlist]['.$k.']'] = $v;
      }else{
        $post['data[Video]['.$k.']'] = $v;
      }
    }
   

    return $this->call(array('url'=>'addPlaylist', 'params'=>$post), $encode);
    
  }
  protected function addVideoPlaylist($_post=array(), $encode=false){
     if(!isset($_post) || empty($_post)){
      throw new InvalidArgumentException('Post is empty.');
    }
    if(!isset($_post['id'])){ //CSV
      throw new InvalidArgumentException('Playlist id (id) is required post param.');
    }
    if(!isset($_post['ids'])){ //CSV
      throw new InvalidArgumentException('Videos Ids (ids) is required post param.');
    }

    $post = array();
    foreach($_post as $k=>$v){
      if($k!='ids'){
        $post['data[Playlist]['.$k.']'] = $v;
      }else{
        $post['data[Video]['.$k.']'] = $v;
      }
    }

    return $this->call(array('url'=>'addVideoPlaylist', 'params'=>$post), $encode);
  }
  
  /**
  * Edit Playlist
  * @param (int) $id - Playlist id
  * @param (array) $_post - Post array playlist data
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function editPlaylist($_post=array(),  $encode=false){

    if(!isset($_post) || empty($_post)){
      throw new InvalidArgumentException('Post is empty.');
    }
    if(!isset($_post['id'])){ //Name
      throw new InvalidArgumentException('Playlist id is required.');
    }
    if(!isset($_post['partner_id'])){ //Name
      throw new InvalidArgumentException('Playlist partner_id is required.');
    }
   
    $post = array();
    foreach($_post as $k=>$v){
      if($k!='ids'){
        $post['data[Playlist]['.$k.']'] = $v;
      }else{
        $post['data[Video]['.$k.']'] = $v;
      }
    }
    return $this->call(array('url'=>'editPlaylist', 'params'=>$post), $encode);
  }

  /**
   * Get channel list
   * @param (bool) $encode - False to encode it in json, true to return it in StdClass
   */
  protected function channelsList($encode=false){
    return $this->call(array('url'=>'channelsList'), $encode);
  }
  /**
  * Get video
  * @param (int) $id - Video id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function video($id=null,  $encode=false){
    $id = intval($id);
    if($id==null || $id==0 || !is_numeric($id)){
      throw new InvalidArgumentException('Partner id is invalid.');
    }
   
    $video = $this->call(array('url'=>'video/'.$id), $encode);
    //Fix dat format
    if(isset($video->Video))
    $video->Video->publish = implode('-',array_reverse(explode('-', $video->Video->publish)));
          
    return $video;
  }
  /**
  * Get playlist
  * @param (int) $id - Playlist id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function playlist($id=null,  $encode=false){
    $id = intval($id);
    if($id==null || $id==0 || !is_numeric($id)){
      throw new InvalidArgumentException('Playlist id is invalid.');
    }
    $playlist = $this->call(array('url'=>'playlist/'.$id), $encode);
    //Fix date format
    if(isset($playlist->Playlist))
    $playlist->Playlist->publish = implode('-',array_reverse(explode('-', $playlist->Playlist->publish)));

    return $playlist;
  }
  /**
  * Delete videos
  * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'ids'=>'1,2,3')
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  **/
  protected function deleteVideos($_p=array(),  $encode=false){
    if(!empty($_p)){
      if(isset($_p['partner_id'])) $_p['partner_id'] = intval($_p['partner_id']);
    }
    if(!isset($_p['partner_id']) || $_p['partner_id']==0){
      throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
    }
    if(isset($_p) && !isset($_p['ids'])){ //CSV
      throw new InvalidArgumentException('Ids (ids) is required post param.');
    }
    $post = array();
    foreach($_p as $k=>$v){
        $post['data[Video]['.$k.']'] = $v;
    }

    return $this->call(array('url'=>'deleteVideos', 'params'=>$post), $encode);
  }
  /**
  * Delete Ad
  * @param (array) $_post - Post array $_POST = array('id'=>AD_ID)
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  **/
  protected function deleteAd($_p=array(),  $encode=false){

    if(!isset($_p['id']) || $_p['id']==0){
      throw new InvalidArgumentException('Ad id (id) is required post param.');
    }
    $post = array();
    foreach($_p as $k=>$v){
        $post['data[Ad]['.$k.']'] = $v;
    }

    return $this->call(array('url'=>'deleteAd', 'params'=>$post), $encode);
  } 
  /**
   * Delete video from playlist
   * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'id'=>1, 'video_id'=>2)
   * @param (bool) $encode - False to encode it in json, true to return it in StdClass
   */
  protected function removeVideoPlaylist($_post, $encode=false){
    if(!empty($_post)){
      if(isset($_post['partner_id'])) $_post['partner_id'] = intval($_post['partner_id']);
      if(isset($_post['video_id'])) $_post['video_id'] = intval($_post['video_id']);
      if(isset($_post['id'])) $_post['id'] = intval($_post['id']);
    }
    if(!isset($_post['partner_id']) || $_post['partner_id']==0){
      throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
    }
    if(!isset($_post['id']) || $_post['partner_id']==0){ //CSV
      throw new InvalidArgumentException('Id (id) is required post param.');
    }
    if(!isset($_post['video_id']) || $_post['video_id']==0){ //CSV
      throw new InvalidArgumentException('Video id (video_id) is required post param.');
    }
    
    $post = array();
    
    foreach($_post as $k=>$v){
        $post['data[Playlist]['.$k.']'] = $v;
    }
    return $this->call(array('url'=>'removeVideoPlaylist', 'params'=>$post), $encode);
  }
  /**
  * Sort Playlist
  * @param (array) $_post - Post array playlist data $_post['id'] = Playlist id, $_post['ids'] = csv
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function sortVideos($_post=array(), $encode=false){
    if(!empty($_post)){
      if(isset($_post['id'])) $_post['id'] = intval($_post['id']);
      if(isset($_post['partner_id'])) $_post['partner_id'] = intval($_post['partner_id']);
    }
     if(!isset($_post['partner_id']) || $_post['partner_id']==0){
      throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
    }
    if(!isset($_post['id']) || $_post['partner_id']==0){ //CSV
      throw new InvalidArgumentException('Playlist id (id) is required post param.');
    }
    if(!isset($_post['sort']) || $_post['sort']==0){ //CSV
      throw new InvalidArgumentException('Video ids (sort) is required post param (csv).');
    }
    
    $post = array();
    foreach($_post as $k=>$v){
        $post['data[Playlist]['.$k.']'] = $v;
    }
    return $this->call(array('url'=>'sortVideos', 'params'=>$post), $encode);
  }
  /**
   * Clear playlist
   * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'id'=>1)
   * @param (bool) $encode - False to encode it in json, true to return it in StdClass
   */
  protected function clearPlaylist($_post=array(), $encode=false){
    if(!empty($_post)){
      if(isset($_post['id'])) $_post['id'] = intval($_post['id']);
      if(isset($_post['partner_id'])) $_post['partner_id'] = intval($_post['partner_id']);
    }
    if(!isset($_post['partner_id']) || $_post['partner_id']==0){
      throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
    }
    if(!isset($_post['id']) || $_post['partner_id']==0){ //CSV
      throw new InvalidArgumentException('Playlist id (id) is required post param.');
    }
    $post = array();
    foreach($_post as $k=>$v){
        $post['data[Playlist]['.$k.']'] = $v;
    }
    
    return $this->call(array('url'=>'clearPlaylist', 'params'=>$post), $encode);
  }
  /**
   * Delete playlists
   * @param (array) $_post - Post array $_POST = array('partner_id'=>1, 'ids'=>'1,2,3')
   * @param (bool) $encode - False to encode it in json, true to return it in StdClass
   */
  protected function deletePlaylists($_p=array(),  $encode=false){
    if(!empty($_p)){
      if(isset($_p['partner_id'])) $_p['partner_id'] = intval($_p['partner_id']);
    }
    if(!isset($_p['partner_id']) || $_p['partner_id']==0){
      throw new InvalidArgumentException('Partner id (partner_id) is required post param.');
    }
    if(isset($_p) && !isset($_p['ids'])){
      throw new InvalidArgumentException('Ids (ids) is required post param.');
    }
    $post = array();
    foreach($_p as $k=>$v){
        $post['data[Playlist]['.$k.']'] = $v;
    }
    return $this->call(array('url'=>'deletePlaylists', 'params'=>$post), $encode);
  }
  /**
   * Get ffmpeg info
   * @param (array) $_post - Post array $_POST = array('url'=>'http://www.my.video.com/1.mp4')
   * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function ffmpegInfo($_post = array(),  $encode=false){

    if(isset($_post) && !isset($_post['url'])){
      throw new InvalidArgumentException('Url parameter is empty or invalid.');
    }

    return $this->call(array('url'=>'ffmpegInfo/', 'params'=>$_post), $encode);
  }
  /**
  * Get partner info
  * @param (int) $id - Site id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function partner($id = null,  $encode = false){
    $id = intval($id);
    if($id==null || $id==0 || !is_numeric($id)){
      throw new InvalidArgumentException('Partner id is invalid.');
    }

    return $this->call(array('url'=>'partner/'.$id), $encode);
  }
  /**
  * Add partner
  * @param (int) $id - Site id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function addPartner($_post=array(), $encode=false){
    
    if(!isset($_post) || empty($_post)){
      throw new InvalidArgumentException('Post is empty.');
    }
    if(!isset($_post['domain'])){ //Name
      throw new InvalidArgumentException('Playlist name is required.');
    }
    if(!isset($_post['user_id'])){ //Name
      throw new InvalidArgumentException('Playlist partner_id is required.');
    }
    
    $post = array();
    foreach($_post as $k=>$v){

       $post['data[Partner]['.$k.']'] = $v;
      
    }
   

    return $this->call(array('url'=>'addPartner', 'params'=>$post), $encode);
    
  }
  /**
   * Call used to intercept exceptions
   */
  public function __call($method,$arguments) {
        if(method_exists($this, $method)) {
           try{
            $r = call_user_func_array(array($this,$method),$arguments);

            if(isset($r->code) && $r->code==1){

              throw new Exception ('Api error code: '.$r->code.'<br/>Api error msg: '.$r->error.'<br/>Api error name: '.$r->name.'<br/>Api error url: '.$r->url);
             
            }
            return $r;

            }catch(InvalidArgumentException $i){

              $this->displayException($i);

            }catch(Exception $e){
              $this->displayException($i);
            }
        }else{
          $class = new ReflectionClass('BridApi');

          $methods = $class->getMethods();

          die('Method ('.$method.') does not exist. Please visit: <a href="https://brid.zendesk.com/hc/en-us/categories/200078691-Developer-API">Brid developer api Documentation page</a> for further information.');
        }
    }
  /**
  * Get videos - LIST
  * @param (int) $id - Site id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function videos($id=null, $encode=false){
   
    if($id==null || $id==0 || !is_numeric($id)){
      throw new InvalidArgumentException('Partner id is invalid.');
    }
    $id = intval($id);
    //Append for pagiantion/ordering
    $append = ''; $search=''; $options = array('url'=>'videos/'.$id);

     if(isset($_POST['apiQueryParams'])){
      $options['url'] .= '/'.$_POST['apiQueryParams'];
     }

     //Save and invalidate search string
     if(isset($_POST['search'])){ $_SESSION['Brid.Video.Search'] = $_POST['search'];}

     if(isset($_SESSION['Brid.Video.Search']) && $_SESSION['Brid.Video.Search']!=''){

        $_POST['Video']['search'] = $search = $_SESSION['Brid.Video.Search'];
        $options['params'] = $_POST;
     }
     
     if(isset($_POST['subaction'])){
     	if(in_array($_POST['subaction'],array('addPlaylist','addPlaylistyt') ) ){
     		$options['params']['videos_type'] = $_POST['subaction']=='addPlaylist' ? 0 : 1;
     	}
     } 
    
     if(isset($_POST['playlistType'])){
     	$options['params']['videos_type'] = $_POST['playlistType'];
     }

     $videoSet = $this->call($options, $encode);

     //Change date to d/m/Y format
     if(!empty($videoSet->Videos)){
        foreach($videoSet->Videos as $k=>$v){
          $v->Video->publish = implode('-',array_reverse(explode('-', $v->Video->publish)));
        }
      }

    return $videoSet;
  }
  /**
  * Get playlists - LIST
  * @param (int) $id - Site id
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function playlists($id,  $encode=false){
    $id = intval($id);
     if($id==null || $id==0 || !is_numeric($id)){
      throw new InvalidArgumentException('Partner id is invalid.');
    }
    //Append for pagiantion/ordering
    $append = ''; $search=''; $options = array('url'=>'playlists/'.$id);

     if(isset($_POST['apiQueryParams'])){
      $options['url'] .= '/'.$_POST['apiQueryParams'];
     }

     //Save and invalidate search string
     if(isset($_POST['search'])){ $_SESSION['Brid.Playlist.Search'] = $_POST['search'];}

     if(isset($_SESSION['Brid.Playlist.Search']) && $_SESSION['Brid.Playlist.Search']!=''){

        $_POST['Playlist']['search'] = $search = $_SESSION['Brid.Playlist.Search'];
        $options['params'] = $_POST;
     } 

      $playlistSet = $this->call($options, $encode);

     //Change date to d/m/Y format
     if(!empty($playlistSet->Playlists)){
        foreach($playlistSet->Playlists as $k=>$v){
          $v->Playlist->publish = implode('-',array_reverse(explode('-', $v->Playlist->publish)));
        }
      }

    return $playlistSet;
  }
  /**
  * Get user
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function userinfo($encode=false){
    return $this->call(array('url'=>'userinfo'), $encode);
  }
  /**
   * Get sites list
   * @param (bool) $encode - False to encode it in json, true to return it in StdClass
   */
  protected function sitesList($encode=false){
    return $this->call(array('url'=>'sitesList'), $encode);
  }
  /**
   *  Display exception in json style so frontend can display it
   *
   * @param (Exception) $i - Exception object
   */
  public function displayException($i){
    if(!headers_sent())
      header('X-Error: By Brid Api');
    $error = array('name'=>$i->getMessage(), 'message'=>$i->getFile(), 'error'=>$i->getMessage(), 'class'=>get_class($i));
    if($i->getCode()!=0){
      $error['code'] = $i->getCode();
    }

    echo json_encode($error);
  }
  /**
  * Check Url
  * @param (array) $_post - Post array $_POST = array('url'=>'http://www.youtube.com/?w=32kdfkskfdsn')
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function checkUrl($_post=array(), $encode=false){

    if(!isset($_post['url']) && strlen($_post['url'])<10){
      throw new InvalidArgumentException('No valid param "url" provided');
    }
    return $this->call(array('url'=>'checkUrl', 'params'=>$_post), $encode);

  }
  /**
  * Set partner upload flags
  * @param (array) $_post - Post array $_p = array('id'=>1, 'upload'=>1)
  * @param (bool) $encode - False to encode it in json, true to return it in StdClass
  */
  protected function partnerUpload($_p=array(), $encode=false){

    if(!isset($_p['id']) || !isset($_p['upload'])){
      throw new InvalidArgumentException('No valid id or upload parameters provided');
    }
     $post = array();
    foreach($_p as $k=>$v){
        $post['data[Partner]['.$k.']'] = $v;
    }
    return $this->call(array('url'=>'partnerUpload', 'params'=>$post), $encode);

  }
  /**
   * Change status
   * @param (array) $_post - Post array $_POST = array('id'=>1, 'partner_id'=>1, 'controller'=>'videos', 'sttus'=>1)
   * @param (bool) $encode - False to encode it in json, true to return it in StdClass
   */
  protected function changeStatus($_post=array(), $encode=false){

    if(isset($_post['id'])){ $_post['id'] = intval($_post['id']); }

    if(!isset($_post['id']) || $_post['id']==0 || !is_numeric($_post['id'])){
      throw new InvalidArgumentException('Content id is invalid.');
    }
    if(!isset($_post['partner_id']) || $_post['partner_id']==0 || !is_numeric($_post['partner_id'])){
      throw new InvalidArgumentException('Content id is invalid.');
    } 
    if(!isset($_post['status']) && !is_numeric($_post['status'])){
      throw new InvalidArgumentException('"status" param is required.');
    }
    if(!isset($_post['controller']) || $_post['controller']==''){
      throw new InvalidArgumentException('Controller param must be valid value ("videos" or "playlists").');
    }
    /* $post = array();
    foreach($_post as $k=>$v){
      $post['data[Video]['.$k.']'] = $v;
    }*/
    return $this->call(array('url'=>'changeStatus', 'params'=>$_post), $encode);
  }

}

?>