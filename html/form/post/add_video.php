<div class="mainWrapper" style='padding-top:0px;width:auto;position: absolute; left: 0px; top: 0px; bottom: 0px; right: 0px;'>
<?php 
$hideUploadFields = 'block';
?>
<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">
	<div class="videos form" style="position:absolute; width:auto; left:0px; right:300px">

 	<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>    
 	<table class="form-table" style="display:<?php echo $hideUploadFields; ?>">
	 <tbody><tr>
		<td>
			<div class="formWrapper videoAddFormWrapper" style="width:100%; margin:0px;">

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
										    
					<div class="mainDataAdd" id="mainData" style="width:auto">
						<table style="border-spacing: 0px;">
							<tbody>
								<!-- Mp4 Version -->
								<tr>
									<td colspan="2">

										 <table style="float:left;width:100%;padding-left:0px;margin-top:0px;">
						                   <tr>
						                     <td>
						                        <div class="input text required">
													<label class="setting" data-setting="title">
														<span>Add MP4, WEBM video file URL</span>
														
															<input name="mp4" placeholder="Mp4 or webm URL" maxlength="300" type="text" id="VideoMp4" required="required" data-ajax-loaded="true">
														
													</label>
												</div>
						                      </td>
						                    
						                     <td style="width:115px;vertical-align:top;">

						                        <div class="bridBrowseLibary" style="margin-top:30px" data-field="VideoMp4" data-uploader_button_text="Add Video" data-uploader_title="Browse for MP4, WEBM video file URL">BROWSE LIBRARY</div>
						                      </td>
						                    </tr>
						                  </table>
											
										
										<table class="hdVideoTable">
											<tr>
												<td>
													<div id="checkbox-mp4_hd_on" class="bridCheckbox disabledCheckbox" data-method="toggleVideoField" data-name="mp4_hd_on" style="top:4px;left:1px;">
														<div class="checkboxContent">
															<img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:none" alt="">
															<input type="hidden" name="mp4_hd_on" class="singleCheckbox" id="mp4_hd_on" data-value="0" style="display:none;">
														</div>
														<div class="checkboxText">Add HD Version</div>
													</div>

												</td>
											</tr>
										</table>
										
										
									</td>

								</tr>
								<!-- HD Version -->
								
								<tr>
									<td colspan="2">
										<table style="float:left;width:100%;padding-left:0px;margin-top:0px;">
						                   <tr>
						                     <td>
						                       <div class="input text invisibleDiv">
													<label class="setting" data-setting="title">
														<span>MP4 High Definition URL Source</span>
															<input name="mp4_hd" placeholder="MP4 or WEBM HD URL" maxlength="300" type="text" id="VideoMp4Hd">
													</label>
												</div>
						                      </td>
						                    
						                     <td style="width:115px;vertical-align:top;">

						                        
						                        <div class="bridBrowseLibary invisibleDiv" style="margin-top:30px" data-field="VideoMp4Hd" data-uploader_button_text="Add HD Video" data-uploader_title="Browse for MP4 High Definition URL Source">BROWSE LIBRARY</div>								
						                      </td>
						                    </tr>
						                  </table>
										
										
									</td>
								</tr>
								<!-- Snapshot -->
								<tr>
									<td colspan="2">
										<input type="hidden" name="thumbnail" id="VideoThumbnail">
										<table style="float:left;width:100%;padding-left:0px;margin-top:0px;">
						                   <tr>
						                     <td>
						                       <div class="input text">
													<label class="setting" data-setting="title">
														<span>Provide URL to the snapshot image</span>
														
															<input name="image" placeholder="Snapshot URL" maxlength="300" type="text" id="VideoImage">
														
													</label>
												</div>	
						                      </td>
						                    
						                     <td style="width:115px;vertical-align:top;">

						                        
						                       <div class="bridBrowseLibary" data-field="VideoImage" style="margin-top:30px"  data-uploader_button_text="Add Snapshot" data-uploader_title="Browse for Snapshot image">BROWSE LIBRARY</div>
						                      </td>
						                    </tr>
						                  </table>
										
										
									</td>
								</tr>
												
								
								
								
							</tbody>
						</table>
				            		      
						<!--
						
						<div id='autoSaving'>Autosaving<span class="fDot">.</span><span class="sDot">.</span><span class="tDot">.</span></div>
					-->
					</div>
				</div>

				
			</div>
				
				
			</td>
		</tr>
	</tbody>
	</table>			


</div>
<!-- SIde bar -->
<div class="media-sidebar">
	<div class="media-uploader-status" style="display: none;">
		<h3>Uploading</h3>
		<a class="upload-dismiss-errors" href="#">Dismiss Errors</a>

		<div class="media-progress-bar"><div></div></div>
		<div class="upload-details">
			<span class="upload-count">
				<span class="upload-index"></span> / <span class="upload-total"></span>
			</span>
			<span class="upload-detail-separator">–</span>
			<span class="upload-filename"></span>
		</div>
		<div class="upload-errors"></div>
	</div>
	<div class="attachment-details save-ready">
		<h3 >
			Video Details
			<span class="settings-save-status">
				<span class="spinner"></span>
				<span class="saved">Saved.</span>
			</span>
		</h3>
		<div class="separator" style="border-bottom: 1px solid #ddd;margin-bottom:10px;"></div>
		
			<label class="setting" data-setting="title">
				<span>Video Title</span>
					<input name="name" maxlength="250" type="text" placeholder="Video title" id="VideoName" required="required">
			</label>
			<label class="setting" data-setting="caption">
				<span>Description</span>
				<textarea name="description" placeholder="Video description" id="VideoDescription"></textarea>
			</label>
			<label class="setting" data-setting="alt">
				<span>Tags</span>
				<input name="tags" placeholder="Comma-Separated Values" type="text" id="VideoTags">
			</label>
			<label class="setting" data-setting="description" onclick="return false;">
				<span>Publish date</span>
				<div style="position:relative;z-index:9999;cursor:pointer">
					<input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" type="text" id="VideoPublish" style="cursor:pointer">
				</div>
			</label>
			<label class="setting" data-setting="description">
				<span>Channel</span>
				<select name="channel_id" id="VideoChannelId" required="required">
							<?php foreach($channels as $k=>$v){
								$selected = '';
								if($v->Channel->name=='Default' || $v->Channel->name=='General'){
									$selected = 'SELECTED';
								}
								?>
									<option value="<?php echo $v->Channel->id; ?>" <?php echo $selected; ?>><?php echo $v->Channel->name; ?></option>
								<?php
							}?>
				</select>
			</label>
			<label class="setting" data-setting="description">
				<span>Age gate</span>
				<select name="age_gate_id">
					<option value="1">Everyone</option>
					<option value="2">17+ (ESRB - Mature rated)</option>
					<option value="3">18+ (ESRB - Adults only)</option>

				</select>
			</label>

	</div>
		
	</div>

</div>
</form>

<?php if(!$upload) {
	?>
	
	
		<div id="addVideoQuestion" style="position:absolute; bottom:0px;"data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>">Want us to host and encode videos for you? Upgrade to premium plan for free.</div>
		<script>jQuery('#addVideoQuestion').colorbox({innerWidth:920, innerHeight:650});</script>
	
	<?php 
}
?>

<script>
var allowedImageExtensions = ["jpg","jpeg","png","gif"];
var amIEncoded = 0;
var typingTimer;                					//timer identifier
var doneTypingInterval = 600;  						//time in ms, 5 second for example
var defaultTab = 'video';
var currentView = 'add-video';						//This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

var clickedAddButton;								//Stores ADD button object we clicked
var selectBoxTitle = 'Select category <img class="arrowDownJs" src="<?php echo BRID_PLUGIN_URL; ?>/img/arrow_down.png" width="8" height="4" alt="Click to open submenu" />';

//JS Templating system @see http://handlebarsjs.com/
//var template = Handlebars.compile(jQuery('#oneRowTempalte').html());
//Init save object
enableSave();
var save = saveObj.init();

	 /**
	  * Save button on click
	  */
	jQuery("#videoSaveAdd").unbind('click');

	jQuery("#videoSaveAdd").off('click.PostBrid', saveVideo).on('click.AddPostBrid', saveVideo);


	function saveVideo(e){

	 	 if(!jQuery(this).hasClass('disabled') && !jQuery("#videoSaveAdd").hasClass('inprogress')){

	 		jQuery("#videoSaveAdd").addClass('inprogress');
	 		 save.save('VideoAddForm');
	 		 //onVideoSave callback will add shortcode to post

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
	         
	 }

	//Call Enable save button function on change
	jQuery('#VideoName, #VideoImage, #VideoMp4Hd').input(function(){
		//checkFields();
		enableSave();
	});
	//Grab additional info and check codec of the provided Mp4 Url (on success call enableSave();)
	jQuery("#VideoMp4").input(function(){
		//checkFields();
		getFfmpegInfo();
		enableSave();

	});
	jQuery('#ChannelIdUpload').change(function(){enableSave();});


	var browse = jQuery('.bridBrowseLibary');

	if(browse.length>0){


		browse.on('click', function(){
				

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

			      //console.log('attachment', attachment);

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