<div class="mainWrapper" style="width:100%;overflow:hidden">
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
				
				<div class="bridButton" id="yesButton">
					<div class="buttonLargeContent">YES</div>
				</div>
				<div class="bridButton" id="noButton">
					<div class="buttonLargeContent">NO</div>
				</div>
			</div>	
			<div style="clear:both;"></div>
			


		</form>  
		<div class="userUploadFooter">
			<a href="/pages/terms-conditions" target="_blank">Terms &amp; Conditions</a> apply. If you wish to change this setting at any point or require further assistance <a href="https://brid.zendesk.com/hc/en-us/requests/new" target="_blank">contact support.</a>
		</div>
	</div>
	
	<div id='uploadRules' style='display:none;width:910px;margin-left:5px;font-color:#000000;min-height:180px' class="formWrapper">
	<h3 class="lined" style='text-transform:uppercase;margin-left:20px;margin-bottom:25px;'><span>Thank you for choosing the Brid.tv FREE PREMIUM plan.</span></h1>
	
	<p style='margin-top:20px;margin-bottom:15px;margin-left:20px;font-size:15px;'>
		Although we maintain the platform to be free, certain requirements must be met if you wish for us to host and encode your videos with us:
	</p>
	<div style='background-color:#f1f2f2;font-size:15px;font-family:Arial;font-weight:bold;color:#000000;padding:20px 0px 10px 20px;margin-bottom:15px;'>
	<ul>
		<li>
			We have a minimum requirement of 5,000 daily click-to-play video views.
		</li>
		<li>
			Large content players are preferred. We consider any player over 400px in width large.
		</li>
		<li>
			We take 40% of ad inventory.
		</li>
		<li>
			Allow up to 2-3 business days for us to approve your PREMIUM account by whitelisting your domain with our ad providers.
		</li>
	</ul>
	</div>
	<?php /*echo $this->element('/html/checkbox', array('id'=>'premiumPlanCheckbox',  'text'=>'Yes, I meet the requirements and want to use Brid.tv\'s PREMIUM plan.','style'=>'top:4px;left:1px;margin-left:20px;margin-bottom:20px;font-size:14px;'));*/ ?>
	
	<div style='clear:both;'></div>
	
	
		<div class="checkboxRow" style='top:5px;margin-bottom:20px;'>
			<div id="checkbox-user_upload" class="bridCheckbox" data-method="toggleTopMenu" data-name="user_upload">
				<div class="checkboxContent" style='margin-right:10px;'>
					<img src="<?php echo BRID_PLUGIN_URL ?>img/checked.png" class="checked" style="display:none" alt="">
					<input type="hidden" name="data[][premiumPlanCheckbox]" class="singleCheckbox" id="premiumPlanCheckbox" data-value="0" style="display:none;">
				</div>
			</div> Yes, I meet the requirements and want to use Brid.tv's PREMIUM plan.
		</div>
	
	<div style='clear:both;'>	</div>
	<div class="bridButton" id="premiumPlanConfirm" style='margin-left:20px;'>
		<div class="buttonLargeContent">CONFIRM</div>
	</div>
	<div class="bridButton" id="premiumPlanCancel">
		<div class="buttonLargeContent">CANCEL</div>
	</div>
	
	<div style='clear:both;margin-bottom:10px;'></div>
	<div style='margin-left:20px;clear:both;'>
		<a style="font-size:14px;font-weight:normal;text-decoration:underline;" target='_blank' href='https://brid.zendesk.com/hc/en-us/articles/202167711'>Read more info on Brid Premium plan.</a> 
		Please also note that we will <span style='font-weight:bold;'>NOT</span> charge you for any bandwidth incurred by using our Premium plan. 
		We will simply reserve the right to monetize 40% of your video inventory.
	</div>
</div>
</div>
<script>
var save = saveObj.init();
$Brid.Html.CheckboxElement.init();
//$Brid.Html.Radio.init();
//jQuery('#PartnerUserUploadForm').submit(function(){return false;});
(function($){ 
$('#userUpload .bridButton,#uploadRules .bridButton').click(function(){
							var idButton = $(this).attr('id'),formData = {};
							$(this).addClass('disabled');
							var object = {
				                    dataType : 'json',
				                    data : {action : "bridPremium"}, 
				                    callback : { after : { name : "setPremium"} }
									};
				
							if(idButton == 'yesButton'){
								$('#userUpload').hide();
								$('#uploadRules').show();
						
								$.colorbox.resize();
								}
							else if(idButton == 'noButton' || idButton == 'premiumPlanCancel'){
								formData.premium = 0;
								}
							else if(idButton == 'premiumPlanConfirm'){
								if( $('#premiumPlanCheckbox').attr('value') != 1){
										alert('Requirements not confirmed. Please check the requirement checkbox.');
										$(this).removeClass('disabled');
									}
								else {						
									formData.premium = 1;
								}
							}
							else return;
							if(typeof formData.premium != 'undefined' ){
								object.data.premium = formData.premium;
						        $Brid.Api.call(object);
						    	
							}
						});
})(jQuery);
</script>