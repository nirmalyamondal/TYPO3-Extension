<?php
namespace Nirmalya\PowermailPdf\Controller;

use In2code\Powermail\Domain\Model\Mail;

/**
 * Class FormController
 *
 * @package Nirmalya\PowermailPdf\Controller
 */
class FormController
{

	/**
     * Update Theme before rendering
     * @param $form
     */
    public function formActionBeforeRenderView($forms, $formController)
    {
		//TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($forms);
		//var_dump($formController);
		//exit;
		//exit;
		/*foreach (array(1) as $form) {
			print_r('sdf');
		}
		exit;*/
    }

}
