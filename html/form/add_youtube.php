<div class="videos form">
	<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"></div>    
		<table class="form-table" style="display:block">
		 <tbody><tr>
			<td style="width:858px;">
				<div class="formWrapper">
									
		    		<div id="mainAdd">
		    			<input type="hidden" name="action" value="addVideo">
					    <input type="hidden" name="insert_via" value="2">
						<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
						<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
						<input type="hidden" name="upload_form" value="0" id="VideoUploadForm">
						<input type="hidden" name="default_tab" value="youtube" id="VideoDefaultTab">
						<input type="hidden" name="external_id" id="VideoExternalId">
						<input type="hidden" name="encoding_setup_finished" id="VideoEncodingSetupFinished">
						<input type="hidden" name="width" id="VideoWidth">
						<input type="hidden" name="height" id="VideoHeight">
						<input type="hidden" name="size" id="VideoSize">
						<input type="hidden" name="video_codec" id="VideoVideoCodec">
						<input type="hidden" name="video_bitrate" id="VideoVideoBitrate">
						<input type="hidden" name="external_service" id="VideoExternalService" value="">
						<input type="hidden" name="external_type" id="VideoExternalType" value="">
						<input type="hidden" name="IsFamilyFriendly" id="VideoIsFamilyFriendly">
						<input type="hidden" name="duration" id="VideoDuration">					    
						<input type="hidden" name="external_url" default-value="External URL" data-info="External URL" id="VideoExternalUrl" value="">					    <!-- Youtube/Vimeo Form -->
						    					        
						    <div class="mainDataAdd" id="externalForm">
						    
						       	<!-- YOUTUBE SEARCH FORM -->
						       
							    <div style="padding:0px;position:relative" id="youtubeSearch">
									<img src="<?php echo BRID_PLUGIN_URL; ?>img/search.png" style="position: absolute; right: 6px; top: 10px; z-index: 10; width: 32px; height: 29px">
								    <div class="input text"><input name="youtube_search" default-value="Search for a term or enter video URL" data-info="Search for a term or enter video URL" type="text" id="VideoYoutubeSearch" aria-describedby="ui-tooltip-0" data-ajax-loaded="true">
								    	
								    </div>						    
								</div>

								<!-- YOUTUBE CHANNELS -->
							   	<div id="add-youtube-channel-container" style="width:820px;">
								   	<div id="add-youtube-channel">
								   		<div class="input select required">
								   			<select name="channel_id_youtube" class="dropdownMenu dropdown" data-css='{"height":230, "width":150}' id="ChannelIdYoutube" required="required" data-method="channelSelected" style="display: none;">
												<?php foreach($channels as $k=>$v){
													
													?>
													<option value="<?php echo $v->Channel->id; ?>"><?php echo $v->Channel->name; ?></option>
													<?php
												}?>
											</select>
								   		</div>							   	
								   	</div>
							   	</div>
							   	
							   	<div id="externalServiceLoading">Searching...</div>
							 	<table id="youtubeContent"></table>
							</div>
													 
							 
							
	                        <!-- MAIN FORM -->
							    
							<div class="mainDataAdd" id="mainData" style="display: none;">
								<table style="border-spacing: 0px;">
									
									<tbody><tr>
										<td style="width:576px; padding-top: 10px;">
											<div class="input text required"><input name="name" default-value="Video title" data-info="Video title" tabindex="1" maxlength="250" type="text" id="VideoName" required="required"><div class="defaultInputValue" data-info="Video title" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoName" data-position="true">Video title</div></div>										
										</td>
										<td style="padding:0px; padding-top: 10px; vertical-align:top; padding-left: 10px;">
											<div style="float:right; position:relative;">

															<div class="input text"><input name="publish" readonly="readonly" value="31-03-2014" default-value="31-03-2014" class="datepicker inputField hasDatepicker" data-info="Publish on a date." type="text" id="VideoPublish"></div>										</div>
										</td>
									</tr>
									
									
									<tr><td colspan="2"><div class="input textarea"><textarea name="description" default-value="Video description" style="height:100px;" data-info="Video description" tabindex="2" cols="30" rows="6" id="VideoDescription"></textarea><div class="defaultInputValue defaultValueIndent" data-info="Video description" style="padding-top: 8px; display: block; top: 6px; padding-left: 5px; font-size: 16px;" id="default-value-VideoDescription" data-position="true">Video description</div></div></td></tr>
									
									<tr>
										<td colspan="2">
											<div class="input select required" tabindex="3" style="max-width:150px">
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

									<tr>
										<td colspan="2">

												<div class="input text">
													<input name="tags" default-value="Tags" tabindex="4" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." type="text" id="VideoTags"><div class="defaultInputValue defaultValueIndent" data-info="Input Tag values as Comma-Separated Values (CSV) if you wish to display related videos when this video ends." style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoTags" data-position="true">Tags</div></div>											</td>
										
									</tr>
																		<tr><td colspan="2">
										<input type="hidden" name="thumbnail" id="VideoThumbnail">									<div class="input text"><input name="image" default-value="Snapshot URL" data-info="Provide URL to the snapshot image" tabindex="5" maxlength="300" type="text" id="VideoImage"><div class="defaultInputValue defaultValueIndent" data-info="Provide URL to the snapshot image" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoImage" data-position="true">Snapshot URL</div></div></td></tr>
										
										<tr>
											<td colspan="2">
											<div class="input text"><input name="mp4" default-value="MP4 or WEBM" data-info="Add MP4, WEBM or streaming video file URL" tabindex="6" maxlength="300" type="text" id="VideoMp4" required="required"><div class="defaultInputValue defaultValueIndent" data-info="Add MP4, WEBM or streaming video file URL" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoMp4" data-position="true">MP4 or WEBM</div></div>										</td>
										</tr>
										
										<tr>
											<td colspan="2">
												<div id="checkbox-mp4_hd_on" class="checkbox disabledCheckbox" data-method="toggleVideoField" data-name="mp4_hd_on" style="top:4px;left:1px;"><div class="checkboxContent"><img src="<?php echo BRID_PLUGIN_URL; ?>img/checked.png" class="checked" style="display:none" alt=""><input type="hidden" name="mp4_hd_on" class="singleCheckbox" id="mp4_hd_on" data-value="0" style="display:none;"></div><div class="checkboxText">Add HD Version</div></div>
											
											</td>
										</tr>
										<tr>
											<td colspan="2">
												<div class="input text invisibleDiv"><input name="mp4_hd" default-value="MP4 or WEBM HD URL" data-info="MP4 High Definition URL Source" maxlength="300" type="text" id="VideoMp4Hd"><div class="defaultInputValue defaultValueIndent" data-info="MP4 High Definition URL Source" style="padding-top: 0px; display: block; top: 14px; padding-left: 5px; font-size: 16px;" id="default-value-VideoMp4Hd" data-position="true">MP4 or WEBM HD URL</div></div>										
											</td>
										</tr>
									</tbody>
								</table>
	            		      

								<div class="button saveButton disabled" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0" style="margin-bottom: 0px; margin-top: 15px; display: none;">
									<div class="buttonLargeContent">SAVE</div>
								</div>
							</div>
					</div>
					
					</div>
					
					
				</td>
			</tr>
		</tbody>
	</table>		
				
	</form>	



<table id="oneRowTempalte" style="display:none"><tbody><tr id="video-row-{{id}}" data-id="{{id}}" class="partnerTr" style="background-color:{{bgColor}}">
	<td style="width:10px;"></td>
		<td class="imgTable">
			<div class="centerImg">
                <div class="centerImgWrapper">
                	<a href="{{providerUrl}}{{id}}" title="View on {{service}}: {{title}}" target="_blank">
                    	<img src="{{image}}" class="thumb" width="111px" height="82px" id="video-img-{{id}}" alt="" style="display: inline;">
                    </a>
                </div>
                <div class="time" id="video-duration-{{id}}">{{duration}}</div>
            </div>
    </td>
    <td class="videoTitleTable">
            <div style="float:left;width:100%;">
                    <a href="{{providerUrl}}{{id}}" id="video-title-{{id}}"  class="listTitleLink"  title="View on {{service}}: {{title}}" target="_blank">{{title}}</a>
                    <div class="videoUploadedBy">
                        <div class="siteVideosNum">By: {{author}} &nbsp;&nbsp;<span style="color:#b5b5b5">Created: {{published}}</span></div>
                    </div>
            <div>
           
     </div></div></td>
     <td align="right" id="td{{id}}">
		<div class="button youtube_add" data-id="{{id}}" style="display: block; opacity: 1;">
		<div class="buttonLargeContent">ADD</div></div>
     </td>
</tr></tbody></table>
</div>

<script>

//Array of destination objects

// Allowed image extensions
var allowedImageExtensions = ["jpg","jpeg","png","gif"];
var amIEncoded = 0;
var typingTimer;                					//timer identifier
var doneTypingInterval = 600;  						//time in ms, 5 second for example
var defaultTab = 'youtube';
var currentView = 'add-video';						//This simulates tab switch for buttons, and currently selected service (youtube, vimeo)

var clickedAddButton;								//Stores ADD button object we clicked
var selectBoxTitle = 'Select category <img class="arrowDownJs" src="<?php echo BRID_PLUGIN_URL; ?>img/arrow_down.png" width="8" height="4" alt="Click to open submenu" />';

//JS Templating system @see http://handlebarsjs.com/
var template = Handlebars.compile(jQuery('#oneRowTempalte').html());
//Init save object
var save = saveObj.init();

//Init main functions
/*
methods.videos_add = function(){ 

	//initMainFunctions();
	//$Brid.init(['datepicker']);
	
	//$('.textButtonSmallJs').html(selectBoxTitle);
	jQuery('.textButtonSmallJs').parent().parent().addClass('required');
	
//	$('.chkbox_action').click(function(){ enableSave(); });    
	
}*/
initBridMain();

function addVideoFromSearch(val, text) {
	jQuery('#add-youtube-channel, #add-vimeo-channel').hide();															// Hide category dropdown
	var dataId = clickedAddButton.attr('data-id');																	// Prepare data and call save function
	var serviceUrl = (currentView=='add-vimeo') ? 'http://www.vimeo.com/' : 'http://www.youtube.com/watch?v=';
	//clickedAddButton.replaceWith('<div class="addedYoutubeVimeo">' + text + '</div>');
	clickedAddButton.remove();
	console.log('addVideoFromSearch', serviceUrl+dataId);        
	populateDataAndSave(serviceUrl+dataId, dataId);

	//Take back add-{currentView}-channel to the container div, so on next contnet display (search) we can show it again
	//If we do not do this, on ADD button click, add-{currentView}-channel will be moved to the Youtube list so user can add it to category
	//But next search query in input field will override Youtube list and add-{currentView}-channel will be lost, so on add
	//we move it back to its parent container
	jQuery('#' + currentView + '-channel-container').append(jQuery('#' + currentView + '-channel').detach());
	
}


function showEditLine(id) {
	var td = jQuery("td#td" + id);
	td.find('.videoAdded').fadeOut('fast', function() {
		td.find('.videoAdded2').fadeIn('fast', function(){

				jQuery(this).find('a').click(function(e){
					e.preventDefault();
					//debug.log('Click on edit it here:', jQuery(this));

					var id = jQuery(this).attr('data-id'); //Populated in brid.save.js
					if(id!=undefined)
					$Brid.Api.call({data : {action : "editVideo", id : id}, callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}});

				});
			});
		});
	
}
//Ajax : Check Youtube url and populate form, and call save
var populateDataAndSave = function(youtubeUrl, dataId){			//Check Youtube/Vimeo Url

		jQuery("td#td" + dataId).append('<img src="<?php echo BRID_PLUGIN_URL; ?>img/adding_external_video.gif" style="padding-right: 25px" />');
		//alert(dataId+'aaaaa'+youtubeUrl);
		jQuery.ajax({
			  url: ajaxurl, //'/videos/check_url/.json',
			  data: 'action=checkUrl&external_url='+youtubeUrl,
			  type: 'POST',
			  context: {id:dataId}
		}).done(function(responseData) {
			   
			if(typeof responseData ==  'object' && responseData.length != 0)
			{
				debug.log('Objekat moj:', responseData, 'id:', this.id);
				
				for(var a in responseData){	//Populate form data
					
					if(jQuery('#Video'+a).length>0)
					{
						jQuery('#default-value-Video'+a).hide();
						jQuery('#Video'+a).val(responseData[a]);
					}
				}
				
				jQuery("td#td" + this.id + ' img').remove();
				jQuery("td#td" + this.id).append('<div class="videoAdded">VIDEO ADDED!</div><div class="videoAdded2"><a href="#">EDIT IT HERE</a></div>');

				if (currentView!='add-vimeo') {
					setTimeout('showEditLine("' + this.id +'")', 1200);
				}

				debug.log('SAVE...');
				save.save('VideoAddForm');
				
			}
	  });
	
}
//Ajax: Search Youtube API
var getYoutube = function(){

	clearTimeout(typingTimer);
	var searchVal = jQuery('#VideoYoutubeSearch').val();
	var youtubeContent = jQuery('#youtubeContent');

	jQuery('#externalServiceLoading').hide();		//Hide Searching text
	
	if(searchVal.length>2){

		//Check is youtube url posted (simple video url or playlist url) and try to get Youtube ID so you can send it as searchVal
		var video_id = searchVal.split('v=')[1];

		console.log('video_id', video_id);
		
		if(video_id!=null){

			//Url or Youtube id provided
			var ampersandPosition = video_id.indexOf('&');
			if(ampersandPosition != -1) {
				searchVal = video_id.substring(0, ampersandPosition);

				
			}else{

				searchVal = video_id;
				
			}

			var urlApi = 'https://gdata.youtube.com/feeds/api/videos/'+escape(searchVal)+'?v=2&alt=json';
			
		}else{
			//Simple test - search by title or string
			//@see https://developers.google.com/youtube/2.0/developers_guide_protocol#orderbysp
			var urlApi = 'https://gdata.youtube.com/feeds/api/videos?q='+escape(searchVal)+'&orderby=relevance&start-index=1&max-results=10&v=2&alt=json';
			
		}
		
		
		jQuery.ajax({
			  url: urlApi,
			  type: 'GET',
			  dataType: 'json'
		}).done(function(data){

			console.log('Youtube data:', data);
			  		youtubeContent.html('');
			  
			  		var tableData = [];

			  		var videos = [];
			  		
			  		if(video_id!=null){

			  			videos.push(data.entry);
						
			  		}else{

			  			videos = data.feed.entry;
			  		}
					jQuery(videos).each(function(k,v){
		
						  tableData.push({
											title : 	v.title.$t, 
											id : 		v.media$group.yt$videoid.$t, 
											image : 	v.media$group.media$thumbnail[0].url, 
											duration:	v.media$group.yt$duration.seconds.toHHMMSS(), 
											author:		v.author[0].name.$t, 
											service:	'Youtube', 
											published : new Date(v.published.$t).toPrettyFormat(),
											providerUrl : 'http://www.youtube.com/watch?v='
										});
					});

					if(tableData.length>0){
				  		showContent(tableData); // This function should be call for both: youtube and vimeo
					}else{

						jQuery('#youtubeContent').html('No videos found.');
						console.log('No videos found');
					}

					 
			});

	}else{
		youtubeContent.html('');
	}
}

/**
 * Show content of youtube/vimeo search results
 */
function showContent(arrayData) {
        
	var youtubeContent = jQuery('#youtubeContent');
	var contnet = '';
	jQuery(arrayData).each(function(k,v){

		if(v.title!=undefined)
		{
			var decoded = jQuery('<div></div>').html(v.title).text();
			v.title = decoded;
			v.bgColor = '#f7f7f7';
			if(k%2==0){ v.bgColor = '#fff';}
			contnet += template(v);
		}
		
	});

	youtubeContent.append(contnet);
	
	jQuery('.youtube_add').click(function(e){
		clickedAddButton = jQuery(this);

		var parentTD = clickedAddButton.closest('td');
		var sBoxId = '#' + currentView + '-channel';
		
		jQuery('.youtube_add').show();											// First show all add buttons
		
		jQuery(sBoxId + ' .textButtonSmallJs').html(selectBoxTitle);				// Initialize drop down box
		jQuery(sBoxId + ' .gdrop_down').hide();

		//var sBoxAlreadyExist = parentTD.find(sBoxId);
		//if($(sBoxAlreadyExist).length==0)
		parentTD.append(jQuery(sBoxId).detach());								// Put it into TD (absolute positioning doesn't work because of sticky nav)

		console.log('sBoxId', parentTD.attr('id'), jQuery(sBoxId));
		
		jQuery(sBoxId).show();													// Show drop box and hide add button
		jQuery(this).hide();

  	});


	
}


jQuery(function() {
	 /**
	  * Youtube search field
	  */
	 jQuery('#VideoYoutubeSearch').keyup(function(){			//on keyup, start the countdown

	 	jQuery('#externalServiceLoading').fadeIn();
	 	clearTimeout(typingTimer);
	    typingTimer = setTimeout(getYoutube, doneTypingInterval);
	     
	 }).keydown(function(){							//on keydown, clear the countdown 
	 	
	     clearTimeout(typingTimer);
	 });
	
	 
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
    function resetFetchedFields(){
        
    	//Reset Youtube fields
		var youtubeFields = ['VideoTags', 'VideoImage', 'VideoName', 'VideoMp4', 'VideoWebmOgg', 'VideoUniqueid', 'VideoSource', 'VideoExternalUrl', 'VideoExternalType', 'VideoExternalService']; //['VideoTags', 'VideoImage', 'VideoTitle', 'VideoExternalUrl', 'VideoUniqueid'];
		
		jQuery(youtubeFields).each(function(a,b){

			jQuery('#default-value-'+b).show();
			jQuery('#'+b).val('');

		});
		
    }
    //Generate form view depending of the defaultTab value
    if (defaultTab == 'vimeo' || defaultTab == 'youtube') {
        //Youtube
        if (defaultTab == 'youtube') {
            addYoutubeProcessor();
        }
        //Vimeo - disabled
        if(defaultTab == 'vimeo'){
            addVimeoProcessor();
        }
    } else {
        //Classic video
        addVideoProcessor();
    }
/**/    
    // Init preview of the Youtube Form (Search)
    function addYoutubeProcessor() {
        resetFetchedFields();
        
        if(currentView!='add-youtube')
        {   
            jQuery('#formName').html('Add YouTube Video');

            jQuery('#externalForm, #youtubeSearch').fadeIn();

            //Empty youtubeContnet div (if someone searched Vimeo first)
            jQuery('#youtubeContent').html('');                  
            jQuery('#VideoVimeoSearch').val('');                 
            //$('#default-value-VideoVimeoSearch, #add-youtube-channel').show();
            
            jQuery('#videoSaveAdd, #vimeoSearch, #mainData, #add-vimeo-channel').hide(); //, #mainData
            
            jQuery('#VideoExternalUrl').val('');
            //Remove this if you want save to work
            jQuery('#VideoMp4').parent().removeClass('required');
            
            currentView = 'add-youtube';
            
        }
        
    }
  
    // Init preview of the Classic Video Input
    function addVideoProcessor() {
        jQuery('#videoSaveAdd, #mainData').fadeIn();
        //If external Url is provided
        if (jQuery('#VideoExternalUrl').val()!='') { 
            resetFetchedFields();
        }
            
        if(currentView!='add-video')
        {
            jQuery('#VideoMp4').parent().addClass('required');
            jQuery('#VideoYoutubeSearch, #VideoVimeoSearch').val('');                    	//remove all from youtube and vimeo search
            jQuery('#default-value-VideoYoutubeSearch, #default-value-VideoVimeoSearch').show();
            jQuery('#formName').html('Add Video');
            jQuery('#videoSaveAdd, #mainData').fadeIn();     
            jQuery('#externalForm').hide();
            currentView = 'add-video';
            
        }
        
    }
   
});

</script>