<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for IBAN rule information with paging information
 */
class PageableIbanRuleList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; IbanRule&lt;br/&gt; List of iban rules information
     * @DTA\Data(field="ibanRules")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection169::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection169::class})
     * @var \App\DTO\Collection169|null
     */
    public $iban_rules;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
