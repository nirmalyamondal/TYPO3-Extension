/* 
 * Copyright: Nirmalya Mondal, http://typo3nirmalya.blogspot.in/
 * Author: Nirmalya Mondal <typo3india@gmail.com>
 */

function _ajax_request_response(){
   
    jQuery.ajax({
            async: 'true',
            url: 'index.php',
            cache: false,
            type: 'POST', 
        
            data: {
                eID: "ajaxDispatcher",  
                request: {
                    pluginName:  'ajax_data',
                    controller:  'AjaxData',
                    action:      'showtext',
                    arguments: {
                        'a1': 'Hello',
                        'a2': 'World'
                    }
                }
            },
            //dataType: "json",
			dataType: "html",
				
            success: function(result) {
                //console.log(result);
				jQuery('div#AjaxDataResponseDiv').text(result);
            },
            error: function(error) {
               console.log(error);
            }
       });
        
}