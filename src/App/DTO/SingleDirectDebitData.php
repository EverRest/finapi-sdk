<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Data for a single direct debit
 */
class SingleDirectDebitData
{
    /**
     * Name of the debitor. Note: Neither finAPI nor the involved bank servers are guaranteed to validate the debitor name. Even if the debitor name does not depict the actual registered account holder of the specified debitor account, the direct debit request might still be successful.
     * @DTA\Data(field="debitorName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $debitor_name;

    /**
     * IBAN of the debitor&#39;s account
     * @DTA\Data(field="debitorIban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $debitor_iban;

    /**
     * BIC of the debitor&#39;s account. Note: This field is optional if - and only if - the bank connection of the account that you want to transfer money to supports the IBAN-Only direct debit. You can find this out via GET /bankConnections/&lt;id&gt;. If no BIC is given, finAPI will try to recognize it using the given debitorIban value (if it&#39;s given). And then if the result value is not empty, it will be used for the direct debit request independent of whether it is required or not.
     * @DTA\Data(field="debitorBic", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $debitor_bic;

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
     * Mandate ID that this direct debit order is based on.
     * @DTA\Data(field="mandateId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $mandate_id;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Date of the mandate that this direct debit order is based on
     * @DTA\Data(field="mandateDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $mandate_date;

    /**
     * Creditor ID of the source account&#39;s holder
     * @DTA\Data(field="creditorId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $creditor_id;

    /**
     * End-To-End ID for the transfer transaction
     * @DTA\Data(field="endToEndId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_to_end_id;

}
