<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for getAndSearchAllTransactions
 */
class GetAndSearchAllTransactionsParameterData
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
     * If specified, then only those transactions will be contained in the result whose purpose field contains the given search string (the matching works case-insensitive). If no transactions contain the search string in the purpose field, then the result will be an empty list. NOTE: If the given search string consists of several terms (separated by whitespace), then ALL of these terms must be contained in the purpose for a transaction to get included into the result.
     * @DTA\Data(subset="query", field="purpose", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $purpose;

    /**
     * If specified, then only transactions that have their &#39;isPotentialDuplicate&#39; flag set to true/false will be regarded.
     * @DTA\Data(subset="query", field="isPotentialDuplicate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_potential_duplicate;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a transaction&#39;s import date, e.g. &#39;2016-01-01&#39;. If specified, then only transactions whose &#39;importDate&#39; is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minImportDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_import_date;

    /**
     * If specified, then only transactions that have their &#39;isAdjustingEntry&#39; flag set to true/false will be regarded.
     * @DTA\Data(subset="query", field="isAdjustingEntry", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_adjusting_entry;

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
     * This parameter defines finAPI&#39;s logical view on the transactions when querying them: &#39;bankView&#39; regards only the original transactions as they were received from the bank, without considering how the transactions might have gotten split by the user (see POST /transactions/&amp;lt;id&amp;gt;/split). This means that if a transaction is split into logical sub-transactions, then the service will still regard only the original transaction, and NOT the logical sub-transactions in its processing (though for convenience, the transactions will have the data of their sub-transactions included in the response). &#39;userView&#39; by contrast regards the transactions as they exist for the user. For transactions that have not been split into logical sub-transactions, there is no difference to the \&quot;bankView\&quot;. But for transaction that have been split into logical sub-transactions, the service will ONLY regard these sub-transactions, and not the originally received transaction (though for convenience, the sub-transactions will have the identifier of their original transaction included in the response).
     * @DTA\Data(subset="query", field="view")
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $view;

    /**
     * If specified, then only those transactions will be contained in the result whose &#39;purpose&#39;, &#39;endToEndReference&#39;, or one of the counterpart fields (&#39;counterpart&#39;, &#39;counterpartAccountNumber&#39;, &#39;counterpartIban&#39;, &#39;counterpartBlz&#39;, &#39;counterpartBic&#39;, &#39;mandateReference&#39;, &#39;customerReference&#39;, &#39;creditorId&#39;, or &#39;debitorId&#39;) contain the given search string (the matching works case-insensitive). If no transactions contain the search string in any of these fields, then the result will be an empty list. NOTE: If the given search string consists of several terms (separated by whitespace), then ALL of these terms must be contained in the searched fields for a transaction to get included into the result.
     * @DTA\Data(subset="query", field="search", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $search;

    /**
     * This flag controls how the &#39;categoryIds&#39; are handled. If set to &#39;true&#39;, then all transactions with the target categories, as well as all transactions with any of their sub-categories will be regarded. If set to &#39;false&#39;, then sub-categories of a category are excluded and only those transactions are regarded whose category matches exactly the target category. The default value for this flag is &#39;true&#39;.&lt;br/&gt;&lt;br/&gt;Note that this field has an effect independent of whether you pass the &#39;categoryIds&#39; yourself, or whether the &#39;categoryIds&#39; are populated automatically based on your client&#39;s category restrictions (see GET /clientConfiguration, field &#39;categoryRestrictions&#39;).
     * @DTA\Data(subset="query", field="includeChildCategories", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $include_child_categories;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a transaction&#39;s booking date as set by finAPI, e.g. &#39;2016-01-01&#39;. For details about the meaning of the finAPI booking date, please see the field&#39;s documentation in the service&#39;s response.
     * @DTA\Data(subset="query", field="maxFinapiBookingDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_finapi_booking_date;

    /**
     * A comma-separated list of label identifiers. If specified, then only transactions that  have been marked with at least one of the given labels will be contained in the result.
     * @DTA\Data(subset="query", field="labelIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $label_ids;

    /**
     * A comma-separated list of account identifiers. If specified, then only transactions that relate to the given accounts will be regarded. If not specified, then all accounts will be regarded.
     * @DTA\Data(subset="query", field="accountIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $account_ids;

    /**
     * If specified, then only those transactions will be contained in the result whose counterpart fields (&#39;counterpart&#39;, &#39;counterpartAccountNumber&#39;, &#39;counterpartIban&#39;, &#39;counterpartBlz&#39;, &#39;counterpartBic&#39;, &#39;mandateReference&#39;, &#39;customerReference&#39;, &#39;creditorId&#39;, or &#39;debitorId&#39;) contain the given search string (the matching works case-insensitive). If no transactions contain the search string in any of the counterpart fields, then the result will be an empty list. NOTE: If the given search string consists of several terms (separated by whitespace), then ALL of these terms must be contained in the searched fields for a transaction to get included into the result.
     * @DTA\Data(subset="query", field="counterpart", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $counterpart;

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
     * Determines the order of the results. You can use the following fields for ordering the response: &#39;id&#39;, &#39;parentId&#39;, &#39;accountId&#39;, &#39;valueDate&#39;, &#39;bankBookingDate&#39;, &#39;finapiBookingDate&#39;, &#39;amount&#39;, &#39;purpose&#39;, &#39;counterpartName&#39;, &#39;counterpartAccountNumber&#39;, &#39;counterpartIban&#39;, &#39;counterpartBlz&#39;, &#39;counterpartBic&#39;, &#39;type&#39;, &#39;primanota&#39;, &#39;category.id&#39;, &#39;category.name&#39;, &#39;isPotentialDuplicate&#39;, &#39;isNew&#39; and &#39;importDate&#39;. The default order for all services is &#39;id,asc&#39;. You can also order by multiple properties. In that case the order of the parameters passed is important. Example: &#39;/transactions?order&#x3D;finapiBookingDate,desc&amp;order&#x3D;counterpartName&#39; will return the latest transactions first. If there are more transactions on the same day, then these transactions are ordered by the counterpart name (ascending). The general format is: &#39;property[,asc|desc]&#39;, with &#39;asc&#39; being the default value.
     * @DTA\Data(subset="query", field="order", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @var string[]|null
     */
    public $order;

    /**
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * If specified, then only transactions that have their &#39;isNew&#39; flag set to true/false will be regarded.
     * @DTA\Data(subset="query", field="isNew", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_new;

    /**
     * A comma-separated list of category identifiers. If specified, then the result will contain only transactions whose category is either one of the target categories, or - but only if the &#39;includeChildCategories&#39; flag is set to &#39;true&#39; - whose category is a sub-category of one of the target categories. To include transactions without any category, pass the value &#39;0&#39; as the category ID.&lt;br/&gt;&lt;br/&gt;NOTE: If your client is restricted to certain categories (see GET /clientConfiguration, field &#39;categoryRestrictions&#39;), then you may only specify categories that match your restrictions. Alternatively, you can leave this field unset, in which case finAPI will automatically populate this field with all categories that are defined in your restrictions.
     * @DTA\Data(subset="query", field="categoryIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $category_ids;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a transaction&#39;s import date, e.g. &#39;2016-01-01&#39;. If specified, then only transactions whose &#39;importDate&#39; is equal to or earlier than the given date will be regarded.
     * @DTA\Data(subset="query", field="maxImportDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_import_date;

    /**
     * Maximum number of records per page. By default it&#39;s 20. Can be at most 500.
     * @DTA\Data(subset="query", field="perPage", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="query", name="GreaterThan", options={"min":1, "inclusive":true})
     * @DTA\Validator(subset="query", name="LessThan", options={"max":500, "inclusive":true})
     * @var int|null
     */
    public $per_page;

    /**
     * A comma-separated list of transaction identifiers. If specified, then only transactions whose identifier match any of the given identifiers will be regarded. The maximum number of identifiers is 1000.
     * @DTA\Data(subset="query", field="ids", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $ids;

    /**
     * Result page that you want to retrieve.
     * @DTA\Data(subset="query", field="page", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="query", name="GreaterThan", options={"min":1, "inclusive":true})
     * @var int|null
     */
    public $page;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a transaction&#39;s booking date as returned by the bank (&#x3D; original booking date), e.g. &#39;2016-01-01&#39;. If specified, then only transactions whose &#39;bankBookingDate&#39; is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minBankBookingDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_bank_booking_date;

}
