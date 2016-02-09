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
 * Typo3ScormbeController
 * 
 * @package TYPO3
 * @subpackage 
 * @author Nirmalya Mondal <typo3india@gmail.com>
 * @copyright (c) 2016, Nirmalya Mondal
 */
class Typo3ScormbeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Typo3ScormbeRepository
	 *
	 * @var \TYPO3\Typo3Scorm\Domain\Repository\Typo3ScormbeRepository
	 * @inject
	 */
	protected $Typo3ScormbeRepository = NULL;
	
	/**
	 * typo3ScormCourseRepository
	 *
	 * @var \TYPO3\Typo3Scorm\Domain\Repository\Typo3ScormCourseRepository
	 * @inject
	 */
	protected $typo3ScormCourseRepository = NULL;

	/**
	 * typo3ScormUserRepository
	 *
	 * @var \TYPO3\Typo3Scorm\Domain\Repository\Typo3ScormUserRepository
	 * @inject
	 */
	protected $typo3ScormUserRepository = NULL;

	/**
	 * typo3ScormFeUserRepository
	 *
	 * @var \TYPO3\Typo3Scorm\Domain\Repository\Typo3ScormFeUserRepository
	 * @inject
	 */
	protected $typo3ScormFeUserRepository = NULL;


	/**
	 * action initialize
	 * 
	 * @see TYPO3\CMS\Extbase\Mvc\Controller.ActionController::initializeAction()
	 */
	public function initializeAction(){
		parent::initializeAction();
		$this->config	= $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);	
		$objectManager	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\\Object\ObjectManager');
		$this->typo3ScormCourseRepository = $objectManager->get('TYPO3\Typo3Scorm\Domain\Repository\Typo3ScormCourseRepository');
	}

	/**
	 * action courselist
	 *
	 * @return void
	 */
	public function courselistAction() {
		$moduleName		= (string)\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('M');
		$moduleToken	= \TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()->generateToken('moduleCall', $moduleName);
		$confArr		= unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['typo3_scorm']);
		$wwwroot		= $GLOBALS['TSFE']->baseURL?$GLOBALS['TSFE']->baseURL:$confArr['wwwroot'];
		$ServiceUrl		= $confArr['scormcloudurl'];
		$AppId			= $confArr['scormcloudappid'];
		$SecretKey		= $confArr['scormcloudsecretkey'];
		$Origin			= $confArr['scormcloudorigin'];
		$ScormService	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ScormEngineService',$ServiceUrl,$AppId,$SecretKey,$Origin);
		$courseService	= $ScormService->getCourseService();

		$postParams		= \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_typo3scorm_web_typo3scormmod1');
		$courseidGP		= $postParams['courseid'];
		$performTask	= $postParams['perform'];
		if(isset($courseidGP) && isset($performTask) && ($courseidGP != '') && ($performTask == 'deletecourse')){
			$courseService->DeleteCourse($courseidGP, 'false');
			$this->_delete_course_T3E($courseidGP);
			$this->_delete_course_users_T3E($courseidGP);
		}
		

		$allResults		= $courseService->GetCourseList();
		if(isset($performTask) && ($performTask == 'synct3scormcourses')) {
			foreach($allResults as $courseCheck){
				$localCourseModelCheck	= $this->typo3ScormCourseRepository->findByCloudId($courseCheck->getCourseId());
				if(!is_object($localCourseModelCheck)){	$this->_insert_scorm_t3e_courses($courseCheck->getCourseId(),$courseCheck->getTitle());	} 
			}
		}
		$reportService	= $ScormService->getReportingService();
		$repAuth		= $reportService->GetReportageAuth("freenav",true);
		$reportageUrl	= $reportService->GetReportageServiceUrl()."Reportage/reportage.php?appId=".$AppId."&courseId=".$courseidGP;
		$reportUrl		= $reportService->GetReportUrl($repAuth,$reportageUrl);

		$courseListRe	.= '<h3 style="margin-top:15px;"><a href="'.$reportUrl.'">Go to Report Page for your App Id.</a></h3>';
		$courseListRe	.= '<table border="1" cellpadding="2" cellspacing="2" width="99%" style="margin-top:15px;">
							<tr><th align="left">SCORM Cloud Title / Typo3 Course Title </th><th align="left">Typo3 Course Id</th><th align="left">SCORM Cloud Course Id</th><th align="left">Registrations</th><th align="left">Preview</th><th align="left">Properties</th><th>Delete</th></tr>';
		foreach($allResults as $course)	{
			$scormCloudId		= $course->getCourseId();
			$localCourseModel	= $this->typo3ScormCourseRepository->findByCloudId($scormCloudId); //print_r($localCourseModel);print_r($course);
			if(is_object($localCourseModel)){
				$localCourseName	= '<br> / '.$localCourseModel->getCourseName();
				$localCourseId		= $localCourseModel->getUid();
			}else{
				$localCourseName	= '';
				$localCourseId		= '';
			}	
			$registUrl		= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=userlisting&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&tx_typo3scorm_web_typo3scormmod1[courseid]=".$scormCloudId."&moduleToken=".$moduleToken;
			$prevReturnUrl	= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=courselist&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&moduleToken=".$moduleToken;
			$prevUrl		= $courseService->GetPreviewUrl($scormCloudId,$prevReturnUrl,"https://cloud.scorm.com/sc/css/cloudPlayer/cloudstyles.css");
			$propertyUrl	= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=courselist&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&tx_typo3scorm_web_typo3scormmod1[perform]=editproperty&tx_typo3scorm_web_typo3scormmod1[courseid]=".$scormCloudId."&moduleToken=".$moduleToken;
			$deleteUrl		= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=courselist&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&tx_typo3scorm_web_typo3scormmod1[perform]=deletecourse&tx_typo3scorm_web_typo3scormmod1[courseid]=".$scormCloudId."&moduleToken=".$moduleToken;
			$regService			= $ScormService->getRegistrationService();
			$allRegResults		= $regService->GetRegistrationList($scormCloudId,null);		
			$totalRegistrant	= 0;
			foreach($allRegResults as $regResult)	{
				$totalRegistrant += 1;
			}
			$totalRegistr	= $totalRegistrant; //$course->getNumberOfRegistrations();
			$courseListRe	.= '<tr><td>'.$course->getTitle().$localCourseName.'</td>';
			$courseListRe	.= '<td>'.$localCourseId.'</td>';	
			$courseListRe	.= '<td>'.$course->getCourseId().'</td>';
			if($totalRegistr > 0){	$courseListRe	.= '<td><a href="'.$registUrl.'">'.$totalRegistr.'</a></td>';	}else{	$courseListRe	.= '<td>'.$totalRegistr.'</td>';	}			
			$courseListRe	.= '';
			$courseListRe	.= '<td><a href="'.$prevUrl.'">Preview</a></td>';			
			$courseListRe	.= '<td><a href="'.$propertyUrl.'">Edit Properties</a></td>';
			$courseListRe	.= '<td><a href="'.$deleteUrl.'" onclick="return confirm(\'Are you sure to delete Course '.$course->getTitle().' ?\')" >Delete</a></td></tr>';
		}
		$courseListRe	.= '</table>';
		
		$syncCourseUrl	= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=courselist&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&tx_typo3scorm_web_typo3scormmod1[perform]=synct3scormcourses&moduleToken=".$moduleToken;
		$courseListRe	.= '<h4><a href="'.$syncCourseUrl.'">Sync Typo3 Records with SCORM Cloud.</a></h4>';
		$t3eThisUrl		= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=courselist&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&tx_typo3scorm_web_typo3scormmod1[perform]=synct3scormcourses&moduleToken=".$moduleToken;;
		if(($courseidGP != '') && ($performTask == 'editproperty')){
			$propsEditorUrl = $courseService->GetPropertyEditorUrl($courseidGP,Null,Null);
			$att			= $_GET['att'];
			$attval			= $_GET['attval'];
			if(isset($att) && isset($attval) && $attval != '')	{				
				$paramAtts = array($att => $attval);
				//If you have more attributes to send, just add more to the $paramAtts array.
				$changedAtts = $courseService->UpdateAttributes($courseId,Null,$paramAtts);				
				$courseListRe	.= "<h4>Changed Attributes</h4>";
				foreach ($changedAtts as $key => $value){
					$courseListRe	.= "Attribute <b>".$key."</b> was changed to <b>" .$value."</b>.";	
				}
			}//att && attval
			$attributes		= $courseService->GetAttributes($courseidGP);
			$courseListRe	.= $this->_show_course_property_editor($courseidGP,$attributes,$propsEditorUrl,$t3eThisUrl);
		}//echo 'i m here'; exit();
        $this->view->assign('courseListRe', $courseListRe);

    //Unset Session
    $GLOBALS['BE_USER']->setAndSaveSessionData('postParams', '');
	}
	
	/**
	 * action courseupload
	 * 
	 * @return void
	 */
	public function courseuploadAction() {
		$moduleName		= (string)\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('M');
		$moduleToken	= \TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()->generateToken('moduleCall', $moduleName);
		$confArr		= unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['typo3_scorm']);	//print_r($confArr);		
		$wwwroot		= $GLOBALS['TSFE']->baseURL?$GLOBALS['TSFE']->baseURL:$confArr['wwwroot']; //$GLOBALS['TSFE']->tmpl->setup['config.']['baseURL'];
		$ServiceUrl		= $confArr['scormcloudurl'];
		$AppId			= $confArr['scormcloudappid'];
		$SecretKey		= $confArr['scormcloudsecretkey'];
		$Origin			= $confArr['scormcloudorigin'];
		$ScormService	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ScormEngineService',$ServiceUrl,$AppId,$SecretKey,$Origin);
		$courseService	= $ScormService->getCourseService();
		$courseListUrl	= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=courselist&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&moduleToken=".$moduleToken;
		$courseId		= uniqid();
		$cloudUploadLink= $courseService->GetImportCourseUrl($courseId,$courseListUrl);

	$this->view->assign("uploadFormRe", $cloudUploadLink);	
	}

	/**
	 * action userlisting
	 *
	 * @param \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $userlistingTypo3Scormbe
	 * @ignorevalidation $userlistingTypo3Scormbe
	 * @return void
	 */
	public function userlistingAction() {
		$moduleName		= (string)\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('M');
		$moduleToken	= \TYPO3\CMS\Core\FormProtection\FormProtectionFactory::get()->generateToken('moduleCall', $moduleName);
		$confArr		= unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['typo3_scorm']);	//print_r($confArr);		
		$wwwroot		= $GLOBALS['TSFE']->baseURL?$GLOBALS['TSFE']->baseURL:$confArr['wwwroot']; //$GLOBALS['TSFE']->tmpl->setup['config.']['baseURL'];
		$ServiceUrl		= $confArr['scormcloudurl'];
		$AppId			= $confArr['scormcloudappid'];
		$SecretKey		= $confArr['scormcloudsecretkey'];
		$Origin			= $confArr['scormcloudorigin'];
		$ScormService	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ScormEngineService',$ServiceUrl,$AppId,$SecretKey,$Origin);
		$courseService	= $ScormService->getCourseService();
		$regService		= $ScormService->getRegistrationService();
		$postParams		= \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_typo3scorm_web_typo3scormmod1');
		$courseidGP		= $postParams['courseid'];
		$regidGP		= $postParams['regid'];
		$performTask	= $postParams['perform'];
		if(isset($regidGP) && isset($performTask) && ($regidGP != '') && ($performTask == 'deleteuser')){
			$regService->DeleteRegistration($regidGP,null);
			$this->_delete_user_T3E($regidGP);
		}

		if(isset($regidGP) && isset($performTask) && ($regidGP != '') && ($performTask == 'lhistory')){
			//show Registration Summary
			$regSummary = $regService->GetRegistrationSummary($regidGP);
			$userHistoryAll	= '';
			$userHistoryAll	.= '<b>Completion:&nbsp;&nbsp;</b>'.$regSummary->getComplete();
			$userHistoryAll	.= '<br>';
			$userHistoryAll	.= '<b>Success:&nbsp;&nbsp;</b>'.$regSummary->getSuccess();
			$userHistoryAll	.= '<br>';
			$userHistoryAll	.= '<b>Total Time:&nbsp;&nbsp;</b>'.$regSummary->getTotalTime();
			$userHistoryAll	.= '<br>';
			$userHistoryAll	.= '<b>Score:&nbsp;&nbsp;</b>'.$regSummary->getScore();
			$userHistoryAll	.= '<br><br>';
			//show Launch History
			$allResults = $regService->GetLaunchHistory($regidGP);
			$userHistoryAll	.= '<table border="1" cellpadding="2" cellspacing="2" width="99%">';
			$userHistoryAll	.= '<tr><th>Completion</th><th>Satisfaction</th><th>Measure Status</th><th>Launch Time</th></tr>';
			foreach($allResults as $result){
				$userHistoryAll	.= '<tr>';
				$userHistoryAll	.= '<td>'.$result->getCompletion().'</td>';
				$userHistoryAll	.= '<td>'.$result->getSatisfaction().'</td>';
				$userHistoryAll	.= '<td>'.$result->getMeasureStatus().'</td>';
				$userHistoryAll	.= '<td>'.$result->getLaunchTime().'</td></tr>';
			}
			$userHistoryAll	.= '</table>';
			if(isset($courseidGP) && ($courseidGP != '')){
				$courseidGP_url = 'tx_typo3scorm_web_typo3scormmod1[courseid]='.$courseidGP;
			}else{
				$courseidGP_url	= '';
			}
			$backToUrl		= $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=userlisting&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe".$courseidGP_url."&moduleToken=".$moduleToken;
			$userHistoryAll	.= '<br/><br/><h4><a href="'.$backToUrl.'">&laquo;Back To Users Listing</a></h4>';
			return $userHistoryAll;
		}
		if(isset($courseidGP) && ($courseidGP != '')){
			$allResults = $regService->GetRegistrationList($courseidGP,null);
		}else{
			$allResults = $regService->GetRegistrationList(null,null);
		}
		$userListRe		= '';
		$userListRe		.= '<table border="1" cellpadding="0" cellspacing="0" width="99%">';
		$userListRe		.= '<tr><th align="left">Typo3 Course Name</th><th align="left">Registration Id</th><th align="left">Username/<br>Learner Id</th><th align="left">Typo3 User Name/<br>Learner Name</th><th align="left">Completion</th><th align="left">Success</th><th align="left">Total Time</th><th align="left">Score</th><th align="left">History</th><th align="left">Delete</th></tr>';
		foreach($allResults as $result)	{
			$registrationId	= $result->getRegistrationId();
			$launchHisUrl = $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=userlisting&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&tx_typo3scorm_web_typo3scormmod1[perform]=lhistory&tx_typo3scorm_web_typo3scormmod1[regid]=".$registrationId."&moduleToken=".$moduleToken;
			$deleteUserUrl = $wwwroot."typo3/mod.php?M=".$moduleName."&tx_typo3scorm_web_typo3scormmod1[action]=userlisting&tx_typo3scorm_web_typo3scormmod1[controller]=Typo3Scormbe&tx_typo3scorm_web_typo3scormmod1[perform]=deleteuser&tx_typo3scorm_web_typo3scormmod1[regid]=".$registrationId."&moduleToken=".$moduleToken;
			$scormCourseId		= $result->getCourseId();
			$localCourseModel	= $this->typo3ScormCourseRepository->findByCloudId($scormCourseId); //print_r($localCourseModel);print_r($course);
			if(is_object($localCourseModel)){
				$localCourseName	= $localCourseModel->getCourseName();
			} else {
				$localCourseName	= 'n/a';
			}
			$userListRe	.= '<tr><td>'.$localCourseName.'</td>';
			$userListRe	.= '<td>'.$registrationId.'</td>';
			$regDetails = $regService->getRegistrationDetail($registrationId);
			$xmlDetails = simplexml_load_string($regDetails);
			$name		= $xmlDetails->registration->learnerFirstName.'&nbsp;'.$xmlDetails->registration->learnerLastName;
			$userListRe	.= '<td>'.$xmlDetails->registration->learnerId.'</td>';
			$userListRe	.= '<td><a href="mailto:'.$xmlDetails->registration->email.'">'.$xmlDetails->registration->learnerFirstName.'&nbsp;'.$xmlDetails->registration->learnerLastName.'</a></td>';
			$regResults = $regService->GetRegistrationResult($registrationId,0,'xml');
			$xmlResults = simplexml_load_string($regResults);
			$userListRe	.= '<td>'.$xmlResults->registrationreport->complete;
			$userListRe	.= '</td><td>';
			$userListRe	.= $xmlResults->registrationreport->success;
			$userListRe	.= '</td><td>';
			$userListRe	.= $xmlResults->registrationreport->totaltime;
			$userListRe	.= '</td><td>';
			$userListRe	.= $xmlResults->registrationreport->score;
			$userListRe	.= '</td><td>';
			$userListRe	.= '<a href="'.$launchHisUrl.'">Launch</a>';
			$userListRe	.= '</td><td>';
			$userListRe .= '<a href="'.$deleteUserUrl.'" onclick="return confirm(\'Are you sure to delete '.$name.' from '.$localCourseName.' ?\')" >Delete</a>';
			$userListRe	.= '</td></tr>';
		}
		$userListRe	.= '</table>';
		if($courseidGP != '') {
			$reportService	= $ScormService->getReportingService();
			$repAuth		= $reportService->GetReportageAuth("freenav",true);
			$reportageUrl	= $reportService->GetReportageServiceUrl()."Reportage/reportage.php?appId=".$AppId."&courseId=".$courseidGP;
			$reportUrl		= $reportService->GetReportUrl($repAuth,$reportageUrl);
			$userListRe		.= '<h3><a href="'.$reportUrl.'">Go to reportage for this course.</a></h3>';
		}
	$this->view->assign("userListRe", $userListRe);
	}

	
	/**
	 * action initializeCoursedelete
	 *
	 * @param \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe
	 * @return void
	 */
	protected function initializeCoursedeleteAction(\TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe){

	}
	
	/**
	 * action coursedelete
	 *
	 * @param \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe
	 * @return void
	 */
	public function coursedeleteAction(\TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe) {	

	}
	
	/**
	 * action initializeUserdelete
	 *
	 * @param \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe
	 * @return void
	 */
	protected function initializeUserdeleteAction(\TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe) {

	}
	
	/**
	 * action userdelete
	 *
	 * @param \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe
	 * @return void
	 */
	public function userdeleteAction(\TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe) {

	}
	
	/**
	 * action initializeUserhistory
	 *
	 * @param \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe
	 * @return void
	 */
	protected function initializeUserhistoryAction(\TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe){

	}
	
	/**
	 * action userhistory
	 *
	 * @param \TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe
	 * @return void
	 */
	public function userhistoryAction(\TYPO3\Typo3Scorm\Domain\Model\Typo3Scormbe $Typo3Scormbe) {

	}

	function _delete_course_T3E($courseidGP) {
		$table						= 'tx_typo3scorm_domain_model_scormcourse';
		//$updateArray['deleted']	= 1;
		$updateArray['hidden']		= 1;
		$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,"cloud_id='".$courseidGP."'",$updateArray);
		if(!$res) {
		  echo '<hr>Error: [File:'.__FILE__.' Func:'.__FUNCTION__.' Line:'.__LINE__.'] SQL='.$GLOBALS['TYPO3_DB']->UPDATEquery($table,"cloud_id='$courseidGP'",$updateArray);
		  return FALSE;
		}
	return TRUE;		
	}

	function _delete_course_users_T3E($courseidGP){
		$table						= 'tx_typo3scorm_domain_model_scormuser';
		//$updateArray['deleted']		= 1;
		$updateArray['hidden']		= 1;
		$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,"scorm_cloud='".$courseidGP."'",$updateArray);
		if(!$res) {
		  echo '<hr>Error: [File:'.__FILE__.' Func:'.__FUNCTION__.' Line:'.__LINE__.'] SQL='.$GLOBALS['TYPO3_DB']->UPDATEquery($table,"cloud_id='$courseidGP'",$updateArray);
		  return FALSE;
		}
	return TRUE;		
	}

	function _delete_user_T3E($regid){
		$table					= 'tx_typo3scorm_domain_model_scormuser';
		//$updateArray['deleted']	= 1;
		$updateArray['hidden']	= 1;
		$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,"reg_id='".$regid."'",$updateArray);
		if(!$res) {
		  echo '<hr>Error: [File:'.__FILE__.' Func:'.__FUNCTION__.' Line:'.__LINE__.'] SQL='.$GLOBALS['TYPO3_DB']->UPDATEquery($table,"reg_id='$regid'",$updateArray);
		  return FALSE;
		}
	return TRUE;		
	}//_delete_user_T3E


	function _insert_scorm_t3e_courses($cloud_id,$course_name){
		if(!$cloud_id){ return FALSE; }
		$confArr				= unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['typo3_scorm']);
		$table  				= 'tx_typo3scorm_domain_model_scormcourse';
		$iArray					= array();
		$iArray['hidden']		= 0;
		$iArray['deleted']		= 0;
		$iArray['cloud_id']		= $cloud_id;
		$iArray['course_name']	= $course_name;
		$iArray['creation_time']= time();
		$iArray['crdate']		= time();
		$iArray['cruser_id']	= 1;
		$iArray['pid']			= $confArr['scormcloudstorage'];
		$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $iArray);
		if (!$res) { //check for sql error
			echo('<hr>\[File:'.__FILE__.' Func:'.__FUNCTION__.' Line:'.__LINE__.'] SQL Error:'.$GLOBALS['TYPO3_DB']->SELECTquery($table, $iArray));
			return FALSE;
		}		
	return TRUE;
	}//_insert_scorm_t3e_courses


	function _show_course_property_editor($courseidGP,$attributes,$propsEditorUrl,$t3eThisUrl){
		$propertyEditorRe	= '';
		//<a href="CoursePropertiesSample.php?courseid='.$courseidGP.'"><b>Refresh</b></a>
		$propertyEditorRe	.='<h4>Course Properties Editor</h4>
							<iframe width="800" height="600" src="'.$propsEditorUrl.'" id="coursePropertyEditIframe"></iframe>';
		/*$propertyEditorRe	.='<h4>Course Properties Editor</h4>
							<iframe width="800" height="600" src="'.$propsEditorUrl.'" id="coursePropertyEditIframe"></iframe><h4>Direct Attribute Updates:</h4><form action="'.$t3eThisUrl.'" method="Get" style="float:left;"><b>Attribute :</b>&nbsp;&nbsp;&nbsp;<select name="att">';
		
		foreach ($attributes as $key => $value){
			if ($value == 'true' || $value == 'false'){
				$propertyEditorRe	.= "<option value='" .$key."'>" .$key."</option>";
			}
        }

		$propertyEditorRe	.= '</select>&nbsp;&nbsp;&nbsp;<select name="attval"><option value="true">true</option><option value="false">false</option></select><input type="hidden" name="courseid" value="'.$courseidGP.'"/>&nbsp;&nbsp;&nbsp;<input type="submit" value="submit"/></form><form action="'.$t3eThisUrl.'" method="Get"><b>Attribute :&nbsp;&nbsp;&nbsp;<b><select name="att">';

		foreach ($attributes as $key => $value){
			if ($value != 'true' && $value != 'false'){
				$propertyEditorRe	.= "<option value='" .$key."'>" .$key."</option>";
			}
        }
		$propertyEditorRe	.= '</select>&nbsp;&nbsp;&nbsp;<input type="text" name="attval"><input type="hidden" name="courseid" value="'.$courseidGP .'"/>&nbsp;&nbsp;&nbsp;<input type="submit" value="submit"/></form>';*/
	return $propertyEditorRe;
	}



}