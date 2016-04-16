<?php

namespace TYPO3\BackendAjax\Controller;

/***************************************************************
*  Copyright notice
*
*  (c) Nirmalya Mondal (https://typo3nirmalya.blogspot.in/)
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

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

/**
 * Controller: Data
 *
 * @package TYPO3\BackendAjax\Controller
 */
class DataController extends ActionController 
{

    /**
     * persistence manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * config
     *
     * @var array
     */
    protected $config;

    /**
     * Data repository
     *
     * @var \TYPO3\BackendAjax\Domain\Repository\dataRepository
     * @
     */
    protected $dataRepository;

    /**
     *  Intantiate the Repository and is called before any Action is executed
     *
     * @see TYPO3\CMS\Extbase\Mvc\Controller.ActionController::initializeAction()
     */
    public function initializeAction() {
        $this->config = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $this->dataRepository = $objectManager->get(\TYPO3\BackendAjax\Domain\Repository\DataRepository::class);		
    }

    /**
     * list function to feed user JSON data 
     *
     * @return void
     */
    public function listAction() {
        $allData = $this->dataRepository->findAll();	
        $allDbColArr = array_keys($this->config['persistence']['classes']['TYPO3\BackendAjax\Domain\Model\Data']['mapping']['columns']);
        $jsonData = $allDataCol = $allDataRow = '';
        foreach($allData as $oneData) {
            $oneDataArray = [];
            $oneDataArray[] = $oneData->getFirstname();
            $oneDataArray[] = $oneData->getLastname();
            $oneDataArray[] = $oneData->getUsername();
            $jsonData = $jsonData ? $jsonData . ',' . json_encode($oneDataArray) : json_encode($oneDataArray);
            $allDataRow = $allDataRow ? $allDataRow . '","' . $oneData->getUid() : '"' . $oneData->getUid();
        }
        $allDataRow = $allDataRow ? $allDataRow . '"' : '';
        $allDataCol = '"' . implode('","', $allDbColArr) . '"';
        $this->view->assign('allData', $jsonData);
        $this->view->assign('allDataCol', $allDataCol);
        $this->view->assign('allDataRow', $allDataRow);
        $moduleName = (string) GeneralUtility::_GET('M');
        $moduleToken = FormProtectionFactory::get()->generateToken('moduleCall', $moduleName);
        $this->view->assign('moduleTokenValue', $moduleToken);
        $this->pageRenderer = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $this->pageRenderer->addCssFile($this->settings['cssFile']);
      }

    /**
     * Receiving the AJAX request and updating the database
     *
     * @return void
     */
    public function ajaxexampleAction() {
        $rowGP = GeneralUtility::_GP('row');
        $colGP = GeneralUtility::_GP('col');
        $newValueGP = GeneralUtility::_GP('newValue');
        $newValueGP = GeneralUtility::removeXSS($newValueGP);
        $currentObject = $this->dataRepository->findByUid($rowGP);
        if (!is_object($currentObject)) {
            echo FALSE;
            die();
        }
        $setPropertyFunction = 'set' . ucwords(str_replace('_', '', $colGP)); 
        $currentObject->$setPropertyFunction($newValueGP);
        $this->dataRepository->update($currentObject);
        $this->view = NULL;
        echo TRUE;
    }


}
