<script>
$BridWordpressConfig = {};
$BridWordpressConfig.pluginUrl = '<?php echo BRID_PLUGIN_URL; ?>';
var currentDivView = 'Videos-content';
</script>
<div class="mainWrapper" style='padding-top:10px;'>
	<?php if(!$partner->Partner->upload){  ?>
	<div  class="planUpgrade various" id="videoQuestion" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>">
		Upgrade <div id="upgradeStar"></div></div>
	<script>jQuery('#videoQuestion').colorbox({innerWidth:920, innerHeight:210});</script>
	<?php
		 } 
	?>
	<!-- Tabs start -->	
	
	<div style="width:858px; padding-top:10px; overflow:hidden;" class="tabs withArrow" id="libraryTabs">
		<div id="Videos" class="tab" style="width: 428px;">VIDEOS</div>
		<div id="Playlists" class="tab-inactive" style="margin-right: 0px; width: 428px;">PLAYLISTS</div>
	</div>
	<!-- Tabs end -->

	<!-- videos tab start -->
	<div id="Videos-content"></div>
	<!-- videos tab end -->


	<!-- Playlists tab start -->
	<div id="Playlists-content" style="display:none;"></div>
	<!-- Playlists tab end -->
	<script>
	//Used in global contentRefresh function @see default.ctp or default.js
	
	//var quickSave = saveObj.init();	//Init all save buttons in quick edit forms
	jQuery(document).ready(function(){

		$Brid.init(['Html.Tabs']);
		//Inital load videos page

      	$Brid.Api.call({data : {action : "videos"}, callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}});

      	jQuery('#wpbody-content').css('float','none');
      	jQuery('html').css('background','none'); //html{background:#f1f1f1}

	});
	
	</script>
</div>
