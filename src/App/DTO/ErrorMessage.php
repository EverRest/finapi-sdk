<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Response type when a service call was not successful. Contains details about the error(s) that occurred.
 */
class ErrorMessage
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; ErrorDetails&lt;br/&gt; List of errors
     * @DTA\Data(field="errors")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection561::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection561::class})
     * @var \App\DTO\Collection561|null
     */
    public $errors;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Server date of when the error(s) occurred
     * @DTA\Data(field="date")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $date;

    /**
     * ID of the request that caused this error. This is either what you have passed for the header &#39;X-Request-Id&#39;, or an auto-generated ID in case you didn&#39;t pass any value for that header.&lt;br/&gt;&lt;br/&gt;
     * @DTA\Data(field="requestId")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $request_id;

    /**
     * The service endpoint that was called
     * @DTA\Data(field="endpoint")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $endpoint;

    /**
     * Information about the authorization context of the service call
     * @DTA\Data(field="authContext")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $auth_context;

    /**
     * BLZ and name (in format \&quot;&lt;BLZ&gt; - &lt;name&gt;\&quot;) of a bank that was used for the original request
     * @DTA\Data(field="bank")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $bank;

}
