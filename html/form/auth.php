<div class="mainWrapper" style="margin-top:50px; margin-left:40px">
	<a href="http://cms.brid.tv" title="Visit Brid.tv Video Platform"><img src="<?php echo BRID_PLUGIN_URL; ?>img/brid_tv_grey.png" alt="Brid.tv Video Platform"/></a>
	
	<?php
	if($error!=''){
	?>
	<div style="color:#ff0000; padding-top:10px;"><?php echo $error; ?></div>
	<?php } ?>
	<div class="authText">The Brid.tv plugin needs your authorization to access some of your information and usage data. All of this information will be accessed privately using the <a href="http://oauth.net/2/">OAuth 2.0 protocol</a>. We will never store any of your <a href="http://www.brid.tv" title="Brid.tv">Brid.tv</a> credentials (email or password) on this blog.</div>
	                   
	<a href="<?php echo $api->authorizationUrl($redirect_uri); ?>" title="Authorize This Plugin">
		<div class="button auth-plugin" data-href="#" id="authPlugin">
			<div class="buttonLargeContent">AUTHORIZE THIS PLUGIN</div>
		</div>
	</a>
</div>