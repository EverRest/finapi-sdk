<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for getDailyBalances
 */
class GetDailyBalancesParameterData
{
    /**
     * Whether finAPI should project the first and last actually existing balance of an account into the past and future. When passing &#39;true&#39;, then the result will always contain a daily balance for every day of the entire requested date range, even for days before the first actually existing balance, resp. after the last actually existing balance. Those days will have the same balance as the day of the first actual balance, resp. last actual balance, i.e. the first/last balance will be infinitely projected into the past/the future. When passing &#39;false&#39;, then the result will contain daily balances only from the day on where the first actual balance exists for any of the regarded accounts, and only up to the day where the last actual balance exists for any of the regarded accounts. Note that when in this case there are no actual balances within the requested date range, then an empty array will be returned. Default value for this parameter is &#39;true&#39;.
     * @DTA\Data(subset="query", field="withProjection", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $with_projection;

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
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for the date range to be returned. Note that the requested date range [startDate .. endDate] may not exceed 1 year (366 days - considering Leap Years too). If endDate is not specified, it defaults to today&#39;s date.
     * @DTA\Data(subset="query", field="endDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $end_date;

    /**
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * A comma-separated list of (non-security) account identifiers. If no accounts are specified, all (non-security) accounts of the user are regarded.
     * @DTA\Data(subset="query", field="accountIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $account_ids;

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
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for the date range to be returned. Note that the requested date range [startDate .. endDate] may not exceed 1 year (366 days - considering Leap Years too).If startDate is not specified, it defaults to the endDate minus one month.
     * @DTA\Data(subset="query", field="startDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $start_date;

    /**
     * Determines the order of the results. You can order the results by &#39;date&#39;, &#39;balance&#39;, &#39;income&#39; or &#39;spending&#39;. The default order for this service is &#39;date,asc&#39;. You can also order by multiple properties. In that case the order of the parameters passed is important. Example: &#39;/accounts/dailyBalances?order&#x3D;date,desc&amp;order&#x3D;balance,asc&#39; will return daily balances ordered by &#39;date&#39; (descending), where items with the same &#39;date&#39; are ordered by &#39;balance&#39; (ascending). The general format is: &#39;property[,asc|desc]&#39;, with &#39;asc&#39; being the default value.
     * @DTA\Data(subset="query", field="order", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @var string[]|null
     */
    public $order;

}
