<div class="media-frame wp-core-ui" id="__wp-uploader-id-12822828287779">
					<div class="media-frame-menu">
						<div class="media-menu">
							<a href="#" class="media-menu-item media-brid-action" data-action="video_library">Manage videos</a>
							<a href="#" class="media-menu-item media-brid-action active" data-action="playlist_library">Manage playlists</a>
							<div class="separator"></div>
							<!--
							<a href="#" class="media-menu-item">How to monetize Youtube video?</a>
							<a href="#" class="media-menu-item">Is there any custom skin available?</a>
							-->
						</div>
					</div>
					<div class="media-frame-title"><h1>Post Playlist</h1></div>
					<div class="media-frame-router">
						<div class="media-router">
							<a href="#" data-id="addPlaylistPost" data-playlistType="0" class="media-menu-item active">Add Playlist</a>
							<a href="#" data-id="addPlaylistPost" data-playlistType="1"  class="media-menu-item">Add Youtube Playlist</a>
							<a href="#" data-id="playlistLibraryPost" class="media-menu-item">Playlist Library</a>
						</div>
					</div>
					<span class="spinner" id="bridSpin" style="display: none;top: 50%; position: absolute;left: 50%;z-index: 9999999;"></span>
					
					<div class="media-frame-content" id="brid-content">
						<?php echo BridQuickPost::addPlaylistPost(true); ?>
					</div>
					
					<div class="media-frame-toolbar">
						<div class="media-toolbar">
							<div class="media-toolbar-secondary">
								<div class="media-selection" id="bridSelected">
									<div class="selection-info">
											<span class="count">0 selected</span>
											<!--
												<a class="edit-selection" href="#">Edit</a>
												-->
												<a class="clear-selection" href="javascript:clearSelectedVideos()">Clear</a>
											
			
									</div>
									<div class="selection-view">
										<ul class="attachments ui-sortable" id="__attachments-view-73"></ul>
									</div>
								</div>
							</div>
							<div class="media-toolbar-primary">
								<div class="mainWrapper" style='padding-top:0px;width:auto'>
									<div class="bridButton disabled" data-redirect="off" data-colorbox-close="0" id="updateBridItem" data-method="onPlaylistUpdate" data-form-bind="0" data-form-req="0" style="position: absolute; right: 120px; top: 5px; display:none;">
										<div class="buttonLargeContent" id="videoSaveAddText">UPDATE</div>
									</div>
									<div class="bridButton saveButton disabled" id="playlistSaveAdd" data-method="onPlaylistSave" data-form-bind="0" data-form-req="0" style="position: absolute; right: 20px; top: 5px;">
										<div class="buttonLargeContent" id="videoSaveAddText">POST</div>
									</div>
								</div>
							</div>
						</div>
					</div>
</div>
