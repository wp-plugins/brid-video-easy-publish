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
				$Brid.init([['Html.Search', {className : '.inputSearch', view : 1, playlistType : <?php echo $playlistType;?>,  action : "addPlaylistPost", after : { name : "insertContentPaginationPlaylist", obj : jQuery("#videoItems")}, model : 'Video', objInto:'videoItems'}]]);
			</script>
		</div>
	</div>
	<div id="videoItems">
		<?php if(!empty($videosDataset->Videos)) { 

					$pagination = $videosDataset->Pagination;

					?>
			<ul class="attachments ui-sortable ui-sortable-disabled" style="overflow:visible">

			<?php foreach($videosDataset->Videos as $k=>$v){ ?>
				<li class="attachment save-ready bridItem" data-video-index="<?php echo $k; ?>" id="brid-video-item-<?php echo $v->Video->id;?>">
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

					<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
					<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
	        		<input type="hidden" name="ids" id="VideoIds">
					<input type="hidden" name="action" value="addPlaylist">
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

var encodingIds = <?php echo json_encode($videosDataset->Encoding); ?>;

var brid_video_item = null;

var brid_videos = <?php echo json_encode($videosDataset->Videos); ?>;

var saved = false;
//Init save object
//enableSave();
//$Brid.init(['Ping.Encoding']);
//var playlistId = null;
//var quickSave = saveObj.init();	//Init all save buttons in quick edit forms
//jQuery(document).ready(function(){

	jQuery('#playlistSaveAdd').off('click.AddPlaylistPostBrid').on('click.AddPlaylistPostBrid', function(){

		if(jQuery('#playlistSaveAdd').hasClass('disabled') && selectedVideos.length==0)
		{

			alert("Please enter Playlist title and select videos first");

		}else{
			saved = true;
			save.save('VideoAddForm');
		}

	});

	jQuery('#VideoAddForm').on("keyup keypress", function(e) {
	  var code = e.keyCode || e.which; 
	  if (code  == 13) {               
	    e.preventDefault();
	    return false;
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

			document.APIReadyDispatched = false;
		var i = jQuery(this);
		
		//jQuery('.bridItem').removeClass('details selected');
		var index = i.attr('data-video-index');
		brid_video_item = brid_videos[index];

		if(!i.hasClass('selected')){

			i.addClass('details selected');
			
			//jQuery('#playlistSaveAdd').removeClass('disabled');
			debug.log('selected index', index);

			jQuery('#bridVideoDetails').show();
			jQuery('.flashFalbackWarring').show();

			jQuery('#video-embed').html($Brid.Util.decodeHtml(brid_video_item.Video.embed_code));
			//jQuery(document).bind('cbox_cleanup', callSave);

			selectedVideos[brid_video_item.Video.id] = brid_video_item.Video;
			
			//details selected
		}else{

			delete(selectedVideos[brid_video_item.Video.id]);
			jQuery('.flashFalbackWarring').hide();
			i.removeClass('details selected');
			jQuery('#playlistSaveAdd').addClass('disabled');
			brid_video_item = null;

		}

		//console.log('brid_video_item', brid_video_item);
		//console.log('selectedVideos', selectedVideos);

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
			checkEnableSavePlaylist();
			
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
							action : "addPlaylistPost",
							subaction:'<?php echo $subaction; ?>', 
							mode : mode, 
							playlistType : playlistType,
							view : 0,
							apiQueryParams : paginationOrder+'page:'+page, 
							buttons : buttonsOff
						}, 
				callback : {
								after : { name : "insertContentPaginationPlaylist", obj : jQuery("#videoItems")}
							}
			};
			
			debug.log(mode, playlistType, pagination);

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
//Check can we enable save button
window.checkEnableSavePlaylist = function(){

	var playlistName = jQuery('#PlaylistName').val(), videos = jQuery('#VideoIds').val();
	debug.log('checkEnableSavePlaylist', playlistName, videos);
	if(playlistName!='' && videos!=''){
		jQuery('#playlistSaveAdd').removeClass('disabled');
	}else{
		jQuery('#playlistSaveAdd').addClass('disabled');
	}
}
//Clear selected items in playlist
function clearSelectedVideos(){
	jQuery('.bridItem').removeClass('details selected');
	selectedVideos = new Array();
	initSelected();
	checkEnableSavePlaylist();
}
//Set csv ids in hidden input for selected items
function setSlectedVideos(){

	var a = [];
	for(var k in selectedVideos){

		a.push(selectedVideos[k].id);

	}
	jQuery('#VideoIds').val(a.join(','));
	checkEnableSavePlaylist();

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