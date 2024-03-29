<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "fku_library"
 *
 * Auto generated by Extension Builder 2015-02-08
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'FKU Library',
	'description' => '',
	'category' => 'plugin',
	'author' => 'Daniel Widmer',
	'author_email' => 'daniel.widmer@fku.ch',
	'state' => 'stable',
	'clearCacheOnLoad' => 0,
	'version' => '3.1.1',
	'constraints' => [
		'depends' => [
			'typo3' => '7.6.0 - 10.4.99',
		],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
];
/***********************************************
 * Version 1.8.0
 * -------------                    
 * Constant allows to set if all media are shown if not search term is entered
 *
 * Version 1.8.1
 * -------------                    
 * Halflings instead of glyphicons
 *
 * Version 1.9.0
 * -------------                    
 * Render flash messages in separate partial template (for Typo3 v8.7)
 * Increased Typo3 version dependency to 8.7
 *
 * Version 2.0.0
 * -------------                    
 * Added field "label" for category
 * When creating a new media or editing an existing one, the registerId is suggested as the current highest registerId + 1
 * Correct flashMessage handling for Typo3 8, dismissable OK alert
 * When creating or updating media a integrity check can be performed to analyze for same register ID or similar title
 *
 * Version 2.0.1
 * -------------                    
 * Minor changes in alert layout (non-breaking space after icon)
 * Modified wording in warning alerts when saving a book
 *
 * Version 2.1.0
 * -------------                    
 * Added scheduler object to perform integrity test
 * Export Excel file set to UTF8 (and with BOM)
 *
 * Version 2.2.0
 * -------------                    
 * Added test action
 *
 * Version 2.3.0
 * -------------                    
 * Added option for publisher check in test action
 * Accept same registerID for media when add a new book and confirm same registerID
 * Returning back from edit action to searchAdmin action shows search results again (of last search saved in cookies)
 * Allows sorting by publisher in search action and searchAdmin action
 * Added selection field to select field where the searchword shall be searched in search action and searchAdmin action
 * For comparing titles in test action, only such ones with different first 7 characters are compared to avoid comparing A-001a with A-001b
 * Show a match value (in percent) in the test action result list
 *
 * Version 2.4.0
 * -------------                    
 * Use constants (from constant editor) in test action to compare title, author, and publisher
 * Modified wording for parameter based test action selection
 *
 * Version 2.5.0
 * -------------                    
 * Function MediaController->nextRegisterId finds first non-used registration ID (instead of highest existing one +1)
 * New action IdCheck to display unused registerId of medias
 *
 * Version 2.6.0
 * -------------                    
 * Added field temporary in media table; by default such flagged medias are not shown in a search
 * New partial action Media/SearchForm used by Media->searchAction and Media->searchAdminAction
 * Recent pages of search result list is now properly saved in session cookie
 *
 * Version 2.6.1
 * -------------                    
 * Correction in MediaController::getUnusedRegisterIds to cut the correct part from the registerID
 *
 * Version 2.6.2
 * -------------                    
 * Correction in template Partials/Media/SearchForm
 *
 * Version 2.7.0
 * -------------                    
 * Added parameter "rejected" for media (new database field), adapted some templates accordingly
 *
 * Version 2.8.0
 * -------------                    
 * Removed translations of categories and media
 * Applied corrections in TCA definitions
 *
 * Version 3.0.0
 * -------------                    
 * Ready for Typo3 version 10, Bootstrap 4.5, Glyphicons 2.4
 *
 * Version 3.0.1
 * -------------                    
 * Corrections in TCA definitions
 *
 * Version 3.0.2
 * -------------                    
 * Added composer.json
 * Changed name of pageType for Excel export and added commented content (10)
 * New partial Media/SerachForm.html used for Search and AdminSearch
 * Made actions SearchAdmin and New non-cacheable
 *
 * Version 3.1.0
 * -------------                    
 * Get rid of swtichable actions in flexform
 * Use extension .typoscript for TypoScript files
 *
 * Version 3.1.1
 * -------------                    
 * Correction of pagination links in template SearchAdmin.html
 *
**/