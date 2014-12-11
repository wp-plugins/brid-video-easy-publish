<form class="form" action="#">
	<div class="mainWrapper">

		<div class="mainButtonsMenu" style="text-align:right; position:absolute;">
			<div class="button post-playlist" data-href="#" id="postPlaylistDynamic" style="margin-right:40px;">
				<div class="buttonLargeContent">POST</div>
			</div>
		</div>

		<table  style="padding-left:20px; padding-top:20px;">
			<tr>
				<td style="width:200px;">
					<div class="dynamicPlaylist">
						<div class="input"><label style="left:0px;">Post dynamic</label></div>
						<div class="divAsRow blueEmbedInside" id="chooseTypeEmbedCode" style="margin-top:10px;">
							<select name="data[Embeds][type_id]" class="dropdownMenu dropdown" data-method="toggleEmbedCodeType" data-css='{"height":115, "width":150}' id="EmbedsTypeId" style="display: none;">
								<option value="latest">By latest on site</option>
								<option value="channel">By channel</option>
								<option value="tag">By tag</option>
								<!--  <option value="source">By source</option> -->
							</select>
						</div>
					</div>
				</td>
				<td style="width:145px;">
					<div class="input text">
						<label for="EmbedsItems">Items</label>
						
							<input name="data[Embeds][items]" default-value="10" style="width:100px" value="10" max="100" min="1" data-into="playlist" data-info="Number of items to display." id="EmbedsItems" data-ajax-loaded="true">
						
					</div>
				</td>
				<td style="width:200px;">
					<div class="dynamicPlaylist"> 
						<div class="input"><label style="left:0px;">Choose video type</label></div>
							<div class="divAsRow blueEmbedInside" id="chooseVideoTypeEmbedCode" style="margin-top:10px;">
								<select name="data[Embeds][video_type_id]" class="dropdownMenu dropdown"  data-css='{"height":115, "width":150}' id="EmbedsVideoTypeId" style="display: none;">
									<option value="0">Brid Videos</option>
									<option value="1">YouTube Videos</option>
								</select>
							</div>
					 </div>
				</td>
				<td>
					<div id="dynamicOptions">
						<div id="channel" class="dynamicOption">
							<div  class="dynamicPlaylist">
								<div class="input"><label style="left:0px;">Choose channel</label></div>
								<div class="divAsRow blueEmbedInside" id="chooseTypeEmbedCode" style="margin-top:10px;">
									<select name="data[Embeds][channel_id]" class="dropdownMenu dropdown" data-css='{"height":115, "width":150}' id="channelEmbed">
										<?php 
										foreach($channels as $k=>$v){ ?>
											<option value="<?php echo $v->Channel->id; ?>"><?php echo $v->Channel->name; ?></option>
										<?php
										}
										?>
										
									</select>
								</div>
							</div>
							
						</div>
						<div id="tag" class="dynamicOption">
							<div class="input"><label style="left:0px;">Tag</label></div>
							<div class="divAsRow blueEmbedInside" style="padding:0px; width:100px; ">
								<div class="input text required">
									<input name="data[Embeds][tagid]" default-value="Tag" data-into="playlist" type="text" id="tagEmbed">
									
								</div>
							</div>
						</div>
						<div id="source" class="dynamicOption">
							<div  class="dynamicPlaylist">
								<div class="input"><label style="left:0px;">Choose source</label></div>
								<div class="divAsRow blueEmbedInside" id="chooseTypeEmbedCode" style="margin-top:10px;">
									<select name="data[Embeds][source_id]" class="dropdownMenu dropdown" data-css='{"height":65, "width":150}' id="sourceEmbed">
										<option value="brid">Brid</option>
										<option value="youtube">Youtube</option>	
									</select>

								</div>
							</div>
						</div>
					</div>

				</td>
			</tr>
		</table>
	</div>
</form>
<script>
jQuery('#tagEmbed').input(function(){
	if(jQuery(this).val()!=''){
		jQuery('#postPlaylistDynamic').removeClass('disabled');
	}else{
		jQuery('#postPlaylistDynamic').addClass('disabled');
	}
})
jQuery('#postPlaylistDynamic').click(function(){

	var val = jQuery('#EmbedsTypeId').val();
	var id = 0;

	if(jQuery('#'+val).length>0){


		if(jQuery('#'+val+'Embed').length>0)
		{
			console.log(jQuery('#'+val+'Embed'));

			id = jQuery('#'+val+'Embed').val();

			if(val=='tag' && id==''){
				return false;
			}

		}
		
		
	}

	var items = jQuery('#EmbedsItems').val(),videoType=jQuery('#EmbedsVideoTypeId').val();
	items = items!='' ? parseInt(items) : 0;

	if(items<=0 || items>100 || items==NaN){
		items = 10;
	}

	$Brid.Util.addToPost('[brid '+val+'="'+id+'" items="'+items+'" player="'+$BridWordpressConfig.Player.id+'" width="'+$BridWordpressConfig.Player.width+'" height="'+$BridWordpressConfig.Player.height+'" video_type="'+videoType+'"]');

});