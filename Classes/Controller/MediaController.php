<?php
namespace FKU\FkuLibrary\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Daniel Widmer <daniel.widmer@fku.ch>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * MediaController
 */

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use FKU\FkuLibrary\Domain\Repository\MediaRepository;
use FKU\FkuLibrary\Domain\Repository\CategoryRepository;


class MediaController extends ActionController {

	/**
	 * mediaRepository
	 *
	 * @var MediaRepository
	 */
	protected $mediaRepository;

	/**
	 * categoryRepository
	 *
	 * @var CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * @param PersistenceManager $persistenceManager
	 * @param MediaRepository $mediaRepository
	 * @param CategoryRepository $categoryRepository
	 */
	public function __construct(
			PersistenceManager $persistenceManager,
			MediaRepository $mediaRepository,
			CategoryRepository $categoryRepository
		) {
		$this->persistenceManager = $persistenceManager;
		$this->mediaRepository = $mediaRepository;
		$this->categoryRepository = $categoryRepository;
	}
	
	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$GLOBALS['TSFE']->fe_user->setKey('ses','libraryPage','list');
		$category = intval($GLOBALS['TSFE']->fe_user->getKey('ses','libraryListCategory'));
		if ($this->request->hasArgument('category')) { 
			$category = intval($this->request->getArgument('category'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','libraryListCategory',$category);
		}
		
		$medias = $this->mediaRepository->findPerCategory($category);
		$categories = $this->categoryRepository->findAll();
		
		$this->view->assignMultiple(array(
			'medias' => $medias,
			'categories' => $categories,
			'category' => $category,
			'newLimit' => $this->getNewLimit(),
			'exportPageType' => $this->settings['excelPageType'],
			'settings' => $this->settings,
		));
	}

	/**
	 * action listNew
	 *
	 * @return void
	 */
	public function listNewAction() {
		$GLOBALS['TSFE']->fe_user->setKey('ses','libraryPage','listNew');
		
		$category = 0;
		$medias = $this->mediaRepository->findNewFlagged();
		
		$this->view->assignMultiple(array(
			'medias' => $medias,
			'exportPageType' => $this->settings['excelPageType'],
			'settings' => $this->settings,
		));
	}

	/**
	 * action listLastAdded
	 *
	 * @return void
	 */
	public function listLastAddedAction() {
		$GLOBALS['TSFE']->fe_user->setKey('ses','libraryPage','listLastAdded');
		
		$limit = intval($this->settings['limitation']);
		if ($limit < 1) { $limit = 5; }
		$medias = $this->mediaRepository->findLastAdded($limit);
		
		$this->view->assignMultiple(array(
			'medias' => $medias,
			'exportPageType' => $this->settings['excelPageType'],
			'settings' => $this->settings,
		));
	}

	/**
	 * action listMissing
	 *
	 * @return void
	 */
	public function listMissingAction() {
		$GLOBALS['TSFE']->fe_user->setKey('ses','libraryPage','listMissing');
		
		$medias = $this->mediaRepository->findMissing();
		
		$this->view->assignMultiple(array(
			'medias' => $medias,
			'exportPageType' => $this->settings['excelPageType'],
			'settings' => $this->settings,
		));
	}

	/**
	 * action listTemporary
	 *
	 * @return void
	 */
	public function listTemporaryAction() {
		$GLOBALS['TSFE']->fe_user->setKey('ses','libraryPage','listTemporary');
		
		$medias = $this->mediaRepository->findTemporary();
		
		$this->view->assignMultiple(array(
			'medias' => $medias,
			'exportPageType' => $this->settings['excelPageType'],
			'settings' => $this->settings,
		));
	}

	/**
	 * action search
	 *
	 * @return void
	 */
	public function searchAction() {
		// get parameters from form or cookies and store them in cookies
		$searchword = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachWord');
		if ($this->request->hasArgument('searchword')) { 
			$searchword = trim($this->request->getArgument('searchword'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachWord',$searchword);
		}
		$field = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachField');
		if ($this->request->hasArgument('field')) { 
			$field = intval($this->request->getArgument('field'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachField',$field);
		}
		$category = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachCategory');
		if ($this->request->hasArgument('category')) { 
			$category = intval($this->request->getArgument('category'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachCategory',$category);
		}
		$limit_recommended = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachRecommended');
		if ($this->request->hasArgument('limit_recommended')) { 
			$limit_recommended = intval($this->request->getArgument('limit_recommended'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachRecommended',$limit_recommended);
		}
		$limit_new = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachNew');
		if ($this->request->hasArgument('limit_new')) { 
			$limit_new = intval($this->request->getArgument('limit_new'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachNew',$limit_new);
		}
		$incl_missing = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachMissing');
		if ($this->request->hasArgument('incl_missing')) { 
			$incl_missing = intval($this->request->getArgument('incl_missing'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachMissing',$incl_missing);
		}
		$incl_temporary = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachTemporary');
		if ($this->request->hasArgument('incl_temporary')) { 
			$incl_temporary = intval($this->request->getArgument('incl_temporary'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachTemporary',$incl_temporary);
		}
		$sorting = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachSorting');
		if ($this->request->hasArgument('sorting')) { 
			$sorting = trim($this->request->getArgument('sorting'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachSorting',$sorting);
		}
		if ($sorting == '') {
			$sorting = 'title';
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachSorting',$sorting);
		}
		$pagenow = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachPage');
		if ($this->request->hasArgument('page')) { 
			$pagenow = intval($this->request->getArgument('page'));
		}
		if ($pagenow < 1) {
			$pagenow = 1;
		}
		if ($this->request->hasArgument('sent')) { 
			if (intval($this->request->getArgument('sent')) > 0) {
				$pagenow = 1;
				$sent = true;
			}
		}
		$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachPage',$pagenow);

		$filter = array (
			'searchword' => $searchword, 
			'field' => $field,
			'category' => $category, 
			'limit_recommended' => $limit_recommended,
			'limit_new' => $limit_new,
			'incl_missing' => $incl_missing,
			'incl_temporary' => $incl_temporary,
			'sorting' => $sorting
		);
		
		$newLimit = $this->getNewLimit();
		$pagetotal = 1;
		if ($this->settings['requireSearchword']==1 and ! $searchword and ! $category and ! $limit_recommended and ! $limit_new) {
			$medias = array ();
		} else {
			$offset = ($pagenow - 1) * intval($this->settings['resultsPerPage']);
			$limit = intval($this->settings['resultsPerPage']);
			if ($limit_new) {
				$limit_new_date = $newLimit;
			} else {
				$limit_new_date = false;
			}
			$medias = $this->mediaRepository->findFiltered($searchword, $field, $category, $limit_recommended, $limit_new_date, $incl_missing, $incl_temporary, $sorting, $limit, $offset);
			$total = $this->mediaRepository->countFiltered($searchword, $field, $category, $limit_recommended, $limit_new_date, $incl_missing, $incl_temporary);
			
			if ($total > $limit) {
				$pagetotal = ceil($total / $limit);
			}
		}
		$page = array ('now' => $pagenow, 'prev' => max(1,$pagenow-1), 'next' => min($pagetotal,$pagenow+1), 'total' => $pagetotal);
		
		$pagearray = array();
		if ($pagenow > 5) {
			$pagearray = array (1, 2, '...');
			for ($i=$pagenow-2; $i<=$pagenow; $i++) {
				$pagearray[] = $i;
			}
		} else {
			for ($i=1;$i<=$pagenow;$i++) {
				$pagearray[] = $i;
			}
		}
		if ($pagetotal - $pagenow > 5) {
			$pagearray[] = $pagenow+1;
			$pagearray[] = $pagenow+2;
			$pagearray[] = '...';
			for ($i=$pagetotal-1; $i<=$pagetotal; $i++) {
				$pagearray[] = $i;
			}
		} elseif ($pagenow < $pagetotal) {
			for ($i=$pagenow+1; $i<=$pagetotal; $i++) {
				$pagearray[] = $i;
			}
		}
			
		$categories = $this->categoryRepository->findAll();
		$fields = [0 => 'allen Feldern', 1 => 'Titel', 2 => 'Autor', 3 => 'Verlag', 4 => 'Stichworten'];
		
		$this->view->assignMultiple(array(
			'medias' => $medias,
			'total' => $total,
			'page' => $page,
			'pagearray' => $pagearray,
			'categories' => $categories,
			'filter' => $filter,
			'newLimit' => $newLimit,
			'fields' => $fields,
			'sent' => $sent,
			'settings' => $this->settings,
		));
	}

	/**
	 * action searchAdmin
	 *
	 * @return void
	 */
	public function searchAdminAction() {
		// get parameters from form or cookies and store them in cookies
		$GLOBALS['TSFE']->fe_user->setKey('ses','libraryPage','searchAdmin');
		$searchword = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachWord');
		if ($this->request->hasArgument('searchword')) { 
			$searchword = trim($this->request->getArgument('searchword'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachWord',$searchword);
		}
		$field = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachField');
		if ($this->request->hasArgument('field')) { 
			$field = intval($this->request->getArgument('field'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachField',$field);
		}
		$category = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachCategory');
		if ($this->request->hasArgument('category')) { 
			$category = intval($this->request->getArgument('category'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachCategory',$category);
		}
		$limit_recommended = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachRecommended');
		if ($this->request->hasArgument('limit_recommended')) { 
			$limit_recommended = intval($this->request->getArgument('limit_recommended'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachRecommended',$limit_recommended);
		}
		$limit_new = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachNew');
		if ($this->request->hasArgument('limit_new')) { 
			$limit_new = intval($this->request->getArgument('limit_new'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachNew',$limit_new);
		}
		$incl_missing = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachMissing');
		if ($this->request->hasArgument('incl_missing')) { 
			$incl_missing = intval($this->request->getArgument('incl_missing'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachMissing',$incl_missing);
		}
		$incl_temporary = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachTemporary');
		if ($this->request->hasArgument('incl_temporary')) { 
			$incl_temporary = intval($this->request->getArgument('incl_temporary'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachTemporary',$incl_temporary);
		}
		$sorting = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachSorting');
		if ($this->request->hasArgument('sorting')) { 
			$sorting = trim($this->request->getArgument('sorting'));
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachSorting',$sorting);
		}
		if ($sorting == '') {
			$sorting = 'title';
			$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachSorting',$sorting);
		}
		$pagenow = $GLOBALS['TSFE']->fe_user->getKey('ses','librarySeachPage');
		if ($this->request->hasArgument('page')) { 
			$pagenow = intval($this->request->getArgument('page'));
		}
		if ($pagenow < 1) {
			$pagenow = 1;
		}
		if ($this->request->hasArgument('sent')) { 
			if (intval($this->request->getArgument('sent')) > 0) {
				$pagenow = 1;
			}
		}
		$GLOBALS['TSFE']->fe_user->setKey('ses','librarySeachPage',$pagenow);
		
		$filter = array (
			'searchword' => $searchword,
			'field' => $field,
			'category' => $category,
			'limit_recommended' => $limit_recommended,
			'limit_new' => $limit_new,
			'incl_missing' => $incl_missing,
			'incl_temporary' => $incl_temporary,
			'sorting' => $sorting
		);
		
		// Run search
		$newLimit = $this->getNewLimit();
		$pagetotal = 1;
		if ($this->settings['requireSearchword']==1 and ! $searchword and ! $category and ! $limit_recommended and ! $limit_new) {
			$medias = array ();
		} else {
			$offset = ($pagenow - 1) * intval($this->settings['resultsPerPage']);
			$limit = intval($this->settings['resultsPerPage']);
			if ($limit_new) {
				$limit_new_date = $newLimit;
			} else {
				$limit_new_date = false;
			}
			$medias = $this->mediaRepository->findFiltered($searchword, $field, $category, $limit_recommended, $limit_new_date, $incl_missing, $incl_temporary, $sorting, $limit, $offset);
			$total = $this->mediaRepository->countFiltered($searchword, $field, $category, $limit_recommended, $limit_new_date, $incl_missing, $incl_temporary);
			
			if ($total > $limit) {
				$pagetotal = ceil($total / $limit);
			}
		}
		$page = array ('now' => $pagenow, 'prev' => max(1,$pagenow-1), 'next' => min($pagetotal,$pagenow+1), 'total' => $pagetotal);
		
		// Prepare pagination values
		$pagearray = array();
		if ($pagenow > 5) {
			$pagearray = array (1, 2, '...');
			for ($i=$pagenow-2; $i<=$pagenow; $i++) {
				$pagearray[] = $i;
			}
		} else {
			for ($i=1;$i<=$pagenow;$i++) {
				$pagearray[] = $i;
			}
		}
		if ($pagetotal - $pagenow > 5) {
			$pagearray[] = $pagenow+1;
			$pagearray[] = $pagenow+2;
			$pagearray[] = '...';
			for ($i=$pagetotal-1; $i<=$pagetotal; $i++) {
				$pagearray[] = $i;
			}
		} elseif ($pagenow < $pagetotal) {
			for ($i=$pagenow+1; $i<=$pagetotal; $i++) {
				$pagearray[] = $i;
			}
		}
			
		$categories = $this->categoryRepository->findAll();
		$fields = [0 => 'allen Feldern', 1 => 'Titel', 2 => 'Autor', 3 => 'Verlag', 4 => 'Stichworten'];
		
		$this->view->assignMultiple(array(
			'medias' => $medias,
			'total' => $total,
			'page' => $page,
			'pagearray' => $pagearray,
			'categories' => $categories,
			'filter' => $filter,
			'newLimit' => $newLimit,
			'fields' => $fields,
			'sent' => $sent,
			'settings' => $this->settings,
		));
	}

	/**
	 * action show
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Media $media
	 * @return void
	 */
	public function showAction(\FKU\FkuLibrary\Domain\Model\Media $media) {
		$this->view->assign('media', $media);
	}

	/**
	 * action new
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Media $media
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("media")
	 * @return void
	 */
	public function newAction(\FKU\FkuLibrary\Domain\Model\Media $media = NULL) {
		if (! $media) {
			$media = new \FKU\FkuLibrary\Domain\Model\Media;
		}
		$media->setNewflag(true);
		$media->setRegisterDate(new \DateTime());
		$categories = $this->categoryRepository->findAll();
		$this->view->assignMultiple(array(
			'media' => $media,
			'categories' => $categories,
			'now' => new \DateTime(),
			'newIds' => $this->getUnusedRegisterIds()
		));
	}

	/**
	* initializeCreateAction
	*
	* @return void
	*/
	public function initializeCreateAction() {
		if (isset($this->arguments['media'])) {
			$this->arguments['media']->getPropertyMappingConfiguration()->forProperty('registerDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		}
	}

	/**
	 * action create
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Media $media
	 * @return void
	 */
	public function createAction(\FKU\FkuLibrary\Domain\Model\Media $media) {
		$this->mediaRepository->add($media);
		$this->persistenceManager->persistAll();
		$this->integrityCheck($media, $sameRegisterId, $similarTitle);
		$message = $this->integrityCheckWarnMessage($sameRegisterId, $similarTitle);
		if ($message) {
			$this->addFlashMessage($message,'Problem festgestellt',\TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);		
			$this->redirect('edit','Media','FkuLibrary',array('media' => $media, 'confirmation' => 1));
		} else {
			$this->addFlashMessage('Das neue Buch wurde gespeichert.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);		
			$action = $GLOBALS['TSFE']->fe_user->getKey('ses','libraryPage');
			if (! $action) { $action = 'list'; }
			$this->redirect($action);
		}
	}

	/**
	 * action edit
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Media $media
	 * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("media")
	 * @return void
	 */
	public function editAction(\FKU\FkuLibrary\Domain\Model\Media $media) {
		$confirmation = 0;
		if ($this->request->hasArgument('confirmation')) { 
			$confirmation = intval($this->request->getArgument('confirmation'));
		}
		$categories = $this->categoryRepository->findAll();
		$this->view->assignMultiple(array(
			'media' => $media,
			'confirmation' => $confirmation,
			'categories' => $categories,
			'newIds' => $this->getUnusedRegisterIds()
		));
	}

	/**
	* initializeUpdateAction
	*
	* @return void
	*/
	public function initializeUpdateAction() {
		if (isset($this->arguments['media'])) {
			$this->arguments['media']->getPropertyMappingConfiguration()->forProperty('registerDate')->setTypeConverterOption('TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'd.m.Y');
		}
	}

	/**
	 * action update
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Media $media
	 * @return void
	 */
	public function updateAction(\FKU\FkuLibrary\Domain\Model\Media $media) {
		$confirmation = 0;
		if ($this->request->hasArgument('confirmation')) { 
			$confirmation = intval($this->request->getArgument('confirmation'));
		}

		$this->mediaRepository->update($media);
		$this->persistenceManager->persistAll();

		$message = '';
		$this->integrityCheck($media, $sameRegisterId, $similarTitle);
		if ($confirmation == 0) {
			$message = $this->integrityCheckWarnMessage($sameRegisterId, $similarTitle);
		}
		if ($message) {
			$this->addFlashMessage($message,'Problem festgestellt',\TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);		
			$this->redirect('edit','Media','FkuLibrary',array('media' => $media, 'confirmation' => 1));
		} else {
			$this->addFlashMessage('Die Buchangaben wurden gespeichert.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);		
			$action = $GLOBALS['TSFE']->fe_user->getKey('ses','libraryPage');
			if (! $action) { $action = 'list'; }
			$this->redirect($action);
		}
	}

	/**
	 * action delete
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Media $media
	 * @return void
	 */
	public function deleteAction(\FKU\FkuLibrary\Domain\Model\Media $media) {
		$this->mediaRepository->remove($media);
		$this->addFlashMessage('Buch wurde gelöscht.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);		
		$action = $GLOBALS['TSFE']->fe_user->getKey('ses','libraryPage');
		if (! $action) { $action = 'list'; }
		$this->redirect($action);
	}

	/**
	 * action export
	 *
	 * @return void
	 */
	public function exportAction() {
		$category = 0;
		$medias = array ();
		if ($this->request->hasArgument('category')) { 
			$category = intval($this->request->getArgument('category'));
			$medias = $this->mediaRepository->findPerCategory($category);
		} elseif ($this->request->hasArgument('newflag')) {
			$medias = $this->mediaRepository->findNewFlagged();
		} elseif ($this->request->hasArgument('missing')) {
			$medias = $this->mediaRepository->findMissing();
		} elseif ($this->request->hasArgument('temporary')) {
			$medias = $this->mediaRepository->findTemporary();
		}
		
		$bom = chr(0xEF) . chr(0xBB) . chr(0xBF);  // Byte order mark for UTF-8
//		$bom = chr(255) . chr(254);  // Byte order mark for UTF-16LE
		
		$separator = $this->settings['exportSeparator'];
		if (substr($separator, 0, 3) == 'chr') {
			$chrValue = substr($separator, 4, -1);
			$separator = chr($chrValue);
		}
		
		$title = 'Bibliothek_'.date('Ymd-His').'.csv';
		$this->response->setHeader('Expires','0');
		$this->response->setHeader('Cache-Control','must-revalidate, post-check=0, pre-check=0');
		$this->response->setHeader('Content-Disposition','attachment; filename=' . $title);
		$this->response->setHeader('Content-Transfer-Encoding','binary');
		$this->response->setHeader('Content-Type','text/csv; charset=UTF-8');
//		$this->response->setHeader('Content-Type','text/csv; charset=UTF-16LE');
		$this->response->sendHeaders();

		$this->view->assignMultiple(array(
			'medias' => $medias,
			'newLimit' => $this->getNewLimit(),
			'bom' =>  $bom,
			'separator' => $separator,
		));
	}

	/**
	 * action removeNewFlagAction
	 *
	 * @return void
	 */
	public function removeNewFlagAction() {
		$result = $this->mediaRepository->removeNewFlag();
		if ($result) {
			$this->addFlashMessage('Alle Neu-Markierungen entfernt.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::OK);		
		} else {
			$this->addFlashMessage('Fehler beim Entfernen der Neu-Markierungen.','',\TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);		
		}
		$action = $GLOBALS['TSFE']->fe_user->getKey('ses','libraryPage');
		if (! $action) { $action = 'list'; }
		$this->redirect($action);
	}

	/**
	 * action test
	 *
	 * @return void
	 */
	public function testAction() {
		$testingSelection = [
			0 => '', 
			1 => 'Buch-Nummer', 
			2 => [0 => 'Buch-Titel', 1 => 'auch innerhalb Buchreihen', 2 => 'ohne Buchreihen'],
			3 => 'Autor', 
			4 => 'Verlag'
		];

		if ($this->request->hasArgument('testing')) { 
			$testing = intval($this->request->getArgument('testing'));
		}
		if ($testing > 4) {
			$testing = 0;
		}

		$param = 0;
		if ($this->request->hasArgument('param')) { 
			$param = intval($this->request->getArgument('param'));
		}
		
		$counter = 0;
		$issues = [];
		if ($testing > 0) {
			$media1 = $this->mediaRepository->findAllSorted('uid',true); // all media in reverse ID order
			$media2 = $this->mediaRepository->findAllSorted('uid',false); // all media in normal ID order
			
			foreach ($media1 as $m1) {
				foreach ($media2 as $m2) {
					// compare media of higest ID with all all media starting from lowest ID until they have the same ID
					if ($m1 == $m2) {
						break;
					}
					$counter++;
					switch ($testing) {
						case 1: // checks if register IDs are different
							if ($m1->getRegisterId() == $m2->getRegisterId()) {
								$issues[] = [0 => $m1, 1 => $m2, 2 => 100];
							}
							break;
						case 2: // checks if titles are similar
							if (substr($m2->getRegisterId(),0,5) != substr($m1->getRegisterId(),0,5) or $param == 1) {
								similar_text(strtolower($m2->getTitle()), strtolower($m1->getTitle()), $percent);
								if ($percent >= $this->settings['checkTitlePercent']) {
									$issues[] = [0 => $m1, 1 => $m2, 2 => $percent];
								}
							}
							break;
						case 3: // checks if authors are similar
							similar_text(strtolower($m2->getAuthor()), strtolower($m1->getAuthor()), $percent);
							if ($percent > $this->settings['checkAuthorPercent'] and $percent < 100) {
								$issues[] = [0 => $m1, 1 => $m2, 2 => $percent];
							}
							break;
						case 4: // checks if publishers are similar
							if ($publ1 = $m1->getPublisher() and $publ2 = $m2->getPublisher()) {
								similar_text(strtolower($publ2), strtolower($publ1), $percent);
								if ($percent > $this->settings['checkPublisherPercent'] and $percent < 100) {
									$issues[] = [0 => $m1, 1 => $m2, 2 => $percent];
								}
							}
							break;
					}
				}
			}
		}
		
		$this->view->assignMultiple(array(
			'issues' => $issues,
			'counter' => $counter,
			'testingSelection' => $testingSelection,
			'testing' => $testing,
			'param' => $param,
		));
	}

	/**
	 * action idCheck
	 *
	 * @return void
	 */
	public function idCheckAction() {
		$this->view->assignMultiple(array(
			'categories' => $this->categoryRepository->findAll(),
			'unused' => $this->getUnusedRegisterIds(0),
		));
	}
	
	/**
	 * getNewLimit
	 *
	 * @return \DateTime
	 */
	public function getNewLimit() {
		$newMonths = intval($this->settings['newMonths']);
		if ($newMonths <= 0) { $newMonths = 3; }
		$newTimestamp = strtotime('-'.$newMonths.' months');
		$newLimit = new \DateTime (date('Y-m-d',$newTimestamp));
		return $newLimit;
	}

	/**
	 * getUnusedRegisterIds
	 *
	 * @param boolean $onlyFirst
	 * @return array
	 */
	public function getUnusedRegisterIds($onlyFirst = true) {
		$unusedIds = [];
		$categories = $this->categoryRepository->findAll();
		foreach ($categories as $category) {
			$medias = $this->mediaRepository->findPerCategory($category->getUid());
			$probing = 0;
			$foundFirst = false;
			foreach ($medias as $media) {
				$probing++;
				$current = intval(substr($media->getRegisterId(),2,3));
				if ($current < $probing) {
					$probing = $current;
				} elseif ($current > $probing) {
					if ($onlyFirst) {
						$unusedIds[$category->getUid()] = $category->getLabel() . '-' . sprintf('%03d', $probing);
						$foundFirst = true;
						break;						
					} else {
						for ($i=$probing; $i<$current; $i++) {
							$unusedIds[$category->getUid()][] = $category->getLabel() . '-' . sprintf('%03d', $i);
						}
						$probing = $current;
					}
				}
			}
			$probing++;
			if ($onlyFirst) {
				if (! $foundFirst) {
					$unusedIds[$category->getUid()] = $category->getLabel() . '-' . sprintf('%03d', $probing);
				}
			} else {
				$unusedIds[$category->getUid()][] = $category->getLabel() . '-' . sprintf('%03d', $probing);
			}
				
		}
		return $unusedIds;
	}

	/**
	 * integrityCheck
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Media $media
	 * @param array $sameRegisterId Output array of media objects that have the same register ID
	 * @param array $similarMedia Output array of media objects that have a similar title
	 */
	public function integrityCheck(\FKU\FkuLibrary\Domain\Model\Media $media, &$sameRegisterId, &$similarTitle) {
		$sameRegisterId = [];
		$similarTitle = [];
		if (max($this->settings['checkTitle'], $this->settings['checkRegisterid']) > 0) {
			$allMedia = $this->mediaRepository->findAll();
			foreach ($allMedia as $oneMedia) {
				if ($oneMedia != $media) {
					if ($this->settings['checkTitle']) {
						similar_text(strtolower($media->getTitle()), strtolower($oneMedia->getTitle()), $percent);
						if ($percent >= $this->settings['checkTitlePercent']) {
							$similarTitle[] = $oneMedia;
						}
					}
					if ($this->settings['checkRegisterid']) {
						if ($media->getRegisterId() == $oneMedia->getRegisterId()) {
							$sameRegisterId[] = $oneMedia;
						}
					}
				}
			}
		}
	}


	/**
	 * integrityCheckWarnMessage
	 *
	 * @param array $sameRegisterId Array of media objects that have the same register ID
	 * @param array $similarMedia Array of media objects that have a similar title
	 * @return string
	 */
	public function integrityCheckWarnMessage($sameRegisterId, $similarTitle) {
		$message = '';
		if (count($sameRegisterId) > 0) {
			if (count($sameRegisterId) > 1) {
				$message .= 'Bücher mit der gleichen Buch-Nummer existieren bereits in der Sammlung:<br /><ul>';
			} else {
				$message .= 'Ein Buch mit der gleichen Buch-Nummer existiert bereits in der Sammlung:<br /><ul>';
			}
			foreach ($sameRegisterId as $mediaItem) {
				$message .= '<li>&quot;'.$mediaItem->getTitle().'&quot;';
				if ($mediaItem->getAuthor()) { $message .= ' von '.$mediaItem->getAuthor(); }
				$message .= ', Buch-Nummer '.$mediaItem->getRegisterId().'</li>';
			}
			$message .= '</ul>';
			$message .= '<span class="halflings halflings-arrow-right"></span>&nbsp;Buch-Nummer gegebebenfalls ändern, dann erneut speichern.';
		}
		if (count($similarTitle) > 0) {
			if ($message != '') { $message .= '<br /><br />'; }
			if (count($similarTitle) > 1) {
				$message .= 'Bücher mit (fast) gleichem Titel existieren bereits in der Sammlung:<br /><ul>';
			} else {
				$message .= 'Ein Buch mit (fast) gleichem Titel existiert bereits in der Sammlung:<br /><ul>';
			}
			foreach ($similarTitle as $mediaItem) {
				$message .= '<li>&quot;'.$mediaItem->getTitle().'&quot;';
				if ($mediaItem->getAuthor()) { $message .= ' von '.$mediaItem->getAuthor(); }
				$message .= ', Buch-Nummer '.$mediaItem->getRegisterId().'</li>';
			}
			$message .= '</ul>';
			$message .= '<span class="halflings halflings-arrow-right"></span>&nbsp;Buch erneut speichern, um den Titel zu bestätigen.';
		}
		return $message;
	}

}