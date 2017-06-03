<?php

namespace Nirmalya\PowermailPdf\Domain\Model;

/**
 * Class Field
 * @package Nirmalya\PowermailPdf\Domain\Model
 */
class Field extends \Nirmalya\NirmalyaPowermail\Domain\Model\Field
{
    /**
     * Signed PDF File
     *
     * @var int $signedpdf
     */
    protected $signedpdf;

    /**
     * Button for PDF File
     *
     * @var int $signedpdfbutton
     */
    protected $signedpdfbutton;

    /**
     * @param int $signedpdf
     * @return void
     */
    public function setSignedpdf($signedpdf)
    {
        $this->signedpdf = $signedpdf;
    }

    /**
     * @return int
     */
    public function getSignedpdf()
    {
        return $this->signedpdf;
    }

    /**
     * @param int $signedpdfbutton
     * @return void
     */
    public function setSignedpdfbutton($signedpdfbutton)
    {
        $this->signedpdfbutton = $signedpdfbutton;
    }

    /**
     * @return int
     */
    public function getSignedpdfbutton()
    {
        return $this->signedpdfbutton;
    }
}
