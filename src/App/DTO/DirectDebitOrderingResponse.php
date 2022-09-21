<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Bank server&#39;s response to a direct debit order request
 */
class DirectDebitOrderingResponse
{
    /**
     * Technical message from the bank server, confirming the success of the request. Typically, you would not want to present this message to the user. Note that this field may not be set. However if it is not set, it does not necessarily mean that there was an error in processing the request.
     * @DTA\Data(field="successMessage", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $success_message;

    /**
     * In some cases, a bank server may accept the requested order, but return a warn message. This message may be of technical nature, but could also be of interest to the user.
     * @DTA\Data(field="warnMessage", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $warn_message;

    /**
     * Payment identifier. Can be used to retrieve the status of the payment (see &#39;Get payments&#39; service).
     * @DTA\Data(field="paymentId")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $payment_id;

    /**
     * Message from the bank server containing information or instructions on how to retrieve the TAN that is needed to execute the requested order. This message should be presented to the user. Note that some bank servers may limit the message to just the most crucial information, e.g. the message may contain just a single number that depicts the target TAN number on a user&#39;s TAN list. You may want to parse the challenge message for such cases and extend it with more detailed information before showing it to the user.
     * @DTA\Data(field="challengeMessage", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $challenge_message;

    /**
     * Suggestion from the bank server on how you can label your input field where the user must enter his TAN. A typical value that many bank servers give is &#39;TAN-Nummer&#39;.
     * @DTA\Data(field="answerFieldLabel", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $answer_field_label;

    /**
     * In case that the bank server has instructed the user to look up a TAN from a TAN list, this field may contain the identification number of the TAN list. However in most cases, this field is only set (i.e. not null) when the user has multiple active TAN lists.
     * @DTA\Data(field="tanListNumber", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $tan_list_number;

    /**
     * In case that the bank server has instructed the user to scan a flicker code, then this field will contain the raw data for the flicker animation as a BASE-64 string. Otherwise, this field will be not set (i.e. null). See also: &lt;a href&#x3D;&#39;https://documentation.finapi.io/access/Flicker-Code-Template.2807824454.html&#39; target&#x3D;&#39;_blank&#39;&gt;Flicker Code Template&lt;/a&gt;
     * @DTA\Data(field="opticalData", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $optical_data;

    /**
     * This field is only relevant when the field &#39;opticalData&#39; is set. It depicts whether the optical data should be processed with the use of the Reiner SCT flicker algorithm. For more details, see: &lt;a href&#x3D;&#39;https://documentation.finapi.io/access/Flicker-Code-Template.2807824454.html&#39; target&#x3D;&#39;_blank&#39;&gt;Flicker Code Template&lt;/a&gt;
     * @DTA\Data(field="opticalDataAsReinerSct")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $optical_data_as_reiner_sct;

    /**
     * In case that the &#39;photoTanData&#39; field is set (i.e. not null), this field contains the MIME type to use for interpreting the photo data (e.g.: &#39;image/png&#39;)
     * @DTA\Data(field="photoTanMimeType", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $photo_tan_mime_type;

    /**
     * In case that the bank server has instructed the user to scan a photo (or more generally speaking, any kind of QR-code-like data), then this field will contain the raw data of the photo as a BASE-64 string. Otherwise, this field will be not set (i.e. null).
     * @DTA\Data(field="photoTanData", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $photo_tan_data;

}
