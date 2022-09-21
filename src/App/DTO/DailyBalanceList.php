<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Contains a list of daily balances
 */
class DailyBalanceList
{
    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;The latestCommonBalanceTimestamp is the latest timestamp at which all regarded  accounts have been up to date. Only balances with their date being smaller than the latestCommonBalanceTimestamp are reliable. Example: A user has two accounts: A (last update today, so balance from today) and B (last update yesterday, so balance from yesterday). The service /accounts/dailyBalances will return a balance for yesterday and for today, with the info latestCommonBalanceTimestamp&#x3D;yesterday. Since account B might have received transactions this morning, today&#39;s balance might be wrong. So either make sure that all regarded accounts are up to date before calling this service, or use the results carefully in combination with the latestCommonBalanceTimestamp.
     * @DTA\Data(field="latestCommonBalanceTimestamp")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $latest_common_balance_timestamp;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; DailyBalance&lt;br/&gt; List of daily balances for the requested period and account(s)
     * @DTA\Data(field="dailyBalances")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection546::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection546::class})
     * @var \App\DTO\Collection546|null
     */
    public $daily_balances;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

}
