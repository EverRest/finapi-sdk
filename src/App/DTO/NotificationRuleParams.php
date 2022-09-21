<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Parameters of notification rule
 */
class NotificationRuleParams
{
    /**
     * Trigger event type
     * @DTA\Data(field="triggerEvent")
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @var string|null
     */
    public $trigger_event;

    /**
     * Additional parameters that are specific to the chosen trigger event type. Please refer to the documentation for details.
     * @DTA\Data(field="params", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\App\DTO\Collection136::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\App\DTO\Collection136::class})
     * @var \App\DTO\Collection136|null
     */
    public $params;

    /**
     * An arbitrary string that finAPI will include into the notifications that it sends based on this rule and that you can use to identify the notification in your application. For instance, you could include the identifier of the user that you create this rule for. Maximum allowed length of the string is 512 characters.&lt;br/&gt;&lt;br/&gt;Note that for this parameter, you can pass the symbols &#39;/&#39;, &#39;&#x3D;&#39;, &#39;%&#39; and &#39;\&quot;&#39; in addition to the symbols that are generally allowed in finAPI (see &lt;a href&#x3D;&#39;https://documentation.finapi.io/access/Allowed-Characters.2764767279.html&#39; target&#x3D;&#39;_blank&#39;&gt;Allowed Characters&lt;/a&gt;). This was done to enable you to set Base64 encoded strings and JSON structures for the callback handle.
     * @DTA\Data(field="callbackHandle", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"string"})
     * @DTA\Validator(name="Regex", options={"pattern":"/[A-Za-z0-9¡-ʯ &\\(\\)\\{\\}\\[\\]\\.:,;\\?!\\+\\-_\\$@#~`\\^€\/=%\"]*/"})
     * @var string|null
     */
    public $callback_handle;

    /**
     * Whether the notification messages that will be sent based on this rule should contain encrypted detailed data or not. Default value is &#39;false&#39;.
     * @DTA\Data(field="includeDetails", nullable=true)
     * @DTA\Validator(name="Scalar", options={"type":"bool"})
     * @var bool|null
     */
    public $include_details;

}
