<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters for getAndSearchTppAuthenticationGroups
 */
class GetAndSearchTppAuthenticationGroupsParameterData
{
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
     * With any API call, you can pass a request ID. The request ID can be an arbitrary string with up to 255 characters. Passing a longer string will result in an error. If you don&#39;t pass a request ID for a call, finAPI will generate a random ID internally. The request ID is always returned back in the response of a service, as a header with name &#39;X-Request-Id&#39;. We highly recommend to always pass a (preferably unique) request ID, and include it into your client application logs whenever you make a request or receive a response (especially in the case of an error response). finAPI is also logging request IDs on its end. Having a request ID can help the finAPI support team to work more efficiently and solve tickets faster.
     * @DTA\Data(subset="header", field="X-Request-Id", nullable=true)
     * @DTA\Strategy(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="header", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $x_request_id;

    /**
     * Only the tpp authentication groups with name matching the given one should appear in the result list
     * @DTA\Data(subset="query", field="name", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $name;

    /**
     * A comma-separated list of TPP authentication group identifiers. If specified, then only TPP authentication groups whose identifier match any of the given identifiers will be regarded. The maximum number of identifiers is 1000.
     * @DTA\Data(subset="query", field="ids", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"int", "format":"multi"})
     * @var int[]|null
     */
    public $ids;

    /**
     * Search by connected banks: only the banks with name matching the given one should appear in the result list
     * @DTA\Data(subset="query", field="bankName", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $bank_name;

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
     * Search by connected banks: only the banks with BLZ matching the given one should appear in the result list
     * @DTA\Data(subset="query", field="bankBlz", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @DTA\Validator(subset="query", name="QueryStringScalar", options={"type":"string"})
     * @var string|null
     */
    public $bank_blz;

    /**
     * Determines the order of the results. You can order the results by &#39;id&#39; and &#39;name&#39;. The default order for this service is &#39;id,asc&#39;. The general format is: &#39;property[,asc|desc]&#39;, with &#39;asc&#39; being the default value.
     * @DTA\Data(subset="query", field="order", nullable=true)
     * @DTA\Strategy(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @DTA\Validator(subset="query", name="QueryStringScalarArray", options={"type":"string", "format":"multi"})
     * @var string[]|null
     */
    public $order;

}
