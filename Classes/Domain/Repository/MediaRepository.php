<?php
namespace FKU\FkuLibrary\Domain\Repository;


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
 * The repository for Medias
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;

class MediaRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	* findAllSorted
	*
	* @param \string $sorting field name
	* @param \boolean $reverse change sorting order: 0=ascending, 1=descending
	* @return
	*/
	public function findAllSorted($sorting = 'uid', $reverse = false) {
		if ($reverse) {
			$orderings = array ($sorting => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
		} else {
			$orderings = array ($sorting => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		}
		$query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
		return $query->setOrderings($orderings)->execute();
	}	

	/**
	* findAllAvailable
	*
	* @param \string $sorting
	* @return
	*/
	public function findAllAvailable($sorting = 'title') {
		$orderings = array ($sorting => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		$query = $this->createQuery();
		$query->matching($query->equals('missing',0));
		return $query->setOrderings($orderings)->execute();
	}	

	/**
	* findPerCategory
	*
	* @param \int $category
	* @return
	*/
	public function findPerCategory($category) {
		$orderings = array ('registerId' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		$query = $this->createQuery();
		if ($category > 0) {
			$query->matching($query->equals('category.uid',$category));
		}
		return $query->setOrderings($orderings)->execute();
	}	

	/**
	* findNewFlagged
	*
	* @return
	*/
	public function findNewFlagged() {
		$orderings = array ('registerId' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		$query = $this->createQuery();
		return $query->matching($query->equals('newflag',1))->setOrderings($orderings)->execute();
	}

	/**
	* findMissing
	*
	* @return
	*/
	public function findMissing() {
		$orderings = array ('registerId' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		$query = $this->createQuery();
		return $query->matching($query->equals('missing',1))->setOrderings($orderings)->execute();
	}

	/**
	* findTemporary
	*
	* @return
	*/
	public function findTemporary() {
		$orderings = array ('registerId' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		$query = $this->createQuery();
		return $query->matching($query->equals('temporary',1))->setOrderings($orderings)->execute();
	}

	/**
	* findLastOfCategory
	*
	* @param \FKU\FkuLibrary\Domain\Model\Category $category
	* @return
	*/
	public function findLastOfCategory($category) {
		$orderings = array ('registerId' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
		$query = $this->createQuery();
		return $query->matching($query->equals('category',$category))->setOrderings($orderings)->execute()->getFirst();
	}

	/**
	* findLastAdded
	*
	* @param \int $limit Maximum of media to be returned (e.g. for list of new books on home page)
	* @return
	*/
	public function findLastAdded($limit = 5) {
		// find last added media
		date_default_timezone_set('UTC');  // to be set because CreationDate is set already in correct timezone
		$query = $this->createFilteredQuery('', 0, 0, false, 4);
		$result = $query->execute()->getFirst();
		if ($result) {
			// find all media added at date of last added media
			$date = $result->getRegisterDate();
			$query2 = $this->createFilteredQuery('', 0, 0, $date, 1);
			$result2 = $query2->execute();
			if (sizeof($result2) > $limit) {
				// pick random items from the found list of media
				$max = sizeof($result2);
				$keys = array();
				do {
					do {
						srand ((double)microtime() * 1000000);
						$number = floor(rand(0,$max));
					} while (in_array($number, $keys) or $number >= $max);
					$keys[] = $number;
				} while (sizeof($keys) < $limit);
				$finalResult = array();
				for ($i=0;$i<$limit;$i++) {
					$finalResult[] = $result2[$keys[$i]];
				}
			} else {
				$finalResult = $result2;
			}
			return $finalResult;
		} else {
			return false;
		}
	}	

	/**
	* findFiltered
	*
	* @param \string $searchword
	* @param \int $field
	* @param \int $category
	* @param \bool $limit_recommended Only finds media that are flagged as "recommended"
	* @param \datetime $limit_new Only finds media that are newer than this date (datetime object)
	* @param \bool $incl_missing Includes media that are flagged as "missing"
	* @param \bool $incl_temporary Includes media that are flagged as "temporary"
	* @param \string $sorting
	* @param \int $limit
	* @param \int $offset
	* @return
	*/
	public function findFiltered($searchword = NULL, $field = 0, $category = 0, $limit_recommended = 0, $limit_new = NULL, $incl_missing = 0, $incl_temporary = 0, $sorting = 'title', $limit = 20, $offset = 0) {
		$query = $this->createFilteredQuery($searchword, $field, $category, $limit_recommended, $limit_new, $incl_missing, $incl_temporary);
		if ($sorting == 'title') {
			$orderings = array ('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		} else {
			$orderings = array ($sorting => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING, 'title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
		}
		$query->setLimit($limit)->setOffset($offset)->setOrderings($orderings);
		return $query->execute();
	}	

	/**
	* countFiltered
	*
	* @param \string $searchword
	* @param \int $field
	* @param \int $category
	* @param \bool $limit_recommended Only finds media that are flagged as "recommended"
	* @param \datetime $limit_new Only finds media that are newer than this date (datetime object)
	* @param \bool $incl_missing Includes media that are flagged as "missing"
	* @param \bool $incl_temporary Includes media that are flagged as "temporary"
	* @return
	*/
	public function countFiltered($searchword = NULL, $field = 0, $category = 0, $limit_recommended = 0, $limit_new = NULL, $incl_missing = 0, $incl_temporary = 0) {
		$query = $this->createFilteredQuery($searchword, $field, $category, $limit_recommended, $limit_new, $incl_missing, $incl_temporary);
		return $query->count();
	}	

	/**
	* createFilteredQuery
	*
	* @param \string $searchword
	* @param \int $field
	* @param \int $category
	* @param \bool $limit_recommended Only finds media that are flagged as "recommended"
	* @param \datetime $limit_new Only finds media that are newer than this date (datetime object)
	* @param \bool $incl_missing Includes media that are flagged as "missing"
	* @param \bool $incl_temporary Includes media that are flagged as "temporary"
	* @return $query
	*/
	private function createFilteredQuery($searchword = NULL, $field = 0, $category = 0, $limit_recommended = 0, $limit_new = NULL, $incl_missing = 0, $incl_temporary = 0) {
		
		$query = $this->createQuery();
		
		$contraints = [];
		
		if ($incl_missing == 0) {
			$contraints[] = $query->equals('missing',0);
		}

		if ($incl_temporary == 0) {
			$contraints[] = $query->equals('temporary',0);
		}
		
		if ($searchword != '') {
			switch ($field) {
				case 1:
					$contraints[] = $query->like('title','%'.$searchword.'%');
					break;
				case 2:
					$contraints[] = $query->like('author','%'.$searchword.'%');
					break;
				case 3:
					$contraints[] = $query->like('publisher','%'.$searchword.'%');
					break;
				case 4:
					$contraints[] = $query->like('keywords','%'.$searchword.'%');
					break;
				default:
					$contraints[] = $query->logicalOr(
						$query->like('title','%'.$searchword.'%'),
						$query->like('author','%'.$searchword.'%'),
						$query->like('publisher','%'.$searchword.'%'),
						$query->like('keywords','%'.$searchword.'%')
					);
					break;
			}
		}

		if ($category > 0) {
			$contraints[] = $query->equals('category.uid',$category);
		}

		if ($limit_recommended > 0) {
			$contraints[] = $query->equals('recommended',1);
		}

		if (is_object($limit_new)) {
			$contraints[] = $query->greaterThanOrEqual('registerDate',$limit_new->format('Y-m-d 00:00:00'));
		}
		
		$query->matching($query->logicalAnd($contraints));
		return $query;
	}	

	/**
	* removeNewFlag
	*
	* @return
	*/
	public function removeNewFlag() {
		// UPDATE tx_fkulibrary_domain_model_media SET newflag = 0 WHERE newflag = 1
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_fkulibrary_domain_model_media');
		$queryBuilder
			->update('tx_fkulibrary_domain_model_media')
			->where($queryBuilder->expr()->eq('newflag', 1))
			->set('newflag', 0);
		return $queryBuilder->execute();
	}	

}