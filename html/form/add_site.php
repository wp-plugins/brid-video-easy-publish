<div class="mainWrapper">
	<div class="users form" style='width:829px;margin-top:34px;margin-left:38px;'>
	 <form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PartnerAddForm" method="post" accept-charset="utf-8">
		    <div class="formWrapper" id='addWebsite' style='margin:0px;'>
		    		 <h3><span>ADD WEBSITE</span></h3>
		    		 <div id="mainDataLight" style='width:790px;margin-top:12px;'>
					    <table>
					    	<tr>
					    		<td style="width:311px;">
					    			<input type="hidden" name="action" value="addPartner">
					        		<input type="hidden" name="insert_via" value="2">
					    			<div class="input text required">
					    				<input name="domain" data-info="Add your domain or subdomain. &lt;br/&gt;Example:&lt;br/&gt;Domain: http://www.brid.tv" style="text-indent:70px;" maxlength="150" type="text" id="PartnerDomain" required="required" data-ajax-loaded="true" aria-describedby="ui-tooltip-1">
									</div>
								</td>
					    	</tr>
					    	<tr>
					    		<td>
									   

									<div class="button save-setting saveButton lightboxSave disabled" data-form-req="0" data-form-bind="0" data-method="partnerCreateSnapshot" id="SaveButtonLarge" style="opacity: 1;">
										<div class="buttonLargeContent">SAVE</div>
									</div>

								</td>
					    		
					    	</tr>
					    </table>
				    </div>
			</div>
		 </form>
	</div>
</div>
<script>
//jQuery('#PartnerAddForm').submit(function(){jQuery('#partnerSaveAdd').click();return false;});

jQuery(document).ready(function(){

	var save = saveObj.init();

	var divParent = jQuery('#PartnerDomain').parent();
	jQuery(divParent).prepend('<span class="partnerAddSiteSpan required">http://</span>');
	jQuery('#PartnerDomain').on('keyup',function(e){
						var $buttonVerify = jQuery('#partnerVerify');
						var val = jQuery(this).val();
						var httpPattern = /^http:\/\//;
						var urlPattern = /^((https?|ftp):\/\/|(www|ftp)\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+([/?].*)?$/;
						if($buttonVerify.length == 0){
							$buttonVerify = jQuery('#SaveButtonLarge');
						}
						if(e.which==13){
							$buttonVerify.click();
							return;
						}
						if(val.length>0) {
							if(val.match(httpPattern) === null){
								val = 'http://'+val;
							}
							
							if(val.match(urlPattern) === null){
								if(!$buttonVerify.hasClass('disabled')){
									$buttonVerify.addClass('disabled');
								}
								return;
							}

							if($buttonVerify.hasClass('disabled')){
								$buttonVerify.removeClass('disabled');
							}
		
						}
				});

	jQuery('.saveButton').click(function(){ 
		var $thisObject = jQuery(this);

		if(!$thisObject.hasClass('disabled') && !$thisObject.hasClass('inprogress')){
		
			$thisObject.addClass('inprogress');
			 save.save('PartnerAddForm');
		 }else{
			//Is save in progress?
			if($thisObject.hasClass('inprogress')){
				$Brid.Util.openDialog('Save error', 'Save already in progress');
				return;
			}
			$Brid.Html.Form.checkPartnersSave();
		 }
	});
});
</script>