/*
Thumbnail scroller jQuery plugin
Author: malihu [http://manos.malihu.gr]
Homepage: manos.malihu.gr/jquery-thumbnail-scroller
*/
(function($){  
	
	 var methods = {
	    		
	    		init : function(opt, callback){
	    			
	    			debug.log('INIT thumbnailScroller');
	    				
	    			    return this.each(function(){ 
	    			    	
	    					var $this=$(this);
	    			    	var options = $this.data('thumbnailScroller');
	    					var $scrollerContainer=$this.children(".jTscrollerContainer");
	    					var $scroller=$this.children(".jTscrollerContainer").children(".jTscroller");
	    					//Custom fix by losmi, adjusting  buttons to the new design
	    					//var $scrollerNextButton=$this.children(".jTscrollerNextButton");
	    					//var $scrollerPrevButton=$this.children(".jTscrollerPrevButton");
							var $scrollerNextButton=$this.parent().children(".jTscrollerNextButton");
	    					var $scrollerPrevButton=$this.parent().children(".jTscrollerPrevButton");
							
							var $scrollerNextTrigger=$this.parent().children(".jNextTrigger");
	    					var $scrollerPrevTrigger=$this.parent().children(".jPrevTrigger");
	    			    	
	    					
	    					//console.log('options start', options);
	    			    	
	            			if(typeof(options) == 'undefined') {
	            				
	            				//console.log('options are undefined');
	            				
	            				var defaults={ //default options
		    	    					scrollerType:"hoverPrecise", //values: "hoverPrecise", "hoverAccelerate", "clickButtons"
		    	    					scrollerOrientation:"horizontal", //values: "horizontal", "vertical"
		    	    					scrollEasing:"easeOutCirc", //easing type
		    	    					scrollEasingAmount:800, //value: milliseconds
		    	    					acceleration:2, //value: integer
		    	    					scrollSpeed:600, //value: milliseconds
		    	    					noScrollCenterSpace:0, //value: pixels
		    	    					autoScrolling:0, //value: integer
		    	    					autoScrollingSpeed:8000, //value: milliseconds
		    	    					autoScrollingEasing:"easeInOutQuad", //easing type
		    	    					autoScrollingDelay:2500 //value: milliseconds
		    	    				};
	         
	            				options = $.extend(defaults, opt);
	         
	        					$this.data('thumbnailScroller', options);
	        				} else {
	        					//alert('else');
	        					options = $.extend(options, opt);
	        				}

	    	    			
	    	    			//console.log('thumbnailScroller INIT options merged:', options, options.autoScrolling);
	    					
	    					
	    					//set scroller width
	    					if(options.scrollerOrientation=="horizontal"){
	    					
	    						$scrollerContainer.css("width",'999999px'); 
	    						// var totalWidth=$scroller.outerWidth(true);
								// modified by dex to include padding of parent element
								var totalWidth=$scroller.outerWidth(true) + $scrollerContainer.innerWidth() - $scrollerContainer.width();
								
	    						$scrollerContainer.css("width",totalWidth);
	    						//console.log('jTscrollerContainer WIDTH', totalWidth, $this.width());
	    					}else{
	    						var totalWidth=$scroller.outerWidth(true);
	    					}
	    					
	    					var totalHeight=$scroller.outerHeight(true); //scroller height
																							//do the scrolling
	    					if(totalWidth>$this.width() || totalHeight>$this.height()){ 	//needs scrolling		
	    						
	    						var pos;
	    						var mouseCoords;
	    						var mouseCoordsY;
								var triggeredNext;
								var triggeredPrev;
								
								
								$scrollerNextTrigger.hover(
									function() { triggeredNext = true; }, 
									function() { triggeredNext = false; }
								);
								
								
								
								
	    						if (options.scrollerType=="hoverAccelerate") { 				//type hoverAccelerate
								
	    							var animTimer;
	    							var interval=8;
	    							
	    							var mousemove = function(e){
    									pos=findPos(this);
    									mouseCoords=(e.pageX-pos[1]);
    									mouseCoordsY=(e.pageY-pos[0]);
    								}
	    							
	    							var showMouseOver = function(){ 						//mouse over
	    								$this.unbind('mousemove.Thumbnail');
	    								
	    								$this.bind('mousemove.Thumbnail', mousemove);
	    								
	    								clearInterval(animTimer);
	    								animTimer = setInterval(Scrolling,interval);
	    							}
	    							
	    							var hideMouseOut = function(){ 							//mouse out
	    								clearInterval(animTimer);
	    								$scroller.stop();
	    							}
	    							
	    							$this.unbind('mouseenter.Thumbnail mouseleave.Thumbnail');
	    							$this.bind('mouseenter.Thumbnail', showMouseOver);
	    							$this.bind('mouseleave.Thumbnail', hideMouseOut);
	    							
									$scrollerPrevButton.add($scrollerNextButton).hide(); 	//hide buttons
									
	    						} else if (options.scrollerType=="clickButtons") {
								
	    							ClickScrolling();
/*									
	    						} else { 													//type hoverPrecise
								
	    							pos=findPos(this);
	    							$this.mousemove(function(e){
	    								mouseCoords=(e.pageX-pos[1]);
	    								mouseCoordsY=(e.pageY-pos[0]);
	    								var mousePercentX=mouseCoords/$this.width(); if(mousePercentX>1){mousePercentX=1;}
	    								var mousePercentY=mouseCoordsY/$this.height(); if(mousePercentY>1){mousePercentY=1;}
	    								var destX=Math.round(-((totalWidth-$this.width())*(mousePercentX)));
	    								var destY=Math.round(-((totalHeight-$this.height())*(mousePercentY)));
	    								$scroller.stop(true,false).animate({left:destX,top:destY},options.scrollEasingAmount,options.scrollEasing); 
	    							});
									$scrollerPrevButton.add($scrollerNextButton).hide(); //hide buttons
*/
	    						}
								
	    						//auto scrolling
/*
	    						if(options.autoScrolling>0){
	    							AutoScrolling();
	    						}
*/
								
	    					} else {
	    						//no scrolling needed
								$scrollerPrevButton.add($scrollerNextButton).hide(); //hide buttons
	    					}
							
							
							
	    					var scrollerPos;
	    					var scrollerPosY;
							var maxLeft = $this.width() - totalWidth;
							var scrollTriggerWidth = $this.width()/2-options.noScrollCenterSpace;
							
							function finishedScrolling() {
								if (dragInProgress) {
									$( "#sortable" ).sortable('refresh');						// i guess this refreshes
									}
								}
									
							function Scrolling(){

								if (mouseCoords <= scrollTriggerWidth) {														// calculate animation move
									scrollerPos = Math.round(((scrollTriggerWidth - mouseCoords) / scrollTriggerWidth) * (interval+options.acceleration));
									} else if ((mouseCoords >= $this.width()-scrollTriggerWidth) || triggeredNext) {
									scrollerPos = Math.round((-(mouseCoords-($this.width()-scrollTriggerWidth)) / scrollTriggerWidth) * (interval+options.acceleration));
									//console.log(scrollerPos, triggeredNext);
									} else {
									return;																						// not in the trigger area; return
									}
								
								$('.ui-sortable-helper').add($scroller).stop(true,true);										// first stop
								
								var l = $scroller.position().left;																// now get left position
								
								
								if (scrollerPos>0 && l==0) { /*console.log('nula');*/ finishedScrolling(); return false; }			// in these cases we don't need to scroll
								if (scrollerPos<0 && l==maxLeft) { finishedScrolling(); return false; }
								if (l+scrollerPos > 0) { scrollerPos = -l; }													// in these cases we need smaller increment/decrement
								if (l+scrollerPos < maxLeft) { scrollerPos = maxLeft-l; }
								
								//Dodao losmi, bez ovoga luduje nesto u WP ako ima manje itema od 6 skoce svi desno
								if((l + scrollerPos) == maxLeft) { finishedScrolling(); return false; }
								if(maxLeft  == l) { finishedScrolling(); return false; }


								//l = -Math.abs(l);
								//console.log('---------- LEFT -----------', l, scrollerPos, maxLeft);


								$('.ui-sortable-helper').animate({left:"-="+scrollerPos},interval,"linear",function() { finishedScrolling(); }); 

								$scroller.animate({left:"+="+scrollerPos},interval,"linear",function() { finishedScrolling(); }); 
									
								
						
								/*
	    						if((mouseCoordsY<$this.height()/2) && ($scroller.position().top>=0)){
	    							$scroller.stop(true,true).css("top",0); 
	    						}else if((mouseCoordsY>$this.height()/2) && ($scroller.position().top<=-(totalHeight-$this.height()))){
	    							$scroller.stop(true,true).css("top",-(totalHeight-$this.height())); 
	    						}else{
	    							if((mouseCoordsY<=($this.height()/2)-options.noScrollCenterSpace) || (mouseCoordsY>=($this.height()/2)+options.noScrollCenterSpace)){
	    								scrollerPosY=Math.cos((mouseCoordsY/$this.height())*Math.PI)*(interval+options.acceleration);
	    								$scroller.stop(true,true).animate({top:"+="+scrollerPosY},interval,"linear"); 
	    							}else{
	    								$scroller.stop(true,true);
	    							}
	    						}
								*/
	    					}
	    					//auto scrolling fn
/*
	    					var autoScrollingCount=0;
	    					function AutoScrolling(){
	    						
	    						$scroller.delay(options.autoScrollingDelay).animate({left:-(totalWidth-$this.width()),top:-(totalHeight-$this.height())},options.autoScrollingSpeed,options.autoScrollingEasing,function(){
	    							$scroller.animate({left:0,top:0},options.autoScrollingSpeed,options.autoScrollingEasing,function(){
	    								autoScrollingCount++;
	    								if(options.autoScrolling>1 && options.autoScrolling!=autoScrollingCount){
	    									AutoScrolling();
	    								}
	    							});
	    						});
	    					}
*/
							
	    					//click scrolling fn
	    					function ClickScrolling(){
	    						$scrollerPrevButton.hide();
	    						$scrollerNextButton.show();
								
	    						$scrollerNextButton.click(function(e){ //next button
	    							e.preventDefault();
	    							var posX=$scroller.position().left;
	    							var diffX=totalWidth+(posX-$this.width());
	    							var posY=$scroller.position().top;
	    							var diffY=totalHeight+(posY-$this.height());
									//var moveDrag = diffX;
	    							$scrollerPrevButton.stop().show("fast");
	    							if(options.scrollerOrientation=="horizontal"){
	    								if(diffX>=$this.width()){
	    									$scroller.stop().animate({left:"-="+$this.width()},options.scrollSpeed,options.scrollEasing,function(){
	    										if(diffX==$this.width()){
	    											$scrollerNextButton.stop().hide("fast");
												}
												if (dragInProgress) {
													var lft = parseInt($('.ui-sortable-helper').css('left'));
													//console.log('movedrag', lft + moveDrag);
													$('.ui-sortable-helper').css('left', lft + $this.width());		// calculating and positioning moving div
													$( "#sortable" ).sortable('refresh');						// i guess this refreshes
												}
												
	    									});
											//moveDrag = $this.width();
	    								} else {
	    									$scrollerNextButton.stop().hide("fast");
	    									$scroller.stop().animate({left:$this.width()-totalWidth},options.scrollSpeed,options.scrollEasing,function(){
												if (dragInProgress) {
													var lft = parseInt($('.ui-sortable-helper').css('left'));
													//console.log('movedrag', lft + moveDrag);
													$('.ui-sortable-helper').css('left', lft + diffX);			// calculating and positioning moving div
													$( "#sortable" ).sortable('refresh');						// i guess this refreshes
												}
											
											});
	    								}
										
										//if (dragInProgress && 1==2) {
										//	var lft = parseInt($('.ui-sortable-helper').css('left'));
										//	//console.log('movedrag', lft + moveDrag);
										//	$('.ui-sortable-helper').css('left', lft + moveDrag);		// calculating and positioning moving div
										//	$( "#sortable" ).sortable('refresh');						// i guess this refreshes
										//}
										
	    							}else{
/*
	    								if(diffY>=$this.height()){
	    									$scroller.stop().animate({top:"-="+$this.height()},options.scrollSpeed,options.scrollEasing,function(){
	    										if(diffY==$this.height()){
	    											$scrollerNextButton.stop().hide("fast");
	    										}
	    									});
	    								} else {
	    									$scrollerNextButton.stop().hide("fast");
	    									$scroller.stop().animate({top:$this.height()-totalHeight},options.scrollSpeed,options.scrollEasing);
	    								}
*/
	    							}
	    						});
								
	    						$scrollerPrevButton.click(function(e){ //previous button
	    							e.preventDefault();
	    							var posX=$scroller.position().left;
	    							var diffX=totalWidth+(posX-$this.width());
	    							var posY=$scroller.position().top;
	    							var diffY=totalHeight+(posY-$this.height());
	    							$scrollerNextButton.stop().show("fast");
	    							if(options.scrollerOrientation=="horizontal"){
	    								if(posX+$this.width()<=0){
	    									$scroller.stop().animate({left:"+="+$this.width()},options.scrollSpeed,options.scrollEasing,function(){
	    										if(posX+$this.width()==0){
	    											$scrollerPrevButton.stop().hide("fast");
	    										}
	    									});
	    								} else {
	    									$scrollerPrevButton.stop().hide("fast");
	    									$scroller.stop().animate({left:0},options.scrollSpeed,options.scrollEasing);
	    								}
	    							}else{
/*
	    								if(posY+$this.height()<=0){
	    									$scroller.stop().animate({top:"+="+$this.height()},options.scrollSpeed,options.scrollEasing,function(){
	    										if(posY+$this.height()==0){
	    											$scrollerPrevButton.stop().hide("fast");
	    										}
	    									});
	    								} else {
	    									$scrollerPrevButton.stop().hide("fast");
	    									$scroller.stop().animate({top:0},options.scrollSpeed,options.scrollEasing);
	    								}
*/
	    							}
	    						});
	    					}
	    				}); 
	    			
	    			
	    		},
	    		destroy: function(options) {
	    			return $(this).each(function() {
	    				
	    				debug.log('destroy thumbnailScroller');
	    				var $this = $(this);
	    				
	    				$this.removeData('thumbnailScroller');
	    				
	    				var $scroller=$this.children(".jTscrollerContainer").children(".jTscroller");
	    				var $scrollerNextButton=$this.parent().children(".jTscrollerNextButton");
    					var $scrollerPrevButton=$this.parent().children(".jTscrollerPrevButton");
    					
    					//$scrollerNextButton.hide();
    					//$scrollerPrevButton.hide();
    					
	    				$scroller.stop();
	    				$scrollerNextButton.stop();
	    				$scrollerPrevButton.stop();
	    				
	    				$scrollerNextButton.unbind('click.Thumbnail');
	    				$scrollerPrevButton.unbind('click.Thumbnail');
	    				
	    				$this.unbind('mousemove.Thumbnail');
	    				$this.unbind('hover.Thumbnail');
	    				
	    			});
	    		}
	    		
	 }

	 $.fn.thumbnailScroller = function() {
			var method = arguments[0];
	 
			if(methods[method]) {
				method = methods[method];
				arguments = Array.prototype.slice.call(arguments, 1);
			} else if( typeof(method) == 'object' || !method ) {
				method = methods.init;
			} else {
				$.error( 'Method ' +  method + ' does not exist on jQuery.thumbnailScroller' );
				return this;
			}

			return method.apply(this, arguments);
	 
		}
	 
})(jQuery); 

//global js functions
//find element Position
function findPos(obj){
	var curleft=curtop=0;
	if (obj.offsetParent){
		curleft=obj.offsetLeft
		curtop=obj.offsetTop
		while(obj=obj.offsetParent){
			curleft+=obj.offsetLeft
			curtop+=obj.offsetTop
		}
	}
	return [curtop,curleft];
}