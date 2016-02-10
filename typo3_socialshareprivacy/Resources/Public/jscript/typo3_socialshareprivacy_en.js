var global_facebook_appid	= 587977977907178;	//Set Your facebook Apps Id
var global_title;
var global_summary;
var global_absurl;
var global_absurl_new;
var global_absimage;

jQuery(document).ready(function(){
	//alert(jQuery.md5('nirmalya',''));
	jQuery('div.tx_typo3socialshareprivacy_ssp').each(function(){
		pathArray	= window.location.href.split( '/' );
		webprotocol = pathArray[0];
		webhost		= pathArray[2];
		baseurl		= webprotocol+'//'+webhost;

		var el_id			= '';	var header			= '';	var htag			= '';
		var text			= '';	var text_cropped	= '';	var tt_content_id	= '';
		var image			= '';
		el_id	= this.id;
		header	= jQuery('#'+el_id).contents().find('h1').html();
		if(!header){ header	= jQuery('#'+el_id).contents().find('h2').html(); }
		if(!header){ header	= jQuery('#'+el_id).contents().find('h3').html(); }
		if(!header){ header	= jQuery('#'+el_id).contents().find('h4').html(); }
		if(!header){ header	= jQuery('#'+el_id).contents().find('h5').html(); }
		if(!header){ header	= jQuery('#'+el_id).contents().find('h6').html(); }		
		text				= jQuery('div#'+el_id).contents().text().replace(header,"");
		text				= jQuery.trim(text);	//alert(text);
		if(text){			text_cropped	= text.substring(0, 100)+' ...';	}
		image				= jQuery('#'+el_id+' img').first().attr('src');
		tt_content_id		= el_id.replace('txtypo3socialshareprivacyssp_','');
		global_ttcontent_id	= tt_content_id;
		global_title		= header;
		global_title		= jQuery.trim(global_title);
		global_summary		= text_cropped;
		
		var doc_location_url = document.location.href;
		if(doc_location_url.indexOf("?") != -1){
    			global_absurl		= document.location.href+'&contentid='+tt_content_id+'#c'+tt_content_id;//#c471
		}else{
		       global_absurl		= document.location.href+'?contentid='+tt_content_id+'#c'+tt_content_id;//#c471
		}		
		global_absurl_new	= document.location.href;//#c471

		global_absimage		= baseurl+'/'+image;
		jQuery('#'+el_id).append('<div class="ltbsspinnerdivtooltipcls ltb_ssp_innerdiv_tooltip_'+tt_content_id+'" onmouseover="_show_this_ssp_div('+tt_content_id+');"><img src="typo3conf/ext/typo3_socialshareprivacy/Resources/Public/css/images/recomment-tooltipp.jpg" alt="" class="" title=""><div class="ltb_ssp_innerdiv" id="ltb_ssp_innerdiv_'+tt_content_id+'"></div></div>');
		jQuery('div#ltb_ssp_innerdiv_'+tt_content_id).socialSharePrivacy(); 
		//alert('ContentId='+tt_content_id+' ,Header='+header+' ,Text='+text_cropped+' ,Image='+image);		
	});
	 ltb_toopen_contentid	= _get_URL_parameter('contentid');
     //alert('ltb_toopen_contentid='+ltb_toopen_contentid);
     var closest_div		= jQuery('#txtypo3socialshareprivacyssp_'+ltb_toopen_contentid).closest('div[class^="content-block"]').show();
})//ready


function _get_URL_parameter(name) {
    return decodeURIComponent((RegExp(name + '=' + '(.+?)(&|$)').exec(window.location.search)||[,null])[1]);
}

function _show_this_ssp_div(tt_content_id){
	jQuery('div.tx_typo3socialshareprivacy_ssp div#ltb_ssp_innerdiv_'+tt_content_id).show(); 
	jQuery('div.tx_typo3socialshareprivacy_ssp div#ltb_ssp_innerdiv_'+tt_content_id).delay(4000).fadeOut('fast');
}