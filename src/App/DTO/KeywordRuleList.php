<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for keyword rules
 */
class KeywordRuleList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; KeywordRule&lt;br/&gt; List of keyword rules
     * @DTA\Data(field="keywordRules")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection156::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection156::class})
     * @var \App\DTO\Collection156|null
     */
    public $keyword_rules;

}
