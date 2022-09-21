<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for TPP client credentials information with paging information
 */
class PageableTppCredentialResources
{
    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TppCredentials&lt;br/&gt; List of TPP client credentials
     * @DTA\Data(field="tppCredentials")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection57::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection57::class})
     * @var \App\DTO\Collection57|null
     */
    public $tpp_credentials;

}
