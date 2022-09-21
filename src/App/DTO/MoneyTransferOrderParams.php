<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for a money transfer order
 */
class MoneyTransferOrderParams
{
    /**
     * Name of the counterpart. Has to be provided for the SEPA EUR transfers. Note: Neither finAPI nor the involved bank servers are guaranteed to validate the counterpart name. Even if the name does not depict the actual registered account holder of the target account, the order might still be successful.
     * @DTA\Data(field="counterpartName", nullable=true)
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
     * BIC of the counterpart&#39;s account. Only required for SEPA payments (i.e. payments in EUR currency), when there is no &#39;IBAN_ONLY&#39;-capability in the respective account/interface combination that is to be used when submitting the payment.
     * @DTA\Data(field="counterpartBic", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_bic;

    /**
     * The amount of the payment. Must be a positive decimal number with at most two decimal places. For money transfers over the XS2A interface, finAPI will interpret the amount to be in the currency of the related account. For money transfers over other interfaces (FINTS_SERVER, WEB_SCRAPER), as well as for standalone money transfers (finAPI Payment product) over all interfaces (FINTS_SERVER, WEB_SCRAPER, XS2A), finAPI will consider the amount to be in EUR.
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
     * SEPA purpose code, according to ISO 20022, external codes set.&lt;br/&gt;Please note that the SEPA purpose code may be ignored by some banks and will be discarded for the non-SEPA payments.
     * @DTA\Data(field="sepaPurposeCode", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $sepa_purpose_code;

    /**
     * End-To-End ID for the transfer transaction. &lt;br/&gt;Only applicable for the SEPA EUR transfers and will be discarded for other transfers.
     * @DTA\Data(field="endToEndId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_to_end_id;

    /**
     * @DTA\Data(field="structuredRemittanceInformation")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection117::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection117::class})
     * @var \App\DTO\Collection117|null
     */
    public $structured_remittance_information;

}
