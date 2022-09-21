<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Params for creation of keyword rules
 */
class KeywordRulesParams
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; KeywordRuleParams&lt;br/&gt; Keyword rule definitions. The minimum number of rule definitions is 1. The maximum number of rule definitions is 100.
     * @DTA\Data(field="keywordRules")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection154::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection154::class})
     * @var \App\DTO\Collection154|null
     */
    public $keyword_rules;

}
