<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for keyword rule information with paging information
 */
class PageableKeywordRuleList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; KeywordRule&lt;br/&gt; List of keyword rules
     * @DTA\Data(field="keywordRules")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection149::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection149::class})
     * @var \App\DTO\Collection149|null
     */
    public $keyword_rules;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
