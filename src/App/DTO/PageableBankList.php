<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for banks with paging information
 */
class PageableBankList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Bank&lt;br/&gt; Banks
     * @DTA\Data(field="banks")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection504::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection504::class})
     * @var \App\DTO\Collection504|null
     */
    public $banks;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
