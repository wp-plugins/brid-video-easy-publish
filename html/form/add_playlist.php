<div id="addPlaylistVideos">
	<h3 class="lined" style="width:828px; margin-left:15px;"><span>ADD VIDEO TO PLAYLIST</span></h3>
		<div class="mainWrapper"><div class="mainButtonsMenu"></div></div>
	<!-- Top menu start -->

	<!-- Top menu end -->
	<div class="playlist_bp_list_items mainWrapper" id="video-list" style="width:858px;-webkit-overflow-scrolling:touch;overflow-y:auto;"></div>
			
</div>

<div class="mainWrapper">
	<!-- Form part -->
	<div class="users form" id="addPlaylistForm">
		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PlaylistAddForm" onsubmit="event.returnValue = false; return false;" method="post" accept-charset="utf-8">
			<div style="display:none;">
				<input type="hidden" name="_method" value="POST">
			</div> 	

			<div class="formWrapper">

		       <h3 class="lined"><span>ADD PLAYLIST</span></h3>
		        <div id="mainDataLight">
		        	<table>
		        		<tbody>
		        			<tr>
			        			<td> 
					        		<input type="hidden" name="action" value="addPlaylist">
					        		<input type="hidden" name="insert_via" value="2">
					        		<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
									<input type="hidden" name="user_id" value="<?php echo BridOptions::getOption('user_id'); ?>">
					        		<input type="hidden" name="ids" id="VideoIds">
					        		<input type="hidden" name="submit" value="1" id="PlaylistSubmit">
					        		<div class="input text required">
					        			<input name="name" id="PlaylistNameId" data-info="Playlist name" default-value="Enter playlist name" maxlength="250" type="text" required="required">
					        		</div>        			
			        			</td>
		        			</tr>
		        			<tr>
		        			<td> 
		        			 

		<div class="button saveButton dsiabled lightboxSave" data-form-id="PlaylistAddForm" id="playlistSaveAdd1">
			<div class="buttonLargeContent">SAVE</div></div>

			

		        			</td>
		        	</tr>
				   </tbody></table>
		   		</div>
		   	        		
		 </div>
		</form>
	</div>
</div>
<!-- JS part -->
<script type="text/javascript">
var playlistType = '<?php echo $playlistType; ?>';
//Load video list
$Brid.Api.call({data : {action : "videos", playlistType : playlistType, mode : 'playlist', subaction : 'addPlaylist'+'<?php echo $videoType; ?>'}, callback : {after : {name : "insertContent", obj : jQuery("#video-list")}}});

//Execute save on enter
jQuery('#PlaylistNameId').keypress(function(e){
    if (e.which == 13){
    	var save = saveObj.init();
    	save.save('PlaylistAddForm');
    }
});

jQuery('#addPlaylistVideos #VideoIndexForm').submit(function(){return false;});


</script>