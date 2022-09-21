<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for money transfer creation parameters
 */
class CreateMoneyTransferParams
{
    /**
     * This field is only relevant when you pass multiple orders. It determines whether the orders should be processed by the bank as one collective booking (in case of &#39;false&#39;), or as single bookings (in case of &#39;true&#39;). Note that it is subject to the bank whether it will regard the field. Default value is &#39;false&#39;.
     * @DTA\Data(field="singleBooking", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $single_booking;

    /**
     * Identifier of the account that should be used for the money transfer. If you want to do a standalone money transfer (finAPI Payment product, i.e. for an account that is not imported in finAPI) leave this field unset and instead use the field &#39;iban&#39;.
     * @DTA\Data(field="accountId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * IBAN of the account that should be used for the money transfer. Use this field only if you want to do a standalone money transfer (finAPI Payment product, i.e. for an account that is not imported in finAPI) otherwise, use the &#39;accountId&#39; field and leave this field unset.
     * @DTA\Data(field="iban", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $iban;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Execution date for the money transfer(s). May not be in the past. For instant payments, it must either be omitted, or be the current date. If not specified, most banks will use the current date as the instructed date for execution.
     * @DTA\Data(field="executionDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $execution_date;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; MoneyTransferOrderParams&lt;br/&gt; List of money transfer orders (may contain at most 15000 items). Please note that collective money transfer may not always be supported.
     * @DTA\Data(field="moneyTransfers")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection118::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection118::class})
     * @var \App\DTO\Collection118|null
     */
    public $money_transfers;

    /**
     * Whether the order should be submitted to the bank as an instant SEPA order. Default value is &#39;false&#39;.&lt;br/&gt;&lt;br/&gt;NOTE:&lt;br/&gt;&amp;bull; Instant payments can only be submitted if you are self-licensed (and not using the finAPI Web Form) OR via our Web Form from the endpoint &lt;a href&#x3D;&#39;?product&#x3D;web_form_2.0#tag--Payment-Initiation-Services&#39; target&#x3D;&#39;_blank&#39;&gt;here&lt;/a&gt;.&lt;br/&gt;&amp;bull; Submitting an instant payment will work only with interfaces that support it, see BankInterface.paymentCapabilities.sepaInstantMoneyTransfer&lt;br/&gt;&amp;bull; Instant payments work only for a single order, not for collective orders.&lt;br/&gt;&amp;bull; The bank may charge a fee for instant payments, depending on the agreement between the user and the bank.&lt;br/&gt;&amp;bull; The payment might get rejected if the source and/or target account doesn&#39;t support instant payments.
     * @DTA\Data(field="instantPayment", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $instant_payment;

}
