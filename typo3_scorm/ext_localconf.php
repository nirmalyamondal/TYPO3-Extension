<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'TYPO3.' . $_EXTKEY,
	'Pi1',
	array(		
		'Typo3Scormfe' => 'play,result',
	),
	// non-cacheable actions
	array(
		'Typo3Scormfe' => 'play,result',		
	)
);

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed'][] = 'EXT:typo3_scorm/Classes/Task/class.tx_typo3scorm_hook.php:tx_typo3scorm_hook->_typo3T3user2scorm';
