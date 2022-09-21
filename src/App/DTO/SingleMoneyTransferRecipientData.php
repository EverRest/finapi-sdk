<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Recipient data for a single money transfer order
 */
class SingleMoneyTransferRecipientData
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

}
