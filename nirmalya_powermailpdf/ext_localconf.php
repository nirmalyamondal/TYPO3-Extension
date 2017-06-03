<?php
/**
 * Register some Slots
 */
// Create signal slot instance
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
);

$signalSlotDispatcher->connect(
	\In2code\Powermail\Controller\FormController::class, 'formActionBeforeRenderView',
	\Nirmalya\PowermailPdf\Controller\FormController::class, 'formActionBeforeRenderView',
	false
);
