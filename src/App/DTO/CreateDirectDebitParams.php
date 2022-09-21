<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for direct debit creation parameters
 */
class CreateDirectDebitParams
{
    /**
     * This field is only relevant when you pass multiple orders. It determines whether the orders should be processed by the bank as one collective booking (in case of &#39;false&#39;), or as single bookings (in case of &#39;true&#39;). Note that it is subject to the bank whether it will regard the field. Default value is &#39;false&#39;.
     * @DTA\Data(field="singleBooking", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $single_booking;

    /**
     * Identifier of the account that should be used for the direct debit.
     * @DTA\Data(field="accountId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $account_id;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; DirectDebitType&lt;br/&gt; Type of the direct debit; either &lt;code&gt;BASIC&lt;/code&gt; or &lt;code&gt;B2B&lt;/code&gt; (Business-To-Business).
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
     * &lt;strong&gt;Type:&lt;/strong&gt; DirectDebitOrderParams&lt;br/&gt; List of direct debit orders (may contain at most 15000 items). Please note that collective direct debit may not always be supported.
     * @DTA\Data(field="directDebits")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection124::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection124::class})
     * @var \App\DTO\Collection124|null
     */
    public $direct_debits;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Execution date for the direct debit(s). May not be in the past.
     * @DTA\Data(field="executionDate")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $execution_date;

}
