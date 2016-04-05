<?php
namespace TYPO3\Googleroutemap\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) Nirmalya Mondal (http://typo3nirmalya.blogspot.in/)
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
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * RoutemapController controls the actions. 
 * In this case 'show' is the default and only one action and called by this controller to render addresses.
 */
class RoutemapController extends ActionController 
{

    /**
     * Routemap Repository
     *
     * @var \TYPO3\Googleroutemap\Domain\Repository\RoutemapRepository
     * @inject
     */
    protected $routemapRepository = null;

    /**
     * Controller action show
     *
     * Default action which outputs the Google Route Map Planner with pre-defined destinations.
     *
     * @return void
     */
    public function showAction() 
    {
        $storagePid = $this->settings['flex_storage_page'];
        $googleroutes = $this->routemapRepository->findByPid($storagePid);
        $addresses[] = LocalizationUtility::translate('tx_googleroutemap_domain_model_routemap.label_select', 'Googleroutemap');
        foreach ($googleroutes as $route) {
            $addresses[] = $route->getAddress();
        }
        $this->view->assign('addresses', $addresses);
    }

}
