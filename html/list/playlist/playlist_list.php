<!-- Used in playlist pagination and search for playlist search -->
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
								$poster = $v->Video[0]->image;;
								if($v->Video[0]->image==''){
									$poster = BRID_PLUGIN_URL. 'img/thumb_404.png';
								}
							}
							?>
						<img src="<?php echo $poster; ?>" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" class="icon" draggable="false" style="width:100%; height:100%;padding-top:0px">
						<div class="filename" style="z-index:2;">
								<div><?php echo $v->Playlist->name; ?></div>
							</div>
						
							<a class="check" href="#" title="Deselect"><div class="media-modal-icon"></div></a>

							<div class="playlist_preview" style="top:0px;right:0px;bottom:0px;height:auto;z-index:1;">
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

			<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="VideoAddForm" style="display:none" method="post" accept-charset="utf-8">

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
<script>


var brid_video_item = null;


</script>