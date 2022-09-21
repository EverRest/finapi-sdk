<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * User&#39;s verification status
 */
class VerificationStatusResource
{
    /**
     * User&#39;s identifier
     * @DTA\Data(field="userId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $user_id;

    /**
     * User&#39;s verification status
     * @DTA\Data(field="isUserVerified")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $is_user_verified;

}
