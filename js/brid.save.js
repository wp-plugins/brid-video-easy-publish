//Magic save object
var saveObj = {
    		
    		init : function(){

    			debug.log('Save Obejct init');
    			
    			var $this = this;
    			
    			jQuery('.saveButton').each(function(){ 
    				
    				var saveButton = jQuery(this);
    				var saveButtonId = saveButton.attr('id');
    				var mode = saveButton.attr('data-mode') || null; 															//optional parameter if we want to force any action (edit, add)
    				var formId  = saveButton.closest('form').attr('id'); //saveButton.attr('data-form-id'); 			//formId to submit
    				
    				var autoBind = (saveButton.attr('data-form-bind')==undefined) ? 1 : parseInt(saveButton.attr('data-form-bind')); 		//auto bind onclick for save element
    				var autoRequired = (saveButton.attr('data-form-req')==undefined) ? 1 : parseInt(saveButton.attr('data-form-req')); 	//auto check the required fields in form
        			
    				if(autoBind)
    				{
    					
    					saveButton.unbind('click');
    					
    					var saveButtonClickE = function(){
	    					
    						
	    					if(!saveButton.hasClass('inprogress')){
	    						
	    					
		    					if(!saveButton.hasClass('disabled')){
			    					
		    						//debug.log('Save object', formId, $this);
		    						saveButton.addClass('inprogress');

		    						$this.save(formId, mode);
			    					
			    				}else{

			    					if(autoRequired){
			    						$this.openRequiredDialog(formId, 'Please check that the required fields are not empty.<br /> Ensure proper format for fields.', 'Save is disabled');
			    					
			    						debug.warn('Save is disabled! Check are there any mandatory fields left empty.', 'Autorequired:'+autoRequired, 'Autobind:'+autoBind);
			    					}else{
			    					
			    						debug.error('You have sent Autorequred check attribute to be disabled, handle openDialog yourself!!!');
			    					}
			    				}
	    					}else{
	    						
	    						$this.openRequiredDialog(formId, 'Save in progress', 'Save is disabled');
		    					
		    					debug.error('Save is in progress! No duplicate save clicks!');
	    					}
	    					
	    				}
    					
    					//Bind on click
    					saveButton.bind('click', saveButtonClickE);
	    				
    				} 
    				
    				if(autoRequired){
   
    					//debug.log('Save Obejct autoRequired:', autoRequired);
    					//debug.log('fieldssssss',$('#'+formId).find('.required'));
    					jQuery('#'+formId).find('.required').each(function(k,v){
    	    				
    						//debug.log('Autobind -', $(this));
    	    				
    						//debug.log('inputtt',$(this).find('input, textarea'));
    						jQuery(this).find('input, textarea').input(function(){
    	    					
    	    					debug.log('Autobind input element for form id:'+formId+' - '+jQuery(this).attr('id'));
        	    				
    	    					//alert('aaaa');
    	    					$this.toggleSave(formId);
    	    					
    	    				});
    	    				
    	    			});
    				}
    				
    				
    			});
    			
    			
    			
    			return this;
    		},
            /**
             * Check is there any validation messages from Model that should be dispalyed
             * @method getValidationMsg
             * @param {Object} data - response data
             * @return {String} msg
             */
            getValidationMsg : function(data){
                var msg = '', shownErrors = new Array();
                if(data==undefined) throw "Invalid argument supplied for save.getValidationMsg()";
                if(data.errors!=undefined && data.errors.validation!=undefined){

                                    for(var i in data.errors.validation){

                                        if(typeof data.errors.validation[i] == 'object'){
                                            
                                            for(var a in data.errors.validation[i]){
                                                
                                                if(typeof data.errors.validation[i][a] == 'object'){
                                                
                                                    for(var b in data.errors.validation[i][a]){
                                                        if (shownErrors.indexOf(data.errors.validation[i][a][b][0]) < 0) {
                                                            msg += ' ' + data.errors.validation[i][a][b] + '<br/>';
                                                            shownErrors.push(data.errors.validation[i][a][b][0]);
                                                            }
                                                    }
                                                    
                                                }else{
                                                    if (shownErrors.indexOf(data.errors.validation[i][a][0]) < 0) {
                                                        msg += ' ' + data.errors.validation[i][a] + '<br/>';
                                                        shownErrors.push(data.errors.validation[i][a][0]);
                                                        }
                                                }
                                            }
                                            
                                        }else{
                                            if (shownErrors.indexOf(data.errors.validation[i][0]) < 0) {
                                                msg += ' ' + data.errors.validation[i] + '<br/>';
                                                shownErrors.push(data.errors.validation[i][0]);
                                                }
                                        }
                                        
                                    }
                                    
                                }
                return msg.replace('<br/>',' ');

            },
    		save : function(formId, mode){ //this formId is not used (we used local this.formId)
    			
    			//var $t = this;
    			debug.log('Form id:', formId, 'Mode:', mode);
    	    	
    			//Does button have any Beofre callback method?

    	    	var $form = jQuery('#'+formId);
    	    	
    	    	if($form.length==0)
    	    	{
    	    		debug.error('Warrning: (Ko god da testira - ovo nije error) - Form does not exist!!! Check data-form-id attribute on your save button');
    	    	}
    	    	
    	    	debug.log('Form', $form);

    			var saveButton = jQuery('#'+formId).find('.saveButton');
				
				var callbackMethodBefore = saveButton.attr('data-method-before');
				if(callbackMethodBefore!=undefined){
                 	
					$Brid.Util.executeCallback($Brid.Callbacks, callbackMethodBefore);
                }
				
				var $self = this;

    			var formData = $form.serialize();

    			var formUrl = $form.attr('action') + (mode!=undefined ? mode : '');
    			
    			//clean formUrl from ?get params that are added (_ajax=2313213) becaouse of back button support
    			
    			formUrl = formUrl.split('?',1);    			

    			jQuery.ajax({
    				  url: formUrl,
    				  data: formData,
    				  type: 'POST',
    				  beforeSend: function(){
    						
    					  //$Brid.Html.FlashMessage.loading('Save in progress , please wait...');
						  
					  }
    		
    				}).done(function(data){
					
    					//var msg = data.message + '<br/><br/>';			//data.flash
    					//Find save button

                        debug.log('Save done:', data);
						var msg = '';
						
    					//Hide if it is shown
    					jQuery('#busy-indicator').hide();
    					 
						saveButton.removeClass('inprogress');
						
    						if(data.status!='success'){

                                if(data.message!=undefined)
                                {
                                    msg += data.message;
                                }
    							msg +=  $self.getValidationMsg(data);
    							//$Brid.Html.FlashMessage.show({msg : msg, status : data.status});
								if(data.error!=undefined && typeof data.error == 'string'){
                                    msg += data.error;
                                }
								alert('Msg:'+msg);
    							
    						}else{

                              
    							var saveTextBefore = saveButton.find('.buttonLargeContent').html();
    							saveButton.find('.buttonLargeContent').html('SAVED!').delay(1000).queue(function( nxt ) {
    								
    						         jQuery(this).html(saveTextBefore);
    						         nxt(); // continue the queue
    						         
    						     });
    							
    							//alert('yuhu');
    							//debug.log('USAO U SAVE SUCCESS');
    							try{
    								//contentRefresh('playlist-list', "/playlists/list_items/");
    								
    								debug.log('TRY TO CLOSE FANCYBOX');
									jQuery.colorbox.close();
    							}catch(e){
    								debug.warn('Fancy box close in save method.');
    							}
    							//alert(data.redirect);
    							/*if(action == 'add'){
    								$('#'+formId)[0].reset();
    								$('.defaultInputValue').show();
    							}*/
    							
    							saveButton.ajaxResponse = data;
    							//Is there anu callback on save button?
    							$Brid.Util.executeCallback($Brid.Callbacks, saveButton.attr('data-method'), saveButton);
								
    							if(data.redirect!=undefined){

    								//$Brid.Ajax.loadAjaxUrl(data.redirect,true);
                                    var callbackName = data.callback!=undefined ? data.callback : 'insertContentVideos';
                                    var contentId = callbackName=='insertContentVideos' ? 'Videos-content' : 'Playlists-content';

                                    $Brid.Api.call({data : $Brid.Util.getRedirectUrl(data.redirect), callback : {after : {name : callbackName, obj : jQuery("#"+contentId)}}});
    								
    							}
								
								if(data.externalId!=undefined && data.videoId!=undefined) {
                                    //jQuery('td#td' + data.externalId + ' a').attr('href', '/videos/edit_external/' + data.videoId);
                                    //jQuery('td#td' + data.externalId + ' a').attr('href', '/videos/edit_external/' + data.videoId);
									jQuery('td#td' + data.externalId + ' a').attr('data-id',  data.videoId);
								}
								
								//$Brid.Html.FlashMessage.show({msg : data.message, status : true});
    						}

    						

    						
    				}).fail(function(jqXHR, textStatus, errorThrown){
						  
						  
						  var data = jQuery.parseJSON(jqXHR.responseText);
						  
						  debug.log('Save FAIL response:', data, textStatus, errorThrown);
						  
						  //Show message anyway
							  
						  $Brid.Html.FlashMessage.show({msg : data.name, status : false});
							  
						  
					  });
    		},

           
    		
    		toggleSave : function(formId){ 
    			
    			debug.log('saveObj.toggleSave', formId);
    			
    			var fields = [];
    			
    			jQuery('#'+formId).find('.required').each(function(k,v){
    				
    				fields.push(jQuery(this).find('input, textarea').attr('id'));
    				
    			});

    			debug.log('saveObj.toggleSave', 'Required:', fields)
    			
    				var enable = false;
    				
    				jQuery(fields).each(function(k,v){

    					var inputObj = jQuery('#'+formId).find('#'+v);
    					
    					if(inputObj.val()!=''){

    						var arrayIndex = fields.indexOf(v);
    						fields.splice(arrayIndex,1); //Remove item from array
    						
    					}

    				});


    			debug.log('saveObj.toggleSave', 'Required after checking values:', fields)
        			
    			if(fields.length==0)
    			{
    				jQuery('#'+formId).find('.saveButton').removeClass('disabled');
    			}else{

    				var a = jQuery('#'+formId).find('.saveButton');
    				
    				if(!a.hasClass('disabled'))
    				{
    					a.addClass('disabled');
    				}
    			}
    		},
    		
    		openRequiredDialog : function(formId, msg, title){
    			
    			debug.log('openRequiredDialog', formId, msg, title);
    			
    			var reqFieldsText = '';
				var reqFields = [];
				var saveButton = jQuery('#'+formId).find('.saveButton');
				var autoRequired = (saveButton.attr('data-form-req')==undefined) ? 1 : parseInt(saveButton.attr('data-form-req')); 	//auto check the required fields in form
    			
				
				debug.log(formId);
				
				if(autoRequired){
					jQuery('#'+formId).find('.required').each(function(k,v){
						
						jQuery(this).find('input, textarea, select').each(function(key, val){
	
						    // On Add video page we have something special, that not work on simple way... I must mess simple code with exception for videos.
	                        var f = '';
	                        if (jQuery(this).attr('id') == 'ChannelIdUpload' && !isCategorySelected()) {
	                            f = 'Select category'.split(/(?=[A-Z])/);
	                            reqFields.push(f.join(' '));
	                        }
							
							else if(jQuery(this).val()==''){
								f = jQuery(this).attr('id').split(/(?=[A-Z])/);
								reqFields.push(f.join(' '));
							}
							
						});
						//var f = $(this).find('input, textarea').attr('id').split(/(?=[A-Z])/);
						
						
					});
					
					debug.log('Req fields', reqFields);
					
					if(reqFields.length>0){
						
						reqFieldsText =  '<br/><br/><p><h5>Notice:</h5></p>';
						reqFieldsText += '<p style="color:#939598;">Please make sure that these fields are filled correctly:</p>';
						
						reqFieldsText += '<ul class="requiredFieldsLightbox">';
						for(var field in reqFields){
							reqFieldsText += '<li>'+reqFields[field]+'</li>';
						}
						reqFieldsText += '</ul>';
					}
				

					if(reqFields.length<=0){
						jQuery('#'+formId).find('.saveButton').removeClass('disabled');
					}
				}
				//<img src="/img/checked.png" class="checked" style="" alt="">
				
				$Brid.Util.openDialog(msg+reqFieldsText, title);
				
    			
    		}
    		
    		
    };