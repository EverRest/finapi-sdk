<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for a single or collective SEPA direct debit order request
 */
class RequestSepaDirectDebitParams
{
    /**
     * Identifier of the bank account to which you want to transfer the money.
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * Whether to store the PIN. If the PIN is stored, it is not required to pass the PIN again when executing SEPA orders. Default value is &#39;false&#39;. &lt;br/&gt;&lt;br/&gt;NOTES:&lt;br/&gt; - before you set this field to true, please regard the &#39;pinsAreVolatile&#39; flag of the bank connection that the account belongs to. Please note that volatile credentials will not be stored, even if provided, to enforce user involvement in the next communication with the bank;&lt;br/&gt; - this field is ignored in case when the user will need to use finAPI&#39;s Web Form. The user will be able to decide whether to store the PIN or not in the Web Form, depending on the &#39;storeSecretsAvailableInWebForm&#39; setting (see Client Configuration).
     * @DTA\Data(field="storeSecrets", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $store_secrets;

    /**
     * The bank-given ID of the two-step-procedure that should be used for the order. For a list of available two-step-procedures, see the corresponding bank connection (GET /bankConnections). If this field is not set, then the bank connection&#39;s default two-step-procedure will be used. Note that in this case, when the bank connection has no default two-step-procedure set, then the response of the service depends on whether you need to use finAPI&#39;s Web Form or not. If you need to use the Web Form, the user will be prompted to select the two-step-procedure within the Web Form. If you don&#39;t need to use the Web Form, then the service will return an error (passing a value for this field is required in this case).
     * @DTA\Data(field="twoStepProcedureId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $two_step_procedure_id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; DirectDebitType&lt;br/&gt; Type of the direct debit; either &lt;code&gt;BASIC&lt;/code&gt; or &lt;code&gt;B2B&lt;/code&gt; (Business-To-Business). Please note that an account which supports the basic type must not necessarily support B2B (or vice versa). Check the source account&#39;s &#39;supportedOrders&#39; field to find out which types of direct debit it supports.&lt;br/&gt;&lt;br/&gt;
     * @DTA\Data(field="directDebitType")
     * @DTA\Strategy(name="Object", options={"type":DirectDebitType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":DirectDebitType::class})
     * @var DirectDebitType|null
     */
    public $direct_debit_type;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; DirectDebitSequenceType&lt;br/&gt; Sequence type of the direct debit. Possible values:&lt;br/&gt;&lt;br/&gt;&amp;bull; &lt;code&gt;OOFF&lt;/code&gt; - means that this is a one-time direct debit order&lt;br/&gt;&amp;bull; &lt;code&gt;FRST&lt;/code&gt; - means that this is the first in a row of multiple direct debit orders&lt;br/&gt;&amp;bull; &lt;code&gt;RCUR&lt;/code&gt; - means that this is one (but not the first or final) within a row of multiple direct debit orders&lt;br/&gt;&amp;bull; &lt;code&gt;FNAL&lt;/code&gt; - means that this is the final in a row of multiple direct debit orders&lt;br/&gt;&lt;br/&gt;
     * @DTA\Data(field="sequenceType")
     * @DTA\Strategy(name="Object", options={"type":DirectDebitSequenceType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":DirectDebitSequenceType::class})
     * @var DirectDebitSequenceType|null
     */
    public $sequence_type;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Execution date for the direct debit(s).
     * @DTA\Data(field="executionDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $execution_date;

    /**
     * This field is only regarded when you pass multiple orders. It determines whether the orders should be processed by the bank as one collective booking (in case of &#39;false&#39;), or as single bookings (in case of &#39;true&#39;). Default value is &#39;false&#39;.
     * @DTA\Data(field="singleBooking", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $single_booking;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; SingleDirectDebitData&lt;br/&gt; List of the direct debits that you want to execute (may contain at most 15000 items). Please check the account&#39;s &#39;supportedOrders&#39; field to find out whether you can pass multiple direct debits or just one.
     * @DTA\Data(field="directDebits")
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\SingleDirectDebitData[]|null
     */
    public $direct_debits;

    /**
     * Whether the finAPI Web Form should hide transaction details when prompting the caller for the second factor. Default value is false.
     * @DTA\Data(field="hideTransactionDetailsInWebForm", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $hide_transaction_details_in_web_form;

    /**
     * @DTA\Data(field="multiStepAuthentication", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\ConnectInterfaceParamsMultiStepAuthentication::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\ConnectInterfaceParamsMultiStepAuthentication::class})
     * @var \App\DTO\ConnectInterfaceParamsMultiStepAuthentication|null
     */
    public $multi_step_authentication;

}
