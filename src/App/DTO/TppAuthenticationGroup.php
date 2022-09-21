<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * TPP authentication group represents certain bank group and contains a set of TPP credentials which can be used with bank interface connected to this group.
 */
class TppAuthenticationGroup
{
    /**
     * TPP Authentication Group ID
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * TPP Authentication Group name
     * @DTA\Data(field="name")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $name;

}
