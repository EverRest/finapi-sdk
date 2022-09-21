<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a transaction&#39;s data
 */
class Transaction
{
    /**
     * Transaction identifier
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Parent transaction identifier
     * @DTA\Data(field="parentId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $parent_id;

    /**
     * Account identifier
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Value date.
     * @DTA\Data(field="valueDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $value_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Bank booking date.
     * @DTA\Data(field="bankBookingDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $bank_booking_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;finAPI Booking date. NOTE: In some cases, banks may deliver transactions that are booked in future, but already included in the current account balance. To keep the account balance consistent with the set of transactions, such \&quot;future transactions\&quot; will be imported with their finapiBookingDate set to the current date (i.e.: date of import). The finapiBookingDate will automatically get adjusted towards the bankBookingDate each time the associated bank account is updated. Example: A transaction is imported on July, 3rd, with a bank reported booking date of July, 6th. The transaction will be imported with its finapiBookingDate set to July, 3rd. Then, on July 4th, the associated account is updated. During this update, the transaction&#39;s finapiBookingDate will be automatically adjusted to July 4th. This adjustment of the finapiBookingDate takes place on each update until the bank account is updated on July 6th or later, in which case the transaction&#39;s finapiBookingDate will be adjusted to its final value, July 6th.&lt;br/&gt; The finapiBookingDate is the date that is used by the finAPI PFM services. E.g. when you calculate the spendings of an account for the current month, and have a transaction with finapiBookingDate in the current month but bankBookingDate at the beginning of the next month, then this transaction is included in the calculations (as the bank has this transaction&#39;s amount included in the current account balance as well).
     * @DTA\Data(field="finapiBookingDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $finapi_booking_date;

    /**
     * Transaction amount
     * @DTA\Data(field="amount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $amount;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Currency&lt;br/&gt; Transaction currency in ISO 4217 format.This field can be null if not explicitly provided the bank. In this case it can be assumed as account’s currency.
     * @DTA\Data(field="currency")
     * @DTA\Strategy(name="Object", options={"type":Currency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":Currency::class})
     * @var Currency|null
     */
    public $currency;

    /**
     * Transaction purpose. Maximum length: 2000
     * @DTA\Data(field="purpose")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $purpose;

    /**
     * Counterpart name. Maximum length: 80
     * @DTA\Data(field="counterpartName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_name;

    /**
     * Counterpart account number
     * @DTA\Data(field="counterpartAccountNumber")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_account_number;

    /**
     * Counterpart IBAN
     * @DTA\Data(field="counterpartIban")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_iban;

    /**
     * Counterpart BLZ
     * @DTA\Data(field="counterpartBlz")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_blz;

    /**
     * Counterpart BIC
     * @DTA\Data(field="counterpartBic")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_bic;

    /**
     * Counterpart Bank name
     * @DTA\Data(field="counterpartBankName")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_bank_name;

    /**
     * The mandate reference of the counterpart
     * @DTA\Data(field="counterpartMandateReference")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_mandate_reference;

    /**
     * The customer reference of the counterpart
     * @DTA\Data(field="counterpartCustomerReference")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_customer_reference;

    /**
     * The creditor ID of the counterpart. Exists only for SEPA direct debit transactions (\&quot;Lastschrift\&quot;).
     * @DTA\Data(field="counterpartCreditorId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_creditor_id;

    /**
     * The originator&#39;s identification code. Exists only for SEPA money transfer transactions (\&quot;Überweisung\&quot;).
     * @DTA\Data(field="counterpartDebitorId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart_debitor_id;

    /**
     * Transaction type, according to the bank. If set, this will contain a German term that you can display to the user. Some examples of common values are: \&quot;Lastschrift\&quot;, \&quot;Auslands&amp;uuml;berweisung\&quot;, \&quot;Geb&amp;uuml;hren\&quot;, \&quot;Zinsen\&quot;. The maximum possible length of this field is 255 characters.
     * @DTA\Data(field="type")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $type;

    /**
     * ZKA business transaction code which relates to the transaction&#39;s type. Possible values range from 1 through 999. If no information about the ZKA type code is available, then this field will be null.
     * @DTA\Data(field="typeCodeZka")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $type_code_zka;

    /**
     * SWIFT transaction type code. If no information about the SWIFT code is available, then this field will be null.
     * @DTA\Data(field="typeCodeSwift")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $type_code_swift;

    /**
     * SEPA purpose code, according to ISO 20022
     * @DTA\Data(field="sepaPurposeCode")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $sepa_purpose_code;

    /**
     * Bank transaction code, according to ISO 20022
     * @DTA\Data(field="bankTransactionCode")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $bank_transaction_code;

    /**
     * Transaction primanota (bank side identification number)
     * @DTA\Data(field="primanota")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $primanota;

    /**
     * @DTA\Data(field="category")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\TransactionCategory::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\TransactionCategory::class})
     * @var \App\DTO\TransactionCategory|null
     */
    public $category;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Label&lt;br/&gt; Array of assigned labels
     * @DTA\Data(field="labels")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection323::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection323::class})
     * @var \App\DTO\Collection323|null
     */
    public $labels;

    /**
     * While finAPI uses a well-elaborated algorithm for uniquely identifying transactions, there is still the possibility that during an account update, a transaction that was imported previously may be imported a second time as a new transaction. For example, this can happen if some transaction data changes on the bank server side. However, finAPI also includes an algorithm of identifying such \&quot;potential duplicate\&quot; transactions. If this field is set to true, it means that finAPI detected a similar transaction that might actually be the same. It is recommended to communicate this information to the end user, and give him an option to delete the transaction in case he confirms that it really is a duplicate.
     * @DTA\Data(field="isPotentialDuplicate")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_potential_duplicate;

    /**
     * Indicating whether this transaction is an adjusting entry (&#39;Zwischensaldo&#39;).&lt;br/&gt;&lt;br/&gt;Adjusting entries do not originate from the bank, but are added by finAPI during an account update when the bank reported account balance does not add up to the set of transactions that finAPI receives for the account. In this case, the adjusting entry will fix the deviation between the balance and the received transactions so that both adds up again.&lt;br/&gt;&lt;br/&gt;Possible causes for such deviations are:&lt;br/&gt;- Inconsistencies in how the bank calculates the balance, for instance when not yet booked transactions are already included in the balance, but not included in the set of transactions&lt;br/&gt;- Gaps in the transaction history that finAPI receives, for instance because the account has not been updated for a while and older transactions are no longer available
     * @DTA\Data(field="isAdjustingEntry")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_adjusting_entry;

    /**
     * Indicating whether this transaction is &#39;new&#39; or not. Any newly imported transaction will have this flag initially set to true. How you use this field is up to your interpretation. For example, you might want to set it to false once a user has clicked on/seen the transaction. You can change this flag to &#39;false&#39; with the PATCH method.
     * @DTA\Data(field="isNew")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_new;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Date of transaction import.
     * @DTA\Data(field="importDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $import_date;

    /**
     * Sub-transactions identifiers (if this transaction is split)
     * @DTA\Data(field="children")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection324::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection324::class})
     * @var \App\DTO\Collection324|null
     */
    public $children;

    /**
     * @DTA\Data(field="paypalData")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\TransactionPaypalData::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\TransactionPaypalData::class})
     * @var \App\DTO\TransactionPaypalData|null
     */
    public $paypal_data;

    /**
     * End-To-End reference
     * @DTA\Data(field="endToEndReference")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $end_to_end_reference;

    /**
     * Compensation Amount. Sum of reimbursement of out-of-pocket expenses plus processing brokerage in case of a national return / refund debit as well as an optional interest equalisation. Exists predominantly for SEPA direct debit returns.
     * @DTA\Data(field="compensationAmount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $compensation_amount;

    /**
     * Original Amount of the original direct debit. Exists predominantly for SEPA direct debit returns.
     * @DTA\Data(field="originalAmount")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $original_amount;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Currency&lt;br/&gt; Currency of the original amount in ISO 4217 format. This field can be null if not explicitly provided the bank. In this case it can be assumed as account’s currency.
     * @DTA\Data(field="originalCurrency")
     * @DTA\Strategy(name="Object", options={"type":Currency::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":Currency::class})
     * @var Currency|null
     */
    public $original_currency;

    /**
     * Payer&#39;s/debtor&#39;s reference party (in the case of a credit transfer) or payee&#39;s/creditor&#39;s reference party (in the case of a direct debit)
     * @DTA\Data(field="differentDebitor")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $different_debitor;

    /**
     * Payee&#39;s/creditor&#39;s reference party (in the case of a credit transfer) or payer&#39;s/debtor&#39;s reference party (in the case of a direct debit)
     * @DTA\Data(field="differentCreditor")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $different_creditor;

}
