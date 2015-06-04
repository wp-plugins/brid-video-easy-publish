<script>
playlistId = <?php echo $playlist_id; ?>;
</script>
<div id="addPlaylistVideos" style="width:880px;">
	<h3 class="lined" style="width:828px; margin-left:15px;"><span>ADD VIDEO TO PLAYLIST</span></h3>
		<div class="mainWrapper"><div class="mainButtonsMenu"></div></div>
	<!-- Top menu start -->

	<!-- Top menu end -->
	<div class="playlist_bp_list_items mainWrapper" id="video-list" style="width:858px;-webkit-overflow-scrolling:touch;overflow-y:auto;"></div>
			
</div>
<!-- JS part -->
<script type="text/javascript">

//Load video list
$Brid.Api.call({data : {action : "videos", mode : 'playlist', subaction : 'editPlaylist', playlistType:'<?php echo $playlistType; ?>'}, callback : {after : {name : "insertContent", obj : jQuery("#video-list")}}});

</script>