<?php
namespace Nirmalya\PowermailPdf\Domain\Validator;

/**
 * PdfValidator
 */
class PdfValidator
{

    /**
     * Check if given number is higher than in configuration
     *
     * @param string $value
     * @param string $validationConfig
     * @return bool
     */
    public function validate107($value, $validationConfig)
    {
        return $value && $value >= $validationConfig;
    }
}
