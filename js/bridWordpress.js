//Input Event Plugin
var inputTimer=null;(function(e,t){var n=".inputEvent ",r="bound.inputEvent",i="value.inputEvent",s="delegated.inputEvent",o=["input","textInput","propertychange","paste","cut","keydown","drop",""].join(n),u=["focusin","mouseover","dragstart",""].join(n),a={TEXTAREA:t,INPUT:t},f={paste:t,cut:t,keydown:t,drop:t,textInput:t};e.event.special.txtinput={setup:function(t,n,l){function l(t){var n=t.target;window.clearTimeout(inputTimer),inputTimer=null;if(m)return;if(t.type in f&&!inputTimer){inputTimer=window.setTimeout(function(){if(n.value!==e.data(n,i)){e(n).trigger("txtinput");e.data(n,i,n.value)}},0)}else if(t.type=="propertychange"){if(t.originalEvent.propertyName=="value"){e(n).trigger("txtinput");e.data(n,i,n.value);m=true;window.setTimeout(function(){m=false},0)}}else{e(n).trigger("txtinput");e.data(n,i,n.value);m=true;window.setTimeout(function(){m=false},0)}}var c,h,p,d=this,v=e(this),m=false;if(d.tagName in a){h=e.data(d,r)||0;if(!h)v.bind(o,l);e.data(d,r,++h);e.data(d,i,d.value)}else{v.bind(u,function(t){var n=t.target;if(n.tagName in a&&!e.data(d,s)){h=e.data(n,r)||0;if(!h)n.bind(o,l);e.data(d,s,true);e.data(n,r,++h);e.data(n,i,n.value)}})}},teardown:function(){var t=e(this);t.unbind(u);t.find("input, textarea").andSelf().each(function(){bndCount=e.data(this,r,(e.data(this,r)||1)-1);if(!bndCount)t.unbind(o)})}};e.fn.input=function(e){return e?this.bind("txtinput",e):this.trigger("txtinput")}})(jQuery);

/**
 * Custom debug console
 */
var DEBUGMODE = true;
var debug = (function(){
	
	var f = ['log','warn','group','groupCollapsed','groupEnd'],debug = {};
	
	jQuery(f).each(function(k,v){
		debug[v] = function(){
			if(window.console && DEBUGMODE){
				if(window.console[v]!=undefined){
					console[v].apply(console, arguments);
				}else{
					console['log'].apply(console, arguments); //IE 10 or lower, do not support console.group
				}
			}
		}
	});
	debug['warn'] = function(){if(window.console)console['warn'].apply(console, arguments);}
	debug['error'] = function(){if(window.console)console['error'].apply(console, arguments);}
	return debug;
})();
/**
 * If argument of method is invalid
 * 
 * @class ArgumentException
 * @param {String} message
 */
var ArgumentException = function (message, param) {
    this.name = 'ArgumentException';
    this.message = message;
    this.param = param;
    this.stack = (new Error()).stack;
}
/**
 * If method called is deprecated
 * 
 * @class DeprecatedMethodException - Temporary class used during cleaning process
 * @param {String} message
 */
var DeprecatedMethodException = function(message){
	this.name = 'DeprecatedMethodException';
    this.message = message;
    this.stack = (new Error()).stack;
    $_this = this;
    this.showMsg = function(){
    	
    	debug.error($_this.name, $_this.message, $_this.stack);
    }
}
ArgumentException.prototype = new Error;  // <-- remove this if you do not  want MyError to be instanceof Error
DeprecatedMethodException.prototype = new Error;  // <-- remove this if you do not  want MyError to be instanceof Error

Date.prototype.toPrettyFormat = function() {

	var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
	return monthNames[this.getMonth()]+' '+this.getUTCDate()+', '+this.getUTCFullYear();
	    

};
String.prototype.toHHMMSS = function () {
    sec_numb    = parseInt(this);
    var hours   = Math.floor(sec_numb / 3600);
    var minutes = Math.floor((sec_numb - (hours * 3600)) / 60);
    var seconds = sec_numb - (hours * 3600) - (minutes * 60);
    
    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return  ((hours!='00') ? hours+':' : '') +minutes+':'+seconds;
}
/**
 * Main Object | Init main components
 * 
 * @class $Brid
 * @constructor
 */
window.$Brid = (function($){
	
	return {
		/**
		 * Here we will store all timers by name e.g. timer['Encoding.checkStatus']
		 * 
		 * @property timer
		 * @type {Array}
		 */
		timer : [],		//Array of timers
		/**
		 * Here we will store all timeouts by name e.g. timeout['FlashMessage.show']
		 * 
		 * @property timeout
		 * @type {Array}
		 */
		timeout : [],	//Array of timeouts
		/**
		 * These are default methods that will be intialized if argument methods is not sent to init()
		 * 
		 * @property methods
		 * @type {Array}
		 */
		methods : ['dropdown', 'datepicker', 'Html.Selectbox', 'Html.Tabs' , 'Html.GoogleCheckbox', 'Html.DefaultInput', 'Html.Button', 'Html.CheckboxElement', 'Html.Radio', 'Html.Sticky','Html.Tooltip'],//, 'Html.Tooltip'
		/**
		 * Kill timer by name, Not used yet, will be used on status check on videos page when encoding is integrated
		 * 
		 * @method killTimer
		 * @param {String} Name of the timer in this.timer array
		 */
		killTimer : function(name){
			debug.log('$Brid.killTimer()', name);
			if(name==undefined) return false;
			if($Brid.timer[name]!=undefined)
			{
				clearInterval($Brid.timer[name]);
				$Brid.timer[name] = null;
			}
		},
		/**
		 * Stop timeout by name
		 * 
		 * @method stopTimeout
		 * @param {String} Name of the timeout in this.timeout array
		 */
		stopTimeout : function(name){
			//debug.log('$Brid.stopTimeout()', name);
			if(name==undefined) return false;
			if($Brid.timeout[name]!=undefined)
			{
				clearTimeout($Brid.timeout[name]);
				$Brid.timeout[name] = null;
			}
		},
		/**
		 * Init jQuery Datepicker
		 * 
		 * @method datepicker
		 */
		datepicker : function(){
			debug.log('$Brid.datepicker()', 'Datepicker is jQuery plugin.');
			jQuery(".datepicker").datepick('destroy');
			
			jQuery( ".datepicker" ).datepicker({
				  changeMonth: true,
				  changeYear: true,
				  dateFormat: 'dd-mm-yy',
				  showAnim: 'fadeIn',
				  disalbed: true
				}).on('change', function(){

					var el = jQuery('#default-value-'+jQuery(this).attr('id'));

					if(jQuery(this).val()!=''){ el.hide(); }else{el.show();}

				 });
		},
		/**
		 * Init all "dropdownMenu" class elements. Jquery dropdown. @see jqery.plugins file
		 * 
		 * @method dropdown
		 */
		dropdown : function(){
			debug.log('$Brid.dropdown()', 'Init all "dropdownMenu" class elements. Jquery dropdown.');
	    	jQuery('.dropdownMenu').dropdown('destroy');
			jQuery('.dropdownMenu').dropdown();
		},
		/**
		 * MAIN Init method - will initialize all necessary components
		 * 
		 * @method init
		 * @param Array methods | init only components of this array e.g ['dropdown','tabs']
		 * @return {String}
		 */
		init : function(methods){
			if(methods!=undefined && typeof methods != 'object') throw new ArgumentException ('$Brid.init argument must be typeof object. Try: $Brid.init(["Html.Checkbox"])');
			var m = null;
			if(methods!=undefined){ m = methods; }else{ m = this.methods;}
			//Kill all timers
			
			debug.log('METHODS;', methods);
			for(var name in this.timer){
				this.killTimer(name);
			}
			//Kill all timetouts
			for(var name in this.timeout){
				this.stopTimeout(name);
			}
	
			
			debug.group('INIT');
			for(var i in m){
				try{		
					var classPath = null, args = null, error=null;
					if(typeof m[i] == 'string'){
						classPath = m[i];
					}
					//e.g. $Brid.init(['dropdown', ['Html.Tabs', {djoka:'runda'}] ]);
					//Second argument will be sent to the init method
					if(typeof m[i] == 'object'){
						classPath = m[i][0];
						args = m[i][1];
					}
					
					//debug.group(classPath);
					debug.groupCollapsed(classPath); //Skupljeno
					
					if(this[classPath]==undefined){
						debug.log('Auto execute init method.', classPath);
						var exec = classPath.split('.');
						//Try to autoexecute object init
						try{
							if(exec==undefined || exec[0]==undefined)
							{
								throw new ArgumentException('Object/Method not defined ('+classPath+'). Try to use: Object.Object e.g. Html.Button');
							}
							if(exec[1]==undefined)
							{
								$Brid[exec[0]].init(); //e.g. $Brid.Object.init();
							}else{
								$Brid[exec[0]][exec[1]].init(args); //e.g. $Brid.Html.Selectbox.init();
							}
							
						}catch(e){
							error = e;
							if(DEBUGMODE){
								debug.error('Error AutoExecute:', exec, e.message, e.stack);
							}else{
								debug.error('Error AutoExecute:', exec, e.message, e);
							}
						}finally {
							//Stop showing page, if necessary object is not Initialized
							handleImportantError(error, 'Object initialization failed <b>('+classPath+')</b>');
						}
						
					}else{
						debug.log('Method defined in $Brid object, so execute it.');
						this[classPath].apply(this, args);
					}
					debug.groupEnd();
					
				}catch(e){debug.error('Error init:', e.message, 'Method $Brid.'+m[i]+'() does not exist?'); }
				
			}
			debug.groupEnd();
			return 'Init end';
			
		}
		
	};
	
})(jQuery);
/**
 *
 *			var CALLBACKS
 *
 **/
$Brid.Callbacks = {
	className : '$Brid.Callbacks',
	/**
	 * Callback after we Add ad for video (load form and update counters)
	 */
	addToAdList : function(obj){

		debug.log('Callback:addToAdList', obj);

		var adType = obj.obj.attr('data-type');

		jQuery('#ad-content').prepend(obj.response);
		if(adType=='midroll')
		{
			//button.button({disabled : true});
			obj.obj.find(':first').removeClass('add-midroll-ad');
			obj.obj.find(':first').addClass('add-midroll-ad-disabled');

			//initSelectboxes();
		}

	   $Brid.init(['dropdown','Html.DefaultInput']);

	   ads[currentAdCount] = adType;
	   currentAdCount++;
	   //Init delete ad box on click
	   jQuery(".ad-box-remove").off('click', removeAdBox).on('click', removeAdBox);
	},
	/**
	 * Callback after we delete ad from video
	 */
	refreshAdList : function(obj){

		debug.log('Callback:refreshAdList', obj);
		if(obj.response!=undefined && obj.response.success){

			debug.log('Call: save.toggleSave from refreshAdList function.');
			save.toggleSave();

			var iterator = obj.obj.attr('data-iterator');
			obj.obj.closest('.ad-box-container').fadeOut(300, function(){jQuery(this).remove();});

			var adType = obj.obj.attr('data-type');;

			delete(ads[iterator]);

			if(adType=='midroll'){ //'midroll'


				debug.log('remove midroll');
				jQuery('#add-midroll-ad').removeClass('add-midroll-ad-disabled');

			}
			//init delete ad box on click
			jQuery(".ad-box-remove").off('click', removeAdBox).on('click', removeAdBox);
							
		}
	},
	/*
	 * Callback  on dynamic playlist type change
	 */
	toggleEmbedCodeType : function(obj){
		debug.log('Callback object', 'toggleEmbedCodeType', obj.val());

		jQuery('#dynamicOptions').children().hide();

		if(jQuery('#'+obj.val()).length>0){
			jQuery('#'+obj.val()).fadeIn();
			if(jQuery('#'+obj.val()).val()=='' && obj.val()=='tag'){
				jQuery('#postPlaylistDynamic').addClass('disabled');
			}else{
				jQuery('#postPlaylistDynamic').removeClass('disabled');
			}
		}
		debug.log(obj.val());
	},
	partnerCreateSnapshot : function(saveButton){

		window.location = settingsUrl;
		/*
		alert('update site id:'+saveButton.ajaxResponse.partnerId);

		$Brid.Api.call({data : {action : "updatePartnerId", id : saveButton.ajaxResponse.partnerId}});
		*/

	},
	/*
	 * Callback afgter sort videos in playlist
	 */
	updatePlaylistItems : function(obj){
		debug.log('Callback object', 'updatePlaylistItems', obj);
		jQuery('.playlist-item').css('left','0px');	//Fix floating Images - not to disapeare or make any blank space AZ bug #131 - Call it twice
	    updateNumbers();
		jQuery('.disablePlaylistOrder').fadeOut();
		hideOver();

	},
	/**
	 * Callback after we execute "add items" to the playlist (from edit screen)
	 */
	itemsAddedToPlaylist : function(obj){
		debug.log('Callback object', 'itemsAddedToPlaylist', obj);

		if(obj.response.playlist_videos!=undefined){

			var added = false; // selectedFields = $Brid.Html.CheckboxElement.getSelectedCheckboxes('video-id-');
    				//var data = b.data;
					//Hide selected rows after we delete them
					/*for(var sid in selectedFields){
	
						$('#video-id-'+selectedFields[sid]).attr("checked", false);
					}
	
					$("#video-toolbar").parent().hide();
					*/
		
					var $_sortable = jQuery('#sortable'); //$('#sortable')
						
				  	if($_sortable.length>0){
	
					  		var sortableCount = ($_sortable.children().length+1);
					  		var imageSrc = '';
					  		
					  		//if(selectedFields.length>0)
					  		//{
	
					  			for(var video_id in obj.response.playlist_videos){
	
					  				added = true;
					  				var playlist_video_id = obj.response.playlist_videos[video_id];
					  				imageSrc = jQuery('#video-img-'+video_id).attr('src');

					  				debug.log ('FOUND SRC:', imageSrc);

					  				if(imageSrc == '/img/indicator.gif'){
					  					imageSrc = jQuery('#video-img-'+video_id).attr('data-original');
					  				}
									
					  				$_sortable.append('<a href="javascript:void(0)" style="position:relative;" id="video-thumb-id-'+video_id+'" class="playlist-item tooltip" data-ajax-loaded="true" data-info="'+jQuery('#video-title-'+video_id).html()+'" > <img src="'+imageSrc+'" width="120px" height="104px" /><div class="hoverDiv"></div><div class="playlist_delete_video" data-id="'+playlist_video_id+'" data-video-id="'+video_id+'"></div><div class="playlist_number" id="playlist-number-'+(sortableCount+1)+'"><span>'+(sortableCount++)+'</span></div> <div class="time">'+jQuery('#video-duration-'+video_id).html()+'</div></a>');
					  			
					  			//}
						  		
						  		updateSortableWidth();
						  		//window.updatePlaylistOrder(); temp disabled
					  		}
					}
		
				  	if(added)
				  	{
				  		//window.parent.initPlaylistMainFunctions();
						initPlaylistMainFunctions();
				  		debug.log('FANCY BOX CLOSE');
				  		//jQuery.fancybox.close( true );
						jQuery.colorbox.close();
		
				  	}

		}

	},
	/*
	 * Callback executed on remove video item from playlist
	 */
	removePlaylistSingleItem : function(delButton){
		debug.log('Callback object', 'removePlaylistSingleItem', delButton);
		var video_id = delButton.obj.attr('data-video-id');
		
		console.log('Video id:', video_id);

		jQuery('#video-thumb-id-'+video_id).fadeOut(function(){jQuery(this).remove(); updateNumbers(); window.updateSortableWidth(); });

	},
	/**
	 Delete all items on clear Playlist click
	 */
	removePlaylistItems : function(a){
		debug.log('Callback object', 'removePlaylistItems', a);
		jQuery('#sortable').children().each(function(k,v){
	
					jQuery(this).fadeOut(function(){jQuery(this).remove();});
	
		});

	},
	//Grey out Video title on status paused
	disableVideoTitle : function(quickButton){
		debug.log('Callback object', 'disableVideoTitle', quickButton);
		var id = quickButton.obj.attr('data-id');
		var videoTitle = jQuery('#video-title-'+id);
		
		
		//Grey title, only when quickIcon is disabled
		//In ajax calls first we add / remove class disabled
		//than we call this callback
		if(quickButton.obj.parent().hasClass('turnedoff'))
		{
			videoTitle.addClass('videoTitleDisabled');
		}else{
			videoTitle.removeClass('videoTitleDisabled');
		}
		
	},
	//Add video on channel select
	channelSelected : function(selectBox){
		debug.log('Callback object', 'channelSelected');
		var val = jQuery(selectBox).find(":selected").val();
		var text = jQuery(selectBox).find(":selected").text();
		if(val > 0) {
			addVideoFromSearch(val, text);
		}
	},
	/**
	 * Delete action callback
	 *
	 *
	 **/
	deleteVideos : function(a){
		debug.log('Callback object', 'deleteVideos', a);
		
		var data = a.response;
		if(data.redirect!=undefined){

			var name = "insertContent"+a.obj.model+"s", div = "#"+a.obj.model+"s-content";

            $Brid.Api.call({data : $Brid.Util.getRedirectUrl(data.redirect), callback : {after : {name : name, obj : jQuery(div)}}});
			
		}
	},
	/**
	 * Video add form, save during upload or just save
	 */
	onVideoSave : function(saveButton){
		debug.log('Callback object', 'onVideoSave', saveButton.ajaxResponse);
		jQuery('#VideoId').val(saveButton.ajaxResponse.videoId);
		jQuery('#autoSaving').html('Saved');
	},
	/**
	 * On media page, click on tabs will trigger this callback on ajax succes load
	 *
	 *
	 *
	 **/
	 insertContent : function(arg){  // arg.response and arg.obj
		
		debug.log("$Brid.Callbacks.insertContent", arg);

		if(arg.obj!=undefined){

			var id = arg.obj.attr('id');

			//Fast clicking on tabs prevention to show 2 tabs becouse ajax api had delay
			//console.log('start');
			console.log('Deca:', jQuery('#postTabs').children());

			jQuery('#postTabs').children().each(function(k,v){

				var this_id = jQuery(v).attr('id');
				if(this_id!=undefined && this_id+'-content'!=id+'_content'){
					jQuery('#'+this_id+'-content').hide();
				}
				//console.log(this_id);

			});
			//console.log('end');

			debug.log("$Brid.Callbacks.insertContent ID:", id);
			var switchDivs = ['Videos-content', 'Playlists-content'];
			//Clear previous content view (checkboxes issue)
			
			if(id!=currentDivView && jQuery.inArray( id, switchDivs ) != -1){
				if(jQuery('#'+currentDivView).length>0){
					jQuery('#'+currentDivView).html('');
				}
				currentDivView = id;
			}

			arg.obj.html(arg.response).fadeIn('fast', function(){ 
				debug.log('Call initBridMain from insertContent');
				initBridMain();
			});

		}
	},
	/*
	 * @todo Should be insertContent 
	 */
	insertContentVideos : function(arg){  // arg.response and arg.obj
		
		debug.log("$Brid.Callbacks.insertContentVideos");
		$Brid.Callbacks.insertContent(arg);
		/*
		if(arg.obj!=undefined){

			arg.obj.html(arg.response).fadeIn('fast', function(){ 
				debug.log('Call initBridMain from insertContentVideos');
				initBridMain();
			});

		}
		var intoDiv = jQuery('#Videos-content');
		*/

		
	},
	/*
	 * @todo Should be insertContent 
	 */
	insertContentPlaylists : function(arg){  // arg.response and arg.obj
		

		debug.log("$Brid.Callbacks.insertContentPlaylists");
		$Brid.Callbacks.insertContent(arg);
		/*
		if(arg.obj!=undefined){

			arg.obj.html(arg.response).fadeIn('fast', function(){ 
				debug.log('Call initBridMain from insertContentPlaylists');
				initBridMain();
			});

		}*/
	},
	/**
	 * Load player list on partner change in settings options page
	 */
	bridPlayerList : function(arg){ // arg.response and arg.obj

		debug.log("$Brid.Callbacks.bridPlayerList", arg);

		var options = '', s ='', players = arg.response;
		for(var o in players){
			str = '{"id":"'+players[o].Player.id+'","width":"'+players[o].Player.width+'","height":"'+players[o].Player.height+'","autoplay":'+players[o].Player.autoplay+'}';
			options += '<option value="'+players[o].Player.id+'" '+s+' data-options=\''+str+'\'>'+players[o].Player.name+'</option>';
		}
		if(options!='')
		jQuery('#playerListSelect').html(options).parent().fadeIn(300, function(){
			playerChanged();
			jQuery("#playerListSelect").trigger("liszt:updated");
		});

	},

	/**
	 * Will initialize player on thumbnail click on videos/index|list_items or players/index|list_items
	 */
	initPlayer : function(a){
		debug.log('Callback object', 'initPlayer');
		var id = jQuery(a).attr('data-id');
		var open = jQuery(a).attr('data-open');
		var args = jQuery(a).attr('data-callback-args');
		
		var playerOptions = jQuery.parseJSON(args);	//Default player id is hardcoded to 1??
		
		var tableRow = jQuery('#tableRowContent'+id);

		var anim = jQuery(tableRow).find('.'+open);

		debug.log('Saljem playeru:', playerOptions);
		//alert($(anim).find('.loadingPreviewPlayer').length)

		//debug.log($(anim).find('#'+divId).length, $(anim).find('.loadingPreviewPlayer').length);
		
		//.loadingPreviewPlayer is a div that track is player loaded already so do not init that player again.
		//plyaerDiv is a div class that contain player
		if(jQuery(anim).hasClass('playerDiv') && jQuery(anim).find('.loadingPreviewPlayer').length==1)
		{
			jQuery(anim).find('.loadingPreviewPlayer').fadeOut(300, function(){jQuery(this).remove()});
			
			var divId = tableRow.find('.brid').attr('id');
			
			debug.log('PLAYER INIT FROM CMS CODE', playerOptions, divId);
			
			$bp(divId, playerOptions); 
			
		}else{

			debug.log('Do not reload player again. It should be already loaded (.loadingPreviewPlayer div should not exist for this player)');
		}
	},
	/**
	 * Callback before initAnimation is called on videos/index|list_items or players/index|list_items
	 * This is called as before callback on video list to change Play to Hide text on the video thumb
	 */
	changeOverText : function(a){
		
		debug.log('Callback object', 'changeOverText');
		
		var id = jQuery(a).attr('data-id'), div = jQuery(a).attr('data-open');
		
		try{
			//Try to stop video playback
			var tableRow = jQuery('#tableRowContent'+id), divId = tableRow.find('.brid').attr('id');
			//alert(divId);
			debug.log('Try brid player stop: ID:',divId);
			$bp(divId).stop();
			
		}catch(e){}
		
		var hideText = function (id){

			var tableRow = jQuery('#tableRowContent'+id), videoPlay = tableRow.find('.videoPlay');
			tableRow.find('.videoPreviewBg').hide();
			videoPlay.hide().removeClass('disableHover');
		}
		//Show hide text "Hide" VS thumbnail play button-a
		var showHideText = function(a){

			var id = jQuery(a).attr('data-id'),tableRow = jQuery('#tableRowContent'+id), videoPlay = tableRow.find('.videoPlay');
			
			//Hide other
			jQuery('.hiddenContnet').each(function(k,v){

				if(jQuery(this).attr('data-id')!=id)
				{
					
					hideText(jQuery(this).attr('data-id'));
				}
				

			});
			
			if(videoPlay.hasClass('disableHover'))
			{
				videoPlay.removeClass('disableHover');
				

			}else{

				videoPlay.addClass('disableHover');
				
			}
			
			
		}
		
		if(div=='playerDiv'){
		 	showHideText(a);
	   	 }else{
	   		 hideText(id);
	   	 }
	},
	addVideoChannelChanged : function(selectBox){
    			enableSave();
    			$Brid.Video.checkAutosaveMessage();
    		},
}
/**
 *
 *			API
 *
 **/
var Api = {

	call : function(arg){

		debug.log('$Brid.Api.call()');

		var config = jQuery.extend(true, {}, arg);
		
		//if(arg.dataType==undefined) { config.dataType = 'json';}
		if(config.url==undefined) { config.url = ajaxurl;}
		if(config.requestType==undefined) { config.type = "POST";}

		debug.log("Config", config, "Arg:", arg, "Data:", arg.data);

		jQuery.ajax(config).done(function(response){

			//console.log('RESPONSEEEEEE', response);
			if(response.error==undefined){
				//Success
				debug.log('$Brid.Api.call()', 'Success');
				if(config.callback!=undefined && config.callback.after!=undefined && config.callback.after.name!=undefined){
					var obj = {response : response };
					if(config.callback.after.obj!=undefined){
						obj.obj = jQuery.extend(true, config.callback.after.obj, {response : response });
					}
					$Brid.Callbacks[config.callback.after.name].call($Brid.Callbacks, obj);

				}
			}else{
				alert('Error: ' + response.error);
			}

		});
		
	}
};

$Brid.Api = jQuery.extend(true, {}, Api);

/**
 *
 *			HTML
 *
 **/
$Brid.Html = {};



/**
 * Effect object defines all necessary effects, on buttons, animations etc.
 * STATIC CLASS - does not have init method
 * 
 * @class $Brid.Effect
 */
var Effect = {
		/**
		 * show encoding status
		 */
		encodingStatus : function(status, obj){
			switch(status){
				case 4:
					obj.html('Uploading');
					break;
				case 6:
					obj.html('Downloading');
					break;
			}
		},
		/**
		 * Show progress bar for encoding
		 */
		encoding : function(){
			debug.log('$Brid.Html.Effect.encoding()');
			
			jQuery('.encodingProgressBarMove').each(function(k,v){
				
				var progressPercentage = jQuery(this).attr('data-progress');
				var maxBarWidth = 666;
				var currentWidth = parseInt(jQuery(this).width());
				var widthToMove = (progressPercentage * maxBarWidth) / 100;
				//width: <pre class= maxBarWidth: 858 currentWidth: 0 widthToMove: NaN 
				//debug.log('width:', $(this).width(), 'progressPercentage:', progressPercentage, 'maxBarWidth:', maxBarWidth,'currentWidth:', currentWidth, 'widthToMove:', widthToMove);
				
				var w = (currentWidth != 0 && currentWidth != 'NaN') ? (widthToMove - currentWidth) : widthToMove;
				
				jQuery(this).animate({width:'+='+w},300, function(){
					//$(this).html('<div class="encodingProgressMsg">Processing '+$(this).attr('data-progress')+'%</div>');
				});
			});
			
		},
		/**
		 * Show hide hover on images on List views
		 * 
		 * @method initImageHover
		 */
		initImageHover : function(){

			debug.log('$Brid.Html.Effect.initImageHover()');
			
			$Brid.stopTimeout('Effect.hover');
			
			jQuery('.centerImgWrapper').off('mouseenter',centarImgOver).off('mouseleave',centarImgOut);
			
			var centarImgOver = function(){

				$Brid.stopTimeout('Effect.hover');
	    		$this = jQuery(this);
	    		$Brid.timeout['Effect.hover'] = setTimeout(function(){
	    			debug.log('SHOW HOVER, timeout', $Brid.timeout['Effect.hover']);
			    	$this.find('.videoPreviewBg').fadeIn(250);
			    	$this.find('.videoPlay').fadeIn(150);
			    	$this.find('.videoStatusText').hide();
			    	$Brid.stopTimeout('Effect.hover');
			    	
	    		},100);
	    	
	        }
			
			var centarImgOut =  function(){

				$Brid.stopTimeout('Effect.hover');
		    	
	        	if(!jQuery(this).find('.videoPlay').hasClass('disableHover'))
	        	{
	            	jQuery(this).find('.videoPreviewBg').fadeOut(150);
	        		jQuery(this).find('.videoPlay').fadeOut(150);

	        		jQuery(this).find('.videoStatusText').show();
	        	}

	      }
		  jQuery('.centerImgWrapper').on('mouseenter', centarImgOver).on('mouseleave', centarImgOut);
		  
		},
		/**
		 * http://fancybox.net/
		 * className or Id property are required
		 * options is Optional to override FancyBox default properties
		 * e.g. initFancyBox({id:'.various', options : {autoSize : true}});
		 * $Brid.Html.Effect.fancybox({id:'.various', options : {autoSize : true}})
		 * 
		 * @method fancybox
		 * @param {Object} {id:'.various', options : {autoSize : true}}
		 */
		 /*fancybox : function(o){
			debug.log('$Brid.Html.Effect.fancybox()', 'FancyBox', o);
			
				if(o==undefined || typeof o !='object')
					throw new ArgumentException('Main function argument "options" must be specified. (e.g. initFancyBox({className : "various"});)');
				if(o.id==undefined)
					throw new ArgumentException('property options.id must be specified.');
				//Default ajax object
				if(jQuery(o.id).length>0){
					
					var myData = {};

					myData.action = jQuery(o.id).attr('data-action');
					if(jQuery(o.id).attr('data-id')!=undefined){
						myData.id = jQuery(o.id).attr('data-id');
					}

					var aO = {type : 'POST', data:  myData, timeout:20000, complete : function(){debug.log('Fancy box after load calls initBridMain'); initBridMain();} };
					
					if(o.ajax!=undefined){ aO = o.ajax;}
					//Default fancybox options
					var defaultFancyBoxOptions = { maxWidth : 858, fitToView	: false, scrolling : 'yes', width : '858px', height : '100%', autoSize : false, closeClick : false, openEffect : 'none', closeEffect : 'none', ajax : aO};
					// Merge defaultOptions with options sent via argument, recursively
					var options = jQuery.extend(true, defaultFancyBoxOptions, ( o.options || {}));
					debug.log('Fancyyyyyboooooooox', options);
					options.live = false;
					jQuery(o.id).fancybox(options);
				}
			
		},*/
		/**
		 * Will init animation on Thumb click, or on edit icon click on list views app wide.
		 * (Animate div with player nad init player, animate div with edit form etc.)
		 * 
		 * @method initAnimation
		 */
		initAnimation : function(){
			debug.log('$Brid.Html.Effect.initAnimation()');
			var $this = jQuery(this);
			debug.log('$this', $this);
	    	var div = $this.attr('data-open');							//Div to open (Stored in hiddenDiv wrapper playerDiv, editDiv...)
	    	var id = $this.attr('data-id');								//Id of the item (video.id, playlist.id...)
	    	var callback = $this.attr('data-callback');					//Is there any callback on animation finish?
	    	var callbackBefore = $this.attr('data-callback-before');	//Is there any callback before animation start?
	    	var tableRow = jQuery('#tableRowContent'+id);					//Table row contnet
	    	var cont = tableRow.find('.hiddenContnet');					//Get table Row to get hidden contnet
	    	var anim = jQuery(tableRow).find('.'+div); 						//Animate div (Content that will be shown)
	    	var cssClass = anim.attr('class');							//Get Anim css class so we can hide all others in the hiddenContnet on the second click
	    	
	    	tableRow.parent().parent().addClass('disableHover'); //video-row-ID	Disable hover while hidden contnet is opened
	    	
	   		//Hide all other divs in hiddenContent (except the one that is clicked)
	    	jQuery('.hiddenContnet').each(function(k,v){	
	    		if(jQuery(this).attr('data-id')!=id) {
	    			
	    			var playerDiv = jQuery(this).find('.playerDiv')
	    			debug.log('playerDiv', jQuery(this).attr('data-id'), id);
	    			
	    			jQuery(this).children().each(function(k,v){
	    				
	    				//debug.log(k,v);
		    			//If player is visible, stop it and hide it
						if(jQuery(this).is(":visible")){
							
							//Stop player during play
							if(jQuery(this).hasClass('playerDiv'))
							{ 
								var bridPlayerId = jQuery(playerDiv).find('.brid').attr('id');
								debug.log('Try brid player stop on opened player: ID:',bridPlayerId);
								if(bridPlayerId != undefined) {
									$bp(bridPlayerId).stop();
								}
							}
				      		//Show/hide div
							jQuery(v).animate({
					    	    height: 'toggle'
					    	  }, 300, function() {
					    		  
					    		// Animation complete. Execute callback if there is any
					    	  });
						}
	    				
	    			});
	    			
	    			var tableUpRow = jQuery('#tableRowContent'+jQuery(this).attr('data-id'));
	    			tableUpRow.parent().parent().removeClass('disableHover');
	    		
	    		}else{
	    			
	    			//ovde ce prikazati taj div
	    		}
	    	});

	    	//Hide already opened dynamicContents in the clicked row
	    	jQuery(cont).children().each(function(k,v){	
	    		
	    		if(!jQuery(this).hasClass(cssClass)){
	    			jQuery(this).fadeOut();
	    		}
	    	});
	    	//Execute before callback animation
	    	if(callbackBefore!=undefined)
	    	{   
	    		$Brid.Util.executeCallback($Brid.Callbacks, callbackBefore, $this);
	    	}
	    	//This div must not have any kind of css margin value, so animation can go smooth.
	    	jQuery(anim).animate({
	    		opacity : 1,
	    	    height: 'toggle'
	    	  }, 400, function() {
	    		  // Animation complete. Execute callback if there is any
					if(callback!=undefined) //E.g. callback = initPlayer
						$Brid.Util.executeCallback($Brid.Callbacks, callback, $this);
	    		    if(!jQuery(this).is(':visible') ){
	    		    	//Re-enable hover effect for quick menu
	    				tableRow.parent().parent().removeClass('disableHover');
	    				
	    		    }
	    	  });
		},
		/**
		 * Lazyload image
		 * 
		 * @method lazyload
		 */
		lazyload : function(){
			
			debug.log('$Brid.Html.Effect.lazyload()', 'completeRefresh - lazy load');
			//container: ".bp_list_items"
			var options = {effect : "fadeIn", failure_limit : 10};
			
			jQuery("img.lazy").each(function(k,v){
				
				if(jQuery(this).attr('src').indexOf('indicator')!==-1)
					jQuery(this).lazyload(options);
				
			});
		},
		/**
		 * Scroll page to top
		 * 
		 * @method scrollUp
		 */
		scrollUp : function(){
			debug.log('$Brid.Html.Effect.scrollUp()');
			jQuery('body,html').animate({scrollTop: 0}, 500);
			return false;
		}
}
$Brid.Html.Effect = jQuery.extend(true, {}, Effect);

/**
 * Button object defines all button behavior, actions and effects.
 * 
 * @class $Brid.Html.Button
 */
var Button = {
		/**
		 * Quick menu icons , .button, .buttonLarge hove effects
		 * 
		 * @method init
		 */
		init : function(){
			debug.log('$Brid.Html.Button.hover()');
			
			//0,8 group
			jQuery('.button, .textButtonSmall, .delButtonSmall, .videoGetEmbed, .opacityButton').hover(function(){
				jQuery(this).stop().animate({"opacity": 0.8}, 250);
			}, function(){
				jQuery(this).stop().animate({"opacity": 1});
			});
			
			//0,6 Group
			jQuery('.partner-quick-menu li:not(.disabled) div').hover(function(){
				jQuery(this).stop().animate({"opacity": 0.6}, 250);
			}, function(){
				jQuery(this).stop().animate({"opacity": 1});
			});
		},
		/**
		 * Init delete button
		 * 
		 * @method initDelete
		 * @param Object obj {buttonId : buttonId, model : model, controller : controller}
		 */
		initDelete : function(obj){
			if(obj.buttonId==undefined) throw new ArgumentException('Argment "buttonId" must be defined.');
			//Button on click
			jQuery("#"+obj.buttonId).click(function(e) {
				e.preventDefault();
				//$Brid.Ajax.remove(obj);
				var modelLowCase = obj.model.toLowerCase(), selectedFields = $Brid.Html.CheckboxElement.getSelectedCheckboxes(modelLowCase+'-id-');
				var action = 'delete'+obj.model+'s';

				var options = {};
				options.data = {};
				options.data['action'] = 'delete'+obj.model+'s';
				options.data['data['+obj.model+'][ids]'] = selectedFields.join(',');
				options.callback = {after : {name : 'deleteVideos', obj : {model : obj.model}}};

				$Brid.Api.call(options);

			});
		}
};
$Brid.Html.Button = jQuery.extend(true, {}, Button);

/**
 * Initialize custom tabs
 * 
 * @class $Brid.Html.Tabs
 * @see video.php and playlists.php there we bind on click events
 */
var Tabs = {
		/**
		 * Init tabs, bind on clicks, do calculation of tabs
		 * 
		 * @method init
		 */
		init : function(){
			debug.log('$Brid.Html.Tabs.init()');
			var $_tabs = jQuery('.tabs');
			$_tabs.each(function(k,v){
				
				var $_this = jQuery(this), w = parseInt($_this.width()), c = $_this.children().length;
				var offset = (c-1) * 2, itemWidth = parseInt((w-offset)/c), itemWidthLast = parseInt((w-offset) - ((c-1) * itemWidth));
				debug.log(w, c, itemWidth, itemWidthLast);
				$_this.children().css('width', itemWidth+'px');
				$_this.children(':last').css('width', itemWidthLast+'px');
				
			});
			
	
			$_tabs.children().off('click', this.click);
			$_tabs.children().on('click', this.click);
		},
		/**
		 * Define click action
		 * 
		 * @method click
		 * @param {Object} Event
		 */
		click : function(e){
			debug.log('$Brid.Html.Tabs.click', 'Executed method on Tab click');
			var $_this = jQuery(this), id = $_this.attr('id');
			//THIS IS UGLY
			//@todo Make unified logic that will work for all tabs
			//If we add disabled class to another tab that is not on Skin screen it will display this message?
			if($_this.hasClass('disabled')){
				
				$Brid.Util.openDialog('This tab is disabled, since "Type" of the Skin you have selected is templatized. <br/>Choose "Custom" Type to add/change Style properties.','Tab disabled');
				
			}else{

				jQuery('.tabContent').hide();
				//Hide tabs
				var children = $_this.parent().children();

				children.each(function(k,v){ 
					var $_this = jQuery(this);
					var id = $_this.attr('id'); jQuery('#'+id+'-content').hide(); //Hide contnet divs
					$_this.removeClass('tab').addClass('tab-inactive');	//Remove active
					
				});
				//Show clicked tab
				jQuery('#'+id+'-content').show();
				$_this.removeClass('tab-inactive').addClass('tab');
			
			}

		}
};
$Brid.Html.Tabs = jQuery.extend(true, {}, Tabs);

/**
 * Will set default values over input fields and center them
 * 
 * @class $Brid.Html.DefaultInput
 */
var DefaultInput = {
		/**
		 * Init default input values on Html inputs
		 * Available input Attributes:
		 * 'default-value' 	- Value that will be displayed as default, if not set on input Html element, Default Input will not be displayed
		 * 'data-info' 		- This is value (text) that will be populated in the div that we create over input
		 * 
		 * @method init
		 */
		init : function(){
			debug.log('$Brid.Html.DefaultInput.init()');
			jQuery('input[type="text"], input[type="password"], textarea').each( function(k,v){
				
				var $this = jQuery(this), $parent = $this.parent(), v = $this.val(), defaultInputValue = $parent.find('.defaultInputValue');
				//If value is set, hide default input div if exists
				if(v.length>0 && defaultInputValue.length>0){

					defaultInputValue.hide();
				}else{
				
					//Go into process of showing default Input div only if Input Value of the field is empty and if default-value attr is set
					if($this.attr('default-value')){
						var defaultText = $this.attr('default-value'); //Default text set
						var data_info = $this.attr('data-info');	   //Attribute set on Tooltip Ajax call
						var data_info_content = (data_info != undefined && data_info!='') ? 'data-info="' + data_info + '"' : 'data-info="' + defaultText + '"'; //Put data-info into defualtInputDiv
						var defaultDivId = 'default-value-'+$this.attr('id');	//Default div id (MAY NOT BE UNIQUE)
						
						// Quick edit has Playlist Name, and Lightbox also has Playlist Name field, so it can clash if the Playlist Name is
						// not for exactly that unique field, so we search it for each input (since it is not unique)
						
						if(!defaultInputValue.length>0)			//Does div already exist?
						{
							var style = 'padding-top:'+$this.css('padding-top')+';';
							
							style += ((v=='') ? 'display:block;' : 'display:none;');
							
							//Lets put the magic default Input div near our input element
							$this.parent().append('<div class="defaultInputValue" ' + data_info_content + ' ' + 'style="' + style + '"'+ 'id="'+defaultDivId+'">'+$this.attr('default-value')+'</div>');
							//Hide default Input div on key up
							$this.keyup( function(){
								
								//Need to find element after each keyup
								var a = jQuery(this).parent().find('.defaultInputValue');
								
					    	    if(jQuery(this).val().length>0){
					    	    	a.hide();
					    	    }else{
					    	    	a.show();
					    	       }
					    	   
					    	});
							
						}else{
							debug.warn('Default Input Div with the same ID ('+jQuery(defaultInputValue).attr('id')+')already exist on this page.');
						}
						
						
				    }
				}
				
			 
			});
			
			//Unbind it first and bind default Input Div Click if there is any
			jQuery('.defaultInputValue').off('click', this.click).on('click', this.click);
			//Here we have already populated all defaultInputValue divs, so lets go and center them
			this.center();
			
		},
		/**
		 * Centering Default Input div that is created via init over the input element
		 * 
		 * @method center
		 */
		center : function(){
			debug.log('$Brid.Html.DefaultInput.center()');
			
			jQuery('.defaultInputValue').each(function(k,v){
			
				if(jQuery(this).attr('data-position')==undefined){	//Check is data-position property set, that means that we already centered defautlInputValue
					var $_this = jQuery(this);
		    		var parent = $_this.parent();
		    		var conteinerPos = parent.position(); //div that contains everything about input
		    		var label = parent.find('label'); //label
		    		var hasLabel = label.length; //label
		    		var input = parent.find('input, textarea');
		    		var inputPos = input.position();
		    		var inputSize = input.height();
		    		var inputWidth = input.width();
		    		var inputOffset = input.offset();
		    		var offset = 0;
		    		var tagName = input.prop("tagName");

		    		if(tagName=='TEXTAREA'){	// use different height for textarea
						inputSize = 12;
					}
		    		
		    		if(input.attr('data-offset')!=undefined){
		    			offset = parseInt(input.attr('data-offset'));
		    		}
		    		
		    		var labelTop = 0;
		    		
		    		if(hasLabel){
		    			
		    			//Ovo ne radi kad je div hidden (u tabu, quick edit itd...)
		    			if(label.is(':visible')){
		    				labelTop = parseInt(label.outerHeight(true));
		    			}else{
		    				labelTop = 23; //is is just a guess
		    			}
		    		}
		    		
		    		//Hack to get width of the hidden field
		    		if(!input.is(':visible')){
		    			inputWidth  = inputWidth+'%';
		    	    }
		    		
		    		var fontSize = parseInt(input.css('font-size'));
		    		var marginTop = parseInt(input.css('margin-top'));
		    	    var paddingTop = parseInt(input.css('padding-top'));
		    	    //Lets do the math
		    	    //Center it 24 - 16 / 2 = 4 => 4 top + 16 font + 4 bottom = 24 height
		    		var inpTop = parseInt((inputSize-fontSize)/2) + marginTop + paddingTop - offset; //1px for the offset
		    	
		    		inpTop += labelTop;

					if (input.attr('default-value-fontsize')) {											// if default fontsize is defined move it a bit up or down
						inpTop += (fontSize - parseInt(input.attr('default-value-fontsize')))/2;
						fontSize = input.attr('default-value-fontsize');
					} else {
						fontSize = input.css('font-size');
					}
					$_this.css({top : inpTop+'px', width : inputWidth+'px', paddingLeft : '5px', fontSize : fontSize});
					
		    		if(!parent.hasClass('required')){
		    			$_this.addClass('defaultValueIndent');
		    		}
		    		$_this.attr('data-position', true);
				}
			
			 });
		},
		/**
		 * On click event over default Input Div
		 * 
		 * @method click
		 * @param {Object} Event
		 */
		click : function(e){
			
			debug.log('$Brid.Html.DefaultInput.click', 'On default Input Div click event');
			var $t = jQuery(this);
			var parent = $t.parent();		//Div that contains input filed and defaultInputValue div
		    $t.prev().select();
		    if($t.prev().val().length>0){

		    	$t.hide();
		    }
		}
		
};
$Brid.Html.DefaultInput = jQuery.extend(true, {}, DefaultInput);
/**
 * Used to generate Custom Checkbox buttons
 * 
 * @class $Brid.Html.Radio
 * @contructor
 */
var CheckboxElement = {
		/**
		 * Init and bind every checkbox button that have class attibute ".checkbox"
		 * 
		 * @method init
		 */
		init : function(){
			debug.log('$Brid.Html.CheckboxElement.init()', 'Init custom checkboxes.');
			jQuery('.checkbox').off('click', this.click).on('click', this.click);
		},
		/**
		 * On click for custom checkboxes (This is not used in toolbar - @see checkAllCheckbox
		 * 
		 * @method click
		 * @param {object} Event
		 */
		click : function(e){
			debug.log('$Brid.Html.CheckboxElement.click', 'Event');
	    	if(jQuery(e.target).hasClass('checkboxContent') || jQuery(e.target).parent().hasClass('checkboxContent'))
	    	{
				var chkboxElement =  jQuery(this), chk = chkboxElement.find(':input'), method = chkboxElement.attr('data-method'), name = chkboxElement.attr('data-name');
				
				if(chkboxElement.hasClass('disabledCheckbox'))
				{
					debug.warn('Checkbox is disabled');
					return false;
				}
				
				var checkbox = $Brid.Html.CheckboxElement.create({name : name});
				
				//First we toggle checkbox 
				$Brid.Util.executeCallback(checkbox, 'toggle', chk);
				 
				//Second we execute callback (if there is any)
				//debug.log('Event:clickCheckbox', checkbox, 'Method:', method, 'Name:', name);
				$Brid.Util.executeCallback(checkbox, method, chk);
				
				
	    	}else{
	    		debug.warn('"checkboxContent" class attr is missing on element you have clicked');
	    	}
			
		},
		/**
		 * This function should belong to Checkbox Object, but its usage is static - we do not need Checkbox object to execute
		 * It is a basic search by id
		 * 
		 * @method getSelectedCheckboxes
		 * @param {Sting} E.g "video-id"
		 * @return {Array} selectedFields
		 */
		getSelectedCheckboxes : function(id){
			var selectedFields = [];
			
			jQuery('input[id*="'+id+'"]').each(function(a,b){

				if (jQuery(this).hasClass('checked')){

					selectedFields.push(jQuery(this).attr('data-value'));
				}
			});
			return selectedFields;
		},
		/**
		 * Checbox object, used to execute methods
		 * Do not call this object directley $Brid.Html.ChecboxElement.Checkbox.init(), instead use $Brid.Html.CheckboxElement.create({name : 'autoplay'});
		 * 
		 * @class Checkbox
		 * @constructor
		 */
		Checkbox : {
			/**
			 * Init Checkox object
			 * 
			 * @method init
			 * @param {Object} {name : "autoplay"}
			 */
			init : function(obj){ 
				if(obj.name==undefined) throw new ArgumentException('"name" property in argumnet object is missing. Try {name: "autoplay"}');
				this.className = '$Brid.HTml.CheckboxElement.Checkbox';
				this.name = obj.name;
				this.id = obj.name + '-id-';					//Id prefix of each checkbox
				this.checkAll = obj.name + '-check-all';		//Group Checkbox to select/deselect all
				this.parentId = 'checkbox-'+ obj.name + '-check-all';
				//This is used on google Dropdown menu click item @see GoogleCheckbox.executeChecboxAction
				if(obj.targetElement!=undefined){
					this.targetElement = obj.targetElement;
				}
		    	return jQuery.extend(true, {}, this);
			},
			/**
			 * Deselect Top checkbox on the list that selectes/deselects all other checkboxes
			 * 
			 * @method deselectCheckboxAll
			 */
			deselectCheckboxAll : function(){
				debug.log('$Brid.Html.CheckboxElement.Checkbox.deselectCheckboxAll');
				  var chkAll = jQuery('#'+this.parentId).find('input');
		       	  this.deselect(chkAll);
			},
			/**
			 * Executed on Grab Embed screen when Autoplay checkbox is clicked
			 * 
			 * @method embedCodeAutoplayToggle
			 * @param {Object} jQuery Checkbox element
			 */
			embedCodeAutoplayToggle : function(checkbox){
				
				debug.log('$Brid.Html.CheckboxElement.Checkbox.embedCodeAutoplayToggle', checkbox);
				
	    		$Brid.Html.Embed.Js.editVal([{name : 'autoplay', value : jQuery(checkbox).val()}]);
	    		$Brid.Html.Embed.Iframe.editVal([{name : 'autoplay', value : jQuery(checkbox).val()}]);
				
			},
			/**
			 * Partner Edit Screen, Toggle Monetization options on Checkbox click
			 * 
			 * @method toggleParterMonetizationOptions
			 */
			toggleParterMonetizationOptions : function(){
				debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleParterMonetizationOptions');
				jQuery('#monetizePartner').animate({height: 'toggle'}, 500); 
			},
			/**
			 * Players Edit/Add screen Controls checkbox toggle
			 * 
			 * @method toggleControlsOptions
			 */
			toggleControlsOptions : function(checkbox){
		    	
				debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleControlsOptions', checkbox);
		    	
		    	if(jQuery(checkbox).val()!=1)
		    		jQuery('#controlsBehavior').next().addClass('disabledCheckbox');
		    	else
		    		jQuery('#controlsBehavior').next().removeClass('disabledCheckbox');
		    },
		    /**
			 * Partner Edit screen Upload Policy checkbox toggle
			 * 
			 * @method toggleControlsOptions
			 */
			toggleUploadOptions : function(checkbox){
		    	
				debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleUploadOptions', checkbox);
		    	
		    	if(jQuery(checkbox).val()!=1)
		    		jQuery('#upload').next().addClass('disabledCheckbox');
		    	else
		    		jQuery('#upload').next().removeClass('disabledCheckbox');
		    },
		    /**
		     * This is where we use targetElement property
		     * On google dropdown menu on users list, when some group is selected
		     * 
		     * @method toggleGroup
		     */
		    toggleGroup : function(){
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleGroup');
		    	var role = jQuery(this.targetElement).attr('data-id');
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleGroup',  role, this);

		    	
		    	this.deselectAll();
				var cntSelected = cntNotSelected = 0;
		        jQuery('div.siteVideosNum').each(function(){
		        	if (jQuery(this).attr('data-group-name')==role) {
		        			var checkbox = jQuery(this).parent().parent().parent().find('.singleCheckbox');
			        		var chkDiv = checkbox.parent().parent();
				        	if (chkDiv.hasClass("disabledCheckbox")) {
				            	debug.log('Skeeped from selection: ' + this.id);
				        	} else {
								cntSelected++;
								checkbox.prop('checked', true).addClass('checked').prev().show();
							}

						} else {
						cntNotSelected++;
						}
		        });
				if (cntSelected>0 && cntNotSelected==0) {
					this.checkSelectAll();
					}
		        
		        this.toggleTopMenu();
		         
		    },
		    /**
		     * Will select check All checkbox only
		     * 
		     * @method checkSelectAll
		     */
		    checkSelectAll : function(name){
		    	jQuery('#checkbox-' + this.name + '-check-all img.checked').show();
				jQuery('#checkbox-' + this.name + '-check-all input[type=hidden]').addClass('checked');
		    },
		    /**
		     * Toggle checkbox
		     * 
		     * @method toggle  
		     * @param {Object} jQuery Checkbox element
		     */
		    toggle : function(chk){
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Toggle()', chk);
		    	if(jQuery(chk).hasClass('checked'))
		    		this.deselect(chk);
		    	else
					this.select(chk);
				//Unselect Top group checkbox if all items are not selected
		    	if(jQuery(chk).attr('id')!=this.checkAll)
				this.areAllSelected();
		    },
		    /**
		     * Toggle all on checkbox (selectAll or deselectAll will be called)
		     * 
		     * @method toggleAll
		     * @param {Object} jQuery Checkbox element
		     */
		    toggleAll : function(chkboxElement){
		    	debug.log('Checkbox.toggleAll');
		    	if(jQuery(chkboxElement).hasClass('checked')){
		    		this.selectAll();
		    		this.togglePostButton(true);
		    	}else{
		    		this.deselectAll();
		    		this.togglePostButton(false);
		    	}
		    },
		    /**
		     * Select checkbox Action
		     * 
		     * @method select
		     * @param {Object} jQuery Checkbox element
		     */
		    select : function(chk){
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.select()', chk);
		    	jQuery(chk).attr('value', '1').addClass('checked');
				jQuery(chk).prev().fadeIn(200); //Hide image
		    },
		    /**
		     * Select all checkboxes by Checbox name
		     * 
		     * @method selectAll
		     */
		    selectAll : function(){
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.selectAll()', this.id);
		    	
		    	//Select top groupchecbox
		    	var chk = jQuery('#'+this.parentId).find('input');
		    	if(chk==undefined) throw Error('Checkbox input element not found.');
		    	this.select(chk);

		    	debug.log('Select input ids:'+this.id);
		    	//Select inputs
		        jQuery('input[id*='+this.id+']').each(function(i){
		        	var par = jQuery('#' + this.id).parent().parent().attr("class");
		        	if (par.indexOf("disabledCheckbox") !== -1) {
		            	debug.log('Skeeped from selection: ' + this.id);
		        	} else {
		        		debug.log('Select: ' + this.id);
		        	    //jQuery('#' + this.id).css('background-image', "url("+$BridWordpressConfig.pluginUrl+"img/checkbox_all.jpg)");
		        	    jQuery('#' + this.id).prop('checked', true).addClass('checked').prev().show();
		        	}
		    	});
		    	jQuery('.toolbarItem').fadeIn();

		    },
		    /**
		     * Deselect Checkbox Action
		     * 
		     * @method deselect
		     * @param {Object} jQuery Checkbox element
		     */
		    deselect : function(chk){
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.deselect()', chk);
		    	jQuery(chk).prev().hide();
		    	//I think attr value must be 1 so Cake can see that input
		    	jQuery(chk).attr('value', '1').removeClass('checked').prop('value', '0');
		    	
		    },
		    /**
		     * Select all checkboxes by Checbox name
		     * 
		     * @method deselectAll
		     */
		    deselectAll : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.deselectAll()', chk);
		    	var chk = jQuery('#'+this.parentId).find('input');
		    	this.deselect(chk);
		    	jQuery('.toolbarItem').hide();
		        jQuery('#'+this.checkAll).prop('checked', false).removeClass('checked');
		        jQuery('#'+this.checkAll).next().css('background-image', "none");
		        jQuery('input[id*='+this.id+']').removeClass('checked').prop('checked', false).prop('value', '0').prev().hide();
		        

		    },
		    /**
		     * Check are all checkboxes selected to select the main checkbox
		     * 
		     * @method areAllSelected
		     */
		    areAllSelected : function(){
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.areAllSelected()');
		    	var allChk = jQuery('input[id*='+this.id+']').length, allChkChecked = jQuery('input.checked[id*='+this.id+']').length, chk = jQuery('#'+this.parentId).find('input');
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.areAllSelected()', 'Ima ih ukupno:', allChk, 'Chekiranih:', allChkChecked);
		    	
		    	if(allChkChecked<allChk){
			    	this.deselect(chk);
		    	}
		    	if(allChkChecked==allChk){
			    	this.select(chk);
		    	}
		    },
		    /**
		     * Check is at least one checkbox selected
		     * 
		     * @method isAnySelected
		     * @return {Boolean}
		     */
		    isAnySelected : function() {
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.isAnySelected()');
		    	return jQuery('input[id*='+this.id+']').hasClass('checked') ? true : false;
		    	
		    },
		    /**
		     * Toggle post button
		     * 
		     * @method togglePostButton
		     * @return {Boolean}
		     */
		    togglePostButton : function(action){

		    	if(jQuery('#postVideo').length>0){
		    		if(action){
		    			jQuery('#postVideo').removeClass('disabled');
		    		}else{
		    			jQuery('#postVideo').addClass('disabled');
		    		}
		    	}
		    	if(jQuery('#postPlaylist').length>0){
		    		if(action){
		    			jQuery('#postPlaylist').removeClass('disabled');
		    		}else{
		    			jQuery('#postPlaylist').addClass('disabled');
		    		}
		    	}
		    },
		    /**
		     * This will toggle toolbar menu if any of the checkboxes are selected
		     * 
		     * @method toggleTopMenu
		     */
		    toggleTopMenu : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.showToolbar()');
		    	var t = jQuery('.toolbarItem');
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.showToolbar()',t);
		    	if (this.isAnySelected()) {
		    		this.togglePostButton(true);
		            if(!t.is(':visible')){
		            	t.fadeIn();
		            }

		        } else {
		        	this.togglePostButton(false);
		        	t.fadeOut();
		        }
		    },
		    /**
		     * Toggle video filed mp4 and mp4 HD - Video Add/Edit screen
		     * 
		     * @method toggleVideoField
		     * @param {Object} jQuery Checkbox element
		     */
		    toggleVideoField : function(chk){
		    	
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleVideoField()', chk);
		    	var id = jQuery(chk).attr('id'), fieldId = id.replace("On", "");
		    	if(jQuery(chk).hasClass('checked')){
		    		jQuery('#Video'+fieldId).parent().fadeIn();
		    		jQuery('.invisibleDiv').fadeIn();
		    	}else{
		            jQuery('.invisibleDiv').fadeOut();
		    	}
		    },
		    /**
			 * Used on Players Add/Edit screen and on Video/Edit screen
			 * to show/hide monetization options
			 * 
			 * @method toggleAdSettings
			 * @param {Object} jQuery Checkbox element
			 */
			toggleAdSettings : function(checkbox){
				
				debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleAdSettings()', checkbox);
		    	try{
		    		debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleAdSettings()', 'Try to toggle save object');
		    		//save.toggleSave();
		    	}catch(e){
		    		
		    	}
		    	var showAdSettings = function(){
		    		jQuery('#adSettings').animate({
						height: 'toggle'
					}, 600, function() {
						// Animation complete. Execute callback if there is any
						
					}); 
		    	}
		    	//Player add/edit screens have #adSettings0 div (Ad Frequency, Ad Offset) and Video edit screen dont
		    	if(jQuery('#adSettings0').length>0){
		    		//On end of the first animation, show second, do not excute both in the same time
		    		jQuery('#adSettings0').fadeToggle(100, function() {
		    			showAdSettings();
		    		});
		    	}
		    	else{	//This will affect on Video/Edit page
		    		showAdSettings();
		    	}
				
			},
			/**
			 * Players Edit/Add screen to toggle Voip options, callback to show more options
			 * 
			 * @method toggleVoipSocialOptions
			 * @param {Object} jQuery Checkbox element
			 * @todo Should be moved into callbacks
			 */
			toggleVoipSocialOptions : function(checkbox){
		    	
				debug.log('$Brid.Html.CheckboxElement.Checkbox.toggleVoipSocialOptions()', checkbox);
		    	if(jQuery(checkbox).val()!=1){
		    		jQuery('#voipSocialOption').next().addClass('disabledCheckbox');
		    		jQuery('#checkbox-makeFamily').addClass('disabledCheckbox');
		    	}
		    	else{
		    		jQuery('#voipSocialOption').next().removeClass('disabledCheckbox');
		    		jQuery('#checkbox-makeFamily').removeClass('disabledCheckbox');
		    	}
		    },
		    /**
		     * Used on videos list screen to select only videos with certain property (published, monetized etc.)
		     * selectProperty({property : property, status : status});
		     * 
		     * @method selectProperty
		     * @param {Object} jQuery Checkbox element
		     */
		    selectProperty : function (obj) {
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.selectProperty()', obj);
		    	if(obj.property==undefined) throw ArgumentException('"property" property in argument is missing e.g {property : property, status : status}');
		        if(obj.status==undefined) throw ArgumentException('"status" property in argument is missing e.g {property : property, status : status}');
		    	
		        this.deselectAll();
				var cntSelected = cntNotSelected = 0;
		        jQuery('input[id*='+this.id+']').each(function(i){
		        	
		        	var vId = jQuery(this).attr('data-value'); //Checbox Value
			        var propertyExists = jQuery('#partner-options-'+vId).parent().find('.' + obj.property); //.parent()
					// If element exists...
			        if (propertyExists[0] != undefined && jQuery(propertyExists[0]).attr('data-value')==obj.status) {
			                 
			            	 debug.log('property',propertyExists);
				             var elStat = jQuery('#tableRow'+vId).find('.checkbox').hasClass('disabledCheckbox');
			                 
			                 debug.log('Checkbox is disabled?', elStat, this.id);
			                 if (elStat==false){
			                            jQuery('#' + this.id).css('background-image', "url("+$BridWordpressConfig.pluginUrl+"/img/checkbox_all.jpg)");
			                            jQuery('#' + this.id).prop('checked', true).addClass('checked').prev().show();
										cntSelected++;
			                        } 
			               
			             // If element does not exist...
			             } else {
			            	
							cntNotSelected++;
								
			             }
		        	//}
		         
		        });
		        
				if (cntSelected>0 && cntNotSelected==0) {
					this.checkSelectAll();
					this.togglePostButton(true);
				}else{
					this.togglePostButton(false);
				}
				
		        jQuery('.toolbarItem').fadeIn();
		    },
		    /**
		     * Used on Video list page to select Published Videos Only
		     * 
		     * @method Published
		     */
		    Published : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Published()');
		        this.selectProperty({property : "video-status", status : 1});
		    },
		    Pending : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Pending()');
		        this.selectProperty({property : "video-status", status : 7});
		    },
		    /**
		     * Used on Video list page to select None Videos
		     * 
		     * @method None
		     */
		    None : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.None()');
		        this.deselectAll();
		    },
		    /**
		     * Used on Video list page to select Paused Videos Only
		     * 
		     * @method Paused
		     */
		    Paused : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Paused()');
		    	this.selectProperty({property : "video-status", status : 0});
		    },
		    /**
		     * Used on Video list page to select Failed Videos Only
		     * 
		     * @method Paused
		     */
		    Failed : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Failed()');
		    	this.selectProperty({property : "video-status", status : 5});
		    },
		    /**
		     * Used on Video list page to select Monetized Videos Only
		     * 
		     * @method Monetized
		     */
		    Monetized : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Monetized()');
		    	this.selectProperty({property : "video-monetize", status : 1});
		    },
		    /**
		     * Used on Video list page to select NotMonetized Videos Only
		     * 
		     * @method NotMonetized
		     */
		    NotMonetized : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.NotMonetized()');
		    	this.selectProperty({property : "video-monetize", status : 0});
		    },
		    /**
		     * Used on Users list page to select Verified Users Only
		     * 
		     * @method Verified
		     */
		    Verified : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Verified()');
		    	this.deselectAll();
		        this.selectProperty({property : "video-verified", status : 1});
		        this.toggleTopMenu();
		    },
		    /**
		     * Used on Users list page to select NotVerified Users Only
		     * 
		     * @method NotVerified
		     */
		    NotVerified : function(){
		    	debug.log('$Brid.Html.CheckboxElement.Checkbox.Verified()');
		    	this.deselectAll();
		        this.selectProperty({property : "video-verified", status : 0});
		        this.toggleTopMenu();
		    },
		    /**
		     * Settings verification/upload screen
		     * 
		     * @method submitForm
		     * @param {Object} ???
		     */
		    submitForm : function(arg) {
		    	var form = jQuery(arg).closest('form'),chkId = jQuery(arg).attr('id');
		    	debug.log('iddd',jQuery(arg).attr('id'));
		    	if(form != undefined){
		    		var button = form.find('[id='+chkId+'Button]').click();
		    	}
		    	
		    },
		    /**
		     * Enable submit on register form
		     * 
		     * @method enableSubmit
		     * @param {Object} Event
		     */
			enableSubmit : function(e){
				debug.log('$Brid.Html.Form.enableSubmit()');
				var u = jQuery('#UserUsername').val(), p = jQuery('#UserPassword').val();
		    	var tc = jQuery('#UserTermsConfirmed').val(); 									// Terms of Use Agreement
		    	var rc = jQuery('#recaptcha_response_field').val();								// reCaptcha
		    	var maxopacity = 1; if (jQuery('#UserPassword').attr('type') == 'text') { maxopacity = 0.3; }
		    	
		    	if (p.length > 0) {
		    		jQuery('#showHidePass').css('opacity', maxopacity);
		    		} else {
		    		jQuery('#showHidePass').css('opacity', 0);
		    		}
		    		
		    	if (u!='' && $Brid.Util.isEmailValid(u) && p!='' && p.length > 6 && p.length < 50 && tc==1 && rc.length>1)
		    	{
		    		jQuery('#registerButton').button({disabled : false}); //hm???
		    	} else {
		    		jQuery('#registerButton').button({disabled : true});
		    	}
			},
			
			/**
			 * Changes aspect ratio when user click checkbox on player add/edit
			 * 
			 * @method changeAspectRatio
			 * @param {Object} Event
			 */
			changeAspectRatio : function(e){ 
				if(parseInt(jQuery('#keepOriginalRatio').val())){
					$Brid.Util.calculateAspectRatio();
				}
			},
		 
		},
		//End of Checkbox Object
		/**
		 * This will create Checkbox object
		 * 
		 * Callback will be defined in template E.g. $this->element('/html/checkbox', array('id'=>'UserTermsConfirmed', 'method'=>'enableSubmit'));
		 * 
		 * @method create
		 * @param {Object} {name : 'autoplay'}
		 * @usage $Brid.Html.CheckboxElement.create({name : 'autoplay'});
		 * @return {Checkbox}
		 */
		create : function(obj){
			debug.log('$Brid.Html.CheckboxElement.create', obj);
			
	    	return this.Checkbox.init(obj);
		}
		
}
$Brid.Html.CheckboxElement = jQuery.extend(true, {}, CheckboxElement);

/**
 * Used to generate Custom Selectboxes (e.g. Ad Frequency, Ad Offset)
 * 
 * @class $Brid.Html.Selectbox
 * @constructor
 */
var Selectbox = {
		/**
		 * Init custom selectboxes on page, and bind on clicks and init top Chosen selectbox
		 * 
		 * @method init
		 */
		init : function(){
			debug.log('$Brid.Html.Selectbox.init()', 'Init custom selectboxes.');
			jQuery('.selectbox').off('click', this.clickSelectbox).on('click', this.clickSelectbox);
			jQuery('.selectBoxActive').off('click', this.clickSelectboxName).on('click', this.clickSelectboxName);
			jQuery('.selectBoxActiveImgDiv').off('click', this.clickSelectboxName).on('click', this.clickSelectboxName);
			this.initTopChosen();
		},
		/**
		 * Init top chosen selectbox
		 * 
		 * @method initTopChosen
		 */
		initTopChosen : function(){
			debug.log('$Brid.Html.Selectbox.initTopChosen()', 'Init chosen Top selectboxes.');
			//Partner Select box
			jQuery(".chzn-select").chosen();
			
		},
		/**
		 * Handle selectbox click
		 * 
		 * @method clickSelectbox
		 * @param {Object} Event
		 */
	    clickSelectbox : function(e){
	    	debug.log('$Brid.Html.Selectbox.clickSelectbox', 'Event');
	    	//target clicked (should always be LI tag
	    	var target = (jQuery(e.target).hasClass('selectbox')) ? jQuery(e.target) : jQuery(e.target).parent(); //check parent if img is clicked
	    	
	    	debug.log(target);
	    	//get li element
	    	if(target.hasClass('selectbox'))
	    	{

	        	debug.log('click item', target);
	        	var parent = jQuery(this).parent().parent().parent();
	        	var active = jQuery(parent).find('.selectBoxActive');
	        	var ul = jQuery(parent).find('.ul-selectbox');
	        	
	    		var input = parent.find(':input')
	    		input.val(target.attr('data-value'));	//Set value into hidden field


	    		if(input.attr('onchange')!=undefined){
	    		
	    			$Brid.Util.executeCallback(callbacks, input.attr('onchange'), input);
	    		}
	    		
	    		jQuery(ul).find('li').each(function(k,v){
	    			jQuery(this).removeClass('selected_selectbox');
	    		});
	    		
	    		active.html(target.text());
	    		
	    		ul.fadeOut(150);

	    		target.addClass('selected_selectbox');
	    		
	    	}
	    	
	    },
	    /**
	     * Handle selectbox click on name
	     * 
	     * @method clickSelectboxName
	     * @param {Object} Event
	     */
	    clickSelectboxName : function(e){ 
	    	debug.log('$Brid.Html.Selectbox.clickSelectboxName', 'Event');
	    	var a = jQuery(this).parent().find('.ul-selectbox');
			jQuery('.selectBoxContent').find('.ul-selectbox').not(a).hide(); 	//hide all other opened selectboxes
			
	    	if(jQuery(a).is(':visible')){
	    		jQuery(a).hide();
	    		jQuery(document).unbind('click', $Brid.Html.Selectbox.closeSelectboxes);
	    	} else {
	    		jQuery(a).fadeIn();
	    		jQuery(document).bind('click', $Brid.Html.Selectbox.closeSelectboxes);
	    	}
	    	
	    },
	    /**
	     * Handle close Selectboxes
	     * 
	     * @method closeSelectboxes
	     * @param {Object} Event
	     */
	    closeSelectboxes : function(e){
	    	debug.log('$Brid.Html.Selectbox.closeSelectboxes', 'Event');
	    	var targetBool = false;
	    	//If any of elements in dom with these class attribute is clicked do not hide dropdowns
	    	jQuery('selectBoxActive,selectbox,selectBoxActiveImg,selectBoxActiveImgDiv'.split(',')).each(function(k,v){
	    		
	    		if(jQuery(e.target).hasClass(v)){
	    			targetBool = true;
	    			return false;
	    		}
	    	});
	    	if(!targetBool){
	    		
	    		//debug.log('hide select', e.target);
		    	
		    	jQuery('.selectBoxContent').find('.ul-selectbox').hide(); //hide all other opened selectboxes
		    	jQuery(document).unbind('click', $Brid.Html.Selectbox.closeSelectboxes);
	    	}
	    }
}
$Brid.Html.Selectbox = jQuery.extend(true, {}, Selectbox);

/**
 * Used to display and hide top messages, static class - does not have init method
 * 
 * @class $Brid.Html.FlashMessage
 * @constructor
 */
var FlashMessage = {
		/**
		 * @property ajaxMsgHeight
		 * @type {Integer}
		 * @default 30
		 */
		ajaxMsgHeight : 30, //Reserve 30 pixels for message
		/**
		 * @property delay
		 * @type {Integer}
		 * @default 5000
		 */
		delay : 5000,
		/**
		 * Display message with class loading
		 * 
		 * @method loading
		 * @param {String} msg
		 */
		loading : function(msg){
			
			debug.log('$Brid.Html.FlashMessage.loading()', msg);
			
			//$Brid.Html.Sticky.doWeNeedToMoveAnyElement('plus');
			
			var msgBox = jQuery('#ajaxFlashMessage');
			msgBox.parent().css({height : this.ajaxMsgHeight+'px', width : '100%'});
			msgBox.css({height : this.ajaxMsgHeight+'px', width : '100%'});
			msgBox.removeClass('success error').addClass('loading').html(msg).fadeIn(500);
		},
		/**
		 * Working with top message when using Ajax statuses or descriptions
		 * Show message on top
		 * 
		 * @method show
		 * @param {Object} {msg : 'message', status : true}
		 */
		show : function(obj) {
			debug.log('$Brid.Html.FlashMessage.show()', obj);
			if(typeof obj != 'object') throw new ArgumentException ('Argument must be typeof object. Try this format: show({msg : "text"}');
			if(obj.msg==undefined) throw new ArgumentException ('Argument property "msg" is missing.  Try this format: show({msg : "text"}');
			var currentMsg = jQuery('#ajaxFlashMessage').text(), msgBox = jQuery('#ajaxFlashMessage');
			var delay = $Brid.Html.FlashMessage.delay;
			// Ukoliko poruka nije ista menjamo je
			//if(currentMsg != obj.msg) {
				
				//Move every strickyElement from top for a ajaxFlashMessage height value (30px)
				//Reverse process is called in hide function and checkSessionMsg (will kill any session or loading msg)
				
				//$Brid.Html.Sticky.doWeNeedToMoveAnyElement('plus');
				
				//$('#ajaxFlashMessage').removeClass('success').html(msg).show();
				debug.log('msgBox.parent()',msgBox.parent(), 'ajaxMsgHeight', this.ajaxMsgHeight);
				if(obj.status==undefined) throw new ArgumentException ('Argument property "status" is missing.  Try this format: show({msg : "message" , stauts : true}', obj);
				
				if (obj.status == 'success' || obj.status==true) {
							
							msgBox.parent().css({height : this.ajaxMsgHeight+'px', width : '100%'});
							msgBox.css('width','100%');
							msgBox.removeClass('loading error').addClass('success').html(obj.msg).css('height', this.ajaxMsgHeight+'px').fadeIn().delay(delay).fadeOut(300, $Brid.Html.FlashMessage.hide);
							
						}else{
							
							msgBox.parent().css({height : this.ajaxMsgHeight+'px', width : '100%'});
							msgBox.css('width','100%');
							msgBox.removeClass('loading success').addClass('error').html(obj.msg).css('height', this.ajaxMsgHeight+'px').fadeIn('fast').delay(delay).fadeOut(300, $Brid.Html.FlashMessage.hide);
						}
				
			//}
			
			//$Brid.stopTimeout('FlashMessage.message');
			//$Brid.timeout['FlashMessage.message'] = setTimeout(this.hide, this.delay);
			
		},
		/**
		 * Hide top message
		 * 
		 * @method hide
		 */
		hide : function() { 
			debug.log('$Brid.Html.FlashMessage.hide()', "Hiding message...");
			
			var msgBox = jQuery('#ajaxFlashMessage');
			
			msgBox.fadeOut("fast",function(){
				msgBox.parent().css({height : '0px', width : '0px'});
				msgBox.css({height : '0px', width : '0px'});
			});
			
			$Brid.Html.Sticky.doWeNeedToMoveAnyElement('minus');

			//$Brid.stopTimeout('FlashMessage.message');
			
		},
		/**
		 * Check is Session->setFlash message is used, if it is, hide it or show it
		 * 
		 * @method check
		 */
		check : function(){
			debug.log('$Brid.Html.FlashMessage.check()', "Check message Hiding message...");
			//jQuery('#flashMessage').html()!='' ? $('#flashMessage').css({'width':'100%','height':this.ajaxMsgHeight+'px'}).show().parent().css({'width':'100%', 'height':this.ajaxMsgHeight+'px'}).delay(4500).fadeOut('slow'): $('#flashMessage').hide();
		}

};
$Brid.Html.FlashMessage = jQuery.extend(true, {}, FlashMessage);


/**
 * Dropdown menu on Checkbox (like Gmail)
 * Also used for More options (videos section) @see $Brid.Html.GoogleCheckbox.toggleGMenu
 * 
 * @class $Brid.Html.GoogleCheckbox
 * @constructor
 * 
 */
var GoogleCheckbox  =  {
		/**
		 * Init all google checkboxes
		 * 
		 * @method init
		 */
		init : function(){
			debug.log('$Brid.Html.GoogleCheckbox.init()', 'Init google checkbox menu.');
			var $_googleButton = jQuery('.google_button'), $_googleMenu = jQuery('#g_menu');
			//Bind group top checbox (gmail checbox)
			$_googleButton.off('click', this.toggleCheckboxMenu).on('click', this.toggleCheckboxMenu);
			//Execute action on click of the item inside dropdown menu
			$_googleMenu.off('click', this.executeChecboxAction).on('click', this.executeChecboxAction);
		},
		/**
		 * Bind GMenu dropdown Used for more section (videos/More)
		 * 
		 * @method toggleGMenu
		 * @param {Object} e Event
		 */
		toggleGMenu : function(e){
			
			debug.log('$Brid.Html.GoogleCheckbox.toggleGMenu()', 'Clicked on ID:', jQuery(this).attr('id'), 'Event', jQuery(e.target));
			
			var a = jQuery(this).parent().find('.gdrop_down');
			
			$Brid.Html.GoogleCheckbox.hideAllGMenus(jQuery(this), a);		//Hide all other gmenus

		    if(a.is(':visible')) { 
		    	//Execute callback on click item before you hide menu
		    	var method = jQuery(e.target).attr('data-method');
		    	
		    	debug.log('$Brid.Html.GoogleCheckbox.toggleGMenu()', 'Method:', method);
		    	
		    	$Brid.Util.executeCallback($Brid.Callbacks, method, jQuery(e.target));
		    	a.hide(0, function(){ jQuery(document).unbind('click', $Brid.Html.GoogleCheckbox.hideAllGMenus);});
		    } else { 
		    	
		    	debug.log('$Brid.Html.GoogleCheckbox.toggleGMenu()', 'Show G menu');
		        a.fadeIn(300, function(){
		        	jQuery(document).bind('click', $Brid.Html.GoogleCheckbox.hideAllGMenus);
		        	if($Brid.Util.isMobileDevice('ios')) {
		        		jQuery(document).bind('touchstart', function(e){ 
		        			if(jQuery(e.target).attr('class') == 'chkbox_action')
		        				return;
		        			$Brid.Html.GoogleCheckbox.hideAllGMenus(); 
		        			});
		        	} 
		       
		        });
		        
		    }
		},
		/**
		 * Execute Callback on menu item click
		 * 
		 * @method executeChecboxAction
		 * @param {Object} e Event
		 */
		executeChecboxAction : function(e){
			var chkId = jQuery(this).attr('data-checkbox-id'), name = jQuery('#'+chkId).attr('data-name'), method = jQuery(e.target).attr('data-method');
			
			debug.log('Checkbox callback method on click:', method, 'Name:',name, 'Checkbox id:',chkId);
			
			var chk = $Brid.Html.CheckboxElement.create({name : name, targetElement : e.target});
			$Brid.Util.executeCallback(chk, method);
		},
		/**
		 * Show hide Checkbox menu (We can not use this.property here since "this" is an object type of Event not type of GoogleCheckbox)
		 * When arrow next to checkbox is clicked, ti will display available options
		 * 
		 * @method toggleCheckboxMenu
		 * @param {Object} e Event
		 */
		toggleCheckboxMenu : function(e) {
			debug.log('$Brid.Html.GoogleCheckbox.toggleCheckboxMenu()', 'Toggle Checkbox Menu', e, jQuery(this));
			
			var a = jQuery(this).parent().find('.gdrop_down');
			$Brid.Html.GoogleCheckbox.hideAllGMenus(e, a);
			if(a.is(':visible')) { 
				 a.hide(0, function(){ 
					 jQuery(document).unbind('click', $Brid.Html.GoogleCheckbox.hideAllGMenus); 
				});
			}else{
				 a.fadeIn(300, function(){
	             	jQuery(document).bind('click', $Brid.Html.GoogleCheckbox.hideAllGMenus);
	             });
			}
			
		},
		/**
		 * Hide GMenu
		 * 
		 * @method hideGMenu
		 * @param {Object} e Event
		 */
		hideGMenu : function(e){
			var menu = jQuery(e.target).find('.gdrop_down');
        	
	        jQuery(menu).hide(function() {
	            jQuery(document).unbind('click', $Brid.Html.GoogleCheckbox.hideAllGMenus);
	        });
		},
		/**
		 * Hide All menus
		 * 
		 * @method hideAllGMenus
		 * @param {Object} Event
		 * @param {Object} jQuery Object class of '.gdrop_down'
		 */
		hideAllGMenus : function(menu, currentOpenMenu){
	    	
	    	var id = jQuery(menu).attr('id');
	    	debug.log('$Brid.Html.GoogleCheckbox.hideAllGMenus()',' First hide all other opened G menus', 'id:'+id);
	    	//If attribute id is defined, hide explicitly that ID menu
	    	if(id!=undefined){
	    		
	    		//this will affect More on the top menu - when we use google drop as menu
	    		jQuery('.gdrop_down').each(function(k,v){ 
	    			
	    			if(currentOpenMenu!=undefined){
	    				if(jQuery(this).parent().attr('id')!=id && jQuery(this).attr('id')!=currentOpenMenu.attr('id')){jQuery(this).hide();}
	    			}else{
	    				
	    				if(jQuery(this).parent().attr('id')!=id){jQuery(this).hide();}
	    			}
	    			
	    		});
	    		
	    	}else{
	    		
	    		if(currentOpenMenu!=undefined){
		    		if(id!=currentOpenMenu.attr('id'))
		    		{
		    			//This will affect on google checkbox	- when we use google drop as checkbox item
		    			jQuery('.gdrop_down').each(function(k,v){
		    				
		    				if(jQuery(this).attr('id')!=currentOpenMenu.attr('id')){jQuery(this).hide();}
		    				
		    			});
		    		}
	    		}else{ 
	    			jQuery('.gdrop_down').hide();
	    		}
	    		
	    	}
	    	jQuery(document).unbind('click', $Brid.Html.GoogleCheckbox.hideAllGMenus);
	    }
		
	}

/**
 * Contains everything that could be explained as Html: GoogleCheckbox, Selectbox, Tabs, DefaultInput
 * 
 * @class $Brid.Html
 * @constructor
 * 
 */
$Brid.Html.GoogleCheckbox = jQuery.extend(true, {}, GoogleCheckbox);



/**
 * Used for all serach inputs on list items screens
 * 
 * @class $Brid.Html.Search
 */
var Search = {
		/**
		 * After this delay value, search will execute ajax, do not search while user is typing
		 * 
		 * @property delay
		 * @type {Integer}
		 * @default 900
		 */
		delay : 900,
		/**
		 * Here we store config sent throug init metod e.g. {className : '.inputSearch', url : '/partnerusers/index/'}
		 * This is sent from view.ctp
		 * 
		 * @property config
		 * @type {Object}
		 * @default {}
		 */
		config : {},
		/**
		 * Init method to initialize search component
		 * 
		 * @method init
		 * @param {Object} {className : '.inputSearch', url : '/partnerusers/index/'}
		 */
		init : function(arg){
			
			debug.log('$Brid.Html.Search.init()', arg);
			if(arg.className==undefined) throw new ArgumentException('Argument "className" must sent as obj.argument. E.g {className : ".inputSearch"}');
			if(arg.model==undefined) throw new ArgumentException('Argument "model" must sent as obj.argument. E.g {model : "Partner"}');
			
			if(arg.controller==undefined){
				arg.controller = arg.model.toLowerCase()+"s";
			}
			if(arg.form==undefined){	//Form ID
				arg.form = arg.model+"IndexForm";
			}
			if(arg.button==undefined){	//Button ID
				arg.button = 'button-search-'+arg.model;
			}
			arg.loadingMsg = ''; //Disable loading message for search
			if(arg.into==undefined){	//Button ID
				arg.into = '.bp_list_items';
			}
			var putContentIntoDivClass = jQuery('#'+arg.form).attr('data-loadIntoDivClass'); //Set div into we want to load content from View
			if(putContentIntoDivClass!=undefined){ 
				arg.into = '.'+putContentIntoDivClass;
			}
			
			if(arg.putContentIntoDivClass!=undefined){
				arg.into = '.'+arg.putContentIntoDivClass;
			}
			
			arg.callback = {
					after : {
						name : 'searchLoaded',
						element : {arguments : arg}
					}
			}
			this.config = jQuery.extend(false, {}, arg);
			debug.log('Search config: ', this.config);
			$Brid.stopTimeout('Search.search');
			//Input field
			jQuery('#'+arg.button).off('click.Search', this.click).on('click.Search', this.click);
			//Input field
			jQuery('.inputSearch').off('keyup.Search', this.keyup).on('keyup.Search', this.keyup);
			jQuery('.inputSearch').off('keydown.Search', this.keydown).on('keydown.Search', this.keydown);
			jQuery('.inputSearch').off('keypress.Search', this.keypress).on('keypress.Search', this.keypress);
		},
		doSearch : function(){
			var controlelr = $Brid.Html.Search.config.model+'s';
			var model = $Brid.Html.Search.config.model;
			var tmpObj = jQuery("#"+controlelr+"-content");
			var dataObject = {action : controlelr.toLowerCase(), search : jQuery('#'+model+'Search').val()};
			
			if(typeof $Brid.Html.Search.config.objInto != "undefined") {
				tmpObj = jQuery($Brid.Html.Search.config.objInto);
			}

			if(typeof $Brid.Html.Search.config.mode != "undefined") {
				dataObject.mode = $Brid.Html.Search.config.mode;
			}
			
			if(typeof $Brid.Html.Search.config.subaction != "undefined") {
				dataObject.subaction = $Brid.Html.Search.config.subaction;
			}
			if(typeof $Brid.Html.Search.config.playlistType != "undefined") {
				dataObject.playlistType = $Brid.Html.Search.config.playlistType;
			}
			if(typeof $Brid.Html.Search.config.buttons != "undefined") {
				dataObject.buttons = $Brid.Html.Search.config.buttons;
			}
			
			
			$Brid.Api.call({data : dataObject , callback : {after : {name : "insertContent", obj :tmpObj }}});

		},
		/**
		 * On click button search
		 * 
		 * @method click
		 * @parame {Object} Event
		 */
		click : function(e){
			debug.log("Click search button: ");
			$Brid.stopTimeout('Search.search');
			//WP AJAX CALL
			$Brid.Html.Search.doSearch();
		},
		/**
		 * On keyup search handler
		 * 
		 * @method keyup
		 * @param {Object} Event
		 */
		keyup : function(e){ 
			debug.log('$Brid.Html.Search.keyup()', 'Event', e);
			e.preventDefault();
			$Brid.stopTimeout('Search.search');
			if ( e.which != 13 )
		    {  
				$Brid.timeout['Search.search'] = setTimeout(function(){

					debug.log("AUTO CALL Search on TIMEOUT: ", $Brid.Html.Search.config);
					$Brid.stopTimeout('Search.search');

					$Brid.Html.Search.doSearch();
					//AJAX CALL
					//var controlelr = $Brid.Html.Search.config.model+'s';
					//var model = $Brid.Html.Search.config.model;
					
					//$Brid.Api.call({data : {action : "get"+controlelr, search : jQuery('#'+model+'Search').val()} , callback : {after : {name : "insertContent", obj : jQuery("#"+controlelr+"-content")}}});

					//$Brid.Api.call({data : {action : "getVideos"}, callback : {after : {name : "insertContent", obj : jQuery("#Videos-content")}}});
		
					//$Brid.Ajax.load($Brid.Html.Search.config);
				
				}, $Brid.Html.Search.delay);
				
		    }
		},
		/**
		 * On keydown search handler
		 * 
		 * @method keydown
		 * @param {Object} Event
		 */
		keydown : function(e){ 
			//e.preventDefault();
			debug.log('$Brid.Html.Search.keydown()', 'Event', e);
			$Brid.stopTimeout('Search.search');
			//return false;
		},
		/**
		 * On keypress search handler
		 * 
		 * @method keypress
		 * @param {Object} Event
		 */
		keypress : function(e){
			debug.log('$Brid.Html.Search.keypress()', 'Event', e.which);
			//e.preventDefault();
			if ( e.which == 13 )
		    { 
				$Brid.stopTimeout('Search.search');

				e.preventDefault();
				//AJAX CALL
				$Brid.Html.Search.doSearch();

				//$Brid.Ajax.load($Brid.Html.Search.config);
		    	//debug.log("Search: " + $Brid.Html.Search.config);
		    	//search(formId, searchUrl);
		    }
		}
};
$Brid.Html.Search = jQuery.extend(true, {}, Search);

/**
 * Used to generate Custom Radio buttons (e.g. Players Add/Edit page)
 * 
 * @class $Brid.Html.Radio
 * @constructor
 */
var Radio = {
		/**
		 * Init and bind every radio button that have class attibute ".options"
		 * 
		 * @method init
		 */
		init : function(){
			debug.log('$Brid.Html.Radio.init()', 'Init custom radio buttons.');
			jQuery('.options').off('click', this.click).on('click', this.click);
		},
		/**
		 * What will happen when we click on radio button
		 * 
		 * @method click
		 * @param {Object} e Event
		 */
		click : function(e){
			
	    	//target clicked (should always be LI tag
	    	var target = (jQuery(e.target).hasClass('option')) ? jQuery(e.target) : jQuery(e.target).parent(); //check parent if img is clicked
	    	
	    	//get li element
	    	if(target.hasClass('option'))
	    	{
	    		if(!target.parent().hasClass('disabledCheckbox'))
	    		{
		    		var input =jQuery(this).find(':input');
		    		input.val(target.attr('data-value'));	//Set value into hidden field
		    		jQuery(this).find('.ul-opitons li').find('.option_selected').hide();	//Hide all dots selected
		    		jQuery(target).find('.option_selected').fadeIn(200);	//Show red dot
		    		$Brid.Util.executeCallback($Brid.Callbacks, input.attr('data-method'), input);
	    		}
	    		
	    	}
		}
}
$Brid.Html.Radio = jQuery.extend(true, {}, Radio);

/**
 * Util object defines all necessary Util function that are used all over the place
 * Something like static calls with possible returns
 * Static Class
 * 
 * @class $Brid.Util
 */
var Util = {
	/**
	 * Array of allowed streaming extenstions
	 * 
	 * @property allowedStreamingExtensions
	 * @type {Array}
	 */
	allowedStreamingExtensions : ['f4m','smil','m3u8'],

	//Add shortcode to post - will close fancybox
	addToPost :  function(shortCodes){
		
		debug.log('$Brid.Util.addToPost()', shortCodes);

		if(jQuery('.wp-editor-area').is(':visible'))
		{
			var cursorPos = jQuery('.wp-editor-area').prop('selectionStart');
	    	var v = jQuery('.wp-editor-area').val(); //shortCodes;
	    	var textBefore = v.substring(0,  cursorPos ), textAfter  = v.substring( cursorPos, v.length );

	   		jQuery('.wp-editor-area').val( textBefore+ shortCodes +textAfter );
	   		
		}else{
			var a = tinyMCE.activeEditor.getContent();

			//tinyMCE.activeEditor.setContent(a + shortCodes, {format : 'raw'});

			tinyMCE.activeEditor.execCommand('mceInsertContent', false, shortCodes);
		}
		
   		//jQuery.fancybox.close( true );
		jQuery.colorbox.close();


	},
	//Translate redirect url
	 getRedirectUrl : function(a){
	 		debug.log('$Brid.Util.getRedirectUrl()');
                var ret = {action : 'videos'};

                var regex = new RegExp("\/videos\/edit\/[0-9]", "i");
	    		if(regex.test(a)){
	    			ret.action = 'editVideo';
	    			ret.id = a.replace('/videos/edit/', '');
	    		}

                switch(a){

                    case '/playlists/index/':
                        ret.action = 'playlists'
                    break;
                }
                debug.log('$Brid.Util.getRedirectUrl()', 'return:', ret);

                return ret;

        },
		/**
		 * Execute callback if there is any
		 * 
		 * @method executeCallback
		 * @param {Object} Object on which we want to execute "method"
		 * @param {String} method that we want to execute
		 * @param {Object} Argument that we want to pass to the method that we want to execute
		 */
		executeCallback : function(obj, method, arg){
			try{
				if(method!=undefined){
					debug.log('$Brid.Util.executeCallback()', 'Object: '+obj.className+' on click call: '+obj.className+'.'+method+'(); Args:', arg, 'Object:', obj);
					
					if(arg!=undefined){
						obj[method].apply(obj, [arg]); //chk will be sent as an argument
					}else{
						obj[method].apply(obj); //chk will be sent as an argument
					}
				}else{
					debug.warn('Callback method ('+obj.className+'.'+method+'()) is undefined. Add function "method" attribute of the HTML element and define your method "'+method+'" in "'+obj.name+'" Object. Method will receive input element as argument.', obj)
				}
			}catch(e){
				if(e instanceof TypeError){
					debug.warn('Check is there callback method "'+method+'" defined in object "'+obj.className+'". Called undefined Function: '+obj.className+'.'+method+'();', e.message, e.stack);
				}else{
					debug.error('$Brid.Util.executeCallback()', 'Object call: '+obj.className+'.'+method+'();' ,e.message, {stack : e.stack});
				}
			}
		},
		/**
		 * Do uppercase of the first char of the string
		 * 
		 * @method ucfirst
		 * @param {String}
		 */
		ucfirst : function(string){
			debug.log('$Brid.Util.ucfirst()');
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
		/**
		 * Make random ID of the string
		 * 
		 * @method makeid
		 * @param {Integer} len | Length of the unique id, defualt is 5
		 */
		makeid : function(len){
			debug.log('$Brid.Util.makeid()');
			if(len==undefined) len = 5;
		       
	        return Math.random().toString(36).substr(2, len)
		},
		/**
		 * Position element on the centar of the parent
		 * 
		 * @method center
		 * @param {jQuery} Object element - Element that we want to centar
		 * @param {jQuery} Object element - Element in relation to which we want to center
		 */
		center : function(element, parent){
			debug.log('$Brid.Util.center()');
	    	jQuery(element).css({
	            position:'absolute',
	            left: (jQuery(parent).width() - jQuery(element).outerWidth())/2,
	            top: (jQuery(parent).height() - jQuery(element).outerHeight())/2
	        });
	    },
	    /**
	     * Check is mobile
	     * 
	     * @method isMobileDevice
	     * @param {String} "ios"
	     * @return {Boolean}
	     */
	    isMobileDevice : function(option){
	    	debug.log('$Brid.Util.isMobileDevice()', option);
	    	if(typeof option == "undefined"){
	    		return jQuery.browser.mobile;
	    	}
	    	else if(option == 'ios'){
	    			return (navigator.userAgent.match(/iPhone|iPad|iPod/i));
	    	}else{
	    		return jQuery.browser.mobile;
	    	}
	    },
	    /**
	     * Check is argument valid email address
	     * 
	     * @method isEmailValid
	     * @param {String} url
	     * @return {Boolean}
	     */
	    isEmailValid : function(email){
	    	debug.log('$Brid.Util.isEmailValid()', email);
	    	 var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	    	 return pattern.test(email);
	    },
	    /**
	     * MAYBE REDUDANT!!!!!!!!!!!!!!!!!!!!! USE isUrl or isFileUrl???
	     * Check is argument valid url string
	     * 
	     * @method isFileUrl
	     * @param {String} url
	     * @return {Boolean}
	     */
	    isFileUrl : function(url){
	    	debug.error('$Brid.Util.isFileUrl() Possible redudant method @see $Brid.Util.isUrl VS $Brid.Util.isFileUrl', url);
	    	var regex = new RegExp("(http|ftp|https)://[a-z0-9\-_]+(\.[a-z0-9\-_]+)+(\.[a-z]{2,4})+\/[a-z0-9\-_\/]+(\.[a-z]{2,4})", "i");
	    	return regex.test(url);
	    },
	    /**
	     * Check is argument valid url string
	     * 
	     * @method isUrl
	     * @param {String} url
	     * @return {Boolean}
	     */
	    isUrl : function(url){
	    	debug.log('$Brid.Util.isUrl()', url);
	    	var regex = new RegExp("(http|https|ftp|rtmp)://(www\.)?([a-z0-9\-_\.])+\.([a-z]{2,6})/(.)*", "i");
	    	debug.log('$Brid.Util.isUrl()', regex.test(url));
	    	return regex.test(url);
	    },
	    
	    /**
	     * Check is extension of the url string against allowedExtensions array
	     * 
	     * @method
	     * @param {String} url
	     * @param {Array} allowedExtensions
	     * @return {Boolean}
	     */
	    checkExtension : function (url, allowedExtensions){
	       debug.log('$Brid.Util.checkExtension()', url, allowedExtensions);
	       if(allowedExtensions==undefined) throw new ArgumentException('"allowedExtensions" second argument is missing.');
    	   var extension = url.substr( (url.lastIndexOf('.') + 1), 4);
    	   extension = extension.replace('?','').replace('#','');
    	   if (jQuery.inArray(extension.toLowerCase(), allowedExtensions) > -1) {
    	            return true;
    	   }
    	   debug.warn('$Brid.Util.isFileUrl()', 'Bad extension: ' , extension);
    	   return false;
    	},
    	/**
    	 * Prevent only numbers
    	 * $Brid.Util.onlyNumbers
    	 * 
    	 * @method onlyNumbers
    	 * @param {Object} Event
    	 */
    	onlyNumbers : function(e){
    		if ((e.which<48 || e.which>57) && e.which!=37 && e.which!=8 && e.which!=0) {				// keyCode ne radi u FF
    			debug.log(e.which);
    			return false; 
    		}
    	},
    	/**
    	 * $Brid.Util.clickUrl
    	 * 
    	 * @method clickUrl
    	 * @param {Object} Event
    	 */
		clickUrl : function(e){
			if(jQuery(this).attr('data-target')!=undefined){
				window.open(jQuery(this).attr('data-href'));
			}else{
				window.location =   jQuery(this).attr('data-href');
			}
		},
		/**
		 * Show dialog (modal box)
		 * $Brid.Util.openDialog(msg, title);
		 * 
		 * @method openDialog
		 * @param {String} message
		 * @param {String} title
		 */
		openDialog : function (msg, title){

			debug.log('$Brid.Util.openDialog', msg);
			var cnt = '';
			if(title!=undefined){
				
				cnt += '<h2>'+title+'</h2>';
				
			}
			cnt += '<p>'+msg+'</p>';
			//Defined in jquery.plugins.min.js
			modal.open({content: cnt});

		},
		
		/**
	     * Url validator 
	     * 
	     * @method isUrl
	     * @param {String} url
	     * @return {Boolean}
	     */
		isUrlString : function(url){
			debug.log('$Brid.Util.isUrlString()', url);
			var urlPattern = /^((https?|ftp|rtmp):\/\/|(www|ftp)\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+([/?].*)?$/;
			return url.match(urlPattern);
			
		},
	    /**
	     * Youtube Url validator 
	     * 
	     * @method isUrl
	     * @param {String} url
	     * @return {Boolean}
	     */
		isYoutubeUrl : function(url){
			debug.log('$Brid.Util.isYoutubeUrl()', url);
			var pattern = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
			return url.match(pattern);
		},

		
		/**
		 * Checks if Url is streaming url
		 * @param {String} url
		 * @return {Boolean}
		 */
		isStreamingUrl : function(url){
			debug.log('$Brid.Util.isStreamingUrl()',url,this.allowedStreamingExtensions);
			return $Brid.Util.checkExtension(url, this.allowedStreamingExtensions) || ($Brid.Util.isUrl(url) && url.match(/^rtmp:\/\//) != null);

		}
}

$Brid.Util = jQuery.extend(true, {}, Util);

var Uploader = {
	/**
	 * Main script path to ping for status or progress
	 * 
	 * @property script_path
	 * @type {String}
	 */
	script_path : 'http://cms.brid.tv/videos/',
	/**
	 * Filename of the file to upload
	 * @propery filename
	 * @type {String}
	 */
	filename : null,
	/**
	 * Old file / Upload twice same file no no
	 * @property oldifle
	 * @type {String}
	 */
	oldfile : null,
	/**
	 * Filesize
	 * @property filesize
	 * @type {Number}
	 */
	filesize : 0,
	/**
	 * Counter for tracking "starting" state (max 15)
	 * Track counter how many "starting" status responses you received
	 * 
	 * @property start_counter
	 * @type {Number}
	 */
	start_counter : 0,
	/**
	 * Maximum number to wait "starting" status response
	 * @property maxStartNumber
	 * @type {Number}
	 */
	maxStartNumber : 15,
	/**
	 * Session id
	 * @property sid
	 * @type {String}
	 */
	sid : '',
	/**
	 * Call s3 upload flag
	 * @property s3uploads
	 * @type {Boolean}
	 */
	s3uploads : false,
	/**
	 * Upload form action
	 * @property uploadForm
	 * @type {Object}
	 */
	uploadForm : null,
	/**
	 * Upload form action
	 * @property action
	 * @type {String}
	 */
	action : '',
	/**
	 * Upload Button jQuery
	 * @property uploadButton
	 * @type {String}
	 */
	uploadButton : null,
	/**
	 * Upload messages
	 * @property uploadMsg
	 * @type {String}
	 */
	uploadMsg : '',
	/**
	 * Upload file input
	 * @property uploadMsg
	 * @type {Object}
	 */
	upload : null,
	/**
	 * Upload limit in file size 10000 by default (in bytes)
	 */
	uploadLimit : '100MB',
	/**
	 * Only used for displaying propper error msg
	 */
	uploadFriendlyLimit :'100MB',
	/**
	 * Copy to s3 flag
	 * @property s3uploads
	 * @type {Boolean}
	 */
	s3uploads : false,
	/**
	 * Is upload canceled
	 * @property canceled
	 * @type {Boolean}
	 */
	canceled : false,
	/**
	 * Number of error retrieve attempts, max 15
	 * @property errorRetrieve
	 * @type {Int}
	 */
	errorRetrieve : 0,
	/**
	 * If run receive empty response, try to retrieve responses 10 times
	 * @property emptyResponseRetrieve
	 * @type {Int}
	 */
	emptyResponseRetrieve : 0,
	/**
	 * Upload input element, inject it on init
	 * @property uploadInputTemplate
	 * @type {String}
	 */
	uploadInputTemplate : '<input name="userfile" id="userfile" type="file"/>',
	/**
	 * Upload file extnesion
	 * @property extension
	 * @type {String}
	 */
	extension : '',
	/**
	 * List of available extensions @see http://edchelp.wpengine.com/?kb_article=what-input-media-formats-are-supported
	 * @property allowedExtensions
	 * @type {String}
	 */
	allowedExtensions : 'mp4,mov,qt,flv,f4v,wmv,asf,mpg,vob,m2v,mp2,m4v,avi,webm,ogv,ogg,mxf,mts,mkv,r3d,rm,flac,mj2,mpeg',
	/**
	 * Progress object, contain progress elements
	 * @class Progress
	 * @constructor
	 */
	Progress : {
		/**
		 * Porgress div
		 * @property progress
		 * @type {Object}
		 */
		element : null,
		/**
		 * Starting upload progress msg
		 * @property start
		 * @type {Object}
		 */
		start : '<div id="prog_c1" style="display:none;"></div><div id="uploadStatus">Starting upload...</div>'
	},
	/**
	 * Exception Object
	 * @class Exception
	 */
	Exception : function(msg){
		this.name = 'UploadException';
	    this.message = msg;
	    this.stack = (new Error()).stack;
	    $_this = this;
	},
	convertSize : function(uploadLimit){
		
		var mb = parseInt(uploadLimit.replace('MB',''));
		
		return mb * 1000 * 1000;
	},
	convertSizeFriendly : function(upLimit){

		var mb = parseInt(upLimit.replace('MB',''));

		if(mb>=1000) { return parseInt(mb/1000)+'GB'; }
		if(mb<1000) { return mb+'MB'; }

		return upLimit;

	},
	/**
	 * Init main function for uploader, will initialize staring elements
	 */
	init : function(arg){
		
		//debug.log('aaaaaaaaaaaaaaaaarrrrrrrrrrrrrrrrgggggggggggggggggg', this.convertSize(arg.uploadLimit));
		if(jQuery('#upload').length>0){
			Uploader.Exception.prototype = new Error; 
			var uploadLimit = (arg!=null && arg.uploadLimit!=undefined) ? arg.uploadLimit : this.uploadLimit;
			
			debug.log('$Brid.Uploader.init()', 'Initialize Uploader Object.');
			this.uploadLimit = this.convertSize(uploadLimit);
			this.uploadFriendlyLimit = this.convertSizeFriendly(uploadLimit);
			this.uploadForm = jQuery('#upload');//upload form
			this.uploadForm.attr('action', 'https://upload.encoding.com/upload');
			this.action = this.uploadForm.attr('action'); //form action
			this.Progress.element = jQuery('#progress');	//progress main div
			this.uploadButton = jQuery('#userfileButton');	//user upload button
			this.uploadMsg = jQuery('#uploadMsg');	//upload message div
			//<input name="userfile" id="userfile" type="file"/>
			jQuery('#uploadInputHide').html(this.uploadInputTemplate).css({height : '280px'});//Inject new input element on every init
			this.upload = jQuery('#userfile');
			this.uploadCloseBtn = jQuery('#uploadCloseBtn');
			
			var self = this;
	
			self.resetFields();
			/*self.uploadButton.off('click.Upload');
			self.uploadButton.on('click.Upload', function(){
				debug.log('$Brid.Uploader.init()', 'userfileButton CLick');
				self.upload.trigger("click");
			});*/
			self.uploadCloseBtn.off('click.Upload');
			self.uploadCloseBtn.on('click.Upload', function(){
				debug.log('$Brid.Uploader.init()', 'uploadCloseBtn CLick');
				self.cancel();
			});
			self.upload.off('change.Upload');
			
			self.upload.on('change.Upload', self.filechange);
			jQuery('#uploadInputHide').hover(function(){ jQuery('#userfileButton').addClass('userfileButtonHover'); }, function(){ jQuery('#userfileButton').removeClass('userfileButtonHover');});
			//self.upload.off('drop.Upload');
			//self.upload.on('drop.Upload', function(e){
				//console.log(this);
				//self.filechange(e);
			//});
			
		}else{
			debug.warn('Calling Brid.Uploader.init() and there is no upload form available on this page.');
		}
	},
	getInstance : function(){
		
		return this;
	},
	/**
	 * Reset upload form hidden fields
	 * @method resetFields
	 */
	resetFields : function(){

		jQuery('#uid').val('');
		jQuery('#sid').val('');
		jQuery('#timestamp').val('');
		jQuery('#signature').val('');
		jQuery('#progress').html('');
	},
	/**
	 * Get input filename
	 * @method getFileName 
	 */
	getFileName : function(){
		
		var value = this.upload.val();
		if (value.indexOf(':\\') == 1) {
			value = value.split(":").pop().split("\\").pop();
		}
		return value;

	},
	/**
	 * errorCallback helper funciton
	 */
	errorCallback : function(a){
		try{
			debug.error('$Brid.Uploader.errorCallback()', a);
			throw new Uploader.Exception(a);
		}catch(e){
			debug.error(e);
			$Brid.Util.openDialog(e.message,"Upload error, please reupload.");
			jQuery('#progress').html();
			jQuery('#userfileButton').show();
			$Brid.init(['Html.Uploader']);
		}
	},
	/**
	 * On file select event
	 * @method filechange
	 */
	filechange : function(e){
		try{
			debug.group("UPLOADER");
			debug.log('$Brid.Uploader.filechange()', e, this.files);
			var self = $Brid.Html.Uploader.getInstance();
			self.oldfile = this.filename;	
			self.filename = self.getFileName();
			self.extension = self.filename.split('.').pop().toLowerCase();
			self.fileSize = this.files[0].size;
			
			//Check extension
			if(jQuery.inArray(self.extension, self.allowedExtensions.split(','))==-1){
				throw new Uploader.Exception("File selected is not has not valid extension.<br/>Supported extensions are:<br/>"+self.allowedExtensions);
			}
			if(this.files[0]!=undefined)
			{
				//Max upload filesize
				if(this.files[0].size>self.uploadLimit){
					throw new Uploader.Exception("Maximum upload filesize limit is "+self.uploadLimitFriendly+'.');
				}
			}
			//Filename?
			if(self.filename==""){
				  throw new Uploader.Exception("Please select a file first.");
			}
			//Is same as old filename?
			if(self.upload.val()==self.oldfile || self.upload.val()==''){
				throw new Uploader.Exception("File selected is same as old file. Please select a different file to upload.");
			}
			
			jQuery('#VideoUploadInProgress').val(1); //Set upload in progress value
			
			
			//Get signer info
			jQuery.ajax({url : self.script_path+'signer/.json', type : 'GET'}).done(function(data) {
				  
				if(typeof data == 'object' && data.sid!=undefined){
					debug.log('$Brid.Uploader.filechange()', 'response', data);
					
			  		jQuery('#sid').val(data.sid);
			  		jQuery('#uid').val(data.uid);
			  		jQuery('#timestamp').val(data.timestamp);
			  		jQuery('#signature').val(data.signature);
					
					self.sid = data.sid;
					self.uploadForm.attr('action', self.action  + "?X-Progress-ID="+data.sid);
					
					//$(window).on('onbeforeunload', $Brid.Html.Uploader.leavePageDuringUpload);
					window.onbeforeunload = function(e) {
						  return 'YOUR UPLOAD WILL BE CANCELED IF YOU LEAVE THIS PAGE NOW.';
						};
					
					debug.log('$Brid.Uploader.filechange()', 'Call start');
					self.start(); //Start upload
				}else{
					self.errorCallback.call(self, 'Response is not an object type');
					//throw self.Exception('Response is not an object type');
				}
					
			 }).fail(function(jqXHR, textStatus, errorThrown){
		
				 debug.error('$Brid.Html.Uploader.filechange()', 'Response failed:', jqXHR.responseText, textStatus, 'errorThrown:', errorThrown);

				 self.failCallback.call(self, jqXHR, textStatus, errorThrown);
				 
			 });
			
			
		}catch(e){
			debug.error(e);
			 $Brid.Util.openDialog(e.message,"input error");
		}
	},
	/**
	 * Cancel upload, sets cancel flag
	 * @method cancel
	 */
	cancel : function(){
		
		debug.log('$Brid.Html.Uploader.cancel()');
		this.canceled = true;
		if(this.uploadMsg.length>0){
			this.uploadMsg.html('Canceling upload...');
		}
		//If video has been saved during the upload process,
		//execute delete of the "none-uploaded but saved" video
		var videoId = jQuery('#VideoId').val();
		//If video id exist, video is saved during the upload process
		if(videoId!=''){
			debug.log('Delete video :'+videoId+' on upload canceled.');
			var object = {	
						controller : 'videos',
						action : 'delete',  
						data : 'data[Video][ids]='+videoId,
						};
		    $Brid.Ajax.update(object);
	    }
		
	},
	/**
	 * If cancel flag is set to true reset to starting point
	 * @method reset
	 */
	reset : function(){
		debug.log('$Brid.Html.Uploader.reset()');
		if(jQuery('#VideoUploadInProgress').length>0 && jQuery('#VideoUploadInProgress').val()==1){
		
			$Brid.stopTimeout('Uploader.progress');
			jQuery('#VideoUploadInProgress').val(0);
		}
		window.onbeforeunload = null;

		var name = "insertContentVideos", div = "#Videos-content";
		$Brid.Api.call({data : {action : 'addVideo'}, callback : {after : {name : name, obj : jQuery(div)}}});
		/*					
		jQuery('#uid').val('');
		jQuery('#sid').val('');
		jQuery('#timestamp').val('');
		jQuery('#signature').val('');
		this.Progress.element.html('');
		this.uploadMsg.html('');
		this.filename = null;
		this.filesize = 0;
		this.oldfile = null;
		this.start_counter = 15;
		this.s3uploads = false;
		this.canceled = false;
		this.extension = '';
		
		jQuery('.form-table').hide();
		jQuery('#uploadCloseBtn').hide(); //Hide cancel
		
		jQuery('#UploaderForm').show(300, function(){
			jQuery('#uploadButtonDiv').show();
			jQuery('#uploadInputHide').css({height : '280px'});
			//Re Init uploader
			$Brid.init(['Html.Uploader']);
			
		});
*/
		
	},
	/**
	 * Start upload get progress and call this.run
	 * @mehtod start
	 */
	start : function(){
		
		debug.log('$Brid.Uploader.start()');
		var self = this;
		//Fade out button, and show input form
		jQuery('#uploadButtonDiv').fadeOut(300, function(){
			jQuery('.fetchWarring').hide();
			jQuery('#fetchDiv').hide();
			  //Show Starting progress bar
			self.Progress.element.html(self.Progress.start);
			jQuery('#prog_c1').fadeIn(); //Show progress
			jQuery('#uploadCloseBtn').fadeIn(); //Show cancel
			jQuery('#uploadInputHide').css({height : '0px'});
			self.uploadMsg.html("PLEASE DO NOT LEAVE THIS PAGE BEFORE UPLOAD IS COMPLETE.").fadeIn();
			//Show input form
			jQuery('.form-table').fadeIn();
		  });
		self.uploadForm.submit();
		
		jQuery.ajax({url : self.script_path+'progress/'+self.sid, type : 'GET'}).done(function(data) {
			  
			var resp = eval("("+data+")");
			
			if(typeof resp == 'object' && resp.state != 'error'){

				jQuery('#VideoProgressSignature').val(self.sid);
				
				debug.log('$Brid.Uploader.start()', 'response', resp);
				
				debug.log('$Brid.Uploader.start()', 'Run call');
				self.run(); //Run upload
			}else{
				debug.error('$Brid.Uploader.start()', resp, data);
				self.errorCallback.call(self, 'Response is not an object type. Error:(1)');
				
			}
				
		 }).fail(function(jqXHR, textStatus, errorThrown){
	
			 debug.error('$Brid.Html.Uploader.start()', 'Response failed:', jqXHR.responseText, textStatus, 'errorThrown:', errorThrown);

			 self.failCallback.call(self, jqXHR, textStatus, errorThrown);
			 
		 });
		
	},
	/**
	 * Main callback function to update status of the upload progress bar
	 */
	updateStatus : function(){
		
		var self = this, received = 0, size=0, percentage=0, width = 740;
		 
		 if(self.response.state == "uploading"){
			received = self.response.received;
			size = self.response.size;
			
			
			var percentage = Math.round(Number(self.response.received)/(Number(self.response.size)/100));

			var widthPercentage = (width * percentage) / 100;
			debug.log('------------FileUploader.callback', received, size, percentage);
			
			if(jQuery('#prog_c2').length>0){
				//alert('ucito');
				var currentWidth = parseInt(jQuery('#prog_c2').width());
				
				jQuery('#prog_c2').animate({width:"+="+(widthPercentage-currentWidth)},300, function(){
					//$(this).html('<div id="uploadStatus">'+percentage+'%</div>');
					jQuery('#uploadStatus').html(percentage+'%');
				});
				
				
			}else{
				jQuery('#uploadStatus').remove();
				jQuery('#prog_c1').html('<div id="prog_c2" style="width:0px;display:block;"></div><div id="uploadStatus">0%</div>');
				
				jQuery('#prog_c2').animate({width:"+="+widthPercentage},400, function(){
					jQuery('#uploadStatus').html(percentage+'%');
					//$(this).html('<div id="uploadStatus">'+percentage+'%</div>');
				});
			}
			
		 }
		 
		 
		 if(self.response.state == "done"){
		 	
		 	if(self.error_message == '' || typeof(self.error_message) == 'undefined')
		 	{
				
				if(jQuery('#uploadStatus').html()!='100%'){
					
					jQuery('#prog_c2').animate({width:width},300, function(){
						//$(this).html('<div id="uploadStatus">100%</div>');
						jQuery('#uploadStatus').html('100%');
					});
				}
				
			} else {
				self.Progress.element.html('An error occurred: '+ self.error_message);
			}
		 }
		 
	},
	/**
	 * Run progress, check progress of the upload and call this.updateStatus
	 * @method run
	 */
	run : function(){
		debug.log('$Brid.Uploader.run()');
		var self = this;
		var act = (self.s3uploads)?'progress/' + self.sid + '/s3uploading/': 'progress/' + self.sid;
	    var url  = self.script_path  + act;
	    
	    if(self.canceled){
	    	self.reset();
	    	return false;
	    }
	    
	    jQuery.ajax({url : url, type : 'GET'}).done(function(resp) {
			
			if(self.canceled){
		    	self.reset();
		    	return false;
		    }
	    	if(resp=='' && resp.responseText == "")
		    {
	    		if(self.emptyResponseRetrieve>=10){
	    			self.emptyResponseRetrieve++;
	    			debug.warn('Response was empty, retry:', self.emptyResponseRetrieve);
	    			$Brid.stopTimeout('Uploader.progress');
	    			$Brid.timeout['Uploader.progress'] = setTimeout(function(){self.run.call(self)}, 2000);
	    		}
		    	return;
		    }
	    	var response = eval("("+resp+")");
	    	
			self.response = response;
			
			if(response.size!=undefined && self.filesize==0){
				
				self.filesize = response.size; //set file size
			}

			if(typeof response != 'object'){ self.errorCallback.call(self, 'Error:(run):Response is not an object.'); }
			if(typeof response.state == 'undefined'){ self.errorCallback.call(self, 'Error:(run): Response "state" is undefined.'); }
			
			debug.log('Upload.run', response, response.state);
			  
			switch(response.state){
			
				case "error":
					if(self.canceled){
				    	self.reset();
				    	return false;
				    }else{
						self.errorCallback.call(self, 'Error:(run), Response returned error status:'+response.status);
					}
					break;
				case "starting":
					self.start_counter++;
					$Brid.stopTimeout('Uploader.progress');
					$Brid.timeout['Uploader.progress'] = setTimeout(function(){self.run.call(self)}, 2000);
					if(self.start_counter == self.maxStartNumber) {
						$Brid.stopTimeout('Uploader.progress');
						self.start_counter = 0;
						self.errorCallback.call(self, 'Error:(run), '+"Start counter reached max 15 start counts." + resp.responseText);
						
					}
					break;
					
				case "done":
					if(self.s3uploads) {
						   //Uploaded do AMAZON S3
						   
						   self.finish();
					   } else {
						   
						   debug.log('Upload.run enter s3Upload');
						   
						   self.s3uploads = true;
						   $Brid.stopTimeout('Uploader.progress');
						   $Brid.timeout['Uploader.progress'] = setTimeout(function(){self.run.call(self)}, 2000);
						   //self.response.state = "processing";
						   //self.response.progress = 0;
					   }
					break;
					
				  default: 
					$Brid.stopTimeout('Uploader.progress');
					$Brid.timeout['Uploader.progress'] = setTimeout(function(){self.run.call(self)}, 2000);
				break;
			}
			
			
			self.updateStatus.call(self);
				
		 }).fail(function(jqXHR, textStatus, errorThrown){
			 
			 debug.error('$Brid.Html.Uploader.run()', 'Response failed:', jqXHR.responseText, textStatus, 'errorThrown:', errorThrown);
			 
			 if(self.errorRetrieve<=15){
				 self.errorRetrieve++;
				 debug.warn('Response failed, retry:', self.errorRetrieve);
				 //Try to continue with larger timeout value 4 sec (maybe there was 404)
				 $Brid.stopTimeout('Uploader.progress');
				 $Brid.timeout['Uploader.progress'] = setTimeout(function(){self.run.call(self)}, 2000);
			 }else{
				 self.failCallback.call(self, jqXHR, textStatus, errorThrown);
			 }
		 });
	},
	/**
	 * On ajax fail callback
	 * @method failCallback
	 */
	failCallback : function(jqXHR, textStatus, errorThrown){
		
		debug.error('$Brid.Html.Uploader.failCallback()', 'Response failed:', jqXHR.responseText, textStatus, 'errorThrown:', errorThrown);
		 
		if(typeof jqXHR.responseText =='object')
		{
			   //It is JSON
				  var data = jQuery.parseJSON(jqXHR.responseText);
				 
				  if(data.message!=undefined)
					  $Brid.Html.FlashMessage.show({msg : data.message, status : false});
		 }
	},
	/**
	 * Finished
	 * @method finish
	 */
	finish : function(){
		
		debug.log('$Brid.Uploader.finish()');
		var self = this;

	    if(self.canceled){
	    	self.reset();
	    	return false;
	    }
		 jQuery.ajax({url : self.script_path + 'progress/' + self.sid + '/filename/', type : 'GET'}).done(function(resp) {
			 	
			 	var response = eval("("+resp+")");
				self.patch_to_file = response.filename;
				self.patch_to_minfo =  response.mediainfo;
				self.error_message =  response.error;
				self.s3uploads = false;
				
				if(response.error == '' || typeof(response.error) == 'undefined')
				{

					jQuery('#VideoUploadInProgress').val(0);
					self.uploadCloseBtn.hide();
					//$(window).off('onbeforeunload.Upload', $Brid.Html.Uploader.leavePageDuringUpload);
					//Fill in form data and encoding will be executed on save
					jQuery('#VideoOriginalFilename').val(self.patch_to_file);
					jQuery('#VideoXmlUrl').val(self.patch_to_minfo);
					jQuery('#VideoUploadSourceUrl').val(self.patch_to_file);
					jQuery('#VideoOriginalFileSize').val(self.filesize);
					//$('#VideoMp4').val(self.patch_to_file+'?nocopy');
					jQuery('#VideoMp4').val(self.patch_to_file); //?nocopy string does not pass mp4 url check
					if(jQuery('#VideoName').val()==''){
						jQuery('#VideoName').val(self.filename.slice(0, -4));
						jQuery('#default-value-VideoName').hide();
					}
					jQuery(self.uploadMsg).html('File uploaded successfully.');
					jQuery('#UploaderForm').delay(3000).fadeOut();
					/*
					self.Progress.element.fadeOut(300, function(){
						$(self.uploadMsg).html('File uploaded successfully.');
					}); //Hide progress bar
					*/
					self.startEncoding();
					window.onbeforeunload = null;
				}
				
					
			 }).fail(function(jqXHR, textStatus, errorThrown){
		
				 debug.error('$Brid.Html.Uploader.finish()', 'Response failed:', jqXHR.responseText, textStatus, 'errorThrown:', errorThrown);

				 self.failCallback.call(self, jqXHR, textStatus, errorThrown);
				 
			 });
	},
	/**
	 * Start encoding process if video is saved and video_id exist in our form 
	 * and if upload is not canceled
	 */
	startEncoding : function (){
		
		debug.log('$Brid.Uploader.startEncoding()');
		var videoId = jQuery('#VideoId').val();
		var self = this;

	    if(self.canceled){
	    	self.reset();
	    	return false;
	    }
		if(videoId!='' && !jQuery('#videoSaveAdd').hasClass("inprogress")){

			debug.log('$Brid.Uploader.startEncoding()', 'Start' ,'video id:'+videoId, self);
			
			var post_params = '';
			post_params += '&data[Video][upload_source_url]=' + self.patch_to_file+'?nocopy';
			post_params += '&data[Video][original_file_name]=' + self.filename;
			post_params += '&data[Video][upload_form]=1';
			post_params += '&data[Video][xml_url]=' + self.patch_to_minfo;
			
			jQuery.ajax({url : self.script_path + 'encode/' + videoId +'.json', type : 'POST', data : post_params}).done(function(resp) {
			 	
				debug.log('---------------Uploader.startEncoding' ,'response', resp);
				//Try to enable save button videos.js
				enableSave();
				debug.groupEnd();
					
			 }).fail(function(jqXHR, textStatus, errorThrown){
		
				 debug.error('$Brid.Html.Uploader.startEncoding()', 'Response failed:', jqXHR.responseText, textStatus, 'errorThrown:', errorThrown);

				 self.failCallback.call(self, jqXHR, textStatus, errorThrown);
				 
			 });
			
		}else{
			//Try to enable save button videos.js
			enableSave();
			debug.groupEnd();
		}
	}
	
}
$Brid.Html.Uploader = jQuery.extend(true, {}, Uploader);



/**
 * Fetch object is used on upload form to Fetch Alternativley pasted Url-s
 * 
 * @class $Brid.Fetch
 */
var Fetch = {
	/**
	 * Checks if url is valid or have valid extension for non-youtube videos
	 * @param {Object} o - Could be event target or manually called
	 */
	checkFetchUrl : function(o){

			debug.log('$Brid.Fetch.checkFetchUrl()', o);
			var popup = false;
			//
			var allowedExtensions = $Brid.Html.Uploader.allowedExtensions.split(',');
			if(o!=undefined && typeof o !='object'){ //Check is called on event, or we call it manually
				popup= o;
			}
			debug.log('$Brid.Fetch.checkFetchUrl()',typeof o,popup);

			var $button = jQuery('#goFetchUrl'), url = jQuery('#fetchUrl').val().trim(), httpPattern = /^((http|https):\/\/)/;
			
			if(url.match(httpPattern) === null && url.match(/^(rtmp:\/\/)/) === null){
				url = 'http://'+url;
			}
			
			try{
				if($button.hasClass('inprogress')) { 
					throw new ArgumentException('Fething video is in progress!');
				}
				
				if(!$Brid.Util.isUrlString(url)){
					throw new ArgumentException('Video url is not valid!');
				}
				
				if(!$Brid.Util.isYoutubeUrl(url) && (!$Brid.Util.checkExtension(url,allowedExtensions) && !$Brid.Util.isStreamingUrl(url))){
					throw new ArgumentException("File selected is not has not valid extension.<br/>Supported extensions are:<br/>"+allowedExtensions);
				}
				
				if($button.hasClass('disabled')){
						$button.removeClass('disabled');
				}
			}
			catch(e){ 
				debug.error('$Brid.Html.Form.checkFetchUrl()', e);
				if(!$button.hasClass('disabled') && !$button.hasClass('inprogress'))
					$button.addClass('disabled');
				if(e instanceof ArgumentException && popup){
					$Brid.Util.openDialog(e.message,'Input error');
				}
			}
		},
		/**
		 * Fetching videos from url on videaos add
		 */
		fetchUrl: function(){
			debug.log('$Brid.Fetch.fetchUrl()');
			this.checkFetchUrl(true);
			var $button = jQuery('#goFetchUrl');
			
			debug.log($button.hasClass('disabled'));
			if($button.hasClass('disabled') || $button.hasClass('inprogress')){
				return;
			}
			$button.addClass('inprogress');
			var url = jQuery('#fetchUrl').val().trim();
			
			var httpPattern = /^((http|https):\/\/)/;
			
			if(url.match(httpPattern) === null && url.match(/^(rtmp:\/\/)/) === null){
				url = 'http://'+url;
			}
			
			if($Brid.Util.isYoutubeUrl(url)) {
				jQuery.ajax({
			        //url: '/videos/fetch_video/'+".json",
			        url: ajaxurl,
			        data: {videoUrl : url, action : 'fetchVideo'},
			        type: 'POST',
			        beforeSend: function(){ $Brid.Html.FlashMessage.loading('In progress...'); }
				  }).done(function(data) {
						$Brid.Html.FlashMessage.show({msg : data.message, status : data.status});

						if(data.redirect!=undefined){
							//$Brid.Ajax.loadAjaxUrl(data.redirect,true);	
							var name = "insertContentVideos", div = "#Videos-content";
							$Brid.Api.call({data : $Brid.Util.getRedirectUrl(data.redirect), callback : {after : {name : name, obj : jQuery(div)}}});
								
						}

						$button.removeClass('inprogress');
				 }).fail(function(jqXHR, textStatus, errorThrown){
			
					  var data = jQuery.parseJSON(jqXHR.responseText);
					  debug.error('$Brid.Util.fetchUrl()', 'Response failed:', data, textStatus, 'errorThrown:', errorThrown);
					  var msg = (data.message!=undefined) ? data.message : data.name;
					  if(msg!=undefined || msg!='')
						  $Brid.Html.FlashMessage.show({msg : msg, status : false});
					  
				  });
					
			}
			else {

				jQuery('#UploaderForm').fadeOut(300,function(){ 
						jQuery('.fetchWarring').hide();
						jQuery('.form-table').fadeIn(300,function(){
							if($Brid.Util.isStreamingUrl(url)) {
								jQuery('#streamingSnapshot').show();
								}
							});
						});
				jQuery('#VideoUploadSourceUrl').val(url);
			}
		},
}
$Brid.Fetch = jQuery.extend(true, {}, Fetch);


/**
 * Video object is used on Videos add/edit
 * 
 * @class $Brid.Video
 */
var Video = {
		 /**
		  *     Array of allowed extensions
		  *     
		  * 	@property allowedExtensions
		  * 	@type {Array}
		  */
		 allowedExtensions : ['webm', 'ogg', 'vp8', 'mp4'],
		 
		 /**
		  *     Array of allowed video extensions 
		  * 
		  * 	@property allowedVideoExtensions
		  * 	@type {Array}
		  */
		 allowedVideoExtensions : ['webm', 'ogg', 'vp8', 'mp4', 'flv', 'mpeg', 'avi', 'mk4', 'mpg','3gp','m4v','mkv','mpe', 'wmv'],
		 
		  /**
		   * Video autosave, when save button is enabled
		   * we do auto save
		   * 
		   * 
		   *  @method autosave
		   */
		  autosave : function(){
	    	  debug.log('$Brid.Video.autosave()');
	    	  if(jQuery("#videoSaveAdd").hasClass('inprogress')){
	    		  $Brid.Util.openDialog('Save error', 'Save already in progress')
	    	  }
	    	  else {
			      jQuery('#autoSaving').show();
			      jQuery("#videoSaveAdd").addClass('inprogress');
			      save.save('VideoAddForm');
			      jQuery('#VideoAutosave').val(0);
	    	  }
		  },
		  /**
		   * Ajax: Get ffmpeg info about video (on VideoMp4 input)
		   * 
		   *  @method getFfmpegInfo
		   */
		  getFfmpegInfo : function(){
			  	debug.log('$Brid.Video.getFfmpegInfo()');
				var source = jQuery('#VideoMp4').val();
				var _this = this;

				jQuery("#videoSaveAdd,#videoSaveEdit").addClass('disabled');
				
				if(source!='' && $Brid.Util.isUrl(source) ){
					if($Brid.Util.isStreamingUrl(source)){
						this.enableSave();
						/**
						 * in case of streaming url files
						 * don't check codec
						 */
						return;
					}
					jQuery.ajax({
						//  url: '/videos/ffmpeg_info/.json',
						   url: ajaxurl, //+'?action=api&method=ffmpeg_info',
						  data: 'url='+source+'&action=ffmpegInfo',

						 // data: 'data[Video][mp4]='+source,
						  type: 'POST',
						  beforeSend: function(){
							  
							  if(!jQuery("#videoSaveAdd,#videoSaveEdit").hasClass('disabled'))
									jQuery("#videoSaveAdd,#videoSaveEdit").addClass('disabled');
							  

						  },
						  success: function(respData) { 
							  console.log("Received: ", respData);

							  if(typeof respData =='object')
							  {
								  if(respData.status && typeof respData.data == 'object'){

									  var codec = '';
									  var data = respData.data;
										for(var a in data){
											//Get codec of the input file
											if(a=='VideoCodec'){
												codec = data[a];
											}
											//Populate invisible input fields
											jQuery('#Video'+a).val(data[a]);
										} 
										debug.log(codec);
										//If supplied video is in valid codec type
										if (jQuery.inArray(codec, ['h264','webm','vp8']) > -1) {
										   console.log(this);
										   _this.enableSave();

										   //@todo Nisam siguran sta ovo radi?
				                           /*if ($('.textButtonSmallJs').text().toLowerCase().search("select category") == -1) {
				                               console.log('CAT: ' + $('.textButtonSmallJs').text().toLowerCase().search("select category"));
			    								//Show save button if it is mp4
			    								$("#videoSaveAdd").show();
				                           }*/
				                           
									    }else{
									    	$Brid.Util.openDialog('Invalid codec type:'+codec, 'Input error');
											if(!jQuery("#videoSaveAdd,#videoSaveEdit").hasClass('disabled'))
												jQuery("#videoSaveAdd,#videoSaveEdit").addClass('disabled');
									    }
										

								  }
								  
							  }
							 
						  }
					});
				}
		  },
		  /**
		   * Check all custom conditions to enable save button
		   * We do not use full advantage of automatic "requireField" check @see videoSaveAdd button and its property 'data-form-req'=>'0'
		   * 
		   *  @method enableSave
		   *  @param displayDialog {Booelan}	If displayDialog is present, it will pop up Dialog with message
		   */
		  enableSave : function(displayDialog){
			    debug.log('$Brid.Video.enableSave()');
				var autosave = parseInt(jQuery('#VideoAutosave').val());
				//Encoded files have different form, some fields are discarded and not required
				if(amIEncoded){
					
					debug.log('video.js', 'enableSave ENCODING');
					
					//If checkFields return false (something is wrong with input data) disable save button
					if(this.checkFieldsEncodedFile(displayDialog)){  
						jQuery("#videoSaveAdd,#videoSaveEdit").removeClass('disabled');
						if(autosave){
							this.autosave();
						}
						return true;
						
					}else{
						jQuery("#videoSaveAdd,#videoSaveEdit").addClass('disabled');
						return false;
					}
				}else{
					debug.log('video.js', 'enableSave VIDEO URL');
		
					//If checkFields return false (something is wrong with input data) disable save button
					if(this.checkFields(displayDialog)){  
						jQuery("#videoSaveAdd,#videoSaveEdit").removeClass('disabled');
						return true;
					}else{ 
						jQuery("#videoSaveAdd,#videoSaveEdit").addClass('disabled');
						return false;
					}
				}
				
				return false;
		  },

		  /**
		   * Check required fields and input fields - are all data is valid?
		   * 
		   * @method checkFieldsEncodedFile
		   * @param displayDialog {Booelan}	If displayDialog is present, it will pop up Dialog with message
		   * @return {Boolean}
		   */
		  checkFieldsEncodedFile : function(displayDialog){
			  	debug.log('$Brid.Video.checkFieldsEncodedFile()');
				var VideoMp4 = VideoName = jQuery("#VideoName").val(),VideoImage = jQuery("#VideoImage").val();
				
				//Test Video Title
				if(VideoName==''){
					if(displayDialog!=undefined)
						$Brid.Util.openDialog('Video title is required.','Invalid input');
					return false;
				}
				
				//Check is category selected
				if(!this.isCategorySelected()){
					if(displayDialog!=undefined)
						$Brid.Util.openDialog("Category is not selected.", 'Input form error');
			        return false;
				}
				
				if(VideoImage!=undefined && VideoImage!=''){

					if(!$Brid.Util.isUrl(VideoImage)){
						if(displayDialog!=undefined)
							$Brid.Util.openDialog('Snapshot Url must be valid URL format.', 'Invalid input');
						
						return false;
					}
					else
					if(!$Brid.Util.checkExtension(VideoImage, allowedImageExtensions)){
						if(displayDialog!=undefined)
							$Brid.Util.openDialog('Snapshot Url must have valid extension (e.g. '+allowedImageExtensions.join(',')+').', 'Invalid input');
						return false;
					}
				}
				
				return true;
		  },
		  
		  /**
		   * Check required fields and input fields on external video form
		   * 
		   * @method checkFields
		   * @param displayDialog {Booelan}	If displayDialog is present, it will pop up Dialog with message
		   * @return {Boolean}
		   */
		  checkFields : function(displayDialog){
			  
			  
	      debug.log('$Brid.Video.checkFields()');
		  var VideoMp4 = jQuery("#VideoMp4").val(), VideoName = jQuery("#VideoName").val(), VideoImage = jQuery("#VideoImage").val(),  VideoHd = jQuery('#VideoMp4Hd').val();
			
			//Test Video Title
			if(VideoName==''){
				if(displayDialog!=undefined)
					$Brid.Util.openDialog('Video title is required.','Invalid input');
				return false;
			}
			//Test Vide Mp4 url
			if(VideoMp4!=undefined && VideoMp4!=''){

				if(!$Brid.Util.isUrl(VideoMp4)){
					if(displayDialog!=undefined)
						$Brid.Util.openDialog('Mp4 or WebM url must be valid URL format.','Invalid input');
					jQuery('#VideoMp4Hd').val('');
					jQuery('#default-value-VideoMp4Hd').show();
					//Disable HD checkbox
					jQuery('#checkbox-mp4_hd_on').removeClass('disabledCheckbox').addClass('disabledCheckbox');
					return false;
				}
				else if(!$Brid.Util.checkExtension(VideoMp4, $Brid.Video.allowedExtensions) && !$Brid.Util.isStreamingUrl(VideoMp4)){ 
					/**
					 * If video doesn't match allowed video format
					 * or isnt't streaming file 
					 */
					if(displayDialog!=undefined)
						$Brid.Util.openDialog('Mp4 or WebM Url must have valid extension (e.g. '+$Brid.Video.allowedExtensions.join(',')+','+$Brid.Util.allowedStreamingExtensions.join(',')+').', 'Invalid input');
					jQuery('#VideoMp4Hd').val('');
					jQuery('#default-value-VideoMp4Hd').show();
					//Disable HD checkbox
					jQuery('#checkbox-mp4_hd_on').removeClass('disabledCheckbox').addClass('disabledCheckbox');
					return false;
				}
				//Enable HD checkbox
				jQuery('#checkbox-mp4_hd_on').removeClass('disabledCheckbox');
			}else{
				if(displayDialog!=undefined)
					$Brid.Util.openDialog('Mp4 or WebM Url is required.', 'Invalid input');
				return false;
			}
			//Snapshot if present
			if(VideoImage!=undefined && VideoImage!=''){

				if(!$Brid.Util.isUrl(VideoImage)){
					if(displayDialog!=undefined)
						$Brid.Util.openDialog('Snapshot Url must be valid URL format.', 'Invalid input');
					
					return false;
				}
				else
				if(!$Brid.Util.checkExtension(VideoImage, allowedImageExtensions)){
					if(displayDialog!=undefined)
						$Brid.Util.openDialog('Snapshot Url must have valid extension (e.g. '+allowedImageExtensions.join(',')+').', 'Invalid input');
					return false;
				}
			}
			//Hd link if present
			if(VideoHd!=undefined && VideoHd!=''){

				if(!$Brid.Util.isUrl(VideoHd)){
					if(displayDialog!=undefined)
						$Brid.Util.openDialog('Mp4/WebM HD url must be valid URL format.', 'Invlid input');
					return false;
				}
				else
				if(!$Brid.Util.checkExtension(VideoHd, $Brid.Video.allowedExtensions)){
					if(displayDialog!=undefined)
						$Brid.Util.openDialog('Mp4/WebM HD url Url must have valid extension (e.g. '+$Brid.Video.allowedExtensions.join(',')+').', 'Invalid input');
					return false;
				}
			}
			//Check is category selected
			if(!this.isCategorySelected()){ 
				if(displayDialog!=undefined)
					$Brid.Util.openDialog("Category is not selected.", 'Input form error');
		        return false;
			}
			
			return true;
			},
		  
		  /**
		   * Checks if is category selected on video form
		   * 
		   * @method isCategorySelected
		   * @return {Boolean}
		   */
		  isCategorySelected : function(){
			  
			  	debug.log('$Brid.Video.isCategorySelected()');
			    debug.log('Ind: ' + jQuery('.textButtonSmallJs').text().search("Select category"));
			    debug.log('VAL: "' + jQuery('.textButtonSmallJs').text() + '"');
			    var displayedCategory = '';
			    if (defaultTab == 'youtube'){
			        displayedCategory = jQuery('#add-youtube-channel').find('.textButtonSmallJs').text();
			    } else if (defaultTab == 'vimeo') {
			        displayedCategory = jQuery('#add-vimeo-channel').find('.textButtonSmallJs').text();
			    } else {
			        displayedCategory = jQuery('.textButtonSmallJs').text();
			    }
			    console.log('Ind: ' + displayedCategory.search("Select category"));
			    console.log('VAL: "' + displayedCategory + '"');
			    if (displayedCategory.toLowerCase().search("select category") >= 0) {
			        debug.log('Category is not selected.');
			        return false;
			    } else {
			        debug.log('Category selected: ' + '"' + jQuery('.textButtonSmallJs').text() + '"');
			        return true;
			    }
		
		  },
		  
		  /**
		   * Checks is present Auto save mesaage, and replace it 
		   * 
		   * @method checkAutosaveMessage
		   */
		  checkAutosaveMessage : function(){
			  
			debug.log('$Brid.Video.checkAutosaveMessage()');
			var $autoSaveMessage = jQuery('#autoSaving');
			if($autoSaveMessage.length && $autoSaveMessage.html()=='Saved'){
				$autoSaveMessage.html('Some changes may have not been saved.');
			}
		 }
};
$Brid.Video = jQuery.extend(true, {}, Video);



function handleImportantError(error, msg){
	if(error!=null){
		debug.error('error', error);
		var reportBug = '<br/>Please report this "bug" to <a href="mailto:brid.dev@brid.tv&subject=Bug+Report&body='+escape(msg+error.message+error.stack)+'">Brid.tv Dev Team</a> and try to reload page.';
		var display = [];
		display.push('<b>Message: </b>'+msg);
		display.push('<b>Error Object Message:</b> '+error.message);
		display.push('<b>Error Object Stack: </b><p>'+error.stack.replace('\n', '<br/>').replace(/at /g, '<br/>')+'</p>');
		display.push('<b>What to do?: </b>'+reportBug);
		debug.error('handleImportantError', error, msg);
	  jQuery('#content').html(display.join('<br/>'));
	}
}






/*				jQuery plugins 				*/





//Dropdown plugin used for simulating dropdown selectbox
//@see http://extraordinarythoughts.com/2011/08/20/understanding-jquery-plugins/
(function($) {
	
    var methods = {
    		
    		init : function(opt, callback){
    			
    			debug.log('DROPDOWN INIT');
    			
    			return this.each(function() {
    				
    				var $this = jQuery(this), settings = $this.data('dropdown');
        			//Extend settings
        			if(typeof(settings) == 'undefined') {
        				 
        				var defaults = {
        			            textColor: "#000",
        			            arrowImg : '<img alt="Click to open submenu" src="'+$BridWordpressConfig.pluginUrl+'/img/arrow_down.png" width="8" height="4" class="arrowDownJs">'
        			        };
     
    					settings = jQuery.extend({}, defaults, opt);
     
    					$this.data('dropdown', settings);
    				} else {
    					settings = jQuery.extend({}, settings,  opt);
    				}
        			
        			//Options array, will contain options of the selectbox	
        			var css = $this.attr('data-css'), additionalOptions = $this.attr('data-options'), options = [], selectedText = '', method = $this.attr('data-method'),methodAfter = $this.attr('data-callback-after') ;
        			$this.addClass('dropdown');
        			var contCss = jQuery.parseJSON(css);
        			
        			var button = jQuery('<div class="textButtonSmallJs" style="opacity: 1;"></div>').css('width', contCss.width).click($Brid.Html.GoogleCheckbox.toggleGMenu);
        	        	
    	        	if(additionalOptions!=undefined){
    	        		additionalOptions = jQuery.parseJSON(additionalOptions);
    	        		
    	        		for(var a in additionalOptions){
    	        			var b = jQuery('<div class="chkbox_action">'+additionalOptions[a].name+'</div>');
    	        			b.attr(additionalOptions[a].attr);
    	        			options.push(b);
    	        		}
    	        		
    	        	}
        	        	
    	        	$this.find('option').each(function(k,v){
    	        		//debug.log(k, v);
    	        		if(jQuery(v).is(':selected')){
    	        			//selectedText = $(v).text();
    	        			
    	        			button.html(jQuery(v).text()+settings.arrowImg);
    	        		}
    	        		options.push(jQuery('<div class="chkbox_action">'+jQuery(v).text()+'</div>').click(function(){
    	        			
    	        			//debug.log('set', k, $(v).val());
    	        			
    	        			jQuery(v).prop('selected', true);
    	        			
    	        			$this.val(jQuery(v).val());
    	        			
    	        			if(method!=undefined){
    		        			try{
    		        				$Brid.Util.executeCallback($Brid.Callbacks, method, $this);
    		        				
    		        			}catch(e){
    		        				
    		        				debug.error('Method ('+method+') not defiend inside your $Brid.Callbacks object.' + e.message, $Brid.Callbacks);
    		        			}
    	        			}
    	        			button.html(jQuery(v).text()+settings.arrowImg);
    	        			
    	        			$Brid.Html.GoogleCheckbox.hideGMenu($this);
    	        			
    	        			if(methodAfter!=undefined){
    		        			try{
    		        				$Brid.Util.executeCallback($Brid.Callbacks, methodAfter, $this);
    		        				
    		        			}catch(e){
    		        				
    		        				debug.error('Method ('+methodAfter+') not defiend inside your $Brid.Callbacks object.' + e.message, $Brid.Callbacks);
    		        			}
    	        			}
    	        			
    	        		}));
    	        	});
        	        	
        	        	//debug.log('selected', selectedText);
        	        	
        	        	
        	        	//Dropdown options
        	        	var group = jQuery('<div class="gdrop_down"></div>');
        	        	
        	        	if(css!=undefined){
            				
        	        		css = jQuery.parseJSON(css);
        	        		
        	        		group.css(css);
            			}

        	        	//Append to group all options
        	        	jQuery(options).each(function(k,v){ group.append(v); });
        	        	
        	        	//Add group of options to the button (Text with arrow image)
        	        	var dropdownButton = jQuery(button).add(group), dropdownConteiner = jQuery('<div class="dropdown"></div>');
        	        	$this.parent().append(jQuery(dropdownConteiner).append(dropdownButton));
        	        	$this.hide();
    	        	
    	        	
    	        });
    			
    		},//init end
    		
    		destroy: function(options) {
    			return jQuery(this).each(function() {
    				

    				debug.log('Destroy dropdowns');
    				
    				var $this = jQuery(this);
     
    				$this.removeData('dropdown');
    				
    				var drop = $this.next();
    				if(drop.hasClass('dropdown')){
    					drop.remove();
    				}
    				
    				//@todo should remove all dropdowns
    			});
    		},
    		
    		val: function(options) {
    			var someValue = this.eq(0).html();
     
    			return someValue;
    		}
    		
    }//methods end
    
    $.fn.dropdown = function() {
		var method = arguments[0];
 
		if(methods[method]) {
			method = methods[method];
			arguments = Array.prototype.slice.call(arguments, 1);
		} else if( typeof(method) == 'object' || !method ) {
			method = methods.init;
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.dropdown' );
			return this;
		}
 
		return method.apply(this, arguments);
 
	}
    
 
})(jQuery);

//CUSTOM MODAL @see http://www.jacklmoore.com/notes/jquery-modal-tutorial/
var modal = (function(){
	var 
	method = {},
	$overlay,
	$modal,
	$content,
	$close;

	// Center the modal in the viewport
	method.center = function () {
		var top, left;

		top = Math.max(jQuery(window).height() - $modal.outerHeight(), 0) / 2;
		left = Math.max(jQuery(window).width() - $modal.outerWidth(), 0) / 2;

		$modal.css({
			top:top + jQuery(window).scrollTop(), 
			left:left + jQuery(window).scrollLeft()
		});
	};

	// Open the modal
	method.open = function (settings) {
		$content.empty().append(settings.content);

		$modal.css({
			width: settings.width || 'auto', 
			height: settings.height || 'auto'
		});

		method.center();
		jQuery(window).bind('resize.modal', method.center);
		$modal.show();
		$overlay.show();
	};

	// Close the modal
	method.close = function () {
		$modal.hide();
		$overlay.hide();
		$content.empty();
		jQuery(window).unbind('resize.modal');
	};

	// Generate the HTML and add it to the document
	$overlay = jQuery('<div id="modalOverlay"></div>');
	$modal = jQuery('<div id="modalBox"></div>');
	$content = jQuery('<div id="modalContent"></div>');
	$close = jQuery('<a id="modalClose" href="#">close</a>');

	$modal.hide();
	$overlay.hide();
	$modal.append($content, $close);

	jQuery(document).ready(function(){
		jQuery('body').append($overlay, $modal);						
	});

	$overlay.click(function(e){
		e.preventDefault();
		method.close();
	});
	
	$close.click(function(e){
		e.preventDefault();
		method.close();
	});

	return method;
}());


/* 					Videos.js Deprecated 						*/

/**
 * Ajax: Get ffmpeg info about video (on VideoMp4 input)
 */
var getFfmpegInfo = function(){ 

	 debug.warn('Deprecated call: getFfmpegInfo');
    
    return $Brid.Video.getFfmpegInfo();
}

/**
 * Check all custom conditions to enable save button
 * We do not use full advantage of automatic "requireField" check @see videoSaveAdd button and its property 'data-form-req'=>'0'
 */
function enableSave(displayDialog){
	 debug.warn('Deprecated call: enableSave');
    
    return $Brid.Video.enableSave(displayDialog);
}
function checkFieldsEncodedFile(displayDialog){

	 debug.warn('Deprecated call: checkFieldsEncodedFile');
    
    return $Brid.Video.checkFieldsEncodedFile(displayDialog);
}
/*
 * Check required fields and input fields - are all data is valid?
 * 
 * @param displayDialog {Booelan}	If displayDialog is present, it will pop up Dialog with message
 * @return {Boolean}
 */
function checkFields(displayDialog){ 

	 debug.warn('Deprecated call: checkFields');
    
    return $Brid.Video.checkFields(displayDialog);
}

function isCategorySelected() {
    
    debug.warn('Deprecated call: isCategorySelected');

    return $Brid.Video.isCategorySelected();

    /*console.log('Ind: ' + jQuery('.textButtonSmallJs').text().search("Select category"));
    console.log('VAL: "' + jQuery('.textButtonSmallJs').text() + '"');
    var displayedCategory = '';
    if (defaultTab == 'youtube'){
        displayedCategory = jQuery('#add-youtube-channel').find('.textButtonSmallJs').text();
    } else if (defaultTab == 'vimeo') {
        displayedCategory = jQuery('#add-vimeo-channel').find('.textButtonSmallJs').text();
    } else {
        displayedCategory = jQuery('.textButtonSmallJs').text();
    }
    console.log('Ind: ' + displayedCategory.search("Select category"));
    console.log('VAL: "' + displayedCategory + '"');
    if (displayedCategory.toLowerCase().search("select category") >= 0) {
        console.log('Category is not selected.');
        return false;
    } else {
        console.log('Category selected: ' + '"' + jQuery('.textButtonSmallJs').text() + '"');
        return true;
    }*/
}


/*
 * Lazy Load - jQuery plugin for lazy loading images
 *
 * Copyright (c) 2007-2013 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/lazyload
 *
 * Version:  1.8.4
 *
 */
(function($, window, document, undefined) {
    var $window = $(window);

    $.fn.lazyload = function(options) {
        var elements = this;
        var $container;
        var settings = {
            threshold       : 0,
            failure_limit   : 0,
            event           : "scroll",
            effect          : "show",
            container       : window,
            data_attribute  : "original",
            skip_invisible  : true,
            appear          : null,
            load            : null
        };

        function update() {
            var counter = 0;
      
            elements.each(function() {
                var $this = $(this);
                if (settings.skip_invisible && !$this.is(":visible")) {
                    return;
                }
                if ($.abovethetop(this, settings) ||
                    $.leftofbegin(this, settings)) {
                        /* Nothing. */
                } else if (!$.belowthefold(this, settings) &&
                    !$.rightoffold(this, settings)) { 
                        $this.trigger("appear");
                        /* if we found an image we'll load, reset the counter */
                        counter = 0;
                } else {
                    if (++counter > settings.failure_limit) {
                        return false;
                    }
                }
            });

        }

        if(options) {
            /* Maintain BC for a couple of versions. */
            if (undefined !== options.failurelimit) {
                options.failure_limit = options.failurelimit; 
                delete options.failurelimit;
            }
            if (undefined !== options.effectspeed) {
                options.effect_speed = options.effectspeed; 
                delete options.effectspeed;
            }

            $.extend(settings, options);
        }

        /* Cache container as jQuery as object. */
        $container = (settings.container === undefined ||
                      settings.container === window) ? $window : $(settings.container);

        /* Fire one scroll event per scroll. Not one scroll event per image. */
        if (0 === settings.event.indexOf("scroll")) {
            $container.bind(settings.event, function(event) {
                return update();
            });
        }

        this.each(function() {
            var self = this;
            var $self = $(self);

           // debug.log('LAZY LOAD', this);
            
            self.loaded = false;

            /* When appear is triggered load original image. */
            $self.one("appear", function() {
            	
                if (!this.loaded) {
                	
                	//alert('appear');
                    if (settings.appear) {
                        var elements_left = elements.length;
                        settings.appear.call(self, elements_left, settings);
                    }
                    //debug.log('Load:' , settings);
                    
                    //Image error handler
                    function handleError($self){
           
                    	//Tests patter agains video and partner snapshots (Partner list screen will receive different snapshot error img)
                    	
                    	//Ako nema url-a ovo zabode browser na 100% cpu

                    	/*var patt=/^\/ugc\/partners\/snapshots\/.+\.jpg/g;
                    	if (patt.test($self.data(settings.data_attribute))) {
						//if ($self.width() && $self.height()==74) {
							$self.attr("src", '/img/thumb_reload.png');
							} else {
							$self.attr("src", '/img/thumb_404.png');
							}
							*/
                    }
                    
                    function loadInitImage($self){
                    	
                    	
                        $self
                            .hide()
                            .attr("src", $self.data(settings.data_attribute))
                            [settings.effect](settings.effect_speed);
                        self.loaded = true;

                        /* Remove image from array so it is not looped next time. */
                        var temp = $.grep(elements, function(element) {
                            return !element.loaded;
                        });
                        elements = $(temp);

                        if (settings.load) {
                            var elements_left = elements.length;
                            settings.load.call(self, elements_left, settings);
                        }
                    }
                    
                    
                   // $img = $("<img />");
                    //alert('aaa');
                    //if($self.complete){
                    	//alert('a');
                    	loadInitImage($self);
                    //}else{
                    	//alert('b');
                    //	$self.load(function(){loadInitImage($self)});
                    	
                    //}
                    
                    //If image "data-original" attribute is empty return 404 image
                    if($self.data(settings.data_attribute)=='')
                    	{
                    	
                    		handleError($self);
                    	}
                    
                    //$img.attr("src", $self.data(settings.data_attribute));
                    
                    //alert($(self).attr('id'));
                    
                    $(self).error(function(){handleError($self);});
                    
                    /*
                    $("<img />")
                        .bind("load", function() {
                        	
                        	loadInitImage($self);
                        })
						.bind("error", function() {
						
							alert('On error');
							var patt=/^\/img\/partners\/.+\.jpg/g;
							
							//if (patt.test($self.data(settings.data_attribute))) {
							//if ($self.width() && $self.height()==74) {
								//$self.attr("src", '/img/thumb_reload.png');
								//} else {
								$self.attr("src", '/img/thumb_404.png');
								//}
							
                        }).attr("src", $self.data(settings.data_attribute));
						*/
                    
                  
						//debug.log('lazy',$self.data(settings.data_attribute));
                }
            });

            
            /* When wanted event is triggered load original image */
            /* by triggering appear.                              */
            if (0 !== settings.event.indexOf("scroll")) {
                $self.bind(settings.event, function(event) {
                    if (!self.loaded) {
                        $self.trigger("appear");
                    }
                });
            }
        });

        /* Check if something appears when window is resized. */
        $window.bind("resize", function(event) {
            update();
        });
              
        /* With IOS5 force loading images when navigating with back button. */
        /* Non optimal workaround. */
        if ((/iphone|ipod|ipad.*os 5/gi).test(navigator.appVersion)) {
            $window.bind("pageshow", function(event) {
                if (event.originalEvent.persisted) {
                    elements.each(function() {
                        $(this).trigger("appear");
                    });
                }
            });
        }

        /* Force initial check if images should appear. */
        //$(window).load(function() {
        //    update();
        //});
        update();
        
        return this;
    };

    /* Convenience methods in jQuery namespace.           */
    /* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

    $.belowthefold = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.height() + $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top + $(settings.container).height();
        }

        return fold <= $(element).offset().top - settings.threshold;
    };
    
    $.rightoffold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left + $(settings.container).width();
        }

        return fold <= $(element).offset().left - settings.threshold;
    };
        
    $.abovethetop = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top;
        }

        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };
    
    $.leftofbegin = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left;
        }

        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.inviewport = function(element, settings) {
         return !$.rightoffold(element, settings) && !$.leftofbegin(element, settings) &&
                !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
     };

    /* Custom selectors for your convenience.   */
    /* Use as $("img:below-the-fold").something() or */
    /* $("img").filter(":below-the-fold").something() which is faster */

    $.extend($.expr[':'], {
        "below-the-fold" : function(a) { return $.belowthefold(a, {threshold : 0}); },
        "above-the-top"  : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-screen": function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-screen" : function(a) { return !$.rightoffold(a, {threshold : 0}); },
        "in-viewport"    : function(a) { return $.inviewport(a, {threshold : 0}); },
        /* Maintain BC for couple of versions. */
        "above-the-fold" : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-fold"  : function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-fold"   : function(a) { return !$.rightoffold(a, {threshold : 0}); }
    });

})(jQuery, window, document);


function initFancybox(){
	//if(jQuery('#Videos-content').is(':visible')){

	//	$Brid.Html.Effect.fancybox({id:'.various', options : {height : 'auto'}});	//Init fancy box
	//}else{
		//$Brid.Html.Effect.fancybox({id:'.various'});	//Init fancy box
	//}
}
function initButtonOpacity(){
	$Brid.init(['Html.Button']);
}

function initBridMain(){

	debug.log('initBridMain');

	$Brid.init(['Html.DefaultInput','Html.GoogleCheckbox', 'Html.CheckboxElement', 'Html.Selectbox','Html.Button','Html.Radio','dropdown','datepicker']);

	$Brid.Html.Effect.lazyload();
	//$Brid.Html.Effect.fancybox({id:'.various'});	//Init fancy box
}



