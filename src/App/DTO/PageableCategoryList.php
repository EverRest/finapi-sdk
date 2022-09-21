<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for categories with paging information
 */
class PageableCategoryList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Category&lt;br/&gt; Categories
     * @DTA\Data(field="categories")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection213::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection213::class})
     * @var \App\DTO\Collection213|null
     */
    public $categories;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
