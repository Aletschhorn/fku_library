<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'FKU.fku_library',
	'Library',
	array(
		'Media' => 'search, searchAdmin, list, listNew, listTemporary, new, create, edit, update, delete, export, removeNewFlag, test, idCheck',
		'Category' => 'list',
		
	),
	// non-cacheable actions
	array(
		'Media' => 'search, searchAdmin, list, listNew, listTemporary, new, create, update, delete, export, removeNewFlag, test, idCheck',
		'Category' => '',
		
	)
);
