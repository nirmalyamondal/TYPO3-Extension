<?php

namespace Nirmalya\PowermailPdf\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Form
 * @package Nirmalya\PowermailPdf\Domain\Model
 */
class Form extends \Nirmalya\NirmalyaPowermail\Domain\Model\Form
{
    /**
     * pages
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Nirmalya\PowermailPdf\Domain\Model\Page>
     */
    protected $pages;

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $pages
     * @return void
     */
    public function setPages(ObjectStorage $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getPages()
    {
        return $this->pages;
    }
}
