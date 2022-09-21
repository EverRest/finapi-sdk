<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Container for multi-step authentication data, as returned by finAPI to the client
 */
class MultiStepAuthenticationChallenge
{
    /**
     * Hash for this multi-step authentication flow. Must be passed back to finAPI when continuing the flow.
     * @DTA\Data(field="hash")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $hash;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; MsaStatus&lt;br/&gt; Indicates the current status of the multi-step authentication flow:&lt;br/&gt;&lt;br/&gt;TWO_STEP_PROCEDURE_REQUIRED means that the bank has requested an SCA method selection for the user. In this case, the service should be recalled with a chosen TSP-ID set to the &#39;twoStepProcedureId&#39; field.&lt;br/&gt;&lt;br/&gt;CHALLENGE_RESPONSE_REQUIRED means that the bank has requested a challenge code for the previously given TSP (SCA). This status can be completed by setting the &#39;challengeResponse&#39; field.&lt;br/&gt;&lt;br/&gt;REDIRECT_REQUIRED means that the user must be redirected to the bank&#39;s website, where the authentication can be finished.&lt;br/&gt;&lt;br/&gt;DECOUPLED_AUTH_REQUIRED means that the bank has asked for the decoupled authentication. In this case, the &#39;decoupledCallback&#39; field must be set to true to complete the authentication.&lt;br/&gt;&lt;br/&gt;DECOUPLED_AUTH_IN_PROGRESS means that the bank is waiting for the completion of the decoupled authentication by the user. Until this is done, the service should be recalled at most every 5 seconds with the &#39;decoupledCallback&#39; field set to &#39;true&#39;. Once the decoupled authentication is completed by the user, the service returns a successful response.
     * @DTA\Data(field="status")
     * @DTA\Strategy(name="Object", options={"type":MsaStatus::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":MsaStatus::class})
     * @var MsaStatus|null
     */
    public $status;

    /**
     * In case of status &#x3D; CHALLENGE_RESPONSE_REQUIRED, this field contains a message from the bank containing instructions for the user on how to proceed with the authorization.
     * @DTA\Data(field="challengeMessage")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $challenge_message;

    /**
     * Suggestion from the bank on how you can label your input field where the user should enter his challenge response.
     * @DTA\Data(field="answerFieldLabel")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $answer_field_label;

    /**
     * In case of status &#x3D; REDIRECT_REQUIRED, this field contains the URL to which you must direct the user. It already includes the redirect URL back to your client that you have passed when initiating the service call.
     * @DTA\Data(field="redirectUrl")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $redirect_url;

    /**
     * Set in case of status &#x3D; REDIRECT_REQUIRED. When the bank redirects the user back to your client, the redirect URL will contain this string, which you must process to identify the user context for the callback on your side.
     * @DTA\Data(field="redirectContext")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $redirect_context;

    /**
     * Set in case of status &#x3D; REDIRECT_REQUIRED. This field is set to the name of the query parameter that contains the &#39;redirectContext&#39; in the redirect URL from the bank back to your client.
     * @DTA\Data(field="redirectContextField")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $redirect_context_field;

    /**
     * &lt;strong&gt;Type:&lt;/strong&gt; TwoStepProcedure&lt;br/&gt; In case of status &#x3D; TWO_STEP_PROCEDURE_REQUIRED, this field contains the available two-step procedures. Note that this set does not necessarily match the set that is stored in the respective bank connection interface. You should always use the set from this field for the multi-step authentication flow.
     * @DTA\Data(field="twoStepProcedures")
     * @DTA\Strategy(name="Object", options={"type":::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":::class})
     * @var \App\DTO\TwoStepProcedure[]|null
     */
    public $two_step_procedures;

    /**
     * In case that the &#39;photoTanData&#39; field is set (i.e. not null), this field contains the MIME type to use for interpreting the photo data (e.g.: &#39;image/png&#39;)
     * @DTA\Data(field="photoTanMimeType")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $photo_tan_mime_type;

    /**
     * In case that the bank server has instructed the user to scan a photo (or more generally speaking, any kind of QR-code-like data), then this field will contain the raw data of the photo as a BASE-64 string.
     * @DTA\Data(field="photoTanData")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $photo_tan_data;

    /**
     * In case that the bank server has instructed the user to scan a flicker code, then this field will contain the raw data for the flicker animation as a BASE-64 string.
     * @DTA\Data(field="opticalData")
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

}
