<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for getCashFlows
 */
class GetCashFlowsParameterData
{
    /**
     * If specified, then only transactions whose amount is equal to or greater than the given amount will be regarded. Can contain a positive or negative number with at most two decimal places. Examples: -300.12, or 90.95
     * @DTA\Data(subset="query", field="minAmount", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @var float|null
     */
    public $min_amount;

    /**
     * If specified, then only those transactions will be contained in the result whose purpose field contains the given search string. Note that the search is case insensitive.NOTE: If the given search string consists of several terms (separated by whitespace), then ALL of these terms must be contained in the purpose for a transaction to get included into the result.
     * @DTA\Data(subset="query", field="purpose", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $purpose;

    /**
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a transaction&#39;s import date, e.g. &#39;2016-01-01&#39;. If specified, then only transactions whose &#39;importDate&#39; is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minImportDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_import_date;

    /**
     * If it is true, then the income, spending, balance and count of transactions of a main category results from all transactions that have either this (main) category or any of its subcategories assigned (of course all transactions depends from the other filtering settings); If it is false, then the income, spending, balance and count of transactions of a main category only results from the transactions that have exactly this (main) category assigned. Default value for this parameter is &#39;true&#39;.
     * @DTA\Data(subset="query", field="includeSubCashFlows", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $include_sub_cash_flows;

    /**
     * If specified, then only transactions that have their &#39;isNew&#39; flag set to true/false will be regarded for the cash flow calculations.
     * @DTA\Data(subset="query", field="isNew", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_new;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a transaction&#39;s booking date as returned by the bank (&#x3D; original booking date), e.g. &#39;2016-01-01&#39;. If specified, then only transactions whose &#39;bankBookingDate&#39; is equal to or earlier than the given date will be regarded.
     * @DTA\Data(subset="query", field="maxBankBookingDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_bank_booking_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a transaction&#39;s booking date as set by finAPI, e.g. &#39;2016-01-01&#39;. For details about the meaning of the finAPI booking date, please see the field&#39;s documentation in the service&#39;s response.
     * @DTA\Data(subset="query", field="minFinapiBookingDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_finapi_booking_date;

    /**
     * If specified, then only transactions that contain the search term in their purpose or counterpart fields will be contained in the result. Note that the search is case insensitive.
     * @DTA\Data(subset="query", field="search", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $search;

    /**
     * If specified, then the result will contain only those cash flows that relate to the given categories. Note that the cash flow for a category may include/exclude the cash flows of its sub-categories, depending on the &#39;includeSubCashFlows&#39; setting. To include the cash flow of not categorized transactions, pass the value &#39;0&#39; as categoryId. Note: When this parameter is NOT set, then the result will contain a cash flow for all categories that have transactions associated to them (this includes the &#39;null&#39;-category for the cash flow of not categorized transactions), more precisely: transactions that fulfill the filter criteria. Categories that have no associated transactions according to the filter criteria will not appear in the result. However, when you specify this parameter, then all specified categories will have a cash flow entry in the result, even if there are no associated transactions for the category (the cash flow will have income, spending and balance all set to zero).
     * @DTA\Data(subset="query", field="categoryIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $category_ids;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a transaction&#39;s booking date as set by finAPI, e.g. &#39;2016-01-01&#39;. For details about the meaning of the finAPI booking date, please see the field&#39;s documentation in the service&#39;s response.
     * @DTA\Data(subset="query", field="maxFinapiBookingDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_finapi_booking_date;

    /**
     * A comma-separated list of label identifiers. If specified, then only transactions that have been marked with at least one of the given labels will be contained in the result.
     * @DTA\Data(subset="query", field="labelIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $label_ids;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a transaction&#39;s import date, e.g. &#39;2016-01-01&#39;. If specified, then only transactions whose &#39;importDate&#39; is equal to or earlier than the given date will be regarded.
     * @DTA\Data(subset="query", field="maxImportDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_import_date;

    /**
     * A comma-separated list of account identifiers. If specified, then only transactions that relate to the given accounts will be regarded. If not specified, then all accounts will be regarded.
     * @DTA\Data(subset="query", field="accountIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $account_ids;

    /**
     * The counterpart is the person or institution that received your payment, or that you made the payment to. If this parameter is specified, then only transactions that contain the given term in one (or more) of their counterpart fields (&#39;counterpartName&#39;, &#39;counterpartAccountNumber&#39;, &#39;counterpartIban&#39;, &#39;counterpartBic&#39; or &#39;counterpartBlz&#39;) will be contained in the result. Note that the search is case insensitive.
     * @DTA\Data(subset="query", field="counterpart", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a transaction&#39;s booking date as returned by the bank (&#x3D; original booking date), e.g. &#39;2016-01-01&#39;. If specified, then only transactions whose &#39;bankBookingDate&#39; is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minBankBookingDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_bank_booking_date;

    /**
     * If specified, then only transactions whose amount is equal to or less than the given amount will be regarded. Can contain a positive or negative number with at most two decimal places. Examples: -300.12, or 90.95
     * @DTA\Data(subset="query", field="maxAmount", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"float"})
     * @var float|null
     */
    public $max_amount;

    /**
     * If specified, then only transactions with the given direction(s) will be regarded. Use &#39;income&#39; for regarding only received payments (amount &gt;&#x3D; 0), &#39;spending&#39; for regarding only outgoing payments (amount &lt; 0), or &#39;all&#39; to regard both directions. If not specified, the direction defaults to &#39;all&#39;.
     * @DTA\Data(subset="query", field="direction", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $direction;

    /**
     * Determines the order of the results. You can order the results by &#39;income&#39;, &#39;spending&#39;, &#39;balance&#39;, &#39;category.id&#39; or &#39;category.name&#39;. The default order for this service is &#39;category.id,asc&#39;. You can also order by multiple properties. In that case the order of the parameters passed is important. Example: &#39;/cashFlows?order&#x3D;income,desc&amp;order&#x3D;spending,asc&amp;balance,desc&#39; will return as first result the category with the highest income. If two categories have the same income, it returns the category with the highest spending first (because spending is a negative value) and so on. The general format is: &#39;property[,asc|desc]&#39;, with &#39;asc&#39; being the default value.
     * @DTA\Data(subset="query", field="order", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @var string[]|null
     */
    public $order;

}
