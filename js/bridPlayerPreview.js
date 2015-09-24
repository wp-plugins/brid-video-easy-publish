(function() {
     /* Register the buttons */
     tinymce.create('tinymce.plugins.BridPlayerPreview', {
          init : function(ed, url) {
               /**
               * Adds HTML tag to selected content
               */
               ed.on('init', function (args) {
                    
                   shortCodeToIframe();
                   //@see bridWordpress.js
                   killVeeps();
                  
               });
          },
          createControl : function(n, cm) {
               return null;
          },
     });
     /* Start the buttons */
     tinymce.PluginManager.add( 'my_button_script', tinymce.plugins.BridPlayerPreview );
})();

function getBridIframe(s){

                         //console.log('getBridIframe', s);
                         s = s.replace(/[(\[\]]/g, '');
                         s = s.replace(/brid/g, '');
                          var params = {};
                         var re = /[\w-]+="[^"]*"/gi;
                        
                        if(window['BridOptions']!=undefined){
                                params['player'] = BridOptions.player;
                              }
                        params['items'] = 1

                        var width = '100%', height = '360px';

                         while (match = re.exec(s)) {
                                   
                                   //console.log('match', match );

                                   var arg = match[0].split('=');

                                   //console.log('arg', arg, arg[0]);

                                   arg[1] = arg[1].replace(/[\"\']/g, '');
                                   if(arg[0]=='video'){
                                        params['type'] = arg[0];
                                        params['id'] =   arg[1];
                                   }
                                   if(arg[0]=="playlist"){
                                        params['type'] = 'playlist';
                                        params['id'] =   arg[1];
                                   }
                                   if(arg[0]=="playlist"){
                                        params['type'] = 'playlist';
                                        params['id'] =   arg[1];
                                   }
                                   if(arg[0]=="latest"){
                                        params['type'] = 'latest';
                                        params['id'] =   arg[1];
                                   }
                                   if(arg[0]=="player"){
                                        params['player'] = arg[1];
                                   }
                                   if(arg[0]=="items"){
                                        params['items'] = arg[1];
                                   }
                                   if(arg[0]=="width"){
                                        params['width'] = arg[1];
                                   }
                                   if(arg[0]=="height"){
                                        params['height'] = arg[1];
                                   }
                                   params[arg[0]] = arg[1]; //decode(match[2]);
                              }
                              
                         
                         convertedVideos.push(params);

                         var selected_text = tinyMCE.get('content').getContent(); //ed.selection.getContent();
                         var return_text = '';

                         

                         if(params['width']!=undefined){
                              width = params['width'];
                          }else{
                              if(window['BridOptions']!=undefined && BridOptions.width!=undefined){
                                   width = BridOptions.width+'px';
                              }
                          }
                         if(params['height']!=undefined){
                              height = params['height'];
                         }else{
                          if(window['BridOptions']!=undefined && BridOptions.height!=undefined){
                           height = BridOptions.height+'px';
                          }
                         }
                         
                         //return_text = '<div id="Brid_27379723" class="brid">Brid video</div>';
                         iframeText = '<iframe src="'+BridOptions.ServicesUrl+'services/iframe/'+params['type']+'/'+params['id']+'/'+BridOptions.site+'/'+params['player']+'/0/'+params['items']+'/" data-title="'+params['title']+'" width="'+width+'" height="'+height+'" ';
                         
                         if(params['width']!=undefined){
                          iframeText += ' data-width="'+params['width']+'" ';
                         }

                         if(params['items']!=undefined){
                          iframeText += ' data-items="'+params['items']+'" ';
                         }
                         
                         if(params['height']!=undefined){
                          iframeText += ' data-height="'+params['height']+'" ';
                         }
                         
                         iframeText+= ' frameborder="0" align="center"></iframe>';
                          

                         return iframeText;

}

function shortCodeToIframe(){

    if(BridOptions.visual==1){

              var tmc = tinyMCE.get('content');

              if(tmc==undefined)
                return;

              var content = tinyMCE.get('content').getContent();

              var bridShortCodeRegex = /\[brid +([^\]]+)]/ig; // bits = split_bits.exec( content );

              var shortCodes = [];

              while (match = bridShortCodeRegex.exec(content)) {

                   console.log('match', match);

                   content = content.replace(match[0], getBridIframe(match[0]));

                   tinyMCE.get('content').setContent(content, {format : 'raw'});


              }
                   
        }
}

function iframeToShortCode(){

  if(BridOptions.visual){
           //var bridShortCodeRegex = /\[brid+([^\]]+)]/ig; 
           var bridShortCodeRegex = /\<iframe src="+([^\>]+)><\/iframe>/ig; 

           var content = finalContent = tinyMCE.get('content').getContent();

           while (match = bridShortCodeRegex.exec(content)) {

                              //alert(match[0]);
                              if(match[0].indexOf('src="'+BridOptions.ServicesUrl+'services/iframe/')!==-1)
                              {
                                
                              //console.log('Iframe:' , match);

                              var m = match[0].replace('<iframe src="'+BridOptions.ServicesUrl+'services/iframe/', '');

                              //Find title
                              var re = /data\-title+="[^"]*"/gi, title = re.exec(m);
                              if(title!=null)
                              {
                                title = title[0].replace('data-title="', '');
                                title = title.substring(0, title.length - 1);
                              }

                              //Find force width
                              var re = /data\-width+="[^"]*"/gi, width = re.exec(m);
                              if(width!=null)
                              {
                                width = width[0].replace('data-width="', '');
                                width = width.substring(0, width.length - 1);
                              }

                              //Find force height
                              var re = /data\-height+="[^"]*"/gi, height = re.exec(m);
                              if(height!=null)
                              {
                                height = height[0].replace('data-height="', '');
                                height = height.substring(0, height.length - 1);
                              }

                              //Find force items
                              var re = /data\-items+="[^"]*"/gi, items = re.exec(m);
                              if(items!=null)
                              {
                                items = items[0].replace('data-items="', '');
                                items = items.substring(0, items.length - 1);
                              }

                              m = m.replace(/[\"\']/g, '');

                              //alert('Title:'+title);

                              m = m.split('/');
                              
                              var shortCode = '[brid '; 

                              shortCode += m[0]+'="'+m[1]+'" ';

                              shortCode += 'player="'+m[3]+'" '; 

                              //console.log('SHORT:', m, m[0], m[1]);

                              if(m[0]!='video' && items!=undefined && items!='undefined')
                              {
                                 shortCode += ' items="'+items+'"';
                              }

                              //Is width forced
                              if(width!=undefined && width!='undefined'){
                                shortCode += ' width="'+width+'"';
                              }
                              //Is width forced
                              if(height!=undefined && height!='undefined'){
                                shortCode += ' height="'+height+'"';
                              }
                              
                              //console.log('SHORT CODE PARSER:', m)

                              if(title!=undefined && title!='undefined'){
                                shortCode += 'title="'+title+'"';
                              }

                              shortCode += ']';
                              
                              finalContent = finalContent.replace(match[0], shortCode);

                              jQuery('#content').val(finalContent);
                              
                              
                          }
                          

          }
    }//end if
}

function initBridEmbedConvert(){

     //console.log('initBridEmbedConvert', jQuery('#wp-content-wrap'));
     if(jQuery('#wp-content-wrap').hasClass('html-active')){
          iframeToShortCode();
     }else{
          shortCodeToIframe();
          killVeeps();//@see bridWordpress.js
     }
}

jQuery('.wp-switch-editor').on('click.Brid', function(){


     if(jQuery(this).text()=='Text'){
         
          iframeToShortCode();


    }else{
      shortCodeToIframe();
      killVeeps();//@see bridWordpress.js
    }

})

