<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Request password change parameters
 */
class RequestPasswordChangeParams
{
    /**
     * User identifier
     * @DTA\Data(field="userId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[a-zA-Z0-9\\-_\\.\\+@]*/"})
     * @var string|null
     */
    public $user_id;

}
