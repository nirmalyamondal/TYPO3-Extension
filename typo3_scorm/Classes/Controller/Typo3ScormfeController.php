<?php
namespace TYPO3\Typo3Scorm\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Nirmalya Mondal - Contact: typo3india@gmail.com
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
 * Typo3ScormfeController
 * 
 * @package TYPO3
 * @subpackage 
 * @author Nirmalya Mondal <typo3india@gmail.com>
 * @copyright (c) 2016, Nirmalya Mondal
 */
class Typo3ScormfeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Typo3ScormfeRepository
	 *
	 * @var \TYPO3\Typo3Scorm\Domain\Repository\Typo3ScormfeRepository
	 * @inject
	 */
	protected $Typo3ScormfeRepository = NULL;
	
	/**
	 * typo3ScormUserRepository
	 *
	 * @var \TYPO3\Typo3Scorm\Domain\Repository\Typo3ScormUserRepository
	 * @inject
	 */
	protected $typo3ScormUserRepository = NULL;

	/**
	 * action initialize
	 * 
	 * @see TYPO3\CMS\Extbase\Mvc\Controller.ActionController::initializeAction()
	 */
	public function initializeAction(){		
		$this->config = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

	}

	/**
	 * action play
	 *
	 * @return void
	 */
	public function playAction() {
		$feuserId		= $GLOBALS['TSFE']->fe_user->user['uid'];
		if(!$feuserId){ return FALSE; }	//print_r($this->settings);
		if(!$this->settings['show_launch'] && !$this->settings['show_history']) { return FALSE; }
		$scorm_courseid			= $this->settings['current_scormtopic_id'];
		if(!$scorm_courseid){ return FALSE; }
		//if($this->settings['show_history'])	{	return $this->resultAction();	}
		$confArr		= unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['typo3_scorm']);
		$wwwroot		= $GLOBALS['TSFE']->tmpl->setup['config.']['baseURL']?$GLOBALS['TSFE']->tmpl->setup['config.']['baseURL']:$confArr['wwwroot'];
		$ServiceUrl		= $confArr['scormcloudurl'];
		$AppId			= $confArr['scormcloudappid'];
		$SecretKey		= $confArr['scormcloudsecretkey'];
		$Origin			= $confArr['scormcloudorigin'];
		$FeGroupId		= $confArr['fegroupid'];
		//if(!$ServiceUrl || !$AppId || !$SecretKey || !$Origin || !$FeGroupId) { return FALSE; }
		if(!$ServiceUrl || !$AppId || !$SecretKey || !$Origin) { return FALSE; }
		$usergroup		= $GLOBALS['TSFE']->fe_user->user['usergroup'];
		$usergroupArray	= @explode(",",$usergroup);
		//if(!in_array($FeGroupId, $usergroupArray)) { return FALSE;	}
		$ScormService	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ScormEngineService',$ServiceUrl,$AppId,$SecretKey,$Origin);
		$regService		= $ScormService->getRegistrationService();
		$regId			= $this->getScormUserDetails($feuserId,$scorm_courseid);	//print_r($regId);
		if(!$regId)	{ return FALSE; }

		$launchtLink	= '';
		if($this->settings['show_launch'])	{
			$currentPid		= $GLOBALS['TSFE']->id;
			$launchUrl		= $regService->GetLaunchUrl($regId,$wwwroot.'index.php?id='.$currentPid);
			$launchtext		= $this->settings['launchtext']?$this->settings['launchtext']:'Launch Test:&nbsp;'.$scorm_coursename;
			$launchtLink	= '<a href="'.$launchUrl.'" target="_new" class="scormLaunchTextClass">'.$launchtext.'</a>';
		} //show_launch

		if($this->settings['show_history'])	{
			$allResults		= $regService->GetLaunchHistory($regId);
			$no_history_result	= 1;
			if(!is_array($allResults)){	$no_history_result	= 0;}
			if(is_array($allResults)) {
				$allResultsData	= array();
				$counter		= 1;
				foreach($allResults as $result)	{
					$allResultsData[$counter]['completion']	= $result->getCompletion();
					$allResultsData[$counter]['satisfaction']	= $result->getSatisfaction();
					$allResultsData[$counter]['measureStatus']	= $result->getMeasureStatus();
					$allResultsData[$counter]['launchTime']	= $result->getLaunchTime();
					$counter++;
				}
			}
		} //show_history
		$this->view->assign('launchtLink', $launchtLink);
		$this->view->assign('no_history_result', $no_history_result);
		$this->view->assign('allResults', $allResultsData);		
	}
	
	/**
	 * action result
	 *
	 * @return void
	 */
	public function resultAction() {
	}

	
	/**
     * Fetch getScormUserDetails
     * 
     * @param string $scorm_cloud
	 * @param int $t3user_id
     * @return void
     */
	function getScormUserDetails($t3user_id,$scorm_cloud){
		$where		= "t3user_id=".$t3user_id." AND scorm_cloud='".$scorm_cloud."' AND deleted=0 AND hidden=0";
		$res		= $GLOBALS['TYPO3_DB']->exec_SELECTquery('reg_id', 'tx_typo3scorm_domain_model_scormuser', $where , '', '', 1);
		if (!$res) { return FALSE;	}
		$num_rows	= $GLOBALS['TYPO3_DB']->sql_num_rows($res);
		if($num_rows < 1){	return FALSE;	}
		$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
	return $row['reg_id'];
	}

}