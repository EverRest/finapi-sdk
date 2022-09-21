<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Standing order resources with paging information
 */
class PageableStandingOrderResources
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; StandingOrder&lt;br/&gt; List of standing orders
     * @DTA\Data(field="standingOrders")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection91::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection91::class})
     * @var \App\DTO\Collection91|null
     */
    public $standing_orders;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
