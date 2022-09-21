<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Label resources with paging information
 */
class PageableLabelList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Label&lt;br/&gt; Labels
     * @DTA\Data(field="labels")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection198::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection198::class})
     * @var \App\DTO\Collection198|null
     */
    public $labels;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
