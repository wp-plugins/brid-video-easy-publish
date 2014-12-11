<?php $playlistType = count($playlist->Video)?$playlist->Video[0]->external_type:0;  ?>
<div class="playlists form" style="padding-top:30px;">
	<!-- @see http://manos.malihu.gr/tuts/jquery_thumbnail_scroller.html# -->
		<table style="width:100%;">
			 <tbody><tr>
				<td>
					<!-- Top menu start -->
					<div class="mainWrapper">
						<div class="list-items-menu">
							<div class="list-items-menu-wrapper">
								<ul class="items-menu">
									<li class="toolbarItemPlaylist" style="display:block">
										<div class="redButtonBg addVideoToPlaylistButton" id="add-video-to-playlist">
											<div class="textButtonSmall various bridAjaxAddVideosToPlaylists"  data-id="<?php echo $playlist->Playlist->id; ?>" data-action="addVideoPlaylist" href="<?php echo admin_url('admin-ajax.php'); ?>" >ADD VIDEO TO PLAYLIST</div>
										</div>
										<script>jQuery('.bridAjaxAddVideosToPlaylists').colorbox({innerWidth:900, innerHeight:780,data:{action:'addVideoPlaylist',id:<?php echo $playlist->Playlist->id; ?>,playlistType:'<?php echo $playlistType; ?>'}});</script>
									</li>
									<li class="toolbarItemPlaylist" style="display:block">
										<div class="redButtonBg emptyPlaylistButton" id="button-empty">
											<div class="textButtonSmall">
												<div class="delButtonSmall" style="top:-3px; margin-right:7px;"></div>CLEAR OUT PLAYLIST
											</div> 
										</div>
									</li>			
									<li class="toolbarItemPlaylist">
										<div class="redButtonBg" id="delete-playlist">
											<div class="delButtonSmall"></div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- Top menu end -->
					<div style="width:100%; position:relative;">
						<div class="disablePlaylistOrder"></div>
						<div id="tS2" class="jThumbnailScroller">
							<div class="jTscrollerContainer">
								<div class="jTscroller" id="sortable">
									<?php foreach($playlist->Video as $k=>$v){ ?>
										<a href="javascript:void(0)" style="position:relative;" id="video-thumb-id-<?php echo $v->id; ?>" class="playlist-item tooltip" data-ajax-loaded="true" data-info="<?php echo $v->name; ?>">
											<img src="<?php echo BridHtml::getPath(array('type'=>'thumb', 'id'=>$v->partner_id)).$v->thumbnail; ?>" width="120" height="104" onerror="this.src = &quot;<?php echo BRID_PLUGIN_URL; ?>img/thumb_404.png&quot;" alt=""> 
											<div class="hoverDiv"></div>
											<div class="playlist_delete_video" data-id="<?php echo $v->PlaylistsVideo->id; ?>" data-video-id="<?php echo $v->id; ?>"></div> 
											<div class="playlist_number" id="playlist-number-0">
												<span><?php echo ($k+1); ?></span>
											</div> 
											<div class="time"><?php echo self::format_time($v->duration); ?></div>
										</a>
									<?php } ?>									
								</div>
							</div>
						</div>
						<a href="#" class="jTscrollerPrevButton"><img src="<?php echo BRID_PLUGIN_URL; ?>img/prevArrow.png" class="previous-next-arrow" alt=""></a>
						<a href="#" class="jTscrollerNextButton"><img src="<?php echo BRID_PLUGIN_URL; ?>img/nextArrow.png" class="previous-next-arrow" alt=""></a>
				
					</div>
				</td>
			</tr>
			 <tr>
				<td style="text-align:center; color:#939598; font-size:13px;">
					Drag &amp; Drop to order items in your playlist
				</td>
			</tr>
		</tbody></table>
		   
			
		<form action="<?php echo admin_url('admin-ajax.php'); ?>" id="PlaylistEditForm" method="post" accept-charset="utf-8">
			<div style="display:none;">
				<input type="hidden" name="_method" value="PUT"></div>		 
				<input type="hidden" name="action" value="editPlaylist">
				<input type="hidden" name="insert_via" value="2">
				<input type="hidden" name="partner_id" value="<?php echo BridOptions::getOption('site'); ?>">
				<input type="hidden" name="id" id="PlaylistId" value="<?php echo $playlist->Playlist->id; ?>">  

	        <div style="padding-top:29px; float:left; width:100%; border-top:1px solid #d9d9da; margin-top: 3px">
		      
	        	<div id="player" style="float:left;margin-left:20px;">
	        	
	        	<!-- Preview player -->
					<div id="preview-player" style="float:left">
					<!--  <iframe id="Brid" src="<?php echo CDN_HTTP; ?>services/iframe/playlist/<?php echo $playlist->Playlist->id; ?>/<?php echo $playlist->Playlist->partner_id; ?>/1/0/100" width="366" height="227" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>-->
					<script type="text/javascript" src='<?php echo CLOUDFRONT."player/build/brid.min.js"; ?>'></script>
					<div id="Brid_video" class="brid" itemprop="video" itemscope itemtype="http://schema.org/VideoObject"><div id="Brid_video_adContainer"></div></div>
					<script type="text/javascript">$bp("Brid_video", {id:'<?php echo DEFAULT_PLAYER_ID; ?>',playlist:'<?php echo $playlist->Playlist->id; ?>',width:'366', height:'227'});</script>
					<script type="text/javascript" src="http://imasdk.googleapis.com/js/sdkloader/ima3.js"></script>
						        		
	        	</div>
		        
		        
		        <div id="playlistRightSide" style="float:left; width:427px; padding-left:16px;">
		        
		        <table style="width:100%;">
		        
		        	<tbody><tr>
		        		<td>
		        			<div class="input text required"><label for="PlaylistName">Playlist title</label><input name="name" default-value="Playlist name" data-info="Playlist name" maxlength="250" type="text" value="<?php echo $playlist->Playlist->name; ?>" id="PlaylistName" required="required"></div>		        		</td>
		        	</tr>
		        	
		        	<tr>
		        		<td style="padding-top:15px;">
		        			<div class="input text"><label for="PlaylistPublish">Publish on a date</label>
		        				<input name="publish" readonly="readonly" class="datepicker inputField" default-value="<?php echo date('m-d-Y'); ?>" data-info="Publish playlist on a date" type="text" value="<?php echo $playlist->Playlist->publish; ?>" id="PlaylistPublish"></div>		        		</td>
		        	</tr>
		        
		        	<tr>
		        		<td style="padding-top:22px;">
							
<div class="button saveButton save-playlist" data-form-id="PlaylistEditForm" id="playlistSaveEdit" style="margin-bottom:40px;">
	<div class="buttonLargeContent">SAVE</div></div>

		        		</td>
		        	</tr>
		        </tbody></table>
			        
		        </div>
		        
			        
		   </div>
		   
<div class="propagate"><div>Please allow up to 10 minutes for changes to propagate.</div></div>			
			</form>		
		
</div>
<script>
var dragInProgress = false;
var hoverDelay =  200;
var touchEvents = false;
var playlistId = <?php echo $playlist->Playlist->id; ?>;
/**
 * Init scrollet on Playlists Edit page
 * @param opt
 */
 var opt = { 
		scrollerType:"hoverAccelerate", 
		scrollerOrientation:"horizontal", 
		scrollSpeed:3, 
		scrollEasing:"easeOutCirc", 
		scrollEasingAmount:200, 
		acceleration:0.5, 
		scrollSpeed:500, 
		noScrollCenterSpace:200, 
		autoScrolling:0, 
		autoScrollingSpeed:1000, 
		autoScrollingEasing:"easeInOutQuad", 
		autoScrollingDelay:5000 
	};
function initScroller(opt){
	
	debug.log('INIT: initScroller');

	jQuery('.jThumbnailScroller').thumbnailScroller('destroy');
	jQuery('.jThumbnailScroller').thumbnailScroller(opt);
	
	
}
function updateNumbers(){

	jQuery('.playlist_number').each(function(k,v){ jQuery(this).html('<span>'+(k+1)+'</span>'); });
}
function getVideosOrder(){

	var videos = [];
	
	jQuery('#sortable').children().each(function(k,v){

		  //Update item numbers in playlist
		//  console.log(k,v);

		  videos.push(jQuery(v).attr('id').replace('video-thumb-id-', ''));
		  
		
	});

	return videos.join(',');
}
window.updateSortableWidth = function(){

	var c = jQuery('#sortable').children().length;
	var l = jQuery('#sortable a').outerWidth(true);
	
	debug.log('width new', (c*l));
	
	jQuery('#sortable').css('width', (c*l)+'px');
	jQuery('.jTscrollerContainer').css('width', (c*l)+'px');

}


function initSortable(){
	jQuery( "#sortable" ).sortable({
		  start: function( event, ui ) { 
				//Hide and remove tooltips
		//$Brid.Html.Tooltip.hideAndRemoveTooltips();
				
				dragInProgress = true;
				if (touchEvents) { 
					mouseW = jQuery('.jThumbnailScroller').width();
					jQuery('.jThumbnailScroller').unbind('mousemove.Thumbnail');
					jQuery('.jThumbnailScroller').bind('mousemove.Thumbnail', mousemove);
					} 
				},
		  stop: function( event, ui ) { 
			  jQuery('.playlist-item').css('left','0px');
				dragInProgress = false;
				if (touchEvents) { 
					jQuery('.jThumbnailScroller').unbind('mousemove.Thumbnail');
					}
				},
		  containment: '.jThumbnailScroller',
		  update: function( event, ui ) { 
			  

			  //Order sortable/thumbnail list
					 //$Brid.Html.FlashMessage.show({msg : data.message, status : data.status});
					 jQuery('.playlist-item').css('left','0px');	//Fix floating Images - not to disapeare or make any blank space AZ bug #131 - Call it twice
				     updateNumbers();
				     //$('.disablePlaylistOrder').animate({height:"0px"}, 400, function(){ $(this).hide();});
					 jQuery('.disablePlaylistOrder').fadeOut();
					 hideOver();


			  $Brid.Api.call({data : {action : "sortVideos", id : playlistId, sortOrder : getVideosOrder()} , callback : {after : {name : "updatePlaylistItems", obj : jQuery("#sortable")}}});
	

			  /*jQuery.ajax({
				  url: '/playlists/sort_videos/'+playlist_id+'.json',
				  data: 'data[Playlist][sort]='+getVideosOrder(),
				  type: 'POST',
				  async: true,
				  beforeSend : function(){
					  //$('.disablePlaylistOrder').fadeIn();
					  
			  		  $('.playlist-item').css('left','0px');	//Fix floating Images - not to disapeare or make any blank space AZ bug #131

				  		$Brid.Html.Tooltip.hideAndRemoveTooltips();
			  		
					 // $('.disablePlaylistOrder').css('height','130px').fadeIn(); //({height:"130px"});
					  $('.disablePlaylistOrder').fadeIn();
					  $Brid.Html.FlashMessage.loading('Ordering in progress. Please Wait...');
					  }
				}).done(function(data){
					//Order sortable/thumbnail list
					 $Brid.Html.FlashMessage.show({msg : data.message, status : data.status});
					 $('.playlist-item').css('left','0px');	//Fix floating Images - not to disapeare or make any blank space AZ bug #131 - Call it twice
				     updateNumbers();
				     //$('.disablePlaylistOrder').animate({height:"0px"}, 400, function(){ $(this).hide();});
					  $('.disablePlaylistOrder').fadeOut();
					  hideOver();
					  
				    
				}).fail(function(jqXHR, textStatus, errorThrown){

					var data = jQuery.parseJSON(jqXHR.responseText);
					 $('.playlist-item').css('left','0px');	
					$('.disablePlaylistOrder').animate({height:"0px"}, 400, function(){ $(this).hide();});
					$Brid.Html.FlashMessage.show({msg : data.message, status : data.status});
				});
				*/

	}});
	
	jQuery( "#sortable" ).disableSelection();

}

var playlistHoverTimer = null;

function showOver(){

	console.log('showOver');
	
	var $this = jQuery(this);
	
	//Hide all hovers
	hideOver();
	
	playlistHoverTimer = setInterval(function(){

		$this.find('.hoverDiv').fadeIn(100); 
		$this.find('.playlist_delete_video').fadeIn(); 
		
    	clearInterval(playlistHoverTimer);
    	playlistHoverTimer = null;
	}, hoverDelay);

}

function hideOver(){

	console.log('hideOver');
	clearInterval(playlistHoverTimer);
	playlistHoverTimer = null;

	jQuery('.hoverDiv').hide(); 
	jQuery('.playlist_delete_video').hide(); 

}

function initPlaylistHover(){

	jQuery('.playlist-item').off('mouseenter.Playlist',showOver);
	jQuery('.playlist-item').off('mouseleave.Playlist',hideOver);

    jQuery('.playlist-item').on('click.Playlist',showOver);
	jQuery('.playlist-item').on('mouseenter.Playlist',showOver);
	jQuery('.playlist-item').on('mouseleave.Playlist',hideOver);
	 
}

var mouseX;
var mouseW;
var animDelay = null;

var mousemove = function(e){ 
	pos = findPos(this);
	mouseX = (e.pageX-pos[1]);
	if (mouseX < 50) {
		if (!animDelay) {
			animDelay = setInterval("jQuery('.jTscrollerPrevButton').trigger('click');", 1200);
			}
		} else if (mouseW-mouseX < 50) {
		if (!animDelay) {
			animDelay = setInterval("jQuery('.jTscrollerNextButton').trigger('click');", 1200);
			}
		} else if (animDelay) {
		clearInterval(animDelay); animDelay = null;
		}
}

//Init save object
var save = saveObj.init();
//Inti all necessary items
/*
window.initPlaylistMainFunctions = function(){

	debug.log('INIT PLAYLIST: initPlaylistMainFunctions');
	initPlaylistHover();
	//initPlaylistDeleteSingle();
	initSortable();
	//initScroller(opt);
}*/

function initPlaylistMainFunctions(){

	debug.log('INIT PLAYLIST: initPlaylistMainFunctions');

	initBridMain();
	initScroller(opt); //Ovde ima neki bug sa ovim mousemove iznad
	initSortable();
	initPlaylistHover();

}

initPlaylistMainFunctions();


//Clear Playlist
jQuery('#button-empty').click(function(e){
	e.preventDefault();
    if(confirm("Are you sure you want to remove all items from this playlist?")){
		$Brid.Api.call({data : {action : "clearPlaylist", id : playlistId} , callback : {after : {name : "removePlaylistItems", obj : jQuery("#sortable")}}});
	}
});
//Delete single video
jQuery('.playlist_delete_video').click(function(){

	if(confirm("Are you sure you want to remove this video?"))
	{
		var id = jQuery(this).attr('data-id');
		var video_id = jQuery(this).attr('data-video-id');

		$Brid.Api.call({data : {action : "removeVideoPlaylist", id : id, video_id : video_id} , callback : {after : {name : "removePlaylistSingleItem", obj : jQuery(this)}}});
	}

});
</script>