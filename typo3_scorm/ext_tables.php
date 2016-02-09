<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'SCORM Play'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'TYPO3.' . $_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'mod1',	// Submodule key
		'',		// Position
		array(
			'Typo3Scormbe' => 'courselist, courseupload, userlisting, coursedelete, userdelete, userhistory',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod1.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Typo3 SCORM Integration');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_typo3scorm_domain_model_scormcourse', 'EXT:typo3_scorm/Resources/Private/Language/locallang_csh_tx_typo3scorm_domain_model_scormcourse.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_typo3scorm_domain_model_scormcourse');
$GLOBALS['TCA']['tx_typo3scorm_domain_model_scormcourse'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:typo3_scorm/Resources/Private/Language/locallang_db.xlf:tx_typo3scorm_domain_model_scormcourse',
		'label' => 'course_name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'cloud_id,course_name,creation_time,update_time,score_format,allow_preview,allow_review,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/ScormCourse.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_typo3scorm_domain_model_scormcourse.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_typo3scorm_domain_model_scormuser', 'EXT:typo3_scorm/Resources/Private/Language/locallang_csh_tx_typo3scorm_domain_model_scormuser.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_typo3scorm_domain_model_scormuser');
$GLOBALS['TCA']['tx_typo3scorm_domain_model_scormuser'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:typo3_scorm/Resources/Private/Language/locallang_db.xlf:tx_typo3scorm_domain_model_scormuser',
		'label' => 't3user_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 't3user_id,reg_id,scorm_cloud,scorm_local,completion,satisfaction,score,total_time,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/ScormUser.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_typo3scorm_domain_model_scormuser.gif'
	),
);

include_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'class.tx_typo3scorm_flexform.php');
$pluginSignature = str_replace('_', '', $_EXTKEY) . '_pi1';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_typo3scorm_pi1.xml');