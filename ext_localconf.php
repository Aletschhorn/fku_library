<?php
use FKU\FkuLibrary\Controller\MediaController;

defined('TYPO3_MODE') || die();

(static function() {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuLibrary',
		'Library',
		[MediaController::class => 'search'],
		[MediaController::class => 'search']
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuLibrary',
		'LastAdded',
		[MediaController::class => 'listLastAdded'],
		[MediaController::class => '']
	);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'FkuLibrary',
		'Admin',
		[MediaController::class => 'searchAdmin, list, listNew, listMissing, listTemporary, export, new, create, edit, update, delete, removeNewFlag, test, idCheck'],
		[MediaController::class => 'searchAdmin, list, listNew, listMissing, listTemporary, export, new, create, edit, update, delete, removeNewFlag, test, idCheck']
	);
})();
