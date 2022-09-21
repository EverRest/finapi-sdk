<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Login credential
 */
class LoginCredential
{
    /**
     * The login field label, as defined by the respective bank interface.
     * @DTA\Data(field="label")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $label;

    /**
     * The value for the login field
     * @DTA\Data(field="value")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $value;

}
