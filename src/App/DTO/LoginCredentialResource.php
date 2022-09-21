<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a bank login credential
 */
class LoginCredentialResource
{
    /**
     * Label for this login credential, as we suggest to show it to the user.
     * @DTA\Data(field="label")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $label;

    /**
     * Stored value for this login credential. Please NOTE:&lt;br/&gt;If your client has no license for processing banking credentials, or if this field contains a value that requires password protection (e.g. PIN), then this field will always be &#39;XXXXX&#39;.
     * @DTA\Data(field="value")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $value;

}
