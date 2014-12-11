<div class="mainWrapper">
	<div class="formWrapper" id="userUpload">
		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PartnerUserUploadForm" method="post" accept-charset="utf-8">
			<div style="display:none;">
				<input type="hidden" name="_method" value="POST">
				<input type="hidden" name="action" value="askQuestion">
				<input type="hidden" name="insert_via" value="2">
			</div> 
			<div class="userUploadHeader">WOULD YOU LIKE US TO ENCODE &amp; HOST THE VIDEO FILES FOR YOU?</div>
			<div class="options">
				<input type="hidden" name="upload" class="singleOption" value="1" id="upload">
				<ul class="ul-opitons">
					<li id="upload-1" data-value="1" class="option">
						<img src="<?php echo BRID_PLUGIN_URL; ?>img/option.png" class="option_not_selected" alt="">
						<img src="<?php echo BRID_PLUGIN_URL; ?>img/option_selected.png" class="option_selected" style="display:block;" alt="">
						<span class="optionText">YES</span>
					</li>
					<li id="upload-0" data-value="0" class="option">
						<img src="<?php echo BRID_PLUGIN_URL; ?>img/option.png" class="option_not_selected" alt="">
						<img src="<?php echo BRID_PLUGIN_URL; ?>img/option_selected.png" class="option_selected" alt="">
						<span class="optionText">NO</span>
					</li>
				</ul>
			</div>	
			<div style="clear:both;"></div>
			

		<div class="button saveButton save-partner lightboxSave" id="partnerSaveEdit">
			<div class="buttonLargeContent">SAVE</div></div>

		</form>  
		<div class="userUploadFooter">
			<a href="/pages/terms-conditions" target="_blank">Terms &amp; Conditions</a> apply. If you wish to change this setting at any point or require further assistance <a href="https://brid.zendesk.com/hc/en-us/requests/new" target="_blank">contact support.</a>
		</div>
	</div>
</div>
<script>
var save = saveObj.init();
$Brid.Html.Radio.init();
//jQuery('#PartnerUserUploadForm').submit(function(){return false;});
</script>