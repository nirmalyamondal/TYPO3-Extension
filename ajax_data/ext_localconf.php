<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'Pi1',
	array(
		'AjaxData' => 'view, showtext',
		
	),
	// non-cacheable actions
	array(
		'AjaxData' => 'view, showtext',		
	)
);

$TYPO3_CONF_VARS['FE']['eID_include']['ajaxDispatcher'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('ajax_data').'EidDispatcher.php';