<script>
$BridWordpressConfig = {};
$BridWordpressConfig.pluginUrl = '<?php echo BRID_PLUGIN_URL; ?>';
var currentDivView = 'Videos-content';
</script>
<div class="mainWrapper" style="width:100%;position:relative; top:20px">
	<div id="bridSpiner"><img src="<?php echo BRID_PLUGIN_URL.'/img/indicator.gif'; ?>" /></div>
	<div class="mainWrapper" style="width:858px">
		<?php //if(!$partner->Partner->upload){  ?>
		<?php if(!$partner->Partner->upload && !$ask){ ?>
		<p class="bridNotice" style="display:block;  float: left; width: 100%; padding-right: 0px; padding-left: 0px; text-indent: 15px;">
		You are currently on Brid's <a href="https://brid.zendesk.com/hc/en-us/articles/202211641" target="_blank">FREE PLAN</a>. You can upgrade to our <a href="https://brid.zendesk.com/hc/en-us/articles/202167711" target="_blank">ENTERPRISE PLAN</a> by <a  class="various" id="videoQuestion" data-action="askQuestion" href="<?php echo admin_url('admin-ajax.php').'?action=askQuestion'; ?>">clicking here</a>.
		</p>
		<script>try{jQuery('#videoQuestion').colorbox({innerWidth:920, innerHeight:650});}catch(e){}</script>
		<?php
			} 
		?>
		<!-- Tabs start -->	
		
		<div style="width:100%; padding-top:10px; overflow:hidden; float:left;" class="tabs withArrow" id="libraryTabs">
			<div id="Videos" class="tab" style="width: 50%;">VIDEOS</div>
			<div id="Playlists" class="tab-inactive" style="margin-right: 0px; width: 50%;">PLAYLISTS</div>
		</div>
		<!-- Tabs end -->

		<!-- videos tab start -->
		<div id="Videos-content" style=" float:left;"></div>
		<!-- videos tab end -->


		<!-- Playlists tab start -->
		<div id="Playlists-content" style="display:none; float:left;"></div>
		<!-- Playlists tab end -->
	</div>

	<!-- Start News Box -->
    <div class="bridNewsBox" style="top:9px;">
      <div class="bridNewsBoxTitle">FAQ</div>
      <ul id="bridWpNews">
        
      </ul>
      <div id="bridBugContent">
      	<div id="bridBugIcon"></div>
      	<a href="https://brid.zendesk.com/hc/en-us/requests/new" target="_blank" id="bridBugLink">Report a bug</a>
  	  </div>
  	</div>
  	<!-- End News Box -->
	<script>
	//Used in global contentRefresh function @see default.ctp or default.js
	
	//var quickSave = saveObj.init();	//Init all save buttons in quick edit forms
	jQuery(document).ready(function(){

		
      	$Brid.init(['Html.Tabs']);


		jQuery(".tab, .tab-inactive").off('click.TabsApiLoad').on("click.TabsApiLoad", function(){
	   
	   	//"id" : jQuery(this).val(), "callback" : "bridPlayerList"
	   	var div = jQuery(this); divId = div.attr("id"), intoDiv = jQuery("#"+divId+'-content');

	   		intoDiv.hide();

	      $Brid.Api.call({
	      					data : {action : divId.toLowerCase()}, 
	      					callback : {after : {name : "insertContent", obj : intoDiv}}
	      				});
	   
	  	});
		//Inital load videos page
		var l = document.location.toString();

		if(l.indexOf('playlist')!=-1){
			jQuery('#Playlists').trigger('click');
		}else{
			
			$Brid.Api.call({data : {action : 'videos'}, callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}});
		}


      	jQuery('#wpbody-content').css('float','none');
      	jQuery('html').css('background','none'); //html{background:#f1f1f1}

      	function tryToLoadNews(){

	    jQuery.ajax({
	          url : '<?php echo CLOUDFRONT; ?>WordpressNew/latest/3.json'
	      }).done(function(response){

	        //console.log(response);
	        var str = '';
	        if(response.length>0){

	          for(var i in response){

	            str += '<li class="bridNewsBoxItem"><a href="'+response[i].WordpressNew.link+'" target="_blank">'+response[i].WordpressNew.name+'</a></li>'
	          }
	        }

	        str += '<li class="bridNewsBoxItem learnMore"><a href="https://brid.zendesk.com/hc/en-us" target="_blank">Learn More >>></a></li>';

	        jQuery('#bridWpNews').html(str);
	        
	        if(response.length>0)
	        	jQuery('.bridNewsBox').show();
	    }).fail(function(){

	      jQuery('#bridWpNews').html('<li class="bridNewsBoxItem">Failed to load.</li>')

	    });

	  }
	  tryToLoadNews();

	});
	
	</script>


</div>



