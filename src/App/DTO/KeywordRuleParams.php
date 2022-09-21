<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters of keyword rule
 */
class KeywordRuleParams
{
    /**
     * ID of the category that this rule should assign to the matching transactions
     * @DTA\Data(field="categoryId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $category_id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; CategorizationRuleDirection&lt;br/&gt; Direction for the rule. &#39;Income&#39; means that the rule applies to transactions with a positive amount only, &#39;Spending&#39; means it applies to transactions with a negative amount only. &#39;Both&#39; means that it applies to both kind of transactions. Note that in case of &#39;Both&#39;, finAPI will create two individual rules (one with direction &#39;Income&#39; and one with direction &#39;Spending&#39;).
     * @DTA\Data(field="direction")
     * @DTA\Strategy(name="Object", options={"type":CategorizationRuleDirection::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":CategorizationRuleDirection::class})
     * @var CategorizationRuleDirection|null
     */
    public $direction;

    /**
     * @DTA\Data(field="keywords")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection153::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection153::class})
     * @var \App\DTO\Collection153|null
     */
    public $keywords;

    /**
     * This field is only relevant if you pass multiple keywords. If set to &#39;true&#39;, it means that all keywords have to be found in a transaction to apply the given category. If set to &#39;false&#39;, then even a single matching keyword in a transaction can trigger this rule. Default value is &#39;false&#39;.
     * @DTA\Data(field="allKeywordsMustMatch", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $all_keywords_must_match;

}
