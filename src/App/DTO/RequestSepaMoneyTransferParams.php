<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for a single or collective SEPA money transfer order request
 */
class RequestSepaMoneyTransferParams
{
    /**
     * Name of the recipient. Note: Neither finAPI nor the involved bank servers are guaranteed to validate the recipient name. Even if the recipient name does not depict the actual registered account holder of the specified recipient account, the money transfer request might still be successful. This field is optional only when you pass a clearing account as the recipient. Otherwise, this field is required.
     * @DTA\Data(field="recipientName", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $recipient_name;

    /**
     * IBAN of the recipient&#39;s account. This field is optional only when you pass a clearing account as the recipient. Otherwise, this field is required.
     * @DTA\Data(field="recipientIban", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $recipient_iban;

    /**
     * BIC of the recipient&#39;s account. Note: This field is optional when you pass a clearing account as the recipient or if the bank connection of the account that you want to transfer money from supports the IBAN-Only money transfer. You can find this out via GET /bankConnections/&lt;id&gt;. If no BIC is given, finAPI will try to recognize it using the given recipientIban value (if it&#39;s given). And then if the result value is not empty, it will be used for the money transfer request independent of whether it is required or not (unless you pass a clearing account, in which case the value will always be ignored).
     * @DTA\Data(field="recipientBic", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $recipient_bic;

    /**
     * Identifier of a clearing account. If this field is set, then the fields &#39;recipientName&#39;, &#39;recipientIban&#39; and &#39;recipientBic&#39; will be ignored and the recipient account will be the specified clearing account.
     * @DTA\Data(field="clearingAccountId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $clearing_account_id;

    /**
     * End-To-End ID for the transfer transaction
     * @DTA\Data(field="endToEndId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_to_end_id;

    /**
     * The amount to transfer. Must be a positive decimal number with at most two decimal places (e.g. 99.99)
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * The purpose of the transfer transaction
     * @DTA\Data(field="purpose", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $purpose;

    /**
     * SEPA purpose code, according to ISO 20022, external codes set.
     * @DTA\Data(field="sepaPurposeCode", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $sepa_purpose_code;

    /**
     * Identifier of the bank account that you want to transfer money from
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
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Execution date for the money transfer(s). If not specified, then the current date will be used.
     * @DTA\Data(field="executionDate", nullable=true)
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
     * &lt;strong&gt;Type:&lt;/strong&gt; SingleMoneyTransferRecipientData&lt;br/&gt; In case that you want to submit not just a single money transfer, but do a collective money transfer, use this field to pass a list of additional money transfer orders. The service will then pass a collective money transfer request to the bank, including both the money transfer specified on the top-level, as well as all money transfers specified in this list. The maximum count of money transfers that you can pass (in total) is 15000. Note that you should check the account&#39;s &#39;supportedOrders&#39; field to find out whether or not it is supporting collective money transfers.
     * @DTA\Data(field="additionalMoneyTransfers", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\SingleMoneyTransferRecipientData[]|null
     */
    public $additional_money_transfers;

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
