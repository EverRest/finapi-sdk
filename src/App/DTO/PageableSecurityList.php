<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for page of securities
 */
class PageableSecurityList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Security&lt;br/&gt; List of securities
     * @DTA\Data(field="securities")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection454::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection454::class})
     * @var \App\DTO\Collection454|null
     */
    public $securities;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
