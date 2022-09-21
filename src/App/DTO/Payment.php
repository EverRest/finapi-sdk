<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a payment&#39;s data
 */
class Payment
{
    /**
     * Payment identifier
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Identifier of the account to which this payment relates. This field is only set if it was specified upon creation of the payment.
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * IBAN of the account to which this payment relates. This field is only set if it was specified upon creation of the payment.
     * @DTA\Data(field="iban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; PaymentType&lt;br/&gt; Payment type
     * @DTA\Data(field="type")
     * @DTA\Strategy(name="Object", options={"type":PaymentType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":PaymentType::class})
     * @var PaymentType|null
     */
    public $type;

    /**
     * Total money amount of the payment order(s), as absolute value
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * Total count of orders included in this payment
     * @DTA\Data(field="orderCount")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $order_count;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; OrderInitiationStatus&lt;br/&gt; Current payment status:&lt;br/&gt; &amp;bull; OPEN: means that this payment has been created in finAPI, but not yet submitted to the bank.&lt;br/&gt; &amp;bull; PENDING: means that this payment has been requested at the bank,  but has not been confirmed yet.&lt;br/&gt; &amp;bull; SUCCESSFUL: means that this payment has been successfully initiated.&lt;br/&gt; &amp;bull; NOT_SUCCESSFUL: means that this payment could not be initiated successfully.&lt;br/&gt; &amp;bull; DISCARDED: means that this payment was discarded, either because another payment was requested for the same account before this payment was initiated and the bank does not support this, or because the user has aborted the initiation (when using finAPI&#39;s Web Form).
     * @DTA\Data(field="status")
     * @DTA\Strategy(name="Object", options={"type":OrderInitiationStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":OrderInitiationStatus::class})
     * @var OrderInitiationStatus|null
     */
    public $status;

    /**
     * The bank&#39;s response to the most recent request for this payment. Possible requests are: Initial submission of the payment, execution request or subsequent status checks. Note that this field may not always (or never) be set. Also, as long as the payment has not reached its final status, this field can always change.
     * @DTA\Data(field="bankMessage")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $bank_message;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Time of when finAPI submitted this payment to the bank.
     * @DTA\Data(field="requestDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $request_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Time of when the execution of this payment has completed.&lt;br/&gt;&lt;br/&gt;Note:&lt;br/&gt;&amp;bull; When the execution of a payment has completed, it does not necessarily mean that the payment was successful. Please refer to the payment &#39;status&#39; for its final status.&lt;br/&gt;&amp;bull; The execution date may deviate from the date when the bank will actually book the payment (for example if the &#39;instructedExecutionDate&#39; is in the future).
     * @DTA\Data(field="executionDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $execution_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;The date that was specified as &#39;executionDate&#39; upon creation of the payment. This field may not be set if no &#39;executionDate&#39; was specified upon payment creation.
     * @DTA\Data(field="instructedExecutionDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $instructed_execution_date;

    /**
     * Whether the order was submitted to the bank as an instant SEPA order.
     * @DTA\Data(field="instantPayment")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $instant_payment;

}
