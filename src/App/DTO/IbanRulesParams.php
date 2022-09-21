<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Params for creation of IBAN rules
 */
class IbanRulesParams
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; IbanRuleParams&lt;br/&gt; IBAN rule definitions. The minimum number of rule definitions is 1. The maximum number of rule definitions is 100.
     * @DTA\Data(field="ibanRules")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection173::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection173::class})
     * @var \App\DTO\Collection173|null
     */
    public $iban_rules;

}
