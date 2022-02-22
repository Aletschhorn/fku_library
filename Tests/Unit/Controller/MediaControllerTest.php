<?php
namespace FKU\FkuLibrary\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Daniel Widmer <daniel.widmer@fku.ch>
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class FKU\FkuLibrary\Controller\MediaController.
 *
 * @author Daniel Widmer <daniel.widmer@fku.ch>
 */
class MediaControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \FKU\FkuLibrary\Controller\MediaController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('FKU\\FkuLibrary\\Controller\\MediaController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllMediasFromRepositoryAndAssignsThemToView() {

		$allMedias = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$mediaRepository = $this->getMock('FKU\\FkuLibrary\\Domain\\Repository\\MediaRepository', array('findAll'), array(), '', FALSE);
		$mediaRepository->expects($this->once())->method('findAll')->will($this->returnValue($allMedias));
		$this->inject($this->subject, 'mediaRepository', $mediaRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('medias', $allMedias);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenMediaToView() {
		$media = new \FKU\FkuLibrary\Domain\Model\Media();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('media', $media);

		$this->subject->showAction($media);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenMediaToView() {
		$media = new \FKU\FkuLibrary\Domain\Model\Media();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newMedia', $media);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($media);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenMediaToMediaRepository() {
		$media = new \FKU\FkuLibrary\Domain\Model\Media();

		$mediaRepository = $this->getMock('FKU\\FkuLibrary\\Domain\\Repository\\MediaRepository', array('add'), array(), '', FALSE);
		$mediaRepository->expects($this->once())->method('add')->with($media);
		$this->inject($this->subject, 'mediaRepository', $mediaRepository);

		$this->subject->createAction($media);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenMediaToView() {
		$media = new \FKU\FkuLibrary\Domain\Model\Media();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('media', $media);

		$this->subject->editAction($media);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenMediaInMediaRepository() {
		$media = new \FKU\FkuLibrary\Domain\Model\Media();

		$mediaRepository = $this->getMock('FKU\\FkuLibrary\\Domain\\Repository\\MediaRepository', array('update'), array(), '', FALSE);
		$mediaRepository->expects($this->once())->method('update')->with($media);
		$this->inject($this->subject, 'mediaRepository', $mediaRepository);

		$this->subject->updateAction($media);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenMediaFromMediaRepository() {
		$media = new \FKU\FkuLibrary\Domain\Model\Media();

		$mediaRepository = $this->getMock('FKU\\FkuLibrary\\Domain\\Repository\\MediaRepository', array('remove'), array(), '', FALSE);
		$mediaRepository->expects($this->once())->method('remove')->with($media);
		$this->inject($this->subject, 'mediaRepository', $mediaRepository);

		$this->subject->deleteAction($media);
	}
}
