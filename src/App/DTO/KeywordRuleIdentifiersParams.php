<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Keyword Rule Identifier params
 */
class KeywordRuleIdentifiersParams
{
    /**
     * List of identifiers
     * @DTA\Data(field="ids")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection162::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection162::class})
     * @var \App\DTO\Collection162|null
     */
    public $ids;

}
