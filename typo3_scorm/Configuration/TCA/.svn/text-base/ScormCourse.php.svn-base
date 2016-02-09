<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_learntubescorm_domain_model_scormcourse'] = array(
	'ctrl' => $GLOBALS['TCA']['tx_learntubescorm_domain_model_scormcourse']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, cloud_id, course_name, creation_time, update_time, score_format, allow_preview, allow_review',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, cloud_id, course_name, creation_time, update_time, score_format, allow_preview, allow_review,  --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
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

		'cloud_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormcourse.cloud_id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'course_name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormcourse.course_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'creation_time' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormcourse.creation_time',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'update_time' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormcourse.update_time',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'score_format' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormcourse.score_format',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'allow_preview' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormcourse.allow_preview',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'allow_review' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:learntube_scorm/Resources/Private/Language/locallang_db.xlf:tx_learntubescorm_domain_model_scormcourse.allow_review',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
	),
);
