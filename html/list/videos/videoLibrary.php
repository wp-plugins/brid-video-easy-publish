<?php
$insertIntoContent = '#Videos-content';
//Playlist mode
if($mode!=''){ 
	$insertIntoContent = '#video-list';
}

?>
<script>
var mode = '<?php echo $mode; ?>'; //playlist mode?
var buttonsOff = '<?php echo $buttonsOff; ?>';
var playlistType = '<?php echo $playlistType; ?>';
</script>
<div class="attachments-browser">
	<div class="media-toolbar">
		<!-- 
		<div class="media-toolbar-secondary">
			<div class="media-toolbar-primary">
				<input type="search" placeholder="Search" class="search">
			</div>
		</div>
	-->
		<div class="media-toolbar-secondary"><!--<div id="site-search-box">-->
			<div class="searchBox search-box" style="margin-left:-7px">
				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
					<div style="display:none;">
						<input type="hidden" name="_method" value="POST">
						<!--<input type="hidden" name="action" value="videoLibraryPost">-->
					</div>
					<div style="width:150px;float:left;padding-top:3px;margin:0px;">
						<div class="input text">
							<input name="data[Video][search]" value="<?php echo $search; ?>" placeholder="Search Videos" class="inputSearch search" autocomplete="off" type="text" id="VideoSearch">

						</div>		
					</div>
					<div class="searchButtonWrapper">
						<div class="searchButton" id="button-search-Partneruser" style="margin-top: 15px;margin-left: -11px;"></div>
					</div>
				</form>
			</div>
			<script>

			//searchObj sent to configure Search
				$Brid.init([['Html.Search', {className : '.inputSearch', view : 1,  action : "videoLibraryPost", after : { name : "insertContentPagination", obj : jQuery("#videoItems")}, model : 'Video', objInto:'videoItems'}]]);
			</script>
		</div>
	</div>
	<div id="videoItems">
		<?php if(!empty($videosDataset->Videos)) { 

					$pagination = $videosDataset->Pagination;

					?>
			<ul class="attachments ui-sortable ui-sortable-disabled" style="overflow:visible">

			<?php foreach($videosDataset->Videos as $k=>$v){ ?>
				<li class="attachment save-ready bridItem" data-video-index="<?php echo $k; ?>">
					<div class="attachment-preview type-video subtype-mp4 landscape" style="width:100%; height:135px">
							
							<?php 
								$poster = $v->Video->thumbnail;
								if($v->Video->thumbnail==''){
									$poster = BRID_PLUGIN_URL. 'img/thumb_404.png';
								}
							?>
							<img src="<?php echo $poster; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;"  class="icon" draggable="false" style="width:100%; height:100%;padding-top:0px">
							<div class="filename">
								<div><?php echo $v->Video->name; ?></div>
							</div>
						

						

						
							<a class="check" href="#" title="Deselect"><div class="media-modal-icon"></div></a>
						
					</div>
					
				</li>

			<?php } ?>
			</ul>
			<div class="pagination" style="position:absolute;right:300px; left:0px; width:auto; bottom:25px;margin-bottom:0px">
				<div class="mainWrapper" style="width:auto">

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
			<?php } ?>

			<!-- SIde bar -->
			<div class="media-sidebar">

				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" method="post" accept-charset="utf-8">

					<input name="id" type="hidden" id="VideoId">
					<input name="channel_id" type="hidden" id="VideoChannelId">
					<input name="partner_id" type="hidden" id="VideoPartnerId">
					<input type="hidden" name="action" value="editVideo">
					<input type="hidden" name="insert_via" id="VideoInsertVia" value="2">

					<div class="attachment-info save-ready" id="bridVideoDetails" style="display:none;">
						
						<div id="video-embed" style="margin-top:10px;"></div>
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
								<textarea name="description"  placeholder="Video description" id="VideoDescription"></textarea>
							</label>
							<label class="setting" data-setting="description">
								<span>Publish date</span>
								<div style="position:relative;z-index:9999;cursor:pointer">
									<input name="publish" readonly="readonly" value="<?php echo date('d-m-Y'); ?>" default-value="<?php echo date('d-m-Y'); ?>" class="datepicker inputField" type="text" id="VideoPublish" style="cursor:pointer">
								</div>
							</label>
							

					</div>
					
			</div>
	</div>
	</form>
<script>
//Video Library post page
var paginationOrder = '';

var encodingIds = <?php echo json_encode($videosDataset->Encoding); ?>;

var brid_video_item = null;

var brid_videos = <?php echo json_encode($videosDataset->Videos); ?>;

var saved = false;
//$Brid.init(['Ping.Encoding']);
//var playlistId = null;
//var quickSave = saveObj.init();	//Init all save buttons in quick edit forms
jQuery(document).ready(function(){

	//var save = saveObj.init();
	jQuery("#videoSaveAdd").unbind('click');
	jQuery('#videoSaveAdd').off('click.AddPostBrid').on('click.PostBrid', function(){

		saved = true;
		if(brid_video_item!=undefined)
		{	
			
			if(checkFormChanges()){
			 		jQuery("#videoSaveAdd").removeAttr('data-method');
		 		 	save.save('VideoAddForm');
		 		}
		 	
		 	$Brid.Util.shortCode(brid_video_item.Video.id, $BridWordpressConfig.Player.id, brid_video_item.Video.name);

			jQuery.colorbox.close();
		}
	});
	
	jQuery('#updateBridItem').off('click.UpdatePostBrid').on('click.UpdatePostBrid', function(){


		if(!jQuery(this).hasClass('disabled')){
			

			if(checkFormChanges()){
		 		jQuery("#videoSaveAdd").removeAttr('data-method');
	 		 	save.save('VideoAddForm',null, 'updateBridItem');
		 	}
		}

	});
	function callSave(){
		if(brid_video_item!=undefined && !saved)
		{	
			 if(!jQuery(this).hasClass('disabled') && !jQuery("#videoSaveAdd").hasClass('inprogress')){

			 	//save changes made to title, desc, publish
			 	if(checkFormChanges()){
			 		jQuery("#videoSaveAdd").removeAttr('data-method');
		 		 	save.save('VideoAddForm');
		 		}
		 		 //onVideoSave callback will add shortcode to post

		 	 }

		}
		
	}

	function checkFormChanges(){

		if(jQuery('#VideoName').val()!=brid_video_item.Video.name){
			return true;
		}
		if(jQuery('#VideoDescription').val()!=brid_video_item.Video.description){
			return true;
		}
		if(jQuery('#VideoPublish').val()!=brid_video_item.Video.publish){
			return true;
		}
		return false;
	}

	document.BridAPIReady = function(){

		var brid = jQuery('#video-embed').find('.brid')
		brid.css('height', '200px');
		var id = brid.attr('id');
		$bp(id).onResize();
	}
	window.bindBridItemClick = function(){

		
		jQuery('.bridItem').on('click', function(){
		var i = jQuery(this);
		document.APIReadyDispatched = false;
		jQuery('.bridItem').removeClass('details selected');

		if(!i.hasClass('selected')){

			i.addClass('details selected');
			var index = i.attr('data-video-index');

			brid_video_item = brid_videos[index];
			jQuery('#videoSaveAdd').removeClass('disabled');
			jQuery('#updateBridItem').removeClass('disabled');
			debug.log('selected index', index);

			jQuery('#bridVideoDetails').show();
			jQuery('.flashFalbackWarring').show();

			//jQuery('#video-embed').css('height', '200px');
			//console.log($Brid.Util.decodeHtml(brid_video_item.Video.embed_code));

			jQuery('#video-embed').html($Brid.Util.decodeHtml(brid_video_item.Video.embed_code));
			
			
			
			jQuery('#VideoId').val(brid_video_item.Video.id);
			jQuery('#VideoName').val(brid_video_item.Video.name);
			jQuery('#VideoDescription').val(brid_video_item.Video.description);
			jQuery('#VideoPublish').val(brid_video_item.Video.publish);
			jQuery('#VideoChannelId').val(brid_video_item.Channel.id);
			jQuery('#VideoInsertVia').val(brid_video_item.Video.insert_via);
			jQuery('#VideoPartnerId').val(brid_video_item.Video.partner_id);

			//jQuery('#video-channel-name').text(brid_video_item.Channel.name);

			jQuery(document).bind('cbox_cleanup', callSave);
			
			//details selected
		}else{

			//jQuery(document).unbind('cbox_cleanup');
			jQuery('#bridVideoDetails').hide();
			jQuery('.flashFalbackWarring').hide();
			i.removeClass('details selected');
			jQuery('#videoSaveAdd').addClass('disabled');
			jQuery('#updateBridItem').addClass('disabled');
			brid_video_item = null;
		}

		debug.log('brid_video_item', brid_video_item);

		});
	}

	window.bindBridPagination = function(){
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
			var pagination = {
				data : {
							action : "videoLibraryPost",
							subaction:'<?php echo $subaction; ?>', 
							mode : mode, 
							view : 0,
							apiQueryParams : paginationOrder+'page:'+page, 
							buttons : buttonsOff
						}, 
				callback : {
								after : { name : "insertContentPagination", obj : jQuery("#videoItems")}
							}
			};
			
			debug.error(mode, playlistType, pagination);

			if(mode=='playlist'){
				pagination.data.playlistType = playlistType;
			}
			$Brid.Api.call(pagination);
			return false;
		});
	}


	bindBridItemClick();
	bindBridPagination();

	initBridMain();

});

</script>