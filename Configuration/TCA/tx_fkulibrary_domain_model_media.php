<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media',
		'label' => 'register_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => TRUE,
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'register_id,register_date,title,author,publisher,year,edition,keywords,isbn,category,',
		'dynamicConfigFile' => 'EXT:fku_library/Configuration/TCA/Media.php',
		'iconfile' => 'EXT:fku_library/Resources/Public/Icons/tx_fkulibrary_domain_model_media.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, register_id, register_date, title, author, publisher, keywords, isbn, recommended, newflag, missing, temporary, rejected, category',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, register_id, register_date, title, author, publisher, keywords, isbn, recommended, newflag, missing, temporary, rejected, category, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
			),
		),

		'register_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.register_id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'register_date' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.register_date',
			'config' => array(
				'dbType' => 'datetime',
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'date',
				'default' => '0000-00-00 00:00:00'
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'author' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.author',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'publisher' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.publisher',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'keywords' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.keywords',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'isbn' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.isbn',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'recommended' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.recommended',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'newflag' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.newflag',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'missing' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.missing',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'temporary' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.temporary',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'rejected' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.rejected',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'category' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:fku_library/Resources/Private/Language/locallang_db.xlf:tx_fkulibrary_domain_model_media.category',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_fkulibrary_domain_model_category',
				'minitems' => 0,
				'maxitems' => 1,
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                        'default' => array(
                            'searchWholePhrase' => true
                        )
                    ),
                ),
			),
		),
		
	),
);
