<?php
namespace TYPO3\Typo3Scorm\Tests\Unit\Controller;
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
 * Test case for class TYPO3\Typo3Scorm\Controller\Typo3ScormbeController.
 *
 * @author Nirmalya Mondal <typo3india@gmail.com>
 */
class Typo3ScormbeControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\Typo3Scorm\Controller\Typo3ScormbeController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('TYPO3\\Typo3Scorm\\Controller\\Typo3ScormbeController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllTypo3ScormbesFromRepositoryAndAssignsThemToView() {

		$allTypo3Scormbes = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$Typo3ScormbeRepository = $this->getMock('TYPO3\\Typo3Scorm\\Domain\\Repository\\Typo3ScormbeRepository', array('findAll'), array(), '', FALSE);
		$Typo3ScormbeRepository->expects($this->once())->method('findAll')->will($this->returnValue($allTypo3Scormbes));
		$this->inject($this->subject, 'Typo3ScormbeRepository', $Typo3ScormbeRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('Typo3Scormbes', $allTypo3Scormbes);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenTypo3ScormbeToView() {
		$Typo3Scormbe = new \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('Typo3Scormbe', $Typo3Scormbe);

		$this->subject->showAction($Typo3Scormbe);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenTypo3ScormbeToView() {
		$Typo3Scormbe = new \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newTypo3Scormbe', $Typo3Scormbe);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($Typo3Scormbe);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenTypo3ScormbeToTypo3ScormbeRepository() {
		$Typo3Scormbe = new \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe();

		$Typo3ScormbeRepository = $this->getMock('TYPO3\\Typo3Scorm\\Domain\\Repository\\Typo3ScormbeRepository', array('add'), array(), '', FALSE);
		$Typo3ScormbeRepository->expects($this->once())->method('add')->with($Typo3Scormbe);
		$this->inject($this->subject, 'Typo3ScormbeRepository', $Typo3ScormbeRepository);

		$this->subject->createAction($Typo3Scormbe);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenTypo3ScormbeToView() {
		$Typo3Scormbe = new \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('Typo3Scormbe', $Typo3Scormbe);

		$this->subject->editAction($Typo3Scormbe);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenTypo3ScormbeInTypo3ScormbeRepository() {
		$Typo3Scormbe = new \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe();

		$Typo3ScormbeRepository = $this->getMock('TYPO3\\Typo3Scorm\\Domain\\Repository\\Typo3ScormbeRepository', array('update'), array(), '', FALSE);
		$Typo3ScormbeRepository->expects($this->once())->method('update')->with($Typo3Scormbe);
		$this->inject($this->subject, 'Typo3ScormbeRepository', $Typo3ScormbeRepository);

		$this->subject->updateAction($Typo3Scormbe);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenTypo3ScormbeFromTypo3ScormbeRepository() {
		$Typo3Scormbe = new \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe();

		$Typo3ScormbeRepository = $this->getMock('TYPO3\\Typo3Scorm\\Domain\\Repository\\Typo3ScormbeRepository', array('remove'), array(), '', FALSE);
		$Typo3ScormbeRepository->expects($this->once())->method('remove')->with($Typo3Scormbe);
		$this->inject($this->subject, 'Typo3ScormbeRepository', $Typo3ScormbeRepository);

		$this->subject->deleteAction($Typo3Scormbe);
	}
}
