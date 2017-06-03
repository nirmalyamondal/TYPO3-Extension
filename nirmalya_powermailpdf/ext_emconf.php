<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "powermail".
 *
 * Auto generated 04-07-2013 17:03
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Nirmalya Powermail PDF',
    'description' => 'PDF file generator for Powermail',
    'category' => 'misc',
    'version' => '7.6.16',
    'state' => 'stable',
    'uploadfolder' => false,
	'createDirs' => 'uploads/tx_powermail',
    'clearcacheonload' => true,
    'author' => 'Nirmalya Mondal',
    'author_email' => 'nirmalya.mondal@gmail.com',
    'author_company' => 'Nirmalya',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0.0-7.6.99',
            'powermail' => '3.2.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];