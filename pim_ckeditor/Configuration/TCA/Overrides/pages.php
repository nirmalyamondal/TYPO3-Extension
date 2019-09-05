<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
   'pim_ckeditor',
   'Configuration/TSconfig/Page/pim_ckeditor_rte.txt',
   'Ext:pim_ckeditor - PIM CkEditor RTE Config'
);
