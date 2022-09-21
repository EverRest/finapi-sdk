<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for deleteAllTransactions
 */
class DeleteAllTransactionsParameterData
{
    /**
     * Some HTTP clients do not support the HTTP methods PATCH or DELETE. If you are using such a client in your application, you can use a POST request instead with this header indicating the originally intended HTTP method. POST Requests having this  header set will be treated either as PATCH or DELETE by the finAPI servers.
     * @DTA\Data(subset="header", field="X-HTTP-Method-Override", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_http_method_override;

    /**
     * When passing &#39;true&#39;, then finAPI will make sure to not re-import deleted transactions on future account updates. When &#39;false&#39;, then deleted transactions might be re-imported. Default value for this parameter is &#39;false&#39;.
     * @DTA\Data(subset="query", field="rememberDeletion", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $remember_deletion;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;If specified, then only those transactions are being deleted whose &#39;finapiBookingDate&#39; is equal to or earlier to the given date. The date may not be in future. If not specified, then no date limitation will be in place for the deletion.
     * @DTA\Data(subset="query", field="maxDeletionDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $max_deletion_date;

    /**
     * When passing &#39;true&#39;, then only those transactions are being deleted where at least one of the following holds true: &lt;br/&gt;1. The transaction belongs to an account of a test bank &lt;br/&gt;2. The transaction&#39;s &#39;potentialDuplicate&#39; flag is set to TRUE&lt;br/&gt;3. The transaction is an adjusting entry (&#39;Zwischensaldo&#39; transaction) that was added by finAPI&lt;br/&gt; When passing &#39;false&#39;, then finAPI will delete transactions independent of these characteristics. The default value for this parameter is &#39;true&#39;.
     * @DTA\Data(subset="query", field="safeMode", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"bool"})
     * @var bool|null
     */
    public $safe_mode;

    /**
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * A comma-separated list of account identifiers. If specified, then only transactions whose account&#39;s identifier is included in this list will be get deleted. The maximum number of identifiers is 1000.
     * @DTA\Data(subset="query", field="accountIds", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $account_ids;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD&#39;&lt;br/&gt;If specified, then only those transactions are being deleted whose &#39;importDate&#39; is later than or equal to the given date. The date may not be in future. This is useful e.g. if a bank returns incorrect transactions and then fixes that issue. Then you could put the date when the error was first observed as &#39;minImportDate&#39;. This would lead to deletion of all transactions after the issue was introduced and allow finAPI to refetch them from scratch. This only works if safeMode is set to false and &#39;rememberDeletion&#39; is undefined or set to false. You also can not use this parameter alongside &#39;maxDeletionDate&#39;.
     * @DTA\Data(subset="query", field="minImportDate", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $min_import_date;

}
