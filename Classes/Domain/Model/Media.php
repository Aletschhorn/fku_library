<?php
namespace FKU\FkuLibrary\Domain\Model;


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
 * Media
 */
class Media extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * registerId
	 *
	 * @var string
	 */
	protected $registerId = '';

	/**
	 * registerDate
	 *
	 * @var \DateTime
	 */
	protected $registerDate = NULL;

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * author
	 *
	 * @var string
	 */
	protected $author = '';

	/**
	 * publisher
	 *
	 * @var string
	 */
	protected $publisher = '';

	/**
	 * keywords
	 *
	 * @var string
	 */
	protected $keywords = '';

	/**
	 * isbn
	 *
	 * @var string
	 */
	protected $isbn = '';

	/**
	 * recommended
	 *
	 * @var boolean
	 */
	protected $recommended = FALSE;

	/**
	 * newflag
	 *
	 * @var boolean
	 */
	protected $newflag = FALSE;

	/**
	 * missing
	 *
	 * @var boolean
	 */
	protected $missing = FALSE;

	/**
	 * temporary
	 *
	 * @var boolean
	 */
	protected $temporary = FALSE;

	/**
	 * rejected
	 *
	 * @var boolean
	 */
	protected $rejected = FALSE;

	/**
	 * category
	 *
	 * @var \FKU\FkuLibrary\Domain\Model\Category
	 */
	protected $category = NULL;

	/**
	 * Returns the registerId
	 *
	 * @return string $registerId
	 */
	public function getRegisterId() {
		return $this->registerId;
	}

	/**
	 * Sets the registerId
	 *
	 * @param string $registerId
	 * @return void
	 */
	public function setRegisterId($registerId) {
		$this->registerId = $registerId;
	}

	/**
	 * Returns the registerDate
	 *
	 * @return \DateTime $registerDate
	 */
	public function getRegisterDate() {
		return $this->registerDate;
	}

	/**
	 * Sets the registerDate
	 *
	 * @param \DateTime $registerDate
	 * @return void
	 */
	public function setRegisterDate(\DateTime $registerDate) {
		$this->registerDate = $registerDate;
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the author
	 *
	 * @return string $author
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Sets the author
	 *
	 * @param string $author
	 * @return void
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Returns the publisher
	 *
	 * @return string $publisher
	 */
	public function getPublisher() {
		return $this->publisher;
	}

	/**
	 * Sets the publisher
	 *
	 * @param string $publisher
	 * @return void
	 */
	public function setPublisher($publisher) {
		$this->publisher = $publisher;
	}

	/**
	 * Returns the keywords
	 *
	 * @return string $keywords
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * Sets the keywords
	 *
	 * @param string $keywords
	 * @return void
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Returns the isbn
	 *
	 * @return string $isbn
	 */
	public function getIsbn() {
		return $this->isbn;
	}

	/**
	 * Sets the isbn
	 *
	 * @param string $isbn
	 * @return void
	 */
	public function setIsbn($isbn) {
		$this->isbn = $isbn;
	}

	/**
	 * Returns the recommended
	 *
	 * @return boolean $recommended
	 */
	public function getRecommended() {
		return $this->recommended;
	}

	/**
	 * Sets the recommended
	 *
	 * @param boolean $recommended
	 * @return void
	 */
	public function setRecommended($recommended) {
		$this->recommended = $recommended;
	}

	/**
	 * Returns the boolean state of recommended
	 *
	 * @return boolean
	 */
	public function isRecommended() {
		return $this->recommended;
	}

	/**
	 * Returns the missing
	 *
	 * @return boolean $missing
	 */
	public function getMissing() {
		return $this->missing;
	}

	/**
	 * Sets the missing
	 *
	 * @param boolean $missing
	 * @return void
	 */
	public function setMissing($missing) {
		$this->missing = $missing;
	}

	/**
	 * Returns the boolean state of missing
	 *
	 * @return boolean
	 */
	public function isMissing() {
		return $this->missing;
	}

	/**
	 * Returns the newflag
	 *
	 * @return boolean $newflag
	 */
	public function getNewflag() {
		return $this->newflag;
	}

	/**
	 * Sets the newflag
	 *
	 * @param boolean $newflag
	 * @return void
	 */
	public function setNewflag($newflag) {
		$this->newflag = $newflag;
	}

	/**
	 * Returns the boolean state of newflag
	 *
	 * @return boolean
	 */
	public function isNewflag() {
		return $this->newflag;
	}

	/**
	 * Returns the temporary
	 *
	 * @return boolean $temporary
	 */
	public function getTemporary() {
		return $this->temporary;
	}

	/**
	 * Sets the temporary
	 *
	 * @param boolean $temporary
	 * @return void
	 */
	public function setTemporary($temporary) {
		$this->temporary = $temporary;
	}

	/**
	 * Returns the boolean state of temporary
	 *
	 * @return boolean
	 */
	public function isTemporary() {
		return $this->temporary;
	}

	/**
	 * Returns the rejected
	 *
	 * @return boolean $rejected
	 */
	public function getRejected() {
		return $this->rejected;
	}

	/**
	 * Sets the rejected
	 *
	 * @param boolean $rejected
	 * @return void
	 */
	public function setRejected($rejected) {
		$this->rejected = $rejected;
	}

	/**
	 * Returns the boolean state of rejected
	 *
	 * @return boolean
	 */
	public function isRejected() {
		return $this->rejected;
	}

	/**
	 * Returns the category
	 *
	 * @return \FKU\FkuLibrary\Domain\Model\Category $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param \FKU\FkuLibrary\Domain\Model\Category $category
	 * @return void
	 */
	public function setCategory(\FKU\FkuLibrary\Domain\Model\Category $category) {
		$this->category = $category;
	}

}