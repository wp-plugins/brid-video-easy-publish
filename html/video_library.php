<div class="media-frame wp-core-ui" id="__wp-uploader-id-128228282889">
					<div class="media-frame-menu">
						<div class="media-menu">
							<a href="#" class="media-menu-item active media-brid-action" data-action="video_library">Manage videos</a>
							<a href="#" class="media-menu-item media-brid-action" data-action="playlist_library">Manage playlists</a>
							<!--<a href="#" class="media-menu-item media-brid-action" data-action="widget_library">Post widget</a>-->
							<div class="separator"></div>
							<!--
							<a href="#" class="media-menu-item">How to monetize Youtube video?</a>
							<a href="#" class="media-menu-item">Is there any custom skin available?</a>
							-->
						</div>
					</div>
					<div class="media-frame-title"><h1>Post Video</h1></div>
					<div class="media-frame-router">
						<div class="media-router">
							<a href="#" data-id="addVideoPost" class="media-menu-item active">Add Video</a>
							<?php if($upload){ ?>
							<a href="#" data-id="uploadVideoPost" class="media-menu-item">Upload Video</a>
							<?php } ?>
							<a href="#" data-id="addYoutubePost" class="media-menu-item">Add Youtube</a>
							<a href="#" data-id="videoLibraryPost" class="media-menu-item">Video Library</a>
						</div>
					</div>
					<span class="spinner" id="bridSpin" style="display: none;top: 50%; position: absolute;left: 50%;z-index: 9999999;"></span>
					<div class="media-frame-content" id="brid-content">
						<?php echo BridQuickPost::addVideoPost(true); ?>
						
	
					</div>
					

					<div class="media-frame-toolbar">
						<div class="media-toolbar">
							<div class="media-toolbar-secondary">
								<div class="media-selection empty">
									<div class="selection-info">
											<span class="count">0 selected</span>
											<a class="edit-selection" href="#">Edit</a>
											<a class="clear-selection" href="#">Clear</a>
			
									</div>
									<div class="selection-view">
										<ul class="attachments ui-sortable" id="__attachments-view-73"></ul>
									</div>
								</div>
							</div>
							<div class="media-toolbar-primary">
								<div class="mainWrapper" style='padding-top:0px;width:auto'>
									

									<div class="bridButton saveButton disabled" id="videoSaveAdd" data-method="onVideoSave" data-form-bind="0" data-form-req="0" style="position: absolute; right: 20px; top: 5px;">
										<div class="buttonLargeContent" id="videoSaveAddText">POST</div>
									</div>

									<div class="bridButton saveButton disabled" data-redirect="off" data-colorbox-close="0" id="updateBridItem" data-method="onVideoUpdate" data-form-bind="0" data-form-req="0" style="position: absolute; right: 120px; top: 5px; display:none;">
										<div class="buttonLargeContent" id="videoSaveAddText">UPDATE</div>
									</div>
								</div>
							</div>
						</div>
					</div>
</div>
<script>

$Brid.Html.QuickLibrary.init();
$Brid.Html.PostVideo.init();
</script>

