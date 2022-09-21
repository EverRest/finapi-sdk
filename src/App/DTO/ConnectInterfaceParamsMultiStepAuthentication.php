<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * &lt;strong&gt;Type:&lt;/strong&gt; MultiStepAuthenticationCallback&lt;br/&gt; Container for multi-step authentication data. Required when a previous service call initiated a multi-step authentication.
 */
class ConnectInterfaceParamsMultiStepAuthentication
{
    /**
     * Hash that was returned in the previous multi-step authentication error.
     * @DTA\Data(field="hash")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $hash;

    /**
     * Challenge response. Must be set when the previous multi-step authentication error had status &#39;CHALLENGE_RESPONSE_REQUIRED&#39;.
     * @DTA\Data(field="challengeResponse", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $challenge_response;

    /**
     * The bank-given ID of the two-step-procedure that should be used for authentication. Must be set when the previous multi-step authentication error had status &#39;TWO_STEP_PROCEDURE_REQUIRED&#39;.
     * @DTA\Data(field="twoStepProcedureId", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $two_step_procedure_id;

    /**
     * Must be passed when the previous multi-step authentication error had status &#39;REDIRECT_REQUIRED&#39;. The value must consist of the complete query parameter list that was contained in the received redirect from the bank.
     * @DTA\Data(field="redirectCallback", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $redirect_callback;

    /**
     * Must be passed when the previous multi-step authentication error had status &#39;DECOUPLED_AUTH_REQUIRED&#39; or &#39;DECOUPLED_AUTH_IN_PROGRESS&#39;. The field represents the state of the decoupled authentication meaning that when it&#39;s set to &#39;true&#39;, the end-user has completed the authentication process on bank&#39;s side.&lt;br/&gt;&lt;br/&gt;Please note: Don&#39;t repeat the service call too frequently. Some banks limit the amount of requests per minute. Our suggestion is to repeat the service call for the decoupled approach every 5 seconds.
     * @DTA\Data(field="decoupledCallback", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $decoupled_callback;

}
