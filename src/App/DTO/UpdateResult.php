<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for a status of bank connection update
 */
class UpdateResult
{
    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; UpdateResultStatus&lt;br/&gt; Note that &#39;OK&#39; just means that finAPI could successfully connect and log in to the bank server. However, it does not necessarily mean that all accounts could be updated successfully. For the latter, please refer to the &#39;status&#39; field of the Account resource.
     * @DTA\Data(field="result")
     * @DTA\Strategy(name="Object", options={"type":UpdateResultStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":UpdateResultStatus::class})
     * @var UpdateResultStatus|null
     */
    public $result;

    /**
     * In case the update result is not &lt;code&gt;OK&lt;/code&gt;, this field may contain an error message with details about why the update failed (it is not guaranteed that a message is available though). In case the update result is &lt;code&gt;OK&lt;/code&gt;, the field will always be null.
     * @DTA\Data(field="errorMessage")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $error_message;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; ErrorType&lt;br/&gt; In case the update result is not &lt;code&gt;OK&lt;/code&gt;, this field contains the type of the error that occurred. BUSINESS means that the bank server responded with a non-technical error message for the user. TECHNICAL means that some internal error has occurred in finAPI or at the bank server.
     * @DTA\Data(field="errorType")
     * @DTA\Strategy(name="Object", options={"type":ErrorType::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":ErrorType::class})
     * @var ErrorType|null
     */
    public $error_type;

    /**
     * &lt;strong&gt;Format:&lt;/strong&gt; &#39;YYYY-MM-DD HH:MM:SS.SSS&#39; (german time)&lt;br/&gt;Time of the update.
     * @DTA\Data(field="timestamp")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $timestamp;

}
