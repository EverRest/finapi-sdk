<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a standing order&#39;s data
 */
class StandingOrder
{
    /**
     * Standing order identifier
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Identifier of the account to which this standing order relates. This field is only set if it was specified upon creation of the standing order.
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * IBAN of the account to which this standing order relates. This field is only set if it was specified upon creation of the standing order.
     * @DTA\Data(field="iban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

    /**
     * Amount of the standing order, as absolute value.
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Currency&lt;br/&gt; The currency code of the &#39;amount&#39;, in the ISO 4217 Alpha 3 format.
     * @DTA\Data(field="currency")
     * @DTA\Strategy(name="Object", options={"type":Currency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":Currency::class})
     * @var Currency|null
     */
    public $currency;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Start date of the standing order.
     * @DTA\Data(field="startDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $start_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Termination date of the standing order. If this field is not set, then the standing order has no termination date.
     * @DTA\Data(field="endDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_date;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; StandingOrderFrequency&lt;br/&gt; The frequency of the standing order.
     * @DTA\Data(field="frequency")
     * @DTA\Strategy(name="Object", options={"type":StandingOrderFrequency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":StandingOrderFrequency::class})
     * @var StandingOrderFrequency|null
     */
    public $frequency;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Time of when finAPI submitted this standing order to the bank.
     * @DTA\Data(field="requestDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $request_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Time of when the submission of this standing order was finalized. Note: When the submission of a standing order is finalized, it does not necessarily mean that the bank accepted the standing order. Please refer to the standing order’s &#39;status&#39; for its final status.
     * @DTA\Data(field="requestCompletionDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $request_completion_date;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; OrderInitiationStatus&lt;br/&gt; Current standing order status:&lt;br/&gt; &amp;bull; OPEN: means that this standing order has been created in finAPI, but not yet submitted to the bank.&lt;br/&gt; &amp;bull; PENDING: means that this standing order has been submitted to the bank,  but has not been confirmed yet.&lt;br/&gt; &amp;bull; SUCCESSFUL: means that this standing order has been successfully initiated.&lt;br/&gt; &amp;bull; NOT_SUCCESSFUL: means that this standing order could not be initiated successfully.&lt;br/&gt; &amp;bull; DISCARDED: means that this standing order was discarded, either because another standing order was requested for the same account before this standing order was initiated and the bank does not support this, or because the user has aborted the initiation (when using finAPI&#39;s Web Form).
     * @DTA\Data(field="status")
     * @DTA\Strategy(name="Object", options={"type":OrderInitiationStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":OrderInitiationStatus::class})
     * @var OrderInitiationStatus|null
     */
    public $status;

    /**
     * The bank&#39;s response to the most recent request for this standing order. Note that this field may not always (or never) be set. Also, as long as the standing order has not reached its final status, this field can always change.
     * @DTA\Data(field="bankMessage")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $bank_message;

}
