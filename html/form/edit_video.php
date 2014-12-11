<div class="videos formVideo">
	<?php //print_r($video->Ad); die(); ?>
	<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoEditForm" method="post" accept-charset="utf-8"><div style="display:none;">
		<input type="hidden" name="_method" value="PUT"></div>
		<input type="hidden" name="action" value="editVideo">
		<input type="hidden" name="id" value="<?php echo $video->Video->id; ?>" id="VideoId">
		<input type="hidden" name="insert_via" value="<?php echo $video->Video->insert_via; ?>" id="VideoInsertVia">
		<input type="hidden" name="partner_id" value="<?php echo $video->Video->partner_id; ?>" id="VideoPartnerId">
		<input type="hidden" name="width" value="<?php echo $video->Video->width; ?>" id="VideoWidth">
		<input type="hidden" name="height" value="<?php echo $video->Video->height; ?>" id="VideoHeight">
		<input type="hidden" name="size" value="<?php echo $video->Video->size; ?>" id="VideoSize">
		<input type="hidden" name="video_codec" value="<?php echo $video->Video->video_codec; ?>" id="VideoVideoCodec">
		<input type="hidden" name="video_bitrate" value="<?php echo $video->Video->video_bitrate; ?>" id="VideoVideoBitrate">
		<input type="hidden" name="duration" value="<?php echo $video->Video->duration; ?>" id="VideoDuration">

		<?php if($video->Video->external_type==0){?>
			<!-- Tabs start -->
			<div style="width:858px; padding-top:2px; /*overflow:hidden;*/" class="tabs tabsRed withArrow">
				<div id="VideoDetails" class="tab" style="width: 428px;border-right:2px solid #fff;">VIDEO DETAILS<div class="arrowDown"></div></div>
				<div id="Monetization" class="tab-inactive" style="border-left:2px solid #fff;margin-right: 0px; width: 428px;">MONETIZATION<div class="arrowDown" style="left:73.5%"></div></div>
			</div>
			<!-- Tabs end -->
		<?php } ?>
		 <!-- Video Details Tab -->
   		<div id="VideoDetails-content" class="tab-content" style="display:block;">	
			<div class="mainDataAdd" id="mainData">
			    <table>
			    	<tbody><tr>
			    		<td colspan="2">
			    			<div class="input text required">
			    				<label for="VideoName">Video title</label>
			    				<input name="name" default-value="Video title" data-info="Video title" maxlength="250" type="text" value="<?php echo $video->Video->name; ?>" id="VideoName" required="required">
			    			</div>			    		
			    		</td>
			    	</tr>
			    	<tr>
			    		<td colspan="2">
			    			<table>
			    				<tbody><tr>
			    					<td style="width:615px;padding-top:0px">
										<div class="input textarea"><label for="VideoDescription">Video description</label>
											<textarea name="description" default-value="Video description" style="width:595px; height:100px;" data-info="Video description" cols="30" rows="6" id="VideoDescription" data-ajax-loaded="true" aria-describedby="ui-tooltip-1"><?php echo $video->Video->description; ?></textarea>
										</div>									
									</td>
									<td style="padding:0px; padding-left:10px;">
										<div style="float:left; position:relative; top:-6px;">
											<table style="width:100%">
												<tbody><tr>
													<td style="padding:0px;">
														<div class="input text">
															<label for="VideoPublish">Publish on a date</label>
															<input name="publish" readonly="readonly" default-value="<?php echo $video->Video->publish; ?>" class="datepicker inputField" data-info="Publish on a date." style="width:225px" type="text" value="<?php echo $video->Video->publish; ?>" id="VideoPublish">
														</div>													
													</td>
												</tr>
												<tr>
													<td style="padding-top:15px">
														<div class="input select required">
															<select name="channel_id" class="dropdownMenu dropdown" data-css='{"height":230, "width":150}' id="VideoChannelId" required="required" style="display: none;">
															
															<?php foreach($channels as $k=>$v){
																$selected = '';
																if($v->Channel->id == $video->Video->channel_id){
																	$selected = 'selected="selected"';
																}
																?>
																	<option value="<?php echo $v->Channel->id; ?>" <?php echo $selected; ?>><?php echo $v->Channel->name; ?></option>
																<?php
															}?>
															</select>
															
													</div>					        		
													</td>
												</tr>
											</tbody></table>
										</div>
									</td>
								</tr>
							</tbody></table>
						</td>
			    	</tr>
			    	<tr>
			    		<td colspan="2">
			    			<div class="input text divFloat"><label for="VideoTags">Tags</label>

			    				<input name="tags" default-value="Tags" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." type="text" value="<?php echo $video->Video->tags; ?>" id="VideoTags">
			    					
			    		</td>
			    	</tr>
			    	<?php if(!$amIEncoded){?>
				    	<?php if($video->Video->external_type!=1){?>
				    	<tr>
				    		<td colspan="2">
				    		
				    			<div class="input text required">
				    				<label for="VideoMp4">MP4</label>
				    				<input name="mp4" default-value="MP4 or WEBM" data-info="MP4 URL Source" maxlength="300" type="text" value="<?php echo $video->Video->mp4; ?>" id="VideoMp4" required="required"></div>			    		
				    		</td>
				    	</tr>
				    	<?php } else {
				    		?>
				    		<tr>
					    		<td colspan="2">
					    		
					    			<div class="input text required">
					    				<label for="VideoMp4">YouTube Url</label>
					    				<input name="external_url" default-value="Youtube Url" data-info="Youtube Url" maxlength="300" type="text" value="<?php echo $video->Video->external_url; ?>" id="VideoExternalUrl" required="required"></div>			    		
					    		</td>
					    	</tr>

				    		<?php
				    	}
				    	
				    	if($video->Video->external_type!=1){?>
				    	<tr>
				    		<td colspan="2" style="padding-top:15px;">
				    			<div id="checkbox-mp4_hd_on" class="checkbox" data-method="toggleVideoField" data-name="mp4_hd_on" style="top:4px;left:0px;">
				    				<div class="checkboxContent">
				    					<?php 
				    						$hdStyle = ($video->Video->mp4_hd_on) ? 'block' : 'none'; 
				    						$hdClass = ($video->Video->mp4_hd_on) ? 'checked' : ''; 

				    					?>
				    					<img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:<?php echo $hdStyle; ?>" alt="">
				    					
				    					<input type="hidden" name="mp4_hd_on" class="singleCheckbox <?php echo $hdClass; ?>" id="mp4_hd_on" data-value="0" value="<?php echo $video->Video->mp4_hd_on; ?>" style="display:none;">
				    				</div>
				    				<div class="checkboxText">Add HD Version</div>
				    			</div>
							</td>
				    	</tr>
				    	<?php } ?> 
				    	<tr>
				    		<td colspan="2">
				    			<div class="input text invisibleDiv" id="hd_version" style="display: <?php echo $hdStyle; ?>">
				    				<input name="mp4_hd" default-value="MP4 or WEBM HD URL" data-info="MP4 High Definition URL Source" maxlength="300" type="text" value="<?php echo $video->Video->mp4_hd; ?>" id="VideoMp4Hd">
				    			</div>						
				    		</td>
				    	</tr>
			    	<?php } ?>
			    	<tr>
			    		<td style="vertical-align: top; width:296px; padding-top:14px;">
			    			<!-- Preview player -->
							<div id="preview-player" style="">
								<!--  <iframe id="<?php echo $video->Video->id; ?>-<?php echo $video->Video->partner_id; ?>-1-0-1" src="<?php echo CDN_HTTP; ?>services/iframe/video/<?php echo $video->Video->id; ?>/<?php echo $video->Video->partner_id; ?>/1/0/1" width="276" height="166" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>-->
								<script type="text/javascript" src='<?php echo CLOUDFRONT."player/build/brid.min.js"; ?>'></script>
								<div id="Brid_video" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><div id="Brid_video_adContainer"></div></div>
								<script type="text/javascript">$bp("Brid_video", {id:'<?php echo DEFAULT_PLAYER_ID; ?>',video:'<?php echo $video->Video->id; ?>',width:'276', height:'166'});</script>
								<script type="text/javascript" src="http://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
								
							</div>						
			    		</td>
			    		<td style="vertical-align:top">
			    			<table>
				    				<tbody>
				    				<?php if($video->Video->external_type!=1){?>
				    				<tr>
				    					<td style="padding:0px; padding-bottom:10px;">
					    					<input type="hidden" name="thumbnail" value="<?php echo $video->Video->thumbnail; ?>" id="VideoThumbnail">			    					
					    					<input type="hidden" name="image_old" value="" id="VideoImageOld">			    					
					    					<div class="input text">
					    						<label for="VideoImage">Snapshot Url</label>
					    						<input name="image" default-value="Snapshot Url" data-info="Provide URL to the snapshot image" maxlength="100" type="text" value="<?php echo $video->Video->image; ?>" id="VideoImage" data-ajax-loaded="true">
					    					</div>			    					
				    					</td>
				    				</tr>
				    				<?php } ?>

				    				<tr>
				    					<td id="ageRestriction">
				    						<div class="selectboxes">
					    						<div class="selectBoxTitle">Age restriction</div>
					    						<div class="selectBoxContent">
					    							<div class="selectBoxActive">Everyone</div>
					    							<div class="selectBoxActiveImgDiv">
					    								<img src="<?php echo BRID_PLUGIN_URL; ?>img/arrow_down_wide.png" class="selectBoxActiveImg" style="width:13px;height:6px" alt="">
					    							</div>
					    							<ul class="ul-selectbox">
					    								<li id="age_gate_id-1" data-value="1" class="<?php echo ($video->Video->landing_page==1) ? 'selected_selectbox' : ''; ?> selectbox"><span class="optionText">Everyone</span></li>
					    								<li id="age_gate_id-2" data-value="2" class="<?php echo ($video->Video->landing_page==2) ? 'selected_selectbox' : ''; ?>selectbox"><span class="optionText">17+ (ESRB - Mature rated)</span></li>
					    								<li id="age_gate_id-3" data-value="3" class="<?php echo ($video->Video->landing_page==3) ? 'selected_selectbox' : ''; ?>selectbox"><span class="optionText">18+ (ESRB - Adults only)</span></li>
					    							</ul>
				    							</div>
				    							<input type="hidden" name="age_gate_id" class="singleOption" value="1" id="age_gate_id">
				    						</div>			    					
				    					</td>
				    				</tr>
				    				
				    			</tbody>
				    		</table>
			    		</td>
			    	</tr>
			    	
			    </tbody></table>

			   
			</div>
		</div>
		<?php if($video->Video->external_type==0){?>
			<!--  Video Monetization Tab (samo admin????????????) -->
	    	<div id="Monetization-content" class="tab-content">
	    		
	    		<table class="form-table">
							  		<tbody><tr>
							  			<td>
							  				<div class="formWrapper" style="margin-bottom:20px">
							  					<div id="checkbox-monetize" class="checkbox" data-method="toggleAdSettings" data-name="monetize" style="top:4px;">
							  						<?php
							  								$c = '';
							  								if($video->Video->monetize){
							  									$c = 'checked';
							  								}

							  								$show = ($c=='') ? 'none' : 'block';
							  							?>
							  						<div class="checkboxContent">
							  							<img src="<?php echo BRID_PLUGIN_URL; ?>/img/checked.png" class="checked" style="display:<?php echo $show; ?>" alt="">
							  							
							  							<input type="hidden" name="monetize" value="<?php echo $video->Video->monetize; ?>" class="singleCheckbox <?php echo $c; ?>" id="monetize" data-value="<?php echo $video->Video->monetize; ?>" style="display:none;" checked="checked" data-display="block">
							  						</div>
							  						<div class="checkboxText">Monetizable</div>
							  					</div>
											</div>
											
																	  			
							  		  		<div class="formWrapper monetizationOptions" style="display:<?php echo $show; ?>;" id="adSettings">
												<div class="add-ad" data-type="preroll">
													
													

											<div class="button add-preroll-ad" id="add-preroll-ad" style="opacity: 1;">
												<div class="buttonLargeContent">ADD PRE-ROLL</div></div>

																						
																						</div>
																						<div class="add-ad" id="add-ad-midroll" data-type="midroll">
																						

											<div class="button add-midroll-ad" id="add-midroll-ad" style="opacity: 1;">
												<div class="buttonLargeContent">ADD MID-ROLL / SET CUE POINTS</div></div>

																						</div>
																						<div class="add-ad" data-type="overlay">
																							

											<div class="button add-overlay-ad" id="add-overlay-ad">
												<div class="buttonLargeContent">ADD OVERLAY</div></div>

																						</div>
																						<div class="add-ad" data-type="postroll">
																							

											<div class="button add-postroll-ad" id="add-postroll-ad">
												<div class="buttonLargeContent">POSTROLL</div>
											</div>

												</div>
												<!-- Content div for ads -->
												<!-- Content div for ads -->
												<div style="float:left; width:100%;margin-top:22px" id="ad-content">
													<?php 
												  		//$ads = $this->Html->value('Ad');
												  		if(!empty($ads)){
												  			
												  			foreach($ads as $k=>$v){
												  				
												  				BridHtml::adBox($k, $v);
												  				
												  			}
												  			
												  			
												  		}?>
												</div>
											</div>
										</td>
							  		</tr>
							  	</tbody></table>
	    	</div>
	    	<!-- Monetization end -->
	    <?php } ?>
    	 <div class="button saveButton save-video lightboxSave" id="videoSaveEdit" data-form-id="VideoEditForm" data-form-bind="0" data-form-req="0" style="margin-top:30px;margin-left:10px;">
				<div class="buttonLargeContent">SAVE</div></div>
		<?php //if($video->Video->external_type!=1){?>
		

		<?php //} else {
			?>
			
			<?php
		//}?>
		<div class="propagate"><div>Please allow up to 10 minutes for changes to propagate.</div></div>
	</form>
</div>

<script>
var amIYoutube = <?php if(isset($video->Video->external_type) && $video->Video->external_type) echo $video->Video->external_type; else echo 0; ?>;
var allowedImageExtensions = ["jpg","jpeg","png","gif"];
var amIEncoded = <?php echo $amIEncoded; ?>;
var typingTimer;                					//timer identifier
var doneTypingInterval = 600;  						//time in ms, 5 second for example
var defaultTab = 'video';
var currentView = 'add-video';						//This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

var clickedAddButton;								//Stores ADD button object we clicked
var selectBoxTitle = 'Select category <img class="arrowDownJs" src="<?php echo BRID_PLUGIN_URL; ?>/img/arrow_down.png" width="8" height="4" alt="Click to open submenu" />';

var currentAdCount = <?php echo (empty($ads)) ? 0 : count($ads)?>;

var ads = <?php echo (empty($ads)) ? json_encode(array()) : json_encode($ads);?>;

//JS Templating system @see http://handlebarsjs.com/
//var template = Handlebars.compile(jQuery('#oneRowTempalte').html());
//Init save object
var save = saveObj.init();
initBridMain();
$Brid.init(['Html.Tabs']);

jQuery('input[id$="OverlayStartAt"], input[id$="OverlayDuration"]').off('keypress').on('keypress', $Brid.Util.onlyNumbers);
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
	 /**
	   * Ad management - Delte ad button 
	   */
	function removeAdBox(){

		var iterator = jQuery(this).attr('data-iterator');
		var id = jQuery(this).attr('data-id');
		var adType = jQuery(this).attr('data-type');
		
		if(id!=undefined && id!=''){
			//Edit mode
			$Brid.Api.call({data : {action : "deleteAd", id : id}, callback : {after : {name : "refreshAdList", obj : jQuery('#ad-box-'+iterator)}}});

		}else{
			//Remove Ad in Add mode (never saved in DB)
			jQuery('#ad-box-'+iterator).closest('.ad-box-container').fadeOut(300, function(){jQuery(this).remove(); save.toggleSave();});

			delete(ads[iterator]);

			if(adType=='midroll'){ //'midroll'
				debug.log('remove midroll');
				jQuery('#add-midroll-ad').removeClass('add-midroll-ad-disabled').addClass('add-midroll-ad');
			}

		}
	
	}
	//Init it by default
	jQuery(".ad-box-remove").off('click', removeAdBox).on('click', removeAdBox);
	if(jQuery('.ad-box-midroll').length > 0){
		
		jQuery('#add-midroll-ad').addClass('add-midroll-ad-disabled');
	}

	 /**
	  * Save button on click
	  */
	  jQuery("#videoSaveEdit").click(function(e){

		
	 	 if(!jQuery(this).hasClass('disabled') && !jQuery("#videoSaveEdit").hasClass('inprogress')){

	 		jQuery("#videoSaveEdit").addClass('inprogress');
	 		 save.save('VideoEditForm');
	 	 }else{
			//Is save in progress?
	 		if(jQuery("#videoSaveEdit").hasClass('inprogress'))
	 		{
	 			$Brid.Util.openDialog('Save error', 'Save already in progress');
		 		
	 		}
	 		//CheckFields (true) will display openDialog message
	 		if(checkFields(true)){
	 		
		 		save.openRequiredDialog('VideoEditForm','<b>Please check following:</b><br/><br/> 1.) Are required fields empty?<br/> 2.) Are fields values in valid format?', 'Save is disabled');
	 			console.error('[Error from custom video save function] Save is disabled. Check mandatory fileds.');
	 			jQuery('.saveButton').addClass('disabled');
	 		}
	 		
	 	 }
	         
	 });
	if(!amIYoutube){ 
		//Call Enable save button function on change
		jQuery('#VideoName, #VideoImage, #VideoMp4Hd').input(function(){
			enableSave(); //@see bridWordpress.js line 3648
		});
		//Grab additional info and check codec of the provided Mp4 Url (on success call enableSave();)
		jQuery("#VideoMp4").input(function(){
			getFfmpegInfo();
		});
	}
	jQuery('#ChannelIdUpload').change(function(){enableSave();});

</script>
