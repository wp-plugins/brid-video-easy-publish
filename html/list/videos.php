<?php
$insertIntoContent = '#Videos-content';
//Playlist mode
if($mode!=''){ 
	$insertIntoContent = '#video-list';
}

if($mode!='playlist') { 

if(!$buttonsOff){
?>
<!-- Add buttons start -->
<div class="mainWrapper">
	<div class="mainButtonsMenu">
		<?php if($ask){
			?>
			<!-- Ask qustion about host -->
			<div class="button add-video various"  data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>" id="addVideoQuestion">
				<div class="buttonLargeContent">ADD VIDEO</div>
			</div>
			<script>jQuery('#addVideoQuestion').colorbox({innerWidth:900, innerHeight:400});</script>
		<?php
		}else{
			?>
			<div class="button add-video" data-href="#" id="addVideo">
			<div class="buttonLargeContent">ADD VIDEO</div>
		</div>
		<?php
		}?>
		
		<div class="button add-youtube" data-href="#" id="addYoutube" style="opacity: 1;">
			<div class="buttonLargeContent">ADD YOUTUBE</div>
		</div>

	</div>
</div>
<!-- Add buttons end -->
<?php }else{
	?>
	<div class="mainWrapper">
	<div class="mainButtonsMenu" style="text-align:right;">
		<div class="button post-video disabled" data-href="#" id="postVideo" style="margin-right:40px;">
			<div class="buttonLargeContent">POST</div>
		</div>
	</div>
</div>
<?php
	}
}
?>
<script>
var mode = '<?php echo $mode; ?>'; //playlist mode?
var buttonsOff = '<?php echo $buttonsOff; ?>';
var playlistType = '<?php echo $playlistType; ?>';
</script>

<div class="list-items-menu">
	<div class="list-items-menu-wrapper">
		<ul class="items-menu">
			<!-- Select all checkbox -->
			<li class="last">
				<div style="float:left; margin-top:1px;margin-left:8px;">
					<div id="checkbox-video-check-all" class="checkbox" data-method="toggleAll" data-name="video">
						<div class="checkboxContent">
							<img src="<?php echo BRID_PLUGIN_URL ?>img/checked.png" class="checked" style="display:none" alt="">
							<input type="hidden" name="data[Video][video-check-all]" class="singleCheckbox" id="video-check-all" data-value="0" style="display:none;">
						</div>
					</div>
				</div>
				<?php if($mode!='playlist') { ?>
				<div id="google_button" class="google_button outer_button_div" style="float: left;">
					<div id="inner_button_checkbox" class="inner_button_div">
						<img alt="Click to open submenu" src="<?php echo BRID_PLUGIN_URL ?>img/arrow_down.png" style="vertical-align: top; position:absolute; top:8px; left:3px; width:8px; height:4px"></div>
				</div>
				<div id="g_menu" data-checkbox-id="checkbox-video-check-all" class="gdrop_down" style="display: none;"><div class="chkbox_action" style="cursor:pointer;" data-method="None">None</div><div class="chkbox_action" style="cursor:pointer;" data-method="Published">Published</div><div class="chkbox_action" style="cursor:pointer;" data-method="Pending">Pending</div><div class="chkbox_action" style="cursor:pointer;" data-method="Failed">Failed</div><div class="chkbox_action" style="cursor:pointer;" data-method="Paused">Paused</div><div class="chkbox_action" style="cursor:pointer;" data-method="Monetized">Monetized</div><div class="chkbox_action" style="cursor:pointer;" data-method="NotMonetized">Not Monetized</div>
				</div>
				<?php } ?>
			</li>
			<?php if($mode=='playlist') { ?>
			<li class="toolbarItem">
					<div class="redButtonBg addToPlaylistButton" id="add-to-playlist-<?php echo $subaction; ?>">
						<div class="textButtonSmall">ADD TO PLAYLIST</div>
					</div>
				</li>		
				<?php
			}else {

				if(!$buttonsOff){
				?>
				<!-- Additional options -->
				<li class="toolbarItem">
					<div class="redButtonBg" id="delete-partner">
						<div class="delButtonSmall"></div>
					</div>
				</li>
				<?php } 
			}
			?>
		</ul>
		<!-- Search -->
		<div id="site-search-box">
			<div class="searchBox search-box">
				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
					<div style="display:none;">
						<input type="hidden" name="_method" value="POST">
						<input type="hidden" name="action" value="searchVideos">
					</div>
					<div style="width:150px;float:left;padding-top:3px;margin:0px;">
						<div class="input text">
							<input name="data[Video][search]" data-offset="2" style="font-size:13px;" value="<?php echo $search; ?>" default-value="Search Videos" class="inputSearch" autocomplete="off" type="text" id="VideoSearch">

						</div>		
					</div>
					<div class="searchButtonWrapper">
						<div class="searchButton" id="button-search-Partneruser"></div>
					</div>
				</form>
			</div>
			<script>

			//searchObj sent to configure Search
			<?php
				if($mode!=''){
					?>
						$Brid.init([['Html.Search', {className : '.inputSearch', model : 'Video',objInto:'<?php echo $insertIntoContent; ?>', playlistType : playlistType,  mode:'<?php echo $mode; ?>',subaction:'<?php echo $subaction; ?>'}]]);
					<?php
				}
				else {
					?>
						$Brid.init([['Html.Search', {className : '.inputSearch', model : 'Video',objInto:'<?php echo $insertIntoContent; ?>', buttons : buttonsOff}]]);
					<?php
			}
			?>
			</script>
		</div>
	</div>
</div>

<?php if(!empty($videosDataset->Videos)) { ?>

				    <table class="list-table">
					<?php
					$paginationOrder = '';
					$direction = '';
					$field = '';
					$pagination = $videosDataset->Pagination;

					if(isset($pagination->options->order)){
						//print_r($pagination->options->order);
						foreach($pagination->options->order as $k=>$v){
							$paginationOrder = 'sort:'.$k.'/direction:'.$v.'/';
							$direction = $v;
							$field = $k;
						}
					}
					$paginationFields = array(
												'Title' => array('class'=>'tableTitle','field'=>'Video.name'), 
												'Created' => array('class'=>'tableCreated','field'=>'Video.created')
												);
					
					?>
						<tbody>
							<tr class="trFirst">
								<th class="thName">
									<?php foreach($paginationFields as $k=>$v){
										$order = 'asc';
										$css = '';
										if($v['field'] == $field){
											$order = $css = $direction;

										}
										?>
										<div class="<?php echo $v['class']; ?>">
											<div>
												<a href="#" class="pagination-link <?php echo $css; ?>" data-page="1" data-order="sort:<?php echo $v['field']; ?>/direction:"><?php echo $k; ?></a>
											</div>
										</div>
									<?php

									}?>
								
								</th>
							</tr>

							<?php foreach($videosDataset->Videos as $k=>$v){

								//One row
								?>
								<tr id="video-row-<?php echo $v->Video->id; ?>" data-id="<?php echo $v->Video->id; ?>" class="partnerTr">
									<td style="vertical-align: top;">
										<div class="tableRowContent" id="tableRowContent<?php echo $v->Video->id; ?>" style="position:relative">
											<div class="tableRow" id="tableRow<?php echo $v->Video->id; ?>">
												<div class="videoContent" id="videoContnet<?php echo $v->Video->id; ?>">
													<?php if(in_array($v->Video->status, array(3,4,5,6))) { 

														$processText = 'Encoding';
														if($v->Video->status==4){
															$processText = 'Uploading';
														}

														?>
													<div class="encodingProgressWrapper" title="Video id: <?php echo $v->Video->id; ?>" data-status="<?php echo $v->Video->status; ?>" id="encoding-<?php echo $v->Video->id; ?>">
	
															<div class="encodingProgress">
																
																<div class="encodingStatusBar"><div class="encodingStatusMsg" id="encoding-status-<?php echo $v->Video->id; ?>"></div></div>
															</div>
															<div class="encodingProgressBar">
																<div class="encodingProgressBarMove" id="encoding-bar-<?php echo $v->Video->id; ?>" style="width: 666px;text-aling:center;background-color:none"><?php echo ($v->Video->status==5) ? 'Error, retry please.' : $processText.' in progress. Refresh video list to see status.';?></div>
															</div>
														
													</div>
													<?php } ?>
													<?php
														$checkboxZindex = in_array($v->Video->status, array(5)) ? 'z-index:999;' : '';
													?>
													<div class="checkboxRow" style="<?php echo $checkboxZindex; ?>">
														<div id="checkbox-video-id-<?php echo $v->Video->id; ?>" class="checkbox" data-method="toggleTopMenu" data-name="video">
															<div class="checkboxContent">
																<img src="<?php echo BRID_PLUGIN_URL ?>img/checked.png" class="checked" style="display:none" alt="">
																<input type="hidden" name="data[Video][id]" class="singleCheckbox" id="video-id-<?php echo $v->Video->id; ?>" data-value="<?php echo $v->Video->id; ?>" style="display:none;">
															</div>
														</div>
													</div>
													<div class="centerImg showHidden click" data-id="<?php echo $v->Video->id; ?>" data-callback="initPlayer" data-callback-args='{"id":"1","video":"<?php echo $v->Video->id; ?>","width":"740","height":"360"}' data-open="playerDiv" data-callback-before="changeOverText">
														<div class="centerImgWrapper">
															<?php 
																$poster = 'indicator.gif';
																if($v->Video->image==''){
																	$poster = 'thumb_404.png';
																}
																$poster = BRID_PLUGIN_URL. 'img/'.$poster;
															?>
															<img src="<?php echo $poster; ?>" id="video-img-<?php echo $v->Video->id; ?>"  data-original="<?php echo $v->Video->thumbnail; ?>" class="lazy thumb" width="111px" height="74px" alt="" style="display: inline;">
															<div class="videoPreviewBg" style="display: none;"></div>
															<div class="videoPlay" style="display: none;">
																<img src="<?php echo BRID_PLUGIN_URL; ?>img/small_play.png" style="position:relative; margin-bottom: 3px; width: 24px; height: 24px" alt="">
															</div>
															<?php if($v->Video->external_url!='') { ?>
																<img src="<?php echo BRID_PLUGIN_URL; ?>img/youtube.png" class="youtube_ico" width="22px" height="22px" alt="">
															<?php } ?>
														</div>
														<div class="time" id="video-duration-<?php echo $v->Video->id; ?>"><?php echo self::format_time($v->Video->duration); ?></div>
													</div>
													<?php
														$itemCss = '';
														$linkCss = '';
														if($v->Video->status==0){
															$itemCss = 'turnedoff';
															$linkCss = 'videoTitleDisabled';
														}
													?>
													<div class="titleRow">
														<a href="<?php echo $v->Video->id; ?>" class="listTitleLink <?php echo $linkCss; ?>" id="video-title-<?php echo $v->Video->id; ?>" title="<?php echo $v->Video->name; ?>"><?php echo $v->Video->name; ?></a>
														<div class="videoUploadedBy">
															<div class="siteVideosNum">
																<span class="by">By:</span> <?php echo !empty($v->User->displayname) ? $v->User->displayname : $v->User->username; ?>&nbsp;&nbsp;&nbsp;
																<span class="by">Channel:</span> <?php echo $v->Channel->name; ?>
															</div> 
															<?php if($mode!='playlist') { ?>
															<div class="partner-quick-menu-section">
																<ul class="partner-quick-menu visible" id="partner-options-<?php echo $v->Video->id; ?>">
																	
																	<li class="item <?php echo $itemCss; ?>">
																		<div class="partner-qm-item video-status tooltip" data-controller="videos" data-field="status" data-info="Video status published/paused or pending" data-ajax-loaded="true" data-value="<?php echo $v->Video->status; ?>" data-id="<?php echo $v->Video->id; ?>" data-callback-after="disableVideoTitle"></div>
																	</li>
																	<li  class="item">
																		<div class="partner-qm-item video-quickedit showHidden tooltip" data-info="Quick Edit video" data-ajax-loaded="true" data-open="editVideoDiv" data-callback-before="changeOverText" data-id="<?php echo $v->Video->id; ?>"></div>
																	</li>

																</ul>
															</div> 
															<?php } ?>
														</div>
													</div>
													
													<div class="dateRow" title="Created on:<?php echo $v->Video->created; ?>"><?php echo self::timeFormat($v->Video->created); ?></div>

												</div>
											</div>
											<div class="hiddenContnet" data-id="<?php echo $v->Video->id; ?>">
												<div class="playerDiv" id="playerDiv<?php echo $v->Video->id; ?>">
													<div class="loadingPreviewPlayer">Loading player</div>
													<div class="playerContent brid" id="bridPlayerVideo<?php echo $v->Video->id; ?>"></div>
												</div>
												<div class="editVideoDiv">
													<div id="quickeditvideoform" class="videos formQuick" style="width:100%;float:left;position:relative;">

														<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoEditQuick<?php echo $v->Video->id; ?>" method="post" accept-charset="utf-8">
															<div style="display:none;">
																<input type="hidden" name="_method" value="POST">
															</div>
															<input type="hidden" name="id" value="<?php echo $v->Video->id; ?>" id="VideoId">
															<input type="hidden" name="insert_via" value="<?php echo $v->Video->insert_via; ?>" id="VideoInsertVia">
															<input type="hidden" name="partner_id" value="<?php echo $v->Video->partner_id; ?>" id="VideoPartnerId">
															<input type="hidden" name="action" value="editVideo" class="VideoEdit">

															<table class="quickVideoSaveTable">
																<tbody>
																	<tr style="background:none;">
																		<td colspan="2">
																			<div class="input text required">
																				<input name="name" value="<?php echo $v->Video->name; ?>" placeholder="Video title" maxlength="250" type="text" id="VideoName" required="required"></div>		
																		</td>
																	</tr>
																	<tr style="background:none;">
																		<td colspan="2">
																	
																			<div class="input textarea">
																				<textarea name="description" style="height:82px;" placeholder="Video description" cols="30" rows="6" id="VideoDescription"><?php echo $v->Video->description; ?></textarea>
																			</div>		
																		</td>
																	</tr>
																	<tr style="background:none;">
																		<td colspan="2">
																			<table>
																				<tbody>
																					<tr style="background:none">
																						<td style="width:250px">
																							<div class="input text">
																								<input name="publish" readonly="readonly" id="VideoPublish<?php echo $v->Video->id; ?>" value="<?php echo $v->Video->publish; ?>" default-value="<?php echo $v->Video->publish; ?>" class="datepicker inputField" data-info="Publish on a date." type="text" style="margin-left:-10px">
																							</div>					
																						</td>
																						<td style="padding-left:25px;padding-top:0px">
																							<div class="button saveButton save-video" data-form-id="VideoEditQuick<?php echo $v->Video->id; ?>" id="videoSaveAdd">
																								<div class="buttonLargeContent">SAVE</div>
																							</div>

																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</form>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>


				<?php
							} //foreach
							

				?>
</tbody>
</table>
<div class="pagination">
	<div class="mainWrapper" style="width:834px;">

			<div class="paging">
				<?php if($pagination->pageCount > 1){ ?>
					<span class="first"><a href="#" class="pagination-link" data-page="1" rel="first"> </a></span>
					<span class="prev"><a href="#" class="pagination-link" data-page="<?php echo $pagination->prevPage; ?>" rel="prev"> </a></span>
					<?php
					
					for($i=$pagination->left; $i <= $pagination->right; $i++){

						if($i==$pagination->page){
							?>
								<span class="current"><?php echo $i; ?></span>&nbsp;
							<?php
						}else{
							?>
								<span><a href="#" data-page="<?php echo $i; ?>" class="pagination-link"><?php echo $i; ?></a></span>&nbsp;
							<?php
						}

					}
					?>
					<span class="next"><a href="#" class="pagination-link" data-page="<?php echo $pagination->nextPage; ?>" rel="next"> </a></span>
					<span class="last"><a href="#" class="pagination-link" data-page="<?php echo $pagination->pageCount; ?>" rel="last"> </a></span>
				<?php } ?>
				<div class="pagingInfo">Page <?php echo $pagination->page; ?> of <?php echo $pagination->pageCount; ?>, showing <?php echo $pagination->current; ?> out of <?php echo $pagination->count; ?> total</div>
		
		</div>
	</div>
</div>
<script>
//$pagination->options->order
	//sort:Video.name/direction:asc/page:1
var paginationOrder = '<?php echo $paginationOrder; ?>';

var encodingIds = <?php echo json_encode($videosDataset->Encoding); ?>;

//$Brid.init(['Ping.Encoding']);
//var playlistId = null;
//var quickSave = saveObj.init();	//Init all save buttons in quick edit forms
jQuery(document).ready(function(){

	var save = saveObj.init();


	//Init pagination links
	jQuery(".pagination-link").on("click", function (event) {
		//event.preventDefault();
		if(jQuery(this).attr('data-order')!=undefined)
		{
			paginationOrder = jQuery(this).attr('data-order');
			var order = '';
			if(jQuery(this).hasClass('asc')){
				order = 'desc';
				jQuery(this).removeClass('asc').addClass('desc');

			}else if(jQuery(this).hasClass('desc')){
				order = 'asc';
				jQuery(this).removeClass('desc').addClass('asc');

			}else{
				order = 'asc';
				jQuery(this).addClass('asc');
			}
			
			paginationOrder += order + '/'; 
		}
		
		var page = jQuery(this).attr('data-page');
		var pagination = {data : {action : "videos",subaction:'<?php echo $subaction; ?>', mode : mode, apiQueryParams : paginationOrder+'page:'+page, buttons : buttonsOff}, callback : {after : {name : "insertContent", obj : jQuery("<?php echo $insertIntoContent; ?>")}}};
		
		console.error(mode, playlistType, pagination);

		if(mode=='playlist'){
			pagination.data.playlistType = playlistType;
		}
		$Brid.Api.call(pagination);
		return false;
	});

	jQuery('.close-quick-video-edit').click(function(){
					     var id = jQuery(this).parent().parent().attr('id').replace('quickEditContent-', '');
					    
					     jQuery('#quickEditContent-'+id).fadeOut();
					     jQuery('#partner-options-'+id).removeClass('noHover'); //Ad this to ignore hover effect of quick menu
					});

	//Disable quick icons for Post video screen if buttons are off
	if(buttonsOff){
		jQuery('.partner-quick-menu-section').hide();
	}
	//initBridMain();
	
	// Init animation to show quick edit form or to open preview player
	jQuery('.showHidden').off('click',$Brid.Html.Effect.initAnimation).on('click',$Brid.Html.Effect.initAnimation);

	// Init date picker for quick edit form
	//$Brid.init(['datepicker']); poziva se u initMainFunctions

	//Init delete button
	$Brid.Html.Button.initDelete({buttonId : 'delete-partner', model : 'Video'});

	
	// Init image hover effect
	$Brid.Html.Effect.initImageHover();

	// End control of checkbox dropdown
	jQuery('#checkbox-video-check-all img.checked').hide();


	

	//Set status
	jQuery('.video-status').off('click').on('click', function(e){

		var $self = jQuery(this);

		var currentVal = $self.attr('data-value')==1 ? 0 : 1;
		var controller = $self.attr('data-controller');
		var id = $self.attr('data-id');

		$self.attr('data-value', currentVal);

		if($self.parent().hasClass('turnedoff')){

			$self.parent().removeClass('turnedoff');

		}else{

			$self.parent().addClass('turnedoff');

		}

		$Brid.Api.call({data : {action : "changeStatus", id : id, controller : controller, status : currentVal}, callback : {after : {name : "disableVideoTitle", obj : $self }}});

		//callback : {after : {name : "disableVideoTitle", obj : jQuery("#Videos-content")}}

	});

  	//Edit video //.off('click')
  	jQuery('.listTitleLink').on('click', function(e){

		e.preventDefault();

		if(mode!='playlist'){
			var id = jQuery(this).attr('href');

  			$Brid.Api.call({data : {action : "editVideo", id : id}, callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}});
  		}
  	});

  	//Post video

  	jQuery('#postVideo').click(function(){

  			debug.log('Send short code to textares via id: postVideo');
  			
  			var selectedItems = $Brid.Html.CheckboxElement.getSelectedCheckboxes('video-id-');

  			debug.log('postVideo', selectedItems, selectedItems.length);
  			
  			if(selectedItems.length>0){
  				v = jQuery('.wp-editor-area').val();
  				var shortCodes = '';
  				for(id in selectedItems){
  					shortCodes += '[brid video="'+selectedItems[id]+'" player="'+$BridWordpressConfig.Player.id+'" width="'+$BridWordpressConfig.Player.width+'" height="'+$BridWordpressConfig.Player.height+'"]';
  				}

  				$Brid.Util.addToPost(shortCodes);
  			}

  	});




  		//Init add to playlist button
function addPlaylist() {

	var selectedItems = $Brid.Html.CheckboxElement.getSelectedCheckboxes('video-id-');

	debug.log('Selected Items are:', selectedItems);
	//if(playlistId!=undefined){
		//Add only videos to the already created Playlist (edit mode)
		//itemsAddedToPlaylist
		//callback : {after : {name : "itemsAddedToPlaylist", obj : jQuery("#video-list")}}

		//@todo Neki callback koji ce ako je success dodao da zatvori fancybox

		//$Brid.Api.call({data : {action : "addVideoPlaylist", id : playlistId, ids : selectedItems.join(',')}, callback : {after : {name : "itemsAddedToPlaylist", obj : jQuery("#video-list")}}});
		//playlistId = null;
	//}else{

		//Add Playlist and playlist videos at the same time (add mode)
		jQuery('#addPlaylistVideos').hide();
		jQuery('#addPlaylistForm').fadeIn();
		
		//alert(selectedItems);

		jQuery('#VideoIds').val(selectedItems);
		//If user close Fancybox on "Add Playlist" screen, and he already has selected videos
		//On second Add playlist button click, and he tries to check other checkboxes he would not see Add to playlist button
		//AZ story #208
		var c = $Brid.Html.CheckboxElement.create({name : 'video'});
		c.deselectAll();
		c.toggleTopMenu();
	//}
}
function editPlaylist(){ 
	debug.log('ediPlaylist call');
	
	var selectedItems = $Brid.Html.CheckboxElement.getSelectedCheckboxes('video-id-');

	$Brid.Api.call({data : {action : "addVideoPlaylist", id : playlistId, ids : selectedItems.join(',')}, callback : {after : {name : "itemsAddedToPlaylist", obj : jQuery("#video-list")}}});
		
}
//moze i bolje ovo
jQuery( "#add-to-playlist-" ).off('click', addPlaylist).on('click', addPlaylist);
jQuery( "#add-to-playlist-addPlaylist" ).off('click', addPlaylist).on('click', addPlaylist);
jQuery( "#add-to-playlist-addPlaylistyt" ).off('click', addPlaylist).on('click', addPlaylist);
jQuery( "#add-to-playlist-editPlaylist" ).off('click', editPlaylist).on('click', editPlaylist);


  
});
  </script>
<?php
 } else { 


	if($search==''){

		$link = '<a href="/videos/add" id="add_new_video">add a video</a>';
		if($ask){

			$link = '<a id="add_new_video_2" class="various" data-fancybox-type="ajax" data-action="askQuestion" href="'.admin_url('admin-ajax.php').'">add a video</a>';

		}
	?>

	
	<div class="noItems">
		You haven't added any videos yet. Please <?php echo $link; ?>.
		<script>
			jQuery('.list-items-menu').hide();
			jQuery('#add_new_video').on('click', function(e){
				e.preventDefault();
				$Brid.Api.call({data : {action : "addVideo"}, callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}});
				jQuery.colorbox.close();
			});
		</script>
	</div>

<?php }else{

	?>

	<div class="noItems">
		Your search hasn't returned any results.
	</div>
	<script>
	jQuery('.items-menu').hide();
	</script>
	<?php
	}

}
?>
<script>
//Onclick Tabs
	jQuery(".tab, .tab-inactive").off('click.TabsApiLoad').on("click.TabsApiLoad", function(){
   
   	//"id" : jQuery(this).val(), "callback" : "bridPlayerList"
   	var div = jQuery(this); divId = div.attr("id"), intoDiv = jQuery("#"+divId+'-content');

   		intoDiv.hide();

      $Brid.Api.call({
      					data : {action : divId.toLowerCase(), buttons : buttonsOff}, 
      					callback : {after : {name : "insertContent", obj : intoDiv}}
      				});

      //alert(jQuery(this).attr('id'));
   
  	});
  	//Bind add video and add youtube buttons
  	jQuery('#addVideo, #addYoutube').off('click').on('click', function(){
			jQuery("#Videos-content").hide();
			var id = jQuery(this).attr('id');
			$Brid.Api.call({data : {action : id}, 
                          					callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}
                          				});

		});



</script>