<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for pagination information
 */
class Paging
{
    /**
     * Current page number
     * @DTA\Data(field="page")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @DTA\Validator(name="GreaterThan", options={"min":1, "inclusive":true})
     * @var int|null
     */
    public $page;

    /**
     * Current page size (number of entries in this page)
     * @DTA\Data(field="perPage")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @DTA\Validator(name="GreaterThan", options={"min":1, "inclusive":true})
     * @var int|null
     */
    public $per_page;

    /**
     * Total number of pages
     * @DTA\Data(field="pageCount")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @DTA\Validator(name="GreaterThan", options={"min":0, "inclusive":true})
     * @var int|null
     */
    public $page_count;

    /**
     * Total number of entries across all pages
     * @DTA\Data(field="totalCount")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @DTA\Validator(name="GreaterThan", options={"min":0, "inclusive":true})
     * @var int|null
     */
    public $total_count;

}
