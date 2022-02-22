<?php

namespace FKU\FkuLibrary\Tests\Unit\Domain\Model;

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
 * Test case for class \FKU\FkuLibrary\Domain\Model\Media.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Daniel Widmer <daniel.widmer@fku.ch>
 */
class MediaTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \FKU\FkuLibrary\Domain\Model\Media
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \FKU\FkuLibrary\Domain\Model\Media();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getRegisterIdReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getRegisterId()
		);
	}

	/**
	 * @test
	 */
	public function setRegisterIdForStringSetsRegisterId() {
		$this->subject->setRegisterId('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'registerId',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRegisterDateReturnsInitialValueForDateTime() {
		$this->assertEquals(
			NULL,
			$this->subject->getRegisterDate()
		);
	}

	/**
	 * @test
	 */
	public function setRegisterDateForDateTimeSetsRegisterDate() {
		$dateTimeFixture = new \DateTime();
		$this->subject->setRegisterDate($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'registerDate',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAuthorReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getAuthor()
		);
	}

	/**
	 * @test
	 */
	public function setAuthorForStringSetsAuthor() {
		$this->subject->setAuthor('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'author',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPublisherReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getPublisher()
		);
	}

	/**
	 * @test
	 */
	public function setPublisherForStringSetsPublisher() {
		$this->subject->setPublisher('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'publisher',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getYearReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getYear()
		);
	}

	/**
	 * @test
	 */
	public function setYearForStringSetsYear() {
		$this->subject->setYear('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'year',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEditionReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEdition()
		);
	}

	/**
	 * @test
	 */
	public function setEditionForStringSetsEdition() {
		$this->subject->setEdition('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'edition',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getKeywordsReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getKeywords()
		);
	}

	/**
	 * @test
	 */
	public function setKeywordsForStringSetsKeywords() {
		$this->subject->setKeywords('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'keywords',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIsbnReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getIsbn()
		);
	}

	/**
	 * @test
	 */
	public function setIsbnForStringSetsIsbn() {
		$this->subject->setIsbn('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'isbn',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getRecommendedReturnsInitialValueForBoolean() {
		$this->assertSame(
			FALSE,
			$this->subject->getRecommended()
		);
	}

	/**
	 * @test
	 */
	public function setRecommendedForBooleanSetsRecommended() {
		$this->subject->setRecommended(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'recommended',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getNewflagReturnsInitialValueForBoolean() {
		$this->assertSame(
			FALSE,
			$this->subject->getNewflag()
		);
	}

	/**
	 * @test
	 */
	public function setNewflagForBooleanSetsNewflag() {
		$this->subject->setNewflag(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'newflag',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCategoryReturnsInitialValueForCategory() {
		$this->assertEquals(
			NULL,
			$this->subject->getCategory()
		);
	}

	/**
	 * @test
	 */
	public function setCategoryForCategorySetsCategory() {
		$categoryFixture = new \FKU\FkuLibrary\Domain\Model\Category();
		$this->subject->setCategory($categoryFixture);

		$this->assertAttributeEquals(
			$categoryFixture,
			'category',
			$this->subject
		);
	}
}
