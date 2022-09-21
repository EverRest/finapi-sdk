<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * &lt;strong&gt;Type:&lt;/strong&gt; TppAuthenticationGroup&lt;br/&gt; TPP Authentication Group which the bank interface is connected to
 */
class BankInterfaceTppAuthenticationGroup
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
