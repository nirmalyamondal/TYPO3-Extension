<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'Pi1',
	array(
		'Typo3Ajax' => 'view, showtext',
		
	),
	// non-cacheable actions
	array(
		'Typo3Ajax' => 'view, showtext',		
	)
);