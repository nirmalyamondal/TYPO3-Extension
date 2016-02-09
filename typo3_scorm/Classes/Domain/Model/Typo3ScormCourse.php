<?php
namespace TYPO3\Typo3Scorm\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Nirmalya Mondal <typo3india@gmail.com>, Nirmalya Mondal
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
 * Typo3ScormCourse
 * 
 * @package TYPO3
 * @subpackage TYPO3
 * @author Nirmalya Mondal <typo3india@gmail.com>
 * @copyright (c) 2016, Nirmalya Mondal
 */
class Typo3ScormCourse extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * cloudId
	 *
	 * @var string
	 */
	protected $cloudId = '';

	/**
	 * courseName
	 *
	 * @var string
	 */
	protected $courseName = '';

	/**
	 * creationTime
	 *
	 * @var int
	 */
	protected $creationTime = '';

	/**
	 * updateTime
	 *
	 * @var int
	 */
	protected $updateTime = '';

	/**
	 * scoreFormat
	 *
	 * @var string
	 */
	protected $scoreFormat = '';

	/**
	 * allowPreview
	 *
	 * @var int
	 */
	protected $allowPreview = '';

	/**
	 * allowReview
	 *
	 * @var int
	 */
	protected $allowReview = '';

	/**
	 * Returns the cloudId
	 *
	 * @return string $cloudId
	 */
	public function getCloudId() {
		return $this->cloudId;
	}

	/**
	 * Sets the cloudId
	 *
	 * @param string $cloudId
	 * @return void
	 */
	public function setCloudId($cloudId) {
		$this->cloudId = $cloudId;
	}

	/**
	 * Returns the courseName
	 *
	 * @return string $courseName
	 */
	public function getCourseName() {
		return $this->courseName;
	}

	/**
	 * Sets the courseName
	 *
	 * @param string $courseName
	 * @return void
	 */
	public function setCourseName($courseName) {
		$this->courseName = $courseName;
	}

	/**
	 * Returns the creationTime
	 *
	 * @return int $creationTime
	 */
	public function getCreationTime() {
		return $this->creationTime;
	}

	/**
	 * Sets the creationTime
	 *
	 * @param int $creationTime
	 * @return void
	 */
	public function setCreationTime($creationTime) {
		$this->creationTime = $creationTime;
	}

	/**
	 * Returns the updateTime
	 *
	 * @return int $updateTime
	 */
	public function getUpdateTime() {
		return $this->updateTime;
	}

	/**
	 * Sets the updateTime
	 *
	 * @param int $updateTime
	 * @return void
	 */
	public function setUpdateTime($updateTime) {
		$this->updateTime = $updateTime;
	}

	/**
	 * Returns the scoreFormat
	 *
	 * @return string $scoreFormat
	 */
	public function getScoreFormat() {
		return $this->scoreFormat;
	}

	/**
	 * Sets the scoreFormat
	 *
	 * @param string $scoreFormat
	 * @return void
	 */
	public function setScoreFormat($scoreFormat) {
		$this->scoreFormat = $scoreFormat;
	}

	/**
	 * Returns the allowPreview
	 *
	 * @return int $allowPreview
	 */
	public function getAllowPreview() {
		return $this->allowPreview;
	}

	/**
	 * Sets the allowPreview
	 *
	 * @param int $allowPreview
	 * @return void
	 */
	public function setAllowPreview($allowPreview) {
		$this->allowPreview = $allowPreview;
	}

	/**
	 * Returns the allowReview
	 *
	 * @return int $allowReview
	 */
	public function getAllowReview() {
		return $this->allowReview;
	}

	/**
	 * Sets the allowReview
	 *
	 * @param int $allowReview
	 * @return void
	 */
	public function setAllowReview($allowReview) {
		$this->allowReview = $allowReview;
	}

}