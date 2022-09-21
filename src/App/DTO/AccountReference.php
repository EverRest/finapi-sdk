<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Account reference data
 */
class AccountReference
{
    /**
     * The account&#39;s IBAN
     * @DTA\Data(field="iban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

}
