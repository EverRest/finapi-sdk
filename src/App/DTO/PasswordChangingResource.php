<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Password changing details
 */
class PasswordChangingResource
{
    /**
     * User identifier
     * @DTA\Data(field="userId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_id;

    /**
     * User&#39;s email, encrypted. Decrypt with your data decryption key. If the user has no email set, then this field will be null.
     * @DTA\Data(field="userEmail")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_email;

    /**
     * Encrypted password change token. Decrypt this token with your data decryption key, and pass the decrypted token to the /users/executePasswordChange service to set a new password for the user.
     * @DTA\Data(field="passwordChangeToken")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $password_change_token;

}
