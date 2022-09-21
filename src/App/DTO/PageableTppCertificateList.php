<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for bank certificate information with paging information
 */
class PageableTppCertificateList
{
    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TppCertificate&lt;br/&gt; List of certificates
     * @DTA\Data(field="tppCertificates")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection66::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection66::class})
     * @var \App\DTO\Collection66|null
     */
    public $tpp_certificates;

}
