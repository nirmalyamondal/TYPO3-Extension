<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

/*\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'TYPO3 Socialshare Privacy'
);
*/
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'TYPO3 Socialshare Privacy');


$tempColumns = array(
	'tx_typo3socialshareprivacy_ssp' => array(		
		'exclude' => 0,		
		'label' => 'LLL:EXT:typo3_socialshareprivacy/Resources/Private/Language/locallang.xlf:tt_content.tx_typo3socialshareprivacy_ssp',
		//'displayCond' => 'FIELD:CType:=:textpic',
		'config' => array(
			'type' => 'check',
		)
	),
);

//\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('tt_content');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$tempColumns,1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content','tx_typo3socialshareprivacy_ssp;;;;1-1-1');