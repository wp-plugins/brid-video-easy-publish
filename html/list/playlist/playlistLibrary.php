<!-- Create Playlist form Post -->
<script>
var mode = '<?php echo $mode; ?>'; //playlist mode?
var buttonsOff = '<?php echo $buttonsOff; ?>';
var playlistType = '<?php echo $playlistType; ?>';
</script>
<div class="attachments-browser">
	<div class="media-toolbar">
		<div class="media-toolbar-secondary"><!--<div id="site-search-box">-->
			<div class="searchBox search-box" style="margin-left:-7px">
				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoIndexForm" data-loadintodivclass="bp_list_items" method="post" accept-charset="utf-8">
					<div style="display:none;">
						<input type="hidden" name="_method" value="POST">
						<!--<input type="hidden" name="action" value="videoLibraryPost">-->
					</div>
					<div style="width:150px;float:left;padding-top:3px;margin:0px;">
						<div class="input text">
							<input name="data[Playlist][search]" value="<?php echo $search; ?>" placeholder="Search Playlists" class="inputSearch search" autocomplete="off" type="text" id="PlaylistSearch">

						</div>		
					</div>
					<div class="searchButtonWrapper">
						<div class="searchButton" id="button-search-Partneruser" style="margin-top: 15px;margin-left: -11px;"></div>
					</div>
				</form>
			</div>
			<script>

			//searchObj sent to configure Search
				$Brid.init([['Html.Search', {className : '.inputSearch', view : 1, action : "playlistLibraryPost", after : { name : "insertContentPaginationPlaylist", obj : jQuery("#videoItems")}, model : 'Playlist', objInto:'videoItems'}]]);
			</script>
		</div>
	</div>
	<div id="videoItems">
		<?php if(!empty($playlists->Playlists)) { 

					$pagination = $playlists->Pagination;

					?>
			<ul class="attachments ui-sortable ui-sortable-disabled" style="overflow:visible">

			<?php foreach($playlists->Playlists as $k=>$v){ ?>
				<li class="attachment save-ready bridItem" data-video-index="<?php echo $k; ?>" id="brid-video-item-<?php echo $v->Playlist->id;?>">
					<div class="attachment-preview type-video subtype-mp4 landscape" style="width:100%; height:135px">
							<?php 
							$poster = BRID_PLUGIN_URL. 'img/thumb_404.png';
							if(isset($v->Video) && !empty($v->Video)){
								$poster = $v->Video[0]->image;
								if($v->Video[0]->image==''){
									$poster = BRID_PLUGIN_URL. 'img/thumb_404.png';
								}
							}
							?>
							<img src="<?php echo $poster; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;"  class="icon" draggable="false" style="width:100%; height:100%;padding-top:0px">
							<div class="filename" style="z-index:2;">
								<div><?php echo $v->Playlist->name; ?></div>
							</div>
						
							<a class="check" href="#" title="Deselect"><div class="media-modal-icon"></div></a>

							<div class="playlist_preview" style="top:0px;right:0px;bottom:28px;height:auto;z-index:1;">
											<div class="playlist_preview_wrapper" style="bottom:0px;height:auto;"></div>
											<div class="playlist_count"><?php echo count($v->Video); ?></div>
											<div class="playlist_count_text">videos</div>
											<div class="playlist_preview_images" style="top:38px;">
												<?php foreach($v->Video as $key=>$video){ 
													if($key>1) break;
												?>
												<div class="preview_youtube_img_small" style="position:relative;">
													<?php

													if($video->thumbnail!=''){
														$firstSnapshotSmall = BridHtml::getPath(array('type'=>'thumb', 'id'=>$video->partner_id)).$video->thumbnail;
													}else{
														$firstSnapshotSmall = BRID_PLUGIN_URL."img/thumb_404.png";
													}

													?>
													<img src="<?php echo $firstSnapshotSmall ?>" width="29px" height="15px" border="0">
												</div>
												<?php } ?>
											</div>
										</div>
						
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

				<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" style="display:none;" method="post" accept-charset="utf-8">

					<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
					<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
					<input type="hidden" name="id" id="PlaylistId">
					<input type="hidden" name="action" value="editPlaylist">
					<input type="hidden" name="playlistType" value="<?php echo $playlistType;?>">
					<input type="hidden" name="insert_via" id="VideoInsertVia" value="2">

					<div class="attachment-info save-ready" id="bridVideoDetails" style="display:block;">
						
						<div id="video-embed" style="margin-top:10px;"></div>
						<h3>
							Playlist Details
							<span class="settings-save-status">
								<span class="spinner"></span>
								<span class="saved" style="display:none;">Saved.</span>
							</span>
						</h3>
						<div class="separator" style="border-bottom: 1px solid #ddd;margin-bottom:10px;"></div>

							<label class="setting" data-setting="title">
								<span>Playlist Title</span>
									<input name="name" maxlength="250" type="text" placeholder="Playlist title" id="PlaylistName" required="required">
							</label>
							

					</div>
					
				</form>
			</div>
	</div>
	
</div>
<script>
//$pagination->options->order
	//sort:Video.name/direction:asc/page:1
var paginationOrder = '';

var brid_playlist_item = null;

var brid_playlists = <?php echo json_encode($playlists->Playlists); ?>;

var saved = false;
//Init save object
//enableSave();
//$Brid.init(['Ping.Encoding']);
//var playlistId = null;
//var quickSave = saveObj.init();	//Init all save buttons in quick edit forms
//jQuery(document).ready(function(){

	
	//var save = saveObj.init();

	jQuery('#playlistSaveAdd').off('click.AddPlaylistPostBrid').on('click.AddPlaylistPostBrid', function(){
		saved = true;
		if(brid_playlist_item!=undefined)
		{
		 	save.save('VideoAddForm');
		 }
		 	
	});

	jQuery('#updateBridItem').off('click.UpdatePlaylistBrid').on('click.UpdatePlaylistBrid', function(){


		if(!jQuery(this).hasClass('disabled')){
			

			//if(checkFormChanges()){
		 		jQuery("#videoSaveAdd").removeAttr('data-method');
	 		 	save.save('VideoAddForm',null, 'updateBridItem');
		 	//}
		}
		 	
	});
	
	document.BridAPIReady = function(){

		var brid = jQuery('#video-embed').find('.brid')
		brid.css('height', '200px');
		var id = brid.attr('id');
		$bp(id).onResize();
	}
	window.bindBridPlaylistItemClick = function(){

		jQuery('.bridItem').on('click', function(){
		var i = jQuery(this);
		document.APIReadyDispatched = false;
		jQuery('.bridItem').removeClass('details selected');
		
		var index = i.attr('data-video-index');
		brid_playlist_item = brid_playlists[index];

		if(!i.hasClass('selected')){

			i.addClass('details selected');
			
			jQuery('#playlistSaveAdd').removeClass('disabled');
			//console.log('selected index', index);

			jQuery('#bridVideoDetails').show();
			jQuery('.flashFalbackWarring').show();

			debug.log('Playlist', brid_playlist_item);

			//jQuery('#video-embed').html($Brid.Util.decodeHtml(brid_playlist_item.Video.embed_code));
			jQuery('#PlaylistName').val(brid_playlist_item.Playlist.name);
			//alert(brid_playlist_item.Playlist.id);
			jQuery('#PlaylistId').val(brid_playlist_item.Playlist.id);
			jQuery('#updateBridItem').removeClass('disabled');
			jQuery('#VideoAddForm').css('display', 'block');
			//jQuery(document).bind('cbox_cleanup', callSave);

			//selectedVideos[brid_video_item.Video.id] = brid_video_item.Video;
			
			//details selected
		}else{

			//delete(selectedVideos[brid_video_item.Video.id]);
			//jQuery(document).unbind('cbox_cleanup');
			//jQuery('#bridVideoDetails').hide();
			jQuery('.flashFalbackWarring').hide();
			i.removeClass('details selected');
			jQuery('#playlistSaveAdd').addClass('disabled');
			jQuery('#updateBridItem').addClass('disabled');
			brid_playlist_item = null;

		}

		debug.log('brid_video_item', brid_video_item);
		debug.log('selectedVideos', selectedVideos);

		initSelected();

		});
	}
	//Set playlist name
	window.bindPlaylistTitle = function(){
		var playlistName = jQuery('#PlaylistName');
		if(playlistTitle!=''){
			playlistName.val(playlistTitle);
		}

		playlistName.input(function(){

			playlistTitle = playlistName.val();
			if(playlistTitle!=''){
				jQuery('#playlistSaveAdd').removeClass('disabled');
			}else{
				jQuery('#playlistSaveAdd').addClass('disabled');
			}
			
		});

	}
	//Pagination links
	window.bindBridPlaylistPagination = function(){

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
							action : "playlistLibraryPost",
							subaction:'<?php echo $subaction; ?>', 
							mode : mode, 
							view : 0,
							apiQueryParams : paginationOrder+'page:'+page, 
							buttons : buttonsOff
						}, 
				callback : {
								after : { name : "insertContentPaginationPlaylist", obj : jQuery("#videoItems")}
							}
			};
			
			if(mode=='playlist'){
				pagination.data.playlistType = playlistType;
			}
			$Brid.Api.call(pagination);
			return false;
		});
	}

	bindBridPlaylistItemClick();
	bindBridPlaylistPagination();
	bindPlaylistTitle();
	initBridMain();
	
	

//});
//Clear selected items in playlist
function clearSelectedVideos(){
	jQuery('.bridItem').removeClass('details selected');
	selectedVideos = new Array();
	initSelected();
}
//Set csv ids in hidden input for selected items
function setSlectedVideos(){

	var a = [];
	for(var k in selectedVideos){

		a.push(selectedVideos[k].id);

	}
	jQuery('#VideoIds').val(a.join(','));

}
//Init seleted mark them selected
function initSelected(){
	var i = 0;
	for(var k in selectedVideos){

		//console.log('selectedVideos-aaa', selectedVideos[k].id, selectedVideos);

		jQuery('#brid-video-item-'+selectedVideos[k].id).addClass('details selected');
		i++;

	}

	jQuery('.count').html(i+' selected');
	setSlectedVideos();
}
initSelected();


</script>