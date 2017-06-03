<?php
/**
 * Include Static TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript',
    'NIRMALYA : Extended Powermail for PDF'
);

/**
 * Fieldtypes
 *        submit
 *        reset
 */

/**
 * extend powermail fields tx_powermail_domain_model_field
 */
$tempColumns = [
    'signedpdf' => [
        'exclude' => 1,
        'label' => 'Ce champ contient le PDF signé',
		'displayCond' => 'FIELD:type:=:file',
        'config' => [
            'type' => 'check'
        ]
    ],
	'signedpdfbutton' => [
        'exclude' => 1,
        'label' => 'Ce champ génére et envoie le PDF',
		'displayCond' => 'FIELD:type:IN:submit',
        'config' => [
            'type' => 'check'
        ]
    ],
	'palettes' => [
		'41' => [
            'showitem' => 'css, multiselect, signedpdf'
        ],
	],

];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_field', $tempColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_powermail_domain_model_field',
    '--div--;Gestion de PDF signé, signedpdf, signedpdfbutton',
    '',
    'after:own_marker_select'
);
