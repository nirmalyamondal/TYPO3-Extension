
function nirmalyaValidateThisForm(fieldId,fieldClass,formClass) {	
	$('form.'+formClass+' :input[type="submit"]').prop('disabled', true);
	$('.powermail_fieldwrap_type_file_nirmalya input').removeAttr('required');
	$('form.'+formClass+' div.'+fieldClass).hide();
	$('form.'+formClass+' .nirmalya_pdf_submit_button').click(function(){	
		var parsleyInstance = $('.'+formClass).parsley();
		var parsleyInstanceValidated = $('.'+formClass).parsley().validate();
		var isFormValid = parsleyInstance.isValid();
		if(!isFormValid || !parsleyInstanceValidated){
			return false; 		
		}		
		generatePDFfile(formClass);
		$('.powermail_fieldwrap_type_file_nirmalya input').attr("required", true);
		$('form.'+formClass+' div.'+fieldClass).show();
		$('form.'+formClass+' .nirmalya_pdf_submit_button').hide();
    });
	$('form.'+formClass+' #'+fieldId).change(function(){
		if($(this).val()) {
			$('form.'+formClass+' :input[type="submit"]').removeAttr('disabled');
		} 
	});
}

function generatePDFfile(formClass) {
	// get all the inputs into an array.
	var $inputs		= $("form."+formClass+" [name*='tx_powermail_pi1[field]']" );
	var pdfDataArr	= {};
	$inputs.each(function() {			
		var fieldName	= this.name;
		var fieldId		= this.id;
		var fieldType	= $(this).attr('type');

		// Before moving to next check any fieldset value is set 
		//var fieldLabel	= $("#"+fieldId).closest(".powermail_fieldwrap").find("label.powermail_label").text();
		var fieldLabel	= $("#"+fieldId).closest(".powermail_fieldset").find(".powermail_legend").text();
		//if(fieldLabel && !jQuery.inArray($.trim(fieldLabel), pdfDataArr)){	
		if(fieldLabel){	
			pdfDataArr[$.trim(fieldLabel)] = 'nirmalyaConstantFieldset';
		}
		if(fieldType == undefined){
			var fieldType = $(this).prop('tagName');
		}
		if(fieldType == 'week'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'url'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'time'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'range'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'number'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'month'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'tel'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'date'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'text'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'TEXTAREA'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'SELECT'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
		}
		if(fieldType == 'file'){
			var fieldLabel	= $("form."+formClass+" label[for='"+fieldId+"']").text();
			var fieldValue	= $(this).val();
			var fieldValue = fieldValue.replace(/^.*[\\\/]/, '');
		}
		if(fieldType == 'radio'){
			var fieldLabel	= $("#"+fieldId).closest(".powermail_fieldwrap").find(".powermail_label").text();
			var fieldValue	= $("input[name='"+fieldName+"']:checked").val();
		}
		if(fieldType == 'checkbox'){
			var fieldLabel	= $("#"+fieldId).closest(".powermail_fieldwrap").find(".powermail_label").text();
			var fieldValue	= '';
			 $("input[name='"+fieldName+"']:checked").each(function() { 
				fieldValue	= fieldValue ? fieldValue +', '+ $(this).val() : $(this).val();
			});
		}
		
		if((fieldLabel != undefined) && (fieldLabel != '') && (fieldValue != undefined) && (fieldValue != '')) {
			//alert(fieldName+'::'+fieldId+'::'+fieldType+'::'+fieldValue+'::'+fieldLabel);alert($.trim(fieldLabel)+'::'+$.trim(fieldValue));
			// Any Special Hardcoding Cases
			if($.trim(fieldLabel) == 'Confirmation du courriel (obligatoire)'){	fieldLabel = 'Courriel';	}
			pdfDataArr[$.trim(fieldLabel)] = $.trim(fieldValue);			
		}
	}); 
	// PDF Generation code starts here
	//data:image/jpeg;base64,/9j/
	var imgFooterLogo	= '';
	// 347x30 = 261x23
	 var imgLogoData	= '';
	 var pdf = new jsPDF('p', 'pt', 'letter');
	/* Setting Up Template */
	// Total 720pt
	// Add Logo at header imgLogoData, type, margin-left, margin-top, img-width pt@96dpi, img-height pt@96dpi
	pdf.addImage(imgLogoData, 'JPEG', 175, 15, 261, 23);
	var leftMargin		= 50;
	// Footer Logo
	pdf.addImage(imgFooterLogo, 'JPEG', 0, 720, 610, 60);
	// Blue Line Top
	pdf.setDrawColor(31,65,130);
    pdf.setLineWidth(1);   
	pdf.line(leftMargin, 615, 560, 615);
	pdf.setFontSize(14);
	pdf.setFontType("bold");
	//pdf.setTextColor(0, 0, 255);
	pdf.setTextColor(31,65,130);
	var zoneString = 'Zone \xE0 compl\xE9ter';
	pdf.text(leftMargin, 635, zoneString);
	pdf.setFontSize(12);
	pdf.setTextColor(0, 0, 0);
	pdf.text(leftMargin, 660, 'Fait \xE0 ......................................');
	pdf.text(leftMargin, 680, 'le .... .... / .... .... / ........');
	pdf.text(leftMargin, 700, 'Signature :');
	// Blue Line Bottom
	pdf.setDrawColor(31,65,130);
    pdf.setLineWidth(1);   
	pdf.line(leftMargin, 715, 560, 715);
	
	var startHeight  = 60;
	$.each(pdfDataArr, function(label, paragraph) {
		pdf.setFontSize(12);
		pdf.setFontType("bold");
		labelReplaced	= label.replace("(obligatoire)", "");
		//doc.text(15, 20, splitTitle);
		// When we've only labels but no input
		if(paragraph == 'nirmalyaConstantFieldset'){
			startHeight = startHeight + 20;
			pdf.setFontType("normal");
			pdf.setFontSize(16);
			var labelReplacedSplit = pdf.splitTextToSize(labelReplaced, 480);
			pdf.text(leftMargin, startHeight, labelReplacedSplit);
			paragraph = '';
			var increasedHeightLabel	= 20 * labelReplacedSplit.length;
		} else {
			var labelReplacedSplit = pdf.splitTextToSize(labelReplaced, 180);
			pdf.text(leftMargin, startHeight, labelReplacedSplit);
			var increasedHeightLabel	= 20 * labelReplacedSplit.length;
		}		
		pdf.setFontType("normal");
		var lines = pdf.splitTextToSize(paragraph, 310);		
		pdf.text(250, startHeight, lines);
		var increasedHeightData = 20 * lines.length;
		if(increasedHeightLabel >= increasedHeightData){
			startHeight = startHeight + increasedHeightLabel;
		}else{
			startHeight = startHeight + increasedHeightData;
		}
	});
	//FormulairesInternet_Export_yyyyMMdd-HHMM.pdf -
	var timeNow		= new Date();
	var dformat = [timeNow.getFullYear(),
               timeNow.getMonth()+1,
               timeNow.getDate()].join('')+'-'+
              [timeNow.getHours(),
               timeNow.getMinutes()].join('');
	var fileName	= 'nirmalya.powermail_'+dformat+'.pdf';
	pdf.save(fileName);

}

/**
 * <input type="text" data-parsley-custom107="1" data-parsley-error-message="Please try again" />
 */
 /*
window.Parsley.addValidator(
	'custom107', function (value, requirement) {
		//alert('Called'); 
		return true;
		if (value) {
			return true;
		}
		return false;
	}, 32)
	.addMessage('en', 'custom107', 'Error');
*/
