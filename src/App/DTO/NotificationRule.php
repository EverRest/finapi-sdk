<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Data of notification rule
 */
class NotificationRule
{
    /**
     * Notification rule identifier
     * @DTA\Data(field="id")
     * @DTA\Validator(name="Scalar", options={"type":"int"})
     * @var int|null
     */
    public $id;

    /**
     * Trigger event type
     * @DTA\Data(field="triggerEvent")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $trigger_event;

    /**
     * Additional parameters that are specific to the trigger event type. Please refer to the documentation for details.
     * @DTA\Data(field="params")
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection470::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection470::class})
     * @var \App\DTO\Collection470|null
     */
    public $params;

    /**
     * The string that finAPI includes into the notifications that it sends based on this rule.
     * @DTA\Data(field="callbackHandle")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $callback_handle;

    /**
     * Whether the notification messages that will be sent based on this rule contain encrypted detailed data or not.
     * @DTA\Data(field="includeDetails")
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $include_details;

}
