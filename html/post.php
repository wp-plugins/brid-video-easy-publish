<script>
$BridWordpressConfig = {};
$BridWordpressConfig.pluginUrl = '<?php echo BRID_PLUGIN_URL; ?>';
$BridWordpressConfig.Player = <?php echo $playerSettings; ?>;
var currentDivView = 'Videos-content';
</script>
<div class="mainWrapper postTabs">

	<!-- Tabs start -->
	<div style="width:862px; overflow:hidden;" class="tabs withArrow" id="postTabs">
		<div id="Videos" class="tab" style="margin-right: 0px;">VIDEOS</div>
		<div id="Playlists" class="tab-inactive" style="margin-right: 0px;">PLAYLISTS</div>
		<div id="Dynamics" class="tab-inactive" style="margin-right: 0px;">DYNAMIC PLAYLISTS</div>
	</div>
	<!-- Tabs end -->

	<!-- videos tab start -->
	<div id="Videos-content"></div>
	<!-- videos tab end -->


	<!-- Playlists tab start -->
	<div id="Playlists-content" style="display:none;"></div>
	<!-- Playlists tab end -->
	

	<!-- Playlists tab start -->
	<div id="Dynamics-content" style="display:none;"></div>
	<script>

	//Used in global contentRefresh function @see default.ctp or default.js
	
	//var quickSave = saveObj.init();	//Init all save buttons in quick edit forms
	jQuery(document).ready(function(){

		$Brid.init(['Html.Tabs']);
		//Inital load videos page
      	$Brid.Api.call({data : {action : "videos", buttons : 'off'}, callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}});
  
	});
		
	</script>
</div>
