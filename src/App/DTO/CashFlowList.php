<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Cash flows
 */
class CashFlowList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; CashFlow&lt;br/&gt; Array of cash flows
     * @DTA\Data(field="cashFlows")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection490::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection490::class})
     * @var \App\DTO\Collection490|null
     */
    public $cash_flows;

    /**
     * The total income
     * @DTA\Data(field="totalIncome")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $total_income;

    /**
     * The total spending
     * @DTA\Data(field="totalSpending")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $total_spending;

    /**
     * The total balance
     * @DTA\Data(field="totalBalance")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $total_balance;

}
