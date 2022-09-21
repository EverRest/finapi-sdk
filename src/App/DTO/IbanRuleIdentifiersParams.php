<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * IBAN Rule Identifier params
 */
class IbanRuleIdentifiersParams
{
    /**
     * List of identifiers
     * @DTA\Data(field="ids")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection180::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection180::class})
     * @var \App\DTO\Collection180|null
     */
    public $ids;

}
