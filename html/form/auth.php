<div class="mainWrapper" style="margin-top:50px; margin-left:40px">
	<a href="https://cms.brid.tv" title="Visit Brid.tv Video Platform" target="_blank"><img src="<?php echo BRID_PLUGIN_URL; ?>img/brid_tv_grey.png" alt="Brid.tv Video Platform"/></a>
	
	<?php
	if($error!=''){
	?>
	<div style="color:#ff0000; padding-top:10px;"><?php echo $error; ?></div>
	<?php } ?>
	<div class="authText">The Brid.tv plugin needs your authorization to access some of your information and usage data. All of this information will be accessed privately using the <a href="http://oauth.net/2/" target="_blank">OAuth 2.0 protocol</a>. We will never store any of your <a href="http://www.brid.tv" target="_blank" title="Brid.tv">Brid.tv</a> credentials (email or password) on this blog.</div>
	                   
	<a href="<?php echo $api->authorizationUrl($redirect_uri); ?>&numVideos=<?php echo $numOfVideos; ?>" title="Authorize This Plugin" style="float:left;height:48px;">
		<div class="bridButton auth-plugin" data-href="#" id="authPlugin" style="margin:0px">
			<div class="buttonLargeContent">AUTHORIZE THIS PLUGIN</div>
		</div>
	</a>
</div>
<script>
jQuery('html').css('background', '#fff');
</script>