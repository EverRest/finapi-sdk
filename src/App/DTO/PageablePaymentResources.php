<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Payment resources with paging information
 */
class PageablePaymentResources
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Payment&lt;br/&gt; List of received account payments
     * @DTA\Data(field="payments")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection466::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection466::class})
     * @var \App\DTO\Collection466|null
     */
    public $payments;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
