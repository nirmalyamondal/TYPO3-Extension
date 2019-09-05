<?php
defined('TYPO3_MODE') || die('Access denied.');

//call_user_func( function() {	
		//\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
		//	<INCLUDE_TYPOSCRIPT: source="FILE:EXT:pim_ckeditor/Configuration/TSconfig/Page/pim_ckeditor_rte.txt">
		//');		
		
//});	

 $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['pim_ckeditor'] = 'EXT:pim_ckeditor/Configuration/TSconfig/TceForm/Default.yaml';
 