<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Set of identifiers (in ascending order)
 */
class IdentifierList
{
    /**
     * Set of identifiers (in ascending order)
     * @DTA\Data(field="identifiers")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection539::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection539::class})
     * @var \App\DTO\Collection539|null
     */
    public $identifiers;

}
