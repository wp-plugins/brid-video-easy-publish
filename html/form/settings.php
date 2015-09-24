<?php 

//print_r($player->start_muted);

        if(empty($sites)){

          ?>
          <div style="margin-top:20px;">
           <p>No sites, please visit our <a href="https://cms.brid.tv" target="_blank">CMS</a> and add website.</p>
         </div>
         <script>
            //Used in callback on save -> partnerCreateSnapshot
            var settingsUrl = "<?php echo admin_url('options-general.php?page=brid-video-config'); ?>"
         </script>
       <?php }else{  ?>

       <div id="settings_header_wrapper">
      
            <div id="logo<?php echo intval($premium); ?>">
                 <div id="clickLogo" title="Go to Brid.tv"></div>
                    <div id="clickPlan" title="Plan explained"></div>
            </div>
             <?php if($premium==1 && $ask){ ?>
             <div class="mainWrapperNotice">
                <p class="bridNotice" id="bridNoticePremiumPlan">
                  You are currently on Brid's <a href="https://brid.zendesk.com/hc/en-us/articles/202211641" target="_blank">FREE PLAN</a>. You can upgrade to our <a href="https://brid.zendesk.com/hc/en-us/articles/202167711" target="_blank">ENTERPRISE PLAN</a> by <a  class="various" id="videoQuestion" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>">clicking here</a>.
        
                  <script>jQuery('#videoQuestion').colorbox({innerWidth:920, innerHeight:650});</script>
                </p>
             </div>
              <?php } ?>
              <div id="plan-premium">
                
                  <table class="plan-premium-table">
                        <tbody><tr>
                          <td colspan="2">
                            <div class="plan-info-top">
                            Free plan
                             <div class="stiklir right"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span>HTML5 Player with Flash fallback</span><br>

                            Powerfull JavaScript API<br>
                            33+ professionally designed skins<br>
                            Intelligent site skinning<br>
                            Responsive sizing<br>
                            Social sharing options<br>
                            VEEPS voip/chatplay plugin (exclusive)
                          </td>
                          <td>
                            <span>Full content management solution</span><br>
                            Google powered analytics<br>
                            Dynamic and Custom playlist support<br>
                            Wordpress plugin<br>
                            Youtube syndication
                          </td>
                        </tr>
                        <tr>
                          
                          <td colspan="2">
                            <span style="margin-top:15px;">You are free to monetize our player</span><br>
                            Pre-roll, mid-roll, post-roll and overlay, VAST and VPAID support, Flash and HTML5 ads
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <div class="plan-info-top" style="margin-top:15px;">
                              Enterprise plan
                               <div class="stiklir right"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span>Unlimited Encoding.com video encoding</span><br>
                            Virtually all formats supported with the fastest turnaround times<br>
                            Optimized playback accross all Android, iOS, web platforms:<br>
                            your videos will work everywhere<br>
                            No file duration restrictions<br>
                            HD video renditions supported<br>
                            Unlimited number of file uploads<br>
                            Upload up to 1 GB files<br>
                          </td>
                          <td style="padding-top:28px">
                            Whitelisted and approved social sharing links via https<br>
                            Unique customized skins and intro videos<br>
                            24/7 support<br>
                            HTML5 interactive ads support<br>
                            You receive <b>minimum 60% of revenue share</b><br>
                            
                          </td>
                        </tr>
                      </tbody></table>    
              </div>
                <div id="plan-free">
                
                  <table class="plan-premium-table">
                        <tbody><tr>
                          <td colspan="2">
                            <div class="plan-info-top">
                            Free plan
                            <div class="stiklir right"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span>HTML5 Player with Flash fallback</span><br>

                            Powerfull JavaScript API<br>
                            33+ professionally designed skins<br>
                            Intelligent site skinning<br>
                            Responsive sizing<br>
                            Social sharing options<br>
                            VEEPS voip/chatplay plugin (exclusive)
                          </td>
                          <td>
                            <span>Full content management solution</span><br>
                            Google powered analytics<br>
                            Dynamic and Custom playlist support<br>
                            Wordpress plugin<br>
                            Youtube syndication
                          </td>
                        </tr>
                        <tr>
                          
                          <td colspan="2">
                            <span style="margin-top:15px;">You are free to monetize our player</span><br>
                            Pre-roll, mid-roll, post-roll and overlay, VAST and VPAID support, Flash and HTML5 ads
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <div class="plan-info-top" style="margin-top:15px;background:#F21F03">
                              Enterprise plan
                              <div class="upgradeBrid right"></div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <span>Unlimited Encoding.com video encoding</span><br>
                            Virtually all formats supported with the fastest turnaround times<br>
                            Optimized playback accross all Android, iOS, web platforms:<br>
                            your videos will work everywhere<br>
                            No file duration restrictions<br>
                            HD video renditions supported<br>
                            Unlimited number of file uploads<br>
                            Upload up to 1 GB files<br>
                          </td>
                          <td style="padding-top:28px">
                            Whitelisted and approved social sharing links via https<br>
                            Unique customized skins and intro videos<br>
                            24/7 support<br>
                            HTML5 interactive ads support<br>
                            You receive <b>minimum 60% of revenue share</b><br>
                            
                          </td>
                        </tr>
                        <tr>
                        <td colspan="2" style="padding-bottom:0px">
                          <div class="bridButton">
                            <div class="buttonLargeContent" id="upgradeMe" style="font-family:'Fjalla One' Arial; float:right; font-size:16px" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>">UPGRADE PLAN</div>
                          </div>
        
                          <script>jQuery('#upgradeMe').colorbox({innerWidth:920, innerHeight:650});</script>
                          </td>
                      </tr>
                      </tbody></table>
                </div>
       </div>
       <script>
       var partnerUpload = <?php echo intval($premium); ?>;
       jQuery('#clickLogo').click(function(){
        window.open('https://cms.brid.tv', '_blank');
       })
        jQuery('#clickPlan, .plan-info-close').on('click', function(){
                
                //if(Object.keys(Partner).length>0){
                  var boxToShow = 'free';
                  if(partnerUpload!=1){
                    boxToShow = 'premium';
                  }
                  if(!jQuery('#plan-'+boxToShow).is(':visible'))
                    jQuery('#plan-'+boxToShow).show();
                  else
                    jQuery('#plan-'+boxToShow).hide();
               // }
              });
       </script>
      <?php if(!function_exists('curl_version')) { ?>
      
         <div class="mainWrapper" style="width:75%;">
              <p class="bridNotice">
              <img src="<?php echo BRID_PLUGIN_URL.'/img/warn.png'; ?>" style="position: relative; top: 1px; margin-right: 5px;"alt="Warning"/> You webserver is not properly configured to use the Brid plugin. Please install/enable cURL on your server before proceeding.

              </p>
           </div>
           
      <?php } ?>

        <?php if(!BridHtml::isThereCrossdomain()){ ?>

           <div class="mainWrapper" style="width:75%;" id="crossdomainBlock">
              <p class="bridNotice">
              <img src="<?php echo BRID_PLUGIN_URL.'/img/warn.png'; ?>" style="position: relative; top: 1px; margin-right: 5px;"alt="Warning"/>We did not detect a valid <b>crossdomain.xml</b> file in your root HTML folder on your server. 
              To properly display videos and snapshots through the Brid player in Flash mode, you will need a valid crossdomain.xml file on your server. 
              <a href="http://www.adobe.com/devnet/adobe-media-server/articles/cross-domain-xml-for-streaming.html" target="_blank">Read here</a> on how to create one  or alternatively <a href="#" id="createCrossdomainLink">click here</a> and we will try to create one for you. <a href="https://brid.zendesk.com/hc/en-us/articles/202769612" target="_blank">Learn more</a>.
              </p>
           </div>
           <script>
            jQuery('#createCrossdomainLink').click(function(e){

                e.preventDefault();

                 jQuery.ajax({
                    url: '<?php echo admin_url("admin-ajax.php?action=createCrossdomain"); ?>'
                  }).done(function( data ) {

                    console.log(data);
                    alert(data.msg);
                    if(data.success){
                      jQuery('#crossdomainBlock').fadeOut();
                    }
                    
                  });

            })

           </script>

        <?php } ?>



          <div class="mainWrapper" style="width:100%;position:relative; top:20px">
            <div class="mainWrapper" style="width:75%;">
            <form method="post" action="admin.php?page=brid-video-config" id="bridSettingsForm">
              <div style="padding-top:2px;" class="tabs">
                    <div id="Settings" class="tab" style="width: 33.3%;border-right:2px solid #fff;">SETTINGS</div>
                    <div id="Monetization" class="tab-inactive" style="border-left:2px solid #fff;margin-right: 0px; width: 33.3%;">MONETIZATION</div>
                    <div id="Player" class="tab-inactive" style="border-left:2px solid #fff;margin-right: 0px; width: 33.3%;">PLAYER</div>
              </div>
              <div id="Settings-content" class="tab-content settingsWrapper" style="display:block;">
                
                  <?php 
                    if(isset($_GET['bridDebug'])){
                      print_r(get_option('brid_options'));
                    }
                      settings_fields('brid_options'); 
                    
                      //do_settings_sections('brid-plugin');
                  ?>
                                
                    
                    <input type="hidden" name="brid_options[oauth_token]" value="<?php echo $oAuthToken; ?>"/>

                    <input type="hidden" name="brid_options[user_id]" value="<?php echo $user_id; ?>"/>

                    <input type="hidden" id="width" name="brid_options[width]" value="<?php echo $width; ?>"/>

                    <input type="hidden" id="height" name="brid_options[height]" value="<?php echo $height; ?>"/>
    

                    <input type="hidden" id="autoplay" name="brid_options[autoplay]" value="<?php echo $autoplay; ?>"/>

                    <input type="hidden" id="intro_enabled" name="brid_options[intro_enabled]" value="<?php echo $partner->Partner->intro_video; ?>"/>

                    <input type="hidden" id="PartnerId" name="Partner[id]" value="<?php echo $selected; ?>"/>
                  
                    <div class="settingsTitle lined"><div class="chkboxTitle">CHOOSE SITE</div></div>
                 
                    <select id="sites" name="brid_options[site]" class="chzn-select" style="width:100%;">';
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

                          

                        }

                        
                    ?>
                    </select>
        
                   <div class="flashFalbackWarring" style="margin-left:10px">All your content on Brid will be managed under this site/account. To add more sites, please <a href="https://cms.brid.tv" target='_blank'>login to BridTv</a>.</div>
                    

                    <?php
                        //Show preview player in visual editor
                        BridHtml::checkbox(array(

                              'id'=>'visual',
                              'name'=>'brid_options[visual]',
                              'value'=>$visual_preview,
                              'marginBottom'=>10,
                              'title'=> 'SHOW PREVIEW PLAYER IN VISUAL EDITOR',
                              'desc'=>'If enabled, will show a preview of the player in your WordPress <a href="https://codex.wordpress.org/Writing_Posts#Visual_Versus_Text_Editor" target="_blank">Visual tab</a> on posts or pages. (May add additional paragraph tags depending on used theme)'

                          ));
                        //Override default video embed
                        BridHtml::checkbox(array(

                              'id'=>'ovr_def',
                              'name'=>'brid_options[ovr_def]',
                              'value'=>$override_def_player,
                              'marginBottom'=>20,
                              'title'=> 'REPLACE DEFAULT PLAYER WITH BRID PLAYER',
                              'desc'=>'Will try to replace all WordPress default video tags with the BridTv player. All players successfully replaced will be automatically monetized with your Ad Tag URL that you set on the <a href="#" class="monetizeTabPage">Brid settings page</a>. <a href="https://brid.zendesk.com/hc/en-us/articles/202733772" target="_blank">Learn more</a>.'

                          ));
                        //Override defualt YT embed
                         BridHtml::checkbox(array(

                              'id'=>'ovr_yt',
                              'name'=>'brid_options[ovr_yt]',
                              'value'=>$override_youtube,
                              'marginBottom'=>20,
                              'title'=> 'REPLACE YOUTUBE LINKS WITH BRID PLAYER',
                              'desc'=>'Will try to replace all YouTube video tags with the BridTv player. All players successfully replaced will be automatically monetized with your Ad Tag URL that you set on the <a href="#" class="monetizeTabPage">Brid settings page</a>. <a href="https://brid.zendesk.com/hc/en-us/articles/202733772" target="_blank">Learn more</a>.'

                          ));

                         //intro_video
                         BridHtml::checkbox(array(

                              'id'=>'PartnerIntroVideo',
                              'name'=>'Partner[intro_video]',

                              'value'=>$partner->Partner->intro_video,
                              'title'=> 'PRE-ROLL BEFORE YOUTUBE VIDEO',
                              'desc'=>'Enable this option if you wish to additionally monetize YouTube videos via pre roll. A short intro video will be added before each of your YouTube videos if this option is enabled. <a href="https://brid.zendesk.com/hc/en-us/articles/201793131" target="_blank">Learn more.</a>',
                              'method'=>'toggleIntroTable'

                          ));

                    ?>  
                    
                 <table style="float:left;width:100%;padding-left:33px;margin-top:30px;" id="introVideoTable" class="<?php echo  (!$partner->Partner->intro_video) ? 'disabledInput' : ''?>">
                   <tr>
                     <td>

                        <div class="input text form">
                            <label class="setting" data-setting="title" style="">
                              <span>Custom intro video</span>
                              
                                <input name="Partner[intro_video_url]" value="<?php echo $partner->Partner->intro_video_url; ?>" placeholder="Custom intro video Url" maxlength="300" type="text" id="IntroVideo" data-ajax-loaded="true">
                                
                            </label>
                          </div>  
                        <div class="flashFalbackWarring" style="margin-left:10px">This intro video will be played before every YouTube video through the Brid player. If left empty, a default 3 second intro video will be provided by Brid. <a href="https://brid.zendesk.com/hc/en-us/articles/201793131" target="_blank">Learn more</a>.</div>
                      </td>
                    
                     <td style="width:105px;vertical-align:top;">

                        <div class="bridBrowseLibary" style="margin-top:30px" data-field="VideoMp4Hd" data-uploader_button_text="Add Intro Video" data-uploader_title="Browse for MP4 URL Source">BROWSE LIBRARY</div>                
                      </td>
                    </tr>
                  </table>
                   
                   
             
            </div>
            <div id="Monetization-content" class="tab-content settingsWrapper" style="display:none;">
         
                <div id="checkbox-monetize" class="bridCheckbox" data-method="toggleAdSettings" data-name="monetize" style="top:4px;margin-top: 20px; margin-bottom: 10px;">
                      <?php
                          $c = '';
                          if($player->monetize){
                            $c = 'checked';
                          }

                          $show = ($c=='') ? 'none' : 'block';
                        ?>
                      <div class="checkboxContent">
                        <img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:<?php echo $show; ?>" alt="">
                        
                        <input type="hidden" name="Player[monetize]" value="<?php echo $player->monetize; ?>" class="singleCheckbox <?php echo $c; ?>" id="monetize" data-value="<?php echo $player->monetize; ?>" style="display:none;" checked="checked" data-display="block">
                      </div>
                      <div class="checkboxText">Monetizable</div>
                      <div class="flashFalbackWarring" style="margin-left:31px">Turn on/off monetization options for this specific player. <a href="https://brid.zendesk.com/hc/en-us/articles/200294232" target="_blank">Learn more</a>.</div>
                </div>


                <div id="monetizationContent">  
                

                      <table class="form-table">
                      <tbody><tr>
                        <td>
                         <div class="formWrapper monetizationOptions" style="display:block;margin:0px;" id="adSettings">

                          <?php require_once('help_monetize.php'); ?>

                          <div id="monetAdvancedTitle" style="float:left; width:100%;margin-bottom:20px">
                            <div class="closeAlertDivButton" style="float:left;cursor:pointer;"></div>
                            <div class="checkboxText" style="cursor:pointer;float: left;margin-left: 10px;top: 7px;">ADVANCED OPTIONS</div>
                          </div>

                          <div id="monetAdvanced" style="display:block;">

                                  <div class="add-ad" data-type="preroll">
                                    <div class="bridButton add-preroll-ad" id="add-preroll-ad" style="opacity: 1;">
                                      <div class="buttonLargeContent">ADD PRE-ROLL</div>
                                    </div>
                                  </div>
                                  
                                  <div class="add-ad" id="add-ad-midroll" data-type="midroll">
                                    <div class="bridButton add-midroll-ad" id="add-midroll-ad" style="opacity: 1;">
                                        <div class="buttonLargeContent">ADD MID-ROLL / SET CUE POINTS</div>
                                    </div>
                                  </div>
                                  
                                  <div class="add-ad" data-type="overlay">
                                      <div class="bridButton add-overlay-ad" id="add-overlay-ad">
                                          <div class="buttonLargeContent">ADD OVERLAY</div>
                                      </div>
                                  </div>
                                  
                                  <div class="add-ad" data-type="postroll">
                                    <div class="bridButton add-postroll-ad" id="add-postroll-ad">
                                        <div class="buttonLargeContent">POSTROLL</div>
                                    </div>
                                  </div>

                                  <!-- Content div for ads -->
                                  <div class="mainWrapper form" style="width:auto">
                                    <div style="float:left; width:100%;margin-top:22px" id="brid-boxes-content">
                                      
                                    </div>
                                  </div>
                        </div>


                        </div>
                      </td>
                      </tr>
                    </tbody></table>
                  <div class="flashFalbackWarring" style="margin-left:10px;margin-top:5px;" id="adTagMsg">Add your own Ad Tag Url and monetize your content. <a href="">Learn more</a></div>
                  </div>

            </div>

            <div id="Player-content" class="tab-content settingsWrapper" style="display:none;">
                <div id="playerList" style="display:block">

                      <div class="settingsTitle lined"><div class="chkboxTitle">CHOOSE PLAYER</div></div>
                      <!-- fill this selectbox via ajax -->
                      <select id="playerListSelect" name="brid_options[player]" class="chzn-select2" style="width:100%;">
                       
                      </select>
                      <div class="flashFalbackWarring" style="margin-left:10px">All your video content will be played through the selected player. To add more players, please <a href="https://cms.brid.tv" target='_blank'>login to BridTv</a>.</div>
                    </div>
                <table style="margin-top:15px;width:100%;">
                    <tr>
                        <td style="width:100%; vertical-align: top;" colspan="2"> <div class="settingsTitle lined"><div class="chkboxTitle">CHOOSE SKIN</div></div></td>
                    </tr>
                    <tr>

                          <td style="width:50%; vertical-align: top;">

                            <input name="Skin[templatized]" type="hidden" value="0" id="SkinTemplatized" required="required">
                            <input name="Player[id]" type="hidden" value="0" id="PlayerId" required="required">

                            <div id="inteligentSkinMsg" style="margin-bottom: 15px;display:none;">Detected skin on this player is an <a href="https://brid.zendesk.com/hc/en-us/articles/200299471" target="_blank">intelligent skin</a>. To change the skin used on this player please change it via <a href="https://cms.brid.tv" target="_blank">Brid CMS</a>.</div>

                              <div id="skinList" style="display:<?php echo !empty($players) ? 'block;' : 'none'; ?>width:95%">


                                <select id="playerSkinSelect" name="Player[skin_id]" class="chzn-select2" style="width:100%;">
                                  <?php
                                  if(!empty($skins)){
                                    $n = count($skins);
                                   
                                    foreach($skins as $k=>$v){
                                        $s = '';
                                        //$v->Skin->id==$skinSelected || 
                                        if($n==1){
                                          $s = 'SELECTED';
                                        }
                                        echo '<option value="'.$v->Skin->id.'" '.$s.'>'.$v->Skin->name.'</option>';
                                    }

                                  }?>
                                </select>
                                <div class="flashFalbackWarring" style="margin-left:10px">Choose one of the many custom designed player skins.</div>
                              </div>
                              <div class="form" style="width:auto">
                                <!-- Player size -->
                                <table style="width:300px;margin-top:20px;">
                                  <tbody><tr>
                                      <td>
                                        <div class="input text required">
                                          <label for="PlayerWidth">Width</label>
                                          <input name="Player[width]" default-value="Width" data-info="Width" maxlength="10" type="text" value="<?php echo $width; ?>" id="PlayerWidth" required="required">
                                            <div class="defaultInputValue" data-info="Width" style="padding-top: 0px; display: none; top: 37px; padding-left: 5px; font-size: 16px;" id="default-value-PlayerWidth" data-position="true">Width</div>
                                          </div>
                                      </td>
                                      <td class="xTD"><div class="xX"></div></td>
                                      <td>
                                        <div class="input text required">
                                          <label for="PlayerHeight">Height</label>
                                          <input name="Player[height]" default-value="Height" data-info="Height" maxlength="10" type="text" value="<?php echo $height; ?>" id="PlayerHeight" required="required">
                                          <div class="defaultInputValue" data-info="Height" style="padding-top: 0px; display: none; top: 37px; padding-left: 5px; font-size: 16px;" id="default-value-PlayerHeight" data-position="true">Height</div>
                                        </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                 <!-- Player options -->
                             </div>

                             <?php

                              BridHtml::checkbox(array(

                                    'id'=>'PlayerAspect',
                                    'name'=>'brid_options[aspect]',
                                    'value'=>$aspect,
                                    'method'=>'togglePlayerSize',
                                    'title'=> 'FIT PLAYER SIZE TO POST',
                                    'marginBottom'=>15,
                                    'desc'=>'If enabled, the Brid player will fit your post width and retain it\'s aspect ratio.<br/>This option will override your player width and height settings.'

                                ));

                              BridHtml::checkbox(array(

                                    'id'=>'PlayerFlashFallback',
                                    'name'=>'Player[flash_fallback]',
                                    'value'=>$player->flash_fallback,
                                    'title'=> 'PREFER FLASH FALLBACK',
                                    'desc'=>'Supports Flash interactive (VPAID) ads.'

                                ));
                              //Player[autoplay]
                               BridHtml::checkbox(array(

                                    'id'=>'PlayerAutoplay',
                                    'name'=>'Player[autoplay]',
                                    'value'=>$player->autoplay,
                                    'title'=> 'AUTOPLAY',
                                    'desc'=>'Autoplay will automatically play the video when the player is loaded.'

                                ));

                                //Player[start_muted]
                               BridHtml::checkbox(array(

                                    'id'=>'PlayerStartMuted',
                                    'name'=>'Player[start_muted]',
                                    'value'=>$player->start_muted,
                                    'title'=> 'START MUTED',
                                    'desc'=>'Start videos with sound muted.'

                                ));
                              ?>
                             
                              <!-- Veeps -->
                              <div class="checkboxRowSettings" style="margin-top:20px;height:60px;margin-bottom:0px;">
                                <div class="bridCheckbox" id="checkbox-voipSocEnabled" data-method="toggleVoipSocialOptions" data-name="voipSocEnabled" style="top:4px;left:1px;">
                                  <div class="checkboxContent">
                                    <img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:none" alt="">
                                    <input type="hidden" name="Player[voipSocEnabled]" class="singleCheckbox" id="voipSocEnabled" data-value="<?php echo $player->voipSocEnabled; ?>" style="display:none;">
                                  </div>
                                  <div class="checkboxText tooltip" id="checkbox-voipSocEnabled">
                                    <div class="veepsLogo"></div>  
                                    <span style="font:italic bold 14px arial;color:#FEA952;position:relative;top:-5px;">- * Conference video and chat plug-in</span>
                                  </div>
                                  <div class="flashFalbackWarring" style="margin-left:31px">Enable VEEPS. A social VoIP plugin which enables your users to chat and conference. <a href="https://brid.zendesk.com/hc/en-us/articles/200294142" target="_blank">Learn more.</a></div>
                                </div>
                              </div>
                             


                              <div class="divAsRow" style="padding-left:38px;float:left;">
                                <div class="checkboxRowSettings" style="margin:0px;height:28px;">
                                
                                  <div class="bridCheckbox disabledCheckbox" id="checkbox-veepsChat" data-name="veepsChat" style="margin-top:4px;">
                                    <div class="checkboxContent">
                                      <img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:none" alt="">
                                      <input type="hidden" name="Player[veepsChat]" class="singleCheckbox" id="veepsChat" data-value="<?php echo $player->veepsChat; ?>" style="display:none;">
                                    </div>
                                    <div class="checkboxText tooltip" id="checkbox-veepsChat">Display video for user portraits</div>
                                  </div>
                                </div>
                                <div class="checkboxRowSettings"  style="margin:0px;height:28px;">
                                  <div class="bridCheckbox disabledCheckbox" id="checkbox-veepsType" data-method="toggleVeepsChatNextToPlayer" data-name="veepsType" style="margin-top:4px;text-transform:none;">
                                   <div class="checkboxContent"><img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:none" alt="">
                                    <input type="hidden" name="Player[veepsType]" class="singleCheckbox" id="veepsType" data-value="<?php echo $player->veepsType; ?>" style="display:none;"></div>
                                    <div class="checkboxText tooltip" id="checkbox-veepsType">Launch chat next to video player</div></div>
                                </div>

                                <div class="checkboxRowSettings" style="margin:0px;height:28px;">
                                <div class="bridCheckbox disabledCheckbox" id="checkbox-veepsInit" data-name="veepsInit" style="margin-top:4px;text-transform:none;left:11px;">
                                  <div class="checkboxContent">
                                    <img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:none" alt="">
                                    <input type="hidden" name="Player[veepsInit]" class="singleCheckbox" id="veepsInit" data-value="<?php echo $player->veepsInit; ?>" style="display:none;"></div>
                                    <div class="checkboxText tooltip" id="checkbox-veepsInit">Launch chat on "play" click</div></div>
                                </div>  

                              </div>

                          </td>
                          <td style="vertical-align: top;float:right; padding-right:5px;">
                              <div id="bridPlayerPreview">
                                <div id="Brid_27449775" class="brid"></div>
                              </div>
                              <div id="createCustomSkin">
                                  <span>Do you want unique custom made skin?</span><br/>
                                  Contact us at <a href="mailto:contact@brid.tv?subject=Custom made skin for <?php echo $_SERVER['HTTP_HOST']; ?>">contact@brid.tv</a> so we can make you a custom designed player skin (free of charge) specifically tailored for your site.
                                
                              </div>
                          </td>
                    </tr>


                </table>

            </div>
            <div class="propagate" style="position:relative;"><div>Please allow up to 10 minutes for changes to propagate.</div>

            <a href="#" class="unauthorizeBrid">Unauthorize account</a>
            </div>
            <!-- End Settings Tab -->
             <div class="bridButton auth-plugin" data-href="#" id="authPlugin" style="padding-left:10px; margin-top:20px;clear:both;">
                      <input type="submit" class="buttonLargeContent" value="SAVE CHANGES"/>
              </div>   

        </form>
           
      </div>
      <!-- End Main Fixed Wrapper 80% -->
       <!-- Start News Box -->
            <div class="bridNewsBox">
              <div class="bridNewsBoxTitle">FAQ</div>
              <ul id="bridWpNews">
                
              </ul>
              <div id="bridBugContent">
                <div id="bridBugIcon"></div>
                <a href="https://brid.zendesk.com/hc/en-us/requests/new" target="_blank" id="bridBugLink">Report a bug</a>
              </div>
          </div>
          <!-- End News Box -->
      </div>
      <!-- End Main Wrapper 100% -->

      
  <?php } ?>

<?php require_once('adBoxes.html'); ?>


<script>
    
    jQuery('#monetAdvancedTitle').on('click', function(e){

  jQuery('#monetAdvanced').fadeToggle(400, function(){

     if(jQuery('#monetAdvanced').is(':visible')){
      jQuery('.closeAlertDivButton').addClass('closeAlertDivButtonRot');
    }else{
      jQuery('.closeAlertDivButton').removeClass('closeAlertDivButtonRot');
    }
  });

  
});
    
    jQuery('html').css('background', '#fff');

    var file_frame = null;
    var playerSelected = '<?php echo $playerSelected; ?>';
    var currentAdCount = 0;
                  // 0 1 2 3
    var adTypes = ['preroll', 'midroll', 'postroll','overlay'];


    var ads = <?php echo json_encode(array());?>;

    initBridMain();
    $Brid.init(['Html.Tabs']);

    jQuery('.unauthorizeBrid').click(function(e){
      e.preventDefault();
      if(confirm("You will not be able to use the BridTv plugin anymore.\nAre you sure you want to unauthorize?"))
      {
       $Brid.Api.call({data : {action : "unauthorizeBrid"}, callback : {after : function(){


          window.location = window.location;

       }}});
      }

    });
    jQuery('input[id$="OverlayStartAt"], input[id$="OverlayDuration"]').off('keypress').on('keypress', $Brid.Util.onlyNumbers);
    jQuery('#PlayerWidth, #PlayerHeight').off('keypress').on('keypress', $Brid.Util.onlyNumbers);
    /**
     * Ad management - Add AD type click on button
     */
     jQuery('.add-ad').click(function(){

    var type = jQuery(this).attr('data-type');
    var button = jQuery(this);
    if(!button.find(':first').hasClass('add-midroll-ad-disabled'))
    {

      $Brid.Api.call({data : {action : "adBox", cnt : currentAdCount, type : type}, callback : {after : {name : "addToAdList", obj : button}}});

    }else{
      debug.warn('Only one midroll per video!');
    }

   });

  function tryToLoadNews(){

    jQuery.ajax({
          url : '<?php echo CLOUDFRONT; ?>WordpressNew/latest/1.json'
      }).done(function(response){

        console.log('response', response);
        var str = '';
        if(response.length>0){

          for(var i in response){
            if(response[i].WordpressNew!=undefined)
              str += '<li class="bridNewsBoxItem"><a href="'+response[i].WordpressNew.link+'" target="_blank">'+response[i].WordpressNew.name+'</a></li>'
          }
        }

        str += '<li class="bridNewsBoxItem learnMore"><a href="https://brid.zendesk.com/hc/en-us" target="_blank">Learn More >>></a></li>';

        jQuery('#bridWpNews').html(str);
        if(response.length>0)
          jQuery('.bridNewsBox').show();
    }).fail(function(){

      jQuery('#bridWpNews').html('<li class="bridNewsBoxItem">Failed to load.</li>')

    });

  }
  tryToLoadNews();
   /**
     * Ad management - Delte ad button 
     */
  function removeAdBox(){

    var iterator = jQuery(this).attr('data-iterator');
    var id = jQuery(this).attr('data-id');
    var adType = jQuery(this).attr('data-type');
    
    if(id!=undefined && id!=''){
      //Edit mode
      $Brid.Api.call({data : {action : "deleteAd", id : id}, callback : {after : {name : "refreshAdList", obj : jQuery('#brid-box-'+iterator)}}});

    }else{
      //Remove Ad in Add mode (never saved in DB)
      jQuery('#brid-box-'+iterator).parent().fadeOut(300, function(){
        jQuery(this).remove(); 
        //save.toggleSave();
      });

      delete(ads[iterator]);

      //if(adType=='midroll'){ //'midroll'
        debug.log('remove midroll');
        jQuery('#add-'+adType+'-ad').removeClass('add-midroll-ad-disabled');//.addClass('add-midroll-ad');
      //}

    }
  
  }
  

    //jQuery(".chzn-select").chosen();

    

    jQuery("#Player").on('click.BridSettings', function(){
        //Do not store config to localstorage
        reloadBridPlayer();
         jQuery(".chzn-select2").chosen();
        //alert('Init Brid_27449775 with:'+playerSelected);
    });

    function reloadBridPlayer(id){

      if(jQuery('#Player-content').is(':visible'))
      {

        killBridPlayer();
        Brid.forceConfigLoad = true;
        var videoId = playerSelected;
        if(id!=undefined)
        {
          videoId = id;
        }
        $bp("Brid_27449775", {"id":videoId,"width":"100%","height":"270","cms":1,"video":"<?php echo DEFAULT_VIDEO_ID; ?>"});
        jQuery('#createCustomSkin').fadeIn();
      }
    }
    function killBridPlayer(){


      jQuery('.bridload[href$=".css"]').remove();//remove all inactive css files (works for Chrome only)
      
      killVeeps();//@see bridWordpress.js
      
      //Remove all classes bridload with style tag name (FF bug only)
      jQuery('.bridload').each(function(k,v){
        if(jQuery(this).prop("tagName")=='STYLE'){
          jQuery(this).remove();
        }
      });
      try{
        //$bp("Brid_27449775").stop();
        $bp("Brid_27449775").destroy();
        jQuery("#bridPlayerPreview").append("<div id='Brid_27449775' class='brid'></div>");
      }catch(e){}
    }

    jQuery("#Settings, #Monetization").on('click.BridSettings', function(){

        killBridPlayer();

    });

    jQuery('#playerSkinSelect').on('change', function(){

      changeSkin();
       
    });

    function changeSkin(){
      
       var skin_id = jQuery('#playerSkinSelect :selected').val(); 
        //reloadBridPlayer(playerSelected+'/'+skin_id);
        $bp('Brid_27449775').changeSkin(skin_id);
    }
    

    function playerChanged(){
        
        //alert('playerChanged');

       var selected = jQuery('#playerListSelect :selected');
        //var json = selected.attr('data-options');
        var obj = selected.data();
        var player = obj.Player;
        var skin = obj.Skin;
        var ad = obj.Ad;
        debug.log('AAAAAAAAAA - PLAYER OBJECT', obj);

        playerSelected = selected.val();

        jQuery('#PlayerId').val(playerSelected);
        
        //If templatized (created by inteligent skin) show inteligent skin msg
        var templatized = parseInt(skin.templatized ? 1 : 0);
        if(templatized){
            jQuery('#skinList').addClass('disabledInput');
            jQuery('#inteligentSkinMsg').fadeIn();
        }else{
            jQuery('#skinList').removeClass('disabledInput');
            jQuery('#inteligentSkinMsg').hide();
        }
        jQuery('#SkinTemplatized').val(templatized);

        reloadBridPlayer();

        debug.log('Ads', ad);

        jQuery('#brid-boxes-content').html('');

        //Unblock all ad buttons
        jQuery('.add-ad').each(function(k,v){

          jQuery(v).children().first().removeClass('add-midroll-ad-disabled');

        });

        //Show ad boxes
        if(ad.length>0){

          currentAdCount = ad.length;

          ads = ad;
          //JS Templating system @see http://handlebarsjs.com/
          jQuery('#adTagMsg').hide();

          console.log('aaaaa', ad);

          var midrollType = null;
          for(var i in ad){
            
             //console.log('yeah', typeof i);

             //when some plugins are installed, for i var it can take string "move", that will brake our JS
            if(typeof i != 'function' && i.length<=2){

              var html = null;
              
              var iterator = currentAdCount;
              

              if(ad[i].adType=="0" || ad[i].adType=="2"){
                //Pre roll and Post roll
                
                var template = Handlebars.compile(jQuery('#pre-roll-template').html());
                var tip = 2;
                if(ad[i].adType==0){
                  tip = null;
                }
                var context = {id : ad[i].id, iterator: iterator,  tip : tip , ad_type_int : ad[i].adType, ad_type: adTypes[ad[i].adType], ad_tag_url : ad[i].adTagUrl};
                html    = template(context);
               
              }else{
               
                //Mid Roll & Overlay
                var template = Handlebars.compile(jQuery('#'+adTypes[ad[i].adType]+'-template').html());
                var tip = ad[i].adType;
                if(ad[i].adType==3){
                  //overlay
                  var context = {id : ad[i].id, iterator:  iterator,  tip : tip ,ad_type_int : ad[i].adType, ad_type: adTypes[ad[i].adType], ad_tag_url : ad[i].adTagUrl, overlayStartAt : ad[i].overlayStartAt, overlayDuration : ad[i].overlayDuration};
                }else{
                  //midroll
                  var context = {id : ad[i].id, iterator:  iterator, tip : tip , ad_type_int : ad[i].adType, ad_type: adTypes[ad[i].adType], ad_tag_url : ad[i].adTagUrl, cuepoints : ad[i].cuepoints};
                  midrollType = ad[i].adTimeType;
                }
                html    = template(context);
              }
              
              jQuery('#add-'+adTypes[ad[i].adType]+'-ad').addClass('add-midroll-ad-disabled');

              if(html){
                 jQuery('#brid-boxes-content').append(html);
              }

              if(midrollType){
                  jQuery("#AdAdTimeType option[value='"+midrollType+"']").prop('selected', true); 
              }

              currentAdCount++;
            }

            //Try to select midroll type
          }

        }

        //Init it by default
        jQuery(".brid-box-remove").off('click', removeAdBox).on('click', removeAdBox);
        if(jQuery('.brid-box-midroll').length > 0){
          
          jQuery('#add-midroll-ad').addClass('add-midroll-ad-disabled');
        }

        if(!player.monetize){

          jQuery('#adSettings').css('display', 'none'); //addClass('disabledInput');

        }else{
          jQuery('#adSettings').css('display', 'block'); //removeClass('disabledInput');
        }

        //debug.log('BBBBB', player, 'Skin', skin,  'playerSelected', playerSelected, 'Skin id:', player.skin_id);

        var selectedSkin = jQuery('#playerSkinSelect :selected').val();

        var currentPlayerSkin = player.skin_id;

        //alert(player.id);

        //Select player
        chosenSelect('playerListSelect',playerSelected);

        //Select current skin of the player
        if(currentPlayerSkin!=selectedSkin){

            //Select Skin
            chosenSelect('playerSkinSelect',currentPlayerSkin);

        }

        

        /*jQuery("#playerSkinSelect option[value='"+player.skin_id+"']").attr('selected', 'selected');

        jQuery("#playerSkinSelect").trigger("liszt:updated");*/
        
        //brid_options wp
         jQuery('#width').val(player.width);
         jQuery('#height').val(player.height);
         jQuery('#autoplay').val(player.autoplay==1 ? 1 : 0);


         jQuery('#PlayerWidth').val(player.width);
         jQuery('#PlayerHeight').val(player.height);


          //Update flash_fallback player options
        var chk = jQuery('#checkbox-PlayerFlashFallback').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'PlayerFlashFallback'});
        if(player.flash_fallback=='1'){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }

         //Update autoplay player options
        var chk = jQuery('#checkbox-PlayerAutoplay').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'PlayerAutoplay'});
        if(player.autoplay){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }

         //Update autoplay player options
        var chk = jQuery('#checkbox-PlayerStartMuted').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'PlayerStartMuted'});

        if(player.start_muted==1){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }
        //VEEPS
        

        var chk = jQuery('#checkbox-voipSocEnabled').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'voipSocEnabled'});
        if(player.voipSocEnabled==1){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }
        
        var chk = jQuery('#checkbox-veepsChat').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'veepsChat'});
        if(player.veepsChat==1){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }

        var chk = jQuery('#checkbox-veepsInit').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'veepsInit'});
        if(player.veepsInit==1){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }


        var chk = jQuery('#checkbox-veepsType').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'veepsType'});
        if(player.veepsType==1){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }
        

        checkbox.toggleVeepsChatNextToPlayer(chk);

        var chk = jQuery('#checkbox-voipSocEnabled').find('input');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'voipSocEnabled'});
        if(player.voipSocEnabled==1){
          checkbox.select(chk);
        }else{
          checkbox.deselect(chk);
        }

        checkbox.toggleVoipSocialOptions(chk);


         var chk = jQuery('#PlayerAspect');
        var checkbox = $Brid.Html.CheckboxElement.create({name : 'PlayerAspect'});
        checkbox.togglePlayerSize(chk);

        //Call change skin to protect against cached skin
        //changeSkin();
        
        jQuery("#playerListSelect").on("change", function(){

            playerChanged();
        });

    }

    function chosenSelect(id, optionValue){
      
       jQuery("#"+id+" option[value='"+optionValue+"']").prop('selected', true); //.end().trigger("liszt:updated");
            
            var skinName = jQuery('#'+id+' :selected').text();

            var items = jQuery('#'+id+'_chzn').find('.active-result');

            items.removeClass('result-selected');

            items.each(function(k,v){

              if(jQuery(this).text()==skinName){

                //alert(jQuery(this).text()+'='+skinName)
                jQuery(this).addClass('result-selected');

                jQuery('#'+id+'_chzn').find('.chzn-single').find('span').html(skinName);
                return false;
              }

            });
    }
    //first init
    //playerChanged();

    jQuery("#sites").on("change", function(){
     
        //$Brid.Api.call({action : "brid_api_get_players", "id" : jQuery(this).val(), "callback" : "bridPlayerList"});
        var v = jQuery(this).val();
        jQuery('#PartnerId').val(v)
        /*$Brid.Api.call({
                    dataType : 'json',
                    data : {action : "getPartnerAndPlayersWithDefaultPlayer", "id" : v}, 
                    callback : { after : { name : "bridPlayerList"} }
                  });*/

        loadBridPlayers(v);
     
    });

    function loadBridPlayers(partnerId){

      $Brid.Api.call({
                    dataType : 'json',
                    data : {action : "getPartnerAndPlayersWithDefaultPlayer", "id" :  partnerId}, 
                    callback : { after : { name : "bridPlayerList"} }
                  });

    }

    loadBridPlayers(jQuery('#PartnerId').val());

    //Load first time

    jQuery("#IntroVideo").input(function(){
    var IntroUrl = jQuery("#IntroVideo").val();
    if(IntroUrl!=undefined && IntroUrl!='' && IntroUrl.length>0){

      var errDiv = jQuery(this).parent().find('.errorMsg');

      if(!$Brid.Util.isUrl(IntroUrl)){
        var errMsg = '*Video Url must be valid URL format.'.toUpperCase();
        
        //$Brid.Util.openDialog('Video Url must be valid URL format.','Invalid input');
        if(errDiv.length==0){
          jQuery(this).parent().addClass('inputError');
          jQuery(this).parent().append('<div class="errorMsg">'+errMsg+'</div>');
        }else{
          errDiv.html(errMsg);
        }
      } 
      else if(!$Brid.Util.checkExtension(IntroUrl, ["mp4"])){
        //$Brid.Util.openDialog('NOT A VALID VIDEO FORMAT ('+$Brid.Video.allowedVideoExtensions.join(',').toUpperCase()+').', 'Invalid input');
        var errMsg = '*NOT A VALID VIDEO FORMAT ('+["mp4"].join(',').toUpperCase()+' ONLY)';
        
        if(errDiv.length==0){
          jQuery(this).parent().addClass('inputError');
          jQuery(this).parent().append('<div class="errorMsg">'+errMsg+'</div>');
        }else{
          errDiv.html(errMsg);
        }
        jQuery(this).val('')
      }else{
        jQuery(this).parent().removeClass('inputError');
        jQuery(this).parent().find('.errorMsg').remove();
      }
    }
  });

    jQuery('.bridBrowseLibary').on('click', function(){
         // If the media frame already exists, reopen it.
          if ( file_frame ) {
            file_frame.open();
            return;
          }

          var field = jQuery('#IntroVideo');

          // Create the media frame.
          file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery( this ).data( 'uploader_title' ),
            button: {
              text: jQuery( this ).data( 'uploader_button_text' ),
            },
            multiple: false  // Set to true to allow multiple files to be selected
          });

          // When an image is selected, run a callback.
          file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();

            if($Brid.Util.checkExtension(attachment.url, $Brid.Util.allowedIntroUrlExtensions)){

                field.val(attachment.url);

                field.parent().find('.errorMsg').remove();
                field.parent().removeClass('inputError');

            }else{
                  alert('Invalid url extension. Video extension required:'+$Brid.Util.allowedIntroUrlExtensions.join(','));
            }
           

          });

          // Finally, open the modal
          file_frame.open();
    });

    //Pre load tab from anchor
    var l = document.location.toString();

    if(l.indexOf('Monetization')!=-1){
      jQuery('#Monetization').trigger('click');
    }
    if(l.indexOf('Player')!=-1){
      jQuery('#Player').trigger('click');
    }

    jQuery('.monetizeTabPage').click(function(e){

      e.preventDefault();
      jQuery('#Monetization').trigger('click');
    });

    <?php if( isset($_GET['code'])) { ?>

      var siteNum = jQuery('#sites option').size();
      var playerNum = jQuery('#playerListSelect option').size();

      debug.log('Site', siteNum, playerNum);

      if(siteNum==1){ //&& playerNum==1

        //playerChanged();

        setTimeout(function() { jQuery('#bridSettingsForm').submit(); }, 800);

      }

    <?php } ?>
</script>