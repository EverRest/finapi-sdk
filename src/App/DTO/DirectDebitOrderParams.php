<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for a direct debit order
 */
class DirectDebitOrderParams
{
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
     * BIC of the counterpart&#39;s account. Only required when there is no &#39;IBAN_ONLY&#39;-capability in the respective account/interface combination that is to be used when submitting the payment.
     * @DTA\Data(field="counterpartBic", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_bic;

    /**
     * The amount of the payment. Must be a positive decimal number with at most two decimal places. When debiting money using the FINTS_SERVER or WEB_SCRAPER interface, the currency is always EUR.
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
     * SEPA purpose code, according to ISO 20022, external codes set.&lt;br/&gt;Please note that the SEPA purpose code may be ignored by some banks.
     * @DTA\Data(field="sepaPurposeCode", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $sepa_purpose_code;

    /**
     * End-To-End ID for the transfer transaction
     * @DTA\Data(field="endToEndId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_to_end_id;

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
     * @DTA\Data(field="creditorId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $creditor_id;

    /**
     * The postal address of the debtor. This should be defined for direct debits created for debtors outside of the european union.
     * @DTA\Data(field="counterpartAddress", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_address;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; ISO3166Alpha2Codes&lt;br/&gt; The ISO 3166 ALPHA-2 country code of the debtor’s address. Examples: &#39;GB&#39; for the United Kingdom or &#39;CH&#39; for Switzerland. This should be defined for direct debits created for debtors outside of the european union.
     * @DTA\Data(field="counterpartCountry", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":ISO3166Alpha2Codes::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":ISO3166Alpha2Codes::class})
     * @var ISO3166Alpha2Codes|null
     */
    public $counterpart_country;

}
