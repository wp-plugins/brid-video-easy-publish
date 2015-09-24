<div class="mainWrapper" style='padding-top:10px;'>
	<div class="backBubble" style="margin-bottom:0px;">
				<a href="<?php echo admin_url( 'admin.php?page=brid-video-menu');?>">« VIDEOS</a>
				
		ADD VIDEO	
	</div>
<div class="videos form">
 <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">
 	<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>    
 	<table class="form-table" style="display:block">
	 <tbody><tr>
		<td style="width:858px">
			<div class="formWrapper videoAddFormWrapper" style="margin-top:0px">

				<div id="mainAdd">
					<input type="hidden" name="action" value="addVideo">
					<input type="hidden" name="insert_via" value="2">
					<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
					<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
					<input type="hidden" name="id" id="VideoId">
					<input type="hidden" name="upload_form" value="0" id="VideoUploadForm">
					
					<input type="hidden" name="default_tab" value="" id="VideoDefaultTab">
					<input type="hidden" name="external_id" id="VideoExternalId">
					<input type="hidden" name="encoding_setup_finished" id="VideoEncodingSetupFinished">
					<input type="hidden" name="width" id="VideoWidth">
					<input type="hidden" name="height" id="VideoHeight">
					<input type="hidden" name="size" id="VideoSize">
					<input type="hidden" name="video_codec" id="VideoVideoCodec">
					<input type="hidden" name="video_bitrate" id="VideoVideoBitrate">
					<input type="hidden" name="external_service" id="VideoExternalService">
					<input type="hidden" name="external_type" id="VideoExternalType">
					<input type="hidden" name="IsFamilyFriendly" id="VideoIsFamilyFriendly">
					<input type="hidden" name="duration" id="VideoDuration">
					<input type="hidden" name="autosave" id="VideoAutosave" value="0">
					<input type="hidden" name="external_url" default-value="External URL" data-info="External URL" id="VideoExternalUrl">					    <!-- Youtube/Vimeo Form -->
									    						 
					<!-- MAIN FORM -->
										    
					<div class="mainDataAdd" id="mainData" style="">
						<table style="border-spacing: 0px;">
							<tbody>
								<tr>
									<td style="width:576px; padding-top: 10px;">
										<div class="input text required">
											<label for="VideoName">Video title</label>
											<input name="name" default-value="Video title" data-info="Video title" tabindex="1" maxlength="250" type="text" id="VideoName" required="required">
										</div>										
									</td>
									<td style="padding:0px; padding-top: 10px; vertical-align:top; padding-left: 10px;">
										<div style="float:right; position:relative;">
											<div class="input text">
												<label for="VideoName">Publish on a date</label>
												<input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" data-info="Publish on a date." type="text" id="VideoPublish">
											</div>										
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="input textarea">
											<label for="VideoName">Video description</label>
											<textarea name="description" default-value="Video description" style="height:100px;" data-info="Video description" tabindex="2" cols="30" rows="6" id="VideoDescription" data-ajax-loaded="true"></textarea>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="input select required" tabindex="3" style="max-width:150px">
											<select name="channel_id" class="dropdownMenu dropdown" data-css='{"height":230, "width":150}' id="VideoChannelId" required="required" data-callback-after="addVideoChannelChanged" style="display: none;">
														<option value="0">Select category</option>
														<?php foreach($channels as $k=>$v){
															$selected = '';
															
															?>
																<option value="<?php echo $v->Channel->id; ?>" <?php echo $selected; ?>><?php echo $v->Channel->name; ?></option>
															<?php
														}?>
											</select>
										</div>									
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="input text">
												<label for="VideoName">Tags</label>
												<input name="tags" default-value="Tags" tabindex="4" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." type="text" id="VideoTags">
											</div>											
									</td>
								</tr>
								
								<tr>
									<td colspan="2">
										<table>
											<tr>
												<td>
													<input type="hidden" name="thumbnail" id="VideoThumbnail">
													<div class="input text">
														<label for="VideoName">Snapshot Url</label>
														<input name="image" default-value="Snapshot URL" data-info="Provide URL to the snapshot image" tabindex="5" maxlength="300" type="text" id="VideoImage">
													</div>
												</td>
												<td style="width:110px">
													<div class="bridBrowseLibary" style="margin-top:25px;" data-field="VideoImage" data-uploader_button_text="Add Snapshot" data-uploader_title="Browse from Media Library">BROWSE LIBRARY</div>
												</td>
											</tr>
										</table>
										
										
									</td>
								</tr>

								<tr>
									<td colspan="2">

										<table>
											<tr>
												<td>
													<div class="input text required">
														<label for="VideoName">Mp4 or Webm Url</label>
														<input name="mp4" default-value="MP4 or WEBM URL" data-info="Add MP4, WEBM or streaming video file URL" tabindex="6" maxlength="300" type="text" id="VideoMp4" required="required" data-ajax-loaded="true">
													</div>	
												</td>
												<td style="width:110px">
													<div class="bridBrowseLibary" style="margin-top:25px;" data-field="VideoMp4" data-uploader_button_text="Add Video" uploader_title="Browse from Media Library">BROWSE LIBRARY</div>
												</td>
											</tr>
										</table>
									</td>
								</tr>
												
								<tr>
									<td colspan="2">

										<div id="checkbox-mp4_hd_on" class="bridCheckbox disabledCheckbox" data-method="toggleVideoField" data-name="mp4_hd_on" style="top:4px;left:1px;">
											<div class="checkboxContent">
												<img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:none" alt="">
												<input type="hidden" name="mp4_hd_on" class="singleCheckbox" id="mp4_hd_on" data-value="0" style="display:none;">
											</div>
											<div class="checkboxText">Add HD Version</div>
										</div>
										

									
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table>
											<tr>
												<td>
													<div class="input text invisibleDiv">
														<input name="mp4_hd" default-value="MP4 or WEBM HD URL" data-info="MP4 High Definition URL Source" maxlength="300" type="text" id="VideoMp4Hd">
													</div>	
												</td>
												<td style="width:110px">
													<div class="bridBrowseLibary invisibleDiv" style="margin-top:0px;" data-field="VideoMp4Hd" data-uploader_button_text="Add HD Video" data-uploader_title="Browse for MP4 High Definition URL Source">BROWSE LIBRARY</div>								
												</td>
											</tr>
										</table>
																			
									</td>
								</tr>
								
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
				    								<li id="age_gate_id-1" data-value="1" class="selected_selectbox selectbox"><span class="optionText">Everyone</span></li>
				    								<li id="age_gate_id-2" data-value="2" class="selectbox"><span class="optionText">17+ (ESRB - Mature rated)</span></li>
				    								<li id="age_gate_id-3" data-value="3" class="selectbox"><span class="optionText">18+ (ESRB - Adults only)</span></li>
				    							</ul>
			    							</div>
			    							<input type="hidden" name="age_gate_id" class="singleOption" value="1" id="age_gate_id">
			    						</div>			    					
			    					</td>
			    				</tr>
							</tbody>
						</table>
				            		      

						<div class="bridButton saveButton disabled" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0" style="margin-bottom:0px; margin-top:15px;">
							<div class="buttonLargeContent">SAVE</div>
						</div>
						<div id='autoSaving'>Autosaving<span class="fDot">.</span><span class="sDot">.</span><span class="tDot">.</span></div>
					</div>
				</div>

				
			</div>
			
			
		</td>
	</tr>
</tbody></table>			
</form>	

</div>
<?php if(!$upload) {
	?>
	<div style="clear:both;"></div>
	<div style="border-top:1px solid #BCC3C3;margin-top:15px;padding-top:2px;">
		<div style="margin-left:12px;font-weight:normal;text-decoration:underline;cursor:pointer;text-weight:bold;" id="addVideoQuestion" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>">Want us to host and encode videos for you? Upgrade to premium plan for free.</div>
		<script>jQuery('#addVideoQuestion').colorbox({innerWidth:920, innerHeight:650});</script>
	</div>
	<?php 
}
?>
</div>
<script>
var allowedImageExtensions = ["jpg","jpeg","png","gif"];
var amIEncoded = 0; //force 0
var typingTimer;                					//timer identifier
var doneTypingInterval = 600;  						//time in ms, 5 second for example
var defaultTab = 'video';
var currentView = 'add-video';						//This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

var clickedAddButton;								//Stores ADD button object we clicked
var selectBoxTitle = 'Select category <img class="arrowDownJs" src="<?php echo BRID_PLUGIN_URL; ?>/img/arrow_down.png" width="8" height="4" alt="Click to open submenu" />';

//JS Templating system @see http://handlebarsjs.com/
//var template = Handlebars.compile(jQuery('#oneRowTempalte').html());
//Init save object
var save = saveObj.init();

//initBridMain();

	 /**
	  * Save button on click
	  */
	  jQuery("#videoSaveAdd").click(function(e){

		
	 	 if(!jQuery(this).hasClass('disabled') && !jQuery("#videoSaveAdd").hasClass('inprogress')){

	 		jQuery("#videoSaveAdd").addClass('inprogress');
	 		 save.save('VideoAddForm');
	 	 }else{
			//Is save in progress?
	 		if(jQuery("#videoSaveAdd").hasClass('inprogress'))
	 		{
	 			$Brid.Util.openDialog('Save error', 'Save already in progress');
		 		
	 		}
	 		//CheckFields (true) will display openDialog message
	 		if(checkFields(true)){
	 		
		 		save.openRequiredDialog('VideoAddForm','<b>Please check following:</b><br/><br/> 1.) Are required fields empty?<br/> 2.) Are fields values in valid format?', 'Save is disabled');
	 			console.error('[Error from custom video save function] Save is disabled. Check mandatory fileds.');
	 			jQuery('.saveButton').addClass('disabled');
	 		}
	 		
	 	 }
	         
	 });
	//Call Enable save button function on change
	jQuery('#VideoName, #VideoImage').input(function(){
		checkFields();
		enableSave();
	});
	//Grab additional info and check codec of the provided Mp4 Url (on success call enableSave();)
	jQuery("#VideoMp4").input(function(){
		checkFields();
		getFfmpegInfo();
	});
	jQuery('#ChannelIdUpload').change(function(){enableSave();});


	jQuery('#fetchUrl').keyup(function(e) {
        if(e.which == 13) {      
        	$Brid.Fetch.fetchUrl();
        }
     });

    jQuery('.fetchDivWrapper .input').prepend('<span class="fetchDivHSpan">http://</span>');

    jQuery("#fetchUrl").bind('paste', function(event) {
        var _this = this;
        // Short pause to wait for paste to complete
        setTimeout( function() {
            var url = jQuery(_this).val();

			url = url.replace(/(https?:\/\/)/, '');
			jQuery(_this).val(url);	
			if(url.match(/^(rtmp:\/\/)/)){
				jQuery('.fetchDivHSpan').hide();
			}
        }, 100);
    });

    jQuery('#goFetchUrl').click(function(){
    		$Brid.Fetch.fetchUrl();
        });
    jQuery('#fetchUrl').on('input',$Brid.Fetch.checkFetchUrl);
    //if(amIEncoded){
	//	jQuery('#VideoName , #VideoDescription, #VideoTags, #VideoLandingPage').input($Brid.Video.checkAutosaveMessage);
	//}


	var browse = jQuery('.bridBrowseLibary');

	if(browse.length>0){


		browse.on('click', function(){
				//http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
				 // If the media frame already exists, reopen it.
			    /*if ( file_frame ) {
			      file_frame.open();
			      return;
			    }*/

			     var fieldName = jQuery(this).attr("data-field");
			     var field = jQuery('#'+fieldName);
			     var title = jQuery('#VideoName');
			     var desc = jQuery('#VideoDescription');
			     var tags = jQuery('#VideoTags');


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


			     // console.log('attachment', attachment);

			     field.val(attachment.url);
			      jQuery('#checkbox-mp4_hd_on').removeClass('disabledCheckbox');

			     jQuery('#default-value-'+fieldName).hide();

			     if(title.val()==''){
			     	title.val(attachment.title);
			     	desc.val(attachment.title);
			     	jQuery('#default-value-VideoName').hide();
			     	jQuery('#default-value-VideoDescription').hide();
			     }

			     if(tags.val()==''){
			     	var str = attachment.title;
					str = str.replace(/[^a-zA-Z-_, ]/g, "");
					str = str.replace(/[^a-zA-Z-_,]/g, ",") //replace space with comma
					str = str.replace(/[^a-zA-Z-,]/g, ",") //replace underscore with comma
					str = str.replace(/[^a-zA-Z,]/g, ",") //replace dash with comma
			     	tags.val(str);
			     	jQuery('#default-value-VideoTags').hide();
			     	
			     }

			     enableSave();

			      // Do something with attachment.id and/or attachment.url here
			      //alert(attachment.url);
			    });

			    // Finally, open the modal
			    file_frame.open();
		});


	}
	initBridMain();
</script>