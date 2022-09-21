<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Execute password change parameters
 */
class ExecutePasswordChangeParams
{
    /**
     * User identifier
     * @DTA\Data(field="userId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[a-zA-Z0-9\\-_\\.\\+@]*/"})
     * @var string|null
     */
    public $user_id;

    /**
     * User&#39;s new password. Minimum length is 6, and maximum length is 128.
     * @DTA\Data(field="password")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $password;

    /**
     * Decrypted password change token (the token that you received from the /users/requestPasswordChange service, decrypted with your data decryption key)
     * @DTA\Data(field="passwordChangeToken")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[0-9a-f\\-]*/"})
     * @var string|null
     */
    public $password_change_token;

}
