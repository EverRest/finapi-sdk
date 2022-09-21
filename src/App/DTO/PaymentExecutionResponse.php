<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Bank server&#39;s response to Money Transfer / Direct Debit execution
 */
class PaymentExecutionResponse
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

}
