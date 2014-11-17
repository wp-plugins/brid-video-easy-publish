<?php 
$hideUploadFields = 'block';
if($upload) {
$hideUploadFields = 'none';
	?>
<div class="formUploaderWrapper" id="UploaderForm" style="position:relative;margin-top:20px">
	<div class="mainDataAdd">
	<form id="upload" name="upload" enctype="multipart/form-data" action="" target="uploadframe"  method="post">
									
		<input type="hidden" id="uid" name="uid" value="0" />
		<input type="hidden" id="sid" name="sid" value="0" />
		<input type="hidden" id="timestamp" name="timestamp" value="0" />
		<input type="hidden" id="signature" name="signature" value="0" />
		<div id="uploadButtonDiv">
			<input type="button" id="userfileButton" class="uploadFile" autocomplete="off"/>
		</div>
		<div id="uploadInputHide">
			<input name="userfile" id="userfile" type="file"/>
		</div>
		
	</form>
	<iframe id="uploadframe" name="uploadframe" width="0" height="0" frameborder="0" border="0" ></iframe>
	<div id="progress"></div>
	<div id="uploadCloseBtn"></div>
	<div id="uploadMsg"></div> 
	<script>
	$Brid.init([['Html.Uploader', {uploadLimit:'1000MB'}]]);
	</script>
	</div>

	<div id="fetchDiv" class="form">
			<div class="fetchDivWrapper">
				<div class="input text"><span class="fetchDivHSpan">http://</span><label for="fetchUrl">Alternatively, you can have us upload your video file from a URL, or enter a streaming URL here:</label><input name="data[fetchUrl]" style="text-indent:50px;color:#bbbdc0;" class="reqiured" type="text" id="fetchUrl"></div>				

			<div class="button go-fetch-url disabled" id="goFetchUrl" data-form-req="0" data-form-bind="0" style="margin-top: 20px; margin-left: 2px;">
			<div class="buttonLargeContent">GO</div></div>

			</div>
			
	</div>

</div>
<div class='fetchWarring'>By uploading this video to our system you confirm that you own all copyrights or have authorization to upload and use it.</div>
<?php } ?>

<div class="videos form">
 <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">
 	<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>    
 	<table class="form-table" style="display:<?php echo $hideUploadFields; ?>">
	 <tbody><tr>
		<td style="width:858px">
			<div class="formWrapper videoAddFormWrapper">

				<div id="mainAdd">
					<input type="hidden" name="action" value="addVideo">
					<input type="hidden" name="insert_via" value="2">
					<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
					<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
					<input type="hidden" name="id" id="VideoId">
					<input type="hidden" name="upload_form" value="<?php echo $upload; ?>" id="VideoUploadForm">
					<?php if($upload) {?>

						<input type="hidden" name="upload_in_progress" id="VideoUploadInProgress" value="0">
						<input type="hidden" name="progress_signature" id="VideoProgressSignature">
						<input type="hidden" name="original_filename" id="VideoOriginalFilename">
						<input type="hidden" name="original_file_size" id="VideoOriginalFileSize">
						<input type="hidden" name="upload_source_url" id="VideoUploadSourceUrl">
						<input type="hidden" name="xml_url" id="VideoXmlUrl">

					<?php } ?>
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
					<input type="hidden" name="autosave" id="VideoAutosave" value="1">
					<input type="hidden" name="external_url" default-value="External URL" data-info="External URL" id="VideoExternalUrl">					    <!-- Youtube/Vimeo Form -->
									    						 
					<!-- MAIN FORM -->
										    
					<div class="mainDataAdd" id="mainData" style="">
						<table style="border-spacing: 0px;">
							<tbody>
								<tr>
									<td style="width:576px; padding-top: 10px;">
										<div class="input text required">
											<input name="name" default-value="Video title" data-info="Video title" tabindex="1" maxlength="250" type="text" id="VideoName" required="required">
										</div>										
									</td>
									<td style="padding:0px; padding-top: 10px; vertical-align:top; padding-left: 10px;">
										<div style="float:right; position:relative;">
											<div class="input text">
												<input name="publish" readonly="readonly" value="17-03-2014" default-value="17-03-2014" class="datepicker inputField" data-info="Publish on a date." type="text" id="VideoPublish">
											</div>										
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="input textarea">
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
												<input name="tags" default-value="Tags" tabindex="4" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." type="text" id="VideoTags">
											</div>											
									</td>
								</tr>
								<?php if($hideUploadFields!='none'){?>
								<tr>
									<td colspan="2">
										<input type="hidden" name="thumbnail" id="VideoThumbnail">									
										<div class="input text">
											<input name="image" default-value="Snapshot URL" data-info="Provide URL to the snapshot image" tabindex="5" maxlength="300" type="text" id="VideoImage">
										</div>
									</td>
								</tr>

								<tr>
									<td colspan="2">
										<div class="input text required">
											<input name="mp4" default-value="MP4 or WEBM" data-info="Add MP4, WEBM or streaming video file URL" tabindex="6" maxlength="300" type="text" id="VideoMp4" required="required" data-ajax-loaded="true">
										</div>							
									</td>
								</tr>
												
								<tr>
									<td colspan="2">

										<div id="checkbox-mp4_hd_on" class="checkbox disabledCheckbox" data-method="toggleVideoField" data-name="mp4_hd_on" style="top:4px;left:1px;">
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
										<div class="input text invisibleDiv">
											<input name="mp4_hd" default-value="MP4 or WEBM HD URL" data-info="MP4 High Definition URL Source" maxlength="300" type="text" id="VideoMp4Hd">
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
				            		      

						<div class="button saveButton disabled" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0" style="margin-bottom:0px; margin-top:15px;">
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
<script>
var allowedImageExtensions = ["jpg","jpeg","png","gif"];
var amIEncoded = <?php echo $upload; ?>;
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

initBridMain();

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
	jQuery('#VideoName, #VideoImage, #VideoMp4Hd').input(function(){
		enableSave();
	});
	//Grab additional info and check codec of the provided Mp4 Url (on success call enableSave();)
	jQuery("#VideoMp4").input(function(){
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
    if(amIEncoded){
		jQuery('#VideoName , #VideoDescription, #VideoTags, #VideoLandingPage').input($Brid.Video.checkAutosaveMessage);
	}
</script>