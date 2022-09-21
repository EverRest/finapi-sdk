<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 */
class BadCredentialsError
{
    /**
     * Error type
     * @DTA\Data(field="error")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $error;

    /**
     * Error description
     * @DTA\Data(field="error_description")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $error_description;

}
