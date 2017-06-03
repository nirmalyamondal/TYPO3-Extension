<?php

namespace Nirmalya\PowermailPdf\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Page
 * @package Nirmalya\PowermailPdf\Domain\Model
 */
class Page extends \Nirmalya\NirmalyaPowermail\Domain\Model\Page
{
    /**
     * Powermail Fields
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Nirmalya\PowermailPdf\Domain\Model\Field>
     */
    protected $fields = null;

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $fields
     * @return void
     */
    public function setFields(ObjectStorage $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getFields()
    {
        return $this->fields;
    }
}
