<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for data of multiple transactions
 */
class TransactionList
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; Transaction&lt;br/&gt; List of transactions
     * @DTA\Data(field="transactions")
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\Transaction[]|null
     */
    public $transactions;

}
