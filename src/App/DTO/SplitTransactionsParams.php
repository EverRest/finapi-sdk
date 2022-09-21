<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Set of logical sub-transactions that a transaction should get split into
 */
class SplitTransactionsParams
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; SubTransactionParams&lt;br/&gt; List of sub-transactions
     * @DTA\Data(field="subTransactions")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection35::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection35::class})
     * @var \App\DTO\Collection35|null
     */
    public $sub_transactions;

}
