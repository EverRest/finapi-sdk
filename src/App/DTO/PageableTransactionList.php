<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a page of transactions, with data about the total count of transactions and their balance with paging information
 */
class PageableTransactionList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Transaction&lt;br/&gt; Array of transactions (for the requested page)
     * @DTA\Data(field="transactions")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection293::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection293::class})
     * @var \App\DTO\Collection293|null
     */
    public $transactions;

    /**
     * @DTA\Data(field="paging")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\DailyBalanceListPaging::class})
     * @var \App\DTO\DailyBalanceListPaging|null
     */
    public $paging;

    /**
     * The total income of all transactions (across all pages)
     * @DTA\Data(field="income")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $income;

    /**
     * The total spending of all transactions (across all pages)
     * @DTA\Data(field="spending")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $spending;

    /**
     * The total sum of all transactions (across all pages)
     * @DTA\Data(field="balance")
     * @DTA\Validator(name="Scalar", options={"type":"float"})
     * @var float|null
     */
    public $balance;

}
