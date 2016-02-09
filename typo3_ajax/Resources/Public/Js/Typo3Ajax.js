/* 
 * Copyright: Nirmalya Mondal, http://typo3nirmalya.blogspot.in/
 * Author: Nirmalya Mondal <typo3indiaATgmail.com>
 */

var tx_typo3_pi1_aJaXuRl = location.href;

function _ajax_request_response(){
   
    jQuery.ajax({
            async: 'true',
            url: tx_typo3_pi1_aJaXuRl,
            cache: false,
            type: 'POST',        
            data: {
                type : 9903,
				typo3_ajax: 'showtext',
				a1: 'Hello',
				a2: 'World!',
            },
            //dataType: "jsonp",
			dataType: "html",				
            success: function(result) {
                //console.log(result);
				jQuery('div#Typo3AjaxResponseDiv').text(result);
            },
            error: function(error) {
               console.log(error);
            }
       });
	   
}