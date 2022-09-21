<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for an IBAN rule
 */
class IbanRule
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
     * The IBAN for this rule
     * @DTA\Data(field="iban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

}
