<div class="mainWrapper">
 
    <?php /*if( isset($_GET['settings-updated']) && $_GET['settings-updated']==true ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
  <?php } */ 

  if(empty($sites)){
    ?>
    <div style="margin-top:20px;">
     <p>We detected that your WordPress instalation is in a local testing environment. The Brid video plugin cannot function on dev sites.<br />
		Please use the plugin with a live site.<br />
		If our detection system made a mistake, please send us a ticket - <a href='https://brid.zendesk.com/hc/en-us' target='_blank'>https://brid.zendesk.com/hc/en-us.</a>
		</p>
     <div class="mainWrapper">
        <div class="mainButtonsMenu" style='display:none;'>
          <div class="button add-site various" data-fancybox-type="ajax" data-action="addPartner" href="<?php echo admin_url('admin-ajax.php'); ?>" id="addPartner">
            <div class="buttonLargeContent">ADD SITE</div>
          </div>
        </div>
      </div>
   </div>
   <script>
      //Used in callback on save -> partnerCreateSnapshot
      var settingsUrl = "<?php echo admin_url('options-general.php?page=brid-video-config'); ?>"
      initFancybox();
   </script>
     <?php
  }else{


  ?>
   <form method="post" action="options.php" id="bridSettingsForm">
      <?php settings_fields('brid_options'); ?>
                      
        <!-- oAuth token -->
        <input type="hidden" name="brid_options[oauth_token]" value="<?php echo $oAuthToken; ?>"/>
        <!-- User id -->
        <input type="hidden" name="brid_options[user_id]" value="<?php echo $user_id; ?>"/>
        <!-- Player width -->
        <input type="hidden" id="width" name="brid_options[width]" value="<?php echo $width; ?>"/>
        <!-- Player height -->
        <input type="hidden" id="height" name="brid_options[height]" value="<?php echo $height; ?>"/>
        <!-- Player autoplay -->
        <input type="hidden" id="autoplay" name="brid_options[autoplay]" value="<?php echo $autoplay; ?>"/>

        <div class="settingsTitle">CHOOSE SITE</div>
        <select id="sites" name="brid_options[site]" class="chzn-select" style="width:862px;">';
        <?php
            if(!empty($sites)){

              foreach($sites as $k=>$v){
                  $s = '';
                  if($selected==''){
                    $selected = $k;
                  }
                  if($k==$selected){
                    $s = 'SELECTED';
                  }
                  echo '<option value="'.$k.'" '.$s.'>'.$v.'</option>';
              }

              $players = array();
              if($selected!=''){
                $players = $api->call(array('url'=>'players/'.$selected), true);

              }

            }

            
        ?>
        </select>
       
        
        <script>
        var playerList = <?php echo json_encode($players); ?>;
        </script>

        <div id="playerList" style="display:<?php echo !empty($players) ? 'block' : 'none'; ?>">

          <div class="settingsTitle">CHOOSE PLAYER</div>

          <select id="playerListSelect" name="brid_options[player]" class="chzn-select" style="width:862px;">
            <?php
            if(!empty($players)){
              $n = count($players);
             
              foreach($players as $k=>$v){
                  $s = '';
                  if($v->Player->id==$playerSelected || $n==1){
                    $s = 'SELECTED';
                  }
                  echo '<option value="'.$v->Player->id.'" '.$s.' data-options=\''.json_encode($v->Player).'\'>'.$v->Player->name.'</option>';
              }

            }?>
          </select>
        </div>

          <div class="button auth-plugin" data-href="#" id="authPlugin" style="margin-top:20px;">
            <input type="submit" class="buttonLargeContent" value="SAVE CHANGES" style="height:48px;"/>
          </div>
       
  </form>
</div>
<?php } ?>
<script>
    
    jQuery(".chzn-select").chosen();

    jQuery("#playerListSelect").on("change", function(){

        playerChanged();

    });
    function playerChanged(){
       debug.log('playerChanged');
        var json = jQuery('#playerListSelect :selected').attr('data-options');
        var player = jQuery.parseJSON( json );

         jQuery('#width').val(player.width);
         jQuery('#height').val(player.height);
         jQuery('#autoplay').val(player.autoplay==1 ? 1 : 0);

    }

    jQuery("#sites").on("change", function(){
     
        //$Brid.Api.call({action : "brid_api_get_players", "id" : jQuery(this).val(), "callback" : "bridPlayerList"});
        $Brid.Api.call({
                    dataType : 'json',
                    data : {action : "brid_api_get_players", "id" : jQuery(this).val()}, 
                    callback : { after : { name : "bridPlayerList"} }
                  });
     
    });
    <?php if( isset($_GET['code'])) { ?>

      var siteNum = jQuery('#sites option').size();
      var playerNum = jQuery('#playerListSelect option').size();

      debug.log('Site', siteNum, playerNum);

      if(siteNum==1 && playerNum==1){

        playerChanged();

        jQuery('#bridSettingsForm').submit();

      }

    <?php } ?>
</script>