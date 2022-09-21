<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters of IBAN rule
 */
class IbanRuleParams
{
    /**
     * IBAN (case-insensitive)
     * @DTA\Data(field="iban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

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

}
