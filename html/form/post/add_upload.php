<div class="mainWrapper" style='padding-top:10px;width:auto'>
<?php 
$hideUploadFields = 'block';
if($upload) {
$hideUploadFields = 'none';
	?>
<div class="formUploaderWrapper" id="UploaderForm" style="width:auto;position:relative;margin-top:20px">
	<div class="mainDataAddQuick">
	<form id="upload" name="upload" enctype="multipart/form-data" action="" target="uploadframe"  method="post">
									
		<input type="hidden" id="uid" name="uid" value="0" />
		<input type="hidden" id="sid" name="sid" value="0" />
		<input type="hidden" id="bridTimestamp" name="timestamp" value="0" />
		<input type="hidden" id="signature" name="signature" value="0" />
		<div id="uploadButtonDiv" style="  text-align: center; ">
			<input type="button" id="userfileButton" class="uploadFile" autocomplete="off" style="position:static;   margin-top: 40px; float:none;"/>
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
		var uploadUrl = '<?php echo OAUTH_PROVIDER; ?>';
		$Brid.init([['Html.Uploader', {uploadLimit:'1000MB', mode : 'quick'}]]);
	</script>
	</div>
<!--
	<div id="fetchDiv" class="form">
			<div class="fetchDivWrapper">
				<div class="input text"><span class="fetchDivHSpan">http://</span><label for="fetchUrl">Alternatively, you can have us upload your video file from a URL, or enter a streaming URL here:</label><input name="data[fetchUrl]" style="text-indent:50px;color:#bbbdc0;" class="reqiured" type="text" id="fetchUrl"></div>				

			<div class="button go-fetch-url disabled" id="goFetchUrl" data-form-req="0" data-form-bind="0" style="margin-top: 20px; margin-left: 2px;">
			<div class="buttonLargeContent">GO</div></div>

			</div>
			
	</div>
-->
</div>
<div class='fetchWarring' style="left: 0px; right: 310px; height:20px;width:auto;bottom:10px;position:absolute;top:inherit">By uploading this video to our system you confirm that you own all copyrights or have authorization to upload and use it.</div>
<?php } ?>


 <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">
 	<div class="videos form">
 	<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>    
 	<table class="form-table" style="display:<?php echo $hideUploadFields; ?>">
	 <tbody><tr>
		<td style="width:858px">
			<div class="formWrapper videoAddFormWrapper">

				<div id="mainAdd">
					<input type="hidden" name="action" value="uploadVideoPost">
					<input type="hidden" name="insert_via" value="2">
					<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
					<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
					<input type="hidden" name="id" id="VideoId">
					<input type="hidden" name="upload_form" value="<?php echo $upload; ?>" id="VideoUploadForm">
					
					<input type="hidden" name="upload_in_progress" id="VideoUploadInProgress" value="0">
					<input type="hidden" name="progress_signature" id="VideoProgressSignature">
					<input type="hidden" name="original_filename" id="VideoOriginalFilename">
					<input type="hidden" name="original_file_size" id="VideoOriginalFileSize">
					<input type="hidden" name="upload_source_url" id="VideoUploadSourceUrl">
					<input type="hidden" name="xml_url" id="VideoXmlUrl">

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
					
				</div>

				
			</div>
			
			
		</td>
	</tr>
</tbody></table>
</div>

<!-- SIde bar -->
<div class="media-sidebar">
	<div class="attachment-details save-ready" id="postUploadQuick" style="display:none">
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
			<label class="setting" data-setting="description">
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
</form>	


<?php if(!$upload) {
	?>
	<div style="clear:both;"></div>
	<div style="border-top:1px solid #BCC3C3;margin-top:15px;padding-top:2px;">
		<div style="margin-left:12px;font-weight:normal;text-decoration:underline;cursor:pointer;text-weight:bold;" class="various" id="addVideoQuestion" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>">Want us to host and encode videos for you? Upgrade to premium plan for free.</div>
		<script>jQuery('#addVideoQuestion').colorbox({innerWidth:920, innerHeight:650});</script>
	</div>
	<?php 
}
?>
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
	  * Save button on click binded already on add_video
	  */
	jQuery("#videoSaveAdd").unbind('click');

	jQuery("#videoSaveAdd").on('click.AddUploadPostBrid', function(){

		if(!jQuery('#videoSaveAdd').hasClass('disabled') && !jQuery('#videoSaveAdd').hasClass('inprogress')){
			save.save('VideoAddForm');
		}else{
			if(jQuery('#VideoXmlUrl').val()=='' && jQuery('#signature').val()!=''){

				$Brid.Util.openDialog('Upload in progress','Save disabled');
			}
		}
		
	});

	//Call Enable save button function on change
	jQuery('#VideoName, #VideoImage, #VideoMp4Hd').input(function(){
		enableSave();

		if(jQuery('#VideoXmlUrl').val()=='' && jQuery('#signature').val()!=''){

			jQuery('#videoSaveAdd').addClass('disabled');
		}
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

			      console.log('attachment', attachment);

			     field.val(attachment.url);

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
</script>