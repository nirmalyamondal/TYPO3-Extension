<?php
namespace TYPO3\Typo3Ajax\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Nirmalya Mondal <typo3india@gmail.com>
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
 * Typo3AjaxController
 */
class Typo3AjaxController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Typo3AjaxRepository
	 * 
	 * @var \TYPO3\Typo3Ajax\Domain\Repository\Typo3AjaxRepository
	 * @inject
	 */
	protected $Typo3AjaxRepository = NULL;

	/**
	 * action initialize
	 * 
	 * @see TYPO3\CMS\Extbase\Mvc\Controller.ActionController::initializeAction()
	*/
	public function initializeAction(){	
		parent::initializeAction();
		$this->config = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $this->cacheService->clearPageCache(array($GLOBALS["TSFE"]->id)); // clear cache
        //$GLOBALS['TSFE']->additionalHeaderData['extCss1'] = '<link rel="stylesheet" type="text/css" href="typo3conf/ext/typo3_ajax/Resources/Public/Css/Typo3Ajax.css">';
		$GLOBALS['TSFE']->additionalHeaderData['extJs1'] = '<script src="typo3conf/ext/typo3_ajax/Resources/Public/Js/jquery-1.7.2.min.js" type="text/javascript"></script>';
        $GLOBALS['TSFE']->additionalHeaderData['extJs2'] = '<script src="typo3conf/ext/typo3_ajax/Resources/Public/Js/Typo3Ajax.js" type="text/javascript"></script>';
		$ajaxRequest = \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('typo3_ajax');
		if($ajaxRequest == 'showtext'){	echo $this->showtextAction(); die(); }
	}


	/**
	 * action list
	 * 
	 * 
	 * @return void
	 */
	public function viewAction() {
		//
		$content	= '';
		$this->view->assign('content', $content);
	}

	 /**
     * action showtext
     * 
     * @param
     * @return string $response
     */
    public function showtextAction() {
        $arg1		= \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('a1');
		$arg2		= \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('a2');
		$returnStr = '';
		$returnStr = '"'.$arg1.' '.$arg2.'" '.'from Server as a Response!';
	return $returnStr;
	}


}