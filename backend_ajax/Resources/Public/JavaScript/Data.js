/***************************************************************************
 *  Copyright notice
 *
 *  (c) Nirmalya Mondal (https://typo3nirmalya.blogspot.in/)
 *
 *  All rights reserved
 *
 *  Unauthorized copying of this file, via any medium is strictly prohibited
 *  Proprietary and confidential
 ****************************************************************************/

jQuery('h4.statusMsgSuccess').hide();
jQuery('h4.statusMsgError').hide();

var allDataHeader = JSON.parse('["' + NM.settings.BackendAjax['first_name'] + '","' + NM.settings.BackendAjax['last_name'] + '","' + NM.settings.BackendAjax['username'] + '"]');

var allDataData = NM.settings.BackendAjax['allData'];
var T3Data = JSON.parse('[' + allDataData + ']');
var T3DataRow = NM.settings.BackendAjax['allDataRow'].split(',');
var T3DataCol = NM.settings.BackendAjax['allDataCol'].split(',');
var ajaxUrl = NM.settings.BackendAjax['ajaxUrl'];

$(function () {
    var $ = function (id) {
            return document.getElementById(id);
        },
        T3Container = $('BackendAjaxDataDiv'),
        hot
    	hot = new Handsontable(T3Container, {
        data: T3Data,
        minSpareRows: 0,
        rowHeaders: true,
        colHeaders: allDataHeader,
        stretchH: 'all',
	columns: [
		{},
		{},
		{readOnly: true}
	 ],
        afterChange: function (changes) {
            if (changes == null) {
                return false;
            }
            changes.forEach(function (change) {
                var sgRow = change[0];
                var sgCol = change[1];
                var oldValue = change[2];
                var newValue = change[3];
                if (oldValue != newValue) {
                    var columnValue = T3DataCol[sgCol].replace(/\"/g, '');
                    var rowValue = T3DataRow[sgRow].replace(/\"/g, '');
                    jQuery.ajax({
                        async: 'true',
                        url: ajaxUrl,
                        cache: false,
                        type: 'POST',
                        data: {
                            'row': rowValue,
                            'col': columnValue,
                            'oldValue': oldValue,
                            'newValue': newValue
                        },
                        dataType: "HTML",
                        success: function (result) {
                            if (result) {
                                jQuery('h4.statusMsgSuccess').show();
                                jQuery('h4.statusMsgError').hide();
                            } else {
                                jQuery('h4.statusMsgError').show();
                            }
                        },
                        error: function (error) {
				//alert(error.responseText);
				jQuery('h4.statusMsgError').show();
                        }
                    });
                }
            });
        } // afterChange() Ends here.
    });

});

