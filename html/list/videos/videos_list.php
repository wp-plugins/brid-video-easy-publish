<!-- Used in pagination and search -->
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

				<input name="id" type="hidden" id="VideoId">
				<input name="channel_id" type="hidden" id="VideoChannelId">
				<input name="partner_id" type="hidden" id="VideoPartnerId">
				<input type="hidden" name="action" value="editVideo">
				<input type="hidden" name="insert_via" id="VideoInsertVia">

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
<script>

var encodingIds = <?php echo json_encode($videosDataset->Encoding); ?>;

var brid_video_item = null;

var brid_videos = <?php echo json_encode($videosDataset->Videos); ?>;

</script>