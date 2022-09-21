<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a keyword rule
 */
class KeywordRule
{
    /**
     * Rule identifier
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * @DTA\Data(field="category")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\IbanRuleCategory::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\IbanRuleCategory::class})
     * @var \App\DTO\IbanRuleCategory|null
     */
    public $category;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TransactionDirection&lt;br/&gt; Direction for the rule. &#39;Income&#39; means that the rule applies to transactions with a positive amount only, &#39;Spending&#39; means it applies to transactions with a negative amount only.
     * @DTA\Data(field="direction")
     * @DTA\Strategy(name="Object", options={"type":TransactionDirection::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":TransactionDirection::class})
     * @var TransactionDirection|null
     */
    public $direction;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Timestamp of when the rule was created.
     * @DTA\Data(field="creationDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $creation_date;

    /**
     * @DTA\Data(field="keywords")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection155::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection155::class})
     * @var \App\DTO\Collection155|null
     */
    public $keywords;

    /**
     * This field is only relevant if the rule contains multiple keywords. If set to &#39;true&#39; it means that all keywords have to be found in a transaction to apply the given category. If set to &#39;false&#39;, then even a single matching keyword in a transaction can trigger this rule.
     * @DTA\Data(field="allKeywordsMustMatch")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $all_keywords_must_match;

}
