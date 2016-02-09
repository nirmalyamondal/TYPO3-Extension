<?php
    $extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('typo3_scorm');

    return array(   
        'ScormEngineService' => $extensionPath.'Resources/Private/PHP/scormcloud/ScormEngineService.php',  
    );

?>