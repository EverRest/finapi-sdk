<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for IBAN rules
 */
class IbanRuleList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; IbanRule&lt;br/&gt; List of IBAN rules
     * @DTA\Data(field="ibanRules")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection174::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection174::class})
     * @var \App\DTO\Collection174|null
     */
    public $iban_rules;

}
