<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for standing order creation parameters
 */
class CreateStandingOrderParams
{
    /**
     * Identifier of the account that should be used for the standing order. If you want to do a standalone standing order (i.e. for an account that is not imported in finAPI) leave this field unset and instead use the field &#39;iban&#39;.
     * @DTA\Data(field="accountId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * IBAN of the account that should be used for the standing order. Use this field only if you want to do a standalone standing order (i.e. for an account that is not imported in finAPI) otherwise, use the &#39;accountId&#39; field and leave this field unset.
     * @DTA\Data(field="iban", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

    /**
     * Name of the counterpart. Note: Neither finAPI nor the involved bank servers are guaranteed to validate the counterpart name. Even if the name does not depict the actual registered account holder of the target account, the order might still be successful.
     * @DTA\Data(field="counterpartName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_name;

    /**
     * IBAN of the counterpart&#39;s account.
     * @DTA\Data(field="counterpartIban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_iban;

    /**
     * The amount of the standing order. Must be a positive decimal number with at most two decimal places.
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Currency&lt;br/&gt; The currency code of the &#39;amount&#39;. To be provided in the ISO 4217 Alpha 3 format.
     * @DTA\Data(field="currency")
     * @DTA\Strategy(name="Object", options={"type":Currency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":Currency::class})
     * @var Currency|null
     */
    public $currency;

    /**
     * The purpose of the standing order.
     * @DTA\Data(field="purpose", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $purpose;

    /**
     * SEPA purpose code, according to ISO 20022, external codes set.&lt;br/&gt;Please note that the SEPA purpose code may be ignored by some banks.
     * @DTA\Data(field="sepaPurposeCode", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $sepa_purpose_code;

    /**
     * End-To-End ID of the standing order
     * @DTA\Data(field="endToEndId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_to_end_id;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Start date of the standing order. Date must be in the future (at least tomorrow).
     * @DTA\Data(field="startDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $start_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Termination date of the standing order. If provided, it must be after the &#39;startDate&#39;. If not provided, then the standing order will have no termination.
     * @DTA\Data(field="endDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_date;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; StandingOrderFrequency&lt;br/&gt; The frequency of the standing order
     * @DTA\Data(field="frequency")
     * @DTA\Strategy(name="Object", options={"type":StandingOrderFrequency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":StandingOrderFrequency::class})
     * @var StandingOrderFrequency|null
     */
    public $frequency;

}
