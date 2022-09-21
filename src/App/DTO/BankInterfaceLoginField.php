<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a bank&#39;s login credential field
 */
class BankInterfaceLoginField
{
    /**
     * Contains a German label for the input field that you should provide to the user. Also, these labels are used to identify login fields on the API-level, when you pass credentials to the service.
     * @DTA\Data(field="label")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $label;

    /**
     * Whether this field has to be treated as a secret. In this case your application should use a password input field instead of a cleartext field.
     * @DTA\Data(field="isSecret")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_secret;

    /**
     * This field depicts whether the given credential is volatile. If a field is volatile, it means that the value for the field, which is provided by the user, is valid only for a single authentication and then gets invalidated on bank-side. If a login credential field is volatile, it is not possible to store it in finAPI, as stored credentials will never work for future authentications.
     * @DTA\Data(field="isVolatile")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_volatile;

    /**
     * Indicates whether this is a mandatory or optional login field. We recommend showing all login fields to the users (mandatory and optional).
     * @DTA\Data(field="isMandatory")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_mandatory;

}
