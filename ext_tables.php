<?php
defined('TYPO3_MODE') or die();

foreach (['media', 'category'] as $table) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_fkulibrary_domain_model_' . $table);
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_fkulibrary_domain_model_' . $table, 
	'EXT:fkulibrary/Resources/Private/Language/locallang_' . $table . '.xlf');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('fku_library', 'Configuration/TypoScript', 'FKU Library');

?>