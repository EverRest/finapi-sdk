<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Error details
 */
class ErrorDetails
{
    /**
     * Error message
     * @DTA\Data(field="message")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $message;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; ErrorCode&lt;br/&gt; Error code. See the documentation of the individual services for details about what values may be returned.
     * @DTA\Data(field="code")
     * @DTA\Strategy(name="Object", options={"type":ErrorCode::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":ErrorCode::class})
     * @var ErrorCode|null
     */
    public $code;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; ErrorType&lt;br/&gt; Error type. BUSINESS errors depict error messages in the language of the bank (or the preferred language) for the user, e.g. from a bank server. TECHNICAL errors are meant to be read by developers and depict internal errors.
     * @DTA\Data(field="type")
     * @DTA\Strategy(name="Object", options={"type":ErrorType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":ErrorType::class})
     * @var ErrorType|null
     */
    public $type;

    /**
     * @DTA\Data(field="multiStepAuthentication")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\ErrorDetailsMultiStepAuthentication::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\ErrorDetailsMultiStepAuthentication::class})
     * @var \App\DTO\ErrorDetailsMultiStepAuthentication|null
     */
    public $multi_step_authentication;

}
