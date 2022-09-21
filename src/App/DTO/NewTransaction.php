<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Mock transaction data
 */
class NewTransaction
{
    /**
     * Amount. Required.
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Currency&lt;br/&gt; Transaction currency.
     * @DTA\Data(field="currency", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":Currency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":Currency::class})
     * @var Currency|null
     */
    public $currency;

    /**
     * Original amount
     * @DTA\Data(field="originalAmount", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $original_amount;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Currency&lt;br/&gt; Currency of the original amount.
     * @DTA\Data(field="originalCurrency", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":Currency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":Currency::class})
     * @var Currency|null
     */
    public $original_currency;

    /**
     * Purpose. Any symbols are allowed. Maximum length is 2000. Optional. Default value: null.
     * @DTA\Data(field="purpose", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $purpose;

    /**
     * Counterpart. Any symbols are allowed. Maximum length is 80. Optional. Default value: null.
     * @DTA\Data(field="counterpart", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart;

    /**
     * Counterpart IBAN. Optional. Default value: null.
     * @DTA\Data(field="counterpartIban", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_iban;

    /**
     * Counterpart BLZ. Optional. Default value: null.
     * @DTA\Data(field="counterpartBlz", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_blz;

    /**
     * Counterpart BIC. Optional. Default value: null.
     * @DTA\Data(field="counterpartBic", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_bic;

    /**
     * Counterpart account number. Maximum length is 34. Optional. Default value: null.
     * @DTA\Data(field="counterpartAccountNumber", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_account_number;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Booking date.&lt;br/&gt;&lt;br/&gt;If the date lies back more than 10 days from the booking date of the latest transaction that currently exists in the account, then this transaction will be ignored and not imported. If the date depicts a date in the future, then finAPI will deal with it the same way as it does with real transactions during a real update (see fields &#39;bankBookingDate&#39; and &#39;finapiBookingDate&#39; in the Transaction Resource for explanation).&lt;br/&gt;&lt;br/&gt;This field is optional, default value is the current date.
     * @DTA\Data(field="bookingDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $booking_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Value date. Optional. Default value: Same as the booking date.
     * @DTA\Data(field="valueDate", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $value_date;

    /**
     * The transaction type id. It&#39;s usually a number between 1 and 999. You can look up valid transaction in the following document on page 198: &lt;a href&#x3D;&#39;https://www.hbci-zka.de/dokumente/spezifikation_deutsch/fintsv4/FinTS_4.1_Messages_Finanzdatenformate_2014-01-20-FV.pdf&#39; target&#x3D;&#39;_blank&#39;&gt;FinTS Financial Transaction Services&lt;/a&gt;.&lt;br/&gt; For numbers not listed here, the service call might fail.
     * @DTA\Data(field="typeId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $type_id;

    /**
     * The mandate reference of the counterpart. The maximum possible length of this field is 270 characters.
     * @DTA\Data(field="counterpartMandateReference", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_mandate_reference;

    /**
     * The creditor ID of the counterpart. Exists only for SEPA direct debit transactions (\&quot;Lastschrift\&quot;). The maximum possible length of this field is 270 characters.
     * @DTA\Data(field="counterpartCreditorId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_creditor_id;

    /**
     * The customer reference of the counterpart. The maximum possible length of this field is 270 characters.
     * @DTA\Data(field="counterpartCustomerReference", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_customer_reference;

    /**
     * The originator&#39;s identification code. Exists only for SEPA money transfer transactions (\&quot;Überweisung\&quot;). The maximum possible length of this field is 100 characters.
     * @DTA\Data(field="counterpartDebitorId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_debitor_id;

    /**
     * Transaction type, according to the bank. If set, this will contain a German term that you can display to the user. Some examples of common values are: \&quot;Lastschrift\&quot;, \&quot;Auslands&amp;uuml;berweisung\&quot;, \&quot;Geb&amp;uuml;hren\&quot;, \&quot;Zinsen\&quot;. The maximum possible length of this field is 270 characters.
     * @DTA\Data(field="type", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $type;

    /**
     * SWIFT transaction type code.
     * @DTA\Data(field="typeCodeSwift", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $type_code_swift;

    /**
     * SEPA purpose code.
     * @DTA\Data(field="sepaPurposeCode", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $sepa_purpose_code;

}
