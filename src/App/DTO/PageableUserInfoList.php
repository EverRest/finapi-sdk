<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for users information with paging information
 */
class PageableUserInfoList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; UserInfo&lt;br/&gt; List of users information
     * @DTA\Data(field="users")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection482::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection482::class})
     * @var \App\DTO\Collection482|null
     */
    public $users;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
