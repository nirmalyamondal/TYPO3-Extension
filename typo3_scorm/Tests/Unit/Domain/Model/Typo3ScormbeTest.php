<?php

namespace TYPO3\Typo3Scorm\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Nirmalya Mondal <typo3india@gmail.com>, LEARNTUBE! GbR
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
 * Test case for class \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Nirmalya Mondal <typo3india@gmail.com>
 */
class Typo3ScormbeTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getTemplateTitleReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getTemplateTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTemplateTitleForStringSetsTemplateTitle() {
		$this->subject->setTemplateTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'templateTitle',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCourseReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getCourse()
		);
	}

	/**
	 * @test
	 */
	public function setCourseForIntegerSetsCourse() {
		$this->subject->setCourse(12);

		$this->assertAttributeEquals(
			12,
			'course',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDaysFromEnrollmentReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getDaysFromEnrollment()
		);
	}

	/**
	 * @test
	 */
	public function setDaysFromEnrollmentForIntegerSetsDaysFromEnrollment() {
		$this->subject->setDaysFromEnrollment(12);

		$this->assertAttributeEquals(
			12,
			'daysFromEnrollment',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailFromAddressReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEmailFromAddress()
		);
	}

	/**
	 * @test
	 */
	public function setEmailFromAddressForStringSetsEmailFromAddress() {
		$this->subject->setEmailFromAddress('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'emailFromAddress',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailFromNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEmailFromName()
		);
	}

	/**
	 * @test
	 */
	public function setEmailFromNameForStringSetsEmailFromName() {
		$this->subject->setEmailFromName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'emailFromName',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailSubjectReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEmailSubject()
		);
	}

	/**
	 * @test
	 */
	public function setEmailSubjectForStringSetsEmailSubject() {
		$this->subject->setEmailSubject('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'emailSubject',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailTextReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEmailText()
		);
	}

	/**
	 * @test
	 */
	public function setEmailTextForStringSetsEmailText() {
		$this->subject->setEmailText('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'emailText',
			$this->subject
		);
	}
}
