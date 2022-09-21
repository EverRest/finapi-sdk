<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Sample data to train categorization
 */
class TrainCategorizationData
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TrainCategorizationTransactionData&lt;br/&gt; Set of transaction data (at most 100 transactions at once)
     * @DTA\Data(field="transactionData")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection227::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection227::class})
     * @var \App\DTO\Collection227|null
     */
    public $transaction_data;

    /**
     * Category identifier
     * @DTA\Data(field="categoryId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $category_id;

}
