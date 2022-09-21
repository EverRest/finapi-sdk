<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for getUserList
 */
class GetUserListParameterData
{
    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a user&#39;s last active date, e.g. &#39;2016-01-01&#39;. If specified, then only users whose &#39;lastActiveDate&#39; is not null, and is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minLastActiveDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_last_active_date;

    /**
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM&#39;&lt;br/&gt;Minimum bound for the monthly stats (&#x3D;oldest month that should be included). If not specified, then the monthly stats will go back up to the first month in which the user existed (date of the user&#39;s registration). Note that this field is only regarded if &#39;includeMonthlyStats&#39; &#x3D; true.
     * @DTA\Data(subset="query", field="monthlyStatsStartDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $monthly_stats_start_date;

    /**
     * A value of X means that the service will return only those users which had at least X bank connections imported at any time within the returned monthly stats set. This field is only regarded when &#39;includeMonthlyStats&#39; is set to &#39;true&#39;. The default value for this field is 0.
     * @DTA\Data(subset="query", field="minBankConnectionCountInMonthlyStats", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @var int|null
     */
    public $min_bank_connection_count_in_monthly_stats;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a user&#39;s deletion date, e.g. &#39;2016-01-01&#39;. If specified, then only users whose &#39;deletionDate&#39; is not null, and is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minDeletionDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_deletion_date;

    /**
     * The identifier of a user to search for. If specified, then only the user with the given id will be regarded. If no user can be found for the passed userId (because the user was deleted or his username was misspelled), then the result list will be empty.
     * @DTA\Data(subset="query", field="userId", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $user_id;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a user&#39;s last active date, .g. &#39;2016-01-01&#39;. If specified, then only users whose &#39;lastActiveDate&#39; is null, or is equal to or earlier than the given date will be regarded.
     * @DTA\Data(subset="query", field="maxLastActiveDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_last_active_date;

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
     * Whether to include the &#39;monthlyStats&#39; for the returned users. If not specified, then the field defaults to &#39;false&#39;.
     * @DTA\Data(subset="query", field="includeMonthlyStats", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $include_monthly_stats;

    /**
     * If NOT specified, then the service will regard both active and deleted users in the search. If set to &#39;true&#39;, then ONLY deleted users will be regarded. If set to &#39;false&#39;, then ONLY active users will be regarded.
     * @DTA\Data(subset="query", field="isDeleted", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_deleted;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a user&#39;s deletion date, e.g. &#39;2016-01-01&#39;. If specified, then only users whose &#39;deletionDate&#39; is null, or is equal to or earlier than the given date will be regarded.
     * @DTA\Data(subset="query", field="maxDeletionDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_deletion_date;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM&#39;&lt;br/&gt;Maximum bound for the monthly stats (&#x3D;latest month that should be included). If not specified, then the monthly stats will go up to either the current month (for active users), or up to the month of deletion (for deleted users). Note that this field is only regarded if  &#39;includeMonthlyStats&#39; &#x3D; true.
     * @DTA\Data(subset="query", field="monthlyStatsEndDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $monthly_stats_end_date;

    /**
     * If NOT specified, then the service will regard both locked and not locked users in the search. If set to &#39;true&#39;, then ONLY locked users will be regarded. If set to &#39;false&#39;, then ONLY not locked users will be regarded.
     * @DTA\Data(subset="query", field="isLocked", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_locked;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Lower bound for a user&#39;s registration date, e.g. &#39;2016-01-01&#39;. If specified, then only users whose &#39;registrationDate&#39; is equal to or later than the given date will be regarded.
     * @DTA\Data(subset="query", field="minRegistrationDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_registration_date;

    /**
     * Result page that you want to retrieve
     * @DTA\Data(subset="query", field="page", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"int"})
     * @DTA\Validator(subset="query", name="GreaterThan", options={"min":1, "inclusive":true})
     * @var int|null
     */
    public $page;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;Upper bound for a user&#39;s registration date, e.g. &#39;2016-01-01&#39;. If specified, then only users whose &#39;registrationDate&#39; is equal to or earlier than the given date will be regarded.
     * @DTA\Data(subset="query", field="maxRegistrationDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_registration_date;

    /**
     * Determines the order of the results. You can order the results by &#39;userId&#39;. The default order for this service is &#39;userId,asc&#39;. The general format is: &#39;property[,asc|desc]&#39;, with &#39;asc&#39; being the default value.
     * @DTA\Data(subset="query", field="order", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @var string[]|null
     */
    public $order;

}
