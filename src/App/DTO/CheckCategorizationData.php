<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Transactions data for categorization check
 */
class CheckCategorizationData
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; CheckCategorizationTransactionData&lt;br/&gt; Set of transaction data
     * @DTA\Data(field="transactionData")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection82::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection82::class})
     * @var \App\DTO\Collection82|null
     */
    public $transaction_data;

}
