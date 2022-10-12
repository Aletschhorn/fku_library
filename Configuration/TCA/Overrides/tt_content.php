<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuLibrary',
	'Library',
	'Library'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuLibrary',
	'LastAdded',
	'Library last added media'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'FkuLibrary',
	'Admin',
	'Library Admin'
);

// register flexform
foreach (['lastadded', 'admin'] as $plugin) {
	$pluginSignature = 'fkulibrary_'.$plugin;
	$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:fku_library/Configuration/FlexForms/flexform_'.$plugin.'.xml'); 
}
