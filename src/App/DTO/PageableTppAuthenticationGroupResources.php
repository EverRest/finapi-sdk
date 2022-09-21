<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * TPP Authentication groups with paging information
 */
class PageableTppAuthenticationGroupResources
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TppAuthenticationGroup&lt;br/&gt; List of received TPP authentication groups
     * @DTA\Data(field="tppAuthenticationGroups")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection439::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection439::class})
     * @var \App\DTO\Collection439|null
     */
    public $tpp_authentication_groups;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
