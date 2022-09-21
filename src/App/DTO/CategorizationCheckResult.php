<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 */
class CategorizationCheckResult
{
    /**
     * The transaction identifier. The transactionId of the transaction that was passed to the service as input. This is not an actual ID of a stored transaction in finAPI, as the checkCategorization service doesn&#39;t store any data.
     * @DTA\Data(field="transactionId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $transaction_id;

    /**
     * @DTA\Data(field="category")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\CategorizationCheckResultCategory::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\CategorizationCheckResultCategory::class})
     * @var \App\DTO\CategorizationCheckResultCategory|null
     */
    public $category;

}
