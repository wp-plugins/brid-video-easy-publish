<?php  
$id = '';
$iterator = isset($iterator) ? $iterator : null;
$type = 'video';
$adTypesFlipped = array_flip($ad_types);
?>
<div class="ad-box-container">
<table id="ad-box-<?php echo $iterator;?>" data-type="<?php echo $adType;?>" data-iterator="<?php echo $iterator;?>" class="ad-box-<?php echo $adType;?>">
	<?php
		if($adObject!=null)
			$id = $adObject->id; //$this->Html->value('Ad.'.$iterator.'.id');

		$cuepointType = '';
		if($adObject!=null)
			$cuepointType = $adObject->adTimeType; // $this->Html->value('Ad.'.$iterator.'.adTimeType');
		$cuepointType = $cuepointType!='' ? $cuepointType : 's';
		if($adObject!=null){
			
			?>
			<input type="hidden" id="AdId" name="Ad[<?php echo $iterator; ?>][id]" value="<?php echo $adObject->id; ?>" />
			<?php
		}
	?>
		<tr style="background-color:#fff;">
			<td style="padding:5px;font-family:'Fjalla One', Arial; font-size:21px; color:#004055;text-transform:uppercase; padding-left:10px;">
				<?php echo $adType; ?>
				<input type="hidden" id="AdAdType" name="Ad[<?php echo $iterator; ?>][adType]" value="<?php echo $adTypesFlipped[$adType]; ?>" />
				<?php //echo $this->Form->hidden('Ad.'.$iterator.'.adType',array('label' => false, 'value'=>$adTypesFlipped[$adType])); ?>
			</td>
			<td style="padding:5px;"></td>
			<td style="padding:5px;">
				<div style="float:right;cursor:pointer;" class="ad-box-remove" data-iterator="<?php echo $iterator;?>" id="ad-box-remove-<?php echo $iterator;?>" data-id="<?php echo $id;?>" data-type="<?php echo $adType;?>">
					<img src="<?php echo BRID_PLUGIN_URL; ?>/img/delete_ad.jpg" />
				</div>
			</td>
		</tr>
		
		
		<?php if($adType=='midroll'){ ?>
			<!-- Mid-Roll -->
		<tr id="midroll-<?php echo $iterator; ?>-settings" class="additional-fields" style="background-color:#fff;display:block;">
			<td  colspan="3">
			
				<table style="width:250px; margin:10px;">
					<tr style="background-color:#fff;">
					<td valign="top" id="1-<?php echo $iterator; ?>-start">Cuepoints:&nbsp;&nbsp;</td>
					<td valign="top" id="1-<?php echo $iterator; ?>-start-at">
						<?php 
							//echo $this->Form->input('Ad.'.$iterator.'.cuepoints',array('label' => false, 'div'=>array('style'=>'width:auto;float:left;'),'type'=>'text','default-value'=>'Comma separated values', 'data-info'=>'Comma-separated values', 'style'=>'width:250px;height:20px;'));
					
						?>
						<input type="text" id="AdCuepoints" name="Ad[<?php echo $iterator; ?>][cuepoints]" value="<?php echo ($adObject!=null) ? $adObject->cuepoints : ''; ?>" style='width:250px;height:20px;'/>
					</td>
					<td>
						<?php 
						//	echo $this->Form->select('Ad.'.$iterator.'.adTimeType', $midroll_type, array('empty'=>false)); 
							/*echo $this->element('/html/selectbox',
								array(
										'text'=>false,
										'id'=>'Ad.'.$iterator.'.adTimeType',
										'selected'=>$cuepointType,
										'style'=>'width:200px;',
										'data_info'=>'',
										'items'=> $midroll_type
								)
							);*/
						?>
						<div class="input select" style="margin-left:20px;margin-top:-3px;">
								<select name="Ad[<?php echo $iterator; ?>][adTimeType]" class="dropdownMenu dropdown" data-css='{"height":60, "width":100}' id="AdAdTimeType" style="display: none;">
								
									<?php foreach($midroll_type as $k=>$v){
										$selected = '';
										if($v == $cuepointType){
											$selected = 'selected="selected"';
										}
										?>
											<option value="<?php echo $k; ?>" <?php echo $selected; ?>><?php echo $v; ?></option>
										<?php
									}?>
								</select>
								
						</div>		
					</td>
				   </tr>
				
				</table>
			
			</td>
		</tr>
		<?php }?>
		<?php if($adType=='overlay'){?>
		<!-- Overlay -->
		<tr id="overlay-<?php echo $iterator; ?>-settings"  class="additional-fields" style="background-color:#fff;display:block;">
			<td  colspan="3">
				<table style="width:300px; margin:10px;">
					<tr style="background-color:#fff;">
					<td>Start At: </td>
					<td><?php 
							 
							//echo $this->Form->input('Ad.'.$iterator.'.overlayStartAt',array('label' => false, 'div'=>array('style'=>'width:auto;float:left;'),'type'=>'text','default-value'=>'', 'data-info'=>'Overlay start at', 'style'=>'width:60px;height:20px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;'));
							
						?>
						<input type="text" id="AdOverlayStartAt" name="Ad[<?php echo $iterator; ?>][overlayStartAt]" value="<?php echo ($adObject!=null) ? $adObject->overlayStartAt : ''; ?>" style='width:60px;height:20px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;'/>
					</td>
					<td>Duration: </td>
					<td><?php 
						
							//echo $this->Form->input('Ad.'.$iterator.'.overlayDuration',array('label' => false, 'div'=>array('style'=>'width:auto;float:left;'),'type'=>'text','default-value'=>'', 'data-info'=>'Overlay duration', 'style'=>'width:60px;height:20px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;'));
							
						?>
						<input type="text" id="AdOverlayDuration" name="Ad[<?php echo $iterator; ?>][overlayDuration]" value="<?php echo ($adObject!=null) ? $adObject->overlayDuration : ''; ?>" style='width:60px;height:20px;text-align:center;font-family:Arial;font-style:italic;font-size:14px;text-indent:0;'/>
					</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php }
		 
		?>
		<tr style="background-color:#fff;">
			<td colspan="3">
				<div style="border-bottom:1px solid #dadadb;width:768px; float:right;">
			</td>
		</tr>
		<tr style="background-color:#fff;">
			<td colspan="3" style="padding: 10px;">
				<input type="text" id="AdAdTagUrl" name="Ad[<?php echo $iterator; ?>][adTagUrl]" value="<?php echo ($adObject!=null) ? $adObject->adTagUrl : ''; ?>" maxlength="1024" />
				<?php //echo $this->Form->input('Ad.'.$iterator.'.adTagUrl',array('label' => false, 'class'=>'adTagUrl','default-value'=>'Ad tag url', 'maxlength'=>1024,'data-info'=>'Ad tag url')); ?>
			</td>
		</tr>
	   
</table>
</div>