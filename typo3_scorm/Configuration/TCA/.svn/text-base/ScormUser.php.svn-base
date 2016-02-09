<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_learntubescorm_domain_model_scormuser'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_learntubescorm_domain_model_scormuser']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, t3user_id, reg_id, scorm_cloud, scorm_local, completion, satisfaction, score, total_time',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, t3user_id, reg_id, scorm_cloud, scorm_local, completion, satisfaction, score, total_time, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		't3user_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.t3user_id',
			'config' => array(
				"type" => "select",	
				"foreign_table" => "fe_users",	
				"foreign_table_where" => "ORDER BY fe_users.username",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		'reg_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.reg_id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'scorm_cloud' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.scorm_cloud',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'scorm_local' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.scorm_local',
			'config' => array(
				"type" => "select",	
				"foreign_table" => "tx_learntubescorm_domain_model_scormcourse",	
				"foreign_table_where" => "ORDER BY tx_learntubescorm_domain_model_scormcourse.course_name",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		'completion' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.completion',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'satisfaction' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.satisfaction',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'score' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.score',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'total_time' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormuser.total_time',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		
	),
);
