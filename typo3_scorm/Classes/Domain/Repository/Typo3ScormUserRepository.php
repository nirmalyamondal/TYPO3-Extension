<?php
namespace TYPO3\Typo3Scorm\Domain\Repository;


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
 * The repository for Typo3ScormUser
 * 
 * @package TYPO3
 * @subpackage TYPO3
 * @author Nirmalya Mondal <typo3india@gmail.com>
 * @copyright (c) 2016, Nirmalya Mondal
 */
class Typo3ScormUserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    public function initializeObject() {
    	$this->querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
    	$this->querySettings->setRespectStoragePage(FALSE);
    	$this->setDefaultQuerySettings($this->querySettings);
    }
    
   
    /**
     * findByUid
     * 
     * @see TYPO3\CMS\Extbase\Persistence.Repository::findByUid()
     */
	public function findByUid($uid, $ignoreEnableFields = FALSE) {
		
		$query = $this->createQuery();
		$query->getQuerySettings()->setIgnoreEnableFields($ignoreEnableFields);
		return $query->matching(
			$query->equals('uid', $uid)
		)->execute()->getFirst();
	}
	
	/**
     * findRegIdByFeuserIdNCourseId
     * 
     * @see findRegIdByFeuserIdNCourseId()
     */
	/*public function findRegIdByFeuserIdNCourseId($t3user_id, $scorm_cloud, $ignoreEnableFields = FALSE) {
		
		$query = $this->createQuery();
		$query->getQuerySettings()->setIgnoreEnableFields($ignoreEnableFields);
		return $query->matching(
			$query->equals('t3user_id', $t3user_id),
			$query->equals('scorm_cloud', $scorm_cloud)
		)->execute()->getFirst();
	}*/

}